<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

?>

<h3><?= Loc::getMessage('DOM_COMMENT_TEMPLATE_HEADING_MAIN') ?></h3>
<ul>
    <?php if (count($arResult['COMMENTS']) > 0): ?>
        <?php foreach ($arResult['COMMENTS'] as $comment): ?>
        <li>
            <?= $comment['~DATE_CREATE'] ?>
            <br>
            <?= $comment['~DETAIL_TEXT'] ?></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>

<h3><?= Loc::getMessage("DOM_COMMENT_TEMPLATE_HEADING_SUB") ?></h3>
<form method="POST">
    <textarea name="new_comment" id="" cols="30" rows="10"></textarea>
    <button type="submit">
        <?= Loc::getMessage("DOM_COMMENT_TEMPLATE_BUTTON") ?>
    </button>
</form>


