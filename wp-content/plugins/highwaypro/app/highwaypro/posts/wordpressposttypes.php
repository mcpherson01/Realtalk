<?php

namespace HighWayPro\App\HighWayPro\Posts;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\Original\Characters\StringManager;

Class WordPressPostTypes
{
    public static function get()
    {
        (object) $postTypes = new Collection(get_post_types(['public' => true], 'objects'));

        return $postTypes->mapwithKeys(function($postType){
            return [
                'key' => (string) $postType->name,
                'value' => (string) $postType->label
            ];
        });
    }
    
}