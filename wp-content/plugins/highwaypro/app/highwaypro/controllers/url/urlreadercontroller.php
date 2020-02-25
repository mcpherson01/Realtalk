<?php

namespace HighWayPro\App\HighWayPro\Controllers\Url;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\ReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Read\ReaderValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Read\UrlReadValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;

Class UrlReaderController extends Controller
{
    const path = 'url';
    protected static $HTTPMethod = 'GET';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new ReaderValidator,
            new UrlReadValidator
        ]);
    }

    protected function request()
    {
        return new ReadRequest;
    }

    public function control()
    {
        (object) $urlGateway = new UrlGateway(new WordPressDatabaseDriver);

        $url = $urlGateway->getWithId($this->request->data->id);

        if (!($url instanceof Url)) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlSuccesses::getUrl($url, 'url_read_success')->asArray()
                             );
    }
}   

