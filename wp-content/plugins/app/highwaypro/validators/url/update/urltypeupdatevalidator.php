<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Update;

use HighWayPro\App\HighWayPro\HTTP\Requests\UrlType\UrlTypeUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlTypeErrors;
use HighwayPro\App\Data\Model\UrlTypes\UrlType;

Class UrlTypeUpdateValidator extends Validator
{
    protected function request()
    {
        return new UrlTypeUpdateRequest;
    }

    public function validate()
    {
        (object) $urlType = new UrlType($this->request->data->urlType->asArray());

        if ($this->request->data->fieldToUpdate->isEmpty()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_no_name_of_field_to_update')->asArray());
        } elseif ($this->request->data->fieldToUpdate->isNotEither(UrlType::updatableFields())) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_invalid_field_name_to_update')->asArray());
        } elseif ($this->request->data->urlType->dataFound->asCollection()->getKeys()->areNot(['id', $this->request->data->fieldToUpdate])) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_invalid_field_to_update')->asArray());
        } elseif ($urlType->getValidator()->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_id')->asArray());
        } elseif ($this->request->data->fieldToUpdate->is('name') && !$urlType->getValidator()->nameIsValid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_name')->asArray());
        } elseif ($this->request->data->fieldToUpdate->is('name') && $urlType->getValidator()->nameAlreadyExists()) {
            return (new Response)->withStatusCode(409)
                                 ->containing(UrlTypeErrors::get('url_type_with_existing_name')->asArray());
        } elseif (
            $this->request->data->fieldToUpdate->is('base_path') && 
            $this->request->data->urlType->base_path->isNotEmpty() && 
            $urlType->getValidator()->pathIsInvalid()
            ) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_path')->asArray());
        } elseif ($this->request->data->fieldToUpdate->is('base_path') && $urlType->getValidator()->pathAlreadyExists()) {
            return (new Response)->withStatusCode(409)
                                 ->containing(UrlTypeErrors::get('url_type_with_existing_path')->asArray());
        } elseif ($this->request->data->fieldToUpdate->is('color') && !$urlType->getValidator()->colorIsValid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlTypeErrors::get('url_type_with_invalid_color')->asArray());
        }

        return true;
    }

}
