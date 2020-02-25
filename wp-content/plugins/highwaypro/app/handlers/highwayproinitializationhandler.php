<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\App\HighWayPro\System\Dispatcher;
use HighWayPro\App\HighWayPro\System\Router;
use HighWayPro\App\HighWayPro\System\URLComponentsRegistrator;
use HighWayPro\Original\Events\Handler\EventHandler;

Class HighWayProInitializationHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        (object) $highwayProDispatcher = new Dispatcher(new Router(new Request));

        $highwayProDispatcher->dispatch();       
    }
}