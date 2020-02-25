<?php

namespace HighwayPro\App\Data\Model\UrlTypes;

use HighWayPro\Original\Collections\Collection;

Class UrlTypeColors
{
    protected static $colors = [
        'original',
        'blue'
    ];

    public static function getAll()
    {
        return new Collection(static::$colors);
    }
    
}