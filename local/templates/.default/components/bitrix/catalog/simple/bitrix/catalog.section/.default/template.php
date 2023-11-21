<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="row box-catalog-section">
    <div class='container-smart-filter'>
        <?php $APPLICATION->ShowViewContent('aside_filter'); ?>
    </div>
    <div class='container-products'>
		<div class='inner-box-products'>
		  <?php /*
            <div class="col-md-12">
                <div class="mens-toolbar">
                    <div class="sort">
                        <div class="sort-by">
									<div class="sort">
										<p>Сортировать по:</p>
										<a href="<?=$APPLICATION->GetCurPageParam('sort=price&order=desc', ['sort', 'order'])?>">lt</a>
										<span> | </span>
										<a href="<?=$APPLICATION->GetCurPageParam('sort=price&order=asc', ['sort', 'order'])?>">gt</a>
									</div>
                            <!-- <label>Sort By</label>
                            <select>
                                <option value="">
                                    Popularity               </option>
                                <option value="">
                                    Price : High to Low               </option>
                                <option value="">
                                    Price : Low to High               </option>
                            </select>
                            <a href=""><img src="images/arrow2.gif" alt="" class="v-middle"></a> -->
                        </div>
                    </div>
                    <div class="pager">
								Выводить по:
								<a href="<?=$APPLICATION->GetCurPageParam('pagelimit=1', ['pagelimit'])?>">1</a>
								<a href="<?=$APPLICATION->GetCurPageParam('pagelimit=2', ['pagelimit'])?>">2</a>
								<a href="<?=$APPLICATION->GetCurPageParam('pagelimit=3', ['pagelimit'])?>">3</a>
                        <!-- <div class="limiter visible-desktop">
                            <label>Show</label>
                            <select>
                                <option value="" selected="selected">
                                    9                </option>
                                <option value="">
                                    15                </option>
                                <option value="">
                                    30                </option>
                            </select> per page
                        </div> -->
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
			*/?>

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
					 			<!-- preloader -->
								<div class="loader">
									<img src="/local/templates/main_velo/images/loader.gif">
								</div>

                        <!-- <div class="view1 view-fifth1"> -->
                            <div class="top_box">
                                <h3 class="m_1"><?=$arElement["NAME"]?></h3>
										  <?php if (!empty($model = $arElement["DISPLAY_PROPERTIES"]['MODEL'])): ?>
                                	<p class="m_2"><?=$model['DISPLAY_VALUE']?></p>
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
                                    <?php if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
													<?php $props = []; ?>
                                            <?foreach($arElement["OFFERS"] as $arOffer):?>

                                                <?foreach($arOffer["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
<?/*
																	<?=$arProperty["NAME"] ?>
*/?>

<?php
	// $props['ll'] = 'hh';
	$props[$pid]['name'] = $arProperty["NAME"];
	$props[$pid]['props'][$arProperty['VALUE']]['id'] = $arOffer['ID'];
	$props[$pid]['props'][$arProperty['VALUE']]['value'] = $arProperty['DISPLAY_VALUE'];
?>
																	 
																	 <?/*
																	 <?=$arProperty["NAME"]?>
																	 : <?
                                                    if(is_array($arProperty["DISPLAY_VALUE"]))
                                                        echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
                                                    else
                                                        echo $arProperty["DISPLAY_VALUE"];?>
																	*/?>
                                                <?endforeach?>

                                                <?foreach($arOffer["ITEM_PRICES"] as $code=>$arPrice):?>
                                                    <?
																	//  if($arPrice["CAN_ACCESS"]):
																	 ?>

<?php
	// $props[$pid]['props'][$arProperty['VALUE']]['price'] = $arPrice['PRINT_DISCOUNT_VALUE'];
	$props[$pid]['props'][$arProperty['VALUE']]['price'] = $arPrice['PRINT_PRICE'];
?>

																		<?/*
                                                        <?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
                                                            <s><?=$arPrice["PRINT_VALUE"]?></s> <?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
                                                        <?else:?>
                                                            <?=$arPrice["PRINT_VALUE"]?>
                                                        <?endif?>
																		*/?>
                                                    <?
																	// endif;
																	 ?>
                                                <?endforeach;?>
<?/*
                                                <?if($arOffer["CAN_BUY"]):?>
<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" class="add2cart">
    <div class="input-group">
<span class="input-group-btn">
<a class="btn btn-default" onclick="if (BX('QUANTITY<?= $arOffer["ID"] ?>').value &gt; 1) BX('QUANTITY<?= $arOffer["ID"] ?>').value--;">-</a>
</span>
        <input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" class="form-control" id="QUANTITY<?= $arOffer["ID"] ?>">
        <span class="input-group-btn input-group-btn2">
<a class="btn btn-default" onclick="BX('QUANTITY<?= $arOffer["ID"] ?>').value++;">+</a>
</span>

        <input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="ADD2BASKET">
        <input type="hidden" name="ajax_basket" value="Y">
        <input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
        <span class="input-group-btn">
<button name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="btn btn-default" type="submit"><?echo GetMessage("CATALOG_ADD")?></button>
</span>
    </div>
</form>
                                                <?elseif(count($arResult["PRICES"]) > 0):?>
                                                    <?=GetMessage("CATALOG_NOT_AVAILABLE")?>
                                                <?endif?>
*/?>

                                            <?endforeach;?>
                                      

<!-- получаем доп. данные из справочника цветов -->
<?php foreach($props as $id => $prop): ?>

<?php
foreach($prop['props'] as $k => $v){
	 $colors[] = $v['value'];
}

if (!CModule::IncludeModule('highloadblock')) //ПОДКЛЮЧАЕМ МОДУЛЬ
	 continue;
$ID = 2; //СЮДА ID ВАШЕГО HL ИНФОБЛОКА (ColorReference)
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
<!-- получаем доп. данные из справочника цветов -->

<span  class="price-value">
	<?php foreach($props['COLOR']['props'] as $color): ?>
		<?=$color['price']?> (<?=$color['value']?>)
	<?php break; endforeach; ?>
</span>

<!-- COLOR -->
<p><b><?=$props["COLOR"]['name'];?></b></p>
<ul class="color-props clearfix">
	<?php $i=0; foreach($props['COLOR']['props'] as $idColor => $color):?>
		<li data-id='<?=$color['id']?>' data-value='<?=$color['value']?>' data-price='<?=$color['price']?>' <? if (!$i) echo "class='active-prop'";?>>
			<div class='innerColor'>
				<?=$color['value']?>
				<?=$color['img']?>
			</div>
		</li>
		<!-- запомнить id предложения, стоящего по дефолту, для передачи в корзину -->
		<? if (!$i) $id_offer = $color['id']; ?>
	<?php $i++; endforeach; ?>
</ul>
<!-- COLOR -->


<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" class="add2cart">
    <div class="input-group">
<span class="input-group-btn">
<a class="btn btn-default" onclick="if (BX('QUANTITY<?= $arOffer["ID"] ?>').value &gt; 1) BX('QUANTITY<?= $arOffer["ID"] ?>').value--;">-</a>
</span>
        <input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" class="form-control" id="QUANTITY<?= $arOffer["ID"] ?>">
        <span class="input-group-btn input-group-btn2">
<a class="btn btn-default" onclick="BX('QUANTITY<?= $arOffer["ID"] ?>').value++;">+</a>
</span>

        <input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="ADD2BASKET">
        <input type="hidden" name="ajax_basket" value="Y">
        <input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?=$id_offer?>" class="id-offer">
        <span class="input-group-btn">
<button name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="btn btn-default" type="submit"><?echo GetMessage("CATALOG_ADD")?></button>
</span>
    </div>
</form>


                                    <?php else:?>
													
													<?foreach($arElement["ITEM_PRICES"] as $code=>$arPrice):?>
														<?=$arPrice["PRINT_PRICE"]?>
													<?endforeach;?>
													<?/*
                                        <?foreach($arElement["PRICES"] as $code=>$arPrice):?>
                                            <?if($arPrice["CAN_ACCESS"]):?>
                                                <?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
                                                    <s><?=$arPrice["PRINT_VALUE"]?></s> <?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
                                                <?else:?>
                                                    <?=$arPrice["PRINT_VALUE"]?>
                                                <?endif;?>
                                            <?endif;?>
                                        <?endforeach;?>
													 */?>

                                        <?if($arElement["CAN_BUY"]):?>
                                            <div class="buy">
<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" class="add2cart">
    <div class="input-group">
<span class="input-group-btn">
<a class="btn btn-default" onclick="if (BX('QUANTITY<?= $arElement['ID'] ?>').value &gt; 1) BX('QUANTITY<?= $arElement['ID'] ?>').value--;">-</a>
</span>
        <input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" class="form-control" id="QUANTITY<?= $arElement['ID'] ?>">
        <span class="input-group-btn input-group-btn2">
<a class="btn btn-default" onclick="BX('QUANTITY<?= $arElement['ID'] ?>').value++;">+</a>
</span>

        <input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="ADD2BASKET">
        <input type="hidden" name="ajax_basket" value="Y">
        <input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arElement["ID"]?>">
        <span class="input-group-btn">
<button name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="btn btn-default" type="submit"><?echo GetMessage("CATALOG_ADD")?></button>
</span>
    </div>
</form>
                                        <?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
                                            <?=GetMessage("CATALOG_NOT_AVAILABLE")?>
                                        <?endif?>
                                        </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                        <!-- </div> -->

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