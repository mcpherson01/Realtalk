<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class UrlExtraErrors extends ErrorsContainer
{
    protected static function objects()       
    {        
        return [
            [
                'state' => 'error',
                'type' =>  'url_extra_update_invalid_name_of_field_to_update',
                'message' => 'The data contains an invalid field to update.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_extra_update_unexisting_value_field',
                'message' => 'The data contains no value to update.'
            ],
        ];
    }
}
