<?php

namespace MS\Main;

use \Bitrix\Main;
use \Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Conversion\Internals\MobileDetect;

class Helpers
{

    /**
     * @param  int  $userID
     * @return array
     */
    public static function getUser(int $userID = 0): array
    {
        return \CUser::GetByID($userID)->Fetch();
    }

    /**
     * @return MobileDetect
     * @throws LoaderException
     */
    public static function detectUserDevice(): object
    {
        $isMobile = Loader::includeModule('conversion') && ($md = new MobileDetect) && $md->isMobile();
        return $md;
    }

    /**
     * @return array
     */
    public static function getGroupOption(): array
    {
        $arGroups = [];
        $arGroups = CGroup::GetList('', '', ["ACTIVE" => "Y", "ADMIN" => "N", "ANONYMOUS" => "N"]);
        while ($group = $arGroups->Fetch()) {
            $ar = [];
            $ar[ "ID" ] = intval($group[ "ID" ]);
            $ar[ "NAME" ] = htmlspecialcharsbx($group[ "NAME" ]);
            $arGroups[ $group[ "ID" ] ] = $group[ "NAME" ]." [".$group[ "ID" ]."]";
        }

        return $arGroups;
    }


    /**
     * @param  int  $dealID
     * @param  array  $arFiledsFilter
     * @return array
     */
    public static function getDealData(int $dealID = 0, array $arFiledsFilter = []): array
    {
        $result = [];

        $entityResult = \CCrmDeal::GetListEx(
            ['SOURCE_ID' => 'DESC'],
            [
                'ID'                => $dealID,
                'CHECK_PERMISSIONS' => 'N'
            ],
            false,
            false,
            $arFiledsFilter
        );

        while ($entity = $entityResult->fetch()) {
            $result = $entity;
        }

        return $result;
    }

}