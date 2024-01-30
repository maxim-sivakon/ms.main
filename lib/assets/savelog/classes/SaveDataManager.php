<?php

namespace MS\Main\Assets\Savelog\Classes;

use Bitrix\Main\LoaderException;
use Bitrix\Main\Type\DateTime;

use MS\Main\Assets\Savelog\Interface\SaveLogInterface;
use MS\Main\Entity\LogsTable;
use MS\Main\NFDS;

class SaveDataManager implements SaveLogInterface
{
    /**
     * @param  array  $arFieldsDeal
     * @return bool|int
     * @throws LoaderException
     */
    public function save(array $arFieldsDeal): bool|int
    {
        if ($arFieldsDeal[ 'MODIFY_BY_ID' ] > 0) {
            $objResult =  new NFDS($arFieldsDeal);
            $checkResult =  $objResult->cook();
            $result = [
                'ID_DEAL'                  => $checkResult[ 'ID_DEAL' ],
                'NAME'                     => $checkResult['NAME'],
                'TYPE_EVENT'               => $checkResult['TYPE_EVENT'],
                'USER_CREATE_LOG'          => $checkResult[ 'MODIFY_BY_ID' ],
                'DATE_CREATE_LOG'          => new DateTime(),
                'TYPE_DEVICE'              => $checkResult['TYPE_DEVICE'],
                'LIST_MODIFI_FIELDS'       => $checkResult['OLD_DATA'],
                'COUNT_MODIFI_FIELDS'      => $checkResult['COUNT_MODIFI_FIELDS'],
                'LIST_MODIFI_FIELDS_VALUE' => $checkResult['DATA'],
                'USER_IP'                  => $checkResult["USER_IP"],
                'USER_URL'                 => ''
            ];

            $id = 0;
            $result = LogsTable::add($result);

            if ($result->isSuccess()) {
                $id = $result->getId();
            }
        }

        return true;
    }

}