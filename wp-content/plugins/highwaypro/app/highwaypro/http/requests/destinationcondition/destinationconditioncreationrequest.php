<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\DestinationCondition;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationComponentCreationRequest;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Characters\StringManager;
use HighwayPro\Original\Collections\Mapper\Types;

Class DestinationConditionCreationRequest extends DestinationComponentCreationRequest
{
    protected $type = 'condition';
    
    public function map()
    {
        return [
            'url' => Url::fields()->only(['id'])->asArray(),
            'destination' => [
                'id' => Types::INTEGER,
                'condition' => DestinationCondition::fields()->except(['destination_id'])->asArray()
            ]
        ];
    }
}