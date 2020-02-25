<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\ExpiringCondition;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class RefererConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'no_referers_specified',
                'state' => 'error',
                'message' => 'No referrers have been specified. This condition requires at least one domain or url.'
            ],
            [
                'type' => 'invalid_domain_format',
                'state' => 'error',
                'message' => 'Invalid domain (host) format. This condition requires a valid URI host. Valid hosts include no scheme, no user info and no path. An example of a valid domain is: google.com'
            ],
            [
                'type' => 'invalid_url_format',
                'state' => 'error',
                'message' => 'Invalid URL format. This condition requires a valid URL. Valid URLS may include a scheme, user info and/or a path. Examples of valid URLS include: google.com/search, https://google.com/search?query=highwaypro'
            ],
        ];
    }
}
