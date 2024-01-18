<?php
defined('B_PROLOG_INCLUDED') || die;

/**
 * @var string $mid module id from GET
 */

$module_id = 'ms.main';
use Bitrix\Main\Loader;
Loader::includeModule($module_id);

use Bitrix\Main\Config\Configuration;
use Bitrix\Main\Localization\Loc;

//use MS\Main\CTypeEventModify;
use MS\Main\Helpers;
//use MS\Main\HelperFields;

global $APPLICATION, $USER;

if (!$USER->IsAdmin()) {
    return;
}

$formAction = $APPLICATION->GetCurPage().'?mid='.htmlspecialcharsbx($mid).'&lang='.LANGUAGE_ID;
//$dealFieldsOption = HelperFields::getDealFieldsOption();


$arFieldsDeal = [
        'ID' => 50862,
    "IS_MANUAL_OPPORTUNITY" => "Y",
    "BEGINDATE"             => "27.10.2023",
    "ASSIGNED_BY_ID"        => "351",
    "UF_CRM_1626853571"     => "23.11.2023",
    "UF_CRM_1460029339"     => "2455",
    "UF_CRM_1478514709"     => "1630",
    "UF_CRM_1548653136"     => "2582",
    "UF_CRM_1568711077"     => [
        0 => "1175",
    ],
    "UF_CRM_1584445181"     => "3025",
    "UF_CRM_1600310015"     => [
        0 => "1. 7326909807",
        1 => "2-3. 8536901000",
        2 => "4-3. 8536901000",
        3 => "6-8. 8536901000"
    ],
   "UF_CRM_1601294280" =>"2866",
    "UF_CRM_1629181183"=> "4141412",
    "UF_CRM_1629873976"=> "RR192992506RURT",
    "UF_CRM_1637686113256" => "29.12.2023",
    "UF_CRM_1640234604791" => 1,
    "UF_CRM_1649312142714" => [
        0 =>"2821",
        1 =>"26911",
        2 =>"2689",
        3 =>"2692",
    ],
    "~DATE_MODIFY" => "now()",
    "MODIFY_BY_ID" => 409,

];



$tabs = [
    [
        'DIV'   => 'MAIN',
        'TAB'   => Loc::getMessage('MSMAIN.MAIN.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.MAIN.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'LOGS',
        'TAB'   => Loc::getMessage('MSMAIN.LOGS.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.LOGS.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'CURRENCIES',
        'TAB'   => Loc::getMessage('MSMAIN.CURRENCIES.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.CURRENCIES.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'BACKLIGHT_DEAL',
        'TAB'   => Loc::getMessage('MSMAIN.BACKLIGHT_DEAL.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.BACKLIGHT_DEAL.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'BOTS',
        'TAB'   => Loc::getMessage('MSMAIN.BOTS.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.BOTS.TAB_GENERAL_TITLE')
    ],
];

$options = [
    'MAIN'           => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
    ],
    'LOGS'           => [
        [
            'MSMAIN.LOGS.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.LOGS.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY'),
            'N',
            ['checkbox', 'N']
        ],
        Loc::getMessage('MSMAIN.LOGS.SEPARATOR_LIST_FIELDS'),
        ["note" => Loc::getMessage('MSMAIN.LOGS.NOTIFI_DEFAULT_SAVE_FIELDS')],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE_EDIT',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE_EDIT'),
            '',
            [
                'multiselectbox',
                $dealFieldsOption
            ]
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY_EDIT',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY_EDIT'),
            '',
            [
                'multiselectbox',
                $dealFieldsOption
            ]
        ],
        "Строгая проверка множественных полей",
        ["note" => 'Строгая проверка позволяет проверить не только значение но и их очерёдность в списке. Например: если при сохранении множественного поля изменили значения местами, то при проверке модуль посчитает поле как изменённое. По умолчанию: проверяется поле на наличие изменений без учета очерёдности значений. '],
        [
            'MSMAIN.LOGS.OPTION_STRICT_CHECK_MULTIPLY_FIELDS',
            'Строгая проверка множественного поля',
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY_EDIT',
            'Поля для строгой проверки множества',
            '',
            [
                'multiselectbox',
                $dealFieldsOption
            ]
        ],

        //TODO сделать разрешения для редактирования определенным группам пользователя.
    ],
    'CURRENCIES'     => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
        [
            'MSMAIN.CURRENCIES.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
        Loc::getMessage('MSMAIN.MAIN.NOTIFICATION'),
        [
            'MSMAIN.CURRENCIES.OPTION_ACTIVE_NOTIFICATION_STAFF',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_ACTIVE_NOTIFICATION_STAFF'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_LIST_NOTIFICATION',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_LIST_NOTIFICATION'),
            '',
            [
                'multiselectbox',
                [
                    ''    => Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_ALL_NOTIFICATION'),
                    '409' => '[409] Sivakon Maxim'
                ]
            ]
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_NOTIFICATION_TYPE',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_NOTIFICATION_TYPE'),
            '',
            [
                'selectbox',
                [
                    'BITRIX24_MESS_PERSONAL'            => Loc::getMessage('MSMAIN.CURRENCIES.BITRIX24_MESS_PERSONAL'),
                    'BITRIX24_NOTIFI_PERSONAL'          => Loc::getMessage('MSMAIN.CURRENCIES.BITRIX24_NOTIFI_PERSONAL'),
                    'BITRIX24_NOTIFI_AND_MESS_PERSONAL' => Loc::getMessage('MSMAIN.CURRENCIES.BITRIX24_NOTIFI_AND_MESS_PERSONAL'),
                    'MAIL_NOTIFI'                       => Loc::getMessage('MSMAIN.CURRENCIES.MAIL_NOTIFI')
                ]
            ]
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION'),
            '',
            [
                'selectbox',
                [
                    '409' => '[409] Sivakon Maxim'
                ]
            ]
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION_MAIL',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION_MAIL'),
            "admin@".$SERVER_NAME, ["text", 30]
        ],

    ],
    'BACKLIGHT_DEAL' => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
        [
            'MSMAIN.BACKLIGHT_DEAL.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.BACKLIGHT_DEAL.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
    ],
    'BOTS'           => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
        [
            'MSMAIN.BOTS.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.BOTS.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
        ["note" => Loc::getMessage('MSMAIN.BOTS.NOTIFI_DEFAULT_SAVE_FIELDS')],
        [
            'MSMAIN.BOTS.OPTION_SAVE_TIMELINE',
            Loc::getMessage('MSMAIN.BOTS.OPTION_SAVE_TIMELINE'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.BOTS.OPTION_SAVE_HISTORY',
            Loc::getMessage('MSMAIN.BOTS.OPTION_SAVE_HISTORY'),
            'N',
            ['checkbox', 'N']
        ],
    ],
];

if (check_bitrix_sessid() && strlen($_POST[ 'save' ]) > 0) {
    foreach ($options as $option) {
        __AdmSettingsSaveOptions($module_id, $option);
    }
    LocalRedirect($APPLICATION->GetCurPageParam());
}

$tabControl = new CAdminTabControl('tabControl', $tabs);
$tabControl->Begin();
?>
<form method="POST" action="<?= $formAction ?>">
    <? foreach ($options as $keyOption => $option) { ?>
        <? $tabControl->BeginNextTab(); ?>
        <?= __AdmSettingsDrawList($module_id, $option); ?>
    <? } ?>
    <? $tabControl->Buttons(['btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false]); ?>
    <?= bitrix_sessid_post(); ?>
    <? $tabControl->End(); ?>
</form>
