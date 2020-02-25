<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class WpsolAddonAdvancedOptimization
 */
class WpsolAddonAdvancedOptimization
{
    /**
     * WpsolAddonAdvancedOptimization constructor.
     */
    public function __construct()
    {
        add_action('wp_head', array($this, 'wpsolDnsFetching'));
    }

    /**
     *  Preload cache for guest
     *
     * @return void
     */
    public static function preloadCache()
    {
        $settings = get_option('wpsol_advanced_settings');

        if (!empty($settings['cache_preload'])) {
            $nonce = rand(time(), true);
            update_option('wpsol-addon-preload-nonce', $nonce);
            $url = home_url().'/wp-admin/admin.php?page=wpsol_speed_optimization&task=wpsol-preload&token='.$nonce;
            $args = array(
                'httpversion' => '1.1',
            );
            //Start preload
            wp_remote_get($url, $args);
        }
    }

    /**
     * Execute preload cache
     *
     * @return void
     */
    public static function preloadProcess()
    {
        $settings = get_option('wpsol_advanced_settings');
        $nonce = get_option('wpsol-addon-preload-nonce');
        //phpcs:ignore WordPress.Security.NonceVerification -- Check request, exist check token after
        if ($_REQUEST['token'] !== $nonce) {
            exit;
        }

        ignore_user_abort(true);

        while (ob_get_level() !== 0) {
            ob_end_clean();
        }

        header('Connection: close', true);
        header("Content-Encoding: none\r\n");

        //Make a request for each url
        $urls = $settings['preload_url'];
        if (!empty($urls)) {
            $args = array(
                'timeout'     => 30,
                'httpversion' => '1.1',
                'headers' => array('Authorpreload' => 'WPSOL_PRELOAD'),
            );
            //Preload for guest
            foreach ($urls as $url) {
                if (empty($url)) {
                    continue;
                }
                wp_remote_get($url, $args);
            }
        }

        exit();
    }

    /**
     * DNS pre fetching
     *
     * @return void
     */
    public function wpsolDnsFetching()
    {
        $advanced = get_option('wpsol_advanced_settings');

        if (!empty($advanced['dns_prefetching'])) {
            $dns_string = '<meta http-equiv="x-dns-prefetch-control" content="on">';
            if (!empty($advanced['prefetching_domain'])) {
                $domain_dns = array_map('esc_url', $advanced['prefetching_domain']);

                foreach ($domain_dns as $domain_name) {
                    $dns_string .= '<link rel="dns-prefetch" href="' . esc_url($domain_name) . '">';
                }
            }
            //phpcs:ignore WordPress.Security.EscapeOutput -- Echo meta tag to content, exist escaping url
            echo $dns_string;
        }
    }
}
