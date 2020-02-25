<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\ExpiringCondition;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class ExpiringConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'no_date_selected',
                'state' => 'error',
                'message' => 'No date selected. This condition requires at least one valid date with the format '.ExpiringCondition::DATE_FORMAT
            ],
            [
                'type' => 'invalid_date_format',
                'state' => 'error',
                'message' => 'This condition requires a valid date with the format '.ExpiringCondition::DATE_FORMAT
            ],
        ];
    }
}
