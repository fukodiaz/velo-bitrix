<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Калькулятор",
	"DESCRIPTION" => "Калькулятор расчета стоимости модифицированного велосипеда",
	"ICON" => "/images/news_line.gif",
	"SORT" => 10,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "news",
			"NAME" => "Собственные компоненты",
			"SORT" => 10,
		)
	),
);

?>