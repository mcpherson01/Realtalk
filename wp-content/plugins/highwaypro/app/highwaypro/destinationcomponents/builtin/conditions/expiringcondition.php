<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions;

use DateTime;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors\ExpiringConditionErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\Original\Collections\Mapper\Types;

Class ExpiringCondition extends DestinationConditionComponent
{
    const name = 'highwaypro.ExpiringCondition';

    public static function title()
    {
        return __('Expiring', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Limit access by date.', Env::textDomain());
    }

    public static function description()
    {
        return __("You may choose a date limit, after which the target will no longer be available.\nExpiration dates may only be set as days only, expiration by hours is currently not available.\nThe destination expires after the expiration day has passed, if the expiration date is November 20, the destination will be available until the first minute of November 21.\nThis component uses your current server date/time for its algorithm.", Env::textDomain());
    }

    const DATE_FORMAT = "Y-m-d";

    public $today;

    protected function setUp()
    {
        if (!$this->today) $this->today = date(SELF::DATE_FORMAT);
    }

    protected function parametersMap()
    {
        return [
            'expirationDate' => Types::STRING
        ];
    }

    public function hasPassed()
    {
        return $this->parameters->expirationDate->hasValue() && (new DateTime($this->parameters->expirationDate)) >= (new DateTime($this->today));
    }

    public function validateParameters()
    {
        if ($this->parameters->expirationDate->isEmpty()) {
            return ExpiringConditionErrors::get('no_date_selected');
        } if (!$this->parameters->expirationDate->isDate(Static::DATE_FORMAT)) {
            return ExpiringConditionErrors::get('invalid_date_format');
        }

        return true;
    }
}