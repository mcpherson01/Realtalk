<?php

namespace HighWayPro\App\HighWayPro\HTTP\Requests\Destination;

use HighWayPro\App\HighWayPro\HTTP\Request;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTarget;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\Original\Collections\Mapper\Types;

Class DestinationComponentCreationRequest extends Request
{
    public function getDestinationComponentFields()
    {
        return array_merge(
            $this->data->destination->{$this->type}->asArray(),
            [
                'destination_id' => $this->data->destination->id
            ]
        );
    }
}