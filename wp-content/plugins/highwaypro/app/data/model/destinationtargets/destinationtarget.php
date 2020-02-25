<?php

namespace HighwayPro\App\Data\Model\DestinationTargets;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\DestinationComponentDomain;
use HighwayPro\App\Data\Model\UrlViews\UrlViewGateway;

Class DestinationTarget extends DestinationComponentDomain
{
    protected function getTargetComponent()
    {
        return $this->getComponent(DestinationTargetComponent::type);
    }

    public function getEvent()
    {
        return $this->getTargetComponent()->getEvent();  
    }

    public function send()
    {
        (object) $response = $this->expect($this->getTargetComponent()->response())->toBe(Response::class);

        $response->send();

        if ($response->shouldSaveView()) {
            (new UrlViewGateway(new WordPressDatabaseDriver))->saveView(
                $this->destination->createView()
            );
        }

        if ($response->needsToExit()) {
            exit;
        }
    }
}