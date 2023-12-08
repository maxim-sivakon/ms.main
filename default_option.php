<?php
defined('B_PROLOG_INCLUDED') || die;

$ms_main_default_option = [
    'LOGS'   => [
        'STORE_DETAIL_TEMPLATE' => '/ms.main/crm/logs/#LOG_ID#/',
        'DEAL_DETAIL_TEMPLATE'  => '/ms.main/crm/logs/details/#DEAL_ID#/',
        'DEAL_UF_NAME'          => 'UF_LOG',
    ],
    'EVENTS' => [
        'STORE_DETAIL_TEMPLATE' => '/ms.main/crm/events/#EVENT_ID#/',
        'DEAL_DETAIL_TEMPLATE'  => '/ms.main/crm/events/details/#EVENT_ID#/',
        'DEAL_UF_NAME'          => 'UF_STORE',
    ]
];