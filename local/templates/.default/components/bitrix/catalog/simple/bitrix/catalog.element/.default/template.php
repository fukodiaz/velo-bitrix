<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
	// debug($arResult);
?>

<script>
	let path = "<?=$arResult['ORIGINAL_PARAMETERS']['SECTION_CODE']?>/";
	console.log(path);
</script>

<script>
	jQuery(document).ready(function($){

		$('#etalage').etalage({
			thumb_image_width: 300,
			thumb_image_height: 'auto',
			source_image_width: 417,
			source_image_height: 'auto', 
			// show_hint: true,
			click_callback: function(image_anchor, instance_id){
				alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
			}
		});

	});
</script>

<div class='box-catalog-element'>
	<div class="inner-box-catalog-element">
		<div class="box-img-cat-el">
			<ul id="etalage">
				<!-- detail picture -->
				<li class='item-et-velo-img'>
					<img class="etalage_thumb_image img-responsive et-velo-img"
							src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"
							alt="<?=$arResult['NAME']?>">
					<img class="etalage_source_image img-responsive et-velo-img"
							src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"
					style='display: none;'>
					<!-- src="/local/templates/pakhi_main/images/d1.jpg" -->
				</li>

				<!-- extra-pictures -->
				<?if (!empty($arResult['MORE_PHOTO'])): ?>
					<? foreach($arResult['MORE_PHOTO'] as $photo): ?>
						<li>
							<img class="etalage_thumb_image img-responsive"
									src="<?=$photo['SRC']?>"
									alt="">
							<img class="etalage_source_image img-responsive"
									src="<?=$photo['SRC']?>"
							>
							<!-- src="/local/templates/pakhi_main/images/d1.jpg" -->
						</li>
					<?endforeach;?>
				<?endif;?>
			</ul>
			<div class="clearfix"></div>
		</div>

		<div class="box-cat-el-props">
			<!-- preloader -->
			<div class="loader">
				<img src="/local/templates/main_velo/images/loader.gif">
			</div>

			<h3 class='el-catal-name'><?=$arResult['NAME']?></h3>

			<div class='box-els-cat-props'>
				<?php foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
					<?php if ($arProperty['NAME'] == 'Наименование') continue; ?>
					<p class='el-catal-props'><b><?=$arProperty["NAME"]?>:</b> <?php
							if(is_array($arProperty["DISPLAY_VALUE"])):
								echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
							elseif($pid=="MANUAL"):
								?><a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a><?
							else:
								echo $arProperty["DISPLAY_VALUE"];?>
							<?php endif?>
					</p>
				<?endforeach?>
			</div>

			<div class="price">
				<?php if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
						<?php $props = []; ?>
						<?foreach($arResult["OFFERS"] as $arOffer):?>
							<?foreach($arOffer["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
								<?
								$props[$pid]['name'] = $arProperty["NAME"];
								$props[$pid]['props'][$arProperty["VALUE"]]['id'] = $arOffer["ID"];
								$props[$pid]['props'][$arProperty["VALUE"]]['value'] = $arProperty["DISPLAY_VALUE"];
								?>
							<?endforeach?>


							<?foreach($arOffer["ITEM_PRICES"] as $code=>$arPrice):?>
								<?
									$props[$pid]['props'][$arProperty['VALUE']]['price'] = $arPrice['PRINT_PRICE'];
								?>
							<?endforeach;?>


						<?endforeach;?>

						<?php foreach($props as $id => $prop): ?>

							<?php
							foreach($prop['props'] as $k => $v){
								$colors[] = $v['value'];
							}

							if (!CModule::IncludeModule('highloadblock')) //ПОДКЛЮЧАЕМ МОДУЛЬ
								continue;
							$ID = 2; //СЮДА ID ВАШЕГО HL ИНФОБЛОКА
							$hldata = Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
							$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
							$hlDataClass = $hldata['NAME'].'Table';

							//СОЗДАЕМ МАССИВ ФИЛЬТРА, В НЕМ УКАЗЫВАЕМ ЛОГИКУ ОТБОРА И (обязательно, иначе будет ИЛИ и отфильтрует только один цвет)
							$arFilter = Array(
								Array(
										"LOGIC"=>"AND",
										Array(
											"UF_NAME"=> $colors //НАШ МАССИВ С ЦВЕТАМИ
										)
								)
							);
							$result = $hlDataClass::getList(array(
								'select' => array('UF_FILE','UF_NAME','UF_DESCRIPTION','UF_XML_ID'), //НАМ НУЖНЫ ТОЛЬКО НАЗВАНИЕ И КАРТИНКА
								//'order' => array('UF_NAME' =>'ASC'),
								'filter' => $arFilter //ПРИМЕНЯМ СОЗДАННЫЙ ВЫШЕ ФИЛЬТР
							));
							while($res = $result->fetch())
							{

								$img_path = CFile::GetPath($res["UF_FILE"]); //ПОЛУЧАЕМ ПУСТЬ К КАРТИНКЕ
								$props['COLOR']['props'][$res["UF_XML_ID"]]['img'] = '<img src="'.$img_path.'"/>';
								if (!empty($res["UF_DESCRIPTION"]))
									$props['COLOR']['props'][$res["UF_XML_ID"]]['code'] = $res["UF_DESCRIPTION"];
							}
							?>
						<?php endforeach; ?>
						<span class="price-value">
							<?php foreach($props['COLOR']['props'] as $color): ?>
								<?= $color['price'] ?> (<?= $color['value'] ?>)
							<?php break; endforeach; ?>
						</span>
						<!--    COLORS    -->
						<p><b><?= $props['COLOR']['name'] ?></b></p>
						<ul class="color-props clearfix">
							<?php $i = 0; foreach($props['COLOR']['props'] as $id => $color): ?>
								<li data-id="<?= $color['id'] ?>" data-value="<?= $color['value'] ?>" data-price="<?= $color['price'] ?>"<?php if(!$i) echo ' class="active-prop"' ?>>
									<div class='innerColor'>
										<?=$color['value']?>
										<?=$color['img']?>
									</div>
								</li>
								<?php if(!$i) $id_offer = $color['id'];?>
								<?php $i++; endforeach; ?>
						</ul>
						<!--    COLORS    -->

						<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" class="add2cart">
							<div class="input-group col-xs-3">
								<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" class="form-control" id="QUANTITY<?= $arElement['ID'] ?>">
								<input type="hidden" name="action" value="ADD2BASKET">
								<input type="hidden" name="ajax_basket" value="Y">
								<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?= $id_offer ?>" class="id-offer">
								<span class="input-group-btn">
							<button name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="btn btn-default" type="submit"><?echo GetMessage("CATALOG_ADD_TO_BASKET")?></button>
						</span>
							</div>
						</form>

				<?php else: ?>
					
						<?foreach($arResult["ITEM_PRICES"] as $code=>$arPrice):?>
							<span class='price_value'>
								<?=$arPrice["PRINT_PRICE"]?>
							</span>
						<?endforeach;?>
						<?/*
						<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
										<s><?=$arPrice["PRINT_VALUE"]?></s> <?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
								<?else:?>
										<?=$arPrice["PRINT_VALUE"]?>
								<?endif;?>
							<?endif;?>
						<?endforeach;?>
						*/?>

						<?if($arResult["CAN_BUY"]):?>
							<div class="buy">
							<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" class="add2cart">
								<div class="input-group col-xs-3">
										<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" class="form-control" id="QUANTITY<?= $arResult['ID'] ?>">
										<input type="hidden" name="action" value="ADD2BASKET">
										<input type="hidden" name="ajax_basket" value="Y">
										<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arResult["ID"]?>">
										<span class="input-group-btn">
							<button name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="btn btn-default" type="submit"><?echo GetMessage("CATALOG_ADD_TO_BASKET")?></button>
						</span>
								</div>
							</form>
						<?elseif((count($arResult["PRICES"]) > 0) || is_array($arResult["PRICE_MATRIX"])):?>
							<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
						<?endif?>
						</div>

				<?php endif; ?>
			</div>

		</div>

	</div>
	<div class="col-md-12 box-el-catal-descrip">
		<div class="single-bottom1">
			<h6>Описание</h6>
			<p><?=$arResult['DETAIL_TEXT'];?></p>
		</div>
	</div>
</div>

<?php /*
<div class="row">
	<div class="col-md-12">
		<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.recommended.products", 
	".default", 
	array(
		"ACTION_VARIABLE" => "action_crp",
		"ADDITIONAL_PICT_PROP_1" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_2" => "",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_TIME" => "86400",
		"CACHE_TYPE" => "A",
		"CART_PROPERTIES_1" => array(
			0 => ",",
		),
		"CART_PROPERTIES_2" => array(
			0 => "",
			1 => "",
		),
		"CODE" => $_REQUEST["PRODUCT_CODE"],
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"ELEMENT_SORT_FIELD" => "SORT",
		"ELEMENT_SORT_FIELD2" => "ID",
		"ELEMENT_SORT_ORDER" => "ASC",
		"ELEMENT_SORT_ORDER2" => "DESC",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "catalog",
		"ID" => $arResult["ID"],
		"LABEL_PROP_1" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_PROPERTY_LINK" => "RECOMMEND",
		"OFFER_TREE_PROPS_2" => "",
		"PAGE_ELEMENT_COUNT" => "30",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_1" => array(
			0 => ",",
		),
		"PROPERTY_CODE_2" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_LINK" => "RELATED",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_1" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
	</div>
</div>
*/?>