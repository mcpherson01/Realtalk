<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class DeviceConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'no_devices_selected',
                'state' => 'error',
                'message' => 'This condition requires at least one device to be selected'
            ],
            [
                'type' => 'unallowed_devices',
                'state' => 'error',
                'message' => 'Unknown or invalid device(s) selected.'
            ],
        ];
    }
}
