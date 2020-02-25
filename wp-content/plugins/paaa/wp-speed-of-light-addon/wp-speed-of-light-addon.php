<?php

/**
 * Plugin Name: WP Speed of Light Addon
 * Plugin URI: https://www.joomunited.com/wordpress-products/wp-speed-of-light-addon
 * Description: WP Speed of Light Addon: Advanced features for WP Speed of Light plugin like image lazy loading, fonts optimization...
 * Version: 2.4.0
 * Text Domain: wp-speed-of-light-addon
 * Domain Path: /languages
 * Author: JoomUnited
 * Author URI: https://www.joomunited.com
 * License: GPL2
 */
/*
 * @copyright 2014  Joomunited  ( email : contact _at_ joomunited.com )
 *
 *  Original development of this plugin was kindly funded by Joomunited
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Check plugin requirements
if (version_compare(PHP_VERSION, '5.3', '<')) {
    if (!function_exists('wpsol_addon_disable_plugin')) {
        /**
         * Check version to disable plugin
         *
         * @return void
         */
        function wpsol_addon_disable_plugin()
        {
            if (current_user_can('activate_plugins') && is_plugin_active(plugin_basename(__FILE__))) {
                deactivate_plugins(__FILE__);
                unset($_GET['activate']);
            }
        }
    }
    if (!function_exists('wpsol_addon_show_error')) {
        /**
         * Show error when check php
         *
         * @return void
         */
        function wpsol_addon_show_error()
        {
            echo '<div class="error"><p>
            <strong>WP Speed Of Light Addon</strong>
             need at least PHP 5.3 version, please update php before installing the plugin.</p></div>';
        }
    }

    //Add actions
    add_action('admin_init', 'wpsol_addon_disable_plugin');
    add_action('admin_notices', 'wpsol_addon_show_error');

    //Do not load anything more
    return;
}

if (!defined('WPSOL_ADDON_PLUGIN_DIR')) {
    define('WPSOL_ADDON_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('WPSOL_ADDON_VERSION')) {
    define('WPSOL_ADDON_VERSION', '2.4.0');
}

if (!defined('WPSOL_UPLOAD_AVATAR')) {
    define('WPSOL_UPLOAD_AVATAR', WP_CONTENT_DIR . '/uploads/wpsol-avatar');
}

require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/wpsol-addon-admin.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/class/class.advanced-optimization.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/class/class.disable-emojis.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/class/class.disable-gravatar.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/wpsol-addon-configuration.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/wpsol-addon-speed-optimization.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/wpsol-addon-database-cleanup.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/lazy-loading/filter-loading.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/class/class.speed-optimization-query.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/class/class.flush-third-party-cache.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'views/wpsol-addon-views-speed-optimization.php');
require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/wpsol-addon-cdn-integration.php');

if (is_admin()) {
    register_activation_hook(__FILE__, array('WpsolAddonAdmin', 'wpsolAddonPluginActivation'));
    register_deactivation_hook(__FILE__, array('WpsolAddonAdmin', 'wpsolAddonPluginDeactivation'));
}


/**
 * Get addon path for requirement check
 *
 * @return string
 */
function wpsolAddons_getPath()
{
    if (!function_exists('plugin_basename')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    return plugin_basename(__FILE__);
}


//JU requirements
if (!class_exists('\Joomunited\WPSOLADDON\JUCheckRequirements')) {
    include_once(WPSOL_ADDON_PLUGIN_DIR . 'requirements.php');
}

if (class_exists('\Joomunited\WPSOLADDON\JUCheckRequirements')) {
    // Plugins name for translate
    $args           = array(
        'plugin_name'       => esc_html__('WP Speed Of Light Addon', 'wp-speed-of-light-addon'),
        'plugin_path'       => 'wp-speed-of-light-addon/wp-speed-of-light-addon.php',
        'plugin_textdomain' => 'wp-speed-of-light-addon',
        'plugin_version'    => WPSOL_ADDON_VERSION,
        'requirements'      => array(
            'plugins'     => array(
                array(
                    'name' => 'WP Speed Of Light',
                    'path' => 'wp-speed-of-light/wp-speed-of-light.php',
                    'requireVersion' => '2.3.0'
                )
            ),
            'php_version' => '5.3'
        ),
    );

    $wpsolAddonCheck = call_user_func('\Joomunited\WPSOLADDON\JUCheckRequirements::init', $args);
    if (!$wpsolAddonCheck['success']) {
        //Do not load anything more
        unset($_GET['activate']);

        return;
    }
}
//Configuration
new WpsolAddonConfiguration();

// Advanced optimization
new WpsolAddonAdvancedOptimization();

// Advanced optimization disable emojis
new WpsolAddonDisableEmojis();

// Filter lazy load
new WpsolAddonDisableGravatar();

// Include inc file
new WpsolAddonSpeedOptimization();

// Database cleanup
new WpsolAddonDatabaseCleanup();

// Filter lazy load
new WpsolAddonFilterLoading();


/**
 * Run this addon
 *
 * @return void
 */
function wpsolAddonsInit()
{
    // Set heartbeat frequency
    //next-version
//    add_filter('heartbeat_settings', function ($settings) {
//        $advanced = get_option('wpsol_advanced_settings');
//        if (isset($advanced['heartbeat_frequency']) && is_numeric($advanced['heartbeat_frequency'])) {
//            $heartbeat            = (int) $advanced['heartbeat_frequency'];
//            $settings['interval'] = $heartbeat;
//        }
//
//        return $settings;
//    }, 10, 1);

    if (is_admin()) {
        new WpsolAddonAdmin();

        $third = new WpsolAddonFlushThirdPartyCache();

        //CDN Integration
        new WpsolAddonCDNIntegration();

        //config section
        if (!defined('JU_BASE')) {
            define('JU_BASE', 'https://www.joomunited.com/');
        }

        $remote_updateinfo = JU_BASE . 'juupdater_files/wp-speed-of-light-addon.json';
        //end config
        require 'juupdater/juupdater.php';
        $UpdateChecker = Jufactory::buildUpdateChecker(
            $remote_updateinfo,
            __FILE__
        );

        // PROCESS PRELOAD
        //phpcs:ignore WordPress.Security.NonceVerification -- Check request, exist check token after
        if (isset($_REQUEST['task']) && $_REQUEST['task'] === 'wpsol-preload') {
            WpsolAddonAdvancedOptimization::preloadProcess();
        }

        //JUtranslation
        add_filter('wpsol_get_addons', function ($addons) {
            $language_folder = plugin_dir_path(__FILE__) . 'languages';
            $language_folder .= DIRECTORY_SEPARATOR . 'wp-speed-of-light-addon-en_US.mo';
            $addon = new stdClass();
            $addon->main_plugin_file = __FILE__;
            $addon->extension_name = 'WP Speed Of Light Addon';
            $addon->extension_slug = 'wp-speed-of-light-addon';
            $addon->text_domain = 'wp-speed-of-light-addon';
            $addon->language_file = $language_folder;
            $addons[$addon->extension_slug] = $addon;
            return $addons;
        });
    }
}
