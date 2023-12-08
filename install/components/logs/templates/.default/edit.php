<?php
defined('B_PROLOG_INCLUDED') || die;

/** @var CBitrixComponentTemplate $this */

$APPLICATION->IncludeComponent(
    'bitrix:crm.control_panel',
    '',
    [
        'ID'             => 'LOGS',
        'ACTIVE_ITEM_ID' => 'LOGS',
    ],
    $component
);

$urlTemplates = [
    'DETAIL' => $arResult[ 'SEF_FOLDER' ].$arResult[ 'SEF_URL_TEMPLATES' ][ 'details' ],
    'EDIT'   => $arResult[ 'SEF_FOLDER' ].$arResult[ 'SEF_URL_TEMPLATES' ][ 'edit' ],
];

$APPLICATION->IncludeComponent(
    'ms.main:logs.edit',
    '',
    [
        'LOGS_ID'       => $arResult[ 'VARIABLES' ][ 'LOGS_ID' ],
        'URL_TEMPLATES' => $urlTemplates,
        'SEF_FOLDER'    => $arResult[ 'SEF_FOLDER' ],
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y',]
);