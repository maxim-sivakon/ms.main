<?php
defined('B_PROLOG_INCLUDED') || die;

/**
 * @var string $mid module id from GET
 */

$module_id = 'ms.main';

use Bitrix\Main\Loader;

Loader::includeModule($module_id);

use Bitrix\Main\Config\Configuration;
use Bitrix\Main\Localization\Loc;
use MS\Main\NFDS;

//use MS\Main\CTypeEventModify;
use MS\Main\Helpers;

//use MS\Main\HelperFields;

global $APPLICATION, $USER;

if (!$USER->IsAdmin()) {
    return;
}


$arFieldsDeal = [
    'ID'                    => 50862,
    'STAGE_ID'                    => 'C6:10',
    'CATEGORY_ID'                    => 3,
    "IS_MANUAL_OPPORTUNITY" => "N",
    "BEGINDATE"             => "27.10.2023",
    "ASSIGNED_BY_ID"        => "351",
    "UF_CRM_1626853571"     => "26.11.2023",
    "UF_CRM_1460029339"     => "2455",
    "UF_CRM_1478514709"     => "1630",
    "UF_CRM_1548653136"     => "2582",
    "UF_CRM_1568711077"     => [
        0 => "1175",
        1 => "1174",
    ],
    "UF_CRM_1457929450"     => 4010,
    "UF_CRM_1632884231" => 4573,
    "UF_CRM_1584445181"     => "3025",
    "UF_CRM_1600310015"     => [
        0 => "",
        1 => "",
        2 => "",
    ],
//    "UF_CRM_1600310015"     => [
//        0 => "1. 7326909807",
//        1 => "2-3. 8536901000",
//        2 => "4-3. 8536901000",
//        3 => "6-8. 8536901000"
//    ],
    "UF_CRM_1601294280"     => "2866",
    "UF_CRM_1629181183"     => "4141412",
    "UF_CRM_1629873976"     => "RR192992506RURT",
    "UF_CRM_1637686113256"  => "29.12.2023",
    "UF_CRM_1640234604791"  => 1,
    "UF_CRM_1649312142714"  => [
        0 => "2821",
        1 => "26911",
        2 => "2689",
        3 => "2692",
    ],
    "~DATE_MODIFY"          => "now()",
    "MODIFY_BY_ID"          => 409,
];




$allArray = [
  "PRODUCT_ROWS" => [],
  "OBSERVER_IDS" => [],
  "UF_CRM_1626079703" => [],
  "UF_CRM_1626161393" => [],
  "UF_CRM_1430283108"=> [1244541],
  "UF_CRM_1430284050"=> [1242088, 1242089],
  "UF_CRM_1430287045"=> [1243455],
  "UF_CRM_1510494191" => [],
  "UF_CRM_1573053953" => [],
  "UF_CRM_1573053974" => [],
  "UF_CRM_1587354093" => [],
  "UF_CRM_1589341670"=> NULL,
  "UF_CRM_1593667879" => [],
  "UF_CRM_1611202144" => [],
  "UF_CRM_1613046337"=> [1252264],
  "UF_CRM_1613560363"=> [1244554,1260941],
  "UF_CRM_1631597157382" => [],
  "UF_CRM_1637230203" => [],
  "UF_CRM_1638250964104" => [],
  "UF_CRM_1638789484782" => [],
  "UF_CRM_61EFD0D079BF1" => [],
  "UF_CRM_61EFD0FBC8496" => [],
  "UF_CRM_61EFD121DD46E"=> NULL,
  "UF_CRM_1648626501214" => [],
  "UF_CRM_1651805106038" => [],
  "UF_CRM_1665732106828"=> NULL,
  "UF_CRM_1680160740787" => [],
  "UF_CRM_1688435716029" => [],
//  "COMMENTS" => "09.10.23 WA Мансур Ибрагимов
//[B][I][LIST]
//[*]+50 000 тенге откат клиенту заложить
//[/LIST][/I][/B]
//мпп Данияр
//
//Счет во вложении
//
//Поставщик
//Нижегородский завод Старт, ООО
//+7 (831) 253-88-33
//[url=mailto:start.nn@mail.ru]start.nn@mail.ru[/url]
//[url=callto:+78312538311]+7 831 253-83-11[/url]
//12,10,2023 ждем договор от поставщика.",
//  "CONTACT_BINDINGS" => [
//          ["CONTACT_ID" => 20098, "SORT" => 10, "ROLE_ID" => 0, "IS_PRIMARY" => "Y"]
//  ],
  "CONTACT_IDS"=> [20098],
  "CONTACT_ID"=> 20098,
  "UTM_SOURCE"=> NULL,
  "UTM_MEDIUM"=> NULL,
  "UTM_CAMPAIGN"=> NULL,
  "UTM_CONTENT"=> NULL,
  "UTM_TERM"=> NULL,
  "ID"=>49928,
  "DATE_CREATE" => "09.10.2023 19:29:22",
  "DATE_CREATE_SHORT" => NULL,
  "DATE_MODIFY" => "24.01.2024 14:31:52",
  "DATE_MODIFY_SHORT" => NULL,
  "CREATED_BY_ID" => 398,
  "MODIFY_BY_ID" => 409,
  "ASSIGNED_BY_ID" => 299,
  "OPENED" => "Y",
  "LEAD_ID" => NULL,
  "COMPANY_ID" => 8104,
  "QUOTE_ID" => NULL,
  "TITLE" => "ТеплоТехСнаб, ТОО (клапан)",
  "PRODUCT_ID" => NULL,
  "CATEGORY_ID" => 6,
  "STAGE_ID" => "C6:UC_VD29WG",
  "STAGE_SEMANTIC_ID" => "P",
  "IS_NEW" => "N",
  "IS_RECURRING" => "N",
  "IS_RETURN_CUSTOMER" => "Y",
  "IS_REPEATED_APPROACH" => "N",
  "CLOSED" => "N",
  "TYPE_ID" => "COMPLEX",
  "OPPORTUNITY" => 5070500.12,
  "IS_MANUAL_OPPORTUNITY" => "Y",
  "TAX_VALUE" => 0,
  "CURRENCY_ID" => "KZT",
  "OPPORTUNITY_ACCOUNT" => 29763835.7,
  "TAX_VALUE_ACCOUNT" => 0,
  "ACCOUNT_CURRENCY_ID" => "RUB",
  "PROBABILITY" => NULL,
  "BEGINDATE" => "09.10.2023",
  "BEGINDATE_SHORT" => NULL,
  "CLOSEDATE" => "17.10.2023",
  "CLOSEDATE_SHORT" => NULL,
  "EVENT_DATE" => NULL,
  "EVENT_DATE_SHORT" => NULL,
  "EVENT_ID"=> NULL,
  "EVENT_DESCRIPTION"=> NULL,
  "EXCH_RATE"=> 5.87,
  "LOCATION_ID"=> NULL,
  "WEBFORM_ID"=> 0,
  "SOURCE_ID"=> NULL,
  "SOURCE_DESCRIPTION"=> NULL,
  "ORIGINATOR_ID"=> NULL,
  "ORIGIN_ID"=> NULL,
  "ADDITIONAL_INFO"=> NULL,
//  "SEARCH_CONTENT"=> "49928 ТеплоТехСнаб, ТОО (клапан) 5070500.12 Тенге Абдулкаримова Рузалия ТеплоТехСнаб, ТОО 77477145970 87477145970 7477145970 477145970 77145970 7145970 145970 45970 5970 970 Евгений graqre grcygrufano xm Контрактеры сбор документов для разрешения 09.10.2023 17.10.2023 09.10.23 JN Мансур Ибрагимов
//[O][V][YVFG]
//[*]+50 000 тенге откат клиенту заложить
//[/YVFG][/V][/O]
//мпп Данияр
//
//Счет во вложении
//
//Поставщик
//Нижегородский завод Старт, ООО
//+7 (831) 253-88-33
//[hey=znvygb:fgneg.aa@znvy.eh]fgneg.aa@znvy.eh[/hey]
//[hey=pnyygb:+78312538311]+7 831 253-83-11[/hey]
//12,10,2023 ждем договор от поставщика. 09.10.2023 19:29:22 Астана не выбрано Коммерческое предложение клиенту № 49928 от 11.10.2023.cqs Договор 28 (1) (1).cqs Реквизиты фирмы (1).qbpk Счет 435 (2).cqs ТОО &dhbg;ВЭД-партнер&dhbg; Отолпление водоснабжение вентиляция Тентиев Данияр Покупатель Неопределен Со счетом от поставщика JungfNcc  Запорная арматура Казахстан 200 р 15% МП 10.10.2023 14:00:00 RKJ ЕАЭС 164 к.д 172-180 10% 450 кг Нижний Новгород Обл г.Нижний Новогород Новые да ООО &dhbg;Экспортер&dhbg; 5405052077 Поставщик
//Нижегородский завод Старт ООО
//+7 (831) 253-88-33
//fgneg.aa@znvy.eh
//+7 831 253-83-11
//Условия работы с клиентом 10% скидки
//Отправка джетом до терминала города Астаны НИЖЕГОРОДСКИЙ ЗАВОД СТАРТ.cqs Счет внешний (ТОО ВЭД Партнер) № 49928       от 11.10.2023.cqs Спецификация (ТОО ВЭД Партнер) № 49928       от 11.10.2023 (2).cqs Нижегородский Завод &dhbg;Старт&dhbg; ООО прошел
//Р/С сверен с реквизитов в контракте на сайте госзакупок uggcf://mnxhcxv.tbi.eh/rcm/beqre/abgvpr/abgvpr223/qbphzragf.ugzy?abgvprVasbVq=4204255 18.03.2024 180 09.10.2023 19:46:58 11.10.2023 13:35:02 11.10.2023 14:03:59 11.10.2023 14:03:57 11.10.2023 14:10:59 11.10.2023 14:11:09 12.10.2023 10:46:32 17.10.2023 15:17:13 17.10.2023 15:17:14 оплата 50/50 Ибрагимов Мансур нет {&dhbg;pbzcnal_vq&dhbg;:[20577] &dhbg;pbagnpg_vqf&dhbg;:[20099]} убрал Прочее поле не заполнено Получение разрешения от ведомства ФСТЭК РК Экспорт из РФ самовывоз 17.10.2023 13:42:28 12.10.2023 ООО прошел Предоплата 100% Не требуется",
  "ORDER_STAGE" => NULL,
  "MOVED_BY_ID"=>409,
  "MOVED_TIME"=> "24.01.2024 14:31:52",
  "LAST_ACTIVITY_BY"=>353,
  "LAST_ACTIVITY_TIME"=> "22.01.2024 14:11:00",
  "IS_WORK" => NULL,
  "IS_WON" => NULL,
  "IS_LOSE" => NULL,
  "RECEIVED_AMOUNT" => NULL,
  "LOST_AMOUNT" => NULL,
  "HAS_PRODUCTS" => NULL,
  "UF_CRM_1605839367" => "09.10.2023 19:29:22",
  "UF_CRM_1625204128" => NULL,
  "UF_CRM_1626853571" => NULL,
  "UF_CRM_1632884231"=>299,
  "UF_CRM_6481770D9068C" => NULL,
  "UF_CRM_1626069863" => NULL,
  "UF_CRM_6481770F48649" => NULL,
  "UF_CRM_648177110594B" => NULL,
  "UF_CRM_64817712D1C41" => NULL,
  "UF_CRM_1416983323"=> "Астана",
  "UF_CRM_1426481943"=> NULL,
  "UF_CRM_1445232100"=>1761,
  "UF_CRM_1452411914"=>[319],
  "UF_CRM_5693244BB24C8"=>0,
  "UF_CRM_1457929450"=>386,
  "UF_CRM_1460029339"=>608,
  "UF_CRM_57397602C8168"=>0,
  "UF_CRM_1478514613"=>800,
  "UF_CRM_1478514709"=>896,
  "UF_CRM_1548653136"=>994,
  "UF_CRM_1551866863"=>1068,
  "UF_CRM_5CE3D3811B525" =>NULL,
  "UF_CRM_5CE3D3822CF3B" =>NULL,
  "UF_CRM_5CE3D38286B4B" =>NULL,
  "UF_CRM_1568711077"=>[1174],
  "UF_CRM_1575044638" => NULL,
  "UF_CRM_1575044651" => NULL,
  "UF_CRM_1575044812" => NULL,
  "UF_CRM_1575305299" => NULL,
  "UF_CRM_1575352316" => NULL,
  "UF_CRM_1580457878" => NULL,
  "UF_CRM_1584445181"=>1652,
  "UF_CRM_1584445243"=>2855,
  "UF_CRM_1587354148" => NULL,
  "UF_CRM_1592278129"=> "10.10.2023 14:00:00",
  "UF_CRM_1600310015"=> [],
  "UF_CRM_1600864431"=>[],
  "UF_CRM_1600864467"=>1777,
  "UF_CRM_1600864557"=> [],
  "UF_CRM_1600864578"=>["164 к.д"],
  "UF_CRM_1600864597"=> [],
  "UF_CRM_1600864610"=> "172-180",
  "UF_CRM_1600864637"=> [],
  "UF_CRM_1600864752"=> [],
  "UF_CRM_1601294280"=>1809,
  "UF_CRM_1601294530"=> ["450 кг"],
  "UF_CRM_1601345972"=>[],
  "UF_CRM_1601534867"=> ["Нижний Новгород Обл г.Нижний Новогород"],
  "UF_CRM_1601538061"=>1873,
  "UF_CRM_1606383286"=> ["да"],
  "UF_CRM_1612843966"=>2178,
//  "UF_CRM_1613045168"=> ["Поставщик
//Нижегородский завод Старт, ООО
//+7 (831) 253-88-33
//start.nn@mail.ru
//+7 831 253-83-11
//Условия работы с клиентом 10% скидки
//Отправка джетом до терминала города Астаны"],
  "UF_CRM_1613371423"=> [],
  "UF_CRM_1613372094"=> [],
  "UF_CRM_1613566474"=> [],
  "UF_CRM_1617941750"=> [],
  "UF_CRM_1617941785"=> [],
  "UF_CRM_1617949739"=> [],
  "UF_CRM_1617949743"=> [],
  "UF_CRM_1618378991" => NULL,
  "UF_CRM_1619768431"=> [],
  "UF_CRM_1619768487" => NULL,
  "UF_CRM_1623930487" => NULL,
//  "UF_CRM_1626493411"=> "Нижегородский Завод 'Старт', ООО прошел Р/С сверен с реквизитов в контракте на сайте госзакупок https://zakupki.gov.ru/epz/order/notice/notice223/documents.html?noticeInfoId=4204255 ",
  "UF_CRM_1626686380" => NULL,
  "UF_CRM_1626762901" => NULL,
  "UF_CRM_1626926911" => NULL,
  "UF_CRM_1626927285230" => NULL,
  "UF_CRM_1626927326988" => NULL,
  "UF_CRM_1626927420584" => NULL,
  "UF_CRM_1627529140" => NULL,
  "UF_CRM_1627614570" => NULL,
  "UF_CRM_1627614616" => NULL,
  "UF_CRM_1627614682" => NULL,
  "UF_CRM_1627614735" => NULL,
  "UF_CRM_1627614822" => NULL,
  "UF_CRM_1627614871" => NULL,
  "UF_CRM_1627614910" => NULL,
  "UF_CRM_1627614996" => NULL,
  "UF_CRM_1627615094" => NULL,
  "UF_CRM_1627615192" => NULL,
  "UF_CRM_1627615252" => NULL,
  "UF_CRM_1627615305" => NULL,
  "UF_CRM_1627615486" => NULL,
  "UF_CRM_1627887177" => NULL,
  "UF_CRM_1627887291" => NULL,
  "UF_CRM_1627887321" => NULL,
  "UF_CRM_1627887357" => NULL,
  "UF_CRM_1627887523" => NULL,
  "UF_CRM_1627887591" => NULL,
  "UF_CRM_1629181183" => NULL,
  "UF_CRM_1629191830" => "18.03.2024",
  "UF_CRM_1629191923" => NULL,
  "UF_CRM_1629191959" => NULL,
  "UF_CRM_1629343466" => NULL,
  "UF_CRM_1629694231816" => [],
  "UF_CRM_1629873976" => NULL,
  "UF_CRM_612F002684C1C" => NULL,
  "UF_CRM_1631597111870" => NULL,
  "UF_CRM_1631597138947" => NULL,
  "UF_CRM_1631597211298" => [],
  "UF_CRM_1631681055582" => NULL,
  "UF_CRM_1632063852" => NULL,
  "UF_CRM_1632063919" => NULL,
  "UF_CRM_1632885157" => [],
  "UF_CRM_1634625263559"=>0,
  "UF_CRM_1634627201265"=> 180,
  "UF_CRM_1635733836" => NULL,
  "UF_CRM_1635733947" => NULL,
  "UF_CRM_1636993600" => "09.10.2023 19:46:58",
  "UF_CRM_1636993653" => NULL,
  "UF_CRM_1636993690" => NULL,
  "UF_CRM_1636993727" => NULL,
  "UF_CRM_1636993765" => NULL,
  "UF_CRM_1636993794" => NULL,
  "UF_CRM_1636993838" => "11.10.2023 13:35:02",
  "UF_CRM_1636993865" => "11.10.2023 14:03:59",
  "UF_CRM_1636993902" => NULL,
  "UF_CRM_1636993948" => "11.10.2023 14:03:57",
  "UF_CRM_1636993992" => "11.10.2023 14:10:59",
  "UF_CRM_1636994614" => NULL,
  "UF_CRM_1636994942" => "11.10.2023 14:10:59",
  "UF_CRM_1636994979" => NULL,
  "UF_CRM_1636995016" => NULL,
  "UF_CRM_1636995052" => NULL,
  "UF_CRM_1636995087" => "11.10.2023 14:11:09",
  "UF_CRM_1636995120" => "12.10.2023 10:46:32",
  "UF_CRM_1636995365" => "17.10.2023 15:17:13",
  "UF_CRM_1636995391" => NULL,
  "UF_CRM_1636995417" => NULL,
  "UF_CRM_619356C1C8970"=> 0,
  "UF_CRM_6193579B0E87B"=> [],
  "UF_CRM_619357A40E31C"=> [],
  "UF_CRM_1637209628"=> "17.10.2023 15:17:14",
  "UF_CRM_1637209765" => NULL,
  "UF_CRM_1637209806" => NULL,
  "UF_CRM_1637209835" => NULL,
  "UF_CRM_1637209865" => NULL,
  "UF_CRM_1637652682" => NULL,
  "UF_CRM_1637682642" => NULL,
  "UF_CRM_1637682785" => NULL,
  "UF_CRM_1637682835" => NULL,
  "UF_CRM_1637682868" => NULL,
  "UF_CRM_1637682895" => NULL,
  "UF_CRM_1637683079" => NULL,
  "UF_CRM_1637683108" => NULL,
  "UF_CRM_1637683164" => NULL,
  "UF_CRM_1637683213" => NULL,
  "UF_CRM_1637683279" => NULL,
  "UF_CRM_1637683331" => NULL,
  "UF_CRM_1637683358" => NULL,
  "UF_CRM_1637683404" => NULL,
  "UF_CRM_1637683445" => NULL,
  "UF_CRM_1637684334" => NULL,
  "UF_CRM_1637684377" => NULL,
  "UF_CRM_1637684416" => NULL,
  "UF_CRM_1637684462" => NULL,
  "UF_CRM_1637686113256" => NULL,
  "UF_CRM_1637686443" => NULL,
  "UF_CRM_1638167545"=>2870,
  "UF_CRM_1638197776"=>268,
  "UF_CRM_1638198906"=>["нет"],
  "UF_CRM_1638428513" => NULL,
  "UF_CRM_1638873020" => NULL,
  "UF_CRM_1639027863827" => NULL,
  "UF_CRM_1639134599851" => NULL,
  "UF_CRM_1639461288216" => NULL,
  "UF_CRM_1639633938" => [],
  "UF_CRM_1639646855" => [],
  "UF_CRM_1639646877" => [],
  //"UF_CRM_1640231782" => ["{company_id:20577,"contact_ids":[20099]}"],
  "UF_CRM_1640234604791" =>0,
  "UF_CRM_1641784754" =>"убрал",
  "UF_CRM_61EFCFF0012E4" => NULL,
  "UF_CRM_61EFCFF7AABE7" => 0,
  "UF_CRM_61EFCFFF62549" => 0,
  "UF_CRM_61EFD00A25526" => 0,
  "UF_CRM_61EFD010A8BB5" => NULL,
  "UF_CRM_61EFD01B8DBD0" => 0,
  "UF_CRM_61EFD0275EFFB" => 0,
  "UF_CRM_61EFD02D49DFD" => 0,
  "UF_CRM_61EFD033345CA" => 0,
  "UF_CRM_61EFD03C7DED7" => 0,
  "UF_CRM_61EFD042CF61A" => 0,
  "UF_CRM_61EFD04D70446" => 0,
  "UF_CRM_61EFD054DB07C" => 0,
  "UF_CRM_61EFD0629C126" => 0,
  "UF_CRM_61EFD06F93317" => 0,
  "UF_CRM_61EFD075891A9"=> NULL,
  "UF_CRM_61EFD081A5A15" => NULL,
  "UF_CRM_61EFD088B29EA"=> [],
  "UF_CRM_61EFD08F37FA3" => 0,
  "UF_CRM_61EFD098ECE1B" => NULL,
  "UF_CRM_61EFD09FA1C3F" => NULL,
  "UF_CRM_61EFD0AAC993A" => NULL,
  "UF_CRM_61EFD0B096EB9" => NULL,
  "UF_CRM_61EFD0B8736E9" => NULL,
  "UF_CRM_61EFD0BF7A424" => NULL,
  "UF_CRM_61EFD0C9AAC36" => NULL,
  "UF_CRM_61EFD0DB2B7FA" => [],
  "UF_CRM_61EFD0E167001" => [],
  "UF_CRM_61EFD0E88842B" => [],
  "UF_CRM_61EFD0F03A87B" => [],
  "UF_CRM_61EFD102717F2" => NULL,
  "UF_CRM_61EFD10A0C9D8" => [],
  "UF_CRM_61EFD116F1F1E" => NULL,
  "UF_CRM_61EFD12A79A4A" => NULL,
  "UF_CRM_61EFD1353BD6E" => [],
  "UF_CRM_1644771255530" => NULL,
  "UF_CRM_1645012791418" => NULL,
  "UF_CRM_1645014352807" => NULL,
  "UF_CRM_1645014382940" => NULL,
  "UF_CRM_1645185546465" => NULL,
  "UF_CRM_1645185849875" => NULL,
  "UF_CRM_1647581294223"=> 0,
  "UF_CRM_1647921800141" => NULL,
  "UF_CRM_1647925817144" => NULL,
  "UF_CRM_1648552820778" => NULL,
  "UF_CRM_1649312142714"=> [2689],
  "UF_CRM_1649312488"=> [2890],
  "UF_CRM_1652248181505" => [],
  "UF_CRM_1652248207354" => [],
  "UF_CRM_1652248238931" => [],
  "UF_CRM_1653046283" => NULL,
  "UF_CRM_1653547130315"=> 0,
  "UF_CRM_1654153999" => [],
  "UF_CRM_1657506837"=>2737,
  "UF_CRM_1657692445974" => NULL,
  "UF_CRM_1657695515" => NULL,
  "UF_CRM_1658395045922"=> [],
  "UF_CRM_1660116417449" => NULL,
  "UF_CRM_1660618681" => NULL,
  "UF_CRM_1662978255487"=>"да",
  "UF_CRM_1665732715397" => NULL,
  "UF_CRM_1665733350921" => NULL,
  "UF_CRM_1667467325" => [],
  "UF_CRM_1667468965" => [],
  "UF_CRM_1667468987" => NULL,
  "UF_CRM_1669094540" => "самовывоз",
  "UF_CRM_1673590374" => "17.10.2023 15:17:14",
  "UF_CRM_1673590404" => NULL,
  "UF_CRM_1673590433" => NULL,
  "UF_CRM_1675321442" => NULL,
  "UF_CRM_1675321616" => NULL,
  "UF_CRM_1675322652" => NULL,
  "UF_CRM_1676979092" => NULL,
  "UF_CRM_1676979219" => NULL,
  "UF_CRM_1676979280" => NULL,
  "UF_CRM_1676979357" => NULL,
  "UF_CRM_1678694124" => "17.10.2023 13:42:28",
  "UF_CRM_1678934976" => NULL,
  "UF_CRM_1680146624"=> 0,
  "UF_CRM_1680669068149"=> 0,
  "UF_CRM_1680756150"=> "12.10.2023",
  "UF_CRM_64337DDA42AC5" => NULL,
  "UF_CRM_64337DDB9B923" => NULL,
  "UF_CRM_64337DDD046C8" => NULL,
  "UF_CRM_64337DDEA8801" => NULL,
  "UF_CRM_64337DE0357D8" => NULL,
  "UF_CRM_64337DE19B3B3" => NULL,
  "UF_CRM_64337DE365E25" => NULL,
  "UF_CRM_1681272900997" => [],
  "UF_CRM_1681997104" => "да",
  //"UF_CRM_1682078893"=> "Нижегородский Завод 'Старт', ООО прошел"
  "UF_CRM_1682575599" => NULL,
  "UF_CRM_1682575659" => "да",
  "UF_CRM_1682576178" => "450 кг",
  "UF_CRM_1682579153" => NULL,
  "UF_CRM_1683719576" => NULL,
  "UF_CRM_1683778067" => NULL,
  "UF_CRM_1683779425" => NULL,
  "UF_CRM_1683779611" => NULL,
  "UF_CRM_1683779687" => NULL,
  "UF_CRM_1683779966" => NULL,
  "UF_CRM_1683780026" => NULL,
  "UF_CRM_1683780108" => NULL,
  "UF_CRM_1684843701867" => [],
  "UF_CRM_1685353852" => NULL,
  "UF_CRM_1685433892" => NULL,
  "UF_CRM_1685707943" => NULL,
  "UF_CRM_1687148434" => NULL,
  "UF_CRM_1688537262" => NULL,
  "UF_CRM_1689309386" => NULL,
  "UF_CRM_1690179362852" => 2968,
  "UF_CRM_DEAL_3826729719797" => NULL,
  "UF_CRM_DEAL_3826729719816" => NULL,
  "UF_CRM_1692946807750" => NULL,
  "UF_CRM_1692947192" => NULL,
  "UF_CRM_1692958226"=>3032,
  "UF_CRM_1692958419"=> [],
  "UF_CRM_1692968443" => NULL,
  "UF_CRM_1694092634" => NULL,
  "UF_CRM_1697111688219" => NULL,
  "UF_CRM_1698112913" => NULL,
  "UF_CRM_1698113548" => NULL,
  "UF_CRM_1698113623" => NULL,
  "UF_CRM_1698113696" => NULL,
  "UF_CRM_1698113748" => NULL,
  "UF_CRM_1698113809" => NULL,
  "UF_CRM_1698113861" => NULL,
  "UF_CRM_1698113950" => NULL,
  "UF_CRM_1698113998" => NULL,
  "UF_CRM_1698114153" => NULL,
  "UF_CRM_1698114707" => NULL,
  "UF_CRM_1698114770" => NULL,
  "UF_CRM_1698114843" => NULL,
  "UF_CRM_1698114882" => NULL,
  "UF_CRM_1698114921" => NULL,
  "UF_CRM_1698783986" => NULL,
  "UF_CRM_1698804442" => NULL,
  "UF_CRM_1698891058" => NULL,
  "UF_CRM_1699496271" => NULL,
  "UF_CRM_1699497300" => NULL,
  "UF_CRM_1700817221464" => NULL,
  "UF_CRM_1700820819" => NULL,
  "UF_CRM_1701228716877" => NULL,
  "UF_CRM_1701241318" => NULL,
  "UF_CRM_1702435112" => NULL,
  "UF_CRM_1702620235" => NULL,
  "UF_CRM_1626079703_SINGLE" => NULL,
  "UF_CRM_1626161393_SINGLE" => NULL,
  "UF_CRM_1430283108_SINGLE" => NULL,
  "UF_CRM_1430284050_SINGLE" => NULL,
  "UF_CRM_1430287045_SINGLE" => NULL,
  "UF_CRM_1452411914_SINGLE" => NULL,
  "UF_CRM_5693244BB24C8_SINGLE" => NULL,
  "UF_CRM_1510494191_SINGLE" => NULL,
  "UF_CRM_1568711077_SINGLE" => NULL,
  "UF_CRM_1573053953_SINGLE" => NULL,
  "UF_CRM_1573053974_SINGLE" => NULL,
  "UF_CRM_1587354093_SINGLE" => NULL,
  "UF_CRM_1593667879_SINGLE" => NULL,
  "UF_CRM_1600310015_SINGLE" => NULL,
  "UF_CRM_1600864431_SINGLE" => NULL,
  "UF_CRM_1600864557_SINGLE" => NULL,
  "UF_CRM_1600864578_SINGLE" => NULL,
  "UF_CRM_1600864597_SINGLE" => NULL,
  "UF_CRM_1600864637_SINGLE" => NULL,
  "UF_CRM_1600864752_SINGLE" => NULL,
  "UF_CRM_1601294530_SINGLE" => NULL,
  "UF_CRM_1601345972_SINGLE" => NULL,
  "UF_CRM_1601534867_SINGLE" => NULL,
  "UF_CRM_1606383286_SINGLE" => NULL,
  "UF_CRM_1611202144_SINGLE" => NULL,
  "UF_CRM_1613045168_SINGLE" => NULL,
  "UF_CRM_1613046337_SINGLE" => NULL,
  "UF_CRM_1613371423_SINGLE" => NULL,
  "UF_CRM_1613372094_SINGLE" => NULL,
  "UF_CRM_1613560363_SINGLE" => NULL,
  "UF_CRM_1613566474_SINGLE" => NULL,
  "UF_CRM_1617941750_SINGLE" => NULL,
  "UF_CRM_1617941785_SINGLE" => NULL,
  "UF_CRM_1617949739_SINGLE" => NULL,
  "UF_CRM_1617949743_SINGLE" => NULL,
  "UF_CRM_1619768431_SINGLE" => NULL,
  "UF_CRM_1629694231816_SINGLE" => NULL,
  "UF_CRM_1631597157382_SINGLE" => NULL,
  "UF_CRM_1631597211298_SINGLE" => NULL,
  "UF_CRM_1632885157_SINGLE" => NULL,
  "UF_CRM_6193579B0E87B_SINGLE" => NULL,
  "UF_CRM_619357A40E31C_SINGLE" => NULL,
  "UF_CRM_1637230203_SINGLE" => NULL,
  "UF_CRM_1638198906_SINGLE" => NULL,
  "UF_CRM_1638250964104_SINGLE" => NULL,
  "UF_CRM_1638789484782_SINGLE" => NULL,
  "UF_CRM_1639633938_SINGLE" => NULL,
  "UF_CRM_1639646855_SINGLE" => NULL,
  "UF_CRM_1639646877_SINGLE" => NULL,
  "UF_CRM_1640231782_SINGLE" => NULL,
  "UF_CRM_61EFD088B29EA_SINGLE" => NULL,
  "UF_CRM_61EFD0D079BF1_SINGLE" => NULL,
  "UF_CRM_61EFD0DB2B7FA_SINGLE" => NULL,
  "UF_CRM_61EFD0E167001_SINGLE" => NULL,
  "UF_CRM_61EFD0E88842B_SINGLE" => NULL,
  "UF_CRM_61EFD0F03A87B_SINGLE" => NULL,
  "UF_CRM_61EFD0FBC8496_SINGLE" => NULL,
  "UF_CRM_61EFD10A0C9D8_SINGLE" => NULL,
  "UF_CRM_61EFD1353BD6E_SINGLE" => NULL,
  "UF_CRM_1648626501214_SINGLE" => NULL,
  "UF_CRM_1649312142714_SINGLE" => NULL,
  "UF_CRM_1649312488_SINGLE" => NULL,
  "UF_CRM_1651805106038_SINGLE" => NULL,
  "UF_CRM_1652248181505_SINGLE" => NULL,
  "UF_CRM_1652248207354_SINGLE" => NULL,
  "UF_CRM_1652248238931_SINGLE" => NULL,
  "UF_CRM_1654153999_SINGLE" => NULL,
  "UF_CRM_1658395045922_SINGLE" => NULL,
  "UF_CRM_1667467325_SINGLE" => NULL,
  "UF_CRM_1667468965_SINGLE" => NULL,
  "UF_CRM_1680160740787_SINGLE" => NULL,
  "UF_CRM_1681272900997_SINGLE" => NULL,
  "UF_CRM_1684843701867_SINGLE" => NULL,
  "UF_CRM_1688435716029_SINGLE" => NULL,
  "UF_CRM_1692958419_SINGLE" => NULL,
  "PARENT_ID_140" => NULL,
  "PARENT_ID_145" => NULL,
  "PARENT_ID_163" => NULL,
  "PARENT_ID_186"=> 5595
];
















$checkResult = new NFDS($allArray);
$result = $checkResult->cook();


$formAction = $APPLICATION->GetCurPage().'?mid='.htmlspecialcharsbx($mid).'&lang='.LANGUAGE_ID;
//$dealFieldsOption = HelperFields::getDealFieldsOption();


$tabs = [
    [
        'DIV'   => 'MAIN',
        'TAB'   => Loc::getMessage('MSMAIN.MAIN.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.MAIN.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'LOGS',
        'TAB'   => Loc::getMessage('MSMAIN.LOGS.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.LOGS.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'CURRENCIES',
        'TAB'   => Loc::getMessage('MSMAIN.CURRENCIES.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.CURRENCIES.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'BACKLIGHT_DEAL',
        'TAB'   => Loc::getMessage('MSMAIN.BACKLIGHT_DEAL.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.BACKLIGHT_DEAL.TAB_GENERAL_TITLE')
    ],
    [
        'DIV'   => 'BOTS',
        'TAB'   => Loc::getMessage('MSMAIN.BOTS.TAB_GENERAL_NAME'),
        'TITLE' => Loc::getMessage('MSMAIN.BOTS.TAB_GENERAL_TITLE')
    ],
];

$options = [
    'MAIN'           => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
    ],
    'LOGS'           => [
        [
            'MSMAIN.LOGS.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.LOGS.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY'),
            'N',
            ['checkbox', 'N']
        ],
        Loc::getMessage('MSMAIN.LOGS.SEPARATOR_LIST_FIELDS'),
        ["note" => Loc::getMessage('MSMAIN.LOGS.NOTIFI_DEFAULT_SAVE_FIELDS')],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE_EDIT',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_TIMELINE_EDIT'),
            '',
            [
                'multiselectbox',
                $dealFieldsOption
            ]
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY_EDIT',
            Loc::getMessage('MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY_EDIT'),
            '',
            [
                'multiselectbox',
                $dealFieldsOption
            ]
        ],
        "Строгая проверка множественных полей",
        ["note" => 'Строгая проверка позволяет проверить не только значение но и их очерёдность в списке. Например: если при сохранении множественного поля изменили значения местами, то при проверке модуль посчитает поле как изменённое. По умолчанию: проверяется поле на наличие изменений без учета очерёдности значений. '],
        [
            'MSMAIN.LOGS.OPTION_STRICT_CHECK_MULTIPLY_FIELDS',
            'Строгая проверка множественного поля',
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.LOGS.OPTION_SAVE_LOG_HISTORY_EDIT',
            'Поля для строгой проверки множества',
            '',
            [
                'multiselectbox',
                $dealFieldsOption
            ]
        ],

        //TODO сделать разрешения для редактирования определенным группам пользователя.
    ],
    'CURRENCIES'     => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
        [
            'MSMAIN.CURRENCIES.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
        Loc::getMessage('MSMAIN.MAIN.NOTIFICATION'),
        [
            'MSMAIN.CURRENCIES.OPTION_ACTIVE_NOTIFICATION_STAFF',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_ACTIVE_NOTIFICATION_STAFF'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_LIST_NOTIFICATION',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_LIST_NOTIFICATION'),
            '',
            [
                'multiselectbox',
                [
                    ''    => Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_ALL_NOTIFICATION'),
                    '409' => '[409] Sivakon Maxim'
                ]
            ]
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_NOTIFICATION_TYPE',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_NOTIFICATION_TYPE'),
            '',
            [
                'selectbox',
                [
                    'BITRIX24_MESS_PERSONAL'            => Loc::getMessage('MSMAIN.CURRENCIES.BITRIX24_MESS_PERSONAL'),
                    'BITRIX24_NOTIFI_PERSONAL'          => Loc::getMessage('MSMAIN.CURRENCIES.BITRIX24_NOTIFI_PERSONAL'),
                    'BITRIX24_NOTIFI_AND_MESS_PERSONAL' => Loc::getMessage('MSMAIN.CURRENCIES.BITRIX24_NOTIFI_AND_MESS_PERSONAL'),
                    'MAIL_NOTIFI'                       => Loc::getMessage('MSMAIN.CURRENCIES.MAIL_NOTIFI')
                ]
            ]
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION'),
            '',
            [
                'selectbox',
                [
                    '409' => '[409] Sivakon Maxim'
                ]
            ]
        ],
        [
            'MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION_MAIL',
            Loc::getMessage('MSMAIN.CURRENCIES.OPTION_STAFF_SEND_NOTIFICATION_MAIL'),
            "admin@".$SERVER_NAME, ["text", 30]
        ],

    ],
    'BACKLIGHT_DEAL' => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
        [
            'MSMAIN.BACKLIGHT_DEAL.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.BACKLIGHT_DEAL.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
    ],
    'BOTS'           => [
        ["note" => Loc::getMessage('MSMAIN.MAIN.DEVELOP')],
        [
            'MSMAIN.BOTS.OPTION_ACTIVE',
            Loc::getMessage('MSMAIN.BOTS.OPTION_ACTIVE'),
            'N',
            ['checkbox', 'N']
        ],
        ["note" => Loc::getMessage('MSMAIN.BOTS.NOTIFI_DEFAULT_SAVE_FIELDS')],
        [
            'MSMAIN.BOTS.OPTION_SAVE_TIMELINE',
            Loc::getMessage('MSMAIN.BOTS.OPTION_SAVE_TIMELINE'),
            'N',
            ['checkbox', 'N']
        ],
        [
            'MSMAIN.BOTS.OPTION_SAVE_HISTORY',
            Loc::getMessage('MSMAIN.BOTS.OPTION_SAVE_HISTORY'),
            'N',
            ['checkbox', 'N']
        ],
    ],
];

if (check_bitrix_sessid() && strlen($_POST[ 'save' ]) > 0) {
    foreach ($options as $option) {
        __AdmSettingsSaveOptions($module_id, $option);
    }
    LocalRedirect($APPLICATION->GetCurPageParam());
}

$tabControl = new CAdminTabControl('tabControl', $tabs);
$tabControl->Begin();
?>
<form method="POST" action="<?= $formAction ?>">
    <?php foreach ($options as $keyOption => $option) { ?>
        <?php $tabControl->BeginNextTab(); ?>
        <?= __AdmSettingsDrawList($module_id, $option); ?>
    <?php } ?>
    <?php $tabControl->Buttons(['btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false]); ?>
    <?= bitrix_sessid_post(); ?>
    <?php $tabControl->End(); ?>
</form>
