<?php

namespace MS\Main;

use \Bitrix\Main;
use \Bitrix\Main\{LoaderException, Loader, Type\DateTime, Localization\Loc};
use \Bitrix\Crm\Category\DealCategory;

final class ControlField
{
    public const TYPE_ARRAY              = 'array';
    public const TYPE_STRING             = 'string';
    public const TYPE_FIELD_ENUMERATION  = 'enumeration';
    public const TYPE_FIELD_FILE         = 'file';
    public const TYPE_FIELD_DATE         = 'date';
    public const TYPE_FIELD_DATETIME     = 'datetime';
    public const TYPE_FIELD_STRING       = 'string';
    public const TYPE_FIELD_CRM_STATUS   = 'crm_status';
    public const TYPE_FIELD_CRM_CATEGORY = 'crm_category';
    public const TYPE_FIELD_CRM_CURRENCY = 'crm_currency';
    public const TYPE_FIELD_CRM_COMPANY  = 'crm_company';
    public const TYPE_FIELD_CRM_CONTACT  = 'crm_contact';
    public const TYPE_FIELD_CRM_LEAD     = 'crm_lead';
    public const TYPE_FIELD_INTEGER      = 'integer';
    public const TYPE_FIELD_EMPLOYEE     = 'employee';
    public const TYPE_FIELD_USER         = 'user';
    public const TYPE_FIELD_DOUBLE       = 'double';
    public const TYPE_FIELD_LOCATION     = 'location';
    public const TYPE_FIELD_CRM_ENTITY   = 'crm_entity';
    public const TYPE_FIELD_CHAR         = 'char';
    public const TYPE_FIELD_TEXT         = 'text';
    public const TYPE_FIELD_BOOLEAN      = 'boolean';
    public const TYPE_FIELD_CRM_DEAL     = 'crm_deal';
    public const FIELDS_MAP_NAME         = [
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

    /** @var integer */
    protected int $dealID;
    /** @var array */
    protected array $notModifiedFields;
    /** @var array */
    protected array $modifiedFields;
    /** @var array */
    protected array $listFieldsDeal;
    /** @var array */
    protected array $strictMultipleFields;
    /** @var array */
    protected array $ignoringFields;

    public function __construct(array $currentModifiedFields)
    {
        if (isset($currentModifiedFields[ 'ID' ]) && $currentModifiedFields[ 'ID' ] > 0) {
            if (Loader::IncludeModule('crm')) {
                $this->dealID = $currentModifiedFields[ 'ID' ];
                $this->strictMultipleFields = $this->setStrictMultipleFields();
                $this->ignoringFields = $this->setIgnoringFields();
                $this->listFieldsDeal = $this->getDealFields();
                $this->modifiedFields = $this->normalizeFields($currentModifiedFields);
                $this->notModifiedFields = $this->getDeal($this->getID(), $this->getModifiedFields());
            } else {
                throw new LoaderException('No include module crm.');
            }
        } else {
            throw new LoaderException('No ID deal or invalid ID!');
        }

        Loc::loadMessages(__FILE__);
    }

    public function getID(): int
    {
        return (int) $this->dealID;
    }

    public function getNotModifiedFields(): array
    {
        return $this->notModifiedFields;
    }

    public function getModifiedFields(): array
    {
        return $this->modifiedFields;
    }

    public function setModifiedFields(array $fields): self
    {
        $this->modifiedFields = $fields;
        return $this;
    }

    public function getListFieldsDeal(): array
    {
        return $this->listFieldsDeal;
    }

    public function setStrictMultipleFields(): array
    {
        $strictMultipleFields = ['UF_CRM_1600310015'];
        return $strictMultipleFields;
    }

    public function getStrictMultipleFields(): array
    {
        return $this->strictMultipleFields;
    }

    public function setIgnoringFields(): array
    {
        $ignoringFields = ['CONTACT_BINDINGS'];
        return $ignoringFields;
    }

    public function getIgnoringFields(): array
    {
        return $this->ignoringFields;
    }

    protected function getDealFields(): array
    {
        global $USER_FIELD_MANAGER;
        $arDeal = \CCrmDeal::GetFieldsInfo();

        foreach ($arDeal as $code => &$field) {
            $field[ 'CAPTION' ] = \CCrmDeal::GetFieldCaption($code);
        }

        $userType = new \CCrmUserType($USER_FIELD_MANAGER, \CCrmDeal::$sUFEntityID);
        $userType->PrepareFieldsInfo($arDeal);

        $arDeal = $this->setNameDealFields($arDeal);
        $arDeal = $this->setTypeDealFields($arDeal);

        return $arDeal;
    }

    protected function getDeal(int $dealID = 0, array $fieldsFilter = []): array
    {
        $dbResult = \CCrmDeal::GetListEx(
            ['SOURCE_ID' => 'DESC'],
            [
                'ID'                => $dealID,
                'CHECK_PERMISSIONS' => 'N'
            ],
            false,
            false,
            array_keys($fieldsFilter)
        );

        $arResult = [];
        while ($entity = $dbResult->fetch()) {
            $arResult = $entity;
        }

        return $arResult;
    }

    public function setNameDealFields(array $fields): array
    {
        foreach ($fields as $keyField => $valueField) {
            if ($valueField[ 'TITLE' ]) {
                $fields[ $keyField ][ 'NAME' ] = $valueField[ 'TITLE' ];
            } elseif ($valueField[ 'CAPTION' ]) {
                $fields[ $keyField ][ 'NAME' ] = $valueField[ 'CAPTION' ];
            } elseif (self::FIELDS_MAP_NAME[ $keyField ]) {
                $fields[ $keyField ][ 'NAME' ] = self::FIELDS_MAP_NAME[ $keyField ];
            } else {
                $fields[ $keyField ][ 'NAME' ] = "Нет названия поля [{$keyField}]";
            }
        }

        return $fields;
    }

    public function setTypeDealFields(array $fields): array
    {
        foreach ($fields as $keyField => $valueField) {
            if (!isset($valueField[ 'TYPE' ])) {
                $fields[ $keyField ][ 'TYPE' ] = 'notype';
            }
        }

        return $fields;
    }

    public function normalizeFields(array $fields): array
    {

        $fields = $this->clearingArrayKeyChar($fields);
        $fields = $this->clearingUnusedFieldsInDeal($fields);
        $fields = $this->distributionByDataType($fields);

        return $fields;
    }

    public function clearingArrayKeyChar(array $fields): array
    {
        $newFields = [];
        $listChars = ['~', '=', '@'];

        foreach ($fields as $keyField => $valueField) {
            foreach ($listChars as $char) {
                if (mb_substr($keyField, 0, 1, "UTF-8") == $char) {
                    $newFields[ substr($keyField, 1) ] = $valueField;
                } else {
                    $newFields[ $keyField ] = $valueField;
                }
            }
        }

        return $newFields;
    }

    public function clearingUnusedFieldsInDeal(array $fields): array
    {

        foreach ($fields as $key => $value) {
            if (in_array($key, $this->getListFieldsDeal()) || $value == 'NULL'
                || is_null($value) || in_array($key, $this->getIgnoringFields())) {
                unset($fields[ $key ]);
            }
        }

        return $fields;
    }

    public function distributionByDataType(array $fields): array
    {
        $listTypeOfData = [];

        foreach ($fields as $key => $value) {
            if ((isset($this->getListFieldsDeal[ $key ][ 'ATTRIBUTES' ])
                    && in_array('MUL', $this->getListFieldsDeal[ $key ][ 'ATTRIBUTES' ]))
                || gettype($value) == 'array') {
                $listTypeOfData[ 'array' ][ $key ] = $value;
            } else {
                settype($value, 'string');
                $listTypeOfData[ 'string' ][ $key ] = $value;
            }
        }

        return $listTypeOfData;
    }

    public function processLogic(): array
    {
        $resultComparing = [];
        foreach ($this->getModifiedFields() as $keyTypeOfDataField => $field) {
            foreach ($field as $keyField => $valueField) {
                if (static::TYPE_ARRAY === $keyTypeOfDataField) {
                    $resultComparing[ $keyField ] = $this->comparingFieldsAsAnArray($valueField, $keyField);
                } elseif (static::TYPE_STRING === $keyTypeOfDataField) {
                    foreach ($valueField as $key => $value) {
                        $resultComparing[ $keyField ] = $this->comparingFieldsAsSingleOnes($value, $key);
                    }
                }
            }
        }
        $resultComparing[ 'MODIFY_BY_ID' ] = $this->getModifiedFields()[ 'MODIFY_BY_ID' ];
        return $resultComparing;
    }

    public function comparingFieldsAsAnArray(array $valueField, string $keyField): array
    {
        $resultComparing = [];

        return [];
    }

    public function comparingFieldsAsSingleOnes(mixed $valueField, string $keyField): array
    {
        $resultComparingFields = [];
        $resultComparing = [];
        switch ($this->getDealFields()[ $keyField ][ 'TYPE' ]) {
            case static::TYPE_FIELD_CRM_STATUS:
                $resultComparing = $this->comparingStageDeal($this->getNotModifiedFields()[ $keyField ], $valueField);
                break;
            case static::TYPE_FIELD_CRM_CATEGORY:
                $resultComparing = $this->comparingCategoryDeal($this->getNotModifiedFields()[ $keyField ],
                    $valueField);
                break;
            case static::TYPE_FIELD_DATETIME:
            case static::TYPE_FIELD_DATE:
            case static::TYPE_FIELD_ENUMERATION:
            case static::TYPE_FIELD_CRM_CURRENCY:
            case static::TYPE_FIELD_CRM_COMPANY:
            case static::TYPE_FIELD_CRM_CONTACT:
            case static::TYPE_FIELD_CRM_ENTITY:
            case static::TYPE_FIELD_CRM_LEAD:
            case static::TYPE_FIELD_INTEGER:
            case static::TYPE_FIELD_EMPLOYEE:
            case static::TYPE_FIELD_USER:
            case static::TYPE_FIELD_DOUBLE:
            case static::TYPE_FIELD_LOCATION:
            case static::TYPE_FIELD_STRING:
            case static::TYPE_FIELD_CHAR:
            case static::TYPE_FIELD_FILE:
                break;
        }
        $resultComparingFields[ 'NAME' ] = $this->getDealFields()[ $keyField ][ 'NAME' ];
        $resultComparingFields[ 'CODE' ] = $keyField;
        $resultComparingFields[ 'TYPE' ] = $this->getDealFields()[ $keyField ][ 'TYPE' ];
        $resultComparingFields[ 'RESULT_COMPARISON' ] = $resultComparing;

        return $resultComparingFields;
    }

    final public function comparingStageDeal(string $old, string $new): array
    {
        $resultComparing = [];

        $categoryOld = DealCategory::getStageInfos(DealCategory::resolveFromStageID($old))[ $old ];
        $categoryNew = DealCategory::getStageInfos(DealCategory::resolveFromStageID($new))[ $new ];

        if ($old != $new && !empty($old) && !empty($new)) {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => $categoryOld[ 'NAME' ],
                'COLOR' => $categoryOld[ 'COLOR' ],
                'ID'    => $old
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => $categoryNew[ 'NAME' ],
                'COLOR' => $categoryNew[ 'COLOR' ],
                'ID'    => $new
            ];
        } elseif (empty($old)) {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => 'новое значение',
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => $categoryNew[ 'NAME' ],
                'COLOR' => $categoryNew[ 'COLOR' ],
                'ID'    => $new
            ];
        } elseif (empty($new)) {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => $categoryOld[ 'NAME' ],
                'COLOR' => $categoryOld[ 'COLOR' ],
                'ID'    => $old
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => 'удалено значение',
            ];
        } else {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => false,
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => false,
            ];
        }

        return $resultComparing;
    }

    final public function comparingCategoryDeal(string $old, string $new): array
    {
        $resultComparing = [];

        if ($old != $new && !empty($old) && !empty($new)) {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => DealCategory::getName($old),
                'ID'    => $old
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => DealCategory::getName($new),
                'ID'    => $new
            ];
        } elseif (empty($old)) {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => 'новое значение',
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => DealCategory::getName($new),
                'ID'    => $new
            ];
        } elseif (empty($new)) {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => DealCategory::getName($old),
                'ID'    => $old
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => 'удалено значение',
            ];
        } else {
            $resultComparing[ 'OLD' ][] = [
                'VALUE' => false,
            ];
            $resultComparing[ 'NEW' ][] = [
                'VALUE' => false,
            ];
        }

        return $resultComparing;
    }

}


