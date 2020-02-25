<?php

namespace HighWayPro\App\HighWayPro\Controllers\Preferences;

use HighWayPro\App\HighWayPro\HTTP\Controller;
use HighWayPro\App\HighWayPro\HTTP\Requests\Preferences\PreferencesUpdateRequest;
use HighWayPro\App\HighWayPro\HTTP\Response;
use HighWayPro\App\HighWayPro\HTTP\Responses\DatabaseErrorResponse;
use HighWayPro\App\HighWayPro\Validators\AdminValidator;
use HighWayPro\App\HighWayPro\Validators\Post\Successes\PreferencesSuccesses;
use HighWayPro\App\HighWayPro\Validators\Post\Update\PreferencesUpdateValidator;
use HighWayPro\Original\Collections\Collection;
use Highwaypro\App\Data\Model\Preferences\Preferences;

Class PreferencesUpdaterController extends Controller
{
    const path = 'preferences/edit';
    protected static $HTTPMethod = 'POST';

    protected function getValidators()
    {
        return new Collection([
            new AdminValidator,
            new PreferencesUpdateValidator,
        ]);
    }

    protected function request()
    {
        return new PreferencesUpdateRequest;
    }

    public function control()
    {
        (object) $preferences = Preferences::get();
        (boolean) $result = $preferences->saveField($this->request->getFieldComponents());

        if ($result === false) {
            return new DatabaseErrorResponse;
        }

        return (new Response)->withStatusCode(200)
                             ->containing(
                                PreferencesSuccesses::getUpdatedValue(Preferences::get(), 'preferences_update_success')->asArray()
                             );
    }
}   

