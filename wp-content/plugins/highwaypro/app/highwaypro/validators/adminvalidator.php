<?php

namespace HighWayPro\App\HighWayPro\Validators;

use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;

Class AdminValidator extends Validator
{
    public function validate()
    {
        if (!in_array('administrator', (array) wp_get_current_user()->roles)) {
            return (new Response)->withStatusCode(403);
        }

        return true;
    }
}