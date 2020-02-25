<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\HighWayPro\Shortcodes\URLShortcode;
use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Events\Handler\EventHandler;
use Highwaypro\App\Data\Model\Preferences\PostPreferences;

Class FrontEndScriptsRegistrator extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    protected function getBehaviourManagerScriptName()
    {
        return Env::id().'c_behaviour_manager';   
    }
    

    public function execute()
    {
        wp_enqueue_script( 
            $this->getBehaviourManagerScriptName(), 
            Env::directoryURI().'app/scripts/frontend/c-behaviour.js', 
            [
                'jquery'
            ]
        );

        wp_localize_script(
            $this->getBehaviourManagerScriptName(),
            $variableName = 'HighWayPro', 
            $data = [
                'LINK_CLASS' => URLShortcode::LINK_CLASS,
                'IN_SITU_TARGET' => PostPreferences::BEHAVIOUR_IN_SITU
            ]
        );
    }
}