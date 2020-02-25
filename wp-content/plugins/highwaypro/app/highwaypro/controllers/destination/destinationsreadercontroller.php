<?php

namespace HighWayPro\App\HighWayPro\Controllers\Destination;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\Destination\DestinationsReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Read\DestinationsReadValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;
use HighwayPro\App\Data\Model\Urls\Url;

Class DestinationsReaderController extends Controller
{
    const path = 'url/destinations';
    protected static $HTTPMethod = 'GET';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new DestinationsReadValidator
        ]);
    }

    protected function request()
    {
        return new DestinationsReadRequest;
    }

    public function control()
    {
        (object) $destinationGateway = new DestinationGateway(new WordPressDatabaseDriver);

        (object) $destinations = $destinationGateway->getFromUrlIncludingThoseWithoutATarget(
            $this->request->createUrl()
        );

        if ($urls === false || WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                DestinationSuccesses::getDestinationsWithComponents($destinations, 'destinations_read_success')->asArray()
                             );
    }
}   

