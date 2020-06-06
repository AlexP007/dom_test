<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

class DomDetail extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        if (!is_null($arParams['GET_PARAM_NAME'])) {
            $eltId = $this->request->getQuery($arParams['GET_PARAM_NAME']);
            $arParams['ELEMENT_ID'] = $eltId;
        };

        return $arParams;
    }

    public function executeComponent()
    {
        $this->arResult['ELEMENT'] = $this->getElement();

        $this->includeComponentTemplate();
    }

    private function getElement()
    {
        Loader::includeModule("iblock") or die('depend on iblock');

        $id = (int) $this->arParams['ELEMENT_ID'];

        if ($id > 0) {
            return CIBlockElement::GetByID($id)->Fetch();
        }

        return null;
    }
}