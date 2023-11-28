<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
	Bitrix\Main,
	Bitrix\Iblock;

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 300;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if($arParams["IBLOCK_TYPE"] == '')
	$arParams["IBLOCK_TYPE"] = "catalog";
if($arParams["IBLOCK_TYPE"]=="-")
	$arParams["IBLOCK_TYPE"] = "";

//params for goods
if(!is_array($arParams["IBLOCKS"]))
	$arParams["IBLOCKS"] = [$arParams["IBLOCKS"]];
foreach($arParams["IBLOCKS"] as $k=>$v)
	if(!$v)
		unset($arParams["IBLOCKS"][$k]);

if(!is_array($arParams["FIELD_CODE"]))
	$arParams["FIELD_CODE"] = [];
foreach($arParams["FIELD_CODE"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE"][$key]);

if(empty($arParams["SECTION_CODE"]))
	$arParams["SECTION_CODE"] = [];

//params for services
if(!is_array($arParams["IBLOCKS_SERV"]))
	$arParams["IBLOCKS_SERV"] = [$arParams["IBLOCKS_SERV"]];
foreach($arParams["IBLOCKS_SERV"] as $k=>$v)
	if(!$v)
		unset($arParams["IBLOCKS_SERV"][$k]);

if(!is_array($arParams["FIELD_CODE_SERV"]))
	$arParams["FIELD_CODE_SERV"] = [];
foreach($arParams["FIELD_CODE_SERV"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE_SERV"][$key]);

if(empty($arParams["SECTION_CODE_SERV"]))
	$arParams["SECTION_CODE_SERV"] = [];

if(empty($arParams["TITLE_SERV"]))
	$arParams["TITLE_SERV"] = '';


$arNavigation = CDBResult::GetNavParams($arParams['PAGEN_PAGES']);

if($this->startResultCache(false, [$arNavigation], ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()))) {
	if(!Loader::includeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	//getting elements from chosen iblocks
	$arSelect = array_merge($arParams["FIELD_CODE"], [
		"ID", "IBLOCK_ID", "ACTIVE_FROM", "DETAIL_PAGE_URL", "NAME", // "CATALOG_GROUP_1", // "PROPERTY_9",
	]);
	$arFilter = [
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"=> $arParams["IBLOCKS"],
		"ACTIVE" => "Y",
		'SECTION_ID' => $arParams["SECTION_CODE"],
		'INCLUDE_SUBSECTIONS' => 'Y', // "ACTIVE_DATE" => "Y", // "CHECK_PERMISSIONS" => "Y",
	];
	$arNavParams = [
		'nPageSize' => $arParams['PAGEN_PAGES'],
		'checkOutOfRange' => true,
		'bShowAll' => false
	];

	$arResult=['ITEMS' => []];
	$base_price = 1; //type of price of goods

	$arResult['ITEMS'] = fillArItems(
		$arFilter,
		$arNavParams,
		$arSelect,
		true,
		$base_price
	);

	//services
	$arServSelect = array_merge($arParams["FIELD_CODE_SERV"], [
		"ID", "IBLOCK_ID", "ACTIVE_FROM", "NAME",
	]);
	$arServFilter = [
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"=> $arParams["IBLOCKS_SERV"],
		"ACTIVE" => "Y",
		'SECTION_ID' => $arParams["SECTION_CODE_SERV"],
		'INCLUDE_SUBSECTIONS' => 'Y',
	];

	$arResult['ITEMS_SERV'] = [];
	$base_serv_price = 1; //type of price of service
		
	$arResult['ITEMS_SERV'] = fillArItems(
		$arServFilter,
		false,
		$arServSelect,
		false,
		$base_serv_price
	);

	//service_covering
	$dataServCover = [
		[
			'ID' => 1,
			'OPTION' => 'С защитным покрытием',
			'PRICE' => 2100
		],
		[
			'ID' => 2,
			'OPTION' => 'Без покрытия',
			'PRICE' => 0
		]
	];
	$arResult['ITEMS_COVERING'] = $dataServCover;

	$this->setResultCacheKeys(["LAST_ITEM_IBLOCK_ID", 'LAST_ITEM_SERV_IBLOCK_ID']);
	$this->includeComponentTemplate();
}

if(
	$arResult["LAST_ITEM_IBLOCK_ID"] > 0
	&& $USER->IsAuthorized()
	&& $APPLICATION->GetShowIncludeAreas()
	&& CModule::IncludeModule("iblock")
)
{
	$arButtons = CIBlock::GetPanelButtons(
		$arResult["LAST_ITEM_IBLOCK_ID"], 
			0, 
			0, 
			["SECTION_BUTTONS"=>false]);
	$this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
}


function setFieldsToArItem($arItemId, $base_price) {
		$ar_fields = [];
		if ($obRes = CIBlockElement::GetByID($arItemId) -> GetNextElement()) {
			$ar_fields = $obRes -> GetFields();
			//properties of element iblock
			$ar_props = $obRes -> GetProperties([], ['ACTIVE'=>'Y', 'EMPTY'=>'N']);
			//getting prices
			$prices = CPrice::GetList(
				[],
				[
					'PRODUCT_ID'=>$ar_fields['ID'],
					'CATALOG_GROUP_ID' => [$base_price]
				]
			);

			//adding price in array of fields
			while($price = $prices->Fetch()) {
				$ar_fields['PRICES'][$price['CATALOG_GROUP_ID']] = $price;
			}
			$ar_fields['PROPERTIES'] = $ar_props;
		}

		return $ar_fields;
}

function fillArItems($arFilter, $arNavParams, $arSelect, $isNav, $base_price) {
	
	$rsItems = CIBlockElement::GetList(
		["SORT"=>"ASC"], 
		$arFilter, 
		false, 
		$arNavParams, 
		$arSelect);

	if ($isNav)
		$arResult['NAV_STRING'] = $rsItems -> GetPageNavString(GetMessage('PAGEN_TITLE'), 'velo_pagination');
	while($arItem = $rsItems->GetNext())
	{
		//button for edit/delete element of iblock
		$arButtons = CIBlock::GetPanelButtons(
			$arItem["IBLOCK_ID"], $arItem["ID"], 0, ["SECTION_BUTTONS"=>false, "SESSID"=>false]);
		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"] ?? '';
		$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"] ?? '';

		//populate fields of item
		$arItem['FIELDS'] = setFieldsToArItem($arItem['ID'], $base_price);

		Iblock\InheritedProperty\ElementValues::queue($arItem["IBLOCK_ID"], $arItem["ID"]);

		$arResult['ITEMS'][]=$arItem;
		$arResult['LAST_ITEM_IBLOCK_ID']=$arItem["IBLOCK_ID"];
	}

	foreach ($arResult['ITEMS'] as &$arItem)
	{
		$ipropValues = new Iblock\InheritedProperty\ElementValues($arItem["IBLOCK_ID"], $arItem["ID"]);
		$arItem["IPROPERTY_VALUES"] = $ipropValues->getValues();
		Iblock\Component\Tools::getFieldImageData(
			$arItem,
			array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
			Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
			'IPROPERTY_VALUES'
		);
	}
	unset($arItem);

	return $arResult['ITEMS'];
}