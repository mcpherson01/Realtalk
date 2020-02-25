<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\Data\Model\Posts\Post;
use HighWayPro\Original\Events\Handler\EventHandler;
use Highwaypro\app\highWayPro\urls\PostShortCodeInsertionRegistrator;
use Highwaypro\app\highWayPro\urls\PostUrlInjectionRegistrator;

Class PostFeaturesRegistratorHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        new PostUrlInjectionRegistrator(Post::fromCurentRequest());      
        new PostShortCodeInsertionRegistrator(Post::fromCurentRequest());
    }
}