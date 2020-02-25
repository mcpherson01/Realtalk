<?php

namespace HighWayPro\App\HighWayPro\Controllers\DestinationTarget;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\HTTP\Requests\DestinationTarget\DestinationTargetCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Create\DestinationTargetCreationValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationTargetSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTarget;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTargetGateway;

Class DestinationTargetCreatorController extends Controller
{
    const path = 'destinations/targets/set';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new DestinationTargetCreationValidator,
        ]);
    }

    protected function request()
    {
        return new DestinationTargetCreationRequest;
    }

    public function control()
    {
        (object) $destinationTargetGateway = new DestinationTargetGateway(new WordPressDatabaseDriver);

        $result = $destinationTargetGateway->deleteAllWithDestinationIdAndInsertNew(
            new DestinationTarget(
                $this->request->getDestinationComponentFields()
            )
        );

        (object) $destinationTarget = $destinationTargetGateway->getWithId(
            $destinationTargetGateway->driver->wpdb->insert_id
        );

        if (($result === false) || !($destinationTarget instanceof DestinationTarget)) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(201)
                             ->containing(
                                DestinationTargetSuccesses::getDestinationComponentCreated(
                                    $destinationTarget
                                )->asArray());
    }
}   
