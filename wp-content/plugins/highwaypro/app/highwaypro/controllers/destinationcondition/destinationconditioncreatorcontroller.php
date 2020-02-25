<?php

namespace HighWayPro\App\HighWayPro\Controllers\DestinationCondition;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\HTTP\Requests\DestinationCondition\DestinationConditionCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Create\DestinationConditionCreationValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationConditionSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationConditionGateway;

Class DestinationConditionCreatorController extends Controller
{
    const path = 'destinations/conditions/set';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new DestinationConditionCreationValidator,
        ]);
    }

    protected function request()
    {
        return new DestinationConditionCreationRequest;
    }

    public function control()
    {
        (object) $destinationConditionGateway = new DestinationConditionGateway(new WordPressDatabaseDriver);

        $result = $destinationConditionGateway->deleteAllWithDestinationIdAndInsertNew(
            new DestinationCondition(
                $this->request->getDestinationComponentFields()
            )
        );

        (object) $destinationCondition = $destinationConditionGateway->getWithId(
            $destinationConditionGateway->driver->wpdb->insert_id
        );

        if (($result === false) || !($destinationCondition instanceof DestinationCondition)) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(201)
                             ->containing(
                                DestinationConditionSuccesses::getDestinationComponentCreated(
                                    $destinationCondition
                                )->asArray());
    }
}   
