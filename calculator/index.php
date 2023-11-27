<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Калькулятор");
?><?$APPLICATION->IncludeComponent(
	"velo:calculator", 
	".default", 
	array(
		"IBLOCKS" => "3",
		"IBLOCK_TYPE" => "catalog",
		"COMPONENT_TEMPLATE" => ".default",
		"TOP_SECTION_CODE" => "6",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DETAIL_TEXT",
			5 => "DETAIL_PICTURE",
			6 => "IBLOCK_TYPE_ID",
			7 => "IBLOCK_ID",
			8 => "",
		),
		"PAGEN_PAGES" => "2",
		"SECTION_CODE" => "6",
		"IBLOCKS_SERV" => "4",
		"SECTION_CODE_SERV" => "13",
		"FIELD_CODE_SERV" => array(
			0 => "",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DETAIL_TEXT",
			5 => "DETAIL_PICTURE",
			6 => "IBLOCK_TYPE_ID",
			7 => "IBLOCK_ID",
			8 => "",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>