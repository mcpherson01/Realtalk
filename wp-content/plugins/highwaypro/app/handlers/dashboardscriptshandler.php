<?php

namespace HighWayPro\App\Handlers;

use HighWayPro\App\HighWayPro\System\URLComponentsRegistrator;
use HighWayPro\App\HighWayPro\Texts\Posteditor\PostEditorText;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Environment\Env;
use HighWayPro\Original\Events\Handler\EventHandler;
use HighwayPro\Original\Characters\StringManager as Str;
use Highwaypro\app\highWayPro\urls\ServerDataBridge;

Class DashboardScriptsHandler extends EventHandler
{
    protected $numberOfArguments = 1;
    protected $priority = 10;

    static public function WP_DASHBOARD_CSS()
    {
        return Env::directoryURI()."app/styles/wpdashboard/wpdashboard.css";
    }

    static public function isGutenberg() {
        /*
         * https://github.com/Freemius/wordpress-sdk
         */
        if ( function_exists( 'is_gutenberg_page' ) &&
                is_gutenberg_page()
        ) {
            // The Gutenberg plugin is on.
            return true;
        }
        $current_screen = get_current_screen();
        if ( method_exists( $current_screen, 'is_block_editor' ) &&
                $current_screen->is_block_editor()
        ) {
            // Gutenberg page on 5+.
            return true;
        }
        return false;
    }
    
    public function getScripts()
    {

        (string) $js = $this->getAssets()->get('main.js');
        (string) $css = $this->getAssets()->get('main.css');
        (string) $dashboardVersion = '1.1.0';
        
        return new Collection([
            'highwaypro' => new Collection([
                [
                    'name' => 'highwaypro-app-css',
                    'type' => 'css',
                    'source' => Env::directoryURI()."app/scripts/dashboard/build/{$css}",
                    'version' => $dashboardVersion,
                ],
                [
                    'name' => 'highwaypro-app-fonts',
                    'type' => 'css',
                    'source' => Env::directoryURI()."app/scripts/dashboard/resources/fonts/manrope/font.css",  
                ],
                [
                    'name' => 'highwaypro-app-tour-css',
                    'type' => 'css',
                    'source' => Env::directoryURI()."app/scripts/dashboard/public/bootstrap-tour-standalone.min.css",
                ],
                [
                    'name' => 'highwaypro-app-tour-js',
                    'type' => 'js',
                    'source' => Env::directoryURI()."app/scripts/dashboard/public/bootstrap-tour-standalone.min.js",
                ],
                [
                    'name' => 'highwaypro-app',
                    'type' => 'js',
                    'source' => Env::directoryURI()."app/scripts/dashboard/build/{$js}",
                    'version' => $dashboardVersion,
                    'inFooter' => true,
                    'data' => ServerDataBridge::get(),
                    'dependencies' => [
                        'jquery',
                    ]
                ],
            ]),
            'post' => new Collection([
                /**
                 * LOAD REACT IF ON PRE-5 AND GUTENBERG IS NOT INSTALLED.
                 * OTHERWISE WE'LL USE WORDPRESS' INCLUDED REACT API
                 */
                [
                    'name' => 'highwaypro-pre-wp-5-react',
                    'type' => 'js',
                    'source' => Env::directoryURI()."storage/react/react-16.js",
                    'dependencies' => [
                    ],
                    'condition' => function() {
                        // only register if gutenberg does not exist...
                        return !static::isGutenberg();
                    }
                ],
                [
                    'name' => 'highwaypro-pre-wp-5-react-dom',
                    'type' => 'js',
                    'source' => Env::directoryURI()."storage/react/react-dom-16.js",
                    'dependencies' => [
                    ],
                    'condition' => function() {
                        // only register if gutenberg does not exist...
                        return !static::isGutenberg();
                    }
                ],
                [
                    'name' => 'highwaypro-post-scripts',
                    'type' => 'js',
                    'source' => Env::directoryURI()."app/scripts/postEditorGutenberg/dist/js/postPicker.js",
                    'dependencies' => Collection::create(
                        [
                            'jquery'
                        ]
                    )->mergeIf(static::isGutenberg(), 
                        ['wp-editor', 'wp-i18n', 'wp-element', 'wp-compose', 'wp-components']
                    )->asArray(),
                    'data' => new Collection([
                        'name' => 'HighWayProPostEditor',
                        'data' => new Collection([
                            'pluginURI' => Env::directoryURI(),
                            'postUrl' => admin_url('admin-post.php'),
                            'postId'  => get_the_ID(),
                            'text'    => (new PostEditorText)->getTexts()
                        ])
                    ]),
                ],
                [
                    'name' => 'highwaypro-wp-dashboard-css',
                    'type' => 'css',
                    'source' => self::WP_DASHBOARD_CSS(),
                ],
            ]),
        ]);
    }
    
    public function getScript($name)
    {
        (object) $scriptGroups = $this->getScripts();

        foreach ($scriptGroups as $scriptsGroup) {
            $script = $scriptsGroup->filter(function($script) use ($name) {
                return $script['name'] === $name;
            })->first(); 

            if ($script) {
                return $script;
            }
        }
    }
    

    public function execute($currentScreen)
    {
        $this->getScripts()->forEvery(function(Collection $scriptsGroup, $screen) use ($currentScreen) {
            (boolean) $isTheRightScreen = Str::create($currentScreen)->contains($screen, false)
                                            ||
                                          $screen === 'all';

            if ($isTheRightScreen) {
                $scriptsGroup->forEvery(function(Array $script){
                    $script = new Collection($script);

                    if (is_callable($script->get('condition'))) {
                        if (!call_user_func($script->get('condition'))) {
                            return;
                        }
                    }

                    if ($script->get('type') == 'js') {

                        wp_enqueue_script(
                            $script->get('name'), 
                            $script->get('source'),
                            $script->get('dependencies'),
                            $version = $script->get('version'),
                            $script->get('inFooter')
                        );

                        if ($script->hasKey('data')) {
                            wp_localize_script(
                                $scriptName = $script->get('name'), 
                                $variableName = $script->get('data')->get('name'), 
                                $variableData = $script->get('data')->get('data')->asArray()
                            );
                        }
                    } else {
                        wp_enqueue_style(
                            $script->get('name'), 
                            $script->get('source')
                        );                    
                    }

                    if ($script->hasKey('tag')) {
                        add_filter('script_loader_tag', $script->get('tag'), 10, 3);
                    }
                });
            }
        });
    }

    protected function getAssets()
    {
        return $this->cache->getifExists('dashboard.assets')->otherwise(function(){
            return new Collection((array) json_decode(
                file_get_contents(Env::getAppDirectory('dashboard').'build/asset-manifest.json')
            ));;
        });
    }
}