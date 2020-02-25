<?php

namespace HighWayPro\App\HighWayPro\Controllers\UrlExtra;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\UrlExtra\UrlExtraUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Url\Successes\UrlExtraSuccesses;
use HighWayPro\App\HighWayPro\Validators\Url\Update\UrlExtraUpdateValidator;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtraGateway;

Class UrlExtraUpdaterController extends Controller
{
    const path = 'urls/extra/edit';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new UrlExtraUpdateValidator,
        ]);
    }

    protected function request()
    {
        return new UrlExtraUpdateRequest;
    }

    public function control()
    {
        (object) $urlExtraGateway = new UrlExtraGateway(new WordPressDatabaseDriver);

        $response = $urlExtraGateway->createOrUpdateSingleField([
            'url_id' => $this->request->data->url->id,
            'fieldName' => $this->request->data->fieldToUpdate->get(),
            'value' => $this->request->data->urlExtra->value
        ]);

        (object) $urlExtra = $urlExtraGateway->getWithUrlIdAndName(
            $this->request->data->url->id,
            $this->request->data->fieldToUpdate->get()
        )->first();

        if (!($urlExtra instanceof UrlExtra) || $response === false) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                UrlExtraSuccesses::getUrlExtra($urlExtra, 'url_extra_save_success')
                                                 ->asArray()
                             );
    }
}   

