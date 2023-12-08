<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Uri;

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

$editUrl = CComponentEngine::makePathFromTemplate(
    $urlTemplates[ 'EDIT' ],
    ['LOGS_ID' => $arResult[ 'VARIABLES' ][ 'LOGS_ID' ]]
);

$viewUrl = CComponentEngine::makePathFromTemplate(
    $urlTemplates[ 'DETAIL' ],
    ['LOGS_ID' => $arResult[ 'VARIABLES' ][ 'LOGS_ID' ]]
);

$editUrl = new Uri($editUrl);
$editUrl->addParams(['backurl' => $viewUrl]);

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.toolbar',
    'type2',
    [
        'TOOLBAR_ID' => 'MSMAIN_TOOLBAR_LOGS',
        'BUTTONS'    => [
            [
                'TEXT'  => Loc::getMessage('MSMAIN.INTERFACE_TOOLBAR_EDIT_TEXT'),
                'TITLE' => Loc::getMessage('MSMAIN.INTERFACE_TOOLBAR_EDIT_TITLE'),
                'LINK'  => $editUrl->getUri(),
                'ICON'  => 'btn-edit',
            ],
        ]
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y']
);


$APPLICATION->IncludeComponent(
    'ms.main:logs.show',
    '',
    [
        'LOGS_ID' => $arResult[ 'VARIABLES' ][ 'LOGS_ID' ]
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y',]
);
