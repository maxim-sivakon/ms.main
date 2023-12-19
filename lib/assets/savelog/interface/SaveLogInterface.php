<?php

namespace MS\Main\Assets\Savelog\Interface;

interface SaveLogInterface
{
    public function save(array $arFieldsDeal): bool|int;
}