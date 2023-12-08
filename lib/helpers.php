<?php

namespace MS\Main;

use \Bitrix\Main;

class Helpers
{

    public static function getUser(int $userID = 0): array
    {
        return \CUser::GetByID($userID)->Fetch();
    }

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

    public static function getDealFields(): ?array
    {
        global $USER_FIELD_MANAGER;
        $arDeal = [];

        if (\Bitrix\Main\Loader::IncludeModule('crm')) {
            $arDeal = \CCrmDeal::GetFieldsInfo();

            foreach ($arDeal as $code => &$field) {
                $field[ 'CAPTION' ] = \CCrmDeal::GetFieldCaption($code);
            }

            $userType = new \CCrmUserType(
                $USER_FIELD_MANAGER,
                \CCrmDeal::$sUFEntityID
            );
            $userType->PrepareFieldsInfo($arDeal);

        }

        return $arDeal;
    }

    public static function getDealFieldsOption(): ?array
    {
        $arDealOption = [];
        $arDealFields = self::getDealFields();

        foreach ($arDealFields as $keyField => $field) {
            if ($field[ 'TITLE' ] ?? $field[ 'CAPTION' ] ?? $field[ 'DESCRIPTION' ]) {
                $arDealOption += [
                    $keyField => $field[ 'TITLE' ] ?? $field[ 'CAPTION' ] ?? $field[ 'DESCRIPTION' ],
                ];
            }
        }

        return $arDealOption;
    }

}