<?php

namespace HighWayPro\App\HighWayPro\Validators\Post\Successes;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Collections\JSONObjectsContainer;

Class PostSuccesses extends JSONObjectsContainer
{
    public static function getPosts(Array $posts, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'posts' => $posts
        ]);
    }
}
