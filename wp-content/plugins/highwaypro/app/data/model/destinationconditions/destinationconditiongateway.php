<?php

namespace HighwayPro\App\Data\Model\DestinationConditions;

use HighWayPro\App\Data\Schema\DestinationConditionTable;
use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationComponentGateway;

Class DestinationConditionGateway extends DestinationComponentGateway
{
    protected function model()
    {
        return [
            'table' => new DestinationConditionTable,
            'domain' => DestinationCondition::class
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