<?php

namespace MS\Main;

use \Bitrix\Main;
use \Bitrix\Main\LoaderException;
use \MS\Main\Helpers;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Type\DateTime;
use \Bitrix\Crm\Category\DealCategory;

interface I_NFDS
{
    public function getDealFields(): array;

    public function garbageCleaning(array $currentModifiedFields): array;

    public function getDeal(int $dealID = 0, array $arFiledsFilter = []): array;

    public function controlField(): array;

    public function checkingMultipleEnumeration(array $new, null|array $old, string $key): array;

    public function checkingMultipleValue(array $new, null|array $old, string $key, string $type): array;

    public function checkingSingle(string $new, null|string $old, string $key, string $type): array;

    public function bakingData(array $arResult): array;

    public function cook(): ?array;
}

final class NFDS implements I_NFDS
{
    public const dealID = 0;
    private array $beforeChangingFields;
    private array $currentModifiedFields;
    private array $listFields;
    private array $finish;
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

    public function __construct(array $currentModifiedFields)
    {
        if (isset($currentModifiedFields[ 'ID' ]) && $currentModifiedFields[ 'ID' ] > 0) {
            if (Loader::IncludeModule('crm')) {

                $this->dealID = $currentModifiedFields[ 'ID' ];
                $this->listFields = self::getDealFields();
                $this->currentModifiedFields = self::garbageCleaning($currentModifiedFields);
                $this->beforeChangingFields = self::getDeal((int) $this->dealID, $this->currentModifiedFields);

                $checkingIncomingData = self::controlField();
                ?><pre><? var_dump($this->bakingData($checkingIncomingData)); ?></pre><?php
                $this->finish = $this->bakingData($checkingIncomingData);
            } else {
                throw new \Exception('No include module crm.');
            }
        } else {
            throw new \Exception('No ID deal or invalid ID!');
        }
    }

    public function getDealFields(): array
    {
        global $USER_FIELD_MANAGER;
        $arDeal = \CCrmDeal::GetFieldsInfo();

        foreach ($arDeal as $code => &$field) {
            $field[ 'CAPTION' ] = \CCrmDeal::GetFieldCaption($code);
        }

        $userType = new \CCrmUserType($USER_FIELD_MANAGER, \CCrmDeal::$sUFEntityID);
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

        foreach ($arDeal as $keyField => $valueField) {
            if (!isset($valueField[ 'TYPE' ])) {
                $arDeal[ $keyField ][ 'TYPE' ] = 'notype';
            }
        }

        return $arDeal;
    }

    public function garbageCleaning(array $currentModifiedFields): array
    {
        $arResultCheck = [];
        $stepCheck = ['1', '2'];
        $charToCheck = ['~'];

        $statusFisrtStepWork = false;

        foreach ($currentModifiedFields as $keyField => $valueField) {
            foreach ($stepCheck as $step) {
                switch ($step) {
                    case '1':
                        foreach ($charToCheck as $char) {
                            if (mb_substr($keyField, 0, 1, "UTF-8") == $char) {
                                $arResultCheck[ substr($keyField, 1) ] = $valueField;
                            } else {
                                $arResultCheck[ $keyField ] = $valueField;
                            }
                        }
                        $statusFisrtStepWork = true;
                        break;
                    case '2':
                        if ($statusFisrtStepWork) {
                            foreach ($arResultCheck as $key => $value) {
                                if (in_array($key, $this->listFields) || $value == 'NULL'
                                    || is_null($value) || in_array($key, self::IGNORING_FIELDS)) {
                                    unset($arResultCheck[ $key ]);
                                }
                            }
                        } else {
                            throw new \Exception('First step don`t work.');
                        }
                        $statusFisrtStepWork = false;
                        break;
                }
            }
        }

        unset($currentModifiedFields);
        $listTypeOfData = [
            'type_array'  => [],
            'type_string' => []
        ];

        foreach ($arResultCheck as $key => $value) {
            if ((isset($this->listFields[ $key ][ 'ATTRIBUTES' ])
                    && in_array('MUL', $this->listFields[ $key ][ 'ATTRIBUTES' ]))
                || gettype($value) == 'array') {
                $listTypeOfData[ 'type_array' ][ $key ] = $value;
            } else {
                settype($value, 'string');
                $listTypeOfData[ 'type_string' ][ $key ] = $value;
            }
        }

        unset($arResultCheck);
        return $listTypeOfData;
    }

    public function getDeal(int $dealID = 0, array $arFiledsFilter = []): array
    {
        $dbResult = \CCrmDeal::GetListEx(
            ['SOURCE_ID' => 'DESC'],
            [
                'ID'                => $dealID,
                'CHECK_PERMISSIONS' => 'N'
            ],
            false,
            false,
            array_keys($arFiledsFilter)
        );

        $arResult = [];
        while ($entity = $dbResult->fetch()) {
            $arResult = $entity;
        }

        return $arResult;
    }

    public function controlField(): array
    {
        $result = [];
        foreach ($this->currentModifiedFields as $keyField => $valueFiled) {
            foreach ($valueFiled as $key => $value) {
                $currentModified = $this->currentModifiedFields[ $keyField ];
                $beforeChanging = $this->beforeChangingFields[ $key ];
                if ($keyField == 'type_array') {
                    switch ($this->listFields[ $key ][ 'TYPE' ]) {
                        case 'enumeration':
                            $baseRes = self::checkingMultipleEnumeration($currentModified, $beforeChanging, $key);
                            if (!is_null($baseRes) && !empty($baseRes)) {
                                $result[ $key ][ 'NAME' ] = $this->listFields[ $key ][ 'NAME' ];
                                $result[ $key ][ 'CODE' ] = $key;
                                $result[ $key ][ 'TYPE' ] = $this->listFields[ $key ][ 'TYPE' ];
                                $result[ $key ][ 'ATTRIBUTES' ] = $this->listFields[ $key ][ 'ATTRIBUTES' ];
                                $result[ $key ][ 'RESULT_COMPARISON' ] = $baseRes;
                            }
                            break;
                        case 'file':
                        case 'datetime':
                        case 'string':
                        case 'date':
                            $baseRes = self::checkingMultipleValue($currentModified, $beforeChanging, $key,
                                $this->listFields[ $key ][ 'TYPE' ]);
                            if (!is_null($baseRes) && !empty($baseRes)) {
                                $result[ $key ][ 'NAME' ] = $this->listFields[ $key ][ 'NAME' ];
                                $result[ $key ][ 'CODE' ] = $key;
                                $result[ $key ][ 'TYPE' ] = $this->listFields[ $key ][ 'TYPE' ];
                                $result[ $key ][ 'ATTRIBUTES' ] = $this->listFields[ $key ][ 'ATTRIBUTES' ];
                                $result[ $key ][ 'RESULT_COMPARISON' ] = $baseRes;
                            }
                            break;
                    }
                } elseif ($keyField == 'type_string') {
                    switch ($this->listFields[ $key ][ 'TYPE' ]) {
                        case 'crm_status':
                        case 'crm_category':
                            foreach ($currentModified as $keyNew => $valueNew) {
                                $baseRes = self::checkingStageOrCategoryDeal($valueNew, $beforeChanging,
                                    $this->listFields[ $keyNew ][ 'TYPE' ]);
                                if (!is_null($baseRes) && !empty($baseRes)) {
                                    $result[ $keyNew ][ 'NAME' ] = $this->listFields[ $keyNew ][ 'NAME' ];
                                    $result[ $keyNew ][ 'CODE' ] = $keyNew;
                                    $result[ $keyNew ][ 'TYPE' ] = $this->listFields[ $keyNew ][ 'TYPE' ];
                                    $result[ $keyNew ][ 'RESULT_COMPARISON' ] = $baseRes;
                                }
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
                            foreach ($currentModified as $keyNew => $valueNew) {
                                $baseRes = self::checkingSingle($valueNew, $beforeChanging, $keyNew,
                                    $this->listFields[ $keyNew ][ 'TYPE' ]);
                                if (!is_null($baseRes) && !empty($baseRes)) {
                                    $result[ $keyNew ][ 'NAME' ] = $this->listFields[ $keyNew ][ 'NAME' ];
                                    $result[ $keyNew ][ 'CODE' ] = $keyNew;
                                    $result[ $keyNew ][ 'TYPE' ] = $this->listFields[ $keyNew ][ 'TYPE' ];
                                    $result[ $keyNew ][ 'RESULT_COMPARISON' ] = $baseRes;
                                }
                            }
                            break;
                    }
                }
            }
        }
        $result[ 'MODIFY_BY_ID' ] = $currentModified['MODIFY_BY_ID'];


        return $result;
    }

    public function checkingMultipleEnumeration(array $new, null|array $old, string $key): array
    {
        if (is_null($old)) {
            $old = [];
        }
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
                if ((is_string($old[ $key ]) && !strlen($old[ $key ])) && (is_string($new[ $key ]) && strlen($new[ $key ]))) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => 'новое значение'
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $valueField[ $new[ $key ] ],
                        'ID'    => $new[ $key ]
                    ];
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
                if ($beforeDiffChangingField[ $key ] && $currentDiffModifiedFields[ $key ] && $beforeDiffChangingField[ $key ] != $currentDiffModifiedFields[ $key ]) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => $valueField[ $beforeDiffChangingField[ $key ] ],
                        'ID'    => $beforeDiffChangingField[ $key ]
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $valueField[ $currentDiffModifiedFields[ $key ] ],
                        'ID'    => $currentDiffModifiedFields[ $key ]
                    ];
                } elseif (!array_key_exists($key, $beforeDiffChangingField) && array_key_exists($key,
                        $currentDiffModifiedFields) && !is_null($valueField[ $currentDiffModifiedFields[ $key ] ])) {
                    $result[ 'OLD' ][] = [
                        'VALUE' => 'новое значение'
                    ];
                    $result[ 'NEW' ][] = [
                        'VALUE' => $valueField[ $currentDiffModifiedFields[ $key ] ],
                        'ID'    => $currentDiffModifiedFields[ $key ]
                    ];
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

    public function checkingMultipleValue(array $new, null|array $old, string $key, string $type): array
    {
        $result = [];
        if (is_null($old)) {
            $old = [];
        }

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

    public function checkingStageOrCategoryDeal(string $new, null|string $old, string $type): array
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

    public function checkingSingle(string $new, null|string $old, string $key, string $type): array
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

        if ($old != $new && (is_string($new) && !strlen($new))) {
            $result[ 'OLD' ][] = [
                'VALUE' => $valueField[ $old ],
                'ID'    => $old
            ];
            $result[ 'NEW' ][] = [
                'VALUE' => $valueField[ $new ],
                'ID'    => $new
            ];
        } elseif ((is_string($old) && !strlen($old)) && (is_string($new) && strlen($new))) {
            $result[ 'OLD' ][] = [
                'VALUE' => 'новое значение',
            ];
            $result[ 'NEW' ][] = [
                'VALUE' => $valueField[ $new ],
                'ID'    => $new
            ];
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

    public function bakingData(array $arResult): array
    {

        var_dump($arResult['MODIFY_BY_ID']);
        $result = [
            'ID_DEAL'    => $this->dealID,
            'NAME'       => 'Сделка отредактирована #'.$this->dealID,
            'TYPE_EVENT' => 'EDIT_DEAL_FIELDS'
        ];
        if ((isset($arResult[ 'STAGE_ID' ]) && array_key_exists('STAGE_ID', $arResult))
            || (isset($arResult[ 'CATEGORY_ID' ]) && array_key_exists('CATEGORY_ID', $arResult))) {
            if ($this->beforeChangingFields[ 'STAGE_ID' ] != $arResult[ 'type_string' ][ 'STAGE_ID' ]) {
                $result += [
                    'NAME'       => 'Смена стадии в сделке #'.$this->dealID,
                    'TYPE_EVENT' => 'EDIT_DEAL_STAGE',
                ];
            } elseif ($this->beforeChangingFields[ 'CATEGORY_ID' ] != $arResult[ 'CATEGORY_ID' ]) {
                $result += [
                    'NAME'       => 'Смена воронки сделки #'.$this->dealID,
                    'TYPE_EVENT' => 'EDIT_DEAL_CATEGORY',
                ];
            }
        }
        $typeDevice = Helpers::detectUserDevice();
        $result += [
            'TYPE_DEVICE'         => $typeDevice->getUserAgent(),
            'USER_IP'             => $typeDevice->getHttpHeaders()[ "HTTP_X_FORWARDED_FOR" ],
            'MODIFY_BY_ID'        => $arResult[ 'MODIFY_BY_ID' ],
            'COUNT_MODIFI_FIELDS' => count($arResult),
        ];

        $result[ 'DATA' ] = base64_encode(serialize($arResult));
        $result[ 'OLD_DATA' ] = base64_encode(serialize($this->beforeChangingFields));

        return $result;
    }

    public function cook(): ?array
    {
        return $this->finish;
    }

    public function __destruct() { }

}


