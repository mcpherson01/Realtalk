<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Create;

use HighWayPro\App\HighWayPro\HTTP\Requests\UrlType\UrlTypeCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlTypeErrors;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;

Class UrlTypeCreationValidator extends Validator
{
    protected function request()
    {
        return new UrlTypeCreationRequest;
    }

    public function validate()
    {
        (object) $urlType = new UrlType($this->request->data->urlType->asArray());

        if ($this->request->data->excluded->urlType->id > 0) {
            return (new Response)->withStatusCode(409)
                                 ->containing(UrlTypeErrors::get('url_type_with_id')->asArray());
        } elseif (!$urlType->getValidator()->hasName()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_no_name')->asArray());
        } elseif (!$urlType->getValidator()->nameIsValid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_name')->asArray());
        } elseif ($urlType->getValidator()->nameAlreadyExists()) {
            return (new Response)->withStatusCode(409)
                                 ->containing(UrlTypeErrors::get('url_type_with_existing_name')->asArray());
        } elseif ($urlType->getValidator()->hasPathButItIsInvalid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_path')->asArray());
        } elseif ($urlType->getValidator()->hasPathButItAlreadyExists()) {
            return (new Response)->withStatusCode(409)
                                 ->containing(UrlTypeErrors::get('url_type_with_existing_path')->asArray());
        } elseif ($urlType->getValidator()->hasColorButItIsInvalid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_color')->asArray());
        }

        return true;
    }

}
