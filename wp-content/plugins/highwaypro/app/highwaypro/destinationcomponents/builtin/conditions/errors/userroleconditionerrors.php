<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors;

use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class UserRoleConditionErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'invalid_type_parameter',
                'state' => 'error',
                'message' => 'This condition requires the parameter userType to be one of the following: logged, unlogged, loggedwithrole'
            ],
            [
                'type' => 'invalid_logged_with_role_parameter',
                'state' => 'error',
                'message' => 'The user type "loggedwithrole" requires the parameter "capabilities" or "roles" to be a valid WordPress user capability or role.'
            ],
            [
                'type' => 'invalid_roles',
                'state' => 'error',
                'message' => 'The user roles parameter requires at leat one valid WordPress user role.'
            ],
            [
                'type' => 'invalid_capabilities',
                'state' => 'error',
                'message' => 'The user capabilities parameter requires at least one valid WordPress user capability.'
            ],
        ];
    }
}
