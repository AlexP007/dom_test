<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;


if(!Loader::IncludeModule("iblock"))
	return;

$arComponentParameters = [
	"PARAMETERS" => [
        "ELEMENT_ID" => [
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("DOM_COMMENT_PARAMETER_ELEMENT_ID"),
			"TYPE" => "STRING",
		],
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	],
];
