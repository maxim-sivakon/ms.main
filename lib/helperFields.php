<?php

namespace MS\Main;

use \Bitrix\Main;
use Bitrix\Main\LoaderException;

class HelperFields
{

    /**
     * Заполняем название полей в том случае если при получении полей нет название(описание) поля
     *
     * @param  array  $arFields
     * @return array
     */
    public static function addFieldName(array &$arFields): array
    {
        /**
         * Массив полей таблицы сделки, их код и название(описание).
         * Используем этот массив в том случае если при получении полей нет название(описание) поля
         *
         * @var array $arPrototypeItemDataManager
         */
        $arPrototypeItemDataManager = [
            'ID'                    => 'Идентификатор элемента',
            'XML_ID'                => 'Внешний код элемента',
            'TITLE'                 => 'Название элемента',
            'CREATED_BY'            => 'ID пользователя, создавшего элемент',
            'UPDATED_BY'            => 'ID пользователя, изменившего элемент',
            'MOVED_BY'              => 'ID пользователя, сменившего стадию элемента',
            'CREATED_TIME'          => 'Время создания элемента',
            'UPDATED_TIME'          => 'Время обновления элемента',
            'MOVED_TIME'            => 'Время смены стадии элемента',
            'CATEGORY_ID'           => 'Идентификатор направления элемента',
            'OPENED'                => 'Флаг (Доступен для всех)',
            'STAGE_ID'              => 'Строковый идентификатор стадии элемента. По умолчанию первая стадия направления',
            'PREVIOUS_STAGE_ID'     => 'Строковый идентификатор предыдущей стадии элемента',
            'BEGINDATE'             => 'Дата начала. По умолчанию дата создания',
            'CLOSEDATE'             => 'Дата окончания. По умолчанию дата создания + 7 дней',
            'COMPANY_ID'            => 'Идентификатор компании. Подробнее о связях',
            'CONTACT_ID'            => 'Идентификатор основного контакта. Подробнее о связях, также о множественных контактах',
            'OPPORTUNITY'           => 'Сумма',
            'IS_MANUAL_OPPORTUNITY' => 'Флаг (Режим расчета суммы). По умолчанию (N) - сумма рассчитывается автоматически',
            'TAX_VALUE'             => 'Идентификатор смарт-процесса',
            'CURRENCY_ID'           => 'Идентификатор валюты',
            'OPPORTUNITY_ACCOUNT'   => 'Сумма для отчетов',
            'TAX_VALUE_ACCOUNT'     => 'Сумма налогов для отчетов',
            'ACCOUNT_CURRENCY_ID'   => 'Валюты для отчетов',
            'MYCOMPANY_ID'          => 'Идентификатор моей компании',
            'SOURCE_ID'             => 'Идентификатор источника',
            'SOURCE_DESCRIPTION'    => 'Дополнительно об источнике',
            'WEBFORM_ID'            => 'Идентификатор crm-формы',
            'EXCH_RATE'             => 'Курс конвертации',
            'MOVED_BY_ID'           => 'Кем перемещена',
            'LAST_ACTIVITY_TIME'    => 'Время последнего действия',
            'LAST_ACTIVITY_BY'      => 'Кем сделано последнее действие',
            'TYPE_ID'               => 'Тип компании',
            'IS_NEW'                => 'Сделка только что создана',
            'IS_RECURRING'          => 'Флаг регулярности',
            'IS_RETURN_CUSTOMER'    => 'Сделка от существующего клиента',
            'IS_REPEATED_APPROACH'  => 'Сделка для повторного обращения',
            'PROBABILITY'           => 'Вероятность',
            'CONTACT_IDS'           => 'Контакты',
            'QUOTE_ID'              => 'Ком.пред',
            'CLOSED'                => 'Сделка закрыта',
            'COMMENTS'              => 'Комментарий',
            'ASSIGNED_BY_ID'        => 'Ответственный',
            'CREATED_BY_ID'         => 'Кем создана',
            'MODIFY_BY_ID'          => 'Кем изменена',
            'DATE_CREATE'           => 'Дата создания',
            'DATE_MODIFY'           => 'Дата изменения',
            'LEAD_ID'               => 'Лид',
            'ADDITIONAL_INFO'       => 'Дополнительная информация',
            'LOCATION_ID'           => 'Местоположение',
            'ORIGINATOR_ID'         => 'Внешний источник',
            'ORIGIN_ID'             => 'Идентификатор элемента во внешнем источнике',
            'STAGE_SEMANTIC_ID'     => 'Семантическая стадия',
            'UTM_SOURCE'            => 'Рекламная система',
            'UTM_MEDIUM'            => 'Тип трафика',
            'UTM_CAMPAIGN'          => 'Обозначение рекламной кампании',
            'UTM_CONTENT'           => 'Содержание кампании',
            'UTM_TERM'              => 'Условие поиска кампании'
        ];

        foreach ($arFields as $keyField => $field) {
            if (!$field[ 'TITLE' ] ?? !$field[ 'CAPTION' ] ?? !$field[ 'DESCRIPTION' ]) {
                $arFields[ $keyField ][ 'CAPTION' ] = $arPrototypeItemDataManager[ $keyField ] ?? "Нет названия поля [{$keyField}]";
            }
        }

        return $arFields;
    }

    /**
     * Получаем все поля сделки
     *
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

        return self::addFieldName($arDeal);
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
        asort($arDealOption, SORT_NATURAL | SORT_FLAG_CASE);

        return $arDealOption;
    }


    /**
     * Проверка множественных полей
     *
     * @param  array  $oldFields
     * @param  array  $сhangedFields
     * @return array
     */
    public static function checkingMultipleFields(array $oldFields, array $сhangedFields): array
    {
        $result = [];
        $strictMultipleFields = [
            'CONTACT_IDS', 'MODIFY_BY_ID'
        ];
        foreach ($сhangedFields as $keyField => $valueFiled) {
            if (is_array($valueFiled)) {
                $arDiffOld = array_diff_assoc($oldFields[ $keyField ], $сhangedFields[ $keyField ]);
                $arDiffNew = array_diff_assoc($сhangedFields[ $keyField ], $oldFields[ $keyField ]);
                $maxCountElement = (count($oldFields[ $keyField ]) > count($сhangedFields[ $keyField ])) ? count($oldFields[ $keyField ]) : count($сhangedFields[ $keyField ]);
                $countDeletedFiled = 0;
                $countEdiedFiled = 0;
                $countAddEdied = 0;

                for ($key = 0; $key < $maxCountElement; $key++) {
                    if (!array_key_exists($key, $arDiffOld) && array_key_exists($key, $arDiffNew)) {
                        $countAddEdied++;
                        $result[ $keyField ][ 'RESULT_CHECK' ][] = array_merge(['новое значение'],
                            [$arDiffNew[ $key ]]);
                    } elseif (!array_key_exists($key, $arDiffNew) && array_key_exists($key, $arDiffOld)) {
                        $countDeletedFiled++;
                        $result[ $keyField ][ 'RESULT_CHECK' ][] = array_merge([$arDiffOld[ $key ]],
                            ['значение удалено']);
                    } elseif (!$arDiffNew[ $key ] && !$arDiffOld[ $key ] && in_array($keyField,
                            $strictMultipleFields)) {
                        $countEdiedFiled++;
                        $result[ $keyField ][ 'TYPE_CHECK' ] = 'STRICT';
                        $result[ $keyField ][ 'RESULT_CHECK' ][] = array_merge([$oldFields[ $keyField ][ $key ]],
                            [$сhangedFields[ $keyField ][ $key ]]);
                    } elseif ($arDiffOld[ $key ] && $arDiffNew[ $key ]) {
                        $countEdiedFiled++;
                        $result[ $keyField ][ 'RESULT_CHECK' ][] = array_merge([$arDiffOld[ $key ]],
                            [$arDiffNew[ $key ]]);
                    }
                }

                $result[ $keyField ][ 'COUNT_EDIT' ] = $countEdiedFiled;
                $result[ $keyField ][ 'COUNT_DELETE' ] = $countDeletedFiled;
                $result[ $keyField ][ 'COUNT_ADD' ] = $countAddEdied;

                $countDeletedFiled = 0;
                $countEdiedFiled = 0;
                $countAddEdied = 0;
            }

        }

        return $result;
    }

    /**
     * @param  array  $oldFields
     * @param  array  $сhangedFields
     * @return array
     */
    public static function checkingFields(array $oldFields, array $сhangedFields): array
    {
        $result = [];

        foreach ($сhangedFields as $keyField => $valueFiled) {
            if (!is_array($valueFiled)) {
                if ($oldFields[ $keyField ] != $сhangedFields[ $keyField ] && !empty($oldFields[ $keyField ]) && !empty($сhangedFields[ $keyField ])) {
                    $result[ $keyField ][ 'RESULT_CHECK' ] = [$oldFields[ $keyField ], $сhangedFields[ $keyField ]];
                } elseif (empty($сhangedFields[ $keyField ])) {
                    $result[ $keyField ][ 'RESULT_CHECK' ] = [$oldFields[ $keyField ], 'значение удалено'];
                } elseif ($сhangedFields[ $keyField ] && $oldFields[ $keyField ] == '') {
                    $result[ $keyField ][ 'RESULT_CHECK' ] = ['новое значение', $oldFields[ $keyField ]];
                }
            } else {
                $result[] = self::checkingMultipleFields($oldFields, $сhangedFields);
            }
        }
        return $result;
    }

    /**
     * @param  array  $сhangedFields
     * @return array
     */
    public static function listCodeFields(array $сhangedFields): array
    {
        $result = [];

        foreach ($сhangedFields as $keyField => $valueFiled) {
            $result[] = $keyField;
        }

        return $result;
    }

}