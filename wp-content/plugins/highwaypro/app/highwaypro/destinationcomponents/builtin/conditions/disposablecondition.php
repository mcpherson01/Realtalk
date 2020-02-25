<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors\DisposableConditionErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\Original\Collections\Mapper\Types;

Class DisposableCondition extends DestinationConditionComponent
{
    const name = 'highwaypro.DisposableCondition';

    public static function title()
    {
        return __('Disposable', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Limit the number of times the destination target can be accessed.', Env::textDomain());
    }

    public static function description()
    {
        return __("Limit the number of times the destination can be accessed.\nAfter the destination target has been successfully used for the number of times specified, the destination target will no longer be available.\nIf the limit has been reached, you can always update the current limit if need be.", Env::textDomain());
    }
    
    protected function parametersMap()
    {
        return [
            'numberOfTimesItCanBeUsed' => Types::INTEGER
        ];
    }

    public function hasPassed()
    {
        return $this->destination->getViews()->haveLessThan($this->parameters->numberOfTimesItCanBeUsed);
    }

    public function validateParameters()
    {
        if ($this->parameters->numberOfTimesItCanBeUsed < 1) {
            return DisposableConditionErrors::get('invalid_number');
        }

        return true;
    }
}