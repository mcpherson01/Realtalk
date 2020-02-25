<?php

namespace HighWayPro\Original\Events\Handler;

use HighWayPro\Original\Utilities\ClassName;
use HighWayPro\Original\Cache\MemoryCache;

Abstract Class EventHandler
{
    use ClassName;

    protected $event;
    protected $numberOfArguments = 1;
    protected $priority = 10;


    //The abstract method, not defined because of the dynamic nature of hook arguments
    #abstract public function execute();
   
    public static final function register($event)
    {
        (object) $handler = new Static($event);

        add_action(
            $event, 
            [$handler, 'execute'],
            $handler->priority,
            $handler->numberOfArguments
        );
    }

    public function __construct()
    {
        $this->cache = new MemoryCache;
    }
 
    protected function dispatcher($method)
    {
        return [$this, $method];   
    }   
}