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

// $iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arTypesEx = CIBlockParameters::GetIBlockTypes();

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

//for to chose top section
$arSection = [];
$ibSectionsFilter = ['ACTIVE' => 'Y'];
if (!empty($arCurrentValues['IBLOCKS'])) {
	$ibSectionsFilter['IBLOCK_ID'] = $arCurrentValues['IBLOCKS'];
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

// $arSorts = [
// 	"ASC" => GetMessage("T_IBLOCK_DESC_ASC"),
// 	"DESC" => GetMessage("T_IBLOCK_DESC_DESC"),
// ];

// $arSortFields = [
// 	"ID" => GetMessage("T_IBLOCK_DESC_FID"),
// 	"NAME" => GetMessage("T_IBLOCK_DESC_FNAME"),
// 	"ACTIVE_FROM" => GetMessage("T_IBLOCK_DESC_FACT"),
// 	"SORT" => GetMessage("T_IBLOCK_DESC_FSORT"),
// 	"TIMESTAMP_X" => GetMessage("T_IBLOCK_DESC_FTSAMP"),
// ];

$arComponentParameters = [
	"GROUPS" => [],
	"PARAMETERS" => [
		"IBLOCK_TYPE" => [	
			"PARENT" => "BASE",
			"NAME" => GetMessage("TYPE_IBLOCKS"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "catalog",
			"REFRESH" => "Y",
		],
		"IBLOCKS" => [
			"PARENT" => "BASE",
			"NAME" => GetMessage('IBLOCK_ID'),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '',
			// "MULTIPLE" => "Y",
			"REFRESH" => "Y"
		],
		"TOP_SECTION_CODE" => [
			"PARENT" => "BASE",
			"NAME" => GetMessage('TOP_SECTIONS_NAME'),
			"TYPE" => "LIST",
			"VALUES" => $arSection,
			"DEFAULT" => '',
			"REFRESH" => "Y"
		],
		"FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("CP_BNL_FIELD_CODE"), "DATA_SOURCE"),

		"PAGEN_PAGES" => [
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("PAGEN_QUALITY_ELS"),
			"TYPE" => "STRING",
			"DEFAULT" => "3",
			"REFRESH" => "Y"
		],

		
		// "NEWS_COUNT" => [
		// 	"PARENT" => "BASE",
		// 	"NAME" => GetMessage("T_IBLOCK_DESC_LIST_CONT"),
		// 	"TYPE" => "STRING",
		// 	"DEFAULT" => "20",
		// ],
		// "FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("CP_BNL_FIELD_CODE"), "DATA_SOURCE"),
		// "SORT_BY1" => [
		// 	"PARENT" => "DATA_SOURCE",
		// 	"NAME" => GetMessage("T_IBLOCK_DESC_IBORD1"),
		// 	"TYPE" => "LIST",
		// 	"DEFAULT" => "ACTIVE_FROM",
		// 	"VALUES" => $arSortFields,
		// 	"ADDITIONAL_VALUES" => "Y",
		// ],
		// "SORT_ORDER1" => [
		// 	"PARENT" => "DATA_SOURCE",
		// 	"NAME" => GetMessage("T_IBLOCK_DESC_IBBY1"),
		// 	"TYPE" => "LIST",
		// 	"DEFAULT" => "DESC",
		// 	"VALUES" => $arSorts,
		// 	"ADDITIONAL_VALUES" => "Y",
		// ],
		// "SORT_BY2" => [
		// 	"PARENT" => "DATA_SOURCE",
		// 	"NAME" => GetMessage("T_IBLOCK_DESC_IBORD2"),
		// 	"TYPE" => "LIST",
		// 	"DEFAULT" => "SORT",
		// 	"VALUES" => $arSortFields,
		// 	"ADDITIONAL_VALUES" => "Y",
		// ],
		// "SORT_ORDER2" => [
		// 	"PARENT" => "DATA_SOURCE",
		// 	"NAME" => GetMessage("T_IBLOCK_DESC_IBBY2"),
		// 	"TYPE" => "LIST",
		// 	"DEFAULT" => "ASC",
		// 	"VALUES" => $arSorts,
		// 	"ADDITIONAL_VALUES" => "Y",
		// ],
		// "DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
		// 	"DETAIL",
		// 	"DETAIL_URL",
		// 	GetMessage("IBLOCK_DETAIL_URL"),
		// 	"",
		// 	"URL_TEMPLATES"
		// ),
		// "ACTIVE_DATE_FORMAT" => CIBlockParameters::GetDateFormat(GetMessage("T_IBLOCK_DESC_ACTIVE_DATE_FORMAT"), "ADDITIONAL_SETTINGS"),
		// "CACHE_TIME" => ["DEFAULT"=>300],
		// "CACHE_GROUPS" => [
		// 	"PARENT" => "CACHE_SETTINGS",
		// 	"NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "Y",
		// ],
	],
];
