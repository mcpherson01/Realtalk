<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\App\HighwayPro\HTTP\Responses\NotFoundResponse;
use HighwayPro\App\HighwayPro\HTTP\Responses\Redirection;

/*
    Shows the 404 template, sets 404 http status code
*/
Class NotFoundTarget extends DestinationTargetComponent
{
    const event = 'wp';

    const name  = 'highwaypro.NotFoundTarget';

    public static function title()
    {
        return __('Not Found', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Redirect to a 404 (Not Found) page.', Env::textDomain());
    }

    public static function description()
    {
        return __("This target sends an http 404 (Not Found) response.\nThis target has no options.\nThis target is useful when you want to explicitly exclude a certain type of users, for example, from a specific country or users with a specific device.\nClick 'OK' to continue.", Env::textDomain());
    }

    protected function parametersMap()
    {
        return [
        ];
    }

    public function response()
    {
        return (new NotFoundResponse);
    }

    public function validateParameters()
    {
        return true;
    }
}