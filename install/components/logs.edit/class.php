<?php
defined('B_PROLOG_INCLUDED') || die;

use MS\Main\Entity\LogsTable;

use Bitrix\Main\Context;
use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UserTable;

class CMsMainLogsEditComponent extends CBitrixComponent
{
    const FORM_ID = 'LOGS_EDIT';

    private $errors;

    public function __construct(CBitrixComponent $component = null)
    {
        parent::__construct($component);

        $this->errors = new ErrorCollection();

        CBitrixComponent::includeComponentClass('ms.main:logs.list');
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $title = Loc::getMessage('CRMSTORES_SHOW_TITLE_DEFAULT');

        if (!Loader::includeModule('ms.main')) {
            ShowError(Loc::getMessage('CRMSTORES_NO_MODULE'));
            return;
        }

        $log = [
            'NAME'           => '',
            'ADDRESS'        => '',
            'ASSIGNED_BY_ID' => 0
        ];

        if (intval($this->arParams[ 'LOG_ID' ]) > 0) {
            $dbLog = LogsTable::getById($this->arParams[ 'LOG_ID' ]);
            $log = $dbLog->fetch();

            if (empty($log)) {
                ShowError(Loc::getMessage('CRMSTORES_STORE_NOT_FOUND'));
                return;
            }
        }

        if (!empty($log[ 'ID' ])) {
            $title = Loc::getMessage(
                'CRMSTORES_SHOW_TITLE',
                [
                    '#ID#'   => $store[ 'ID' ],
                    '#NAME#' => $store[ 'NAME' ]
                ]
            );
        }

        $APPLICATION->SetTitle($title);

        if (self::isFormSubmitted()) {
            $savedStoreId = $this->processSave($log);
            if ($savedLogId > 0) {
                LocalRedirect($this->getRedirectUrl($savedLogId));
            }

            $submittedLog = $this->getSubmittedStore();
            $log = array_merge($log, $submittedLog);
        }

        $this->arResult = [
            'FORM_ID'  => self::FORM_ID,
            'GRID_ID'  => CMsMainLogsListComponent::GRID_ID,
            'IS_NEW'   => empty($log[ 'ID' ]),
            'TITLE'    => $title,
            'STORE'    => $log,
            'BACK_URL' => $this->getRedirectUrl(),
            'ERRORS'   => $this->errors,
        ];

        $this->includeComponentTemplate();
    }

    private function processSave($initialLog)
    {
        $submittedLog = $this->getSubmittedStore();

        $log = array_merge($initialLog, $submittedLog);

        $this->errors = self::validate($log);

        if (!$this->errors->isEmpty()) {
            return false;
        }

        if (!empty($log[ 'ID' ])) {
            $result = LogsTable::update($log[ 'ID' ], $log);
        } else {
            $result = LogsTable::add($log);
        }

        if (!$result->isSuccess()) {
            $this->errors->add($result->getErrors());
        }

        return $result->isSuccess() ? $result->getId() : false;
    }

    private function getSubmittedStore()
    {
        $context = Context::getCurrent();
        $request = $context->getRequest();

        $submittedLog = [
            'NAME'           => $request->get('NAME'),
            'ASSIGNED_BY_ID' => $request->get('ASSIGNED_BY_ID'),
        ];

        return $submittedLog;
    }

    private static function validate($log)
    {
        $errors = new ErrorCollection();

        if (empty($log[ 'NAME' ])) {
            $errors->setError(new Error(Loc::getMessage('CRMSTORES_ERROR_EMPTY_NAME')));
        }

        if (empty($log[ 'ASSIGNED_BY_ID' ])) {
            $errors->setError(new Error(Loc::getMessage('CRMSTORES_ERROR_EMPTY_ASSIGNED_BY_ID')));
        } else {
            $dbUser = UserTable::getById($log[ 'ASSIGNED_BY_ID' ]);
            if ($dbUser->getSelectedRowsCount() <= 0) {
                $errors->setError(new Error(Loc::getMessage('CRMSTORES_ERROR_UNKNOWN_ASSIGNED_BY_ID')));
            }
        }

        return $errors;
    }

    private static function isFormSubmitted()
    {
        $context = Context::getCurrent();
        $request = $context->getRequest();
        $saveAndView = $request->get('saveAndView');
        $saveAndAdd = $request->get('saveAndAdd');
        $apply = $request->get('apply');
        return !empty($saveAndView) || !empty($saveAndAdd) || !empty($apply);
    }

    private function getRedirectUrl($savedLogId = null)
    {
        $context = Context::getCurrent();
        $request = $context->getRequest();

        if (!empty($savedLogId) && $request->offsetExists('apply')) {
            return CComponentEngine::makePathFromTemplate(
                $this->arParams[ 'URL_TEMPLATES' ][ 'EDIT' ],
                ['LOG_ID' => $savedLogId]
            );
        } elseif (!empty($savedLogId) && $request->offsetExists('saveAndAdd')) {
            return CComponentEngine::makePathFromTemplate(
                $this->arParams[ 'URL_TEMPLATES' ][ 'EDIT' ],
                ['LOG_ID' => 0]
            );
        }

        $backUrl = $request->get('backurl');
        if (!empty($backUrl)) {
            return $backUrl;
        }

        if (!empty($savedLogId) && $request->offsetExists('saveAndView')) {
            return CComponentEngine::makePathFromTemplate(
                $this->arParams[ 'URL_TEMPLATES' ][ 'DETAIL' ],
                ['LOG_ID' => $savedLogId]
            );
        } else {
            return $this->arParams[ 'SEF_FOLDER' ];
        }
    }
}