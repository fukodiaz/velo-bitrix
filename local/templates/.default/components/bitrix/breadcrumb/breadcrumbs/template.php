<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @global CMain $APPLICATION
 */
global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '<div class="dreamcrub clearfix"><ul class="breadcrumbs">';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
}

$strReturn .= '<div class="bx-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);

for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$titleContent = $title;
	if ($index == 0) $titleContent = '<i class="fa-sharp fa-solid fa-house"></i>';
	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
		<li class="bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		'.$arrow.'
			<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
				<span itemprop="name">'.$titleContent.'</span>
			</a>
			<meta itemprop="position" content="'.($index + 1).'" />
		</li>';
	}
	else
	{
		$strReturn .= '
			<li class="bx-breadcrumb-item">
				'.$arrow.'
				<span>'.$titleContent.'</span>
			</li>';
	}
}

$strReturn .= '</></div>';

return $strReturn;
