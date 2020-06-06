<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>

<h1>Детальная страница элемента</h1>
<h2>Элемент <?= $arResult['ELEMENT']['NAME'] ?></h2>
<img src=<?= $arResult['ELEMENT']['DETAIL_PICTURE']['src'] ?>>
<p><?= $arResult['ELEMENT']['PREVIEW_TEXT'] ?></p>
<p><?= $arResult['ELEMENT']['DETAIL_TEXT'] ?></p>

