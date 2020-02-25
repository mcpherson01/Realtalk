<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class DestinationErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'state' => 'error',
                'type' =>  'destination_with_id',
                'message' => 'The data has a destination id. This resource requires no destination id.'
            ],
            [
                'state' => 'error',
                'type' =>  'destination_with_position',
                'message' => 'The data has a destination position. This resource accepts no explicit destination position. The position is set upon creation.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_no_id',
                'message' => 'The data contains no url id. This resource requires a valid url entity to be associated with.'
            ],
            [
                'state' => 'error',
                'type' =>  'destination_with_invalid_url_id',
                'message' => 'The data contains an invalid url id. This resource requires a valid url entity to be associated with.'
            ],
            [
                'state' => 'error',
                'type' =>  'destination_not_associated_with_a_url',
                'message' => 'The data contains a destination that is associated to no url. This resource requires a destination that is associated with a previously created url.'
            ],
            [
                'state' => 'error',
                'type' =>  'destination_with_no_id',
                'message' => 'The data contains no destination id. This resource requires a destination entity to be associated with.'
            ],
            [
                'state' => 'error',
                'type' =>  'destination_with_invalid_destination_id',
                'message' => 'The data contains an invalid destination id. This resource requires a valid destination entity to be associated with.'
            ],
            [
                'state' => 'error',
                'type' =>  'destination_with_mismatched_url_id',
                'message' => 'The data contains a valid url id that is not associated with this destination. This resource requires a valid url entity to be associated with.'
            ],
            [
                'state' => 'error',
                'type' =>  'invalid_destination_data',
                'message' => 'The data either contains no destination id or no destination position, or contains more than that. This resource requires only a valid destination id and a new position to be set to the destination.'
            ],
            [
                'state' => 'error',
                'type' =>  'destination_with_invalid_position',
                'message' => 'The data contains a invalid destination position. A valid position must be an integer greater than 0.'
            ],
            [
                'state' => 'error',
                'type' =>  'invalid_destination_data_delete',
                'message' => 'The data either contains no destination id or contains more than that. This resource requires only a valid destination id.'
            ],
        ];
    }
}
