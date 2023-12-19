<?php

namespace MS\Main\Assets\Savelog;

use MS\Main\Assets\Savelog\Classes\SaveDataManager;
use MS\Main\Assets\Savelog\Classes\SaveHistoryDeal;
use MS\Main\Assets\Savelog\Classes\SaveTimelineDeal;

class Config
{
    public static $logOption = 'OPTION_SAVE_LOG_DATAMANAGER';
}

abstract class WorkLog
{

    public static function initFactory()
    {
        switch (Config::$logOption) {
            case 'OPTION_SAVE_LOG_DATAMANAGER':
                return new SaveDataManager();
            case 'OPTION_SAVE_LOG_HISTORY':
                return new SaveHistoryDeal();
            case 'OPTION_SAVE_LOG_TIMELINE':
                return new SaveTimelineDeal();
        }
        throw new \Exception('Bad config');

    }

    abstract public function save();
}