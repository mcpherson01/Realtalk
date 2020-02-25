<?php

namespace HighwayPro\App\HighwayPro\HTTP\Errors;

use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\HighwayPro\HTTP\Errors\ErrorsContainer;

Class DatabaseErrors extends ErrorsContainer
{
    protected static function objects()       
    {
        return [
            [
                'type' => 'database_error',
                'message' => static::getDatabaseErrorMessage()
            ]
        ];
    }

    public static function getDatabaseErrorMessage()
    {
        (object) $errors = WordPressDatabaseDriver::errors();

        if ($errors->haveAny() && current_user_can('administrator')) {
            return $errors->reduce(function($message, Collection $error){
                return $message .= "----\n".
                                   "Error: {$error->get('error_str')}.\n".
                                   "Query: {$error->get('query')}\n".
                                   "----\n";
            })->get();
        }   

        return 'There is a Database error.';
    }
    
}
