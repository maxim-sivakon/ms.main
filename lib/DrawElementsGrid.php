<?php

namespace MS\Main;

use \Bitrix\Main;
use \MS\Main\Helpers;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Type\DateTime;

class DrawElementsGrid
{
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