<?php

namespace HighWayPro\App\HighWayPro\Controllers\Destination;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationSuccesses;
use HighWayPro\App\HighWayPro\Validators\Url\Update\DestinationUpdateValidator;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;
use HighwayPro\App\Data\Model\Urls\Url;

Class DestinationUpdaterController extends Controller
{
    const path = 'destinations/edit';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new DestinationUpdateValidator,
        ]);
    }

    protected function request()
    {
        return new DestinationUpdateRequest;
    }

    public function control()
    {
        (object) $destinationGateway = new DestinationGateway(new WordPressDatabaseDriver);

        $updateResult = $destinationGateway->updatePositions($this->request->getUpdateData());

        (object) $destination = $destinationGateway->getWithId($this->request->data->destination->id);

        if ($updateResult === false) {
            return new DatabaseErrorResponse;
        }

        if (!($destination instanceof Destination)) {
            return (new Response)->withStatusCode(205);
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                DestinationSuccesses::getDestinations(
                                    $destination->getUrl()->getDestinationsIncludingThoseWithoutATarget(), 
                                    'destination_update_success'
                                )->asArray()
                              );
    }
}   
