<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors\UserAgentConditionErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Collections\Mapper\Types;
use HighWayPro\Original\Environment\Env;

Class UserAgentCondition extends DestinationConditionComponent
{
    const name = 'highwaypro.UserAgentCondition';

    public static function title()
    {
        return __('User Agent', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Limit access by user agent.', Env::textDomain());
    }

    public static function description()
    {
        return __("Limit access by the client's user agent. More than one user agent may be specified.\nThis is useful if, for example, you want to use a different target when the user agent is \"googlebot\" (Google's web crawler).\nYou may specify more than on user agent and the condition will be met when the request has one of the specified user agents.", Env::textDomain());
    }

    protected function parametersMap()
    {
        return [
            'userAgents' => Types::Collection()->escape(Types::returnValueCallable()),
        ];
    }

    public function hasPassed()
    {
        return $this->parameters->userAgents->contain($_SERVER['HTTP_USER_AGENT']);
    }

    public function validateParameters()
    {
        if ($this->parameters->userAgents->haveNone() || $this->parameters->userAgents->test(function($userAgent){
            return (!Types::isString($userAgent)) || (trim((string) $userAgent) === '');
        })) {
            return UserAgentConditionErrors::get('non_valid_user_agents');
        }

        return true;
    }
}