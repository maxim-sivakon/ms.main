<?php
defined('B_PROLOG_INCLUDED') || die;

use MS\Main\Entity\LogsTable;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

class CMsMainLogsShowComponent extends CBitrixComponent
{
    const FORM_ID = 'LOGS_SHOW';

    public function __construct(CBitrixComponent $component = null)
    {
        parent::__construct($component);

        CBitrixComponent::includeComponentClass('ms.main:logs.list');
        CBitrixComponent::includeComponentClass('ms.main:logs.edit');
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $APPLICATION->SetTitle(Loc::getMessage('CRMSTORES_SHOW_TITLE_DEFAULT'));

        if (!Loader::includeModule('ms.main')) {
            ShowError(Loc::getMessage('CRMSTORES_NO_MODULE'));
            return;
        }

        $dbLog = LogsTable::getById($this->arParams[ 'LOG_ID' ]);
        $log = $dbLog->fetch();

        if (empty($log)) {
            ShowError(Loc::getMessage('CRMSTORES_STORE_NOT_FOUND'));
            return;
        }

        $APPLICATION->SetTitle(Loc::getMessage(
            'CRMSTORES_SHOW_TITLE',
            [
                '#ID#'   => $log[ 'ID' ],
                '#NAME#' => $log[ 'NAME' ]
            ]
        ));

        $this->arResult = [
            'FORM_ID'         => self::FORM_ID,
            'TACTILE_FORM_ID' => CMsMainLogsEditComponent::FORM_ID,
            'GRID_ID'         => CMsMainLogsListComponent::GRID_ID,
            'STORE'           => $log
        ];

        $this->includeComponentTemplate();
    }
}