<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<!DOCTYPE html>
<html>
<head>
	<?php 
		use Bitrix\Main\Page\Asset;
		$APPLICATION -> ShowHead();
	?>

	<title>
		<?php $APPLICATION -> ShowTitle(); ?>

		<?php
			Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . "/css/bootstrap.css");
			Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . "/css/style.css");
			Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . "/css/nav.css");

			Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/jquery.min.js");
			Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/move-top.js");
			Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/easing.js");
			Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/responsiveslides.min.js");
			Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/jquery.easydropdown.js");
			Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . "/js/scripts.js");

			Asset::getInstance()->addString('<meta name="viewport" content="width=device-width, initial-scale=1">');
			Asset::getInstance()->addString('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
			Asset::getInstance()->addString('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&amp;display=swap" rel="stylesheet">');
			Asset::getInstance()->addString("<link href='http://fonts.googleapis.com/css?family=Roboto:500,900,100,300,700,400' rel='stylesheet' type='text/css'>");
			Asset::getInstance()->addCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

		?>
	</title>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
			});
		});
	</script>

	<script type="application/x-javascript"> 
		addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
	</script>

	<script>  
		$(function () {
			$("#slider").responsiveSlides({
				auto: true,
				nav: true,
				speed: 500,
				namespace: "callbacks",
				pager: true,
			});
		});
	</script>
</head>
<body>
	<div id="panel">
		<?php 
			$APPLICATION->ShowPanel();
		?>
	</div>
	<div class="banner-bg banner-bg1">	
		<div class="container mainContainer">
			<div class="header">
				<div class="logo">
					<a href="index.html">VELO SHOP</a>
				</div>
				
				<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"menu_catalog", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "main",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "menu_catalog"
	),
	false
);?>	
			<!-- <div class="top-nav">										 
				<label class="mobile_menu" for="mobile_menu">
				<span>Menu</span>
				</label>
				<input id="mobile_menu" type="checkbox">
				<ul class="nav">
					<li class="dropdown1"><a href="bicycles.html">BICYCLES</a>
						<ul class="dropdown2">
							<li><a href="bicycles.html">FIXED / SINGLE SPEED</a></li>
							<li><a href="bicycles.html">CITY BIKES</a></li>
							<li><a href="bicycles.html">PREMIMUN SERIES</a></li>												
						</ul>
					</li>
					<li class="dropdown1"><a href="parts.html">PARTS</a>
						<ul class="dropdown2">
							<li><a href="parts.html">CHAINS</a></li>
							<li><a href="parts.html">TUBES</a></li>
							<li><a href="parts.html">TIRES</a></li>
							<li><a href="parts.html">DISC BREAKS</a></li>
						</ul>
					</li>      
					<li class="dropdown1"><a href="accessories.html">ACCESSORIES</a>
						<ul class="dropdown2">
							<li><a href="accessories.html">LOCKS</a></li>
								<li><a href="accessories.html">HELMETS</a></li>
								<li><a href="accessories.html">ARM COVERS</a></li>
								<li><a href="accessories.html">JERSEYS</a></li>
						</ul>
					</li>               
					<li class="dropdown1"><a href="404.html">EXTRAS</a>
						<ul class="dropdown2">
							<li><a href="404.html">CLASSIC BELL</a></li>
							<li><a href="404.html">BOTTLE CAGE</a></li>
							<li><a href="404.html">TRUCK GRIP</a></li>
						</ul>
					</li>
					<a class="shop" href="cart.html"><img src="images/cart.png" alt=""/></a>
				</ul>
			</div> -->
			<div class="clearfix"></div>
		</div>
	</div>	