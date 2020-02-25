<?php

namespace HighwayPro\App\Data\Model\Destinations;

use HighWayPro\App\Data\Schema\DestinationTable;
use HighWayPro\App\Data\Schema\DestinationTargetTable;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Model\Gateway;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationConditionGateway;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTargetGateway;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Urls\Url;

Class DestinationGateway extends Gateway
{
    protected function model()
    {
        return [
            'table' => new DestinationTable,
            'domain' => Destination::class
        ];
    }

    public function getDestinationConditionGateway()
    {
        return new DestinationConditionGateway($this->driver);
    }
    
    public function getDestinationTargetGateway()
    {
        return new DestinationTargetGateway($this->driver);
    }

    public function insertWithUrlId($urlId)
    {
        (integer) $position = $this->getPositionOfLastdestinationFor($urlId) + 1;
        
        $this->driver->execute(
            "INSERT INTO {$this->table->getName()} 
             (url_id, position, date) VALUES(?, ?, ?)",
             [$urlId, $position, date('Y-m-d H:i:s')]  
        );

        return $this->driver->wpdb->insert_id;
    }

    public function getPositionOfLastdestinationFor($urlId)
    {
        (array) $destinations = $this->driver->get(
            "SELECT position FROM {$this->table->getName()} 
             WHERE url_id = ? 
             ORDER BY position DESC 
             LIMIT 1", 
            [$urlId]
        );

        return count($destinations)? (integer) $destinations[0]['position'] : 0;
    }

    public function getFromUrlIncludingThoseWithoutATarget(Url $url)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE url_id = ?", [$url->id])
                );
    }

    /**
     * Gets only the destinations with a valid target
     * @param  Url    $url
     * @return Collection
     */
    public function getFromUrlWithAValidTarget(Url $url)
    {
        (object) $destinationTargetsTable = new DestinationTargetTable;

        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT destination.* 
                         FROM {$this->table->getName()} destination
                         JOIN {$destinationTargetsTable->getName()} target ON destination.id = target.destination_id
                         WHERE destination.url_id = ?
                         ORDER BY destination.position ASC", 
                        [$url->id]
                    )
                );
    }

    public function updateSinglePosition(Array $destinationData)
    {
        return $this->driver->execute(
            "UPDATE {$this->table->getName()}
             SET position = ?
             WHERE id = ? LIMIT 1",
            [ 
                $destinationData['newPosition'],
                $destinationData['id']
            ]
        );
    }
    
    public function updatePositions(Array $destinationData)
    {
        (integer) $newPosition = $destinationData['newPosition'];
        (object) $destinationToUpdate = $this->getWithId($destinationData['id']);
        (boolean) $positionHasDecreased = $newPosition < $destinationToUpdate->position;
        (string) $addOrRemove = $positionHasDecreased? '+':'-';
        (string) $higherOrLowerThanNew = $positionHasDecreased? '>=': '<=';
        (string) $lowerOrHigherThanActual = $positionHasDecreased? '<=': '>=';

        // we'll take the target destination out of the current count
        $this->updateSinglePosition([
            'id' => $destinationData['id'],
            'newPosition' => 0 
        ]);

        $destinationsOrderingResult = $this->driver->execute(
            "UPDATE {$this->table->getName()}
             SET position = position {$addOrRemove} 1 
             WHERE url_id = ? 
             AND (position {$higherOrLowerThanNew} ? AND position {$lowerOrHigherThanActual} ?)",
             [
                $destinationToUpdate->url_id,
                $newPosition,
                $destinationToUpdate->position
             ]
        );

        $targetDestinationOrderingResult = $this->updateSinglePosition([
            'id' => $destinationData['id'],
            'newPosition' => $newPosition
        ]);

        if ($targetDestinationOrderingResult === false || $destinationsOrderingResult === false) {
            return false;
        }

        return $destinationsOrderingResult + $targetDestinationOrderingResult;
    }
    
    public function deleteDestinationAndItsComponents(Destination $destination)
    {
        $result = $this->delete($destination);

        if ($result === false) return false;

        $conditionsDeletionResult = $this->getDestinationConditionGateway()
                                        ->deleteAllWithDestinationId($destination->id);

        $targetsDeletionResult = $this->getDestinationTargetGateway()
                                        ->deleteAllWithDestinationId($destination->id);

        (boolean) $thereIsAnError = ($conditionsDeletionResult === false) ||
                                    ($targetsDeletionResult === false) ||
                                    WordPressDatabaseDriver::errors()->haveAny();

        if ($thereIsAnError) return false;

        return $result + $conditionsDeletionResult + $targetsDeletionResult;
    }
    
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

    public function specificDestinationWithUrlIdExists(Array $values)
    {
        (object) $destinationValues = new Collection($values);

        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT id FROM {$this->table->getName()} 
                         WHERE id = ? AND url_id = ? 
                         LIMIT 1", 
                        [
                            $destinationValues->get('id'),
                            $destinationValues->get('url_id')
                        ]
                    )
                )->haveAny();
    }
    
    public function getWithId($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE id = ?", [$id])
                )->first();
    }   

}