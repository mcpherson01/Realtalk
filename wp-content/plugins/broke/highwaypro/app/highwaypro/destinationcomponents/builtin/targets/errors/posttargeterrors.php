<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class PostTargetErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'invalid_type',
                'message' => 'Invalid type of posts. Valid types are: newest and withid.'
            ],
            [
                'type' => 'empty_post_id',
                'message' => 'Empty post id. This target requires a valid post id.'
            ],
            [
                'type' => 'invalid_post_id',
                'message' => 'Nonexistent post. This target requires a valid post id.'
            ],
        ];
    }
}

