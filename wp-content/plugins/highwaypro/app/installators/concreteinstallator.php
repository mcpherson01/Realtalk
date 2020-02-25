<?php

namespace HighWayPro\App\Installators;

use HighWayPro\App\Data\Settings\Settings;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Installation\Installator;

Class ConcreteInstallator
{
    public function install()
    {
        (string) $ApplicationDatabase = Env::settings()->schema->applicationDatabase;

        (object) $applicationDatabase = new $ApplicationDatabase(new WordPressDatabaseDriver);

        $applicationDatabase->install();
    }
}