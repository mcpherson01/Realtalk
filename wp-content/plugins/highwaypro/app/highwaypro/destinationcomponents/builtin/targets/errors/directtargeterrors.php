<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class DirectTargetErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'no_target_url',
                'message' => 'This target requires valid url.'
            ],
            [
                'type' => 'invalid_url_format',
                'state' => 'error',
                'message' => 'Invalid URL format. This target requires a valid URL. Valid URLS may include a scheme, user info and/or a path. Examples of valid URLS include: google.com/search, https://google.com/search?query=highwaypro'
            ],
        ];
    }
}
