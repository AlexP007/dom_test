<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

class DomComment extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        // ELEMENT_ID - prior to ancestor
        $eltIdFromGet = (int) $this->request->getQuery($arParams['GET_PARAM_NAME']);
        if ($arParams['ELEMENT_ID'] < 1 && $eltIdFromGet > 0) {
            $arParams['ELEMENT_ID'] = $eltIdFromGet;
        }
        // check parameters filled
        if (
            (int) $arParams['IBLOCK_ID'] < 1
            || strlen($arParams['RELATED_FIELD']) < 1
        ) {
            ShowError("To init DomComment component IBLOCK_ID,
             RELATED_FIELD are required");
            return ['ERROR' => true];
        }

        // getting comment from post
        $commentText = $this->request->getPost('new_comment');
        $arParams['NEW_COMMENT'] = htmlspecialchars($commentText); // some filters

        return $arParams;
    }

    public function executeComponent()
    {
        // if no required params or ELEMENT_ID - finished exec
        if (
            $this->arParams['ERROR'] === true
            || $this->arParams['ELEMENT_ID'] < 1
        ) {
            return 0;
        }

        // check iblock module
        if(!Loader::includeModule("iblock")) {
            ShowError('depends on iblock');
            return 0;
        }

        // add comment
        if (strlen($this->arParams['NEW_COMMENT']) > 0) {
            // if success - refresh
            if ($this->addComment($this->arParams['NEW_COMMENT'])) {
                LocalRedirect($this->request->getRequestUri());
            };
        }

        // tag cache
        if ($this->startResultCache(false)) {

            // fetching comments
            $this->arResult['COMMENTS'] = $this->getComments();

            if (count($this->arResult['COMMENTS']) < 1) {
                $this->abortResultCache();
                return 0;
            }

            $this->setResultCacheKeys(['COMMENTS']);
            // include template
            $this->includeComponentTemplate();
        }

        return 1;
    }

    private function addComment($comment)
    {
        $elementId = $this->arParams['ELEMENT_ID'];

        $newComment = new CIBlockElement;

        $commentId = $newComment->Add([
            "IBLOCK_SECTION" => false,
            "NAME" => substr($comment, 0, 8) . "...",
            "IBLOCK_ID"   => $this->arParams['IBLOCK_ID'],
            "ACTIVE"      => "Y",
            "DETAIL_TEXT" => $comment,
            "PROPERTY_VALUES" => [
                $this->arParams['RELATED_FIELD'] => $elementId,
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
