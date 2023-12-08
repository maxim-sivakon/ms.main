<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Grid\Panel\Snippet;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Web\Json;

/** @var CBitrixComponentTemplate $this */

if (!Loader::includeModule('crm')) {
    ShowError(Loc::getMessage('CRMSTORES_NO_CRM_MODULE'));
    return;
}

$asset = Asset::getInstance();
$asset->addJs('/bitrix/js/crm/interface_grid.js');

$gridManagerId = $arResult[ 'GRID_ID' ].'_MANAGER';

$rows = [];
foreach ($arResult[ 'LOGS' ] as $log) {

    $viewUrl = CComponentEngine::makePathFromTemplate(
        $arParams[ 'URL_TEMPLATES' ][ 'DETAIL' ],
        ['LOG_ID' => $log[ 'ID' ]]
    );
    $editUrl = CComponentEngine::makePathFromTemplate(
        $arParams[ 'URL_TEMPLATES' ][ 'EDIT' ],
        ['LOG_ID' => $log[ 'ID' ]]
    );

    $deleteUrlParams = http_build_query([
        'action_button_'.$arResult[ 'GRID_ID' ] => 'delete',
        'ID'                                    => [$log[ 'ID' ]],
        'sessid'                                => bitrix_sessid()
    ]);
    $deleteUrl = $arParams[ 'SEF_FOLDER' ].'?'.$deleteUrlParams;

    $rows[] = [
        'id'      => $log[ 'ID' ],
        'actions' => [
            [
                'TITLE'   => Loc::getMessage('CRMSTORES_ACTION_VIEW_TITLE'),
                'TEXT'    => Loc::getMessage('CRMSTORES_ACTION_VIEW_TEXT'),
                'ONCLICK' => 'BX.Crm.Page.open('.Json::encode($viewUrl).')',
                'DEFAULT' => true
            ],
            [
                'TITLE'   => Loc::getMessage('CRMSTORES_ACTION_EDIT_TITLE'),
                'TEXT'    => Loc::getMessage('CRMSTORES_ACTION_EDIT_TEXT'),
                'ONCLICK' => 'BX.Crm.Page.open('.Json::encode($editUrl).')',
            ],
            [
                'TITLE'   => Loc::getMessage('CRMSTORES_ACTION_DELETE_TITLE'),
                'TEXT'    => Loc::getMessage('CRMSTORES_ACTION_DELETE_TEXT'),
                'ONCLICK' => 'BX.CrmUIGridExtension.processMenuCommand('.Json::encode($gridManagerId).', BX.CrmUIGridMenuCommand.remove, { pathToRemove: '.Json::encode($deleteUrl).' })',
            ]
        ],
        'data'    => $log,
        'columns' => [
            'ID'          => $log[ 'ID' ],
            'NAME'        => '<a href="'.$viewUrl.'" target="_self">'.$log[ 'NAME' ].'</a>',
            'ASSIGNED_BY' => empty($log[ 'ASSIGNED_BY' ]) ? '' : CCrmViewHelper::PrepareUserBaloonHtml(
                [
                    'PREFIX'           => "LOG_{$log['ID']}_RESPONSIBLE",
                    'USER_ID'          => $log[ 'ASSIGNED_BY_ID' ],
                    'USER_NAME'        => CUser::FormatName(CSite::GetNameFormat(), $log[ 'ASSIGNED_BY' ]),
                    'USER_PROFILE_URL' => Option::get('intranet', 'path_user', '', SITE_ID).'/'
                ]
            )
        ]
    ];
}

$snippet = new Snippet();

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.grid',
    'titleflex',
    [
        'GRID_ID'                 => $arResult[ 'GRID_ID' ],
        'HEADERS'                 => $arResult[ 'HEADERS' ],
        'ROWS'                    => $rows,
        'PAGINATION'              => $arResult[ 'PAGINATION' ],
        'SORT'                    => $arResult[ 'SORT' ],
        'FILTER'                  => $arResult[ 'FILTER' ],
        'FILTER_PRESETS'          => $arResult[ 'FILTER_PRESETS' ],
        'IS_EXTERNAL_FILTER'      => false,
        'ENABLE_LIVE_SEARCH'      => $arResult[ 'ENABLE_LIVE_SEARCH' ],
        'DISABLE_SEARCH'          => $arResult[ 'DISABLE_SEARCH' ],
        'ENABLE_ROW_COUNT_LOADER' => true,
        'AJAX_ID'                 => '',
        'AJAX_OPTION_JUMP'        => 'N',
        'AJAX_OPTION_HISTORY'     => 'N',
        'AJAX_LOADER'             => null,
        'ACTION_PANEL'            => [
            'GROUPS' => [
                [
                    'ITEMS' => [
                        $snippet->getRemoveButton(),
                        $snippet->getForAllCheckbox(),
                    ]
                ]
            ]
        ],
        'EXTENSION'               => [
            'ID'       => $gridManagerId,
            'CONFIG'   => [
                'ownerTypeName' => 'LOGS',
                'gridId'        => $arResult[ 'GRID_ID' ],
                'serviceUrl'    => $arResult[ 'SERVICE_URL' ],
            ],
            'MESSAGES' => [
                'deletionDialogTitle'       => Loc::getMessage('CRMSTORES_DELETE_DIALOG_TITLE'),
                'deletionDialogMessage'     => Loc::getMessage('CRMSTORES_DELETE_DIALOG_MESSAGE'),
                'deletionDialogButtonTitle' => Loc::getMessage('CRMSTORES_DELETE_DIALOG_BUTTON'),
            ]
        ],
    ],
    $this->getComponent(),
    ['HIDE_ICONS' => 'Y',]
);