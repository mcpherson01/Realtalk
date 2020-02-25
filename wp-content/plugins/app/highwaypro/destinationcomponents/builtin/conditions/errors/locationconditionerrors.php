<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class LocationConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'invalid_countries_selected',
                'state' => 'error',
                'message' => 'Invalid countries selected. This condition requires at least one valid country ISO code.'
            ],
        ];
    }
}
