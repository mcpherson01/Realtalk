<?php

namespace Highwaypro\App\Data\Model\Preferences;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\JSONMapper;
use HighwayPro\Original\Collections\Mapper\Mappable;
use HighwayPro\Original\Collections\Mapper\Types;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class DashboardPreferences extends Preferences
{
    static public function fields()
    {
        return new Collection([
            'tourIsEnabled'  => Types::BOOLEAN()->withDefault(true),
        ]);   
    }

    protected function getMap()
    {
        return static::fields()->asArray();
    }
}