<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Events\Handler\EventHandler;

Class TextDomainHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        load_plugin_textdomain(
            Env::textDomain(), 
            false, 
            Env::directory() . '/international' 
        );       
    }
}