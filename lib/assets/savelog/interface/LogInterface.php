<?php

namespace MS\Main\Assets\Savelog\Interface;
interface LogInterface
{
    public function createLogDataManages(): SaveLogInterface;
    public function createHistoryDeal(): SaveLogInterface;
    public function createTimelineDeal(): SaveLogInterface;
}