<?php

namespace HighwayPro\App\Data\Model\DestinationTargets\Validators;

use HighWayPro\App\HighWayPro\DestinationComponents\DestinationTargetComponent;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTarget;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTargetGateway;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\Validators\DestinationComponentValidator;

Class DestinationTargetValidator extends DestinationComponentValidator
{
    protected $destinationConditionFields;
    protected $urlGateway;
    protected $destinationGateway;
    protected $parameterError;

    public function getDestinationComponentGateway()
    {
        return new DestinationTargetGateway(new WordPressDatabaseDriver, new Destination([]));   
    }

    public function getComponentType()
    {
        return DestinationTarget::class;
    }

    public function getComponentExtensionType()
    {
        return DestinationTargetComponent::type;   
    }
}