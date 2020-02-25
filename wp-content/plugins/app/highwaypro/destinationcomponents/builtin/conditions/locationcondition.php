<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors\LocationConditionErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\App\HighWayPro\Location\Countries;
use HighWayPro\App\HighWayPro\Location\LocationDetector;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use MaxMind\Db\Reader;

Class LocationCondition extends DestinationConditionComponent
{
    const name = 'highwaypro.LocationCondition';

    public static function title()
    {
        return __('Country', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Target users by their country', Env::textDomain());
    }

    public static function description()
    {
        return __("Target users by the country they are located in when making the request.\nYou may select more than one country. For example, you may target North America by selecting Canada, the United States and Mexico.\nPlease note our geolocation services depend on the user's IP.", Env::textDomain());
    }

    protected function getAllowedValues()
    {
        return new Collection([
            'countries' => Countries::all()
        ]);
    }

    protected function parametersMap()
    {
        return [
            'countries' => Collection::class,
        ];
    }

    public function hasPassed()
    {

        (object) $ipDatabaseReader = new LocationDetector($_SERVER['REMOTE_ADDR']);

        return $this->parameters->countries->contain(
            $ipDatabaseReader->getCountryCode()
        );
    }

    public function validateParameters()
    {
        if (!Countries::all()->getKeys()->containAll($this->parameters->countries)) {
            return LocationConditionErrors::get('invalid_countries_selected');
        }

        return true;
    }
}