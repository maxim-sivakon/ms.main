<?php
defined('B_PROLOG_INCLUDED') || die;

use MS\Main\Entity\LogsTable;

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\UserTable;
use Bitrix\Main\Grid;
use Bitrix\Main\UI\Filter;
use Bitrix\Main\Web\Json;
use Bitrix\Main\Web\Uri;

class CMsMainLogsListComponent extends CBitrixComponent
{
    const GRID_ID                   = 'LOGS_LIST';
    const SORTABLE_FIELDS           = [
        'ID', 'NAME', 'TYPE_EVENT', 'DATE_CREATE_LOG', 'USER_CREATE_LOG', 'LOCAL_TIME_USER', 'ID_DEAL', 'TYPE_DEVICE',
        'LIST_MODIFI_FIELDS', 'COUNT_MODIFI_FIELDS', 'LIST_MODIFI_FIELDS_VALUE', 'USER_IP', 'USER_URL'
    ];
    const FILTERABLE_FIELDS         = [
        'ID', 'NAME', 'TYPE_EVENT', 'DATE_CREATE_LOG', 'USER_CREATE_LOG', 'LOCAL_TIME_USER', 'ID_DEAL', 'TYPE_DEVICE',
        'LIST_MODIFI_FIELDS', 'COUNT_MODIFI_FIELDS', 'LIST_MODIFI_FIELDS_VALUE', 'USER_IP', 'USER_URL'
    ];
    const SUPPORTED_ACTIONS         = ['delete'];
    const SUPPORTED_SERVICE_ACTIONS = ['GET_ROW_COUNT'];

    private static $headers;
    private static $filterFields;
    private static $filterPresets;

    public function __construct(CBitrixComponent $component = null)
    {
        global $USER;

        parent::__construct($component);

        self::$headers = [
            [
                'id'          => 'ID',
                'name'        => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_ID'),
                'sort'        => 'ID',
                'first_order' => 'desc',
                'type'        => 'int',
                'default'     => true,
            ],
            [
                'id'      => 'NAME', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_NAME'), 'sort' => 'NAME',
                'default' => true,
            ],
            [
                'id'   => 'TYPE_EVENT', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_TYPE_EVENT'),
                'sort' => 'TYPE_EVENT', 'default' => true,
            ],
            [
                'id'   => 'DATE_CREATE_LOG', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_DATE_CREATE_LOG'),
                'sort' => 'DATE_CREATE_LOG', 'default' => true,
            ],
            [
                'id'   => 'USER_CREATE_LOG', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_USER_CREATE_LOG'),
                'sort' => 'USER_CREATE_LOG', 'default' => true,
            ],
            [
                'id'   => 'LOCAL_TIME_USER', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_LOCAL_TIME_USER'),
                'sort' => 'LOCAL_TIME_USER', 'default' => false,
            ],
            [
                'id'      => 'ID_DEAL', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_ID_DEAL'),
                'sort'    => 'ID_DEAL',
                'default' => true,
            ],
            [
                'id'   => 'TYPE_DEVICE', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_TYPE_DEVICE'),
                'sort' => 'TYPE_DEVICE', 'default' => false,
            ],
            [
                'id'   => 'LIST_MODIFI_FIELDS', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_LIST_MODIFI_FIELDS'),
                'sort' => 'LIST_MODIFI_FIELDS', 'default' => false,
            ],
            [
                'id'   => 'COUNT_MODIFI_FIELDS',
                'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_COUNT_MODIFI_FIELDS'),
                'sort' => 'COUNT_MODIFI_FIELDS', 'default' => false,
            ],
            [
                'id'   => 'LIST_MODIFI_FIELDS_VALUE',
                'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_LIST_MODIFI_FIELDS_VALUE'),
                'sort' => 'LIST_MODIFI_FIELDS_VALUE', 'default' => true,
            ],
            [
                'id'      => 'USER_IP', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_USER_IP'),
                'sort'    => 'USER_IP',
                'default' => false,
            ],
            [
                'id'   => 'USER_URL', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_USER_URL'),
                'sort' => 'USER_URL', 'default' => false,
            ],

        ];

        self::$filterFields = [
            [
                'id'   => 'ID',
                'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_ID')
            ],
            ['id' => 'NAME', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_NAME'), 'default' => true,],
            ['id' => 'TYPE_EVENT', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_TYPE_EVENT'), 'default' => true,],
            [
                'id'      => 'DATE_CREATE_LOG', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_DATE_CREATE_LOG'),
                'default' => true,
            ],
            [
                'id'       => 'USER_CREATE_LOG',
                'name'     => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_USER_CREATE_LOG'),
                'type'     => 'custom_entity',
                'params'   => [
                    'multiple' => 'Y'
                ],
                'selector' => [
                    'TYPE' => 'user',
                    'DATA' => [
                        'ID'       => 'USER_CREATE_LOG',
                        'FIELD_ID' => 'USER_CREATE_LOG_ID'
                    ]
                ],
                'default'  => true,
            ],
            [
                'id'      => 'LOCAL_TIME_USER', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_LOCAL_TIME_USER'),
                'default' => false,
            ],
            ['id' => 'ID_DEAL', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_ID_DEAL'), 'default' => true,],
            [
                'id'      => 'TYPE_DEVICE', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_TYPE_DEVICE'),
                'default' => false,
            ],
            [
                'id'      => 'LIST_MODIFI_FIELDS',
                'name'    => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_LIST_MODIFI_FIELDS'),
                'default' => false,
            ],
            [
                'id'   => 'COUNT_MODIFI_FIELDS',
                'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_COUNT_MODIFI_FIELDS'), 'default' => false,
            ],
            [
                'id'   => 'LIST_MODIFI_FIELDS_VALUE',
                'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_LIST_MODIFI_FIELDS_VALUE'), 'default' => true,
            ],
            ['id' => 'USER_IP', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_USER_IP'), 'default' => false,],
            ['id' => 'USER_URL', 'name' => Loc::getMessage('MSMAIN.LOGS_LIST.FIELD_USER_URL'), 'default' => false,],
        ];

        //        self::$filterPresets = array(
        //            'my_stores' => array(
        //                'name' => Loc::getMessage('CRMSTORES_FILTER_PRESET_MY_STORES'),
        //                'fields' => array(
        //                    'ASSIGNED_BY_ID' => $USER->GetID(),
        //                    'ASSIGNED_BY_ID_name' => $USER->GetFullName(),
        //                )
        //            )
        //        );
    }

    public function executeComponent()
    {
        if (!Loader::includeModule('ms.main')) {
            ShowError(Loc::getMessage('CRMSTORES_NO_MODULE'));
            return;
        }

        $context = Context::getCurrent();
        $request = $context->getRequest();

        $grid = new Grid\Options(self::GRID_ID);

        //region Sort
        $gridSort = $grid->getSorting();
        $sort = array_filter(
            $gridSort[ 'sort' ],
            function ($field) {
                return in_array($field, self::SORTABLE_FIELDS);
            },
            ARRAY_FILTER_USE_KEY
        );
        if (empty($sort)) {
            $sort = ['NAME' => 'asc'];
        }
        //endregion

        //region Filter
        $gridFilter = new Filter\Options(self::GRID_ID, self::$filterPresets);
        $gridFilterValues = $gridFilter->getFilter(self::$filterFields);
        $gridFilterValues = array_filter(
            $gridFilterValues,
            function ($fieldName) {
                return in_array($fieldName, self::FILTERABLE_FIELDS);
            },
            ARRAY_FILTER_USE_KEY
        );
        //endregion

        $this->processGridActions($gridFilterValues);
        $this->processServiceActions($gridFilterValues);

        //region Pagination
        $gridNav = $grid->GetNavParams();
        $pager = new PageNavigation('');
        $pager->setPageSize($gridNav[ 'nPageSize' ]);
        $pager->setRecordCount(LogsTable::getCount($gridFilterValues));
        if ($request->offsetExists('page')) {
            $currentPage = $request->get('page');
            $pager->setCurrentPage($currentPage > 0 ? $currentPage : $pager->getPageCount());
        } else {
            $pager->setCurrentPage(1);
        }
        //endregion

        $logs = $this->getLogs([
            'filter' => $gridFilterValues,
            'limit'  => $pager->getLimit(),
            'offset' => $pager->getOffset(),
            'order'  => $sort
        ]);

        $requestUri = new Uri($request->getRequestedPage());
        $requestUri->addParams(['sessid' => bitrix_sessid()]);

        $this->arResult = [
            'GRID_ID'            => self::GRID_ID,
            'LOGS'               => $logs,
            'HEADERS'            => self::$headers,
            'PAGINATION'         => [
                'PAGE_NUM'         => $pager->getCurrentPage(),
                'ENABLE_NEXT_PAGE' => $pager->getCurrentPage() < $pager->getPageCount(),
                'URL'              => $request->getRequestedPage(),
            ],
            'SORT'               => $sort,
            'FILTER'             => self::$filterFields,
            'FILTER_PRESETS'     => self::$filterPresets,
            'ENABLE_LIVE_SEARCH' => false,
            'DISABLE_SEARCH'     => true,
            'SERVICE_URL'        => $requestUri->getUri(),
        ];

        $this->includeComponentTemplate();
    }

    private function getLogs($params = [])
    {
        $dbLogs = LogsTable::getList($params);
        $logs = $dbLogs->fetchAll();

        $userIds = array_column($logs, 'ASSIGNED_BY_ID');
        $userIds = array_unique($userIds);
        $userIds = array_filter(
            $userIds,
            function ($userId) {
                return intval($userId) > 0;
            }
        );

        $dbUsers = UserTable::getList([
            'filter' => ['=ID' => $userIds]
        ]);
        $users = [];
        foreach ($dbUsers as $user) {
            $users[ $user[ 'ID' ] ] = $user;
        }

        foreach ($logs as &$log) {
            if (intval($log[ 'ASSIGNED_BY_ID' ]) > 0) {
                $logs[ 'ASSIGNED_BY' ] = $users[ $log[ 'ASSIGNED_BY_ID' ] ];
            }
        }

        return $logs;
    }

    private function processGridActions($currentFilter)
    {
        if (!check_bitrix_sessid()) {
            return;
        }

        $context = Context::getCurrent();
        $request = $context->getRequest();

        $action = $request->get('action_button_'.self::GRID_ID);

        if (!in_array($action, self::SUPPORTED_ACTIONS)) {
            return;
        }

        $allRows = $request->get('action_all_rows_'.self::GRID_ID) == 'Y';
        if ($allRows) {
            $dbLogs = LogsTable::getList([
                'filter' => $currentFilter,
                'select' => ['ID'],
            ]);
            $logIds = [];
            foreach ($dbLogs as $log) {
                $logIds[] = $log[ 'ID' ];
            }
        } else {
            $logIds = $request->get('ID');
            if (!is_array($logIds)) {
                $logIds = [];
            }
        }

        if (empty($logIds)) {
            return;
        }

        switch ($action) {
            case 'delete':
                foreach ($logIds as $logId) {
                    LogsTable::delete($logId);
                }
                break;

            default:
                break;
        }
    }

    private function processServiceActions($currentFilter)
    {
        global $APPLICATION;

        if (!check_bitrix_sessid()) {
            return;
        }

        $context = Context::getCurrent();
        $request = $context->getRequest();

        $params = $request->get('PARAMS');

        if (empty($params[ 'GRID_ID' ]) || $params[ 'GRID_ID' ] != self::GRID_ID) {
            return;
        }

        $action = $request->get('ACTION');

        if (!in_array($action, self::SUPPORTED_SERVICE_ACTIONS)) {
            return;
        }

        $APPLICATION->RestartBuffer();
        header('Content-Type: application/json');

        switch ($action) {
            case 'GET_ROW_COUNT':
                $count = LogsTable::getCount($currentFilter);
                echo Json::encode([
                    'DATA' => [
                        'TEXT' => Loc::getMessage('CRMSTORES_GRID_ROW_COUNT', ['#COUNT#' => $count])
                    ]
                ]);
                break;

            default:
                break;
        }

        die;
    }
}