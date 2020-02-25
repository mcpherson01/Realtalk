<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\Data\Model\Posts\Post;
use HighWayPro\Original\Events\Handler\EventHandler;
use Highwaypro\app\highWayPro\urls\OpenGraphThirdPartyCompatibiltyManager;

Class OpenGraphThirdPartyCompatibilityHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        new OpenGraphThirdPartyCompatibiltyManager(
                OpenGraphThirdPartyCompatibiltyManager::getFilters(),
                Post::fromCurentRequest()
        );
    }
}