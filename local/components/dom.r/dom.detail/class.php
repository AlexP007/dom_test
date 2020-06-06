<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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
        $this->includeComponentTemplate();
    }
}