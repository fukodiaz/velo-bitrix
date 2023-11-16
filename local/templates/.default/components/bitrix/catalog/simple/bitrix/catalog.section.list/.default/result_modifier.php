<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<!-- если не определена picture для раздела, брать из подразделов или товаров -->
<?php
	// debug($arResult['SECTIONS']);
	foreach($arResult['SECTIONS'] as $k => $arSection) {
		if ($arSection['PICTURE']['SRC']) {
			$sectImg = $arSection['PICTURE']['SRC'];
		} else {
			$elWithPicture = CIBlockElement::GetList(
				['ID'=>'ASC'],
				[
					'IBLOCK_ID' => $arSection['IBLOCK_ID'],
					'SECTION_ID' => $arSection['ID'],
					'INCLUDE_SUBSECTIONS' => 'Y',
					'!DETAIL_PICTURE' => false
				],
				false,
				['nTopCount'=>1],
				['DETAIL_PICTURE']
			);

			while ($arPic = $elWithPicture -> Fetch()) {
				$renderImage2 = CFile::ResizeImageGet(
					$arPic['DETAIL_PICTURE'],
					['width' => 300, 'height' => 300],
					BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
					false
				);
				$sectImg = $renderImage2['src'];
			}

			if (empty($sectImg))
				$sectImg = $this -> GetFolder . '/images/line-empty.png';

			$arResult['SECTIONS'][$k]['ALT_PICTURE'] = $sectImg;
		}
	}