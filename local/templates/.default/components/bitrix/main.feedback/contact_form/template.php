<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if($arResult["OK_MESSAGE"] <> '')
{
	?>
	<div class="alert alert-success" role="alert">Данные успешно отправлены!</div>
	<!-- <div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?> -->
	</div><?
}
?>

<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
	<?=bitrix_sessid_post()?>
	<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>"  class='user' placeholder="USERNAME" >
	<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" class='user' placeholder="EXAMPLE@GMAIL.COM">
	<textarea name="MESSAGE" placeholder="MESSAGE" value="<?=$arResult["MESSAGE"]?>"><?=$arResult["MESSAGE"]?></textarea>

	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>" class='btn_submit-feed'>
</form>