<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Delete;

use HighWayPro\App\HighWayPro\HTTP\Requests\Url\UrlDeleteRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlErrors;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlDeleteValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new UrlDeleteRequest;
    }

    public function validate()
    {
        (object) $url = new Url($this->request->data->url->asArray());

        if ($this->request->data->url->allFieldsFoundInSource->areNot(['id'])) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_data_delete')->asArray());
        } elseif ($url->getValidator()->idDoesNotExist()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(UrlErrors::get('url_with_invalid_id')->asArray());
        } 
        
        return true;
    }

}