<?php

namespace HighWayPro\App\HighWayPro\Controllers\Url;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlSuccesses;
use HighWayPro\App\HighWayPro\Validators\Url\Update\UrlUpdateValidator;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class UrlUpdaterController extends Controller
{
    const path = 'urls/edit';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlUpdateValidator,
        ]);
    }

    protected function request()
    {
        return new UrlUpdateRequest;
    }

    public function control()
    {
        (object) $urlGateway = new UrlGateway(new WordPressDatabaseDriver);

        $response = $urlGateway->update($this->request->getDataToUpdate()->asArray());

        (object) $url = $urlGateway->getWithId($this->request->data->url->id);

        if (!($url instanceof Url)) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlSuccesses::geUpdatedUrl($url, 'url_update_success', $this->request->data->fieldToUpdate)->asArray()
                             );
    }
}   

