<?php

namespace HighwayPro\App\Data\Model\DestinationConditions;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighwayPro\App\Data\Model\Destinations\DestinationComponentDomain;

Class DestinationCondition extends DestinationComponentDomain
{
    protected function getConditionComponent()
    {
        return $this->getComponent(DestinationConditionComponent::type);
    }

    public function getEvent()
    {
        return $this->getConditionComponent()->getEvent();  
    }

    public function hasPassed()
    {
        (boolean) $hasItPassed = $this->expect($this->getConditionComponent()->hasPassed())->toBeBoolean();

        return $hasItPassed;

    }
}