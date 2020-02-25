<?php

namespace HighWayPro\Original\Installation;

use HighWayPro\App\Installators\ConcreteInstallator;
use HighWayPro\Original\Environment\Env;

Class Installator
{
    public function __construct()
    {
        register_activation_hook(
            Env::absolutePluginFilePath(), 
            [new ConcreteInstallator, 'install']
        );
    }
}