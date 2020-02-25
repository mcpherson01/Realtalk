<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WpsolAddonAdmin
 */
class WpsolAddonAdmin
{

    /**
     * WpsolAddonAdmin constructor.
     */
    public function __construct()
    {
        /**
         * Load admin js *
        */
        add_action('admin_enqueue_scripts', array($this, 'loadAdminScripts'));
        //** load languages **//
        add_action('init', function () {
            load_plugin_textdomain('wp-speed-of-light-addon', false, WPSOL_ADDON_PLUGIN_DIR . '/languages/');
        });
        //Update option when update plugin
        add_action('admin_init', array($this, 'wpsolAddonUpdateVersion'));
    }

    /**
     * Load script
     *
     * @return void
     */
    public function loadAdminScripts()
    {
        $current_screen = get_current_screen();
        if ('wp-speed-of-light_page_wpsol_speed_optimization' === $current_screen->base) {
            wp_register_style(
                'wpsol-addon-admin-styles',
                plugins_url('css/wpsol-addon-backend.css', dirname(__FILE__)),
                array(),
                WPSOL_ADDON_VERSION
            );
            wp_enqueue_style('wpsol-addon-admin-styles');

            // Modal jquery
            wp_enqueue_style(
                'wpsol-addon-mdl-modal-css',
                plugins_url('/css/mdl-jquery-modal-dialog.css', dirname(__FILE__))
            );
            wp_enqueue_script(
                'wpsol-addon-mdl-modal-js',
                plugins_url('js/mdl-jquery-modal-dialog.js', dirname(__FILE__)),
                array('jquery'),
                WPSOL_ADDON_VERSION,
                true
            );
            // Material js
            wp_enqueue_script(
                'wpsol-addon-material-js',
                plugins_url('js/material.min.js', dirname(__FILE__)),
                array('jquery'),
                WPSOL_ADDON_VERSION,
                true
            );
            wp_enqueue_style(
                'wpsol-addon-material_deep_orange-amber',
                plugins_url('/css/material.deep_orange-amber.min.css', dirname(__FILE__))
            );
            // Tree Folder
            wp_enqueue_style('wpsol-addon-jaofiletree-css', plugins_url('/css/jaofiletree.css', dirname(__FILE__)));
            wp_enqueue_script(
                'wpsol-addon-jaofiletree-js',
                plugins_url('js/jaofiletree.js', dirname(__FILE__)),
                array('jquery'),
                WPSOL_ADDON_VERSION,
                true
            );
            $ajax_nonce =  wp_create_nonce('folder-jao-nonce');
            wp_localize_script('wpsol-addon-jaofiletree-js', 'jaofiletree_nonce', array('ajaxnonce' => $ajax_nonce));

            wp_enqueue_script(
                'wpsol-addon-folder-tree',
                plugins_url('js/wpsol-addon-folder-tree.js', dirname(__FILE__)),
                array('jquery'),
                WPSOL_VERSION,
                true
            );
            $ajax_nonce =  wp_create_nonce('folder-minify-nonce');
            wp_localize_script('wpsol-addon-folder-tree', 'folders_nonce', array('ajaxnonce' => $ajax_nonce));

            wp_enqueue_script(
                'wpsol-addon-admin-js',
                plugins_url('js/wpsol-addon-backend.js', dirname(__FILE__)),
                array('jquery'),
                WPSOL_ADDON_VERSION,
                true
            );
            $ajax_nonce =  wp_create_nonce('addon-admin-nonce');
            wp_localize_script('wpsol-addon-admin-js', 'addon_admin_nonce', array('ajaxnonce' => $ajax_nonce));

            wp_enqueue_script(
                'wpsol-addon-group-minify-js',
                plugins_url('js/wpsol-addon-group-minify-js.js', dirname(__FILE__)),
                array('jquery'),
                WPSOL_ADDON_VERSION,
                true
            );
        }

        if ('wp-speed-of-light_page_wpsol_speed_optimization' === $current_screen->base) {
            wp_enqueue_script(
                'wpsol-addon-advanced-cdn-js',
                plugins_url('js/wpsol-addon-advanced-cdn.js', dirname(__FILE__)),
                array('jquery'),
                WPSOL_ADDON_VERSION,
                true
            );
            //set tokken ajax
            $token_name = array(
                'check_save_authorization' => wp_create_nonce('_save_authorization'),
            );
            wp_localize_script('wpsol-addon-advanced-cdn-js', '_author_third_party_token_name', $token_name);
        }
    }

    /**
     * Active plugin
     *
     * @return void
     */
    public static function wpsolAddonPluginActivation()
    {
        //Update option
        $opts = get_option('wpsol_optimization_settings');
        if (empty($opts)) {
            $opts['speed_optimization'] = array();
            $opts['advanced_features'] = array();
        }
        $default_opts = array(
            'speed_optimization' => array(
                'act_cache' => 1,
                'add_expires' => 1,
                'clean_cache' => 40,
                'clean_cache_each_params' => 2,
                'devices' => array(
                    'cache_desktop' => 1,
                    'cache_tablet' => 1,
                    'cache_mobile' => 1,
                ),
                'query_strings' => 1,
                'cleanup_on_save' => 1,
                'disable_page' => array(),
            ),
            'advanced_features' => array(
                'html_minification' => 0,
                'css_minification' => 0,
                'js_minification' => 0,
                'cssgroup_minification' => 0,
                'jsgroup_minification' => 0,
                'fontgroup_minification' => 0,
                'excludefiles_minification' => 0,
                'exclude_inline_script' => 1,
                'move_script_to_footer' => 0,
                'exclude_move_to_footer' => array()
            )
        );
        $opts['speed_optimization'] = array_merge($default_opts['speed_optimization'], $opts['speed_optimization']);
        $opts['advanced_features'] = array_merge($default_opts['advanced_features'], $opts['advanced_features']);
        update_option('wpsol_optimization_settings', $opts);
        // Create advanced optimization default
        $advanced = get_option('wpsol_advanced_settings');
        if (empty($advanced)) {
            $advanced = array();
        }
        $default_advanced = array(
            'cache_preload' => 0,
            'dns_prefetching' => 0,
            'preload_url' => array(),
            'prefetching_domain' => array(),
            'lazy_loading' => 0,
            'exclude_lazy_loading' => array(),
            'iframe_lazy_loading' => 0,
            'remove_emojis' => 0,
            'disable_gravatar' => 0,
            'heartbeat_frequency' => 60
        );
        $advanced = array_merge($default_advanced, $advanced);
        update_option('wpsol_advanced_settings', $advanced);
        // Create database default
        $database_settings = get_option('wpsol_db_clean_addon');
        if (empty($database_settings)) {
            $database_settings = array();
        }
        $default_database = array(
            'db_clean_auto' => 0,
            'clean_db_each' => 0,
            'clean_db_each_params' => 0,
            'list_db_clear' => array()
        );
        $database_settings = array_merge($default_database, $database_settings);
        update_option('wpsol_db_clean_addon', $database_settings);


        //config by default
        $config = get_option('wpsol_configuration');
        if (empty($config)) {
            $config = array();
        }
        $default_config = array(
            'disable_user' => 0,
            'display_clean' => 1,
            'webtest_api_key' => '',
            'disable_roles' => array(),
        );
        $config = array_merge($default_config, $config);
        update_option('wpsol_configuration', $config);

        // update CDN
        $cdn_addon = get_option('wpsol_cdn_integration');
        if (empty($cdn_addon)) {
            $cdn_addon = array();
        }
        $cdn_addon_default = array(
            'cdn_active' => 0,
            'cdn_url' => '',
            'cdn_content' => array('wp-content', 'wp-includes'),
            'cdn_exclude_content' => array('.php'),
            'cdn_relative_path' => 1,
            'third_parts' => array(),
        );
        $cdn_addon = array_merge($cdn_addon_default, $cdn_addon);
        update_option('wpsol_cdn_integration', $cdn_addon);
        // // Save folder select memories
        update_option('wpsol_folder_scan_selected', array());
        //Create database
        self::installDb();
    }
    /**
     * Deactive plugin
     *
     * @return void
     */
    public static function wpsolAddonPluginDeactivation()
    {
    }
    /**
     * Update version
     *
     * @return void
     */
    public static function wpsolAddonUpdateVersion()
    {
        $db_installed = get_option('wpsol_addon_db_version', false);
        $config = get_option('wpsol_cdn_integration');
        $advanced = get_option('wpsol_advanced_settings');
        $optimization = get_option('wpsol_optimization_settings');

        if (!$db_installed) {
            if (empty($config)) {
                $config = array(
                    'cdn_active'          => 0,
                    'cdn_url'             => '',
                    'cdn_content'         => array('wp-content', 'wp-includes'),
                    'cdn_exclude_content' => array('.php'),
                    'cdn_relative_path'   => 1,
                    'third_parts'         => array(),
                );
            }
            update_option('wpsol_cdn_integration', $config);
            if (empty($advanced)) {
                $advanced = array(
                    'cache_preload'        => 0,
                    'dns_prefetching'      => 0,
                    'preload_url'          => array(),
                    'prefetching_domain'   => array(),
                    'lazy_loading'         => 0,
                    'exclude_lazy_loading' => array(),
                    'iframe_lazy_loading'  => 0,
                    'remove_emojis'        => 0,
                    'disable_gravatar'     => 0,
                    'heartbeat_frequency'  => 60
                );
            }
            update_option('wpsol_advanced_settings', $advanced);
            if (empty($optimization)) {
                $optimization = array(
                    'speed_optimization' => array(
                        'act_cache'               => 1,
                        'add_expires'             => 1,
                        'clean_cache'             => 40,
                        'clean_cache_each_params' => 2,
                        'devices'                 => array(
                            'cache_desktop' => 1,
                            'cache_tablet'  => 1,
                            'cache_mobile'  => 1,
                        ),
                        'query_strings'           => 1,
                        'cleanup_on_save'         => 1,
                        'disable_page'            => array(),
                    ),
                    'advanced_features'  => array(
                        'html_minification'         => 0,
                        'css_minification'          => 0,
                        'js_minification'           => 0,
                        'cssgroup_minification'     => 0,
                        'jsgroup_minification'      => 0,
                        'fontgroup_minification'    => 0,
                        'excludefiles_minification' => 0,
                        'exclude_inline_script'     => 1,
                        'move_script_to_footer'     => 0,
                        'exclude_move_to_footer'    => array()
                    )
                );
            }
            update_option('wpsol_optimization_settings', $optimization);
            // Update current version
            update_option('wpsol_addon_db_version', WPSOL_ADDON_VERSION);

            return;
        }

        if (!empty($db_installed) && strpos($db_installed, '{{version') !== false) {
            return;
        }

        if (version_compare($db_installed, '2.0.0', '<')) {
            $config['third_parts'] = array();
            update_option('wpsol_cdn_integration', $config);
        }
        if (version_compare($db_installed, '2.1.0', '<')) {
            $advanced['lazy_loading'] = 0;
            $advanced['remove_emojis'] = 0;
            $advanced['disable_gravatar'] = 0;
            $optimization['advanced_features']['exclude_inline_script'] = 1;
            $optimization['advanced_features']['move_script_to_footer'] = 0;
            $optimization['advanced_features']['exclude_move_to_footer'] = array();
            update_option('wpsol_advanced_settings', $advanced);
            update_option('wpsol_optimization_settings', $optimization);
        }
        if (version_compare($db_installed, '2.2.0', '<')) {
            $advanced['exclude_lazy_loading'] = array();
            update_option('wpsol_advanced_settings', $advanced);
        }
        if (version_compare($db_installed, '2.4.0', '<')) {
            $advanced['iframe_lazy_loading'] = 0;
            $advanced['heartbeat_frequency'] = 60;
            update_option('wpsol_advanced_settings', $advanced);
        }

        update_option('wpsol_addon_db_version', WPSOL_ADDON_VERSION);
    }

    /**
     * Create table wpsol_minify_file
     *
     * @return void
     */
    public static function installDb()
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql = 'CREATE TABLE `' . $wpdb->prefix . "wpsol_minify_file` (
		   `id` INT(11) NOT NULL AUTO_INCREMENT,
		   `filename` VARCHAR(250) NOT NULL,
		   `minify` TINYINT(2) NOT NULL,
		   `filetype` TINYINT(3) NOT NULL,
		   PRIMARY KEY (`id`),
		   UNIQUE KEY `filename` (`filename`)
		) COLLATE 'utf8_unicode_ci';";
        dbDelta($sql);
    }


    /**
     * Render account form for execute api
     *
     * @param string $key Name of form
     *
     * @return void
     */
    public static function renderForm($key)
    {
        require_once(WPSOL_ADDON_PLUGIN_DIR . 'views/account-form-api/' . $key . '-form.php');
    }
}
