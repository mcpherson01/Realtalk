<?php

namespace HighWayPro\App\HighWayPro\Validators\Post\Successes;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\JSONObjectsContainer;

Class TermSuccesses extends JSONObjectsContainer
{
    public static function getTerms(Array $terms, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'terms' => $terms
        ]);
    }
}
