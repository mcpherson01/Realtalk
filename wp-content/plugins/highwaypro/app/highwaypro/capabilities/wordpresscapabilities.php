<?php

namespace HighWayPro\App\HighWayPro\Capabilities;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Characters\StringManager;

Class WordPressCapabilities
{
    protected static function get_editable_roles()
    {
        (array) $values = [];

        // this is only needed on the back-end (HP Dashboard)
        if (function_exists('get_editable_roles')) {
            foreach (get_editable_roles() as $key => $value) {
                $values[$key] = $value;
            }
        }

        return $values;
    }
    
    protected static function getLevels()
    {
        return Collection::range(0, 10)->map(function($number){
            return "level_{$number}";
        });
    }
    
    public static function getRoles()
    {
        return new Collection(array_keys(static::get_editable_roles()));   
    }

    public static function getCapabilities()
    {
        (array) $allCapabilities = [];

        foreach(static::get_editable_roles() as $userRoles) {
            $allCapabilities = array_merge($allCapabilities, array_keys($userRoles['capabilities']));
        }

        return (new Collection(array_unique($allCapabilities)))->filter(function($capability){
            return (new StringManager($capability))->isNotEither(static::getLevels());
        })->getValues();
    }
}
