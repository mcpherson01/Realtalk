<?php

namespace HighWayPro\App\HighWayPro\Controllers\Url;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlDeleteRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Delete\UrlDeleteValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class UrlDeleterController extends Controller
{
    const path = 'urls/delete';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlDeleteValidator,
        ]);
    }

    protected function request()
    {
        return new UrlDeleteRequest;
    }

    public function control()
    {
        (object) $urlGateway = new UrlGateway(new WordPressDatabaseDriver);

        $result = $urlGateway->deleteUrlAndAllItsComponents(new Url($this->request->data->url->asArray()));

        if (($result !== 1) || WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlSuccesses::get('url_delete_success')->asArray()
                             );
    }
}   

