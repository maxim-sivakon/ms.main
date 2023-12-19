<?php

namespace MS\Main\Assets\Savelog\Classes;

use MS\Main\Assets\Savelog\Interface\SaveLogInterface;

class SaveTimelineDeal implements SaveLogInterface
{
    public function save(array $arFieldsDeal): bool|int
    {
        $resultSave = false;
        var_dump("");
        var_dump("SaveTimelineDeal");
        // сохраняем в timeline deal
        var_dump(3);
        return 3;
    }
}