<?php

namespace MS\Main;

use \Bitrix\Main;
use Bitrix\Main\LoaderException;

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
     * @return array|null
     * @throws LoaderException
     */
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

    /**
     * @return array|null
     */
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
            [
                'ID',
                'TITLE',
                'STAGE_ID',
                $arFiledsFilter
            ]
        );

        while ($entity = $entityResult->fetch()) {
            $result = $entity;
        }

        return $result;
    }

    /**
     * preparing an array for storage in databases
     *
     * @param  array  $oldFields
     * @param  array  $сhangedFields
     * @return array
     */
    public static function normalizationFields(array $oldFields, array $сhangedFields): array
    {
        $result = [];
        $fullListFields = self::getDealFieldsOption();

        foreach ($сhangedFields as $keyFiled => $valueFiled) {
            $result[ 'NEW' ][] = [
                'NAME'  => $fullListFields[ $keyFiled ],
                'CODE'  => $keyFiled,
                'VALUE' => $valueFiled
            ];
        }

        foreach ($oldFields as $keyFiled => $valueFiled) {
            $result[ 'OLD' ][] = [
                'NAME'  => $fullListFields[ $keyFiled ],
                'CODE'  => $keyFiled,
                'VALUE' => $valueFiled
            ];
        }


        return $result;
    }

}