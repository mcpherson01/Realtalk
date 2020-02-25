<?php

namespace HighWayPro\App\HighWayPro\Controllers\UrlType;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\HTTP\Requests\UrlType\UrlTypeCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Create\UrlTypeCreationValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlTypeSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;

Class UrlTypeCreatorController extends Controller
{
    const path = 'urls/types/new';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlTypeCreationValidator,
        ]);
    }

    protected function request()
    {
        return new UrlTypeCreationRequest;
    }

    public function control()
    {
        (object) $urlTypeGateway = new UrlTypeGateway(new WordPressDatabaseDriver);

        $response = $urlTypeGateway->insert(new UrlType($this->request->data->urlType->asArray()));

        (object) $urlType = $urlTypeGateway->getWithId($urlTypeGateway->driver->wpdb->insert_id);

        if (($response !== 1) || !($urlType instanceof UrlType)) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(201)
                             ->containing(
                                UrlTypeSuccesses::getUrlType($urlType, 'url_type_create_success', 'URL Type successfully created.')->asArray()
                             );
    }
}   
