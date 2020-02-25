<?php

namespace HighWayPro\App\HighWayPro\Controllers\Destination;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Create\DestinationCreationValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;

Class DestinationCreatorController extends Controller
{
    const path = 'destinations/new';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new DestinationCreationValidator,
        ]);
    }

    protected function request()
    {
        return new DestinationCreationRequest;
    }

    public function control()
    {
        (object) $destinationGateway = new DestinationGateway(new WordPressDatabaseDriver);

        (boolean) $insertedUrlId = $destinationGateway->insertWithUrlId($this->request->data->url->id);
        (object) $destination = $destinationGateway->getWithId($insertedUrlId);

        if (($insertedUrlId < 0) || !($destination instanceof Destination)) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(201)
                             ->containing(
                                DestinationSuccesses::getDestination(
                                    $destination, 'destination_create_success'
                                )->asArray());
    }
}   
