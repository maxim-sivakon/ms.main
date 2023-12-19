<?php defined('B_PROLOG_INCLUDED') || die;
IncludeModuleLangFile(__FILE__);

if (class_exists("ms_main")) {
    return;
}


use MS\Main\Entity\LogsTable;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

class ms_main extends CModule
{
    const MODULE_ID = 'ms.main';
    var $MODULE_ID = self::MODULE_ID;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $strError  = '';

    function __construct()
    {
        $arModuleVersion = [];
        include(dirname(__FILE__).'/version.php');
        $this->MODULE_VERSION = $arModuleVersion[ 'VERSION' ];
        $this->MODULE_VERSION_DATE = $arModuleVersion[ 'VERSION_DATE' ];

        $this->MODULE_NAME = Loc::getMessage('MSMAIN.MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MSMAIN.MODULE_DESC');

        $this->PARTNER_NAME = Loc::getMessage('MSMAIN.PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('MSMAIN.PARTNER_URI');
    }

    function DoInstall()
    {
        ModuleManager::registerModule(self::MODULE_ID);

        $this->InstallDB();
        $this->InstallFiles();
        $this->InstallEvents();
    }

    function DoUninstall()
    {
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        $this->UnInstallDB();

        ModuleManager::unRegisterModule(self::MODULE_ID);
    }

    function InstallDB()
    {
        Loader::includeModule('ms.main');

        $db = Application::getConnection();

        $logsEntity = LogsTable::getEntity();
        if (!$db->isTableExists($logsEntity->getDBTableName())) {
            $logsEntity->createDbTable();
        }
    }

    function UnInstallDB()
    {
        // Не существенно в данном примере.
    }

    function InstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible("crm", "OnBeforeCrmDealUpdate", $this->MODULE_ID,
            "\\MS\\Main\\Handler\\LogHandler", "SaveLog");
    }

    function UnInstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler("crm", "OnBeforeCrmDealUpdate", $this->MODULE_ID,
            "\\MS\\Main\\Handler\\LogHandler", "SaveLog");

    }

    function InstallFiles()
    {
        $documentRoot = Application::getDocumentRoot();

        CopyDirFiles(__DIR__.'/components', $documentRoot.'/bitrix/components/ms.main/', true, true);
        CopyDirFiles(__DIR__.'/public', $documentRoot.'/ms.main/', true, true);
        CopyDirFiles(__DIR__.'/js', $documentRoot.'/bitrix/js/ms.main/', true, true);
        CopyDirFiles(__DIR__.'/css', $documentRoot.'/bitrix/css/ms.main/', true, true);

        CUrlRewriter::Add([
            'CONDITION' => '#^/ms.main/crm/logs/#',
            'RULE'      => '',
            'ID'        => 'ms.main:logs',
            'PATH'      => '/ms.main/crm/logs/index.php',
        ]);
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx('/ms.main');
        DeleteDirFilesEx('/bitrix/components/ms.main');
        DeleteDirFilesEx('/bitrix/js/ms.main');
        DeleteDirFilesEx('/bitrix/css/ms.main');

        CUrlRewriter::Delete([
            'ID'   => 'ms.main:logs',
            'PATH' => '/ms.main/crm/logs/index.php',
        ]);
    }
}