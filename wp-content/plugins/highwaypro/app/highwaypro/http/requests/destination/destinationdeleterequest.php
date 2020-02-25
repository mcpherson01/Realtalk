<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Destination;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighwayPro\App\Data\Model\Destinations\Destination;

Class DestinationDeleteRequest extends Request
{
    public function map()
    {
        return [
            'destination' => Destination::fields()->only(['id'])->asArray(),
        ];
    }    
}