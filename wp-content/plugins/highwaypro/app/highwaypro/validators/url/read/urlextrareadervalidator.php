<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Read;

use HighWayPro\App\HighWayPro\HTTP\Requests\UrlExtra\UrlExtraReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlErrors;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlExtraErrors;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighwayPro\App\Data\Model\UrlTypes\UrlTypeGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use HighwayPro\App\Data\Model\Urls\UrlGateway;
use HighwayPro\App\Data\Model\Urls\Validators\UrlValidator;

Class UrlExtraReaderValidator extends Validator
{
    protected function request()
    {
        return new UrlExtraReadRequest;
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

        if ($urlValidator->idDoesNotExist()) {
            return (new Response)->withStatusCode(404)
                                 ->containing(UrlErrors::get('url_with_invalid_id')->asArray());
        } 

        return true;
    }

}
