<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\HighWayPro\Shortcodes\URLShortcode;
use HighWayPro\Original\Events\Handler\EventHandler;

Class ShortCodesRegistratorHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        add_shortcode(URLShortcode::name(), URLShortcode::handle());
    }
}