<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class WpsolAddonFilterLoading
 */
class WpsolAddonFilterLoading
{
    /**
     * WpsolAddonFilterLoading constructor.
     */
    public function __construct()
    {
        $advanced_option = get_option('wpsol_advanced_settings');
        if (!is_admin()) {
            if (isset($advanced_option['lazy_loading']) && $advanced_option['lazy_loading']) {
                add_filter('wpsol_addon_image_lazy_loading', array($this, 'filterImageFromContent'));
                add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
            }
//            if (isset($advanced_option['iframe_lazy_loading']) && $advanced_option['iframe_lazy_loading']) {
//                add_filter('wpsol_addon_iframe_lazy_loading', array($this, 'filterIframeFromContent'));
//                add_action('wp_enqueue_scripts', array($this, 'enqueueIframeScripts'));
//            }
        }
    }


    /**
     * Find image from content
     *
     * @param string $content HTML raw
     *
     * @return mixed
     */
    public function filterImageFromContent($content)
    {
        $placeholder_url = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

        if (preg_match_all('#<img\s[^>]*?src\s*=\s*[\'\"]([^\'\"]*?)[\'\"][^>]*?>#Usmi', $content, $matches)) {
            foreach ($matches[0] as $imgtag) {
                // Fix conflict gallery of media folder plugin
                if (strpos($imgtag, 'wpmfgalleryimg') !== false) {
                    continue;
                }
                if (!preg_match("/src=['\"]data:image/is", $imgtag)) {
                    // replace the src and add the data-src attribute
                    $imgtag_data = preg_replace(
                        '/<img(.*?)src=/is',
                        '<img$1src="'.esc_attr($placeholder_url).'" data-wpsollazy-src=',
                        $imgtag
                    );
                    // replace the srcset
                    $imgtag_data = str_replace('srcset', 'data-wpsollazy-srcset', $imgtag_data);
                    // add the lazy class to the img element
                    if (preg_match('/class=["\']/i', $imgtag_data)) {
                        $imgtag_data = preg_replace(
                            '/class=(["\'])(.*?)["\']/is',
                            'class=$1wpsol-lazy wpsol-lazy-hidden $2$1',
                            $imgtag_data
                        );
                    } else {
                        $imgtag_data = preg_replace(
                            '/<img/is',
                            '<img class="wpsol-lazy wpsol-lazy-hidden"',
                            $imgtag_data
                        );
                    }
                    $noscript = '<noscript>'.$imgtag.'</noscript>';
                    $imgtag_data .= $noscript;

                    // Replace new img tag to old img tag
                    $content = str_replace($imgtag, $imgtag_data, $content);
                }
            }
        }
        return $content;
    }

    /**
     * Enqueue lazy load script
     *
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'wpsol-addon-lazy-load',
            plugins_url('lazy-loading/wpsol-addon-lazyload.min.js', dirname(__FILE__)),
            array('jquery'),
            '1.0',
            true
        );
        wp_enqueue_style(
            'wpsol-addon-lazy-load-css',
            plugins_url('lazy-loading/wpsol-addon-lazyload.min.css', dirname(__FILE__))
        );
    }

    /**
     * Find iframe from content
     *
     * @param string $content HTML raw
     *
     * @return mixed
     */
    public function filterIframeFromContent($content)
    {
        $placeholder_url = '';
        if (preg_match_all('#<iframe(.*)\/iframe>#is', $content, $matches)) {
            foreach ($matches[0] as $iframetag) {
                // Replace the src and add the data-src attribute
                $iframetag_data = preg_replace(
                    '/<iframe(.*?)src=/is',
                    '<iframe$1src="'.esc_attr($placeholder_url).'" wpsol-iframe-lazyload="true" data-wpsolsrc=',
                    $iframetag
                );
                // Replace the srcset
                $iframetag_data = str_replace('srcset', 'data-wpsolsrcset', $iframetag_data);
                // Replace style
                $iframetag_data = str_replace('style', 'data-wpsolstyle', $iframetag_data);
                // No script if browser not support
                $noscript = '<noscript>'.$iframetag.'</noscript>';
                $iframetag_data .= $noscript;

                // Replace new iframe tag to old iframe tag
                $content = str_replace($iframetag, $iframetag_data, $content);
            }
        }
        return $content;
    }

    /**
     * Enqueue lazy load script
     *
     * @return void
     */
    public function enqueueIframeScripts()
    {
        wp_enqueue_script(
            'wpsol-addon-iframe-lazy-load',
            plugins_url('lazy-loading/wpsol-addon-iframe-lazyload.js', dirname(__FILE__)),
            array('jquery'),
            '1.0',
            true
        );
    }
}
