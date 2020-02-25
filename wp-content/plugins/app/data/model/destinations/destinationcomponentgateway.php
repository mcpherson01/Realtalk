<?php

namespace HighwayPro\App\Data\Model\Destinations;

use HighWayPro\App\Data\Schema\DestinationConditionTable;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Model\Gateway;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationComponentDomain;

Abstract Class DestinationComponentGateway extends Gateway
{
    /**
     * This method checks the existence of a row with an id 
     * it does not do JOINs as opposed to getWithId
     */
    public function idExists($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT id FROM {$this->table->getName()} WHERE id = ?", 
                        [$id]
                    )
                )->haveAny();
    } 
    
    public function deleteAllWithDestinationIdAndInsertNew(DestinationComponentDomain $destinationComponent)
    {
        $this->expect($destinationComponent)->toBe($this->domainType);

        $deleteResult = $this->deleteAllWithDestinationId($destinationComponent->destination_id);
        
        if ($deleteResult === false) {
            return false;
        }

        $insertResult = $this->insert($destinationComponent);

        if ($insertResult !== 1) {
            return false;
        }

        return true;
    }   

    public function deleteAllWithDestinationId($destinationId)
    {
        return $this->driver->execute(
            "DELETE FROM {$this->table->getName()} WHERE destination_id = ? LIMIT 1", 
            [
                $destinationId
            ]
        );
    }
}

