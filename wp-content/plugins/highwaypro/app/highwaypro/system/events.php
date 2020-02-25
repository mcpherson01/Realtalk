<?php

namespace HighWayPro\App\HighWayPro\System;

use HighWayPro\Original\Collections\Collection;

Class Events
{
    protected static $events = [];

    public static function getAll()
    {
        if (!(static::$events instanceof Collection)) {
            static::$events = new Collection(self::getEventsArray());
        }

        return static::$events;
    }

    protected static function getEventsArray()
    {
        return [
            'muplugins_loaded',
            'registered_taxonomy',
            'registered_post_type',
            'plugins_loaded',
            'sanitize_comment_cookies',
            'setup_theme',
            'unload_textdomain',
            'load_textdomain',
            'after_setup_theme',
            'auth_cookie_malformed',
            'auth_cookie_valid',
            'set_current_user',
            'init',
            'widgets_init',
            'register_sidebar',
            'wp_register_sidebar_widget',
            'wp_loaded',
            'parse_request',
            'send_headers',
            'parse_tax_query',
            'parse_query',
            'pre_get_posts',
            'posts_selection',
            'wp',
            'template_redirect',
            'wp_default_scripts',
            'wp_default_styles',
            'admin_bar_init',
            'add_admin_bar_menus',
            'get_header',
            'wp_head',
            'wp_enqueue_scripts',
            'wp_print_styles',
            'wp_print_scripts',
            'loop_start',
            'the_post',
            'get_template_part_content',
            'begin_fetch_post_thumbnail_html',
            'end_fetch_post_thumbnail_html',
            'loop_end',
            'get_sidebar',
            'dynamic_sidebar_before',
            'dynamic_sidebar',
            'dynamic_sidebar_after',
            'get_footer',
            'twentytwelve_credits',
            'wp_footer',
            'wp_print_footer_scripts',
            'admin_bar_menu',
            'wp_before_admin_bar_render',
            'wp_after_admin_bar_render',
            'shutdown'
        ];
    }
}