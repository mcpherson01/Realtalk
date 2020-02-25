<?php

namespace HighwayPro\App\HighwayPro\HTTP\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class RouterErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'invalid_http_method',
                'message' => 'Invalid method.'
            ],
            [
                'type' => 'invalid_request_not_found',
                'message' => 'Resource not found'
            ],
            [
                'type' => 'unallowed_access',
                'message' => 'Access to this resource is forbidden.'
            ]
        ];
    }
}