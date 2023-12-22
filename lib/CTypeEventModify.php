<?php

namespace MS\Main;

class CTypeEventModify
{

    public static function checkEvent(array &$arFields, array $oldFieldsDeal): array
    {
        $result = [
            'NAME'       => 'Сделка отредактирована #'.$arFields[ 'ID' ],
            'TYPE_EVENT' => 'EDIT_DEAL',
            'FIELDS'     => $arFields
        ];

        if (array_key_exists('STAGE_ID', $arFields)) {
            if ($oldFieldsDeal[ 'STAGE_ID' ] != $arFields[ 'STAGE_ID' ]) {
                $tmpStage = $arFields[ 'STAGE_ID' ];
                $result[ 'TYPE_CHECK' ] = 'MODIFY_STAGE';
                $result[ 'FIELDS' ][][ 'STAGE_ID' ] = $arFields[ 'STAGE_ID' ];
                $result = [
                    'NAME'       => 'Смена стадии в сделке #'.$arFields[ 'ID' ],
                    'TYPE_EVENT' => 'EDIT_DEAL_STAGE',
                    'FIELDS'     => [
                        'STAGE_ID' => $arFields[ 'STAGE_ID' ]
                    ]
                ];
            }
        }

        return $result;
    }

}