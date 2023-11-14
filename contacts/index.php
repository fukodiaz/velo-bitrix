<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>

<div class="contact">
	<div class="container">
		<h3>Контакты</h3>

		<?$APPLICATION->IncludeComponent("bitrix:main.feedback", "contact_form", Array(
	"EMAIL_TO" => "fukodiaz@gmail.com",	// E-mail, на который будет отправлено письмо
		"EVENT_MESSAGE_ID" => "",	// Почтовые шаблоны для отправки письма
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",	// Сообщение, выводимое пользователю после отправки
		"REQUIRED_FIELDS" => "",	// Обязательные поля для заполнения
		"USE_CAPTCHA" => "N",	// Использовать защиту от автоматических сообщений (CAPTCHA) для неавторизованных пользователей
	),
	false
);?>
		<!-- <form>
			 <input type="text" placeholder="NAME" required="">
			 <input type="text" placeholder="SURNAME" required="">			 
			 <input class="user" type="text" placeholder="USER@DOMAIN.COM" required=""><br>
			 <textarea placeholder="MESSAGE"></textarea>
			 <input type="submit" value="SEND">
		</form> -->
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>