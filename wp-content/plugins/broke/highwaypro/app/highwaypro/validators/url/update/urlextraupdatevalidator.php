<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Update;

use Exception;
use HighWayPro\App\HighWayPro\HTTP\Requests\UrlExtra\UrlExtraUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlErrors;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlExtraErrors;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;
use HighwayPro\App\Data\Model\UrlExtra\Validators\UrlExtraValidator;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlExtraUpdateValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new UrlExtraUpdateRequest;
    }

    public function validate()
    {
        (object) $url = new Url($this->request->data->url->asArray());
        if ($this->request->data->fieldToUpdate->isNotEither(UrlExtra::validUpdateableFields())) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlExtraErrors::get('url_extra_update_invalid_name_of_field_to_update')->asArray());
        } elseif ($this->request->data->urlExtra->mapFieldsNotFoundInSource->contain('value')) {
            // IMPORTANT AS AN EMPTY VALUE IS ALSO VALID FOR SOME FIELDS, IF THE REQUEST
            // SENT NO VALUE FIELD BY ACCIDENT, THE CURRENT SPECIFIED FIELD VALUE WOULD BE REMOVED
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlExtraErrors::get('url_extra_update_unexisting_value_field')->asArray());
        } elseif ($this->request->data->url->mapFieldsNotFoundInSource->contain('id')) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_no_id')->asArray());
        } elseif ($url->getValidator()->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_id')->asArray());
        } else {
            return $this->validateFieldToUpdate();
        }
    }

    protected function validateFieldToUpdate()
    {
        (object) $urlExtraValidator = new UrlExtraValidator([
            $this->request->data->fieldToUpdate->get() => $this->request->data->urlExtra->value
        ]);

        if ($this->request->data->fieldToUpdate->is('keyword_injection_keywords')) {
            try {
                $urlExtraValidator->validateInjectionKeywords();
            } catch (Exception $exception) {
                return (new Response)->withStatusCode(400)
                                      ->containing(UrlExtraErrors::create([
                                          'name' => 'url_extra_keyword_injection__invalid_keywords',
                                          'value' => $exception->getMessage()
                                      ])->asArray());      
            }
        }

    }
    
}