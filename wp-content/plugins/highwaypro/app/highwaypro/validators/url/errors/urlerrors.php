<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class UrlErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        (string) $validPathMessage = PathManager::getValidPathMessage();
        
        return [
            [
                'state' => 'error',
                'type' =>  'empty_url_object',
                'message' => 'The url contains no data.'
            ],
            [
                'state' => 'error',
                'type' =>  'empty_url_name',
                'message' => 'The url contains no name. Please provide a valid name.'
            ],
            [
                'state' => 'error',
                'type' =>  'empty_url_path',
                'message' => 'The url contains no path. Please provide a valid path.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_id',
                'message' => 'The url contains an id'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_invalid_path',
                'message' => "The url contains a malformed path. {$validPathMessage}" 
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_registered_path',
                'message' => 'The url contains a path that is already being used. No more than one path per site with the same characters is allowed.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_nonexistent_type',
                'message' => 'The url contains an type id that does not exist.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_invalid_name',
                'message' => 'The url contains a malformed name. Names must contain either number or letters optionally separated by one or more spaces.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_existing_name',
                'message' => 'The url contains a name that is already being used. No more than one url can have the same name.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_update_invalid_name_of_field_to_update',
                'message' => 'The data contains an invalid name of the field to update'
            ],
            [
                'state' => 'error',
                'type' =>  'url_update_invalid_field_to_update',
                'message' => 'The data contains an invalid field to update. The url must contain an id and a valid updateable field, nothing more and nothing less.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_no_id',
                'message' => 'The data contains no url id. This resource requires a valid url id'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_invalid_id',
                'message' => 'The data contains an invalid url id. This resource requires a valid url id'
            ],
            [
                'state' => 'error',
                'type' =>  'url_with_invalid_data_delete',
                'message' => 'The data either contains no url id or contains more than that. This resource requires only a valid url id.'
            ],
        ];
    }
}
