<?php
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class WpsolAddonDisableEmojis
 */
class WpsolAddonDisableEmojis
{

    /**
     * WpsolAddonDisableEmojis constructor.
     */
    public function __construct()
    {
        $advanced_option = get_option('wpsol_advanced_settings');

        if (isset($advanced_option['remove_emojis']) && $advanced_option['remove_emojis']) {
            add_action('init', array($this, 'disableEmojis'));
        }
    }

    /**
     * Disable the emoji's
     *
     * @return void
     */
    public function disableEmojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', array($this, 'disableEmojisTinymce'));
    }

    /**
     * Filter function used to remove the tinymce emoji plugin.
     *
     * @param array $plugins Plugin check
     *
     * @return array
     */
    public function disableEmojisTinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    }
}
