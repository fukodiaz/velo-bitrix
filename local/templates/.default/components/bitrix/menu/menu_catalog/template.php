<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="top-nav">
	<div class='inner-block-nav'>
		<label class="mobile_menu" for="mobile_menu">
		<span>Меню</span>
		</label>
		<input id="mobile_menu" type="checkbox">
		<ul class="nav">
			<?
			$previousLevel = 0;
			foreach($arResult as $arItem):?>

				<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
					<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
				<?endif?>

				<?if ($arItem["IS_PARENT"]):?>

					<?if ($arItem["DEPTH_LEVEL"] == 1):?>
						<li class="dropdown1 <?php if ($arItem["SELECTED"]) echo "active";?>">
							<a href="<?=$arItem["LINK"]?>" class="<?php if ($arItem["SELECTED"]) echo "active";?>">
									<?=$arItem["TEXT"]?>
							</a>
							<ul class="dropdown2">
					<?php else:?>
						<li<?php if ($arItem["SELECTED"]) echo 'class="active"';?>
							<a href="<?=$arItem["LINK"]?>" class="parent">
								<?=$arItem["TEXT"]?>
							</a>
						</li>
					<?php endif;?>

				<?else:?>


						<?if ($arItem["DEPTH_LEVEL"] == 1):?>
							<li class="<?php if ($arItem["SELECTED"]) echo "active";?>"><a href="<?=$arItem["LINK"]?>" <?php if ($arItem["SELECTED"]) echo 'class="active"';?>><?=$arItem["TEXT"]?></a></li>
						<?else:?>
							<li <?if ($arItem["SELECTED"]) echo "class='item-selected'";?>>
								<a href="<?=$arItem["LINK"]?>">
									<?=$arItem["TEXT"]?>
								</a>
							</li>
						<?endif?>

					<?endif;?>


				<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

			<?endforeach?>

			<?if ($previousLevel > 1)://close last item tags?>
				<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
			<?endif?>
		</ul>
		<a href='#' class='link-cart'>
			<i class="fa-solid fa-cart-shopping icon-cart"></i>
		</a>
	</div>
</div>
<?endif?>