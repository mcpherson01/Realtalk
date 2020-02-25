<?php

namespace HighWayPro\App\HighWayPro\Validators\Post\Errors;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class PreferencesErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        (string) $validPathMessage = PathManager::getValidPathMessage();
        (object) $preferencesComponents = Preferences::components();
        
        return [
            [
                'state' => 'error',
                'type' =>  'invalid_preferences_field',
                'message' => 'Invalid preferences field. This resource requires one of the following components: '.$preferencesComponents->getKeys()->asList().'.'
            ],
            [
                'state' => 'error',
                'type' =>  'invalid_preferences_value',
                'message' => 'Invalid preferences value.'
            ],
        ];
    }
}
