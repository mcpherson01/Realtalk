<?php

namespace HighWayPro\App\HighWayPro\Controllers\DestinationCondition;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\DestinationCondition\DestinationConditionDeleteRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Delete\DestinationConditionDeletionValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\DestinationConditionSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationCondition;
use HighwayPro\App\Data\Model\DestinationConditions\DestinationConditionGateway;

Class DestinationConditionDeleterController extends Controller
{
    const path = 'destinations/conditions/delete';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new DestinationConditionDeletionValidator,
        ]);
    }

    protected function request()
    {
        return new DestinationConditionDeleteRequest;
    }

    public function control()
    {
        (object) $destinationConditionGateway = new DestinationConditionGateway(new WordPressDatabaseDriver);

        $result = $destinationConditionGateway->delete(
            new DestinationCondition([
                'id' => $this->request->data->destinationCondition->id
            ])
        );

        if (($result !== 1) || WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                DestinationConditionSuccesses::get('destination_condition_delete_success')->asArray());
    }
}   