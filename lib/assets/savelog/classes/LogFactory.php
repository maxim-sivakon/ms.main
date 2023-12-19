<?php

namespace MS\Main\Assets\Savelog\Classes;

use MS\Main\Assets\Savelog\Classes\SaveDataManager;
use MS\Main\Assets\Savelog\Classes\SaveHistoryDeal;
use MS\Main\Assets\Savelog\Classes\SaveTimelineDeal;
use MS\Main\Assets\Savelog\Interface\SaveLogInterface;
use MS\Main\Assets\Savelog\Interface\LogInterface;

class LogFactory implements LogInterface
{
    public function createLogDataManages(): SaveLogInterface
    {
        return new SaveDataManager();
    }

    public function createHistoryDeal(): SaveLogInterface
    {
        return new SaveTimelineDeal();
    }

    public function createTimelineDeal(): SaveLogInterface
    {
        return new SaveHistoryDeal();
    }
}