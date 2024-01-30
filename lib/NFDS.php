<?php

namespace MS\Main;

use \Bitrix\Main;
use Bitrix\Main\LoaderException;
use \MS\Main\Helpers;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Type\DateTime;
use \Bitrix\Crm\Category\DealCategory;

final class NFDS
{
    private array $beforeChangingFields;
    private array $currentModifiedFields;
    private array $finResult;
    private array $listFields;
    private const MAP_FILED_NAME         = [
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
        'CONTACT_BINDINGS'      => 'Основной контакт',
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
    private const STRICT_MULTIPLE_FIELDS = ['UF_CRM_1600310015'];
    private const IGNORING_FIELDS        = [
        'CONTACT_BINDINGS'
    ];

    /**
     * @param $currentModifiedFields
     * @throws LoaderException
     */
    public function __construct($currentModifiedFields)
    {
        if (array_key_exists('ID', $currentModifiedFields)) {
            if (\Bitrix\Main\Loader::IncludeModule('crm')) {
                $this->listFields = self::getDealFields();
                $this->currentModifiedFields = self::cleaner(self::checkLimitKeyField($currentModifiedFields));
                $this->beforeChangingFields = self::getDeal((int) $this->currentModifiedFields[ 'ID' ],
                    $this->currentModifiedFields);


                ?><pre><?  var_dump(count($this->listFields)); ?></pre><?php
                ?><pre><?  var_dump(count($currentModifiedFields)); ?></pre><?php
                ?><pre><?  var_dump(count($this->currentModifiedFields)); ?></pre><?php


                $preBuild = $this->controlField();
                ?><pre><?  var_dump($preBuild); ?></pre><?php
                die();
                $this->finResult = $this->bakingData($preBuild);

            } else {
                throw new \Exception('No include module crm.');
            }
        } else {
            throw new \Exception('No ID deal.');
        }
    }

    /**
     * @param  array|null  $arFields
     * @return array
     */
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

    /**
     * @param  int  $dealID
     * @param  array  $arFiledsFilter
     * @return array|null
     */
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

    /**
     * @return array|null
     */
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

    private function cleaner(array $arFields):?array
    {
        $arFieldsTmp = $arFields;
        foreach ($arFieldsTmp as $key => $value){
            if(in_array($key, $this->listFields) || $value == 'NULL' || is_null($value) || in_array($key, self::IGNORING_FIELDS)
                || (is_array($value) && empty($value))){
                unset($arFieldsTmp[$key]);
            }
        }
        return $arFieldsTmp;
    }


    /**
     *
     *  Предварительно перед тем как начать обработку измененного значения поля сделки, нужно получить список полей сделки и основывать проверку поля и
     *  после проверять сохраненные значения основываясь на настройках поля.
     *
     *  Для проверки полей первоначально нужно обращать внимание на ключ поля ATTRIBUTES
     *  в нем есть значение MUL что означает множественное поле. Каждое значение множественного поля хранится в типе данных строка,
     *  но, само хранимое значение может быть и целым числом в виде строки.
     *  Например: если обратить внимание на ключ TYPE -> enumeration хранит в себе в виде строки целое число ID значения с которого мы
     *  можем получить текст выбранным пользователем в интерфейсе. Текущее поле может быть как множественным так не множественным.
     *
     *  Помимо ключа ATTRIBUTES есть ключ TYPE - в котором описывается тип поля,
     *  то есть поле в виде файла, контакта, компании и так далее, каждый тип на мой взгляд лучше обрабатывать по отдельности.
     *
     *
     * @return array
     */
    private function controlField(): array
    {
        $result = [];

        foreach ($this->currentModifiedFields as $keyField => $valueFiled) {

                $currentModified = $this->currentModifiedFields[ $keyField ];
                $beforeChanging = $this->beforeChangingFields[ $keyField ];

                if (!$this->listFields[ $keyField ][ 'TYPE' ]) {
                    $this->listFields[ $keyField ][ 'TYPE' ] = 'notype';
                }

                if (gettype($currentModified) == 'array' && gettype($beforeChanging) == 'NULL') {
                    $beforeChanging = [];
                    settype($beforeChanging, "array");
                } elseif (gettype($beforeChanging) == 'string') {
                    settype($currentModified, 'string');
                } elseif (gettype($beforeChanging) == 'array') {
                    settype($currentModified, 'array');
                }else{
                    settype($currentModified, 'string');


                }

                if (!is_null($currentModified) || $currentModified == 'NULL') {

                    if (!is_null($this->listFields[ $keyField ][ 'ATTRIBUTES' ])
                        && in_array('MUL', $this->listFields[ $keyField ][ 'ATTRIBUTES' ])
                        || gettype($currentModified) == 'array' && gettype($beforeChanging) == 'array') {

                        switch ($this->listFields[ $keyField ][ 'TYPE' ]) {
                            case 'enumeration':
                                $baseRes = self::checkingMultipleEnumeration($currentModified, $beforeChanging,
                                    $keyField);
                                if (!is_null($baseRes) && !empty($baseRes)) {
                                    $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                                    $result[ $keyField ][ 'CODE' ] = $keyField;
                                    $result[ $keyField ][ 'TYPE' ] = $this->listFields[ $keyField ][ 'TYPE' ];
                                    $result[ $keyField ][ 'ATTRIBUTES' ] = $this->listFields[ $keyField ][ 'ATTRIBUTES' ];
                                    $result[ $keyField ][ 'RESULT_COMPARISON' ] = $baseRes;
                                }
                                break;
                            case 'file':
                            case 'datetime':
                            case 'string':
                            case 'date':
                            default:
                                var_dump($keyField);
                                var_dump($this->listFields[ $keyField ][ 'TYPE' ]);
                                $baseRes = self::checkingMultipleValue($currentModified, $beforeChanging, $keyField,
                                    $this->listFields[ $keyField ][ 'TYPE' ]);
                                if (!is_null($baseRes) && !empty($baseRes)) {
                                    $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                                    $result[ $keyField ][ 'CODE' ] = $keyField;
                                    $result[ $keyField ][ 'TYPE' ] = $this->listFields[ $keyField ][ 'TYPE' ];
                                    $result[ $keyField ][ 'ATTRIBUTES' ] = $this->listFields[ $keyField ][ 'ATTRIBUTES' ];
                                    $result[ $keyField ][ 'RESULT_COMPARISON' ] = $baseRes;
                                }
                                break;

                        }
                    } else {
                        switch ($this->listFields[ $keyField ][ 'TYPE' ]) {
                            case 'crm_status':
                            case 'crm_category':
                                $baseRes = self::checkingStageOrCategoryDeal($currentModified, $beforeChanging,
                                    $this->listFields[ $keyField ][ 'TYPE' ]);
                                if (!is_null($baseRes) && !empty($baseRes)) {
                                    $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                                    $result[ $keyField ][ 'CODE' ] = $keyField;
                                    $result[ $keyField ][ 'TYPE' ] = $this->listFields[ $keyField ][ 'TYPE' ];
                                    $result[ $keyField ][ 'RESULT_COMPARISON' ] = $baseRes;
                                }
                                break;
                            case 'crm_company':
                            case 'crm_lead':
                            case 'integer':
                            case 'employee':
                            case 'user':
                            case 'crm_contact':
                            case 'double':
                            case 'location':
                            case 'string':
                            case 'crm_entity':
                            case 'crm_currency':
                            case 'char':
                            case 'enumeration':
                            case 'file':
                            case 'datetime':
                            case 'date':
                            default:
                                $baseRes = self::checkingSingle($currentModified, $beforeChanging, $keyField,
                                    $this->listFields[ $keyField ][ 'TYPE' ]);

                                if (!is_null($baseRes) && !empty($baseRes)) {
                                    $result[ $keyField ][ 'NAME' ] = $this->listFields[ $keyField ][ 'NAME' ];
                                    $result[ $keyField ][ 'CODE' ] = $keyField;
                                    $result[ $keyField ][ 'TYPE' ] = $this->listFields[ $keyField ][ 'TYPE' ];
                                    $result[ $keyField ][ 'RESULT_COMPARISON' ] = $baseRes;
                                }
                                break;
                        }
                    }
                }
            }


        return $result;
    }

    /**
     * @param  string  $new
     * @param  string  $old
     * @param  string  $type
     * @return array|null
     */
    private function checkingStageOrCategoryDeal(string $new, string $old, string $type): ?array
    {
        $result = [];
        switch ($type) {
            case 'crm_status':
                $categoryInfoOld = DealCategory::getStageInfos(DealCategory::resolveFromStageID($old))[ $old ];
                $categoryInfoNew = DealCategory::getStageInfos(DealCategory::resolveFromStageID($new))[ $new ];

                if ($old != $new && !empty($old) && !empty($new)) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $categoryInfoOld[ 'NAME' ],
                        'COLOR' => $categoryInfoOld[ 'COLOR' ],
                        'ID'    => $old
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $categoryInfoNew[ 'NAME' ],
                        'COLOR' => $categoryInfoNew[ 'COLOR' ],
                        'ID'    => $new
                    ];
                } elseif (empty($old)) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => 'новое значение',
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $categoryInfoNew[ 'NAME' ],
                        'COLOR' => $categoryInfoNew[ 'COLOR' ],
                        'ID'    => $new
                    ];
                } elseif (empty($new)) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $categoryInfoOld[ 'NAME' ],
                        'COLOR' => $categoryInfoOld[ 'COLOR' ],
                        'ID'    => $old
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => 'удалено значение',
                    ];
                }
                break;
            case 'crm_category':
                if ($old != $new) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => DealCategory::getName($old),
                        'ID'    => $old
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => DealCategory::getName($new),
                        'ID'    => $new
                    ];
                }
                break;
        }


        return $result;
    }

    /**
     * @param  string  $new
     * @param  string  $old
     * @param  string  $key
     * @param  string  $type
     * @return array|null
     */
    private function checkingSingle(string $new, null|string $old, string $key, string $type): ?array
    {
        $result = [];
        $tmpVal = [$old, $new];
        $valueField = [];
        foreach ($tmpVal as $val) {
            if ($type == "enumeration") {
                foreach ($this->listFields[ $key ][ 'ITEMS' ] as $valueListFields) {
                    if ((int) $valueListFields[ 'ID' ] === (int) $val) {
                        $valueField[ $val ] = $valueListFields[ 'VALUE' ];
                    }
                }
            } elseif ($type == "date" || $type == "datetime") {
                switch ($val) {
                    case 'now()':
                        $valueField[ $val ] = new DateTime();
                        break;
                    default:
                        $valueField[ $val ] = $val;
                }
            } elseif ($type == "char") {
                switch ($val) {
                    case '1':
                    case 'Y':
                        $valueField[ $val ] = 'да';
                        break;
                    case '0':
                    case 'N':
                        $valueField[ $val ] = 'нет';
                        break;
                    default:
                        $valueField[ $val ] = $val;
                }
            } else {
                $valueField = [
                    $val => $val,
                ];
            }
        }

        //if ($old != $new && !isset($old) && !isset($new)) {
        if ($old != $new && (is_string($new) && !strlen($new))) {
            $result[ 'OLD' ][] = [
                'VALUE' => $valueField[ $old ],
                'ID'    => $old
            ];
            $result[ 'NEW' ][] = [
                'VALUE' => $valueField[ $new ],
                'ID'    => $new
            ];
            //} elseif (empty($old) || !isset($old) && !empty($new)) {
        } elseif ((is_string($old) && !strlen($old)) && (is_string($new) && strlen($new))) {
            $result[ 'OLD' ][] = [
                'VALUE' => 'новое значение',
            ];
            $result[ 'NEW' ][] = [
                'VALUE' => $valueField[ $new ],
                'ID'    => $new
            ];
            //} elseif (empty($new) || !isset($new)) {
        } elseif ((is_string($old) && strlen($old)) && (is_string($new) && !strlen($new))) {
            $result[ 'OLD' ][] = [
                'VALUE' => $valueField[ $old ],
                'ID'    => $old
            ];
            $result[ 'NEW' ][] = [
                'VALUE' => 'удалено значение',
            ];
        }

        return $result;
    }

    /**
     * @param  array  $new
     * @param  array  $old
     * @param  string  $key
     * @return array|null
     */
    private function checkingMultipleEnumeration(array $new, array $old, string $key): ?array
    {
        $result = [];
        $tmpVal = [$old, $new];
        $valueField = [];

        foreach ($tmpVal as $value) {
            foreach ($value as $valueFull) {
                foreach ($this->listFields[ $key ][ 'ITEMS' ] as $valueListFields) {
                    if ((int) $valueListFields[ 'ID' ] === (int) $valueFull) {
                        $valueField[ $valueFull ] = $valueListFields[ 'VALUE' ];
                    }
                }
            }
        }

        if (in_array($key, self::STRICT_MULTIPLE_FIELDS)) {
            $maxCountElement = max(count($old), count($new));
            for ($key = 0; $key < $maxCountElement; $key++) {
                //if (!isset($old[ $key ]) && isset($new[ $key ])) {
                if ((is_string($old[ $key ]) && !strlen($old[ $key ])) && (is_string($new[ $key ]) && strlen($new[ $key ]))) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => 'новое значение'
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $valueField[ $new[ $key ] ],
                        'ID'    => $new[ $key ]
                    ];
                    //} elseif (isset($old[ $key ]) && !isset($new[ $key ])) {
                } elseif ((is_string($old[ $key ]) && strlen($old[ $key ])) && (is_string($new[ $key ]) && !strlen($new[ $key ]))) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $valueField[ $old[ $key ] ],
                        'ID'    => $old[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => 'удалено значение'
                    ];
                } else {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $valueField[ $old[ $key ] ],
                        'ID'    => $old[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $valueField[ $new[ $key ] ],
                        'ID'    => $new[ $key ]
                    ];
                }
            }
        } else {
            $beforeDiffChangingField = array_diff_assoc($old, $new);
            $currentDiffModifiedFields = array_diff_assoc($new, $old);
            $maxCountElement = max(count($old), count($new));

            for ($key = 0; $key < $maxCountElement; $key++) {
                //if ($beforeDiffChangingField[ $key ] && $currentDiffModifiedFields[ $key ] && $beforeDiffChangingField[ $key ] != $currentDiffModifiedFields[ $key ]) {
                if ($beforeDiffChangingField[ $key ] && $currentDiffModifiedFields[ $key ] && $beforeDiffChangingField[ $key ] != $currentDiffModifiedFields[ $key ]) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $valueField[ $beforeDiffChangingField[ $key ] ],
                        'ID'    => $beforeDiffChangingField[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $valueField[ $currentDiffModifiedFields[ $key ] ],
                        'ID'    => $currentDiffModifiedFields[ $key ]
                    ];
                    //} elseif (!array_key_exists($key, $beforeDiffChangingField) && array_key_exists($key,
                } elseif (!array_key_exists($key, $beforeDiffChangingField) && array_key_exists($key,
                        $currentDiffModifiedFields) && !is_null($valueField[ $currentDiffModifiedFields[ $key ] ])) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => 'новое значение'
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $valueField[ $currentDiffModifiedFields[ $key ] ],
                        'ID'    => $currentDiffModifiedFields[ $key ]
                    ];
                    // } elseif (array_key_exists($key, $beforeDiffChangingField) && !array_key_exists($key,
                } elseif (array_key_exists($key, $beforeDiffChangingField) && !array_key_exists($key,
                        $currentDiffModifiedFields)) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $valueField[ $beforeDiffChangingField[ $key ] ],
                        'ID'    => $beforeDiffChangingField[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => 'удалено значение'
                    ];
                }
            }

        }
        return $result;
    }

    /**
     * @param  array  $new
     * @param  array  $old
     * @param  string  $key
     * @param  string  $type
     * @return array|null
     */
    private function checkingMultipleValue(array $new, array $old, string $key, string $type): ?array
    {
        $result = [];

        if (in_array($key, self::STRICT_MULTIPLE_FIELDS)) {
            $maxCountElement = max(count($old), count($new));
            for ($key = 0; $key < $maxCountElement; $key++) {
                if (!isset($old[ $key ]) && isset($new[ $key ])) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => 'новое значение'
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $new[ $key ],
                        'ID'    => $new[ $key ]
                    ];
                } elseif (isset($old[ $key ]) && (is_string($new[ $key ]) && !strlen($new[ $key ]))) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $old[ $key ],
                        'ID'    => $old[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => 'удалено значение'
                    ];
                } else {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $old[ $key ],
                        'ID'    => $old[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $new[ $key ],
                        'ID'    => $new[ $key ]
                    ];
                }
            }

        } else {
            $beforeDiffChangingField = array_diff_assoc($old, $new);
            $currentDiffModifiedFields = array_diff_assoc($new, $old);
            $maxCountElement = max(count($old), count($new));

            for ($key = 0; $key < $maxCountElement; $key++) {
                //if ($beforeDiffChangingField[ $key ] && $currentDiffModifiedFields[ $key ] && $beforeDiffChangingField[ $key ] != $currentDiffModifiedFields[ $key ]) {
                if ($beforeDiffChangingField[ $key ] && $currentDiffModifiedFields[ $key ] && $beforeDiffChangingField[ $key ] != $currentDiffModifiedFields[ $key ]) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $beforeDiffChangingField[ $key ],
                        'ID'    => $beforeDiffChangingField[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $currentDiffModifiedFields[ $key ],
                        'ID'    => $currentDiffModifiedFields[ $key ]
                    ];
                } elseif (!array_key_exists($key, $beforeDiffChangingField) && array_key_exists($key,
                        $currentDiffModifiedFields)) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => 'новое значение'
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $currentDiffModifiedFields[ $key ],
                        'ID'    => $currentDiffModifiedFields[ $key ]
                    ];
                } elseif (array_key_exists($key, $beforeDiffChangingField) && !array_key_exists($key,
                        $currentDiffModifiedFields)) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $beforeDiffChangingField[ $key ],
                        'ID'    => $beforeDiffChangingField[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => 'удалено значение'
                    ];
                }
            }

        }
        return $result;
    }

    /**
     * @param  array  $arResult
     * @return array|string[]|null
     * @throws LoaderException
     */
    private function bakingData(array $arResult): ?array
    {
        $result = [];
        $result = [
            'NAME'       => 'Сделка отредактирована #'.$this->currentModifiedFields[ 'ID' ],
            'TYPE_EVENT' => 'EDIT_DEAL_FIELDS'
        ];
        if (array_key_exists('STAGE_ID', $this->currentModifiedFields) || array_key_exists('CATEGORY_ID',
                $this->currentModifiedFields)) {
            if ($this->beforeChangingFields[ 'STAGE_ID' ] != $this->currentModifiedFields[ 'STAGE_ID' ]) {
                $result = [
                    'NAME'       => 'Смена стадии в сделке #'.$this->currentModifiedFields[ 'ID' ],
                    'TYPE_EVENT' => 'EDIT_DEAL_STAGE',
                ];
            } elseif ($this->beforeChangingFields[ 'CATEGORY_ID' ] != $this->currentModifiedFields[ 'CATEGORY_ID' ]) {
                $result = [
                    'NAME'       => 'Смена воронки сделки #'.$this->currentModifiedFields[ 'ID' ],
                    'TYPE_EVENT' => 'EDIT_DEAL_CATEGORY',
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

    public function cook(): ?array
    {
        return $this->finResult;
    }

}


/*
 *
 * поля котоорые не отобразились и не дали ошибку
 * Вид ВЭД для ООО Экспортер ООО ВЭ - UF_CRM_1657506837
 *
 *
Результат проверки поставщика - UF_CRM_1698783986
 *
 *
 *
 *
 *
 * */