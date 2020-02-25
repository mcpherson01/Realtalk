<?php

namespace HighWayPro\App\Data\Model\UrlViews\UrlViewStatistics;

Interface UrlViewStatisticsInterface
{
    public function getTotal();
    public function getCountFromPastDays($numberOfDays);
    public function getTotalBy($field);
}