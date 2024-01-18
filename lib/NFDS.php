<?php

namespace MS\Main;

use \Bitrix\Main;
use \MS\Main\Helpers;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Type\DateTime;

/*
 * Normalization of the data structures of the array fields while saving the transaction.
 * Preparing an array for storing and verifying data in the module.
 */

class NFDS
{
    // TODO ПРЕДУСМОТРЕТЬ ВОЗМОЖНОСТЬ ОТПРАВКИ УВЕДОМЛЕНИЙ ПОЧТА/ТЕЛЕГРАМ БОТ И ПРОЧЕЕ. ТО ЕСТЬ РЕАЛИЗОВАТЬ КЛАСС, КОТОРЫЙ ПОЗВОЛИТ ДЕЛАТЬ ОТПРАВКУ ВСЕХ УВЕДОМЛЕНИЙ. СВЯЗАТЬ МЕЖДУ СОБОЙ ОБА КЛАССА СОГЛАСНО НАСТРОЙКАМ СИСТЕМЫ.
    private array $beforeChangingFields;
    private array $currentModifiedFields;
    private array $listFields;
    private const MAP_FILED_NAME              = [
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
    private const STRICT_MULTIPLE_FIELDS      = ['UF_CRM_1600310015'];
    private const IGNORING_FIELDS_LIMIT_CHECK = [
        'ID', 'XML_ID', 'CREATED_BY', 'UPDATED_BY', 'MOVED_BY', 'CATEGORY_ID', 'STAGE_ID', 'PREVIOUS_STAGE_ID',
        'COMPANY_ID', 'CONTACT_ID', 'CURRENCY_ID', 'ACCOUNT_CURRENCY_ID', 'MYCOMPANY_ID', 'SOURCE_ID',
        'WEBFORM_ID', 'MOVED_BY_ID', 'TYPE_ID', 'CONTACT_IDS', 'QUOTE_ID', 'ASSIGNED_BY_ID', 'CREATED_BY_ID',
        'MODIFY_BY_ID', 'LEAD_ID', 'LOCATION_ID', 'ORIGINATOR_ID', 'ORIGIN_ID', 'STAGE_SEMANTIC_ID'
    ];

    public function __construct($currentModifiedFields)
    {
        if (array_key_exists('ID', $currentModifiedFields)) {
            if (\Bitrix\Main\Loader::IncludeModule('crm')) {
                $this->currentModifiedFields = self::checkLimitKeyField($currentModifiedFields);
                $this->beforeChangingFields = self::getDeal((int) $this->currentModifiedFields[ 'ID' ],
                    $this->currentModifiedFields);
                $this->listFields = self::getDealFields();

                return $this->arrayProcessing();

            } else {
                throw new \Exception('No include module crm.');
            }
        } else {
            throw new \Exception('No ID deal.');
        }
    }

    private function checkLimitKeyField(?array &$arFields): array
    {
        $result = [];
        $checkChar = ['~'];

        foreach ($checkChar as $valueChar) {
            foreach ($arFields as $keyField => $valueField) {
                $result[ mb_substr($keyField, 0, 1, "UTF-8") == $valueChar ? substr($keyField,
                    1) : $keyField ] = $valueField;
            }
        }

        return $result;
    }

    private static function getDeal(int $dealID = 0, array $arFiledsFilter = []): ?array
    {
        $arResult = [];

        $entityResult = \CCrmDeal::GetListEx(
            ['SOURCE_ID' => 'DESC'],
            [
                'ID'                => $dealID,
                'CHECK_PERMISSIONS' => 'N'
            ],
            false,
            false,
            array_keys($arFiledsFilter)
        );

        while ($entity = $entityResult->fetch()) {
            $arResult = $entity;
        }

        return $arResult;
    }

    private static function getDealFields(): ?array
    {
        global $USER_FIELD_MANAGER;
        $arDeal = [];

        $arDeal = \CCrmDeal::GetFieldsInfo();

        foreach ($arDeal as $code => &$field) {
            $field[ 'CAPTION' ] = \CCrmDeal::GetFieldCaption($code);
        }

        $userType = new \CCrmUserType(
            $USER_FIELD_MANAGER,
            \CCrmDeal::$sUFEntityID
        );
        $userType->PrepareFieldsInfo($arDeal);

        foreach ($arDeal as $keyField => $valueField) {
            if ($valueField[ 'TITLE' ]) {
                $arDeal[ $keyField ][ 'NAME' ] = $valueField[ 'TITLE' ];
            } elseif ($valueField[ 'CAPTION' ]) {
                $arDeal[ $keyField ][ 'NAME' ] = $valueField[ 'CAPTION' ];
            } elseif ($valueField[ 'DESCRIPTION' ]) {
                $arDeal[ $keyField ][ 'NAME' ] = $valueField[ 'DESCRIPTION' ];
            } elseif (self::MAP_FILED_NAME[ $keyField ]) {
                $arDeal[ $keyField ][ 'NAME' ] = self::MAP_FILED_NAME[ $keyField ];
            } else {
                $arDeal[ $keyField ][ 'NAME' ] = "Нет названия поля [{$keyField}]";
            }
        }
        return $arDeal;
    }

    private function checkingInt(null|string|int $variable): ?int
    {
        return is_numeric($variable) || is_int($variable) ? (int) $variable : null;
    }

    private function checkLimitValueField(?string $valueField, string $keyField): string
    {
        if (!array_search($keyField, self::IGNORING_FIELDS_LIMIT_CHECK)) {
            switch ($valueField) {
                case '1':
                case 'Y':
                    $valueField = 'да';
                    break;
                case '0':
                case 'N':
                    $valueField = 'нет';
                    break;
                case 'now()':
                    $valueField = new DateTime();
                default:
                    $valueField = $valueField ?? 'пустое значение';
            }
        }
        return $valueField;
    }

    private function checkingFields(): ?array
    {
        $result = [];

        foreach ($this->currentModifiedFields as $keyField => $valueFiled) {
            $beforeChangingFields = $this->beforeChangingFields[ $keyField ];
            $currentModifiedFields = $this->currentModifiedFields[ $keyField ];

            if (is_array($valueFiled)) {
                $result += self::checkingMultipleFields($valueFiled);
            } else {
                $beforeChangingFields_isInt = self::checkingInt($beforeChangingFields);
                $currentModifiedFields_isInt = self::checkingInt($currentModifiedFields);

                if ((string) $currentModifiedFields !== (string) $beforeChangingFields) {
                    $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                    $result[ $keyField ][ 'RESULT_CHECK' ][] = [
                        'OLD' => ['VALUE' => $beforeChangingFields, 'ID' => $beforeChangingFields_isInt],
                        'NEW' => ['VALUE' => $currentModifiedFields, 'ID' => $currentModifiedFields_isInt]
                    ];
                } elseif (empty((string) $currentModifiedFields)) {
                    $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                    $result[ $keyField ][ 'RESULT_CHECK' ][] = [
                        'OLD' => ['VALUE' => $beforeChangingFields, 'ID' => $beforeChangingFields_isInt],
                        'NEW' => 'удалено значение'
                    ];
                } elseif ((string) $currentModifiedFields && (string) $beforeChangingFields == '') {
                    $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                    $result[ $keyField ][ 'RESULT_CHECK' ][] = [
                        'OLD' => 'новое значение',
                        'NEW' => ['VALUE' => $currentModifiedFields, 'ID' => $currentModifiedFields_isInt]
                    ];
                }
            }
        }

        return $result;
    }

    private function checkingMultipleFields(): ?array
    {
        $result = [];

        foreach ($this->currentModifiedFields as $keyField => $valueFiled) {
            if (is_array($valueFiled)) {

                $beforeChangingFields = $this->beforeChangingFields[ $keyField ];
                $currentModifiedFields = $this->currentModifiedFields[ $keyField ];

                $beforeDiffChangingField = array_diff_assoc($beforeChangingFields, $currentModifiedFields);
                $currentDiffModifiedFields = array_diff_assoc($currentModifiedFields, $beforeChangingFields);

                $maxCountElement = max(count($beforeChangingFields), count($currentModifiedFields));
                $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                $exRes = [];
                for ($key = 0; $key < $maxCountElement; $key++) {
                    if (in_array($keyField, self::STRICT_MULTIPLE_FIELDS)) {
                        $exRes[ 'OLD' ][] = [
                            'VALUE' => $beforeChangingFields[ $key ] ?? 'новое значение',
                            'ID'    => self::checkingInt($beforeChangingFields[ $key ])
                        ];
                        $exRes[ 'NEW' ][] = [
                            'VALUE' => $currentModifiedFields[ $key ] ?? 'удалено значение',
                            'ID'    => self::checkingInt($currentModifiedFields[ $key ])
                        ];
                    } elseif (!array_key_exists($key, $beforeDiffChangingField) && array_key_exists($key,
                            $currentDiffModifiedFields)) {
                        $exRes[ 'OLD' ] = 'новое значение';
                        $exRes[ 'NEW' ][] = [
                            'VALUE' => $currentDiffModifiedFields[ $key ],
                            'ID'    => self::checkingInt($currentDiffModifiedFields[ $key ])
                        ];
                    } elseif (!array_key_exists($key, $currentDiffModifiedFields) && array_key_exists($key,
                            $beforeDiffChangingField)) {
                        $exRes[ 'OLD' ][] = [
                            'VALUE' => $beforeDiffChangingField[ $key ],
                            'ID'    => self::checkingInt($beforeDiffChangingField[ $key ])
                        ];
                        $exRes[ 'NEW' ][] = 'удалено значение';
                    } elseif ($beforeDiffChangingField[ $key ] && $currentDiffModifiedFields[ $key ]) {
                        $exRes[ 'OLD' ][] = [
                            'VALUE' => $beforeDiffChangingField[ $key ],
                            'ID'    => self::checkingInt($beforeDiffChangingField[ $key ])
                        ];
                        $exRes[ 'NEW' ][] = [
                            'VALUE' => $currentModifiedFields[ $key ],
                            'ID'    => self::checkingInt($currentModifiedFields[ $key ])
                        ];
                    }
                }
                $result[ $keyField ][ 'RESULT_CHECK' ][] = $exRes;
            }
        }

        return $result;
    }

    private function fillMultipleFieldID(array $preFinishDealFields): ?array
    {
        $finalResult = [];

        foreach ($preFinishDealFields as $keyField => $valueFiled) {
            $finalResult[ $keyField ][ 'NAME' ] = $valueFiled[ 'NAME' ];
            $finalResult[ $keyField ][ 'CODE' ] = $keyField;
            $keyEx = array_key_exists(0,
                $valueFiled[ 'RESULT_CHECK' ]) ? $valueFiled[ 'RESULT_CHECK' ][ 0 ] : $valueFiled[ 'RESULT_CHECK' ];
            foreach ($keyEx as $keyResult => $valueResult) {

                $checker = false;
                if (!is_string($valueResult) && array_key_exists(0, $valueResult)) {
                    $checker = true;
                }

                if ($checker) {
                    foreach ($valueResult as $valueResultKey => $valueResultItem) {
                        if (!is_null($valueResultItem[ 'ID' ]) && array_key_exists('ITEMS',
                                $this->listFields[ $keyField ])) {
                            foreach ($this->listFields[ $keyField ][ 'ITEMS' ] as $keyListFields => $valueListFields) {
                                if ((int) $valueListFields[ 'ID' ] === $valueResultItem[ 'ID' ]) {
                                    $finalResult[ $keyField ][ 'RESULT_COMPARISON' ][ $keyResult ][] = [
                                        'ID'    => $valueResultItem[ 'ID' ],
                                        'VALUE' => self::checkLimitValueField($valueListFields[ 'VALUE' ],
                                            $keyField)
                                    ];
                                    unset($preFinishDealFields[ $keyField ]);
                                }
                            }
                        } else {
                            $finalResult[ $keyField ][ 'RESULT_COMPARISON' ][ $keyResult ][] = [
                                'ID'    => $valueResultItem[ 'ID' ],
                                'VALUE' => self::checkLimitValueField($valueResultItem[ 'VALUE' ], $keyField)
                            ];
                            unset($preFinishDealFields[ $keyField ]);
                        }
                    }
                } else {
                    if (!is_null($valueResult[ 'ID' ]) && array_key_exists('ITEMS',
                            $this->listFields[ $keyField ])) {
                        foreach ($this->listFields[ $keyField ][ 'ITEMS' ] as $keyListFields => $valueListFields) {
                            if ((int) $valueListFields[ 'ID' ] === $valueResult[ 'ID' ]) {
                                $finalResult[ $keyField ][ 'RESULT_COMPARISON' ][ $keyResult ][] = [
                                    'ID'    => $valueResult[ 'ID' ],
                                    'VALUE' => self::checkLimitValueField($valueListFields[ 'VALUE' ], $keyField)
                                ];
                                unset($preFinishDealFields[ $keyField ]);
                            }
                        }
                    } else {
                        $finalResult[ $keyField ][ 'RESULT_COMPARISON' ][ $keyResult ][] = [
                            'ID'    => $valueResult[ 'ID' ],
                            'VALUE' => self::checkLimitValueField($valueResult[ 'VALUE' ], $keyField)
                        ];
                        unset($preFinishDealFields[ $keyField ]);
                    }

                }

            }
        }

        return self::checkEvent($finalResult);
    }

    private function checkEvent(array $arResult): array
    {
        $result = [
            'NAME'       => 'Сделка отредактирована #'.$this->currentModifiedFields[ 'ID' ],
            'TYPE_EVENT' => 'EDIT_DEAL_FIELDS'
        ];
        if (array_key_exists('STAGE_ID', $this->currentModifiedFields)) {
            if ($this->beforeChangingFields[ 'STAGE_ID' ] != $this->currentModifiedFields[ 'STAGE_ID' ]) {
                $result = [
                    'NAME'       => 'Смена стадии в сделке #'.$this->currentModifiedFields[ 'ID' ],
                    'TYPE_EVENT' => 'EDIT_DEAL_STAGE',
                ];
            }
        }
        $typeDevice = Helpers::detectUserDevice();
        $result += [
            'TYPE_DEVICE'         => $typeDevice->getUserAgent(),
            'USER_IP'             => $typeDevice->getHttpHeaders()[ "HTTP_X_FORWARDED_FOR" ],
            'MODIFY_BY_ID'        => $this->currentModifiedFields[ 'MODIFY_BY_ID' ],
            'ID_DEAL'             => $this->currentModifiedFields[ 'ID' ],
            'COUNT_MODIFI_FIELDS' => count($arResult),
        ];

        $result[ 'DATA' ] = base64_encode(serialize($arResult));
        $result[ 'OLD_DATA' ] = base64_encode(serialize($this->beforeChangingFields));

        return $result;
    }


    public function arrayProcessing(): ?array
    {
        $preFinishDealFields = self::checkingFields();
        return self::fillMultipleFieldID($preFinishDealFields);
    }

}