<?php

namespace HighWayPro\App\HighWayPro\Validators\Post\Successes;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\JSONObjectsContainer;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class PreferencesSuccesses extends JSONObjectsContainer
{
    public static function getUpdatedValue(Preferences $preferences, $type)
    {
        return new Collection([
            'state' => 'success',
            'message' => 'Preferences successesfully updated.',
            'type' =>  $type,
            'preferences' => json_decode($preferences->unMap())
        ]);
    }
}
