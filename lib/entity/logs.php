<?php

namespace MS\Main\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Crm\DealTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\UserTable;

class LogsTable extends DataManager
{
    protected static $instance = null;
    public static function getTableName()
    {
        return 'ms_main_logs';
    }

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new LogsTable();
        }
        return self::$instance;
    }

    public static function getFilePath()
    {
        return __FILE__;
    }

    public static function getMap()
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),
            new StringField('NAME', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_NAME')]),
            new StringField('TYPE_EVENT', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_TYPE_EVENT')]),
            new DatetimeField('DATE_CREATE_LOG', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_DATE_CREATE_LOG')]),
            new IntegerField('USER_CREATE_LOG', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_USER_CREATE_LOG')]),
            new DateField('LOCAL_TIME_USER', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_LOCAL_TIME_USER')]),
            new IntegerField('ID_DEAL', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_ID_DEAL')]),
            new StringField('TYPE_DEVICE', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_TYPE_DEVICE')]),
            new TextField('LIST_MODIFI_FIELDS',
                ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_LIST_MODIFI_FIELDS')]),
            new IntegerField('COUNT_MODIFI_FIELDS',
                ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_COUNT_MODIFI_FIELDS')]),
            new TextField('LIST_MODIFI_FIELDS_VALUE',
                ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_LIST_MODIFI_FIELDS_VALUE')]),
            new StringField('USER_IP', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_USER_IP')]),
            new StringField('USER_URL', ['title' => Loc::getMessage('MSMAIN.ENTITY.FIELD_USER_URL')]),

            new Reference(
                'USER_CREATE_LOG',
                UserTable::getEntity(),
                ['=this.USER_CREATE_LOG' => 'ref.ID']
            ),
            new Reference(
                'ID_DEAL',
                DealTable::getEntity(),
                ['=this.ID_DEAL' => 'ref.ID']
            )
        ];
    }

    public static function add(array $data){
        return parent::add($data);
    }

}