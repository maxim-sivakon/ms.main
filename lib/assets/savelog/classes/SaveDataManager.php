<?php

namespace MS\Main\Assets\Savelog\Classes;

use Bitrix\Main\LoaderException;
use Bitrix\Main\Type\DateTime;

use MS\Main\Assets\Savelog\Interface\SaveLogInterface;
use MS\Main\Entity\LogsTable;
use MS\Main\Helpers;
use MS\Main\HelperFields;
use MS\Main\CTypeEventModify;

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

            global $APPLICATION;
            $resultSave = false;
            $listCodeFields = HelperFields::listCodeFields($arFieldsDeal);
            $oldFieldsDeal = Helpers::getDealData($arFieldsDeal[ 'ID' ], $listCodeFields);
            $resultCheckEvent = CTypeEventModify::checkEvent($arFieldsDeal, $oldFieldsDeal);

            $typeDevice = Helpers::detectUserDevice();
            $listCodeFields = HelperFields::listCodeFields($resultCheckEvent['FIELDS']);

            $result = [
                'NAME'                     => $resultCheckEvent['NAME'],
                'TYPE_EVENT'               => $resultCheckEvent['TYPE_EVENT'],
                'USER_CREATE_LOG'          => $arFieldsDeal[ 'MODIFY_BY_ID' ],
                'DATE_CREATE_LOG'          => new DateTime(),
                'ID_DEAL'                  => $arFieldsDeal[ 'ID' ],
                'TYPE_DEVICE'              => $typeDevice->getUserAgent(),
                'LIST_MODIFI_FIELDS'       => base64_encode(serialize($resultCheckEvent['FIELDS'])),
                'COUNT_MODIFI_FIELDS'      => count($listCodeFields),
                'LIST_MODIFI_FIELDS_VALUE' => base64_encode(serialize(HelperFields::checkingFields($oldFieldsDeal, $resultCheckEvent['FIELDS']))),
                'USER_IP'                  => $typeDevice->getHttpHeaders()["HTTP_X_FORWARDED_FOR"],
                'USER_URL'                 => $APPLICATION->GetCurPage()
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