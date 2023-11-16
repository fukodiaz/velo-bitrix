<?php 
	if ($arParams['ADD_SECTIONS_CHAIN'] && !empty($arResult['NAME'])) {
		$arResult['SECTION']['PATH'][] = [
			'NAME' => $arResult['NAME'],
			'PATH' => ''
		];
	} 