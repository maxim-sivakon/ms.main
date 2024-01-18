<?php

namespace MS\Main;

use \Bitrix\Main;
use \Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\LoaderException;
use \Bitrix\Crm\Category\DealCategory;
use Bitrix\Conversion\Internals\MobileDetect;

class Helpers
{

    /**
     * @param  int  $userID
     * @return array
     */
    public static function getUser(int $userID = 0): bool|array
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


    //    /**
    //     * @param  int  $dealID
    //     * @param  array  $arFiledsFilter
    //     * @return array
    //     */
    //    public static function getDealData(int $dealID = 0, array $arFiledsFilter = []): array
    //    {
    //        $result = [];
    //
    //        $entityResult = \CCrmDeal::GetListEx(
    //            ['SOURCE_ID' => 'DESC'],
    //            [
    //                'ID'                => $dealID,
    //                'CHECK_PERMISSIONS' => 'N'
    //            ],
    //            false,
    //            false,
    //            $arFiledsFilter
    //        );
    //
    //        while ($entity = $entityResult->fetch()) {
    //            $result = $entity;
    //        }
    //
    //        return $result;
    //    }

    /**
     * @param  array|string  $listField
     * @return mixed
     */
    public static function formatFieldGrid(array|string $listField): mixed
    {
        $dataListField = unserialize(base64_decode($listField));
        $codes = ['OLD', 'NEW'];


        $result = '<table><tbody>';

        foreach ($dataListField as $keyField => $valueFiled) {

            $result .= '<tr><th colspan="2"><b field-code="'.$valueFiled[ 'CODE' ].'">'.$valueFiled[ 'NAME' ].':</b></th></tr>';

            foreach ($codes as $code) {
                foreach ($valueFiled[ "RESULT_COMPARISON" ][ $code ] as $key => $value) {
                    if ($code == 'OLD') {
                        $result .= '<tr><td>'.self::checkfieldData($value[ 'VALUE' ], $keyField).'</td><td>→</td>';
                    } else {
                        $result .= '<td>'.self::checkfieldData($value[ 'VALUE' ], $keyField).'</td></tr>';
                    }
                }
            }
        }
        $result .= '</tbody></table>';

        return $result;
    }



    static function checkfieldData($valueFiled, $codeFiled)
    {
        if (str_contains($codeFiled, '_BY') || str_contains($codeFiled, '_BY_ID') || $codeFiled == 'UF_CRM_1457929450' || $codeFiled == 'UF_CRM_1638197776') {

            (int) $userId = $valueFiled;

            $randCode = rand(0, 30);
            $valueFiled = \CCrmViewHelper::PrepareUserBaloonHtml(
                [
                    'PREFIX'           => "LOG_RESPONSIBLE_USER_".$userId."_".$randCode,
                    'USER_ID'          => $userId,
                    'USER_NAME'        => \CUser::FormatName(\CSite::GetNameFormat(), self::getUser((int) $userId)),
                    'USER_PROFILE_URL' => Option::get('intranet', 'path_user', '', SITE_ID).'/'
                ]
            );
        } else if($codeFiled == 'STAGE_ID'){
            $categoryEntryID = DealCategory::resolveFromStageID($valueFiled);
            $categoryInfo = DealCategory::getStageInfos($categoryEntryID)[$valueFiled];
            $valueFiled = '<div style="color:' . self::detectLightDarkColor($categoryInfo['COLOR']) . ';background-color:'.$categoryInfo['COLOR'].'!important;padding: 4px 8px;border-radius: 5px;font-weight: 600;">'. $categoryInfo['NAME'] .'</div>';
        }
        return $valueFiled;
    }



    public static function detectLightDarkColor(string $hexa) : string{
        $r = hexdec(substr($hexa,1,2));
        $g = hexdec(substr($hexa,3,2));
        $b = hexdec(substr($hexa,5,2));
        $luminosidade = ( $r * 299 + $g * 587 + $b * 114) / 1000;
        $returnPriorityColor = "white";

        if( $luminosidade > 128 ) {
            $returnPriorityColor = "black";
        }

        return $returnPriorityColor;
    }

    public static function drawTableComparisonFields(array|string $listField): mixed
    {
        $dataListField = unserialize(base64_decode($listField));
        $codes = ['OLD', 'NEW'];


        $result = '<table><tbody>';

        foreach ($dataListField as $keyField => $valueFiled) {

            $result .= '<tr><th colspan="2"><b field-code="'.$valueFiled[ 'CODE' ].'">'.$valueFiled[ 'NAME' ].':</b></th></tr>';

            foreach ($codes as $code) {
                foreach ($valueFiled[ "RESULT_COMPARISON" ][ $code ] as $key => $value) {
                    if ($code == 'OLD') {
                        $result .= '<tr><td>'.self::checkfieldData($value[ 'VALUE' ], $keyField).'</td><td>→</td>';
                    } else {
                        $result .= '<td>'.self::checkfieldData($value[ 'VALUE' ], $keyField).'</td></tr>';
                    }
                }
            }
        }
        $result .= '</tbody></table>';

        return $result;
    }


}


