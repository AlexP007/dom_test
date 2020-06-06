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
        // tag cache
        if ($this->startResultCache(false)) {

            if(!Loader::includeModule("iblock")) {
                $this->abortResultCache();
                ShowError('depends on iblock');
                return 0;
            }

            $this->arResult['ELEMENT'] = $this->getElement();

            // proceed 404
            if ($this->arResult['ELEMENT'] === false) {
                $this->abortResultCache();
                $this->proceed404();
                return 0;
            }

            // picture cropping
            $pictureId = $this->arResult['ELEMENT']['DETAIL_PICTURE'];
            $this->arResult['ELEMENT']['DETAIL_PICTURE'] = $this->cropPicture($pictureId);

            $this->setResultCacheKeys(['ELEMENT']);
            // include template
            $this->includeComponentTemplate();
        }

        return 1;
    }

    private function getElement()
    {
        $id = (int) $this->arParams['ELEMENT_ID'];
        return CIBlockElement::GetByID($id)->Fetch();
    }

    private function proceed404()
    {
        Tools::process404(
            'Not found'
            ,true
            ,true,
            true,
            false
        );
    }

    private function cropPicture($id)
    {
        $width = $this->arParams['IMAGE_WIDTH'] > 0
            ? $this->arParams['IMAGE_WIDTH'] : 50;

        $height = $this->arParams['IMAGE_WIDTH'] > 0
            ? $this->arParams['IMAGE_HEIGHT'] : 50;

        return CFile::ResizeImageGet(
            $id,
            [
                'width' => $width,
                'height' => $height,
            ],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );
    }
}
