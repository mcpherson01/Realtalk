<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighWayPro\App\Data\Schema\DestinationTargetTable;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class DestinationTargetErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'state' => 'error',
                'type' =>  'destination_with_target_with_different_id',
                'message' => 'The data has a destination associated with another destination target. This resource requires a destination with no destination targets or the same destination target to be associated with the given destination.'
            ],
            [
                'state' => 'error',
                'type' =>  'target_with_invalid_type',
                'message' => 'The data has a destination target with an invalid target type. This resource requires a valid registered target type.'
            ],
            [
                'state' => 'error',
                'type' =>  'new_target_destination_with_target',
                'message' => 'The data has a destination target with no id but destination already has a target associated with it. This resource requires new targets to target a destination not already associated with a target.'
            ],
            [
                'state' => 'error',
                'type' =>  'allowed_parameter_size_exceeded',
                'message' => 'The data contains parameter characters that exceed the maximum length allowed. Maximum size allowed is less than '.DestinationTargetTable::PARAMETERS_LENGTH
            ],
        ];
    }
}
