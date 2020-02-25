<?php

namespace HighWayPro\App\HighWayPro\Controllers\UrlType;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlTypeSuccesses;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;

Class UrlTypesReaderCreatorController extends Controller
{
    const path = 'url/types';
    protected static $HTTPMethod = 'GET';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator
        ]);
    }

    public function control()
    {
        (object) $urlTypeGateway = new UrlTypeGateway(new WordPressDatabaseDriver);

        $urlTypes = $urlTypeGateway->getAll();

        if ($urlTypes === false || WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlTypeSuccesses::getUrlTypes($urlTypes, 'url_types_read_success')->asArray()
                             );
    }
}   

