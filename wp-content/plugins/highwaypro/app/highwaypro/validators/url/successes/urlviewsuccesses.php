<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Successes;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\JSONObjectsContainer;

Class UrlViewSuccesses extends JSONObjectsContainer
{
    public static function getStatistics(Collection $statisticsData, $type)
    {
        return new Collection([
            'state' => 'success',
            'message' => 'Success reading url statistics',
            'type' => $type,
            'statistics' => $statisticsData
        ]);
    }
}