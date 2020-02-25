<?php

namespace HighWayPro\App\HighWayPro\Controllers\UrlType;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\UrlType\UrlTypeUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlTypeSuccesses;
use HighWayPro\App\HighWayPro\Validators\Url\Update\UrlTypeUpdateValidator;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;

Class UrlTypeUpdaterController extends Controller
{
    const path = 'urls/types/edit';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlTypeUpdateValidator,
        ]);
    }

    protected function request()
    {
        return new UrlTypeUpdateRequest;
    }

    public function control()
    {
        (object) $urlTypeGateway = new UrlTypeGateway(new WordPressDatabaseDriver);

        $response = $urlTypeGateway->update($this->request->getDataToUpdate()->asArray());

        (object) $urlType = $urlTypeGateway->getWithId($this->request->data->urlType->id);

        if (($response !== 1) || !($urlType instanceof UrlType) || WordPressDatabaseDriver::errors()->haveAny()) {
            return new DatabaseErrorResponse;
        }
        
        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlTypeSuccesses::getUrlType($urlType, 'url_type_update_success', 'URL Type Successfully Updated.')->asArray()
                             );
    }
}   
