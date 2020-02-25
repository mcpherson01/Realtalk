<?php

namespace HighWayPro\App\HighWayPro\System;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class Router
{
    protected $request;

    public function __construct(Request $request, UrlGateway $urlGateway = null)
    {
        $this->request = $request;
        $this->urlGateway = $urlGateway? $urlGateway : new UrlGateway(new WordPressDatabaseDriver);
    }

    public function findRoute()
    {
        if ($this->request->methodIs('GET') && 
            $this->request->paths->haveAtLeast(1) && 
            $this->request->paths->haveLessThan(3)
           ) {
            $this->matchedUrls = $this->urlGateway->getFromFullPath($this->request->paths);
        } else {
            $this->matchedUrls = new Collection([]);
        }
    }

    public function getEarliestEventNeeded()
    {
        if ($this->matchedUrls->haveAny()) {
            (string) $latestEventNeeded = $this->matchedUrls->first()->getLatestEvent();

            return ($latestEventNeeded === 'plugins_loaded')? Dispatcher::afterDispatchEvent : $latestEventNeeded;
        }

        return Dispatcher::nonMatchingUrlEvent;
    }

    public function foundRoute()
    {
        return $this->matchedUrls->haveAny() && 
               ($this->matchedUrls->first()->getDestination() instanceof Destination);   
    }

    public function getUrl()
    {
        return $this->matchedUrls->first();   
    }
}