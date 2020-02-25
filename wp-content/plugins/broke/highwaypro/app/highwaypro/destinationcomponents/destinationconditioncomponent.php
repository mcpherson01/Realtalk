<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents;

use HighWayPro\Original\Environment\Env;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;

Abstract Class DestinationConditionComponent extends DestinationComponent
{
    const type = 'conditions';
    public static function description()
    {
        return __("Conditions are optional.
    When you set a condition, the target associated with the destination will be discarded if the condition for the destination is not met. 
    If the target is discarded, control will be passed to the next destination.", Env::textDomain());
    }
                                    
    abstract public function hasPassed();
}