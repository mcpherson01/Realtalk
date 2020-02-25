<?php

namespace HighwayPro\App\Data\Model\DestinationTargets;

use HighWayPro\App\Data\Schema\DestinationTargetTable;
use HighWayPro\Original\Data\Model\Gateway;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTarget;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationComponentGateway;

Class DestinationTargetGateway extends DestinationComponentGateway
{
    protected function model()
    {
        return [
            'table' => new DestinationTargetTable,
            'domain' => DestinationTarget::class
        ];
    }

    public function getFromDestination(Destination $destination) 
    {
        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT * FROM {$this->table->getName()} WHERE destination_id = ?", 
                        [$destination->id]
                    )
                )->first();
    }

    public function GetWithId($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE id = ?", [$id])
                )->first();
    }   

}