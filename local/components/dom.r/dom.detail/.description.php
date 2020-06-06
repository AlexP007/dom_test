<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("DOM_DETAIL_COMPONENT_NAME"),
    "DESCRIPTION" => Loc::getMessage("DOM_DETAIL_COMPONENT_DESCRIPTION"),
    "SORT" => 30,
    "CACHE_PATH" => "Y",
    "PATH" => [
        "ID" => "dom",
        "NAME" => Loc::getMessage("DOM_DETAIL_GROUP_NAME"),
        "SORT" => 10,
    ],
];