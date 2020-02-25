<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Successes;

use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Utilities\TypeChecker;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationComponentDomain;
use HighwayPro\Original\Collections\JSONObjectsContainer;

Abstract Class DestinationComponentSuccesses extends JSONObjectsContainer
{
    public static function getDestinationComponentCreated(DestinationComponentDomain $destinationComponent)
    {
        return new Collection([
            'state' => 'success',
            'message' => 'Destination component successfully saved.',
            'type' =>  'destination_'. static::type .'_set_success',
            'url' => [
                'id' => $destinationComponent->getDestination()->url_id,
            ],
            'destination' => [
                'id' => $destinationComponent->getDestination()->id,
                static::type => $destinationComponent->getAvailableValuesBut(['destination_id'])
            ]
        ]);
    }
}
