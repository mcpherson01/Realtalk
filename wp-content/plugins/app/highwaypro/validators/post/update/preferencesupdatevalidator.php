<?php

namespace HighWayPro\App\HighWayPro\Validators\Post\Update;

use HighWayPro\App\HighWayPro\HTTP\Requests\Preferences\PreferencesUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Validator;
use HighWayPro\App\HighWayPro\Validators\Post\Errors\PreferencesErrors;
use HighwayPro\App\Data\Model\Preferences\Validators\PreferencesValidator;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class PreferencesUpdateValidator extends Validator
{
    protected $url;

    protected function request()
    {
        return new PreferencesUpdateRequest;
    }

    public function validate()
    {
        (object) $preferencesValidator = new PreferencesValidator($this->request);

        if ($preferencesValidator->hasInvalidFieldName()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(PreferencesErrors::get('invalid_preferences_field')->asArray());
        } elseif ($preferencesValidator->valueIsInvalid()) {
            return (new Response)->withStatusCode(400)
                                 ->containing(PreferencesErrors::get('invalid_preferences_value')->asArray());
        }

        return true;
    }        
}