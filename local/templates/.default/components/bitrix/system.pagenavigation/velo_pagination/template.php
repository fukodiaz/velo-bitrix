<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

\Bitrix\Main\UI\Extension::load(['ui.design-tokens']);

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
// debug($arResult);
?>

<?
$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<?php if ($arResult['NavPageCount'] > 1): ?>
	<nav>
		<ul class="pagination">
			<!-- Prev -->
			<?php if ($arResult['NavPageNomer'] > 1): ?>
				<?php if ($arResult['NavPageNomer'] >= 2): ?>
					<li>
						<a href="<?=$arResult['sUrlPath']?>?<?=$strNavQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=($arResult['NavPageNomer']-1)?>" aria-label="Previous">
							<span aria-hidden="true"><?=GetMessage("nav_prev")?></span>
						</a>
					</li>
					<?php else: ?>
					<li>
						<a href="<?=$arResult['sUrlPath']?><?=$strNavQueryStringFull?>" aria-label="Previous">
							<span aria-hidden="true"><?=GetMessage("nav_prev")?></span>
						</a>
					</li>
				<?php endif; ?>
			<?php endif; ?>

			<!-- Nums -->
			<?php while($arResult['nStartPage'] <= $arResult['nEndPage']): ?>
				<?php if ($arResult['nStartPage'] == $arResult['NavPageNomer']): ?>
					<!-- current page -->
					<li class='active'><a><?=$arResult['nStartPage']?></a></li>
					<!-- first page -->
				<?php elseif ($arResult['nStartPage']==1 && $arResult['bSavePage']==false): ?>
					<li>
						<a href="<?=$arResult['sUrlPath']?><?=$strNavQueryStringFull?>">
							<?=$arResult['nStartPage']?>
						</a>
					</li>
					<?php else: ?>
						<li>
							<a href="<?=$arResult['sUrlPath']?>?<?=$strNavQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=$arResult['nStartPage']?>">
								<?=$arResult['nStartPage']?>
							</a>
						</li>
					<?php endif; ?>
					<?php $arResult['nStartPage']++?>
			<?php endwhile; ?>

			<!-- Next -->
			<?php if ($arResult['NavPageNomer'] < $arResult['NavPageCount']): ?>
				<li>
					<a href="<?=$arResult['sUrlPath']?>?<?=$strNavQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=($arResult["NavPageNomer"]+1)?>" aria-label="Next">
						<span aria-hidden="true"><?=GetMessage("nav_next")?></span>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</nav>
<?php endif; ?>