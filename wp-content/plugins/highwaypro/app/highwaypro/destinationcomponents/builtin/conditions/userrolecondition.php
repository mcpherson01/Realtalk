<?php

namespace HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions;

use HighWayPro\App\HighWayPro\Capabilities\WordPressCapabilities;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\Errors\UserRoleConditionErrors;
use HighWayPro\App\HighWayPro\DestinationComponents\DestinationConditionComponent;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighwayPro\Original\Collections\Mapper\Types;

Class UserRoleCondition extends DestinationConditionComponent
{
    const name = 'highwaypro.UserRoleCondition';

    public static function title()
    {
        return __('Roles & Capabilities', Env::textDomain());
    }

    public static function shortDescription()
    {
        return __('Limit users by their roles or capabilities.', Env::textDomain());
    }

    public static function description()
    {
        return __("You may limit the destination target to users with a specific WordPress role or capability, for example, an administrator or a user capable of publishing posts.\nMore than one role and/or capability may be selected.\nBoth default WordPress roles and capabilities, as well as those registered by third-party plugins are supported.", Env::textDomain());
    }

    protected function getAllowedValues()
    {
        return new Collection([
            'userType' => new Collection([
                'logged' => 'Logged In',
                'unlogged' => 'Not Logged In (visitor)',
                'loggedwithrole' => 'Logged In With Special Role'
            ]),
            'roles' => WordPressCapabilities::getRoles(),
            'capabilities' => WordPressCapabilities::getCapabilities()
        ]);
    }

    protected function parametersMap()
    {
        return [
            'userType' => Types::STRING, // logged, unlogged, loggedwithrole
            'capabilities' => Collection::class,
            'roles' => Collection::class
        ];
    }

    public function hasPassed()
    {
        if ($this->userNeedsToBe('logged')) {
            return is_user_logged_in();
        } elseif ($this->userNeedsToBe('unlogged')) {
            return !is_user_logged_in();
        } elseif ($this->userNeedsToBe('loggedwithrole')) {
            if ($this->parameters->capabilities->haveAny()) {
                if ($this->parameters->capabilities->test('current_user_can')) {
                    return true;
                }
            }
            if ($this->parameters->roles->haveAny()) {
                if ($this->parameters->roles->containEither(wp_get_current_user()->roles)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function userNeedsToBe($type)
    {
        return $this->parameters->userType->is($type);   
    }

    public function validateParameters()
    {
        if ($this->parameters->userType->isNotEither($this->allowed->get('userType')->getKeys())) {
            return UserRoleConditionErrors::get('invalid_type_parameter');
        }

        if ($this->parameters->userType->is('loggedwithrole')) {
            if ($this->parameters->capabilities->haveNone() && $this->parameters->roles->haveNone()) {
                return UserRoleConditionErrors::get('invalid_logged_with_role_parameter');
            } elseif ($this->parameters->roles->haveAny() && !$this->allowed->get('roles')->containAll($this->parameters->roles)) {
                return UserRoleConditionErrors::get('invalid_roles');
            } elseif ($this->parameters->capabilities->haveAny() && !$this->allowed->get('capabilities')->containAll($this->parameters->capabilities)) {
                return UserRoleConditionErrors::get('invalid_capabilities');
            }
        }

        return true;
    }
}
