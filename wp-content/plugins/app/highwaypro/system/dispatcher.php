<?php

namespace HighWayPro\App\HighWayPro\System;

use HighWayPro\App\HighWayPro\System\URLComponentsRegistrator;

Class Dispatcher
{
    const afterDispatchEvent = 'highwaypro_plugins_loaded';
    const nonMatchingUrlEvent = 'highwaypro_url_not_matched';
    
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /*
        Registers an action event to be handled by a response if the current request matches a 
        registered URL. Ignored otherwise.

        If the latest action event required is plugins_loaded, then controll
        will be dispatched to the Dispatcher::afterDispatchEvent, as the 
        plugins_loaded event has already been fired (it's the one this method is being called on) 
    */
    public function dispatch()
    {
        $this->router->findRoute();

        add_action($this->router->getEarliestEventNeeded(), [$this, 'dispatchToUrl']);

        do_action(Dispatcher::afterDispatchEvent);
    }

    /**
     * Called on the latest action hook event declared by a 
     * DestinationComponent from ALL the destinations registered 
     * to the matched url
     */
    public function dispatchToUrl()
    {
        if ($this->router->foundRoute()) {
            (object) $url = $this->router->getUrl();
            (object) $target = $url->getDestination()->getTarget();

            $target->send();
        }
    }
}