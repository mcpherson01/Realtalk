<?php

namespace HighWayPro\App\HighWayPro\Controllers\Destination;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationDeleteRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Delete\DestinationDeleteValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;

Class DestinationDeleterController extends Controller
{
    const path = 'destinations/delete';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new DestinationDeleteValidator,
        ]);
    }

    protected function request()
    {
        return new DestinationDeleteRequest;
    }

    public function control()
    {
        (object) $destinationGateway = new DestinationGateway(new WordPressDatabaseDriver);
        (object) $destination = $destinationGateway->getWithId($this->request->data->destination->id);

        $deletionResult = $destinationGateway->deleteDestinationAndItsComponents($destination);

        if (!($destination instanceOf Destination) || $deletionResult === false || WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                DestinationSuccesses::getDestinationsWithComponents(
                                    $destination->getUrl()->getDestinationsIncludingThoseWithoutATarget(), 
                                    'destination_delete_success',
                                    'Destination permanently deleted.'
                                )->asArray()
                              );
    }
}   
