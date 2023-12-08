<?php

namespace MS\Main\Entity;

use Bitrix\Crm\DealTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\UserTable;
use DateTime;

class LogsTable extends \Bitrix\Main\Entity\DataManager
{
    public static function getTableName()
    {
        return 'ms_main_logs';
    }

    public static function getMap()
    {
        return [
            new IntegerField('ID',
                ['primary' => true, 'autocomplete' => true, 'title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_ID')]),
            new StringField('NAME', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_NAME')]),
            new StringField('TYPE_EVENT', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_TYPE_EVENT')]),
            new DatetimeField("DATE_CREATE_LOG", [
                "default_value" => function () {
                    return new DateTime();
                }, 'title'      => Loc::getMessage('MSMAIN.ENTITY.FIELD_DATE_CREATE_LOG')
            ]),
            new IntegerField('USER_CREATE_LOG', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_USER_CREATE_LOG')]),
            new DateField('LOCAL_TIME_USER', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_LOCAL_TIME_USER')]),
            new IntegerField('ID_DEAL', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_ID_DEAL')]),
            new StringField('TYPE_DEVICE', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_TYPE_DEVICE')]),
            new StringField('LIST_MODIFI_FIELDS',
                ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_LIST_MODIFI_FIELDS')]),
            new IntegerField('COUNT_MODIFI_FIELDS',
                ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_COUNT_MODIFI_FIELDS')]),
            new StringField('LIST_MODIFI_FIELDS_VALUE',
                ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_LIST_MODIFI_FIELDS_VALUE')]),
            new StringField('USER_IP', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_USER_IP')]),
            new StringField('USER_URL', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_USER_URL')]),

            new ReferenceField(
                'USER_CREATE_LOG',
                UserTable::getEntity(),
                ['=this.USER_CREATE_LOG' => 'ref.ID']
            ),
            new ReferenceField(
                'ID_DEAL',
                DealTable::getEntity(),
                ['=this.ID_DEAL' => 'ref.ID']
            )
        ];
    }
}