<?php

namespace HighwayPro\App\Data\Model\DestinationConditions\Validators;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationConditionGateway;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\Validators\DestinationComponentValidator;

Class DestinationConditionValidator extends DestinationComponentValidator
{
    protected $destinationConditionFields;
    protected $urlGateway;
    protected $destinationGateway;
    protected $parameterError;

    public function getDestinationComponentGateway()
    {
        return new DestinationConditionGateway(new WordPressDatabaseDriver, new Destination([]));   
    }

    public function getComponentType()
    {
        return DestinationCondition::class;
    }

    public function getComponentExtensionType()
    {
        return DestinationConditionComponent::type;   
    }
}