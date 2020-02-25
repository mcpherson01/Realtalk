<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Create;

use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlCreationRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlErrors;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlCreationValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new UrlCreationRequest;
    }

    public function validate()
    {
        (object) $url = new Url($this->request->data->url->asArray());

        if ($url->getValidator()->hasId()) {
            return (new Response)->withStatusCode(409)
                                 ->containing(UrlErrors::get('url_with_id')->asArray());
        } elseif ($this->request->data->url->name->isEmpty() && $this->request->data->url->path->isEmpty()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('empty_url_object')->asArray());
        } elseif ($this->request->data->url->name->isEmpty()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('empty_url_name')->asArray());
        } elseif ($this->request->data->url->path->isEmpty()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('empty_url_path')->asArray());
        } elseif ($url->getValidator()->pathIsInvalid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_path')->asArray());
        } elseif ($url->getValidator()->pathAlreadyExists()) {
            return (new Response)->withStatusCode(409)
                                 ->containing(UrlErrors::get('url_with_registered_path')->asArray());
        } elseif ($this->request->data->url->name->isNotEmpty() && !$url->getValidator()->nameIsValid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_name')->asArray());

        } elseif ($this->request->data->url->name->isNotEmpty() && $url->getValidator()->nameAlreadyExists()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_existing_name')->asArray());

        } elseif ($this->request->data->url->type_id > 0 && $url->getValidator()->typeIdDoesntExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_nonexistent_type')->asArray());
        }

        return true;
    }

}