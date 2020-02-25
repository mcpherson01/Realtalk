<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Destination;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighwayPro\App\Data\Model\Destinations\Destination;

Class DestinationUpdateRequest extends Request
{
    public function map()
    {
        return [
            'destination' => Destination::fields()->only(['id', 'position'])->asArray(),
        ];
    }

    public function getUpdateData()
    {
        return [
            'id' => $this->data->destination->id,
            'newPosition' => $this->data->destination->position
        ];   
    }
    
}