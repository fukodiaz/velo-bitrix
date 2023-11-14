<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Velo Shop");
?>

<div class='contentBox'>
	<ul class='list-velo-pictures'>
		<li class='item-velo-picture item-velo-first'>
			<img src="<?=DEFAULT_TEMPLATE_PATH_IMG?>/images/c1.jpg" alt=""/>
		</li>
		<li class='item-velo-picture item-velo-picture_second'>
			<img src="<?=DEFAULT_TEMPLATE_PATH_IMG?>/images/c2.jpg" alt=""/>
		</li>
		<li class='item-velo-picture item-velo-picture_third'>
			<img src="<?=DEFAULT_TEMPLATE_PATH_IMG?>/images/c3.jpg" alt=""/>
		</li>
	</ul>

	<div class='box-choice'>
		<a class="morebtn btn-choice" href="/catalog/">ВЫБОР</a>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>