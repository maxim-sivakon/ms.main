<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Localization\Loc;


/** @var CBitrixComponentTemplate $this */

$APPLICATION->SetTitle(Loc::getMessage('MSMAIN.LIST_TITLE'));

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
    'bitrix:crm.interface.toolbar',
    'title',
    [
        'TOOLBAR_ID' => 'MSMAIN_TOOLBAR_LOGS',
        'BUTTONS'    => [
            [
                'TEXT'  => Loc::getMessage('MSMAIN.INTERFACE_TOOLBAR_LIST_TEXT'),
                'TITLE' => Loc::getMessage('MSMAIN.INTERFACE_TOOLBAR_LIST_TITLE'),
                'LINK'  => CComponentEngine::makePathFromTemplate($urlTemplates[ 'EDIT' ], ['LOGS_ID' => 0]),
                'ICON'  => 'btn-add',
            ],
        ]
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y']
);

$APPLICATION->IncludeComponent(
    'ms.main:logs.list',
    '',
    [
        'URL_TEMPLATES' => $urlTemplates,
        'SEF_FOLDER'    => $arResult[ 'SEF_FOLDER' ],
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y',]
);