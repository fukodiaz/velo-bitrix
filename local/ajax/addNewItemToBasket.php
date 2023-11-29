<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
Loader::includeModule("sale");
// basket of current user
$fUserID = CSaleBasket::GetBasketUserID(True);
$fUserID = IntVal($fUserID);

//params for adding new item
$randomId = rand(1000000000, 11000000000);
$arFields = [
	'PRODUCT_ID' => $randomId,
	"PRODUCT_PRICE_ID" => '1',
	'PRICE' => $_POST['price'],
	'CURRENCY' => 'RUB',
	'QUANTITY' => 1,
	'NAME' => $_POST['name'],
	'LID' => 's1',
	'CUSTOM_PRICE' => 'Y',
	"CALLBACK_FUNC"  => "Y",
	"ORDER_CALLBACK_FUNC" => "",
	"MODULE" => '',
	"NOTES" => "",
	"DELAY" => "N",
	'DETAIL_PAGE_URL' => $_POST['pdu'],
	'FUSER_ID' => $fUserID,
];

$arProps = [];
$arProps[] = [
	"NAME" => "PREVIEW_PICTURE_SRC",
	"CODE" => 'PREVIEW_PICTURE_SRC',
	"VALUE" => $_POST['img']
];
$arFields["PROPS"] = $arProps;

CSaleBasket::Add($arFields);
exit();