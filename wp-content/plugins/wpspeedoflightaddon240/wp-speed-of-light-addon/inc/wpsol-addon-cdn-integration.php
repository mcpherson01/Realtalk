<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WpsolAddonCDNIntegration
 */
class WpsolAddonCDNIntegration
{

    /**
     * WpsolAddonCDNIntegration constructor.
     */
    public function __construct()
    {
        // Filter
        add_filter('wpsol_addon_save_cdn_integration', array($this, 'saveCdnIntegration'), 10, 2);
        // Add ajax
        add_action('wp_ajax_wpsol_save_max_cdn_3rd_party', array($this, 'saveMaxCdn3rdParty'));
        add_action('wp_ajax_wpsol_save_key_cdn_3rd_party', array($this, 'saveKeyCdn3rdParty'));
        add_action('wp_ajax_wpsol_save_cloudflare_3rd_party', array($this, 'saveCloudFlare3rdParty'));
        add_action('wp_ajax_wpsol_save_varnish_3rd_party', array($this, 'saveVarnish3rdParty'));
    }


    /**
     * Storage cdn parameter
     *
     * @param array $settings Option of CDN intergration
     * @param array $request  Request to save
     *
     * @return mixed
     */
    public function saveCdnIntegration($settings, $request)
    {
        $third_parts = array();
        if (isset($request['siteground-cache'])) {
            array_push($third_parts, 'siteground-cache');
        }
        if (isset($request['maxcdn-cache'])) {
            array_push($third_parts, 'maxcdn-cache');
        }
        if (isset($request['keycdn-cache'])) {
            array_push($third_parts, 'keycdn-cache');
        }
        if (isset($request['cloudflare-cache'])) {
            array_push($third_parts, 'cloudflare-cache');
        }
        if (isset($request['varnish-cache'])) {
            array_push($third_parts, 'varnish-cache');
        }
        $settings['third_parts'] = $third_parts;
        return $settings;
    }

    /**
     * Check option cleanup on save
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
     *  Ajax to save account api
     *
     * @return void
     */
    public function saveMaxCdn3rdParty()
    {
        check_ajax_referer('_save_authorization', 'security');
        $cache_3rd_party = array(
            'consumer-key' => (isset($_POST['maxcdn_consumer_key'])) ? $_POST['maxcdn_consumer_key'] : '',
            'consumer-secret' => (isset($_POST['maxcdn_consumer_secret'])) ? $_POST['maxcdn_consumer_secret'] : '',
            'alias' => (isset($_POST['maxcdn_alias'])) ? $_POST['maxcdn_alias'] : '',
            'zone' => (isset($_POST['zone'])) ? $_POST['zone'] : '',
        );
        if (update_option('wpsol_addon_author_max_cdn', $cache_3rd_party)) {
            wp_send_json(true);
        }
        wp_send_json(false);
    }


    /**
     *  Ajax to save account api
     *
     * @return void
     */
    public function saveKeyCdn3rdParty()
    {
        check_ajax_referer('_save_authorization', 'security');
        $cache_3rd_party = array(
            'authorization' => (isset($_POST['authorization'])) ? $_POST['authorization'] : '',
            'zone' => (isset($_POST['zone'])) ? $_POST['zone'] : '',
        );
        if (update_option('wpsol_addon_author_key_cdn', $cache_3rd_party)) {
            wp_send_json(true);
        }
        wp_send_json(false);
    }

    /**
     *  Ajax to save account api
     *
     * @return void
     */
    public function saveCloudFlare3rdParty()
    {
        check_ajax_referer('_save_authorization', 'security');
        $cache_3rd_party = array(
            'username' => (isset($_POST['username'])) ? $_POST['username'] : '',
            'key' => (isset($_POST['key'])) ? $_POST['key'] : '',
            'domain' => (isset($_POST['domain'])) ? $_POST['domain'] : ''
        );
        if (update_option('wpsol_addon_author_cloudflare', $cache_3rd_party)) {
            wp_send_json(true);
        }
        wp_send_json(false);
    }

    /**
     *  Ajax to save account api
     *
     * @return void
     */
    public function saveVarnish3rdParty()
    {
        check_ajax_referer('_save_authorization', 'security');
        $cache_3rd_party = array(
            'ip' => (isset($_POST['ip'])) ? $_POST['ip'] : '',
        );
        if (update_option('wpsol_addon_varnish_ip', $cache_3rd_party)) {
            wp_send_json(true);
        }
        wp_send_json(false);
    }
}
