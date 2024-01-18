<?php

namespace MS\Main\Assets\Savelog\Classes;

use Bitrix\Main\LoaderException;
use Bitrix\Main\Type\DateTime;

use MS\Main\Assets\Savelog\Interface\SaveLogInterface;
use MS\Main\Entity\LogsTable;
use MS\Main\NFDS;





//use MS\Main\Helpers;
//use MS\Main\HelperFields;
//use MS\Main\CTypeEventModify;

class SaveDataManager implements SaveLogInterface
{
    /**
     * @param  array  $arFieldsDeal
     * @return bool|int
     * @throws LoaderException
     */
    public function save(array $arFieldsDeal): bool|int
    {


        //TODO создать отдельный класс - позовляющий запустить алгоритм обработки массива под логирование



        if ($arFieldsDeal[ 'MODIFY_BY_ID' ] > 0) {

//            global $APPLICATION;
//            $resultSave = false;

//
//            $arFieldsDeal = HelperFields::checkLimitKeyField($arFieldsDeal);
//            $listCodeFields = HelperFields::listCodeFields($arFieldsDeal);
//            $oldFieldsDeal = Helpers::getDealData($arFieldsDeal[ 'ID' ], $listCodeFields);
//
//            $typeDevice = Helpers::detectUserDevice();
//            $listCodeFields = HelperFields::listCodeFields($resultCheckEvent['FIELDS']);
//
//            $superRes = HelperFields::checkingFields($oldFieldsDeal, $resultCheckEvent['FIELDS']);


            $checkResult =  new NFDS($arFieldsDeal);
            $result = $checkResult->arrayProcessing();





            $result = [
                'ID_DEAL'                  => $result[ 'ID_DEAL' ],
                'NAME'                     => $result['NAME'],
                'TYPE_EVENT'               => $result['TYPE_EVENT'],
                'USER_CREATE_LOG'          => $result[ 'MODIFY_BY_ID' ],
                'DATE_CREATE_LOG'          => new DateTime(),
                'TYPE_DEVICE'              => $result['TYPE_DEVICE'],
                'LIST_MODIFI_FIELDS'       => $result['OLD_DATA'],
                'COUNT_MODIFI_FIELDS'      => $result['COUNT_MODIFI_FIELDS'],
                'LIST_MODIFI_FIELDS_VALUE' => $result['DATA'],
                'USER_IP'                  => $result["USER_IP"],
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