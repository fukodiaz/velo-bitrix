<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}
/** @var array $arCurrentValues */

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock'))
{
	return;
}

function getParamsIBlockType($defaultVal, $mess) {
	$arTypesEx = CIBlockParameters::GetIBlockTypes();
	return [	
		"PARENT" => "BASE",
		"NAME" => GetMessage($mess),
		"TYPE" => "LIST",
		"VALUES" => $arTypesEx,
		"DEFAULT" => $defaultVal,
		"REFRESH" => "Y",
	];
};

//to define ID IBlock
global $arIBlocks;
$arIBlocks = [];
$iblockFilter = [
	'ACTIVE' => 'Y',
];
if (!empty($arCurrentValues['IBLOCK_TYPE']))
{
	$iblockFilter['TYPE'] = $arCurrentValues['IBLOCK_TYPE'];
}

$db_iblock = CIBlock::GetList(["SORT"=>"ASC"], $iblockFilter);
while($arRes = $db_iblock->Fetch())
{
	$arIBlocks[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];
}

function getParamsIBlocks($mess) {
	global $arIBlocks;
	return [
		"PARENT" => "BASE",
		"NAME" => GetMessage($mess),
		"TYPE" => "LIST",
		"VALUES" => $arIBlocks,
		"DEFAULT" => '',
		// "MULTIPLE" => "Y",
		"REFRESH" => "Y"
	];
};

//to chose section
function gettingArSection($iblock_id) {
	$arSection = [];
	$ibSectionsFilter = ['ACTIVE' => 'Y'];
	if (!empty($iblock_id)) {
		$ibSectionsFilter['IBLOCK_ID'] = $iblock_id;
	}

	$db_sections = CIBlockSection::GetList(
		['SORT'=>'DESC'],
		$ibSectionsFilter,
		false,
		['ID', 'NAME']	
	);
	while($section = $db_sections->GetNext()) {
		$arSection[$section['ID']] = '[' . $section['ID'] . '] ' . $section['NAME'];
	}
	
	return $arSection;
}

function getSectionCode($vals, $mess) {
	return [
		"PARENT" => "BASE",
		"NAME" => GetMessage($mess),
		"TYPE" => "LIST",
		"VALUES" => $vals,//gettingArSection($arCurrentValues['IBLOCKS'])
		"DEFAULT" => '',
		"REFRESH" => "Y"
	];
};

//getting array codes of fields
function getFieldCodes($mess) {
	return CIBlockParameters::GetFieldCode(GetMessage($mess), "DATA_SOURCE");
};

$arComponentParameters = [
	"GROUPS" => [],
	"PARAMETERS" => [
		"IBLOCK_TYPE" => getParamsIBlockType("catalog", "TYPE_IBLOCKS"),
		"IBLOCKS" => getParamsIBlocks('IBLOCK_ID'),
		"SECTION_CODE" => getSectionCode(gettingArSection($arCurrentValues['IBLOCKS']), 'SECTIONS_NAME'),
		"FIELD_CODE" => getFieldCodes("FIELD_CODE"),
		"PAGEN_PAGES" => [
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("PAGEN_QUALITY_ELS"),
			"TYPE" => "STRING",
			"DEFAULT" => "3",
			"REFRESH" => "Y"
		],

		//params for services
		// "IBLOCK_TYPE_SERV" => getParamsIBlockType("catalog", "TYPE_IBLOCKS_SERV"),
		"IBLOCKS_SERV" => getParamsIBlocks('IBLOCK_ID_SERV'),
		"SECTION_CODE_SERV" => getSectionCode(gettingArSection($arCurrentValues['IBLOCKS_SERV']), 'SECTION_CODE_SERV'),
		"FIELD_CODE_SERV" => getFieldCodes('FIELD_CODE_SERV'),
		"TITLE_SERV" => [
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("TITLE_SERV"),
			"TYPE" => "STRING",
			"DEFAULT" => "Предпочтительный вариант:"
		],
	],
];
