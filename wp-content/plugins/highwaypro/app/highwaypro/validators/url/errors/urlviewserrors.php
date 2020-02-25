<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class UrlViewsErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'state' => 'error',
                'type' =>  'url_view_statistics_invalid_url_id',
                'message' => 'The data contains a url object but the id is either missing or not valid.'
            ],
        ];
    }
}
