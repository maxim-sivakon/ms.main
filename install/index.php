<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (class_exists('tk_main'))
{
    return;
}

class tk_main extends CModule
{
    var $MODULE_ID           = "tk.main";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";

    public function __construct()
    {
        $arModuleVersion = [];

        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion[ "VERSION" ];
        $this->MODULE_VERSION_DATE = $arModuleVersion[ "VERSION_DATE" ];

        $this->MODULE_NAME = Loc::getMessage("TK_MAIN_INSTALL_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("TK_MAIN_INSTALL_DESCRIPTION");
    }


    function InstallDB()
    {

        global $DB, $APPLICATION;
        $connection = \Bitrix\Main\Application::getConnection();
        $errors = null;

        if (!$DB->TableExists('b_tk_main'))
        {
            $errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/db/' . strtolower($connection->getType()) . '/install.sql');
        }

//        var_dump($errors);
//        die();

        if (!empty($errors))
        {
            $APPLICATION->ThrowException(implode("", $errors));
            return false;
        }

        RegisterModule($this->MODULE_ID);

        return true;
    }

    function UnInstallDB()
    {
        global $DB, $APPLICATION;
        $connection = \Bitrix\Main\Application::getConnection();
        $errors = null;


            $errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . $this->MODULE_ID . "/install/db/".strtolower($connection->getType())."/uninstall.sql");

            if (!empty($errors))
            {
                $APPLICATION->ThrowException(implode("", $errors));
                return false;
            }
            \Bitrix\Main\Config\Option::delete($this->MODULE_ID);


        UnRegisterModule($this->MODULE_ID);

        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        // перемещаем файлы в публичную часть
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/public', $_SERVER['DOCUMENT_ROOT'] . '/', true, true);

        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/public', $_SERVER['DOCUMENT_ROOT'] . '/');
        return true;
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB();
    }

    function DoUninstall()
    {
        $this->UnInstallFiles();
        $this->UnInstallDB();
    }
}

?>