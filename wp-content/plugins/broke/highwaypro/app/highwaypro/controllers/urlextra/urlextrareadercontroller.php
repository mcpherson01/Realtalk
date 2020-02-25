<?php

namespace HighWayPro\App\HighWayPro\Controllers\UrlExtra;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\UrlExtra\UrlExtraReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Read\UrlExtraReaderValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlExtraSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtraGateway;

Class UrlExtraReaderController extends Controller
{
    const path = 'url/extra';
    protected static $HTTPMethod = 'GET';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlExtraReaderValidator
        ]);
    }

    protected function request()
    {
        return new UrlExtraReadRequest;
    }

    public function control()
    {
        (object) $urlExtraGateway = new UrlExtraGateway(new WordPressDatabaseDriver);

        (object) $extraMetaData = $urlExtraGateway->getWithUrlId($this->request->data->url->id);

        if (WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlExtraSuccesses::getUrlExtras(
                                    $extraMetaData,
                                    "url_extra_read_sucess")
                                ->asArray()
                             );
    }
}   

