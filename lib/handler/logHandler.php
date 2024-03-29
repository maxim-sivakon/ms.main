<?php

namespace MS\Main\Handler;

use Bitrix\Main\LoaderException;
use MS\Main\Assets\Savelog\Config;
use MS\Main\Assets\Savelog\WorkLog;

class logHandler
{

    /**
     * @param $arFields
     * @return mixed
     * @throws LoaderException
     */
    public static function SaveLog(&$arFields)
    {
        $result = false;
        $workLog = \COption::GetOptionString("ms.main", "MSMAIN.LOGS.OPTION_ACTIVE", "");
        $workLog = 'Y';
        if ($workLog === "Y") {

            $logOptions = [
                'OPTION_SAVE_LOG_DATAMANAGER' => 'Y',
//                'OPTION_SAVE_LOG_HISTORY'     => 'N',
//                'OPTION_SAVE_LOG_TIMELINE'    => 'N'
            ];

            foreach ($logOptions as $keyOption => $valueOption) {
                if ($valueOption === 'Y') {
                    try {
                        Config::$logOption = $keyOption;
                        WorkLog::initFactory()->save($arFields);
                    } catch (\Bitrix\Main\SystemException $e) {
                        $error = true;
                        $e->getMessage();
                    }
                }
            }

        }

        return $arFields;
    }

}