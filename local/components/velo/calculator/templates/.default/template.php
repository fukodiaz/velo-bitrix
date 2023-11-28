<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
	$this->setFrameMode(true);
	// debug($arResult['ITEMS_COVERING']);
?>


<div class="wrapperCalcul">
	
	<div class='container-products'>
		<div class='boxHeading'>
			<h2>Калькулятор расчета стоимости товара с учетом модификаций</h2>
		</div>
		<h3 class='headingChoice'>1. Выберите необходимую позицию:</h3>
		<div class='inner-box-products'>
			<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
				<?
				$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				?>

				<?php
				if(empty($arElement["PREVIEW_PICTURE"])){
					$arElement["PREVIEW_PICTURE"] = [
						'SRC' => $this->GetFolder().'/images/line-empty2.png',
					];
				}
				?>

				<div class="cart-goods">
					<div class="item-product" id="<?=$this->GetEditAreaId($arElement['ID']);?>">

						<div class="top_box">
							<h3 class="m_1"><?=$arElement["NAME"]?></h3>
							<?php if (!empty($model = $arElement["FIELDS"]['PROPERTIES']['MODEL'])): ?>
							<p class="m_2"><?=$model['VALUE']?></p>
							<?php endif;?>
							<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"
								class='link-img-product'>
								<div class="grid_img">
									<div class="css3">
										<img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement["NAME"]?>" class='img-product'>
									</div>
									<div class="mask1">
										<div class="add-cart">Подробнее</div>
									</div>
								</div>
							</a>
							<div class="price">
								<?php $price = 0;?>
								<?if (!empty($arPrices = $arElement['FIELDS']['PRICES'])):?>
									<?foreach($arPrices as $k => $arPrice):?>
										<?if (!empty(($price = $arPrice['PRICE']))):?>
										<p>
											<?=(int)$price .  ' '?>&#8381
										</p>
										<?else:?>
											<p>
												Цена не указана
											</p>
										<?endif;?>
									<?endforeach;?>
									<?else:?>
										<p>
											Цена не указана
										</p>
								<?endif;?>
							</div>
							<div class='boxChoice'>
								<input class='input_choice-goods visually-hidden' type='radio' name='goods' value='<?=$arElement['ID'];?>' id='goods-<?=$arElement['ID'];?>' data-price="<?=(int)$price;?>">
								<label class='label_choice-goods' for='goods-<?=$arElement['ID'];?>'></label>
							</div>
						</div>

					<div class="clear"></div>
				</div>
			</div>

		<?php endforeach; ?>
		</div>

		<?
			echo $arResult["NAV_STRING"];
		?>


		<h3 class='headingChoice headingChoice_serv'>2. <?=$arParams['TITLE_SERV']?></h3>
		<div class='inner-box-products'>
			<?foreach($arResult["ITEMS_SERV"] as $cell=>$arElement):?>
				<?
				$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				?>

				<?php
				if(empty($arElement["PREVIEW_PICTURE"])){
					$arElement["PREVIEW_PICTURE"] = [
						'SRC' => $this->GetFolder().'/images/line-empty2.png',
					];
				}
				?>
				<?php
				if(empty($arElement["DETAIL_PAGE_URL"]))
					$arElement["DETAIL_PAGE_URL"] = '#'; ?>

				<div class="cart-goods">
					<div class="item-product item-product_tires" id="<?=$this->GetEditAreaId($arElement['ID']);?>">

						<div class="top_box">
							<h3 class="m_1"><?=$arElement["NAME"]?></h3>
							<?php if (!empty($brand = $arElement["FIELDS"]['PROPERTIES']['BRAND'])): ?>
							<p class="m_2"><?=$brand['VALUE']?></p>
							<?php endif;?>
							<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"
								class='link-img-product'>
								<div class="grid_img">
									<div class="css3">
										<img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement["NAME"]?>" class='img-product'>
									</div>
									<!-- <div class="mask1">
										<div class="add-cart">Подробнее</div>
									</div> -->
								</div>
							</a>
							<div class="price">
								<?php $price = 0;?>
								<?if (!empty($arPrices = $arElement['FIELDS']['PRICES'])):?>
									<?foreach($arPrices as $k => $arPrice):?>
										<?if (!empty(($price = $arPrice['PRICE']))):?>
										<p>
											<?=(int)$price .  ' '?>&#8381
										</p>
										<?else:?>
											<p>
												Цена не указана
											</p>
										<?endif;?>
									<?endforeach;?>
									<?else:?>
										<p>
											Цена не указана
										</p>
								<?endif;?>
							</div>
							<div class='boxChoice'>
								<input class='input_choice-goods visually-hidden' type='radio' name='service_tires' value='<?=$arElement['ID'];?>' id='service-<?=$arElement['ID'];?>' data-price="<?=(int)$price;?>">
								<label class='label_choice-goods' for='service-<?=$arElement['ID'];?>'></label>
							</div>
						</div>

					<div class="clear"></div>
				</div>
			</div>

		<?php endforeach; ?>
		</div>

		<!-- protective covering -->
		<h3 class='headingChoice headingChoice_covering'>3. Защитное покрытие:</h3>
		<div class='inner-box-products inner-box-cover'>
			<?foreach($arResult['ITEMS_COVERING'] as $item):?>
				<div class='wrapperCovering'>
					<div class='boxChoice'>
						<input class='input_choice-goods visually-hidden' type='radio' name='covering' value='<?=$item['ID'];?>' id='covering-<?=$item['ID'];?>' data-price="<?=$item['PRICE'];?>">
						<label class='label_choice-goods' for='covering-<?=$item['ID'];?>'></label>
					</div>
					<div class='blockContentCover'>
						<p class='optionCover'>
							<?=$item['OPTION']?>
						</p>
						<p class='priceCover'>
							<?=$item['PRICE']?> &#8381
						</p>
					</div>
				</div>
			<?endforeach;?>
		</div>
	</div>
</div>
