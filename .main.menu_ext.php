<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	global $APPLICATION;
	$arMenuLinksExt = $APPLICATION -> IncludeComponent(
		'bitrix:menu.sections',
		'',
		[
			'IS_SEF' => 'Y',
			'SEF_BASE_URL' => '/catalog/',
			'SECTION_PAGE_URL' => '#SECTION_CODE#/',
			'DETAIL_PAGE_URL' => '#SECTION_CODE#/#ELEMENT_CODE#/',
			'IBLOCK_TYPE' => 'catalog',
			'IBLOCK_ID' => '3',
			'DEPTH_LEVEL' => '2',
			'CACHE_TYPE' => 'A',
			"CACHE_TIME" => '3600'
		]
	);

	$aMenuLinks = array_merge(
		[['Главная', '/', [], [], '']],
		$arMenuLinksExt,
		$aMenuLinks
	);
?>