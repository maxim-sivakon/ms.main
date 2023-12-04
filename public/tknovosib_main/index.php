<?
require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/header.php");
$APPLICATION->SetTitle("События");

\Bitrix\Main\Loader::includeModule('ui');

\Bitrix\UI\Toolbar\Facade\Toolbar::addFilter([
    'GRID_ID' => $arResult['GRID']['ID'],
    'FILTER_ID' => "ID_FILTER",
    'FILTER' => $arResult['FILTER']['FILTER'],
    'FILTER_PRESETS' => $arResult['FILTER']['FILTER_PRESETS'],
    'ENABLE_LIVE_SEARCH' => $arResult['FILTER']['ENABLE_LIVE_SEARCH'],
    'ENABLE_LABEL' => $arResult['FILTER']['ENABLE_LABEL'],
    'RESET_TO_DEFAULT_MODE' => $arResult['FILTER']['RESET_TO_DEFAULT_MODE'],
]);
$demoArrayRows = [
    'columns' => [
        'TITLE' => 'Сделать анимацию добавления нового элемента в грид',
        'DATE' => '15 сентября 2022, 14:51',
        'AUTHOR' => 'Владимир Белов',
        'TAGS' => [
            'addButton' => [
                'events' => [
                    'click' => 'console.log.bind(null, "add button click")',
                ],
            ],
            'items' => [
                [
                    'text' => 'Грид',
                    'active' => false,
                    'events' => [
                        'click' => 'console.log.bind(null, "tag click")',
                    ],
                    'removeButton' => [
                        'events' => [
                            'click' => 'console.log.bind(null, "tag remove click")',
                        ],
                    ],
                ],
                [
                    'text' => 'UI',
                    'active' => false,
                    'events' => [
                        'click' => 'console.log.bind(null, "tag click")',
                    ],
                    'removeButton' => [
                        'events' => [
                            'click' => 'console.log.bind(null, "tag remove click")',
                        ],
                    ],
                ],
                [
                    'text' => 'Анимация',
                    'active' => true,
                    'events' => [
                        'click' => 'console.log.bind(null, "tag click")',
                    ],
                    'removeButton' => [
                        'events' => [
                            'click' => 'console.log.bind(null, "tag remove click")',
                        ],
                    ],
                ],
                [
                    'text' => 'Главный модуль',
                    'active' => false,
                    'events' => [
                        'click' => 'console.log.bind(null, "tag click")',
                    ],
                    'removeButton' => [
                        'events' => [
                            'click' => 'console.log.bind(null, "tag remove click")',
                        ],
                    ],
                ]
            ],
        ],
        'LABELS' => [
            [
                'text' => 'Лейбл #1',
                'color' => \Bitrix\Main\Grid\Cell\Label\Color::DANGER,
                'events' => [
                    'click' => "console.log.bind(null, 'Label click')",
                ],
                'removeButton' => [
                    'type' => \Bitrix\Main\Grid\Cell\Label\RemoveButtonType::INSIDE,
                    'events' => [
                        'click' => "console.log.bind(null, 'Label remove click')",
                    ],
                ],
            ],
            [
                'text' => 'Лейбл #2',
                'color' => \Bitrix\Main\Grid\Cell\Label\Color::PRIMARY,
                'events' => [
                    'click' => "console.log",
                ],
                'removeButton' => [
                    'type' => \Bitrix\Main\Grid\Cell\Label\RemoveButtonType::OUTSIDE,
                    'events' => [
                        'click' => "console.log.bind(null, 'Label remove click')",
                    ],
                ],
            ],
            [
                'text' => 'Лейбл #3',
                'color' => \Bitrix\Main\Grid\Cell\Label\Color::SECONDARY,
                'events' => [
                    'click' => "console.log",
                ],
                'remove-button-events' => [
                    'click' => "console.log.bind(null, 'remove')",
                ],
            ],
            [
                'text' => '«Text»',
                'color' => \Bitrix\Main\Grid\Cell\Label\Color::LIGHT,
                'events' => [
                    'click' => "console.log",
                ],
                'remove-button-events' => [
                    'click' => "console.log.bind(null, 'remove')",
                ],
            ],
        ],

    ],
];
$demoArrayColumns = [
    'id' => 'column_id',
    'name' => 'Заголовок колонки',
];

?>

<? $APPLICATION->IncludeComponent(
    'bitrix:main.ui.grid',
    '',
    [
        'GRID_ID'                   => "GRID_ID",
        'COLUMNS'                   => $demoArrayColumns,
        'ROWS'                      => $demoArrayRows,
        'SHOW_ROW_CHECKBOXES'       => false,
        'NAV_OBJECT'                => "",
        'AJAX_MODE'                 => 'N',
        'AJAX_ID'                   => \CAjax::getComponentID(
            'bitrix:main.ui.grid',
            '.default',
            ''
        ),
        'PAGE_SIZES'                => [
            ['NAME' => '1', 'VALUE' => '1'],
            ['NAME' => '5', 'VALUE' => '5'],
            ['NAME' => '10', 'VALUE' => '10'],
            ['NAME' => '20', 'VALUE' => '20'],
            ['NAME' => '50', 'VALUE' => '50'],
            ['NAME' => '100', 'VALUE' => '100'],
            ['NAME' => '200', 'VALUE' => '250'],
            ['NAME' => '500', 'VALUE' => '500'],
        ],
        'AJAX_OPTION_JUMP'          => 'Y',
        'SHOW_CHECK_ALL_CHECKBOXES' => false,
        'SHOW_ROW_ACTIONS_MENU'     => true,
        'SHOW_GRID_SETTINGS_MENU'   => true,
        'SHOW_NAVIGATION_PANEL'     => true,
        'SHOW_PAGINATION'           => true,
        'SHOW_SELECTED_COUNTER'     => false,
        'SHOW_TOTAL_COUNTER'        => true,
        'SHOW_PAGESIZE'             => true,
        'SHOW_ACTION_PANEL'         => false,
        'ACTION_PANEL'              => false,
        'ALLOW_COLUMNS_SORT'        => true,
        'ALLOW_COLUMNS_RESIZE'      => true,
        'ALLOW_HORIZONTAL_SCROLL'   => true,
        'ALLOW_SORT'                => true,
        'ALLOW_PIN_HEADER'          => true,
        'AJAX_OPTION_HISTORY'       => 'N',
        'TOTAL_ROWS_COUNT'          => "",
        'ENABLE_NEXT_PAGE'          => true,
    ]
); ?>

<? require($_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/footer.php"); ?>