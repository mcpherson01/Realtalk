<?php

namespace HighwayPro\App\Data\Model\destinations\Validators;

use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class DestinationValidator
{
    protected $destinationFields;
    protected $urlGateway;
    protected $destinationGateway;
    
    public function __construct(Array $destinationFields)
    {
        $this->destinationFields = new Collection($destinationFields);   
        $this->urlGateway = new UrlGateway(new WordPressDatabaseDriver);
        $this->destinationGateway = new DestinationGateway(new WordPressDatabaseDriver);
    }

    public function urlDoesNotExist()
    {
        return !$this->urlGateway->idExists($this->destinationFields->get('url_id'));
    }

    public function idDoesNotExist()
    {
        return !$this->destinationGateway->idExists($this->destinationFields->get('id'));
    }

    public function hasNoUrlAssociated()
    {
        (object) $destination = $this->destinationGateway->getWithId($this->destinationFields->get('id'));

        if (!($destination instanceof Destination)) {
            return true;
        }

        return !$this->urlGateway->idExists($destination->url_id);
    }
    

    public function urlIsNotAssociatedWithDestination()
    {
        return !$this->destinationGateway->specificDestinationWithUrlIdExists([
            'id' => $this->destinationFields->get('id'),
            'url_id' => $this->destinationFields->get('url_id')
        ]);
    }

    public function positionIsInvalid()
    {
        return $this->destinationFields->get('position') < 1;   
    }
    
}