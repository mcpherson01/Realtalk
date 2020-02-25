<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class UserAgentConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'non_valid_user_agents',
                'state' => 'error',
                'message' => 'This condition requires at least one valid user agent.'
            ],
        ];
    }
}
