<?php

namespace MS\Main\Assets\Savelog\Classes;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Type\DateTime;

use MS\Main\Assets\Savelog\Interface\SaveLogInterface;
use MS\Main\Entity\LogsTable;

class SaveDataManager implements SaveLogInterface
{
    /**
     * @param  array  $arFieldsDeal
     * @return bool|int
     * @throws LoaderException
     */
    public function save(array $arFieldsDeal): bool|int
    {
        $resultSave = false;

        if ($arFieldsDeal[ 'MODIFY_BY_ID' ]) {
            Loader::includeModule('crm');

            $result = [
                'NAME'                     => 'Text event',
                'TYPE_EVENT'               => 'test',
                'USER_CREATE_LOG'          => $arFieldsDeal[ 'MODIFY_BY_ID' ],
                'DATE_CREATE_LOG'          => new DateTime(),
                'ID_DEAL'                  => $arFieldsDeal[ 'ID' ],
                'TYPE_DEVICE'              => 'mac',
                'LIST_MODIFI_FIELDS'       => serialize($arFieldsDeal),
                'COUNT_MODIFI_FIELDS'      => count($arFieldsDeal),
                'LIST_MODIFI_FIELDS_VALUE' => serialize($arFieldsDeal),
                'USER_IP'                  => '0.0.0.0',
                'USER_URL'                 => 'yyy.ru'
            ];

            $id = 0;
            $result = LogsTable::add($result);
            if ($result->isSuccess()) {
                $id = $result->getId();
            }
            var_dump($arFieldsDeal);
            die();

        }

        return true;
    }

}