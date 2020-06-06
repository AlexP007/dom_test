<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

?>

<h2><?= Loc::getMessage('DOM_DETAIL_TEMPLATE_HEADING_SUB') ?> <?= $arResult['ELEMENT']['NAME'] ?></h2>
<img src=<?= $arResult['ELEMENT']['DETAIL_PICTURE']['src'] ?>>
<p><?= $arResult['ELEMENT']['PREVIEW_TEXT'] ?></p>
<p><?= $arResult['ELEMENT']['DETAIL_TEXT'] ?></p>

<?$APPLICATION->IncludeComponent(
    "dom.r:dom.comment",
    "",
    Array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "ELEMENT_ID" => $arParams['ELEMENT_ID'],
        "IBLOCK_ID" => "6",
        "RELATED_FIELD" => "RELATED_COMMENT_ID"
    )
);?>

