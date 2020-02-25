<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Read;

use HighWayPro\App\HighWayPro\HTTP\Requests\ReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\UrlErrors;
use HighwayPro\App\Data\Model\Urls\Url;

Class UrlReadValidator extends Validator
{
    protected function request()
    {
        return new ReadRequest;
    }

    public function validate()
    {
        (object) $url = new Url([
            'id' => $this->request->data->id
        ]);

        if ($url->getValidator()->idDoesNotExist()) {
            return (new Response)->withStatusCode(404)
                                 ->containing(UrlErrors::get('url_with_invalid_id')->asArray());
        } 

        return true;
    }

}
