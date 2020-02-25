<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\DeviceCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\DisposableCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\ExpiringCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\LocationCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\RefererCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\UserAgentCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Conditions\UserRoleCondition;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\DirectTarget;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\NotFoundTarget;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\PostTarget;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\TaxonomyTarget;
use HighWayPro\App\HighWayPro\System\URLComponentsRegistrator;
use HighWayPro\Original\Events\Handler\EventHandler;

Class BuilInDestinationComponentsRegistratorHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute(URLComponentsRegistrator $componentsRegistrator)
    {
        //Conditions:
        $componentsRegistrator->register(DeviceCondition::class);
        $componentsRegistrator->register(DisposableCondition::class);
        $componentsRegistrator->register(ExpiringCondition::class);
        $componentsRegistrator->register(LocationCondition::class);
        $componentsRegistrator->register(RefererCondition::class);
        $componentsRegistrator->register(UserAgentCondition::class);
        $componentsRegistrator->register(UserRoleCondition::class);

        //Targets:
        $componentsRegistrator->register(DirectTarget::class); 
        $componentsRegistrator->register(PostTarget::class);
        $componentsRegistrator->register(TaxonomyTarget::class);
        $componentsRegistrator->register(NotFoundTarget::class);
    }
}