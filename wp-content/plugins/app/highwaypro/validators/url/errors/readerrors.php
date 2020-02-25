<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class ReadErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'state' => 'error',
                'type' =>  'request_no_id',
                'message' => 'The data contains no id. This resource requires a valid id.'
            ],
        ];
    }

    public static function getErrorWithReceivedData($type, Request $request)
    {
        (string) $dataFound = $request->data->dataFound->asCollection()->asJson()->get();

        return new Collection([
            'state' => 'error',
            'type' =>  $type,
            'message' => "Invalid data received, we received: {$dataFound}",
        ]);
    }
}
