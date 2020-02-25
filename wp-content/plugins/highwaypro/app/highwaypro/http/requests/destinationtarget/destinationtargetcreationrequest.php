<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\DestinationTarget;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationComponentCreationRequest;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTarget;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Collections\Mapper\Types;

Class DestinationTargetCreationRequest extends DestinationComponentCreationRequest
{
    protected $type = 'target';
    
    public function map()
    {
        return [
            'url' => Url::fields()->only(['id'])->asArray(),
            'destination' => [
                'id' => Types::INTEGER,
                'target' => DestinationTarget::fields()->except(['destination_id'])->asArray()
            ]
        ];
    }
}