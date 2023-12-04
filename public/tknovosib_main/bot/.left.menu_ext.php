<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (CModule::IncludeModule('tknovosib.main')) {
    $aMenuLinksExt = [];

    $aMenuLinksExt[] =
        [
            'Добавить нового бота',
            '/tknovosib_eh/bot/edit/0/',
            [],
            [],
            ''
        ];
    $aMenuLinksExt[] =
        [
            'Список ботов',
            '/tknovosib_eh/bot/list/',
            [],
            [],
            ''
        ];

    $aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
}

?>