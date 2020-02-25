<?php

namespace HighwayPro\App\Data\Model\Destinations;

use HighWayPro\App\HighWayPro\System\URLComponentsRegistrator;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Model\Domain;
use HighWayPro\Original\Utilities\TypeChecker;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;
use HighwayPro\Original\Collections\Mapper\Types;

Class DestinationComponentDomain extends Domain
{
    use TypeChecker;

    protected $destination;
    protected $destinationGateway;

    public static function fields()
    {
        return new Collection([
            'id' => Types::INTEGER,
            'destination_id' => Types::INTEGER,
            'type' => Types::STRING,
            'parameters' => Types::STRING()->escape(Types::returnValueCallable()),
        ]);   
    }

    public function beforeInsertion()
    {
        unset($this->id);
    }

    protected function map()
    {
        return static::fields()->asArray();
    }

    protected function setUp(Destination $destination = null)
    {
        $this->destination = $destination;
        $this->destinationGateway = new DestinationGateway(new WordPressDatabaseDriver);
    }

    protected function getComponent($type)
    {
        return URLComponentsRegistrator::get()->createComponent([
            'type' => $type,
            'component' => $this->type->get(),
            'parameters' => $this->parameters->get(),
            'destination' => $this->getDestination()
        ]);   
    }    

    public function getDestination()
    {
        if (!($this->destination instanceof Destination)) {
            $this->destination = $this->destinationGateway->getWithId($this->destination_id);
        }

        return $this->destination;
    }
}