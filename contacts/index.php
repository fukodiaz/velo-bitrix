<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><div class="contact">
	<div class="container">
		<h3>Контакты</h3>
		 <?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"contact_form",
	Array(
		"EMAIL_TO" => "fukodiazz@gmail.com",
		"EVENT_MESSAGE_ID" => array(),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array("NAME","EMAIL"),
		"USE_CAPTCHA" => "N"
	)
);?> <!-- <form>
			 <input type="text" placeholder="NAME" required="">
			 <input type="text" placeholder="SURNAME" required="">			 
			 <input class="user" type="text" placeholder="USER@DOMAIN.COM" required=""><br>
			 <textarea placeholder="MESSAGE"></textarea>
			 <input type="submit" value="SEND">
		</form> -->
	</div>
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>