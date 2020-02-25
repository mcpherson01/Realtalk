<?php

namespace HighWayPro\App\HighWayPro\Controllers\Url;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Create\UrlCreationValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class UrlCreatorController extends Controller
{
    const path = 'urls/new';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlCreationValidator,
        ]);
    }

    protected function request()
    {
        return new UrlCreationRequest;
    }

    public function control()
    {
        (object) $urlGateway = new UrlGateway(new WordPressDatabaseDriver);

        $response = $urlGateway->insert(new Url($this->request->data->url->asArray()));

        (object) $url = $urlGateway->getWithId($urlGateway->driver->wpdb->insert_id);

        if (($response !== 1) || !($url instanceof Url)) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(201)
                             ->containing(
                                UrlSuccesses::getUrl($url, 'url_create_success')->asArray()
                             );
    }
}   

