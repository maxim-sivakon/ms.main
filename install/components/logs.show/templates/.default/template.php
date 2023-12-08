<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/** @var CBitrixComponentTemplate $this */

if (!Loader::includeModule('crm')) {
    ShowError(Loc::getMessage('CRMSTORES_NO_CRM_MODULE'));
    return;
}

ob_start();
$APPLICATION->IncludeComponent(
    'academy.crmstores:store.bounddeals',
    '',
    [
        'STORE_ID' => $arResult[ 'STORE' ][ 'ID' ]
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y']
);
$boundDealsHtml = ob_get_clean();

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.form',
    'show',
    [
        'GRID_ID'                  => $arResult[ 'GRID_ID' ],
        'FORM_ID'                  => $arResult[ 'FORM_ID' ],
        'TACTILE_FORM_ID'          => $arResult[ 'TACTILE_FORM_ID' ],
        'ENABLE_TACTILE_INTERFACE' => 'Y',
        'SHOW_SETTINGS'            => 'Y',
        'DATA'                     => $arResult[ 'STORE' ],
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
                        'id'        => 'ID',
                        'name'      => Loc::getMessage('CRMSTORES_FIELD_ID'),
                        'type'      => 'label',
                        'value'     => $arResult[ 'STORE' ][ 'ID' ],
                        'isTactile' => true,
                    ],
                    [
                        'id'        => 'NAME',
                        'name'      => Loc::getMessage('CRMSTORES_FIELD_NAME'),
                        'type'      => 'label',
                        'value'     => $arResult[ 'STORE' ][ 'NAME' ],
                        'isTactile' => true,
                    ],
                    [
                        'id'        => 'ADDRESS',
                        'name'      => Loc::getMessage('CRMSTORES_FIELD_ADDRESS'),
                        'type'      => 'label',
                        'value'     => $arResult[ 'STORE' ][ 'ADDRESS' ],
                        'isTactile' => true,
                    ],
                    [
                        'id'        => 'ASSIGNED_BY',
                        'name'      => Loc::getMessage('CRMSTORES_FIELD_ASSIGNED_BY'),
                        'type'      => 'custom',
                        'value'     => CCrmViewHelper::PrepareFormResponsible(
                            $arResult[ 'STORE' ][ 'ASSIGNED_BY_ID' ],
                            CSite::GetNameFormat(),
                            Option::get('intranet', 'path_user', '', SITE_ID).'/'
                        ),
                        'isTactile' => true,
                    ]
                ]
            ],
            [
                'id'     => 'deals',
                'name'   => Loc::getMessage('CRMSTORES_TAB_DEALS_NAME'),
                'title'  => Loc::getMessage('CRMSTORES_TAB_DEALS_TITLE'),
                'fields' => [
                    [
                        'id'      => 'DEALS',
                        'colspan' => true,
                        'type'    => 'custom',
                        'value'   => $boundDealsHtml
                    ]
                ]
            ]
        ],
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y']
);