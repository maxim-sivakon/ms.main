<?
require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/header.php");
$APPLICATION->SetTitle("События");

\Bitrix\Main\Loader::includeModule('ui');
Bitrix\Main\Page\Asset::getInstance()->addCss('/bitrix/css/main/grid/webform-button.css');


//\Bitrix\UI\Toolbar\Facade\Toolbar::addFilter([
//    'GRID_ID'               => 'GRID_ID',
//    'FILTER_ID'             => "ID_FILTER",
//    'FILTER'                => $arResult[ 'FILTER' ][ 'FILTER' ],
//    'FILTER_PRESETS'        => $arResult[ 'FILTER' ][ 'FILTER_PRESETS' ],
//    'ENABLE_LIVE_SEARCH'    => $arResult[ 'FILTER' ][ 'ENABLE_LIVE_SEARCH' ],
//    'ENABLE_LABEL'          => $arResult[ 'FILTER' ][ 'ENABLE_LABEL' ],
//    'RESET_TO_DEFAULT_MODE' => $arResult[ 'FILTER' ][ 'RESET_TO_DEFAULT_MODE' ],
//]);
//
//$demoArrayRows = [
//    [
//        'id'   => 'ID',
//        'name' => 'ID',
//    ],
//    [
//        'id'   => 'ACTIVITY',
//        'name' => 'Активность',
//        'type' => 's',
//    ],
//    [
//        'id'   => 'DATE_CREATES',
//        'name' => 'Дата создания',
//        'type' => 's',
//    ],
//    [
//        'id'   => 'TYPE_EVENT',
//        'name' => 'Тип события',
//        'type' => 's',
//    ],
//    [
//        'id'   => 'DEAL_CATEGORY',
//        'name' => 'Воронка',
//        'type' => 's',
//    ],
//    [
//        'id'   => 'CATEGORY_STAGE',
//        'name' => 'Стадия',
//        'type' => 's',
//    ],
//    [
//        'id'   => 'COMMENTS',
//        'name' => 'Описание',
//        'type' => 's',
//    ]
//
//];
//
//$demoArrayColumns = [
//    ['id' => 'ID', 'name' => 'ID', 'sort' => false, 'default' => true],
//    ['id' => 'HREF', 'name' => 'HREF', 'sort' => false, 'default' => true],
//    ['id' => 'ACTIVITY', 'name' => 'Активность', 'sort' => false, 'default' => true],
//    ['id' => 'DATE_CREATES', 'name' => 'Дата создания', 'sort' => false, 'default' => true],
//    ['id' => 'TYPE_EVENT', 'name' => 'Тип события', 'sort' => false, 'default' => true],
//    ['id' => 'DEAL_CATEGORY', 'name' => 'Воронка', 'sort' => false, 'default' => true],
//    ['id' => 'CATEGORY_STAGE', 'name' => 'Стадия', 'sort' => false, 'default' => true],
//    ['id' => 'COMMENTS', 'name' => 'Описание', 'sort' => false, 'default' => true],
//    ['id' => 'CREATOR', 'name' => 'Создатель', 'sort' => false, 'default' => true],
//    ['id' => 'EDITOR', 'name' => 'Редактировал', 'sort' => false, 'default' => true],
//];
//
//$valueCol[] = [
//    'id' => 1,
//    'columns' => [
//        'ID' => '1',
//        'HREF' => '<a href="/my/url">My url</a>',
//        'ACTIVITY' => '2',
//        'DATE_CREATES' => '3',
//        'TYPE_EVENT' => 'g',
//        'DEAL_CATEGORY' => '5',
//        'CATEGORY_STAGE' => '6',
//        'COMMENTS' => '77',
//        'CREATOR' => 409,
//        'EDITOR' => 409,
//    ],
//    'data' => [
//        'ID' => '1',
//        'HREF' => '<a href="/my/url">My url</a>',
//        'ACTIVITY' => '2',
//        'DATE_CREATES' => '3',
//        'TYPE_EVENT' => 'hhh',
//        'DEAL_CATEGORY' => '5',
//        'CATEGORY_STAGE' => '6',
//        'COMMENTS' => '77',
//        'CREATOR' => 409,
//        'EDITOR' => 409,
//    ]
//
//];
//?>
    <!---->
<? // $APPLICATION->IncludeComponent(
//    'bitrix:main.ui.grid',
//    '',
//    [
//        'GRID_ID'                   => "GRID_ID",
//        'COLUMNS'                   => $demoArrayColumns,
//        'ROWS'                      => $valueCol,
//        'SHOW_ROW_CHECKBOXES'       => true,
//        'NAV_OBJECT'                => $demoArrayColumns,
//        'AJAX_MODE'                 => 'N',
//        'AJAX_ID'                   => \CAjax::getComponentID(
//            'bitrix:main.ui.grid',
//            '.default',
//            ''
//        ),
//        'PAGE_SIZES'                => [
//            ['NAME' => '1', 'VALUE' => '1'],
//            ['NAME' => '5', 'VALUE' => '5'],
//            ['NAME' => '10', 'VALUE' => '10'],
//            ['NAME' => '20', 'VALUE' => '20'],
//            ['NAME' => '50', 'VALUE' => '50'],
//            ['NAME' => '100', 'VALUE' => '100'],
//            ['NAME' => '200', 'VALUE' => '250'],
//            ['NAME' => '500', 'VALUE' => '500'],
//        ],
//        'AJAX_OPTION_JUMP'          => 'Y',
//        'SHOW_CHECK_ALL_CHECKBOXES' => true,
//        'SHOW_ROW_ACTIONS_MENU'     => true,
//        'SHOW_GRID_SETTINGS_MENU'   => true,
//        'SHOW_NAVIGATION_PANEL'     => true,
//        'SHOW_PAGINATION'           => true,
//        'SHOW_SELECTED_COUNTER'     => true,
//        'SHOW_TOTAL_COUNTER'        => true,
//        'SHOW_PAGESIZE'             => true,
//        'SHOW_ACTION_PANEL'         => true,
//        'ACTION_PANEL'              => true,
//        'ALLOW_COLUMNS_SORT'        => true,
//        'ALLOW_COLUMNS_RESIZE'      => true,
//        'ALLOW_HORIZONTAL_SCROLL'   => true,
//        'ALLOW_SORT'                => true,
//        'ALLOW_PIN_HEADER'          => true,
//        'AJAX_OPTION_HISTORY'       => 'N',
//        'TOTAL_ROWS_COUNT'          => "",
//        'ENABLE_NEXT_PAGE'          => true,
//    ]
//); ?>

<?php
\Bitrix\UI\Toolbar\Facade\Toolbar::addFilter([
    'FILTER_ID'          => 'report_list',
    'GRID_ID'            => 'report_list',
    'FILTER'             => [
        ['id' => 'DATE', 'name' => 'Дата', 'type' => 'date'],
        [
            'id'    => 'IS_SPEND', 'name' => 'Тип операции', 'type' => 'list',
            'items' => ['' => 'Любой', 'P' => 'Поступление', 'M' => 'Списание'], 'params' => ['multiple' => 'Y']
        ],
        ['id' => 'AMOUNT', 'name' => 'Сумма', 'type' => 'number'],
        ['id' => 'PAYER_INN', 'name' => 'ИНН Плательщика', 'type' => 'number'],
        ['id' => 'PAYER_NAME', 'name' => 'Плательщик'],
    ],
    'ENABLE_LIVE_SEARCH' => true,
    'ENABLE_LABEL'       => true
]);

$filter = [];
$filterOption = new Bitrix\Main\UI\Filter\Options('report_list');
$filterData = $filterOption->getFilter([]);
foreach ($filterData as $k => $v) {
    $filter[ $k ] = $v;
}

$grid_options = new Bitrix\Main\Grid\Options('report_list');
$sort = $grid_options->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$nav_params = $grid_options->GetNavParams();

$nav = new Bitrix\Main\UI\PageNavigation('report_list');
$nav->allowAllRecords(true)
    ->setPageSize($nav_params[ 'nPageSize' ])
    ->initFromUri();


$list = [
    [
        'data'    => [ //Данные ячеек
            "ID"         => 1,
            "NAME"       => "Название 1",
            "AMOUNT"     => 1000,
            "PAYER_NAME" => "Плательщик 1"
        ],
        'actions' => [ //Действия над ними
            [
                'text'    => 'Редактировать',
                'onclick' => 'document.location.href="/accountant/reports/1/edit/"'
            ],
            [
                'text'    => 'Удалить',
                'onclick' => 'document.location.href="/accountant/reports/1/delete/"'
            ]

        ],
    ], [
        'data'    => [ //Данные ячеек
            "ID"         => 2,
            "NAME"       => "Название 2",
            "AMOUNT"     => 3000,
            "PAYER_NAME" => "Плательщик 2"
        ],
        'actions' => [ //Действия над ними
            [
                'text'    => 'Редактировать',
                'onclick' => 'document.location.href="/accountant/reports/2/edit/"'
            ],
            [
                'text'    => 'Удалить',
                'onclick' => 'document.location.href="/accountant/reports/2/delete/"'
            ]

        ],
    ]
];

$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID'                   => 'report_list',
    'COLUMNS'                   => [
        ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
        ['id' => 'DATE', 'name' => 'Дата', 'sort' => 'DATE', 'default' => true],
        ['id' => 'AMOUNT', 'name' => 'Сумма', 'sort' => 'AMOUNT', 'default' => true],
        ['id' => 'PAYER_INN', 'name' => 'ИНН Плательщика', 'sort' => 'PAYER_INN', 'default' => true],
        ['id' => 'PAYER_NAME', 'name' => 'Плательщик', 'sort' => 'PAYER_NAME', 'default' => true],
        ['id' => 'IS_SPEND', 'name' => 'Тип операции', 'sort' => 'IS_SPEND', 'default' => true],
    ],
    'ROWS'                      => $list, //Самое интересное, опишем ниже
    'SHOW_ROW_CHECKBOXES'       => true,
    'NAV_OBJECT'                => $nav,
    'AJAX_MODE'                 => 'Y',
    'AJAX_ID'                   => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
    'PAGE_SIZES'                => [
        ['NAME' => "5", 'VALUE' => '5'],
        ['NAME' => '10', 'VALUE' => '10'],
        ['NAME' => '20', 'VALUE' => '20'],
        ['NAME' => '50', 'VALUE' => '50'],
        ['NAME' => '100', 'VALUE' => '100']
    ],
    'AJAX_OPTION_JUMP'          => 'N',
    'SHOW_CHECK_ALL_CHECKBOXES' => true,
    'SHOW_ROW_ACTIONS_MENU'     => true,
    'SHOW_GRID_SETTINGS_MENU'   => true,
    'SHOW_NAVIGATION_PANEL'     => true,
    'SHOW_PAGINATION'           => true,
    'SHOW_SELECTED_COUNTER'     => true,
    'SHOW_TOTAL_COUNTER'        => true,
    'SHOW_PAGESIZE'             => true,
    'SHOW_ACTION_PANEL'         => true,
    'ACTION_PANEL'              => [
        'GROUPS' => [
            'TYPE' => [
                'ITEMS' => [
                    [
                        'ID'    => 'set-type',
                        'TYPE'  => 'DROPDOWN',
                        'ITEMS' => [
                            ['VALUE' => '', 'NAME' => '- Выбрать -'],
                            ['VALUE' => 'plus', 'NAME' => 'Поступление'],
                            ['VALUE' => 'minus', 'NAME' => 'Списание']
                        ]
                    ],
                    [
                        'ID'       => 'edit',
                        'TYPE'     => 'BUTTON',
                        'TEXT'     => 'Редактировать',
                        'CLASS'    => 'icon edit',
                        'ONCHANGE' => ''
                    ],
                    [
                        'ID'       => 'delete',
                        'TYPE'     => 'BUTTON',
                        'TEXT'     => 'Удалить',
                        'CLASS'    => 'icon remove',
                        'ONCHANGE' => ''
                    ],
                ],
            ]
        ],
    ],
    'ALLOW_COLUMNS_SORT'        => true,
    'ALLOW_COLUMNS_RESIZE'      => true,
    'ALLOW_HORIZONTAL_SCROLL'   => true,
    'ALLOW_SORT'                => true,
    'ALLOW_PIN_HEADER'          => true,
    'AJAX_OPTION_HISTORY'       => 'N'
]);


?>
    <script type="text/javascript">
        var reloadParams = { apply_filter: 'Y', clear_nav: 'Y' };
        var gridObject = BX.Main.gridManager.getById('report_list'); // Идентификатор грида

        if (gridObject.hasOwnProperty('instance')){
            gridObject.instance.reloadTable('POST', reloadParams);
        }
    </script>
    <script type="text/javascript">
        BX.addCustomEvent('BX.Main.Filter:apply', BX.delegate(function (command, params) {
            var workarea = $('#' + command); // в command будет храниться GRID_ID из фильтра

            $.post(window.location.href, function(data){
                workarea.html($(data).find('#' + command).html());
            })
        }));
    </script>
<? require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/footer.php"); ?>