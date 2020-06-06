<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;


if(!Loader::IncludeModule("iblock"))
	return;

$arComponentParameters = [
	"PARAMETERS" => [
        "GET_PARAM_NAME" => [
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("DOM_DETAIL_PARAMETER_GET_PARAM_NAME"),
			"TYPE" => "STRING",
		],
        "IMAGE_HEIGHT" => [
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("DOM_DETAIL_PARAMETER_IMAGE_HEIGHT"),
			"TYPE" => "STRING",
		],
        "IMAGE_WIDTH" => [
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("DOM_DETAIL_PARAMETER_IMAGE_WIDTH"),
			"TYPE" => "STRING",
		],
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	],
];
