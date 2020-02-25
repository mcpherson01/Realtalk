<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Update;

use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlErrors;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlUpdateValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new UrlUpdateRequest;
    }

    public function validate()
    {
        (object) $url = new Url($this->request->data->url->asArray());

        if ($this->request->data->mapFieldsNotFoundInSource->containEither(['fieldToUpdate', 'url'])) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('empty_url_object')->asArray());
        }
        if ($this->request->data->fieldToUpdate->isNotEither($url->updatableFields())) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_update_invalid_name_of_field_to_update')->asArray());
        } elseif ($this->request->data->url->mapFieldsNotFoundInSource->contain('id')) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_no_id')->asArray());
        } elseif ($url->getValidator()->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_id')->asArray());
        } elseif ($this->request->data->url->dataFound->asCollection()->getKeys()->areNot(['id', $this->request->data->fieldToUpdate])) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_update_invalid_field_to_update')->asArray());
        } elseif ($this->request->data->fieldToUpdate->is('path') && $url->getValidator()->pathIsInvalid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_path')->asArray());;
        } elseif ($this->request->data->fieldToUpdate->is('path') && $url->getValidator()->pathAlreadyExistsAndItIsNotFromThisUrl()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_registered_path')->asArray());;
        } elseif ($this->request->data->fieldToUpdate->is('name') && !$url->getValidator()->nameIsValid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_name')->asArray());;
        } elseif ($this->request->data->fieldToUpdate->is('name') && $url->getValidator()->nameAlreadyExists()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_existing_name')->asArray());

        } elseif ($url->getValidator()->hasTypeId() && $url->getValidator()->typeIdDoesntExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_nonexistent_type')->asArray());
        }

        return true;
    }

}