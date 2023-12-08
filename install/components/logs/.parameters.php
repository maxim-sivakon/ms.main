<?php

defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    'PARAMETERS' => [
        'SEF_MODE' => [
            'details' => [
                'NAME'      => Loc::getMessage('MSMAIN.DETAILS_URL_TEMPLATE'),
                'DEFAULT'   => '#LOGS_ID#/',
                'VARIABLES' => ['LOGS_ID'],
            ],
            'edit'    => [
                'NAME'      => Loc::getMessage('MSMAIN.EDIT_URL_TEMPLATE'),
                'DEFAULT'   => '#LOGS_ID#/edit/',
                'VARIABLES' => ['LOGS_ID'],
            ]
        ]
    ]
];