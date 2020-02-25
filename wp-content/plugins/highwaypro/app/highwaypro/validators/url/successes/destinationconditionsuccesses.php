<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Successes;

use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationComponentSuccesses;

Class DestinationConditionSuccesses extends DestinationComponentSuccesses
{
    const type = 'condition';

    protected static function objects()       
    {
        return [
            [
                'state' => 'success',
                'type' =>  'destination_condition_delete_success',
                'message' => 'This resource has been permanently deleted.'
            ]
        ];
    }
}
