<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (CModule::IncludeModule('tknovosib.main')) {
    $arMenuCrm = [];

    $arMenuCrm[] = [
        "Боты",
        "/tknovosib_main/bot",
        [],
        [],
        ""
    ];


    $aMenuLinks = array_merge($arMenuCrm, $aMenuLinks);
}

?>