<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class DisposableConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'invalid_number',
                'state' => 'error',
                'message' => 'Invalid value. This condition requires a positive integer higher than 0.'
            ],
        ];
    }
}
