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
	debug($arResult['ITEMS']);
?>


<div class="wrapperCalcul">
	
	<div class='container-products'>
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
								<?if (!empty($arPrices = $arElement['FIELDS']['PRICES'])):?>
									<?foreach($arPrices as $k => $arPrice):?>
										<?if (!empty($price = $arPrice['PRICE'])):?>
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
						</div>

					<div class="clear"></div>
				</div>
			</div>

		<?php endforeach; ?>
		</div>

		<?
			echo $arResult["NAV_STRING"];
		?>
	</div>
</div>
