<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\DestinationCondition;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\Destinations\Destination;

Class DestinationConditionDeleteRequest extends Request
{
    protected $type = 'condition';
    
    public function map()
    {
        return [
            'destinationCondition' => DestinationCondition::fields()->only(['id'])->asArray()
        ];
    }
}