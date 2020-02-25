<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class DestinationConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'state' => 'error',
                'type' =>   'destination_with_condition_with_different_id',
                'message' => 'The data has a destination associated with another destination condition. This resource requires a destination with no destination conditions or the same destination condition to be associated with the given destination.'
            ],
            [
                'state' => 'error',
                'state' => 'error',
                'type' =>   'condition_with_invalid_type',
                'message' => 'The data has a destination condition with an invalid condition type. This resource requires a valid registered condition type.'
            ],
            [
                'state' => 'error',
                'state' => 'error',
                'type' =>   'new_condition_destination_with_condition',
                'message' => 'The data has a destination condition with no id but this destination already has a condition associated with it. This resource requires new conditions to target a destination not already associated with a condition.'
            ],
            [
                'state' => 'error',
                'state' => 'error',
                'type' =>   'condition_with_invalid_id',
                'message' => 'The data has a destination condition with an invalid condition id. This resource requires a valid registered condition.'
            ],
            [
                'state' => 'error',
                'state' => 'error',
                'type' =>   'condition_delete_invalid_fields',
                'message' => 'The data has either no destination condition id or has more than that. This resource requires only a valid destination condition id.'
            ]
        ];
    }
}
