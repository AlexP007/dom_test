<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\Component\Tools;

class DomDetail extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        // getting element id
        if (!is_null($arParams['GET_PARAM_NAME'])) {
            $eltId = $this->request->getQuery($arParams['GET_PARAM_NAME']);
            $arParams['ELEMENT_ID'] = $eltId;
        };

        // setting cache time
        if(!isset($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 36000000;
        }

        return $arParams;
    }

    public function executeComponent()
    {
        $this->arResult['ELEMENT'] = $this->getElement();

        // proceed 404
        if ($this->arResult['ELEMENT'] === false) {
            Tools::process404(
                'Not found'
                ,true
                ,true,
                true,
                false
            );
        }
        $this->includeComponentTemplate();
    }

    private function getElement()
    {
        Loader::includeModule("iblock") or die('depend on iblock');

        $id = (int) $this->arParams['ELEMENT_ID'];
        return CIBlockElement::GetByID($id)->Fetch();

    }
}