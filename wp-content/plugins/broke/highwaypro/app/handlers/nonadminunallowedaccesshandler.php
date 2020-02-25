<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\Original\Events\Handler\EventHandler;
use HighwayPro\App\HighwayPro\HTTP\Errors\RouterErrors;

Class NonAdminUnallowedAccessHandler extends EventHandler
{
    public function execute()
    {
        (object) $request = new Request;
        (object) $response = (new Response)->withStatusCode(403)
                                           ->containing(
                                                RouterErrors::get('unallowed_access')->asArray()
                                            );

        $response->send();
        $request->finish();           
    }
}