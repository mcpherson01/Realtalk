<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\Handlers\DashboardScriptsHandler;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Events\Handler\EventHandler;

Class TinyMCERegistratorHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    public function execute()
    {
        add_filter('mce_buttons', $this->dispatcher('myplugin_register_buttons'));
        add_filter('mce_external_plugins', $this->dispatcher('myplugin_register_tinymce_javascript'));
        add_filter('tiny_mce_before_init', $this->dispatcher('addCustomSettings'));

        add_filter('mce_css', $this->dispatcher('addCustomCSS'));
    }

    public function myplugin_register_buttons( $buttons ) 
    {
       array_push( $buttons, 'separator', 'myplugin' );
       return $buttons;
    }

    public function myplugin_register_tinymce_javascript( $plugin_array ) 
    {
       $plugin_array['myplugin'] = Env::directoryURI()."app/scripts/postEditorGutenberg/dist/js/postPicker.js";
       return $plugin_array;
    }

    public function addCustomSettings($settings)
    {
        (object) $settingsCollection = new Collection($settings);

        (array) $tagSettings = [
            'extended_valid_elements',
            'custom_elements'
        ];

        foreach ($tagSettings as $tagSetting) {
            $settingsCollection->add(
                $tagSetting, 
                // will append to previous values if a third party has registered them
                trim(($settingsCollection->get($tagSetting) . ',hwprourl[class|data|data-id],'), ',')
            );
        }

        return $settingsCollection->asArray();
    }
    
    public function addCustomCSS($mce_css) {
        if ( ! empty( $mce_css ) ) {
            $mce_css .= ',';
        }


        $mce_css .= DashboardScriptsHandler::WP_DASHBOARD_CSS();

        return $mce_css;
    }
}