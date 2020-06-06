<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\Component\Tools;

class DomComment extends CBitrixComponent
{
    public function executeComponent()
    {
        // fetching comments
        $this->arResult['COMMENTS'] = $this->getComments();

        $this->includeComponentTemplate();
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