<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WpsolAddonConfiguration
 */
class WpsolAddonConfiguration
{
    /**
     * WpsolAddonConfiguration constructor.
     */
    public function __construct()
    {
        // Filter
        add_filter('wpsol_addon_save_configuration', array($this, 'saveConfiguration'), 10, 2);
        add_filter('wpsol_addon_check_cleanup_on_save', array($this, 'checkCleanupOnSave'));
        add_filter('wpsol_addon_check_user_roles', array($this, 'checkUserRoles'));
    }


    /**
     * Storage configuration addon
     *
     * @param array $settings Option of Configuration
     * @param array $request  Request configuration
     *
     * @return mixed
     */
    public function saveConfiguration($settings, $request)
    {
        $disable_roles = array();
        if (isset($request['disable_roles'])) {
            $disable_roles = $request['disable_roles'];
        }
        $settings['disable_roles'] = $disable_roles;
        return $settings;
    }

    /**
     * Check cleanup on save
     *
     * @return boolean
     */
    public function checkCleanupOnSave()
    {
        $config = get_option('wpsol_optimization_settings');
        if (!empty($config['speed_optimization']['cleanup_on_save'])) {
            return true;
        }
        return false;
    }

    /**
     * Check user roles
     *
     * @return boolean
     */
    public static function checkUserRoles()
    {
        $user = wp_get_current_user();
        $config = get_option('wpsol_configuration');

        if (!empty($config['disable_roles'])) {
            $r = array_intersect($user->roles, $config['disable_roles']);
            if (!empty($r)) {
                return true;
            }
        }
        return false;
    }
}
