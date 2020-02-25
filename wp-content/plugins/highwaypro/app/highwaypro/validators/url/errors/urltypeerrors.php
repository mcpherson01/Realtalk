<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Errors;

use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class UrlTypeErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        (object) $updatablefields = UrlType::updatableFields();
        (string) $validPathMessage = PathManager::getValidPathMessage();
        
        return [
            [
                'state' => 'error',
                'type' =>  'url_type_with_id',
                'message' => 'The data has a url type id. This resource requires no url type id.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_invalid_id',
                'message' => 'The data has an invalid url type id. This resource requires a valid url type id.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_no_name',
                'message' => 'The data has no name. This resource requires a valid name.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_invalid_name',
                'message' => 'The data has an invalid name. Valid names contain only letters, numbers, underscores and/or spaces.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_existing_name',
                'message' => 'The data contains a url type name that is already being used. No more than one url type can have the same name.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_invalid_path',
                'message' => "The data contains a malformed path. Paths are optional. {$validPathMessage}"
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_existing_path',
                'message' => 'The data has an existing path. Paths are optional. This resource requires a path name that is not used by other url types.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_invalid_color',
                'message' => 'The data has an invalid color. This resource requires a valid color.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_with_no_name_of_field_to_update',
                'message' => 'The data has no field to update. This resource requires a valid field name to be updated.'
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_invalid_field_name_to_update',
                'message' => "The data contains an invalid field name to update. A valid field name is one of the following: {$updatablefields->asList()->ensureRight('.')}"
            ],
            [
                'state' => 'error',
                'type' =>  'url_type_invalid_field_to_update',
                'message' => 'The data either contains no valid field to update or contains more than what it is acceptable for this request to be processed. The data must contain a valid url type id and a valid updateable field with a valid value, nothing more and nothing less.'
            ],
        ];
    }
}
