<?php require $_SERVER[ 'DOCUMENT_ROOT' ].'/bitrix/header.php';

$APPLICATION->IncludeComponent(
    'ms.main:logs',
    '',
    [
        'SEF_MODE'          => 'Y',
        'SEF_FOLDER'        => '/ms.main/crm/logs/',
        'SEF_URL_TEMPLATES' => [
            'details' => '#LOG_ID#/',
            'edit'    => '#LOG_ID#/edit/',
        ]
    ],
    false
);

require $_SERVER[ 'DOCUMENT_ROOT' ].'/bitrix/footer.php' ?>