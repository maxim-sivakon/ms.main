<?php

namespace MS\Main;

use \Bitrix\Main;
use \Bitrix\Main\{LoaderException, Loader, Type\DateTime, Localization\Loc};
use \Bitrix\Crm\Category\DealCategory;

interface ControlFieldInterface
{
    public function getID(): int;

    public function getNotModifiedFields(): array;

    public function getModifiedFields(): array;

    public function setModifiedFields(array $fields): self;

    public function getListFieldsDeal(): array;

    public function getStrictMultipleFields(): array;

    public function getIgnoringFields(): array;

    public function getDealFields(): array;

    public function setNameDealFields(array $fields): array;

    public function setTypeDealFields(array $fields): array;

    public function normalizeFields(array $fields): array;

    public function clearingArrayKeyChar(array $fields): array;

    public function clearingUnusedFieldsInDeal(array $fields): array;

    public function distributionByDataType(array $fields): array;

    public function processLogic(): array;
}

final class ControlField implements ControlFieldInterface
{
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
    protected $dealID;
    /** @var array */
    protected $notModifiedFields;
    /** @var array */
    protected $modifiedFields;
    /** @var array */
    protected $listFieldsDeal;
    /** @var array */
    protected $strictMultipleFields;
    /** @var array */
    protected $ignoringFields;

    public function __construct(array $currentModifiedFields)
    {
        if (isset($currentModifiedFields[ 'ID' ]) && $currentModifiedFields[ 'ID' ] > 0) {
            if (Loader::IncludeModule('crm')) {
                $this->dealID = $currentModifiedFields[ 'ID' ];
                $this->listFieldsDeal = $this->getDealFields();
                $this->modifiedFields = $this->normalizeFields($currentModifiedFields);
                $this->notModifiedFields = [];
                $this->strictMultipleFields = ['UF_CRM_1600310015'];
                $this->ignoringFields = ['CONTACT_BINDINGS'];
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
        return $this->dealID;
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

    public function getStrictMultipleFields(): array
    {
        return $this->strictMultipleFields;
    }

    public function getIgnoringFields(): array
    {
        return $this->ignoringFields;
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

        $arDeal = $this->setNameDealFields($arDeal);
        $arDeal = $this->setTypeDealFields($arDeal);

        return $arDeal;
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
                $listTypeOfData[ 'type_array' ][ $key ] = $value;
            } else {
                settype($value, 'string');
                $listTypeOfData[ 'type_string' ][ $key ] = $value;
            }
        }

        return $listTypeOfData;
    }

    public function processLogic(): array
    {
        return [];
    }
}


