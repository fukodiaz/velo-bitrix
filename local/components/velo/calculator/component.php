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

if(empty($arParams["TOP_SECTION_CODE"]))
	$arParams["TOP_SECTION_CODE"] = [];


// $arParams["NEWS_COUNT"] = intval($arParams["NEWS_COUNT"]);
// if($arParams["NEWS_COUNT"]<=0)
// 	$arParams["NEWS_COUNT"] = 20;

// $arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);

var_dump($arParams["TOP_SECTION_CODE"]);

if($this->startResultCache(false, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))
{
	if(!Loader::includeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	//getting elements from chosen iblocks
	$arSelect = array_merge($arParams["FIELD_CODE"], [
		"ID",
		"IBLOCK_ID",
		"ACTIVE_FROM",
		"DETAIL_PAGE_URL",
		"NAME",
		"PRICE_TYPE"
	]);
	$arFilter = [
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"=> $arParams["IBLOCKS"],
		// "ACTIVE" => "Y",
		'SECTION_ID' => $arParams["TOP_SECTION_CODE"],
		'INCLUDE_SUBSECTIONS' => 'Y',
		// "ACTIVE_DATE" => "Y",
		// "CHECK_PERMISSIONS" => "Y",
	];

	$arResult=['ITEMS' => []];
		
	$rsItems = CIBlockElement::GetList(
		[], 
		$arFilter, 
		false, 
		false,// ["nTopCount"=>$arParams["NEWS_COUNT"]], 
		$arSelect);
	// $rsItems->SetUrlTemplates($arParams["DETAIL_URL"]);
	while($arItem = $rsItems->GetNext())
	{
		$arButtons = CIBlock::GetPanelButtons(//button for edit/delete element of iblock
			$arItem["IBLOCK_ID"],
			$arItem["ID"],
			0,
			["SECTION_BUTTONS"=>false, "SESSID"=>false]
		);
		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"] ?? '';
		$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"] ?? '';


		Iblock\InheritedProperty\ElementValues::queue($arItem["IBLOCK_ID"], $arItem["ID"]);

		$arResult["ITEMS"][]=$arItem;
		$arResult["LAST_ITEM_IBLOCK_ID"]=$arItem["IBLOCK_ID"];
	}

	foreach ($arResult["ITEMS"] as &$arItem)
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

	$this->setResultCacheKeys(["LAST_ITEM_IBLOCK_ID",]);
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
