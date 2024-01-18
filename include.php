<?php
IncludeModuleLangFile(__FILE__);

CModule::AddAutoloadClasses(
    'ms.main',
    [
        "MS\Main\NFDS"               => "lib/NFDS.php",
        "MS\Main\Helpers"               => "lib/helpers.php",
        "MS\\Main\\Handler\\LogHandler" => "lib/handler/logHandler.php",

        "MS\Main\Assets\Savelog\Config"                     => "lib/assets/savelog/workLog.php",
        "MS\Main\Assets\Savelog\WorkLog"                    => "lib/assets/savelog/workLog.php",
        "MS\Main\Assets\Savelog\Interface\SaveLogInterface" => "lib/assets/savelog/interface/SaveLogInterface.php",
        "MS\Main\Assets\Savelog\Interface\LogInterface"     => "lib/assets/savelog/interface/LogInterface.php",
        "MS\Main\Assets\Savelog\Classes\LogFactory"         => "lib/assets/savelog/classes/LogFactory.php",
        "MS\Main\Assets\Savelog\Classes\SaveDataManager"    => "lib/assets/savelog/classes/SaveDataManager.php",
        "MS\Main\Assets\Savelog\Classes\SaveHistoryDeal"    => "lib/assets/savelog/classes/SaveHistoryDeal.php",
        "MS\Main\Assets\Savelog\Classes\SaveTimelineDeal"   => "lib/assets/savelog/classes/SaveTimelineDeal.php",
    ]
);
