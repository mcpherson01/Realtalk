<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Successes;

use HighWayPro\Original\Collections\Collection;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\Original\Collections\JSONObjectsContainer;

Class DestinationSuccesses extends JSONObjectsContainer
{
    public static function getDestination(Destination $destination, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'url' => [
                'id' => $destination->url_id,
            ],
            'destination' => $destination->getWithComponents()
        ]);
    }

    public static function getDestinations(Collection $destinations, $type)
    {
        return new Collection([
            'state' => 'success',
            'type' =>  $type,
            'destinations' => $destinations->forEvery(function(Destination $destination){
                unset($destination->date);
            })->asArray()
        ]);   
    }

    public static function getDestinationsWithComponents(Collection $destinations, $type, $message = '')
    {
        return new Collection([
            'state' => 'success',
            'message' => $message,
            'type' =>  $type,
            'destinations' => $destinations->map(function(Destination $destination){
                unset($destination->date);
                return $destination->getWithComponents();
            })
        ]);   
    }

}