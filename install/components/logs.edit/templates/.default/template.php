<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/** @var CBitrixComponentTemplate $this */

/** @var ErrorCollection $errors */
$errors = $arResult[ 'ERRORS' ];

foreach ($errors as $error) {
    /** @var Error $error */
    ShowError($error->getMessage());
}

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.form',
    'edit',
    [
        'GRID_ID'                  => $arResult[ 'GRID_ID' ],
        'FORM_ID'                  => $arResult[ 'FORM_ID' ],
        'ENABLE_TACTILE_INTERFACE' => 'Y',
        'SHOW_SETTINGS'            => 'Y',
        'TITLE'                    => $arResult[ 'TITLE' ],
        'IS_NEW'                   => $arResult[ 'IS_NEW' ],
        'DATA'                     => $arResult[ 'LOGS' ],
        'TABS'                     => [
            [
                'id'      => 'tab_1',
                'name'    => Loc::getMessage('CRMSTORES_TAB_STORE_NAME'),
                'title'   => Loc::getMessage('CRMSTORES_TAB_STORE_TITLE'),
                'display' => false,
                'fields'  => [
                    [
                        'id'        => 'section_store',
                        'name'      => Loc::getMessage('CRMSTORES_FIELD_SECTION_STORE'),
                        'type'      => 'section',
                        'isTactile' => true,
                    ],
                    [
                        'id'        => 'NAME',
                        'name'      => Loc::getMessage('CRMSTORES_FIELD_NAME'),
                        'type'      => 'text',
                        'value'     => $arResult[ 'LOGS' ][ 'NAME' ],
                        'isTactile' => true,
                    ],
                    [
                        'id'              => 'ASSIGNED_BY',
                        'name'            => Loc::getMessage('CRMSTORES_FIELD_ASSIGNED_BY'),
                        'type'            => 'intranet_user_search',
                        'value'           => $arResult[ 'LOGS' ][ 'ASSIGNED_BY_ID' ],
                        'componentParams' => [
                            'NAME'              => 'crmstores_edit_responsible',
                            'INPUT_NAME'        => 'ASSIGNED_BY_ID',
                            'SEARCH_INPUT_NAME' => 'ASSIGNED_BY_NAME',
                            'NAME_TEMPLATE'     => CSite::GetNameFormat()
                        ],
                        'isTactile'       => true,
                    ]
                ]
            ],
        ],
        'BUTTONS'                  => [
            'back_url'         => $arResult[ 'BACK_URL' ],
            'standard_buttons' => true,
        ],
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y']
);