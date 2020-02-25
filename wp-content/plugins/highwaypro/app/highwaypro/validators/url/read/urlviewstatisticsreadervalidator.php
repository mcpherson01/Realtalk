<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Read;

use HighWayPro\App\HighWayPro\HTTP\Requests\UrlView\UrlViewStatisticsReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlViewsErrors;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;
use HighwayPro\App\Data\Model\Urls\Validators\UrlValidator;

Class UrlViewStatisticsReaderValidator extends Validator
{
    protected function request()
    {
        return new UrlViewStatisticsReadRequest;
    }

    public function validate()
    {
        (object) $urlValidator = new UrlValidator(
            new Url([
                'id' => $this->request->data->url->id
            ]),
            new UrlGateway(new WordPressDatabaseDriver),
            new UrlTypeGateway(new WordPressDatabaseDriver)
        );

        if ($this->request->hasUrlObject() && $urlValidator->idDoesNotExist()) {
            return (new Response)->withStatusCode(404)
                                 ->containing(UrlViewsErrors::get('url_view_statistics_invalid_url_id')->asArray());
        } 

        return true;
    }

}
