<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\Component\Tools;

class DomComment extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        if (
            (int) $arParams['IBLOCK_ID'] < 1
            || (int) $this->arParams['ELEMENT_ID'] < 1
            || strlen($this->arParams['RELATED_FIELD']) < 1
        ) {
            ShowError("To init DomComment component IBLOCK_ID,
             ELEMENT_ID, RELATED_FIELD are required");
            return ['ERROR' => true];
        }

        $commentText = $this->request->getQuery('comment_text');
        $arParams['NEW_COMMENT'] = htmlspecialchars($commentText);

        return $arParams;
    }

    public function executeComponent()
    {
        if ($this->arParams['ERROR'] === true) {
            return 0;
        }

        // add comment
        if (strlen($this->arParams['NEW_COMMENT']) > 0) {
            $this->addComment($this->arParams['NEW_COMMENT']);
        }

        // fetching comments
        $this->arResult['COMMENTS'] = $this->getComments();

        $this->includeComponentTemplate();
    }

    private function addComment($comment)
    {
        $elementId = $this->arParams['ELEMENT_ID'];

        $commentId = CIBlockElement::Add([
            "IBLOCK_ID"   => $this->arParams['IBLOCK_ID'],
            "ACTIVE"      => "Y",
            "DETAIL_TEXT" => $comment,
            "PROPERTY_VALUES" => [
                "PROPERTY_{$this->arParams['RELATED_FIELD']}" => $elementId,
            ]
        ]);

        if (!$commentId) {
            // add to log
            CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => "COMMENT_ADD_FAIL",
                "MODULE_ID" => "main",
                "ITEM_ID" => $elementId,
                "DESCRIPTION" => "failed to add comment",
            ));
            return false;
        }

        return true;
    }

    private function getComments()
    {
        $result = [];

        $dbRes = CIBlockElement::GetList(
            [
                "SORT"=>"ASC"
            ],
            [
                "IBLOCK_ID" => (int) $this->arParams['IBLOCK_ID'],
                "PROPERTY_{$this->arParams['RELATED_FIELD']}" => "{$this->arParams['ELEMENT_ID']}",
                "ACTIVE" => "Y",
            ],
            false,
            false,
            [
                'DETAIL_TEXT',
                'DATE_CREATE',
            ]
        );

        while ($elt = $dbRes->GetNext() ) {
            $result[] = $elt;
        }

        return $result;
    }
}