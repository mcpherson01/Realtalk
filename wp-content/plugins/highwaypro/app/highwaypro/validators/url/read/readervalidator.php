<?php

namespace HighWayPro\App\HighWayPro\Validators\Url\Read;

use HighWayPro\App\HighWayPro\HTTP\Requests\ReadRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Url\Errors\ReadErrors;

Class ReaderValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new ReadRequest;
    }

    public function validate()
    {
        if ($this->request->data->id < 1) {
            return (new Response)->withStatusCode(400)
                                 ->containing(ReadErrors::get('request_no_id')->asArray());
        }

        return true;
    }

}