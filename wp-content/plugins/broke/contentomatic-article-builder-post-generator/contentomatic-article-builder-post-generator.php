<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/** 
Plugin Name: Contentomatic Automatic Post Generator
Plugin URI: //1.envato.market/contentomatic
Description: This plugin will generate content for you, even in your sleep using News public group feeds.
Author: CodeRevolution
Version: 1.0.2
Author URI: //1.envato.market/coderevolution
License: Commercial. For personal use only. Not to give away or resell.
Text Domain: contentomatic-article-builder-post-generator
*/
/*  
Copyright 2016 - 2019 CodeRevolution
*/
defined('ABSPATH') or die();
//bugs
update_option('contentomatic-article-builder-post-generator_register_code', '208677d5-d9at-49b5-9a22-006304b54656');
update_option('contentomatic-article-builder-post-generator_registration', 
[ 'item_id' => '24990646',
  'item_name' => 'Contentomatic Automatic Post Generator',
  'created_at' => '10.10.2020',
  'buyer' => 'nulled',
  'licence' => 'Standart',
  'supported_until' => '10.10.2030']
);
update_option('coderevolution_settings_changed', 2);
function contentomatic_load_textdomain() {
    load_plugin_textdomain( 'contentomatic-article-builder-post-generator', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'init', 'contentomatic_load_textdomain' );


function contentomatic_assign_var(&$target, $var) {
	static $cnt = 0;
    $key = key($var);
    if(is_array($var[$key])) 
        contentomatic_assign_var($target[$key], $var[$key]);
    else {
        if($key==0)
		{
			if($cnt == 0)
			{
				$target['_contentomaticr_nonce'] = $var[$key];
				$cnt++;
			}
			elseif($cnt == 1)
			{
				$target['_wp_http_referer'] = $var[$key];
				$cnt++;
			}
			else
			{
				$target[] = $var[$key];
			}
		}
        else
		{
            $target[$key] = $var[$key];
		}
    }   
}


function contentomatic_preg_grep_keys( $pattern, $input, $flags = 0 )
{
    if(!is_array($input))
    {
        return array();
    }
    $keys = preg_grep( $pattern, array_keys( $input ), $flags );
    $vals = array();
    foreach ( $keys as $key )
    {
        $vals[$key] = $input[$key];
    }
    return $vals;
}

function contentomatic_replace_attachment_url($att_url, $att_id) {
    {
         $post_id = get_the_ID();
         wp_suspend_cache_addition(true);
         $metas = get_post_custom($post_id);
         wp_suspend_cache_addition(false);
         $rez_meta = contentomatic_preg_grep_keys('#.+?_featured_img#i', $metas);
         if(count($rez_meta) > 0)
         {
             foreach($rez_meta as $rm)
             {
                 if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
                 {
                    return $rm[0];
                 }
             }
         }
    }
    return $att_url;
}


function contentomatic_replace_attachment_image_src($image, $att_id, $size) {
    {
        $post_id = get_the_ID();
        wp_suspend_cache_addition(true);
        $metas = get_post_custom($post_id);
        wp_suspend_cache_addition(false);
        $rez_meta = contentomatic_preg_grep_keys('#.+?_featured_img#i', $metas);
        if(count($rez_meta) > 0)
        {
            foreach($rez_meta as $rm)
            {
                if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
                {
                    return array($rm[0], 0, 0, false);
                }
            }
        }
     }
     return $image;
}

function contentomatic_thumbnail_external_replace( $html, $post_id ) {
    
    wp_suspend_cache_addition(true);
    $metas = get_post_custom($post_id);
    wp_suspend_cache_addition(false);
    $rez_meta = contentomatic_preg_grep_keys('#.+?_featured_img#i', $metas);
    if(count($rez_meta) > 0)
    {
        foreach($rez_meta as $rm)
        {
            if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
            {
                $alt = get_post_field( 'post_title', $post_id ) . ' ' .  esc_html__( 'thumbnail', 'amazomatic-amazon-post-generator' );
                $attr = array( 'alt' => $alt );
                $attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, NULL , 'thumbnail');
                $attr = array_map( 'esc_attr', $attr );
                $html = sprintf( '<img src="%s"', esc_url($rm[0]) );
                foreach ( $attr as $name => $value ) {
                    $html .= " " . esc_html($name) . "=" . '"' . esc_attr($value) . '"';
                }
                $html .= ' />';
                return $html;
            }
        }
    }
    return $html;
}
$plugin = plugin_basename(__FILE__);
if(is_admin())
{
    if($_SERVER["REQUEST_METHOD"]==="POST" && !empty($_POST["coderevolution_max_input_var_data"])) {
    $vars = explode("&", $_POST["coderevolution_max_input_var_data"]);
    $coderevolution_max_input_var_data = array();
    foreach($vars as $var) {
        parse_str($var, $variable);
        contentomatic_assign_var($_POST, $variable);
    }
	unset($_POST["coderevolution_max_input_var_data"]);
}
    $plugin_slug = explode('/', $plugin);
    $plugin_slug = $plugin_slug[0];
    if(isset($_POST[$plugin_slug . '_register']) && isset($_POST[$plugin_slug. '_register_code']) && trim($_POST[$plugin_slug . '_register_code']) != '')
    {
        update_option('coderevolution_settings_changed', 1);
        if(strlen(trim($_POST[$plugin_slug . '_register_code'])) != 36 || strstr($_POST[$plugin_slug . '_register_code'], '-') == false)
        {
            contentomatic_log_to_file('Invalid registration code submitted: ' . $_POST[$plugin_slug . '_register_code']);
        }
        else
        {
            $ch = curl_init('https://wpinitiate.com/verify-purchase/purchase.php');
            if($ch !== false)
            {
                $data           = array();
                $data['code']   = trim($_POST[$plugin_slug . '_register_code']);
                $data['siteURL']   = get_bloginfo('url');
                $data['siteName']   = get_bloginfo('name');
                $data['siteEmail']   = get_bloginfo('admin_email');
                $fdata = "";
                foreach ($data as $key => $val) {
                    $fdata .= "$key=" . urlencode(trim($val)) . "&";
                }
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                $result = curl_exec($ch);
                if($result === false)
                {
                    contentomatic_log_to_file('Failed to get verification response: ' . curl_error($ch));
                }
                else
                {
                    if($result == 'error1' || $result == 'error2' || $result == 'error3' || $result == 'error4')
                    {
                        contentomatic_log_to_file('Failed to validate plugin info: ' . $result);
                    }
                    else
                    {
                        $rj = json_decode($result, true);
                        if(isset($rj['item_name']))
                        {
                            $rj['code'] = $_POST[$plugin_slug . '_register_code'];
                            if($rj['item_id'] == '24990646' || $rj['item_id'] == '13371337' || $rj['item_id'] == '19200046')
                            {
                                update_option($plugin_slug . '_registration', $rj);
                                update_option('coderevolution_settings_changed', 2);
                            }
                            else
                            {
                                contentomatic_log_to_file('Invalid response from purchase code verification (are you sure you inputed the right purchase code?): ' . print_r($rj, true));
                            }
                        }
                        else
                        {
                            contentomatic_log_to_file('Invalid json from purchase code verification: ' . print_r($result, true));
                        }
                    }
                }
                curl_close($ch);
            }
            else
            {
                contentomatic_log_to_file('Failed to init curl when trying to make purchase verification.');
            }
        }
    }
    $uoptions = get_option($plugin_slug . '_registration', array());
    if(isset($uoptions['item_id']) && isset($uoptions['item_name']) && isset($uoptions['created_at']) && isset($uoptions['buyer']) && isset($uoptions['licence']) && isset($uoptions['supported_until']))
    {
        require "update-checker/plugin-update-checker.php";
        $fwdu3dcarPUC = Puc_v4_Factory::buildUpdateChecker("https://wpinitiate.com/auto-update/?action=get_metadata&slug=contentomatic-article-builder-post-generator", __FILE__, "contentomatic-article-builder-post-generator");
    }
    else
    {
        add_action("after_plugin_row_{$plugin}", function( $plugin_file, $plugin_data, $status ) {
            $plugin_url = '//codecanyon.net/item/contentomatic-article-builder-post-generator-plugin-for-wordpress/24990646';
            echo '<tr class="active"><td>&nbsp;</td><td colspan="2"><p class="cr_auto_update">';
          echo sprintf( wp_kses( __( 'The plugin is not registered. Automatic updating is disabled. Please purchase a license for it from <a href="%s" target="_blank">here</a> and register  the plugin from the \'Main Settings\' menu using your purchase code. <a href="%s" target="_blank">How I find my purchase code?', 'contentomatic-article-builder-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'http://1.envato.market/c/1264868/275988/4415?u=' . urlencode($plugin_url)), esc_url('//www.youtube.com/watch?v=NElJ5t_Wd48') );     
          echo '</a></p> </td></tr>';
        }, 10, 3 );
        add_action('admin_enqueue_scripts', 'contentomatic_admin_enqueue_all');
        add_filter("plugin_action_links_$plugin", 'contentomatic_add_activation_link');
    }
    add_action('admin_menu', 'contentomatic_register_my_custom_menu_page');
    add_action('network_admin_menu', 'contentomatic_register_my_custom_menu_page');
    add_filter("plugin_action_links_$plugin", 'contentomatic_add_support_link');
    add_filter("plugin_action_links_$plugin", 'contentomatic_add_settings_link');
    add_filter("plugin_action_links_$plugin", 'contentomatic_add_rating_link');
    add_action('add_meta_boxes', 'contentomatic_add_meta_box');
    add_action('admin_init', 'contentomatic_register_mysettings');
    require(dirname(__FILE__) . "/res/contentomatic-main.php");
    require(dirname(__FILE__) . "/res/contentomatic-rules-list.php");
    require(dirname(__FILE__) . "/res/contentomatic-logs.php");
}
function contentomatic_admin_enqueue_all()
{
    $reg_css_code = '.cr_auto_update{background-color:#fff8e5;margin:5px 20px 15px 20px;border-left:4px solid #fff;padding:12px 12px 12px 12px !important;border-left-color:#ffb900;}';
    wp_register_style( 'contentomatic-plugin-reg-style', false );
    wp_enqueue_style( 'contentomatic-plugin-reg-style' );
    wp_add_inline_style( 'contentomatic-plugin-reg-style', $reg_css_code );
}

function contentomatic_add_activation_link($links)
{
    $settings_link = '<a href="admin.php?page=contentomatic_admin_settings">' . esc_html__('Activate Plugin License', 'contentomatic-article-builder-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
use \Eventviva\ImageResize;

function contentomatic_register_my_custom_menu_page()
{
    add_menu_page('Contentomatic Post Generator', 'Contentomatic Post Generator', 'manage_options', 'contentomatic_admin_settings', 'contentomatic_admin_settings', plugins_url('images/icon.png', __FILE__));
    $main = add_submenu_page('contentomatic_admin_settings', esc_html__("Main Settings", 'contentomatic-article-builder-post-generator'), esc_html__("Main Settings", 'contentomatic-article-builder-post-generator'), 'manage_options', 'contentomatic_admin_settings');
    add_action( 'load-' . $main, 'contentomatic_load_all_admin_js' );
    add_action( 'load-' . $main, 'contentomatic_load_main_admin_js' );
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (isset($contentomatic_Main_Settings['contentomatic_enabled']) && $contentomatic_Main_Settings['contentomatic_enabled'] == 'on') {
        $latest = add_submenu_page('contentomatic_admin_settings', esc_html__('Article Builder To Posts', 'contentomatic-article-builder-post-generator'), esc_html__('Article Builder To Posts', 'contentomatic-article-builder-post-generator'), 'manage_options', 'contentomatic_items_panel', 'contentomatic_items_panel');
        add_action( 'load-' . $latest, 'contentomatic_load_admin_js' );
        add_action( 'load-' . $latest, 'contentomatic_load_all_admin_js' );
        $logs = add_submenu_page('contentomatic_admin_settings', esc_html__("Activity & Logging", 'contentomatic-article-builder-post-generator'), esc_html__("Activity & Logging", 'contentomatic-article-builder-post-generator'), 'manage_options', 'contentomatic_logs', 'contentomatic_logs');
        add_action( 'load-' . $logs, 'contentomatic_load_all_admin_js' );
    }
}
function contentomatic_load_admin_js(){
    add_action('admin_enqueue_scripts', 'contentomatic_enqueue_admin_js');
}

function contentomatic_enqueue_admin_js(){
    wp_enqueue_script('contentomatic-footer-script', plugins_url('scripts/footer.js', __FILE__), array('jquery'), false, true);
    $cr_miv = ini_get('max_input_vars');
	if($cr_miv === null || $cr_miv === false || !is_numeric($cr_miv))
	{
        $cr_miv = '9999999';
    }
    $footer_conf_settings = array(
        'max_input_vars' => $cr_miv,
        'plugin_dir_url' => plugin_dir_url(__FILE__),
        'ajaxurl' => admin_url('admin-ajax.php')
    );
    wp_localize_script('contentomatic-footer-script', 'mycustomsettings', $footer_conf_settings);
    wp_register_style('contentomatic-rules-style', plugins_url('styles/contentomatic-rules.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('contentomatic-rules-style');
}
function contentomatic_load_helper_js(){
    add_action('admin_enqueue_scripts', 'contentomatic_admin_load_helper');
}
function contentomatic_admin_load_helper()
{
    wp_enqueue_script('contentomatic-helper-script', plugins_url('scripts/helper.js', __FILE__), array('jquery'), false, true);
}
function contentomatic_load_main_admin_js(){
    add_action('admin_enqueue_scripts', 'contentomatic_enqueue_main_admin_js');
}

function contentomatic_enqueue_main_admin_js(){
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    wp_enqueue_script('contentomatic-main-script', plugins_url('scripts/main.js', __FILE__), array('jquery'));
    if(!isset($contentomatic_Main_Settings['best_user']))
    {
        $best_user = '';
    }
    else
    {
        $best_user = $contentomatic_Main_Settings['best_user'];
    }
    if(!isset($contentomatic_Main_Settings['best_password']))
    {
        $best_password = '';
    }
    else
    {
        $best_password = $contentomatic_Main_Settings['best_password'];
    }
    $header_main_settings = array(
        'best_user' => $best_user,
        'best_password' => $best_password
    );
    wp_localize_script('contentomatic-main-script', 'mycustommainsettings', $header_main_settings);
}
function contentomatic_load_all_admin_js(){
    add_action('admin_enqueue_scripts', 'contentomatic_admin_load_files');
}
function contentomatic_add_rating_link($links)
{
    $settings_link = '<a href="//codecanyon.net/downloads" target="_blank" title="Rate">
            <i class="wdi-rate-stars"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></i></a>';
    array_push($links, $settings_link);
    return $links;
}

function contentomatic_add_support_link($links)
{
    $settings_link = '<a href="//coderevolution.ro/knowledge-base/" target="_blank">' . esc_html__('Support', 'contentomatic-article-builder-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

function contentomatic_add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=contentomatic_admin_settings">' . esc_html__('Settings', 'contentomatic-article-builder-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

function contentomatic_add_meta_box()
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (isset($contentomatic_Main_Settings['contentomatic_enabled']) && $contentomatic_Main_Settings['contentomatic_enabled'] === 'on') {
        if (isset($contentomatic_Main_Settings['enable_metabox']) && $contentomatic_Main_Settings['enable_metabox'] == 'on') {
            foreach ( get_post_types( '', 'names' ) as $post_type ) {
               add_meta_box('contentomatic_meta_box_function_add', esc_html__('Contentomatic Automatic Post Generator Information', 'contentomatic-article-builder-post-generator'), 'contentomatic_meta_box_function', $post_type, 'advanced', 'default', array('__back_compat_meta_box' => true));
            }
            
        }
    }
}

add_filter('cron_schedules', 'contentomatic_add_cron_schedule');
function contentomatic_add_cron_schedule($schedules)
{
    $schedules['contentomatic_cron'] = array(
        'interval' => 3600,
        'display' => esc_html__('Contentomatic Cron', 'contentomatic-article-builder-post-generator')
    );
    $schedules['minutely'] = array(
        'interval' => 60,
        'display' => esc_html__('Once A Minute', 'contentomatic-article-builder-post-generator')
    );
    $schedules['weekly']        = array(
        'interval' => 604800,
        'display' => esc_html__('Once Weekly', 'contentomatic-article-builder-post-generator')
    );
    $schedules['monthly']       = array(
        'interval' => 2592000,
        'display' => esc_html__('Once Monthly', 'contentomatic-article-builder-post-generator')
    );
    return $schedules;
}
function contentomatic_auto_clear_log()
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
       wp_filesystem($creds);
    }
    if ($wp_filesystem->exists(WP_CONTENT_DIR . '/contentomatic_info.log')) {
        $wp_filesystem->delete(WP_CONTENT_DIR . '/contentomatic_info.log');
    }
}

register_deactivation_hook(__FILE__, 'contentomatic_my_deactivation');
function contentomatic_my_deactivation()
{
    wp_clear_scheduled_hook('contentomaticaction');
    wp_clear_scheduled_hook('contentomaticactionclear');
    $running = array();
    update_option('contentomatic_running_list', $running, false);
}
add_action('contentomaticaction', 'contentomatic_cron');
add_action('contentomaticactionclear', 'contentomatic_auto_clear_log');

function contentomatic_cron_schedule()
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (isset($contentomatic_Main_Settings['contentomatic_enabled']) && $contentomatic_Main_Settings['contentomatic_enabled'] === 'on') {
        if (!wp_next_scheduled('contentomaticaction')) {
            $unlocker = get_option('contentomatic_minute_running_unlocked', false);
            if($unlocker == '1')
            {
                $rez = wp_schedule_event(time(), 'minutely', 'contentomaticaction');
            }
            else
            {
                $rez = wp_schedule_event(time(), 'hourly', 'contentomaticaction');
            }
            
            if ($rez === FALSE) {
                contentomatic_log_to_file('[Scheduler] Failed to schedule contentomaticaction to contentomatic_cron!');
            }
        }
        
        if (isset($contentomatic_Main_Settings['enable_logging']) && $contentomatic_Main_Settings['enable_logging'] === 'on' && isset($contentomatic_Main_Settings['auto_clear_logs']) && $contentomatic_Main_Settings['auto_clear_logs'] !== 'No') {
            if (!wp_next_scheduled('contentomaticactionclear')) {
                $rez = wp_schedule_event(time(), $contentomatic_Main_Settings['auto_clear_logs'], 'contentomaticactionclear');
                if ($rez === FALSE) {
                    contentomatic_log_to_file('[Scheduler] Failed to schedule contentomaticactionclear to ' . $contentomatic_Main_Settings['auto_clear_logs'] . '!');
                }
                add_option('contentomatic_schedule_time', $contentomatic_Main_Settings['auto_clear_logs']);
            } else {
                if (!get_option('contentomatic_schedule_time')) {
                    wp_clear_scheduled_hook('contentomaticactionclear');
                    $rez = wp_schedule_event(time(), $contentomatic_Main_Settings['auto_clear_logs'], 'contentomaticactionclear');
                    add_option('contentomatic_schedule_time', $contentomatic_Main_Settings['auto_clear_logs']);
                    if ($rez === FALSE) {
                        contentomatic_log_to_file('[Scheduler] Failed to schedule contentomaticactionclear to ' . $contentomatic_Main_Settings['auto_clear_logs'] . '!');
                    }
                } else {
                    $the_time = get_option('contentomatic_schedule_time');
                    if ($the_time != $contentomatic_Main_Settings['auto_clear_logs']) {
                        wp_clear_scheduled_hook('contentomaticactionclear');
                        delete_option('contentomatic_schedule_time');
                        $rez = wp_schedule_event(time(), $contentomatic_Main_Settings['auto_clear_logs'], 'contentomaticactionclear');
                        add_option('contentomatic_schedule_time', $contentomatic_Main_Settings['auto_clear_logs']);
                        if ($rez === FALSE) {
                            contentomatic_log_to_file('[Scheduler] Failed to schedule contentomaticactionclear to ' . $contentomatic_Main_Settings['auto_clear_logs'] . '!');
                        }
                    }
                }
            }
        } else {
            if (!wp_next_scheduled('contentomaticactionclear')) {
                delete_option('contentomatic_schedule_time');
            } else {
                wp_clear_scheduled_hook('contentomaticactionclear');
                delete_option('contentomatic_schedule_time');
            }
        }
    } else {
        if (wp_next_scheduled('contentomaticaction')) {
            wp_clear_scheduled_hook('contentomaticaction');
        }
        
        if (!wp_next_scheduled('contentomaticactionclear')) {
            delete_option('contentomatic_schedule_time');
        } else {
            wp_clear_scheduled_hook('contentomaticactionclear');
            delete_option('contentomatic_schedule_time');
        }
    }
}
function contentomatic_cron()
{
    $GLOBALS['wp_object_cache']->delete('contentomatic_rules_list', 'options');
    if (!get_option('contentomatic_rules_list')) {
        $rules = array();
    } else {
        $rules = get_option('contentomatic_rules_list');
    }
    $unlocker = get_option('contentomatic_minute_running_unlocked', false);
    if (!empty($rules)) {
        $cont = 0;
        foreach ($rules as $request => $bundle[]) {
            $bundle_values   = array_values($bundle);
            $myValues        = $bundle_values[$cont];
            $array_my_values = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
            $schedule        = isset($array_my_values[1]) ? $array_my_values[1] : '24';
            $active          = isset($array_my_values[2]) ? $array_my_values[2] : '0';
            $last_run        = isset($array_my_values[3]) ? $array_my_values[3] : contentomatic_get_date_now();
            if ($active == '1') {
                $now                = contentomatic_get_date_now();
                if($unlocker == '1')
                {
                    $nextrun        = contentomatic_add_minute($last_run, $schedule);
                    $contentomatic_hour_diff = (int) contentomatic_minute_diff($now, $nextrun);
                }
                else
                {
                    $nextrun            = contentomatic_add_hour($last_run, $schedule);
                    $contentomatic_hour_diff = (int) contentomatic_hour_diff($now, $nextrun);
                }
                if ($contentomatic_hour_diff >= 0) {
                    contentomatic_run_rule($cont, 0);
                }
            }
            $cont = $cont + 1;
        }
    }
    $GLOBALS['wp_object_cache']->delete('contentomatic_all_list', 'options');
    if (!get_option('contentomatic_all_list')) {
        $rules2 = array();
    } else {
        $rules2 = get_option('contentomatic_all_list');
    }
    if (!empty($rules2)) {
        $cont2 = 0;
        foreach ($rules2 as $request2 => $bundle2[]) {
            $bundle_values2   = array_values($bundle2);
            $myValues2        = $bundle_values2[$cont2];
            $array_my_values2 = array_values($myValues2);for($iji=0;$iji<count($array_my_values2);++$iji){if(is_string($array_my_values2[$iji])){$array_my_values2[$iji]=stripslashes($array_my_values2[$iji]);}}
            $schedule2        = isset($array_my_values2[1]) ? $array_my_values2[1] : '24';
            $active2          = isset($array_my_values2[2]) ? $array_my_values2[2] : '0';
            $last_run2        = isset($array_my_values2[3]) ? $array_my_values2[3] : contentomatic_get_date_now();
            if ($active2 == '1') {
                $now2                = contentomatic_get_date_now();
                if($unlocker == '1')
                {
                    $nextrun2        = contentomatic_add_minute($last_run2, $schedule2);
                    $contentomatic_hour_diff2 = (int) contentomatic_minute_diff($now2, $nextrun2);
                }
                else
                {
                    $nextrun2            = contentomatic_add_hour($last_run2, $schedule2);
                    $contentomatic_hour_diff2 = (int) contentomatic_hour_diff($now2, $nextrun2);
                }
                
                if ($contentomatic_hour_diff2 >= 0) {
                    contentomatic_run_rule($cont2, 1);
                }
            }
            $cont2 = $cont2 + 1;
        }
    }
    $running = array();
    update_option('contentomatic_running_list', $running);
}

function contentomatic_log_to_file($str)
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (isset($contentomatic_Main_Settings['enable_logging']) && $contentomatic_Main_Settings['enable_logging'] == 'on') {
        $d = date("j-M-Y H:i:s e", current_time( 'timestamp' ));
        error_log("[$d] " . $str . "<br/>\r\n", 3, WP_CONTENT_DIR . '/contentomatic_info.log');
    }
}

function contentomatic_delete_all_posts()
{
    $failed                 = false;
    $number                 = 0;
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    $post_list = array();
    $postsPerPage = 50000;
    $paged = 0;
    do
    {
        $postOffset = $paged * $postsPerPage;
        $query = array(
            'post_status' => array(
                'publish',
                'draft',
                'pending',
                'trash',
                'private',
                'future'
            ),
            'post_type' => array(
                'any'
            ),
            'numberposts' => $postsPerPage,
            'meta_key' => 'contentomatic_parent_rule',
            'fields' => 'ids',
            'offset'  => $postOffset
        );
        $got_me = get_posts($query);
        $post_list = array_merge($post_list, $got_me);
        $paged++;
    }while(!empty($got_me));
    wp_suspend_cache_addition(true);
    foreach ($post_list as $post) {
        $index = get_post_meta($post, 'contentomatic_parent_rule', true);
        if (isset($index) && $index !== '') {
            $args             = array(
                'post_parent' => $post
            );
            $post_attachments = get_children($args);
            if (isset($post_attachments) && !empty($post_attachments)) {
                foreach ($post_attachments as $attachment) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
            $res = wp_delete_post($post, true);
            if ($res === false) {
                $failed = true;
            } else {
                $number++;
            }
        }
    }
    wp_suspend_cache_addition(false);
    if ($failed === true) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('[PostDelete] Failed to delete all posts!');
        }
    } else {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('[PostDelete] Successfuly deleted ' . esc_html($number) . ' posts!');
        }
    }
}

function contentomatic_replaceContentShortcodesAgain($the_content, $item_cat, $item_tags)
{
    $the_content = str_replace('%%item_cat%%', $item_cat, $the_content);
    $the_content = str_replace('%%item_tags%%', $item_tags, $the_content);
    return $the_content;
}
function contentomatic_replaceContentShortcodes($the_content, $just_title, $content, $description, $author, $date, $orig_content, $img_attr, $item_image)
{
    $the_content = str_replace('%%random_sentence%%', contentomatic_random_sentence_generator(), $the_content);
    $the_content = str_replace('%%random_sentence2%%', contentomatic_random_sentence_generator(false), $the_content);
    $the_content = contentomatic_replaceSynergyShortcodes($the_content);
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    $the_content = str_replace('%%item_show_image%%', contentomatic_getItemImage($item_image), $the_content);
    $the_content = str_replace('%%item_image_URL%%', $item_image, $the_content);
    if (isset($contentomatic_Main_Settings['custom_html'])) {
        $the_content = str_replace('%%custom_html%%', $contentomatic_Main_Settings['custom_html'], $the_content);
    }
    if (isset($contentomatic_Main_Settings['custom_html2'])) {
        $the_content = str_replace('%%custom_html2%%', $contentomatic_Main_Settings['custom_html2'], $the_content);
    }
    $img_attr = str_replace('%%image_source_name%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_url%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_website%%', '', $img_attr);
    $the_content = str_replace('%%royalty_free_image_attribution%%', $img_attr, $the_content);
    $the_content = str_replace('%%item_title%%', $just_title, $the_content);
    $the_content = str_replace('%%item_content%%', $content, $the_content);
    $the_content = str_replace('%%item_original_content%%', $orig_content, $the_content);
    $the_content = str_replace('%%item_content_plain_text%%', contentomatic_getPlainContent($content), $the_content);
    $the_content = str_replace('%%item_description%%', $description, $the_content);
    $the_content = str_replace('%%author%%', $author, $the_content);
    $the_content = str_replace('%%item_date%%', $date, $the_content);
    return $the_content;
}
function contentomatic_replaceTitleShortcodes($the_content, $just_title, $content, $date, $author)
{
    $the_content = str_replace('%%random_sentence%%', contentomatic_random_sentence_generator(), $the_content);
    $the_content = str_replace('%%random_sentence2%%', contentomatic_random_sentence_generator(false), $the_content);
    $the_content = str_replace('%%item_title%%', $just_title, $the_content);
    $the_content = str_replace('%%item_description%%', $content, $the_content);
    $the_content = str_replace('%%item_date%%', $date, $the_content);
    $the_content = str_replace('%%author%%', $author, $the_content);
    return $the_content;
}

function contentomatic_replaceTitleShortcodesAgain($the_content, $item_cat, $item_tags)
{
    $the_content = str_replace('%%item_cat%%', $item_cat, $the_content);
    $the_content = str_replace('%%item_tags%%', $item_tags, $the_content);
    return $the_content;
}

add_shortcode( 'contentomatic-display-posts', 'contentomatic_display_posts_shortcode' );
function contentomatic_display_posts_shortcode( $atts ) {
    
	$original_atts = $atts;
	$atts = shortcode_atts( array(
		'author'               => '',
		'category'             => '',
		'category_display'     => '',
		'category_label'       => 'Posted in: ',
		'content_class'        => 'content',
		'date_format'          => '(n/j/Y)',
		'date'                 => '',
		'date_column'          => 'post_date',
		'date_compare'         => '=',
		'date_query_before'    => '',
		'date_query_after'     => '',
		'date_query_column'    => '',
		'date_query_compare'   => '',
		'display_posts_off'    => false,
		'excerpt_length'       => false,
		'excerpt_more'         => false,
		'excerpt_more_link'    => false,
		'exclude_current'      => false,
		'id'                   => false,
		'ignore_sticky_posts'  => false,
		'image_size'           => false,
		'include_author'       => false,
		'include_content'      => false,
		'include_date'         => false,
		'include_excerpt'      => false,
		'include_link'         => true,
		'include_title'        => true,
		'meta_key'             => '',
		'meta_value'           => '',
		'no_posts_message'     => '',
		'offset'               => 0,
		'order'                => 'DESC',
		'orderby'              => 'date',
		'post_parent'          => false,
		'post_status'          => 'publish',
		'post_type'            => 'post',
		'posts_per_page'       => '10',
		'tag'                  => '',
		'tax_operator'         => 'IN',
		'tax_include_children' => true,
		'tax_term'             => false,
		'taxonomy'             => false,
		'time'                 => '',
		'title'                => '',
        'title_color'          => '#000000',
        'excerpt_color'        => '#000000',
        'title_font_size'      => '100%',
        'excerpt_font_size'    => '100%',
        'read_more_text'       => '',
		'wrapper'              => 'ul',
		'wrapper_class'        => 'display-posts-listing',
		'wrapper_id'           => false,
        'ruleid'               => '',
        'ruletype'             => ''
	), $atts, 'display-posts' );
	if( $atts['display_posts_off'] )
		return;
    $ruleid               = sanitize_text_field( $atts['ruleid'] );
    $ruletype             = sanitize_text_field( $atts['ruletype'] );
	$author               = sanitize_text_field( $atts['author'] );
	$category             = sanitize_text_field( $atts['category'] );
	$category_display     = 'true' == $atts['category_display'] ? 'category' : sanitize_text_field( $atts['category_display'] );
	$category_label       = sanitize_text_field( $atts['category_label'] );
	$content_class        = array_map( 'sanitize_html_class', ( explode( ' ', $atts['content_class'] ) ) );
	$date_format          = sanitize_text_field( $atts['date_format'] );
	$date                 = sanitize_text_field( $atts['date'] );
	$date_column          = sanitize_text_field( $atts['date_column'] );
	$date_compare         = sanitize_text_field( $atts['date_compare'] );
	$date_query_before    = sanitize_text_field( $atts['date_query_before'] );
	$date_query_after     = sanitize_text_field( $atts['date_query_after'] );
	$date_query_column    = sanitize_text_field( $atts['date_query_column'] );
	$date_query_compare   = sanitize_text_field( $atts['date_query_compare'] );
	$excerpt_length       = intval( $atts['excerpt_length'] );
	$excerpt_more         = sanitize_text_field( $atts['excerpt_more'] );
	$excerpt_more_link    = filter_var( $atts['excerpt_more_link'], FILTER_VALIDATE_BOOLEAN );
	$exclude_current      = filter_var( $atts['exclude_current'], FILTER_VALIDATE_BOOLEAN );
	$id                   = $atts['id'];
	$ignore_sticky_posts  = filter_var( $atts['ignore_sticky_posts'], FILTER_VALIDATE_BOOLEAN );
	$image_size           = sanitize_key( $atts['image_size'] );
	$include_title        = filter_var( $atts['include_title'], FILTER_VALIDATE_BOOLEAN );
	$include_author       = filter_var( $atts['include_author'], FILTER_VALIDATE_BOOLEAN );
	$include_content      = filter_var( $atts['include_content'], FILTER_VALIDATE_BOOLEAN );
	$include_date         = filter_var( $atts['include_date'], FILTER_VALIDATE_BOOLEAN );
	$include_excerpt      = filter_var( $atts['include_excerpt'], FILTER_VALIDATE_BOOLEAN );
	$include_link         = filter_var( $atts['include_link'], FILTER_VALIDATE_BOOLEAN );
	$meta_key             = sanitize_text_field( $atts['meta_key'] );
	$meta_value           = sanitize_text_field( $atts['meta_value'] );
	$no_posts_message     = sanitize_text_field( $atts['no_posts_message'] );
	$offset               = intval( $atts['offset'] );
	$order                = sanitize_key( $atts['order'] );
	$orderby              = sanitize_key( $atts['orderby'] );
	$post_parent          = $atts['post_parent'];
	$post_status          = $atts['post_status'];
	$post_type            = sanitize_text_field( $atts['post_type'] );
	$posts_per_page       = intval( $atts['posts_per_page'] );
	$tag                  = sanitize_text_field( $atts['tag'] );
	$tax_operator         = $atts['tax_operator'];
	$tax_include_children = filter_var( $atts['tax_include_children'], FILTER_VALIDATE_BOOLEAN );
	$tax_term             = sanitize_text_field( $atts['tax_term'] );
	$taxonomy             = sanitize_key( $atts['taxonomy'] );
	$time                 = sanitize_text_field( $atts['time'] );
	$shortcode_title      = sanitize_text_field( $atts['title'] );
    $title_color          = sanitize_text_field( $atts['title_color'] );
    $excerpt_color        = sanitize_text_field( $atts['excerpt_color'] );
    $excerpt_font_size    = sanitize_text_field( $atts['excerpt_font_size'] );
    $title_font_size      = sanitize_text_field( $atts['title_font_size'] );
    $read_more_text       = sanitize_text_field( $atts['read_more_text'] );
	$wrapper              = sanitize_text_field( $atts['wrapper'] );
	$wrapper_class        = array_map( 'sanitize_html_class', ( explode( ' ', $atts['wrapper_class'] ) ) );
	if( !empty( $wrapper_class ) )
		$wrapper_class = ' class="' . implode( ' ', $wrapper_class ) . '"';
	$wrapper_id = sanitize_html_class( $atts['wrapper_id'] );
	if( !empty( $wrapper_id ) )
		$wrapper_id = ' id="' . esc_html($wrapper_id) . '"';
	$args = array(
		'category_name'       => $category,
		'order'               => $order,
		'orderby'             => $orderby,
		'post_type'           => explode( ',', $post_type ),
		'posts_per_page'      => $posts_per_page,
		'tag'                 => $tag,
	);
	if ( ! empty( $date ) || ! empty( $time ) || ! empty( $date_query_after ) || ! empty( $date_query_before ) ) {
		$initial_date_query = $date_query_top_lvl = array();
		$valid_date_columns = array(
			'post_date', 'post_date_gmt', 'post_modified', 'post_modified_gmt',
			'comment_date', 'comment_date_gmt'
		);
		$valid_compare_ops = array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );
		$dates = contentomatic_sanitize_date_time( $date );
		if ( ! empty( $dates ) ) {
			if ( is_string( $dates ) ) {
				$timestamp = strtotime( $dates );
				$dates = array(
					'year'   => date( 'Y', $timestamp ),
					'month'  => date( 'm', $timestamp ),
					'day'    => date( 'd', $timestamp ),
				);
			}
			foreach ( $dates as $arg => $segment ) {
				$initial_date_query[ $arg ] = $segment;
			}
		}
		$times = contentomatic_sanitize_date_time( $time, 'time' );
		if ( ! empty( $times ) ) {
			foreach ( $times as $arg => $segment ) {
				$initial_date_query[ $arg ] = $segment;
			}
		}
		$before = contentomatic_sanitize_date_time( $date_query_before, 'date', true );
		if ( ! empty( $before ) ) {
			$initial_date_query['before'] = $before;
		}
		$after = contentomatic_sanitize_date_time( $date_query_after, 'date', true );
		if ( ! empty( $after ) ) {
			$initial_date_query['after'] = $after;
		}
		if ( ! empty( $date_query_column ) && in_array( $date_query_column, $valid_date_columns ) ) {
			$initial_date_query['column'] = $date_query_column;
		}
		if ( ! empty( $date_query_compare ) && in_array( $date_query_compare, $valid_compare_ops ) ) {
			$initial_date_query['compare'] = $date_query_compare;
		}
		if ( ! empty( $date_column ) && in_array( $date_column, $valid_date_columns ) ) {
			$date_query_top_lvl['column'] = $date_column;
		}
		if ( ! empty( $date_compare ) && in_array( $date_compare, $valid_compare_ops ) ) {
			$date_query_top_lvl['compare'] = $date_compare;
		}
		if ( ! empty( $initial_date_query ) ) {
			$date_query_top_lvl[] = $initial_date_query;
		}
		$args['date_query'] = $date_query_top_lvl;
	}
    if($ruleid != '' && $ruletype != '')
    {
        $q_arr = array();
        $temp_arr['key'] = 'contentomatic_parent_rule1';
        $temp_arr['value'] = $ruleid;
        $q_arr[] = $temp_arr;
        $temp_arr2['key'] = 'contentomatic_parent_type';
        $temp_arr2['value'] = $ruletype;
        $q_arr[] = $temp_arr2;
        $args['meta_query'] = $q_arr;
    }
    elseif($ruleid != '')
    {
        $args['meta_key'] = 'contentomatic_parent_rule1';
        $args['meta_value'] = $ruleid;
    }
    elseif($ruletype != '')
    {
        $args['meta_key'] = 'contentomatic_parent_type';
        $args['meta_value'] = $ruletype;
    }
	if( $ignore_sticky_posts )
		$args['ignore_sticky_posts'] = true;
	 
	if( $id ) {
		$posts_in = array_map( 'intval', explode( ',', $id ) );
		$args['post__in'] = $posts_in;
	}
	if( is_singular() && $exclude_current )
		$args['post__not_in'] = array( get_the_ID() );
	if( !empty( $author ) ) {
		if( 'current' == $author && is_user_logged_in() )
			$args['author_name'] = wp_get_current_user()->user_login;
		elseif( 'current' == $author )
            $unrelevar = false;
			 
		else
			$args['author_name'] = $author;
	}
	if( !empty( $offset ) )
		$args['offset'] = $offset;
	$post_status = explode( ', ', $post_status );
	$validated = array();
	$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
	foreach ( $post_status as $unvalidated )
		if ( in_array( $unvalidated, $available ) )
			$validated[] = $unvalidated;
	if( !empty( $validated ) )
		$args['post_status'] = $validated;
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
		if( 'current' == $tax_term ) {
			global $post;
			$terms = wp_get_post_terms(get_the_ID(), $taxonomy);
			$tax_term = array();
			foreach ($terms as $term) {
				$tax_term[] = $term->slug;
			}
		}else{
			$tax_term = explode( ', ', $tax_term );
		}
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy'         => $taxonomy,
					'field'            => 'slug',
					'terms'            => $tax_term,
					'operator'         => $tax_operator,
					'include_children' => $tax_include_children,
				)
			)
		);
		$count = 2;
		$more_tax_queries = false;
		while(
			isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
			isset( $original_atts['tax_' . esc_html($count) . '_term'] ) && !empty( $original_atts['tax_' . esc_html($count) . '_term'] )
		):
			$more_tax_queries = true;
			$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
	 		$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . esc_html($count) . '_term'] ) );
	 		$tax_operator = isset( $original_atts['tax_' . esc_html($count) . '_operator'] ) ? $original_atts['tax_' . esc_html($count) . '_operator'] : 'IN';
	 		$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
	 		$tax_include_children = isset( $original_atts['tax_' . esc_html($count) . '_include_children'] ) ? filter_var( $atts['tax_' . esc_html($count) . '_include_children'], FILTER_VALIDATE_BOOLEAN ) : true;
	 		$tax_args['tax_query'][] = array(
	 			'taxonomy'         => $taxonomy,
	 			'field'            => 'slug',
	 			'terms'            => $terms,
	 			'operator'         => $tax_operator,
	 			'include_children' => $tax_include_children,
	 		);
			$count++;
		endwhile;
		if( $more_tax_queries ):
			$tax_relation = 'AND';
			if( isset( $original_atts['tax_relation'] ) && in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) ) )
				$tax_relation = $original_atts['tax_relation'];
			$args['tax_query']['relation'] = $tax_relation;
		endif;
		$args = array_merge_recursive( $args, $tax_args );
	}
	if( $post_parent !== false ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = get_the_ID();
		}
		$args['post_parent'] = intval( $post_parent );
	}
	$wrapper_options = array( 'ul', 'ol', 'div' );
	if( ! in_array( $wrapper, $wrapper_options ) )
		$wrapper = 'ul';
	$inner_wrapper = 'div' == $wrapper ? 'div' : 'li';
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $original_atts ) );
	if ( ! $listing->have_posts() ) {
		return apply_filters( 'display_posts_shortcode_no_results', wpautop( $no_posts_message ) );
	}
	$inner = '';
    wp_suspend_cache_addition(true);
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
		$image = $date = $author = $excerpt = $content = '';
		if ( $include_title && $include_link ) {
            $title = '<a class="contentomatic_display_title" href="' . apply_filters( 'the_permalink', get_permalink() ) . '"><span class="cr_display_span" >' . get_the_title() . '</span></a>';
		} elseif( $include_title ) {
			$title = '<span class="contentomatic_display_title" class="cr_display_span">' . get_the_title() . '</span>';
		} else {
			$title = '';
		}
		if ( $image_size && has_post_thumbnail() && $include_link ) {
            $image = '<a class="contentomatic_display_image" href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> <br/>';
		} elseif( $image_size && has_post_thumbnail() ) {
			$image = '<span class="contentomatic_display_image">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</span> <br/>';
		}
		if ( $include_date )
			$date = ' <span class="date">' . get_the_date( $date_format ) . '</span>';
		if( $include_author )
			$author = apply_filters( 'display_posts_shortcode_author', ' <span class="contentomatic_display_author">by ' . get_the_author() . '</span>', $original_atts );
		if ( $include_excerpt ) {
			if( $excerpt_length || $excerpt_more || $excerpt_more_link ) {
				$length = $excerpt_length ? $excerpt_length : apply_filters( 'excerpt_length', 55 );
				$more   = $excerpt_more ? $excerpt_more : apply_filters( 'excerpt_more', '' );
				$more   = $excerpt_more_link ? ' <a href="' . get_permalink() . '">' . esc_html($more) . '</a>' : ' ' . esc_html($more);
				if( has_excerpt() && apply_filters( 'display_posts_shortcode_full_manual_excerpt', false ) ) {
					$excerpt = $post->post_excerpt . $more;
				} elseif( has_excerpt() ) {
					$excerpt = wp_trim_words( strip_shortcodes( $post->post_excerpt ), $length, $more );
				} else {
					$excerpt = wp_trim_words( strip_shortcodes( $post->post_content ), $length, $more );
				}
			} else {
				$excerpt = get_the_excerpt();
			}
			$excerpt = ' <br/><br/> <span class="contentomatic_display_excerpt" class="cr_display_excerpt_adv">' . $excerpt . '</span>';
            if($read_more_text != '')
            {
                $excerpt .= '<br/><a href="' . get_permalink() . '"><span class="contentomatic_display_excerpt" class="cr_display_excerpt_adv">' . esc_html($read_more_text) . '</span></a>';
            }
		}
		if( $include_content ) {
			add_filter( 'shortcode_atts_display-posts', 'contentomatic_display_posts_off', 10, 3 );
			$content = '<div class="' . implode( ' ', $content_class ) . '">' . apply_filters( 'the_content', get_the_content() ) . '</div>';
			remove_filter( 'shortcode_atts_display-posts', 'contentomatic_display_posts_off', 10, 3 );
		}
		$category_display_text = '';
		if( $category_display && is_object_in_taxonomy( get_post_type(), $category_display ) ) {
			$terms = get_the_terms( get_the_ID(), $category_display );
			$term_output = array();
			foreach( $terms as $term )
				$term_output[] = '<a href="' . get_term_link( $term, $category_display ) . '">' . esc_html($term->name) . '</a>';
			$category_display_text = ' <span class="category-display"><span class="category-display-label">' . esc_html($category_label) . '</span> ' . trim(implode( ', ', $term_output ), ', ') . '</span>';
			$category_display_text = apply_filters( 'display_posts_shortcode_category_display', $category_display_text );
		}
		$class = array( 'listing-item' );
		$class = array_map( 'sanitize_html_class', apply_filters( 'display_posts_shortcode_post_class', $class, $post, $listing, $original_atts ) );
		$output = '<br/><' . esc_html($inner_wrapper) . ' class="' . implode( ' ', $class ) . '">' . $image . $title . $date . $author . $category_display_text . $excerpt . $content . '</' . esc_html($inner_wrapper) . '><br/><br/><hr class="cr_hr_dot"/>';		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $original_atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class );
	endwhile; wp_reset_postdata();
    wp_suspend_cache_addition(false);
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<' . $wrapper . $wrapper_class . $wrapper_id . '>', $original_atts );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '</' . esc_html($wrapper) . '>', $original_atts );
	$return = $open;
	if( $shortcode_title ) {
		$title_tag = apply_filters( 'display_posts_shortcode_title_tag', 'h2', $original_atts );
		$return .= '<' . esc_html($title_tag) . ' class="display-posts-title">' . esc_html($shortcode_title) . '</' . esc_html($title_tag) . '>' . "\n";
	}
	$return .= $inner . $close;
    $reg_css_code = '.cr_hr_dot{border-top: dotted 1px;}.cr_display_span{font-size:' . esc_html($title_font_size) . ';color:' . esc_html($title_color) . ' !important;}.cr_display_excerpt_adv{font-size:' . esc_html($excerpt_font_size) . ';color:' . esc_html($excerpt_color) . ' !important;}';
    wp_register_style( 'contentomatic-display-style', false );
    wp_enqueue_style( 'contentomatic-display-style' );
    wp_add_inline_style( 'contentomatic-display-style', $reg_css_code );
	return $return;
}
function contentomatic_sanitize_date_time( $date_time, $type = 'date', $accepts_string = false ) {
	if ( empty( $date_time ) || ! in_array( $type, array( 'date', 'time' ) ) ) {
		return array();
	}
	$segments = array();
	if (
		true === $accepts_string
		&& ( false !== strpos( $date_time, ' ' ) || false === strpos( $date_time, '-' ) )
	) {
		if ( false !== $timestamp = strtotime( $date_time ) ) {
			return $date_time;
		}
	}
	$parts = array_map( 'absint', explode( 'date' == $type ? '-' : ':', $date_time ) );
	if ( 'date' == $type ) {
		$year = $month = $day = 1;
		if ( count( $parts ) >= 3 ) {
			list( $year, $month, $day ) = $parts;
			$year  = ( $year  >= 1 && $year  <= 9999 ) ? $year  : 1;
			$month = ( $month >= 1 && $month <= 12   ) ? $month : 1;
			$day   = ( $day   >= 1 && $day   <= 31   ) ? $day   : 1;
		}
		$segments = array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day
		);
	} elseif ( 'time' == $type ) {
		$hour = $minute = $second = 0;
		switch( count( $parts ) ) {
			case 3 :
				list( $hour, $minute, $second ) = $parts;
				$hour   = ( $hour   >= 0 && $hour   <= 23 ) ? $hour   : 0;
				$minute = ( $minute >= 0 && $minute <= 60 ) ? $minute : 0;
				$second = ( $second >= 0 && $second <= 60 ) ? $second : 0;
				break;
			case 2 :
				list( $hour, $minute ) = $parts;
				$hour   = ( $hour   >= 0 && $hour   <= 23 ) ? $hour   : 0;
				$minute = ( $minute >= 0 && $minute <= 60 ) ? $minute : 0;
				break;
			default : break;
		}
		$segments = array(
			'hour'   => $hour,
			'minute' => $minute,
			'second' => $second
		);
	}

	return apply_filters( 'display_posts_shortcode_sanitized_segments', $segments, $date_time, $type );
}

function contentomatic_display_posts_off( $out, $pairs, $atts ) {
	$out['display_posts_off'] = apply_filters( 'display_posts_shortcode_inception_override', true );
	return $out;
}
add_shortcode( 'contentomatic-list-posts', 'contentomatic_list_posts' );
function contentomatic_list_posts( $atts ) {
    ob_start();
    extract( shortcode_atts( array (
        'type' => 'any',
        'order' => 'ASC',
        'orderby' => 'title',
        'posts' => 50,
        'category' => '',
        'ruleid' => '',
        'ruletype' => ''
    ), $atts ) );
    $options = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
        'category_name' => $category
    );
    if($ruleid != '' && $ruletype != '')
    {
        $q_arr = array();
        $temp_arr['key'] = 'contentomatic_parent_rule1';
        $temp_arr['value'] = $ruleid;
        $q_arr[] = $temp_arr;
        $temp_arr2['key'] = 'contentomatic_parent_type';
        $temp_arr2['value'] = $ruletype;
        $q_arr[] = $temp_arr2;
        $options['meta_query'] = $q_arr;
    }
    elseif($ruleid != '')
    {
        $options['meta_key'] = 'contentomatic_parent_rule1';
        $options['meta_value'] = $ruleid;
    }
    elseif($ruletype != '')
    {
        $options['meta_key'] = 'contentomatic_parent_type';
        $options['meta_value'] = $ruletype;
    }
    
    $query = new WP_Query( $options );
    if ( $query->have_posts() ) { ?>
        <ul class="clothes-listing">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title());?></a>
            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
    return '';
}

add_action('wp_ajax_contentomatic_my_action', 'contentomatic_my_action_callback');
function contentomatic_my_action_callback()
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    $failed                 = false;
    $del_id                 = $_POST['id'];
    $type                   = $_POST['type'];
    $how                    = $_POST['how'];
    if($how == 'duplicate')
    {
        if($type == 1)
        {
            $GLOBALS['wp_object_cache']->delete('contentomatic_all_list', 'options');
            if (!get_option('contentomatic_all_list')) {
                $rules = array();
            } else {
                $rules = get_option('contentomatic_all_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    contentomatic_log_to_file('contentomatic_all_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('contentomatic_all_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                contentomatic_log_to_file('contentomatic_all_list empty!');
                echo 'nochange';
                die();
            }
        }
        else
        {
            $GLOBALS['wp_object_cache']->delete('contentomatic_rules_list', 'options');
            if (!get_option('contentomatic_rules_list')) {
                $rules = array();
            } else {
                $rules = get_option('contentomatic_rules_list');
            }
            if (!empty($rules)) {
                $found            = 0;
                $cont = 0;
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $del_id) {
                        $copy_bundle = $rules[$request];
                        $rules[] = $copy_bundle;
                        $found   = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
                if($found == 0)
                {
                    contentomatic_log_to_file('contentomatic_rules_list index not found: ' . $del_id);
                    echo 'nochange';
                    die();
                }
                else
                {
                    update_option('contentomatic_rules_list', $rules, false);
                    echo 'ok';
                    die();
                }
            } else {
                contentomatic_log_to_file('contentomatic_rules_list empty!');
                echo 'nochange';
                die();
            }
        } 
    }
    $force_delete           = true;
    $number                 = 0;
    if ($how == 'trash') {
        $force_delete = false;
    }
    $post_list = array();
    $postsPerPage = 50000;
    $paged = 0;
    do
    {
        $postOffset = $paged * $postsPerPage;
        $query = array(
            'post_status' => array(
                'publish',
                'draft',
                'pending',
                'trash',
                'private',
                'future'
            ),
            'post_type' => array(
                'any'
            ),
            'numberposts' => $postsPerPage,
            'meta_key' => 'contentomatic_parent_rule',
            'fields' => 'ids',
            'offset'  => $postOffset
        );
        $got_me = get_posts($query);
        $post_list = array_merge($post_list, $got_me);
        $paged++;
    }while(!empty($got_me));
    wp_suspend_cache_addition(true);
    foreach ($post_list as $post) {
        $index = get_post_meta($post, 'contentomatic_parent_rule', true);
        if ($index == $type . '-' . $del_id) {
            $args             = array(
                'post_parent' => $post
            );
            $post_attachments = get_children($args);
            if (isset($post_attachments) && !empty($post_attachments)) {
                foreach ($post_attachments as $attachment) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
            $res = wp_delete_post($post, $force_delete);
            if ($res === false) {
                $failed = true;
            } else {
                $number++;
            }
        }
    }
    wp_suspend_cache_addition(false);
    if ($failed === true) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('[PostDelete] Failed to delete all posts for rule id: ' . esc_html($del_id) . '!');
        }
        echo 'failed';
    } else {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('[PostDelete] Successfuly deleted ' . esc_html($number) . ' posts for rule id: ' . esc_html($del_id) . '!');
        }
        if ($number == 0) {
            echo 'nochange';
        } else {
            echo 'ok';
        }
    }
    die();
}

add_action('wp_ajax_contentomatic_run_my_action', 'contentomatic_run_my_action_callback');
function contentomatic_run_my_action_callback()
{
    $run_id = $_POST['id'];
    $run_type = isset($_POST['type']) ? $_POST['type'] : 0;
    echo contentomatic_run_rule($run_id, $run_type, 0);
    die();
}

function contentomatic_clearFromList($param, $type)
{
    $GLOBALS['wp_object_cache']->delete('contentomatic_running_list', 'options');
    $running = get_option('contentomatic_running_list');
    $key = array_search(array(
        $param => $type
    ), $running);
    if ($key !== FALSE) {
        unset($running[$key]);
        update_option('contentomatic_running_list', $running);
    }
}

function contentomatic_get_web_page($url)
{
    $content = false;
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);

   $args = array(
           'timeout'     => 30,
           'redirection' => 10,
           'user-agent'  => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
           'blocking'    => true,
           'headers'     => array(),
           'cookies'     => array(),
           'body'        => null,
           'compress'    => false,
           'decompress'  => true,
           'sslverify'   => false,
           'stream'      => false,
           'filename'    => null
    );
    $ret_data            = wp_remote_get(html_entity_decode($url), $args);  
    $response_code       = wp_remote_retrieve_response_code( $ret_data );
    $response_message    = wp_remote_retrieve_response_message( $ret_data );        
    if ( 200 != $response_code ) {
    } else {
        $content = wp_remote_retrieve_body( $ret_data );
    }
    if($content === false)
    {
        if(function_exists('curl_version') && filter_var($url, FILTER_VALIDATE_URL))
        {
            $options    = array(
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_COOKIEJAR => 'contentomaticcookie.txt',
                CURLOPT_COOKIEFILE => 'contentomaticcookie.txt',
                CURLOPT_POST => false,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_AUTOREFERER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            );
            $ch = curl_init($url);
            if ($ch === FALSE) {
                contentomatic_log_to_file('curl not inited: ' . $url);
                $allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
                if ($allowUrlFopen) {
                    global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                return $wp_filesystem->get_contents($url);
                }
            }
            curl_setopt_array($ch, $options);
            
            $content = curl_exec($ch);
            if($content === false)
            {
                contentomatic_log_to_file('Error occured in curl: ' . curl_error($ch) . ', url: ' . $url);
                $allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
                if ($allowUrlFopen) {
                    global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                return $wp_filesystem->get_contents($url);
                }
            }
            curl_close($ch);
        }
        else
        {
            $allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
            if ($allowUrlFopen) {
                global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                return $wp_filesystem->get_contents($url);
            }
        }
    }
    return $content;
}

function contentomatic_utf8_encode($str)
{
    if(function_exists('mb_detect_encoding') && function_exists('mb_convert_encoding'))
    {
        $enc = mb_detect_encoding($str);
        if ($enc !== FALSE) {
            $str = mb_convert_encoding($str, 'UTF-8', $enc);
        } else {
            $str = mb_convert_encoding($str, 'UTF-8');
        }
    }
    return $str;
}

function contentomatic_substr_close_tags($text, $max_length)
{
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $in_double_quotes = false;
    $in_single_quotes = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);
    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        while ($i < mb_strlen($text) && $stripped < mb_strlen($stripped_text) && $stripped < $max_length)
        {
            $symbol  = mb_substr($text,$i,1);
            $result .= $symbol;

            switch ($symbol)
            {
               case '<':
                    $is_open   = true;
                    $grab_open = true;
                    break;

               case '"':
                   if ($in_double_quotes)
                       $in_double_quotes = false;
                   else
                       $in_double_quotes = true;

                break;

                case "'":
                  if ($in_single_quotes)
                      $in_single_quotes = false;
                  else
                      $in_single_quotes = true;

                break;

                case '/':
                    if ($is_open && !$in_double_quotes && !$in_single_quotes)
                    {
                        $is_close  = true;
                        $is_open   = false;
                        $grab_open = false;
                    }

                    break;

                case ' ':
                    if ($is_open)
                        $grab_open = false;
                    else
                        $stripped++;

                    break;

                case '>':
                    if ($is_open)
                    {
                        $is_open   = false;
                        $grab_open = false;
                        array_push($tags, $tag);
                        $tag = "";
                    }
                    else if ($is_close)
                    {
                        $is_close = false;
                        array_pop($tags);
                        $tag = "";
                    }

                    break;

                default:
                    if ($grab_open || $is_close)
                        $tag .= $symbol;

                    if (!$is_open && !$is_close)
                        $stripped++;
            }
            $i++;
        }
    }
    else
    {
        while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
        {
            $symbol  = $text{$i};
            $result .= $symbol;

            switch ($symbol)
            {
               case '<':
                    $is_open   = true;
                    $grab_open = true;
                    break;

               case '"':
                   if ($in_double_quotes)
                       $in_double_quotes = false;
                   else
                       $in_double_quotes = true;

                break;

                case "'":
                  if ($in_single_quotes)
                      $in_single_quotes = false;
                  else
                      $in_single_quotes = true;

                break;

                case '/':
                    if ($is_open && !$in_double_quotes && !$in_single_quotes)
                    {
                        $is_close  = true;
                        $is_open   = false;
                        $grab_open = false;
                    }

                    break;

                case ' ':
                    if ($is_open)
                        $grab_open = false;
                    else
                        $stripped++;

                    break;

                case '>':
                    if ($is_open)
                    {
                        $is_open   = false;
                        $grab_open = false;
                        array_push($tags, $tag);
                        $tag = "";
                    }
                    else if ($is_close)
                    {
                        $is_close = false;
                        array_pop($tags);
                        $tag = "";
                    }

                    break;

                default:
                    if ($grab_open || $is_close)
                        $tag .= $symbol;

                    if (!$is_open && !$is_close)
                        $stripped++;
            }
            $i++;
        }
    }

    while ($tags)
        $result .= "</".array_pop($tags).">";
    return $result;
}
function contentomatic_my_list_cats() {
    $catsArray = array();
    $cat_args   = array(
        'orderby' => 'name',
        'hide_empty' => 0,
        'order' => 'ASC'
    );
    $categories = get_categories($cat_args);
    foreach($categories as $cat) {
        $catsArray[] = $cat->name;
    }
    return $catsArray;
}
function contentomatic_my_user_by_rand( $ua ) {
  remove_action('pre_user_query', 'contentomatic_my_user_by_rand');
  $ua->query_orderby = str_replace( 'user_login ASC', 'RAND()', $ua->query_orderby );
}

function contentomatic_display_random_user(){
  add_action('pre_user_query', 'contentomatic_my_user_by_rand');
  $args = array(
    'orderby' => 'user_login', 'order' => 'ASC', 'number' => 1
  );
  $user_query = new WP_User_Query( $args );
  $user_query->query();
  $results = $user_query->results;
  if(empty($results))
  {
      return false;
  }
  return array_pop($results);
}

function contentomatic_get_positions($needle, $haystack)
{
    preg_match_all('#' . $needle . '#', $haystack, $m, PREG_OFFSET_CAPTURE);
    return $m;
}

function contentomatic_url_handle($href, $api_key)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.shorte.st/v1/data/url");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "urlToShorten=" . trim($href));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [
        'public-api-token: ' . $api_key,
        'Content-Type: application/x-www-form-urlencoded'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $serverOutput = json_decode(curl_exec($ch), true);
    curl_close($ch);
    if (!isset($serverOutput['shortenedUrl']) || $serverOutput['shortenedUrl'] == '') {
        return $href;
    } else {
        return esc_url($serverOutput['shortenedUrl']);
    }  
}

function contentomatic_get_featured_image($content)
{
    $biggest_img = '';
    $doc = new DOMDocument();
    $internalErrors = libxml_use_internal_errors(true);
    $doc->loadHTML($content);
                    libxml_use_internal_errors($internalErrors);
    $tags    = $doc->getElementsByTagName('img');
    $maxSize = 0;
    foreach ($tags as $tag) {
        $temp_get_img = $tag->getAttribute('src');
        if ($temp_get_img != '') {
            $temp_get_img = strtok($temp_get_img, '?');
            $temp_get_img   = rtrim($temp_get_img, '/');
            $image=getimagesize($temp_get_img);
            if(isset($image[0]) && isset($image[1]) && is_numeric($image[0]) && is_numeric($image[1]))
            {
                if (($image[0] * $image[1]) > $maxSize) {   
                    $maxSize = $image[0] * $image[1]; 
                    $biggest_img = $temp_get_img;
                }
            }
            else
            {
                 $image = contentomatic_getimgsize($temp_get_img);
                 if(isset($image[0]) && isset($image[1]) && is_numeric($image[0]) && is_numeric($image[1]))
                 {
                    if (($image[0] * $image[1]) > $maxSize) {   
                        $maxSize = $image[0] * $image[1]; 
                        $biggest_img = $temp_get_img;
                    }
                 }
            }
        }
    }
    return $biggest_img;
}
function contentomatic_getimgsize($url, $referer = 'https://www.google.com')
{
    $headers = array(
        'Range: bytes=0-32768'
    );
    if (!empty($referer)) array_push($headers, 'Referer: '.$referer);
    $curl = curl_init($url);
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $data = curl_exec($curl);
    curl_close($curl);
    if($data == false)
    {
        return false;
    }
    $image = imagecreatefromstring($data);

    $return = array(imagesx($image), imagesy($image));

    imagedestroy($image);

    return $return;
}
function contentomatic_replaceSynergyShortcodes($the_content)
{
    $regex = '#%%([a-z0-9]+?)_(\d+?)_(\d+?)%%#';
    $rezz = preg_match_all($regex, $the_content, $matches);
    if ($rezz === FALSE) {
        return $the_content;
    }
    if(isset($matches[1][0]))
    {
        $two_var_functions = array('pdfomatic');
        $three_var_functions = array('bhomatic', 'crawlomatic', 'dmomatic', 'ezinomatic', 'fbomatic', 'flickomatic', 'imguromatic', 'iui', 'instamatic', 'linkedinomatic', 'mediumomatic', 'pinterestomatic', 'echo', 'spinomatic', 'tumblomatic', 'wordpressomatic', 'wpcomomatic', 'youtubomatic', 'mastermind', 'businessomatic');
        $four_var_functions = array('contentomatic', 'newsomatic', 'aliomatic', 'amazomatic', 'blogspotomatic', 'bookomatic', 'careeromatic', 'cbomatic', 'cjomatic', 'craigomatic', 'ebayomatic', 'etsyomatic', 'eventomatic', 'gameomatic', 'gearomatic', 'giphyomatic', 'gplusomatic', 'hackeromatic', 'imageomatic', 'midas', 'movieomatic', 'nasaomatic', 'ocartomatic', 'okomatic', 'playomatic', 'recipeomatic', 'redditomatic', 'soundomatic', 'mp3omatic', 'ticketomatic', 'tmomatic', 'trendomatic', 'tuneomatic', 'twitchomatic', 'twitomatic', 'vimeomatic', 'viralomatic', 'vkomatic', 'walmartomatic', 'wikiomatic', 'xlsxomatic', 'yelpomatic', 'yummomatic');
        for ($i = 0; $i < count($matches[1]); $i++)
        {
            $replace_me = false;
            if(in_array($matches[1][$i], $four_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 4)
                    {  
                        $rule_runner = $za_function($matches[3][$i], $matches[2][$i], 0, 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            elseif(in_array($matches[1][$i], $three_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 3)
                    {
                        $rule_runner = $za_function($matches[3][$i], 0, 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            elseif(in_array($matches[1][$i], $two_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 2)
                    {
                        $rule_runner = $za_function($matches[3][$i], 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            if($replace_me == false)
            {
                $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', '', $the_content);
            }
        }
    }
    return $the_content;
}
function contentomatic_curl_post($url, $data, &$info){

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, contentomatic_curl_postData($data));
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_REFERER, $url);
  $html = trim(curl_exec($ch));
  curl_close($ch);

  return $html;
}

function contentomatic_curl_postData($data){

  $fdata = "";
  foreach($data as $key => $val){
    $fdata .= "$key=" . urlencode($val) . "&";
  }

  return $fdata;
}
function contentomatic_get_categories()
{
	$categories_option_value = get_option('contentomatic_categories_list');
	if(isset($categories_option_value['category_list']) && isset($categories_option_value['last_updated']))
	{
		if( (time() - $categories_option_value['last_updated']) < 686400 )
		{
			return $categories_option_value;
		}
	}
	$categories = contentomatic_update_categories();
	if(is_array($categories))
	{
		return $categories;
	}
	return false;
}

function contentomatic_update_categories()
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (isset($contentomatic_Main_Settings['app_id']) && trim($contentomatic_Main_Settings['app_id']) !== '' && isset($contentomatic_Main_Settings['app_pass']) && trim($contentomatic_Main_Settings['app_pass']) !== '') {
        $categories = array();
        $url = 'http://articlebuilder.net/api.php';
        $info = '';
        $data = array();
        $data['action'] = 'authenticate';
        $data['format'] = 'php';
        $data['username'] = $contentomatic_Main_Settings['app_id'];
        $data['password'] = $contentomatic_Main_Settings['app_pass'];

        $output = unserialize(contentomatic_curl_post($url, $data, $info));
        if($output['success']=='true'){
            $session = $output['session'];

            $data = array();
            $data['session'] = $session;
            $data['action'] = 'categories';
            $data['format'] = 'json';
            $cats = contentomatic_curl_post($url, $data, $info);	
            if ($cats === FALSE) {
                $ret = array();
                return $ret;
            }
            $cats = json_decode($cats);
            if ($cats === FALSE) {
                $ret = array();
                return $ret;
            }
            if ($cats->success != 'true') {
                $ret = array();
                return $ret;
            }
            foreach($cats->output as $api_category)
            {
                $categories[] = $api_category;
            }
            $news_categories = array(
                'category_list' => $categories,
                'last_updated' => time()
            );
            update_option('contentomatic_categories_list', $news_categories);
            return $news_categories;
        }
        else
        {
            $ret = array();
            return $ret;
        }
    }
    else
    {
        $ret = array();
        return $ret;
    }
}

function contentomatic_articlebuilder($user, $pass, $category, $num, $query_string, $word_count, $enable_lsi, $enable_superspun, $kw_replace, $spin_content, $spin_phrases, $contentomatic_comments) 
{
	$feed_url = 'http://articlebuilder.net/api.php';
	$data = array();
	$data['action'] = 'authenticate';
	$data['format'] = 'php';
	$data['username'] = $user;
	$data['password'] = $pass;
	$output = unserialize(contentomatic_curl_post($feed_url, $data, $info));
	if($output['success']=='true' && isset($output['session']))
    {
		$session = $output['session'];
		$data = array();
		$data['session'] = $session;
		$data['format'] = 'php';
		$data['action'] = 'buildArticle';
		$data['category'] = $category;
		if($query_string != '')
        {
            $query_string = str_replace(',', '\n', $query_string);
            $data['subtopics'] = $query_string;
        }
		$data['wordcount'] = $word_count;
        if($enable_lsi == '1')
        {
            $data['lsireplacement'] = '1';
        }
        if($spin_content == '1')
        {
            $data['spin'] = '1';
        }
        if($spin_phrases == '1')
        {
            $data['phrasesonly'] = '1';
        }
        if($enable_superspun == '1' || $enable_superspun == '2')
        {
            $data['superspun'] = $enable_superspun;
        }
        if($kw_replace != '')
        {
            $data['customkeyslist'] = $kw_replace;
            $data['customkeys'] = '1';
        }
		$posts = array();
		for ($i = 0; $i < $num; $i++) 
        {
			$output = contentomatic_curl_post($feed_url, $data, $info);
			$output = unserialize($output);
			if($output['success']=='true')
            {
                if($spin_content == '1')
                {
                    $spintax = new Contentomatic_Spintax();
                    $output['output'] = $spintax->process($output['output']);
                }
                $arts = preg_split('/\r\n|\r|\n/', $output['output'], 2);
                if(isset($arts[1]))
                {
                    $post = str_replace("\r", "<br>", str_replace("\n\n", "<p>", $arts[1]));
                    $title = $arts[0];
                    $comments = array();
                    if($contentomatic_comments != '' && $contentomatic_comments > 0) 
                    {
                        for ($x = 0; $x < $contentomatic_comments; $x++) 
                        {
                            $xdata = array();
                            $xdata['session'] = $session;
                            $xdata['format'] = 'php';
                            $xdata['action'] = 'getTip';
                            $xdata['category'] = $category;
                            if($query_string != '')
                            {
                                $query_string = str_replace('\n', ' ', $query_string);
                                $xdata['keywords'] = $query_string;	
                            }
                            if($enable_superspun == '1' || $enable_superspun == '2')
                            {
                                $xdata['superspun'] = $enable_superspun;
                            }
                            if($spin_content == '1')
                            {
                                $xdata['spin'] = '1';
                            }
                            if($spin_phrases == '1')
                            {
                                $xdata['phrasesonly'] = '1';
                            }
                            $coutput = contentomatic_curl_post($feed_url, $xdata, $info);
                            $coutput = unserialize($coutput);
                            if($coutput['success']=='true' && isset($coutput['output']))
                            {
                                $tip = $coutput['output'];
                                $comments[$x]["author"] = contentomatic_randomName();
                                $comments[$x]["content"] = $tip;					
                            }
                        }		
                    }
                    $posts[$i]["title"] = $title;
                    $posts[$i]["content"] = $post;	
                    $posts[$i]["comments"] = $comments;
                    $posts[$i]["author"] = contentomatic_randomName();
                    $posts[$i]["date"] = contentomatic_randomDate();
                }
                else
                {
                    contentomatic_log_to_file('Unknown response from API, got: ' . print_r($output, true) . ' -- data: ' . print_r($data, true));
                }
			} else {
				contentomatic_log_to_file('Failed to get response from the ArticleBuilder API, got: ' . print_r($output, true) . ' -- data: ' . print_r($data, true));
				return false;	
			}
		}
		if(empty($posts)) {
			contentomatic_log_to_file('No content returned by the ArticleBuilder API, got: ' . print_r($output, true) . ' -- data: ' . print_r($data, true));
            return false;			
		} else {
			return $posts;	
		}			
	} else {
		contentomatic_log_to_file('Failed to log you in to ArticleBuilder API: ' . print_r($output, true) . ' -- data: ' . print_r($data, true));
		return false;	
	}	
}
function contentomatic_randomName() {
    $firstname = array(
        'Johnathon',
        'Anthony',
        'Erasmo',
        'Raleigh',
        'Nancie',
        'Tama',
        'Camellia',
        'Augustine',
        'Christeen',
        'Luz',
        'Diego',
        'Lyndia',
        'Thomas',
        'Georgianna',
        'Leigha',
        'Alejandro',
        'Marquis',
        'Joan',
        'Stephania',
        'Elroy',
        'Zonia',
        'Buffy',
        'Sharie',
        'Blythe',
        'Gaylene',
        'Elida',
        'Randy',
        'Margarete',
        'Margarett',
        'Dion',
        'Tomi',
        'Arden',
        'Clora',
        'Laine',
        'Becki',
        'Margherita',
        'Bong',
        'Jeanice',
        'Qiana',
        'Lawanda',
        'Rebecka',
        'Maribel',
        'Tami',
        'Yuri',
        'Michele',
        'Rubi',
        'Larisa',
        'Lloyd',
        'Tyisha',
        'Samatha',
    );

    $lastname = array(
        'Mischke',
        'Serna',
        'Pingree',
        'Mcnaught',
        'Pepper',
        'Schildgen',
        'Mongold',
        'Wrona',
        'Geddes',
        'Lanz',
        'Fetzer',
        'Schroeder',
        'Block',
        'Mayoral',
        'Fleishman',
        'Roberie',
        'Latson',
        'Lupo',
        'Motsinger',
        'Drews',
        'Coby',
        'Redner',
        'Culton',
        'Howe',
        'Stoval',
        'Michaud',
        'Mote',
        'Menjivar',
        'Wiers',
        'Paris',
        'Grisby',
        'Noren',
        'Damron',
        'Kazmierczak',
        'Haslett',
        'Guillemette',
        'Buresh',
        'Center',
        'Kucera',
        'Catt',
        'Badon',
        'Grumbles',
        'Antes',
        'Byron',
        'Volkman',
        'Klemp',
        'Pekar',
        'Pecora',
        'Schewe',
        'Ramage',
    );

    $name = $firstname[rand ( 0 , count($firstname) -1)];
    $name .= ' ';
    $name .= $lastname[rand ( 0 , count($lastname) -1)];
    return $name;
}
function contentomatic_randomDate()
{
    $my_time = time();
    $start_date = $my_time - rand(0, 40000000);
    $val = rand($start_date, $my_time);
    return date('Y-m-d H:i:s', $val);
}
function contentomatic_run_rule($param, $type, $auto = 1, $ret_content = 0)
{
    do_action( 'wpml_multilingual_options', 'contentomatic_Main_Settings' );
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if($ret_content == 0)
    {
        $f = fopen(get_temp_dir() . 'contentomatic_' . $type . '_' . $param, 'w');
        if($f !== false)
        {
            $flock_disabled = explode(',', ini_get('disable_functions'));
            if(!in_array('flock', $flock_disabled))
            {
                if (!flock($f, LOCK_EX | LOCK_NB)) {
                    return 'nochange';
                }
            }
        }

        
        $GLOBALS['wp_object_cache']->delete('contentomatic_running_list', 'options');
        if (!get_option('contentomatic_running_list')) {
            $running = array();
        } else {
            $running = get_option('contentomatic_running_list');
        }
        if (!empty($running)) {
            if (in_array(array(
                $param => $type
            ), $running))
            {
                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                    contentomatic_log_to_file('Only one instance of this rule is allowed. Rule is already running!');
                }
                return 'nochange';
            }
        }
        $running[] = array(
            $param => $type
        );
        update_option('contentomatic_running_list', $running, false);
        register_shutdown_function('contentomatic_clear_flag_at_shutdown', $param, $type);
        if (isset($contentomatic_Main_Settings['rule_timeout']) && $contentomatic_Main_Settings['rule_timeout'] != '') {
            $timeout = intval($contentomatic_Main_Settings['rule_timeout']);
        } else {
            $timeout = 3600;
        }
        ini_set('safe_mode', 'Off');
        ini_set('max_execution_time', $timeout);
        ini_set('ignore_user_abort', 1);
        ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
        ignore_user_abort(true);
        set_time_limit($timeout);
    }
    $posts_inserted         = 0;
    if (isset($contentomatic_Main_Settings['contentomatic_enabled']) && $contentomatic_Main_Settings['contentomatic_enabled'] == 'on') {
        try {
            if (!isset($contentomatic_Main_Settings['app_id']) || trim($contentomatic_Main_Settings['app_id']) == '') {
                contentomatic_log_to_file('You need to insert a valid ArticleBuilder User Name for this to work!');
                if($auto == 1)
                {
                    contentomatic_clearFromList($param);
                }
                return 'fail';
            }
            if (!isset($contentomatic_Main_Settings['app_pass']) || trim($contentomatic_Main_Settings['app_pass']) == '') {
                contentomatic_log_to_file('You need to insert a valid ArticleBuilder User Password for this to work!');
                if($auto == 1)
                {
                    contentomatic_clearFromList($param);
                }
                return 'fail';
            }
            $items            = array();
            $item_img         = '';
            $cont             = 0;
            $found            = 0;
            $schedule         = '';
            $enable_comments  = '1';
            $enable_pingback  = '1';
            $active           = '0';
            $last_run         = '';
            $ruleType         = 'week';
            $first            = false;
            $others           = array();
            $post_title       = '';
            $post_content     = '';
            $list_item        = '';
            $default_category = '';
            $extra_categories = '';
            $post_status     = 'publish';
            $post_type       = 'post';
            $accept_comments = 'closed';
            $post_user_name  = 1;
            $can_create_cat  = 'off';
            $item_create_tag = '';
            $can_create_tag  = 'disabled';
            $item_tags       = '';
            $date            = 'any';
            $auto_categories = 'disabled';
            $get_img         = '';
            $img_found       = false;
            $image_url       = '';
            $limit_title_word_count = '';
            $post_format     = 'post-format-standard';
            $post_array      = array();
            $max             = 50;
            $lon             = '';
            $lat             = '';
            $img_path        = '';
            $center          = 'any';
            $sol              = '';
            $query_string     = '';
            $query_string_title = '';
            $camera           = 'any';
            $disable_excerpt  = '0';
            $custom_fields    = '';
            $custom_tax       = '';
            $remove_default   = '0';
            $articles_from    = '';
            $articles_to      = '';
            $sort_results     = 'publishedAt';
            $skip_posts       = '';
            $rule_translate   = '';
            $only_domains     = '';
            $min_word         = '';
            $max_word         = '';
            $rule_description = '';
            $remove_domains   = '';
            $strip_by_regex   = '';
            $replace_regex    = '';
            $enable_lsi       = '';
            $kw_replace       = '';
            $enable_superspun = '';
            $spin_content     = '';
            $spin_phrases     = '';
            $contentomatic_comments = '';
            $skip_spin_translate = '';
            $rule_translate_source = 'disabled';
            $royalty_free     = '';
            if($type == 0)
            {
                $GLOBALS['wp_object_cache']->delete('contentomatic_rules_list', 'options');
                if (!get_option('contentomatic_rules_list')) {
                    $rules = array();
                } else {
                    $rules = get_option('contentomatic_rules_list');
                }
                if (!empty($rules)) {
                    foreach ($rules as $request => $bundle[]) {
                        if ($cont == $param) {
                            $bundle_values    = array_values($bundle);
                            $myValues         = $bundle_values[$cont];
                            $array_my_values  = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
                            $limit_title_word_count = isset($array_my_values[0]) ? $array_my_values[0] : '';
                            $schedule         = isset($array_my_values[1]) ? $array_my_values[1] : '';
                            $active           = isset($array_my_values[2]) ? $array_my_values[2] : '';
                            $last_run         = isset($array_my_values[3]) ? $array_my_values[3] : '';
                            $post_status      = isset($array_my_values[4]) ? $array_my_values[4] : '';
                            $post_type        = isset($array_my_values[5]) ? $array_my_values[5] : '';
                            $post_user_name   = isset($array_my_values[6]) ? $array_my_values[6] : '';
                            $item_create_tag  = isset($array_my_values[7]) ? $array_my_values[7] : '';
                            $default_category = isset($array_my_values[8]) ? $array_my_values[8] : '';
                            $auto_categories  = isset($array_my_values[9]) ? $array_my_values[9] : '';
                            $can_create_tag   = isset($array_my_values[10]) ? $array_my_values[10] : '';
                            $enable_comments  = isset($array_my_values[11]) ? $array_my_values[11] : '';
                            $royalty_free     = isset($array_my_values[12]) ? $array_my_values[12] : '';
                            $image_url        = isset($array_my_values[13]) ? $array_my_values[13] : '';
                            $post_title       = isset($array_my_values[14]) ? htmlspecialchars_decode($array_my_values[14]) : '';
                            $post_content     = isset($array_my_values[15]) ? htmlspecialchars_decode($array_my_values[15]) : '';
                            $enable_pingback  = isset($array_my_values[16]) ? $array_my_values[16] : '';
                            $post_format      = isset($array_my_values[17]) ? $array_my_values[17] : '';
                            $date             = isset($array_my_values[18]) ? $array_my_values[18] : '';
                            $query_string     = isset($array_my_values[19]) ? $array_my_values[19] : '';
                            $max              = isset($array_my_values[20]) ? $array_my_values[20] : '';
                            $disable_excerpt  = isset($array_my_values[21]) ? $array_my_values[31] : '';
                            $remove_default   = isset($array_my_values[22]) ? $array_my_values[22] : '';
                            $skip_spin_translate= isset($array_my_values[23]) ? $array_my_values[23] : '';
                            $rule_translate   = isset($array_my_values[24]) ? $array_my_values[24] : '';
                            $rule_translate_source= isset($array_my_values[25]) ? $array_my_values[25] : '';
                            $custom_fields    = isset($array_my_values[26]) ? $array_my_values[26] : '';
                            $custom_tax       = isset($array_my_values[27]) ? $array_my_values[27] : '';
                            $rule_description = isset($array_my_values[28]) ? $array_my_values[28] : '';
                            $strip_by_regex   = isset($array_my_values[29]) ? $array_my_values[29] : '';
                            $replace_regex    = isset($array_my_values[30]) ? $array_my_values[30] : '';
                            $min_word         = isset($array_my_values[31]) ? $array_my_values[31] : '';
                            $max_word         = isset($array_my_values[32]) ? $array_my_values[32] : '';
                            $enable_lsi       = isset($array_my_values[33]) ? $array_my_values[33] : '';
                            $enable_superspun = isset($array_my_values[34]) ? $array_my_values[34] : '';
                            $kw_replace       = isset($array_my_values[35]) ? $array_my_values[35] : '';
                            $spin_content     = isset($array_my_values[36]) ? $array_my_values[36] : '';
                            $spin_phrases     = isset($array_my_values[37]) ? $array_my_values[37] : '';
                            $contentomatic_comments = isset($array_my_values[38]) ? $array_my_values[38] : '';
                            $found            = 1;
                            break;
                        }
                        $cont = $cont + 1;
                    }
                } else {
                    contentomatic_log_to_file('No rules found for contentomatic_rules_list!');
                    if($auto == 1)
                    {
                        contentomatic_clearFromList($param, $type);
                    }
                    return 'fail';
                }
                if ($found == 0) {
                    contentomatic_log_to_file($param . ' not found in contentomatic_rules_list!');
                    if($auto == 1)
                    {
                        contentomatic_clearFromList($param, $type);
                    }
                    return 'fail';
                } else {
                    if($ret_content == 0)
                    {
                        $GLOBALS['wp_object_cache']->delete('contentomatic_rules_list', 'options');
                        $rules = get_option('contentomatic_rules_list');
                        $rules[$param][3] = contentomatic_get_date_now();
                        update_option('contentomatic_rules_list', $rules, false);
                    }
                }
            }
            else
            {
                contentomatic_log_to_file('Invalid rule type provided: ' . $type);
                if($auto == 1)
                {
                    contentomatic_clearFromList($param, $type);
                }
                return 'fail';
            }
            
            if ($enable_comments == '1') {
                $accept_comments = 'open';
            }
            if($type == 0)
            {
                $required_added = false;
                if($max_word == '')
                {
                    $max_word = 1000;
                }
                else
                {
                    $max_word = intval($max_word);
                }
                if($min_word == '')
                {
                    $min_word = 1000;
                }
                else
                {
                    $min_word = intval($min_word);
                }
                $word_count = rand($min_word, $max_word);
                $word_count = round($word_count / 100) * 100;
                $items = contentomatic_articlebuilder(trim($contentomatic_Main_Settings['app_id']), trim($contentomatic_Main_Settings['app_pass']), $date, $max, $query_string, $word_count, $enable_lsi, $enable_superspun, $kw_replace, $spin_content, $spin_phrases, $contentomatic_comments);
                if($items == false)
                {
                    contentomatic_log_to_file('Failed to get ArticleBuilder response from API.');
                    if($auto == 1)
                    {
                        contentomatic_clearFromList($param, $type);
                    }
                    return 'fail';
                }
            }
            if (count($items) == 0) {
                contentomatic_log_to_file('No posts inserted because no posts found.');
                if($auto == 1)
                {
                    contentomatic_clearFromList($param, $type);
                }
                return 'nochange';
            }
            
            $count = 1;
            $skip_pcount = 0;
            $skipped_pcount = 0;
            if($ret_content == 1)
            {
                $item_xcounter = count($items);
                $skip_pcount = rand(0, $item_xcounter-1);
            }
            foreach ($items as $item) {
                if($ret_content == 1)
                {
                    if($skip_pcount > $skipped_pcount)
                    {
                        $skipped_pcount++;
                        continue;
                    }
                }
                $get_img = '';
                $item_words = '';
                $img_found = false;
                if ($count > intval($max)) {
                    break;
                }
                if(isset($contentomatic_Main_Settings['attr_text']) && $contentomatic_Main_Settings['attr_text'] != '')
                {
                    $img_attr = $contentomatic_Main_Settings['attr_text'];
                }
                else
                {
                    $img_attr = '';
                }
                $query_words = '';
                if($type == 0)
                {
                    $title = $item['title'];
                    if($royalty_free == '1')
                    {
                        $keyword_class = new Contentomatic_keywords();
                        $query_words = $keyword_class->keywords($title, 2);
                        $get_img = contentomatic_get_free_image($contentomatic_Main_Settings, $query_words, $img_attr, 10);
                        if($get_img == '' || $get_img === false)
                        {
                            if(isset($contentomatic_Main_Settings['bimage']) && $contentomatic_Main_Settings['bimage'] == 'on')
                            {
                                $query_words = $keyword_class->keywords($title, 1);
                                $get_img = contentomatic_get_free_image($contentomatic_Main_Settings, $query_words, $img_attr, 20);
                                if($get_img === false)
                                {
                                    $get_img = '';
                                }
                            }
                            else
                            {
                                $get_img = '';
                            }
                        }
                    }
                    $content = $item['content'];
                    $orig_content = $content;
                    $description = wp_trim_words($content, 55, '');;
                    $author = $item['author'];
                    if (trim($content) == '') {
                        $content = $title;
                        if (trim($content) == '') {
                            continue;
                        }
                    }
                    $date = $item['date'];
                }
                $my_post                              = array();
                $postdate = strtotime($date);
                if($postdate !== FALSE)
                {
                    $postdate = gmdate("Y-m-d H:i:s", intval($postdate));
                }
                $my_post['post_date_gmt'] = $postdate;
                if(substr($get_img, 0, 2) === "//")
                {
                    $get_img = 'http:' . $get_img;
                }
                $my_post['contentomatic_post_image']  = $get_img;
                $my_post['comments']  = $item['comments'];
                $my_post['default_category']          = $default_category;
                $my_post['post_type']                 = $post_type;
                $my_post['comment_status']            = $accept_comments;
                $my_post['post_status']               = $post_status;
                if($post_user_name == 'rand')
                {
                    $randid = contentomatic_display_random_user();
                    if($randid === false)
                    {
                        $my_post['post_author']               = '1';
                    }
                    else
                    {
                        $my_post['post_author']               = $randid->ID;
                    }
                }
                else
                {
                    $my_post['post_author']               = contentomatic_utf8_encode($post_user_name);
                }
                $my_post['contentomatic_post_date']        = $date;
                if (strpos($post_content, '%%') !== false) {
                    $new_post_content = contentomatic_replaceContentShortcodes($post_content, $title, $content, $description, $author, $date, $orig_content, $img_attr, $get_img);
                } else {
                    $new_post_content = $post_content;
                }
                if (strpos($post_title, '%%') !== false) {
                    $new_post_title = contentomatic_replaceTitleShortcodes($post_title, $title, $content, $date, $author);
                } else {
                    $new_post_title = $post_title;
                }
                $my_post['description']      = $description;
                $my_post['author']           = $author;
                $keyword_class = new Contentomatic_keywords();
                $title_words = $keyword_class->keywords($title, 2);
                $title_words = str_replace(' ', ',', $title_words);
                if($skip_spin_translate != '1')
                {
                    $arr                         = contentomatic_spin_and_translate($new_post_title, $new_post_content, $rule_translate, $rule_translate_source);
                    if($arr === false)
                    {
                        continue;
                    }
                    $new_post_title              = $arr[0];
                    $new_post_content            = $arr[1];
                    $new_post_content = str_replace('%% item_show_image %%', '%%item_show_image%%', $new_post_content);
                }
                if ($auto_categories == 'title') 
                {
                    if(isset($contentomatic_Main_Settings['new_category']) && $contentomatic_Main_Settings['new_category'] == 'on')
                    {
                        $blog_cats = contentomatic_my_list_cats();
                        $blog_cats = array_map('strtolower', $blog_cats);
                        $titler = preg_replace("#[^\sa-zA-Z0-9]+#", "", $new_post_title);
                        $titler = explode(' ', $titler);
                        $title_words = '';
                        foreach($titler as $t)
                        {
                            if(in_array(strtolower($t), $blog_cats))
                            {
                                $title_words .= $t . ',';
                            }
                        }
                        $title_words = trim($title_words, ',');
                        $extra_categories = $title_words;
                    }
                    else
                    {
                        $extra_categories = $title_words;
                    }
                }
                else
                {
                    $extra_categories = '';

                }
                $my_post['extra_categories'] = $extra_categories;

                if ($can_create_tag == 'title') {
                    $item_tags = $title_words;
                    $post_the_tags = ($item_create_tag != '' ? $item_create_tag . ',' : '') . contentomatic_utf8_encode($item_tags);
                }
                else
                {
                    $item_tags = '';
                    $post_the_tags = contentomatic_utf8_encode($item_create_tag);
                }
                $my_post['extra_tags'] = $item_tags;
                $my_post['tags_input'] = $post_the_tags;
                $new_post_title   = contentomatic_replaceTitleShortcodesAgain($new_post_title, $extra_categories, $post_the_tags);
                $new_post_content = contentomatic_replaceContentShortcodesAgain($new_post_content, $extra_categories, $post_the_tags);
                $title_count = -1;
                if (isset($contentomatic_Main_Settings['min_word_title']) && $contentomatic_Main_Settings['min_word_title'] != '') {
                    $title_count = str_word_count($new_post_title);
                    if ($title_count < intval($contentomatic_Main_Settings['min_word_title'])) {
                        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                            contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because title lenght < ' . $contentomatic_Main_Settings['min_word_title']);
                        }
                        continue;
                    }
                }
                if (isset($contentomatic_Main_Settings['max_word_title']) && $contentomatic_Main_Settings['max_word_title'] != '') {
                    if ($title_count == -1) {
                        $title_count = str_word_count($new_post_title);
                    }
                    if ($title_count > intval($contentomatic_Main_Settings['max_word_title'])) {
                        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                            contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because title lenght > ' . $contentomatic_Main_Settings['max_word_title']);
                        }
                        continue;
                    }
                }
                $content_count = -1;
                if (isset($contentomatic_Main_Settings['min_word_content']) && $contentomatic_Main_Settings['min_word_content'] != '') {
                    $content_count = str_word_count(contentomatic_strip_html_tags($new_post_content));
                    if ($content_count < intval($contentomatic_Main_Settings['min_word_content'])) {
                        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                            contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because content lenght < ' . $contentomatic_Main_Settings['min_word_content']);
                        }
                        continue;
                    }
                }
                if (isset($contentomatic_Main_Settings['max_word_content']) && $contentomatic_Main_Settings['max_word_content'] != '') {
                    if ($content_count == -1) {
                        $content_count = str_word_count(contentomatic_strip_html_tags($new_post_content));
                    }
                    if ($content_count > intval($contentomatic_Main_Settings['max_word_content'])) {
                        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                            contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because content lenght > ' . $contentomatic_Main_Settings['max_word_content']);
                        }
                        continue;
                    }
                }
                if (isset($contentomatic_Main_Settings['banned_words']) && $contentomatic_Main_Settings['banned_words'] != '') {
                    $continue    = false;
                    $banned_list = explode(',', $contentomatic_Main_Settings['banned_words']);
                    foreach ($banned_list as $banned_word) {
                        if (stripos($new_post_content, trim($banned_word)) !== FALSE) {
                            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                                contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s content contains banned word: ' . $banned_word);
                            }
                            $continue = true;
                            break;
                        }
                        if (stripos($new_post_title, trim($banned_word)) !== FALSE) {
                            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                                contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s title contains banned word: ' . $banned_word);
                            }
                            $continue = true;
                            break;
                        }
                    }
                    if ($continue === true) {
                        continue;
                    }
                }
                if (isset($contentomatic_Main_Settings['required_words']) && $contentomatic_Main_Settings['required_words'] != '') {
                    if (isset($contentomatic_Main_Settings['require_all']) && $contentomatic_Main_Settings['require_all'] == 'on') {
                        $require_all = true;
                    }
                    else
                    {
                        $require_all = false;
                    }
                    
                    $required_list = explode(',', $contentomatic_Main_Settings['required_words']);
                    if($require_all === true)
                    {
                        $continue      = false;
                        foreach ($required_list as $required_word) {
                            if (stripos($new_post_content, trim($required_word)) === FALSE) {
                                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                                    contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s content doesn\'t contain required word: ' . $required_word);
                                }
                                $continue = true;
                                break;
                            }
                            if (stripos($new_post_title, trim($required_word)) === FALSE) {
                                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                                    contentomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s title doesn\'t contain required word: ' . $required_word);
                                }
                                $continue = true;
                                break;
                            }
                        }
                    }
                    else
                    {
                        $continue      = true;
                        foreach ($required_list as $required_word) {
                            if (stripos($new_post_content, trim($required_word)) !== FALSE) {
                                $continue = false;
                                break;
                            }
                            if (stripos($new_post_title, trim($required_word)) !== FALSE) {
                                $continue = false;
                                break;
                            }
                        }
                    }
                    if ($continue === true) {
                        continue;
                    }
                }
                if (isset($contentomatic_Main_Settings['no_link_translate']) && $contentomatic_Main_Settings['no_link_translate'] == 'on')
                {
                    $new_post_content = preg_replace('{"https:\/\/translate.google.com\/translate\?hl=(?:.*?)&prev=_t&sl=(?:.*?)&tl=(?:.*?)&u=([^"]*?)"}i', "$1", urldecode(html_entity_decode($new_post_content)));
                }
                else
                {
                    $new_post_content        = html_entity_decode($new_post_content);
                }
                
                if ($disable_excerpt == '1') 
                {
                    $my_post['post_excerpt'] = '';
                }
                else
                {
                    if (isset($contentomatic_Main_Settings['translate']) && $contentomatic_Main_Settings['translate'] != "disabled" && $contentomatic_Main_Settings['translate'] != "en") {
                        $my_post['post_excerpt'] = contentomatic_utf8_encode(contentomatic_getExcerpt($new_post_content));
                    } else {
                        $my_post['post_excerpt'] = contentomatic_utf8_encode(contentomatic_getExcerpt($content));
                    }
                }
                
                $new_post_title = contentomatic_utf8_encode($new_post_title);
                if($limit_title_word_count != '' && is_numeric($limit_title_word_count))
                {
                    $new_post_title = wp_trim_words($new_post_title, intval($limit_title_word_count), '');
                }
                if ($strip_by_regex !== '')
                {
                    $temp_cont = preg_replace("~" . $strip_by_regex . "~i", $replace_regex, $new_post_content);
                    if($temp_cont !== NULL)
                    {
                        $new_post_content = $temp_cont;
                    }
                }
                $new_post_content = str_replace('</ iframe>', '</iframe>', $new_post_content);
                if($ret_content == 1)
                {
                    return $new_post_content;
                }
                $my_post['post_content'] = contentomatic_utf8_encode($new_post_content);
                $my_post['post_title']           = $new_post_title;
                $my_post['original_title']       = $title;
                $my_post['original_content']     = $content;
                $my_post['contentomatic_timestamp']   = contentomatic_get_date_now();
                $my_post['contentomatic_post_format'] = $post_format;
                if (isset($default_category) && $default_category !== 'contentomatic_no_category_12345678' && $default_category[0] !== 'contentomatic_no_category_12345678') {
                    if(is_array($default_category))
                    {
                        $extra_categories_temp = '';
                        foreach($default_category as $dc)
                        {
                            $extra_categories_temp .= get_cat_name($dc) . ',';
                        }
                        $extra_categories_temp .= $extra_categories;
                        $extra_categories_temp = trim($extra_categories_temp, ',');
                    }
                    else
                    {
                        $extra_categories_temp = trim(get_cat_name($default_category) . ',' .$extra_categories, ',');
                    }
                }
                else
                {
                    $extra_categories_temp = $extra_categories;
                }
                $custom_arr = array();
                if($custom_fields != '')
                {
                    if(stristr($custom_fields, '=>') != false)
                    {
                        $rule_arr = explode(',', trim($custom_fields));
                        foreach($rule_arr as $rule)
                        {
                            $my_args = explode('=>', trim($rule));
                            if(isset($my_args[1]))
                            {
                                $custom_field_content = trim($my_args[1]);
                                $custom_field_content = contentomatic_replaceContentShortcodes($custom_field_content, $title, $content, $description, $author, $date, $orig_content, $img_attr, $get_img);
                                $custom_field_content = contentomatic_replaceContentShortcodesAgain($custom_field_content, $extra_categories, $post_the_tags);
                                $custom_arr[trim($my_args[0])] = $custom_field_content;
                            }
                        }
                    }
                }
                $custom_arr = array_merge($custom_arr, array('contentomatic_featured_image' => $get_img, 'contentomatic_post_cats' => $extra_categories_temp, 'contentomatic_post_tags' => $post_the_tags));
                $my_post['meta_input'] = $custom_arr;
                $custom_tax_arr = array();
                if($custom_tax != '')
                {
                    if(stristr($custom_tax, '=>') != false)
                    {
                        $rule_arr = explode(';', trim($custom_tax));
                        foreach($rule_arr as $rule)
                        {
                            $my_args = explode('=>', trim($rule));
                            if(isset($my_args[1]))
                            {
                                $custom_tax_content = trim($my_args[1]);
                                $custom_tax_content = contentomatic_replaceContentShortcodes($custom_tax_content, $title, $content, $description, $author, $date, $orig_content, $img_attr, $get_img);
                                $custom_tax_content = contentomatic_replaceContentShortcodesAgain($custom_tax_content, $extra_categories, $post_the_tags);
                                $custom_tax_arr[trim($my_args[0])] = $custom_tax_content;
                            }
                        }
                    }
                }
                if(count($custom_tax_arr) > 0)
                {
                    $my_post['taxo_input'] = $custom_tax_arr;
                }
                if ($enable_pingback == '1') {
                    $my_post['ping_status'] = 'open';
                } else {
                    $my_post['ping_status'] = 'closed';
                }
                remove_filter('content_save_pre', 'wp_filter_post_kses');
                remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                $post_id = wp_insert_post($my_post, true);
                add_filter('content_save_pre', 'wp_filter_post_kses');
                add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                if (!is_wp_error($post_id)) 
                {
                    $posts_inserted++;
                    if(isset($my_post['taxo_input']))
                    {
                        foreach($my_post['taxo_input'] as $taxn => $taxval)
                        {
                            $taxn = trim($taxn);
                            $taxval = trim($taxval);
                            if(is_taxonomy_hierarchical($taxn))
                            {
                                $taxval = array_map('trim', explode(',', $taxval));
                                for($ii = 0; $ii < count($taxval); $ii++)
                                {
                                    if(!is_numeric($taxval[$ii]))
                                    {
                                        $xtermid = get_term_by('name', $taxval[$ii], $taxn);
                                        if($xtermid !== false)
                                        {
                                            $taxval[$ii] = intval($xtermid->term_id);
                                        }
                                        else
                                        {
                                            wp_insert_term( $taxval[$ii], $taxn);
                                            $xtermid = get_term_by('name', $taxval[$ii], $taxn);
                                            if($xtermid !== false)
                                            {
                                                $taxval[$ii] = intval($xtermid->term_id);
                                            }
                                        }
                                    }
                                }
                                wp_set_post_terms($post_id, $taxval, $taxn);
                            }
                            else
                            {
                                wp_set_post_terms($post_id, trim($taxval), $taxn);
                            }
                        }
                    }
                    if (isset($my_post['contentomatic_post_format']) && $my_post['contentomatic_post_format'] != '' && $my_post['contentomatic_post_format'] != 'post-format-standard') {
                        wp_set_post_terms($post_id, $my_post['contentomatic_post_format'], 'post_format');
                    }
                    $featured_path = '';
                    $image_failed  = false;
                    if ($royalty_free == '1') {
                        $get_img = $my_post['contentomatic_post_image'];
                        if ($get_img != '') {
                            if (!contentomatic_generate_featured_image($get_img, $post_id)) {
                                $image_failed = true;
                                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                                    contentomatic_log_to_file('contentomatic_generate_featured_image failed for ' . $get_img . '!');
                                }
                            } else {
                                $featured_path = $get_img;
                            }
                        } else {
                            $image_failed = true;
                        }
                    }
                    if ($image_failed || $royalty_free !== '1') {
                        if ($image_url != '') {
                            $image_urlx = array($image_url);
                            $image_urlx = trim($image_urlx[array_rand($image_urlx)]);
                            $retim = false;
                            if(is_numeric($image_urlx) && $image_urlx > 0)
                            {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                require_once(ABSPATH . 'wp-admin/includes/media.php');
                                $res2 = set_post_thumbnail($post_id, $image_urlx);
                                if ($res2 === FALSE) {
                                }
                                else
                                {
                                    $retim = true;
                                }
                            }
                            if($retim == false)
                            {
                                stream_context_set_default( [
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                    ],
                                ]);
                                $url_headers = get_headers($image_urlx, 1);
                                if (isset($url_headers['Content-Type'])) {
                                    if (is_array($url_headers['Content-Type'])) {
                                        $img_type = strtolower($url_headers['Content-Type'][0]);
                                    } else {
                                        $img_type = strtolower($url_headers['Content-Type']);
                                    }
                                    
                                    if (strstr($img_type, 'image/') !== false) {
                                        if (!contentomatic_generate_featured_image($image_urlx, $post_id)) {
                                            $image_failed = true;
                                            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                                                contentomatic_log_to_file('contentomatic_generate_featured_image failed to deafault value: ' . $image_urlx . '!');
                                            }
                                        } else {
                                            $featured_path = $image_urlx;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($remove_default == '1' && ($auto_categories !== 'disabled' || (isset($default_category) && $default_category !== 'contentomatic_no_category_12345678' && $default_category[0] !== 'contentomatic_no_category_12345678')))
                    {
                        $default_categories = wp_get_post_categories($post_id);
                    }
                    if ($auto_categories != 'disabled') {
                        if ($my_post['extra_categories'] != '') {
                            $extra_cats = explode(',', $my_post['extra_categories']);
                            foreach($extra_cats as $extra_cat)
                            {
                                $termid = contentomatic_create_terms('category', '0', trim($extra_cat));
                                wp_set_post_terms($post_id, $termid, 'category', true);
                            }
                        }
                    }
                    if (isset($default_category) && $default_category !== 'contentomatic_no_category_12345678' && $default_category[0] !== 'contentomatic_no_category_12345678') {
                        $cats   = array();
                        if(is_array($default_category))
                        {
                            foreach($default_category as $dc)
                            {
                                $cats[] = $dc;
                            }
                        }
                        else
                        {
                            $cats[] = $default_category;
                        }
                        wp_set_post_categories($post_id, $cats, true);
                    }
                    if($remove_default == '1' && ($auto_categories !== 'disabled' || (isset($default_category) && $default_category !== 'contentomatic_no_category_12345678' && $default_category[0] !== 'contentomatic_no_category_12345678')))
                    {
                        $new_categories = wp_get_post_categories($post_id);
                        if(isset($default_categories) && !($default_categories == $new_categories))
                        {
                            foreach($default_categories as $dc)
                            {
                                $rem_cat = get_category( $dc );
                                wp_remove_object_terms( $post_id, $rem_cat->slug, 'category' );
                            }
                        }
                    }
                    $tax_rez = wp_set_object_terms( $post_id, 'Contentomatic_' . $type . '_' . $param, 'coderevolution_post_source');
                    if (is_wp_error($tax_rez)) {
                        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                            contentomatic_log_to_file('wp_set_object_terms failed for: ' . $post_id . '!');
                        }
                    }
                    contentomatic_addPostMeta($post_id, $my_post, $param, $type, $featured_path);
                    if (isset($my_post['comments']) && count($my_post['comments']) > 0) 
                    {
                        foreach($my_post['comments'] as $comment)
                        {
                            $comm       = $comment['content'];
                            $author     = $comment['author'];
                            $date       = date('Y-m-d H:i:s', time());
                            $data = array(
                                'comment_post_ID' => $post_id,
                                'comment_author' => $author,
                                'comment_author_email' => '',
                                'comment_author_url' => '',
                                'comment_content' => $comm,
                                'comment_type' => '',
                                'comment_parent' => 0,
                                'user_id' => 1,
                                'comment_author_IP' => '127.0.0.1',
                                'comment_agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36',
                                'comment_date' => $date,
                                'comment_approved' => 1
                            );
                            wp_insert_comment($data);
                        }
                    }
                } else {
                    contentomatic_log_to_file('Failed to insert post into database! Title:' . $my_post['post_title'] . '! Error: ' . $post_id->get_error_message() . 'Error code: ' . $post_id->get_error_code() . 'Error data: ' . $post_id->get_error_data());
                    continue;
                }
                $count++;
            }
        }
        catch (Exception $e) {
            contentomatic_log_to_file('Exception thrown ' . esc_html($e->getMessage()) . '!');
            if($auto == 1)
            {
                contentomatic_clearFromList($param, $type);
            }
            return 'fail';
        }
        
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('Rule ID ' . esc_html($param) . ' succesfully run! ' . esc_html($posts_inserted) . ' posts created!');
        }
        if (isset($contentomatic_Main_Settings['send_email']) && $contentomatic_Main_Settings['send_email'] == 'on' && $contentomatic_Main_Settings['email_address'] !== '') {
            try {
                $to        = $contentomatic_Main_Settings['email_address'];
                $subject   = '[contentomatic] Rule running report - ' . contentomatic_get_date_now();
                $message   = 'Rule ID ' . esc_html($param) . ' succesfully run! ' . esc_html($posts_inserted) . ' posts created!';
                $headers[] = 'From: Contentomatic Plugin <contentomatic@noreply.net>';
                $headers[] = 'Reply-To: noreply@contentomatic.com';
                $headers[] = 'X-Mailer: PHP/' . phpversion();
                $headers[] = 'Content-Type: text/html';
                $headers[] = 'Charset: ' . get_option('blog_charset', 'UTF-8');
                wp_mail($to, $subject, $message, $headers);
            }
            catch (Exception $e) {
                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                    contentomatic_log_to_file('Failed to send mail: Exception thrown ' . esc_html($e->getMessage()) . '!');
                }
            }
        }
    }
    if ($posts_inserted == 0) {
        if($auto == 1)
        {
            contentomatic_clearFromList($param, $type);
        }
        return 'nochange';
    } else {
        if($auto == 1)
        {
            contentomatic_clearFromList($param, $type);
        }
        return 'ok';
    }
}

$contentomatic_fatal = false;
function contentomatic_clear_flag_at_shutdown($param, $type)
{
    $error = error_get_last();
    if ($error['type'] === E_ERROR && $GLOBALS['contentomatic_fatal'] === false) {
        $GLOBALS['contentomatic_fatal'] = true;
        $running = array();
        update_option('contentomatic_running_list', $running);
        contentomatic_log_to_file('[FATAL] Exit error: ' . $error['message'] . ', file: ' . $error['file'] . ', line: ' . $error['line'] . ' - rule ID: ' . $param . '!');
        contentomatic_clearFromList($param, $type);
    }
    else
    {
        contentomatic_clearFromList($param, $type);
    }
}

add_filter('the_title', 'contentomatic_add_affiliate_title_keyword');
function contentomatic_add_affiliate_title_keyword($content)
{
    $rules  = get_option('contentomatic_keyword_list');
    $output = '';
    if (!empty($rules)) {
        foreach ($rules as $request => $value) {
            if(!isset($value[2]) || $value[2] == 'content')
            {
                continue;
            }
            if (is_array($value) && isset($value[1])) {
                $repl = $value[1];
            } else {
                $repl = $request;
            }
            if (isset($value[0]) && $value[0] != '') {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request) . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', '<a href="' . esc_url($value[0]) . '" target="_blank">' . esc_html($repl) . '</a>', $content);
            } else {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request) . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', esc_html($repl), $content);
            }
        }
    }
    return $content;
}
add_filter('the_content', 'contentomatic_add_affiliate_keyword');
add_filter('the_excerpt', 'contentomatic_add_affiliate_keyword');
function contentomatic_add_affiliate_keyword($content)
{
    $rules  = get_option('contentomatic_keyword_list');
    $output = '';
    if (!empty($rules)) {
        foreach ($rules as $request => $value) {
            if(isset($value[2]) && $value[2] == 'title')
            {
                continue;
            }
            if (is_array($value) && isset($value[1]) && $value[1] != '') {
                $repl = $value[1];
            } else {
                $repl = $request;
            }
            if (isset($value[0]) && $value[0] != '') {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request) . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', '<a href="' . esc_url($value[0]) . '" target="_blank">' . esc_html($repl) . '</a>', $content);
            } else {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request) . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', esc_html($repl), $content);
            }
        }
    }
    return $content;
}
function contentomatic_generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function contentomatic_get_free_image($contentomatic_Main_Settings, $query_words, &$img_attr, $res_cnt = 3)
{
    $original_url = '';
    $rand_arr = array();
    if(isset($contentomatic_Main_Settings['pixabay_api']) && $contentomatic_Main_Settings['pixabay_api'] != '')
    {
        $rand_arr[] = 'pixabay';
    }
    if(isset($contentomatic_Main_Settings['morguefile_api']) && $contentomatic_Main_Settings['morguefile_api'] !== '' && isset($contentomatic_Main_Settings['morguefile_secret']) && $contentomatic_Main_Settings['morguefile_secret'] !== '')
    {
        $rand_arr[] = 'morguefile';
    }
    if(isset($contentomatic_Main_Settings['flickr_api']) && $contentomatic_Main_Settings['flickr_api'] !== '')
    {
        $rand_arr[] = 'flickr';
    }
    if(isset($contentomatic_Main_Settings['pexels_api']) && $contentomatic_Main_Settings['pexels_api'] !== '')
    {
        $rand_arr[] = 'pexels';
    }
    if(isset($contentomatic_Main_Settings['pixabay_scrape']) && $contentomatic_Main_Settings['pixabay_scrape'] == 'on')
    {
        $rand_arr[] = 'pixabayscrape';
    }
    $rez = false;
    while(($rez === false || $rez === '') && count($rand_arr) > 0)
    {
        $rand = array_rand($rand_arr);
        if($rand_arr[$rand] == 'pixabay')
        {
            unset($rand_arr[$rand]);
            $rez = contentomatic_get_pixabay_image($contentomatic_Main_Settings['pixabay_api'], $query_words, $contentomatic_Main_Settings['img_language'], $contentomatic_Main_Settings['imgtype'], $contentomatic_Main_Settings['img_orientation'], $contentomatic_Main_Settings['img_order'], $contentomatic_Main_Settings['img_cat'], $contentomatic_Main_Settings['img_mwidth'], $contentomatic_Main_Settings['img_width'], $contentomatic_Main_Settings['img_ss'], $contentomatic_Main_Settings['img_editor'], $original_url, $res_cnt);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Pixabay', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://pixabay.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'morguefile')
        {
            unset($rand_arr[$rand]);
            $rez = contentomatic_get_morguefile_image($contentomatic_Main_Settings['morguefile_api'], $contentomatic_Main_Settings['morguefile_secret'], $query_words, $original_url);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'MorgueFile', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', 'https://morguefile.com/', $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://morguefile.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'flickr')
        {
            unset($rand_arr[$rand]);
            $rez = contentomatic_get_flickr_image($contentomatic_Main_Settings, $query_words, $original_url, $res_cnt);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Flickr', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://www.flickr.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'pexels')
        {
            unset($rand_arr[$rand]);
            $rez = contentomatic_get_pexels_image($contentomatic_Main_Settings, $query_words, $original_url, $res_cnt);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Pexels', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://www.pexels.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'pixabayscrape')
        {
            unset($rand_arr[$rand]);
            $rez = contentomatic_scrape_pixabay_image($contentomatic_Main_Settings, $query_words, $original_url);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Pixabay', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://pixabay.com/', $img_attr);
            }
        }
        else
        {
            contentomatic_log_to_file('Unrecognized free file source: ' . $rand_arr[$rand]);
            unset($rand_arr[$rand]);
        }
    }
    $img_attr = str_replace('%%image_source_name%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_url%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_website%%', '', $img_attr);
    return $rez;
}
function contentomatic_get_pixabay_image($app_id, $query, $lang, $image_type, $orientation, $order, $image_category, $max_width, $min_width, $safe_search, $editors_choice, &$original_url, $get_max = 3)
{
    $original_url = 'https://pixabay.com';
    $featured_image = '';
    $feed_uri = 'https://pixabay.com/api/?key=' . $app_id;
    if($query != '')
    {
        $feed_uri .= '&q=' . urlencode($query);
    }
    $feed_uri .= '&per_page=' . $get_max;
    if($lang != '' && $lang != 'any')
    {
        $feed_uri .= '&lang=' . $lang;
    }
    if($image_type != '')
    {
        $feed_uri .= '&image_type=' . $image_type;
    }
    if($orientation != '')
    {
        $feed_uri .= '&orientation=' . $orientation;
    }
    if($order != '')
    {
        $feed_uri .= '&order=' . $order;
    }
    if($image_category != '')
    {
        $feed_uri .= '&category=' . $image_category;
    }
    if($max_width != '')
    {
        $feed_uri .= '&max_width=' . $max_width;
    }
    if($min_width != '')
    {
        $feed_uri .= '&min_width=' . $min_width;
    }
    if($safe_search == '1')
    {
        $feed_uri .= '&safesearch=true';
    }
    if($editors_choice == '1')
    {
        $feed_uri .= '&editors_choice=true';
    }
    $feed_uri .= '&callback=' . contentomatic_generateRandomString(6);
     
    $exec = contentomatic_get_web_page($feed_uri);
    if ($exec !== FALSE) 
    {
        if (stristr($exec, '"hits"') !== FALSE) 
        {
            $json  = json_decode($exec);
            $items = $json->hits;
            if (count($items) != 0) 
            {
                shuffle($items);
                foreach($items as $item)
                {
                    $featured_image = $item->webformatURL;
                    $original_url = $item->pageURL;
                    break;
                }
            }
        }
        else
        {
            contentomatic_log_to_file('Unknow response from api: ' . $feed_uri . ' - resp: ' . $exec);
        }
    }
    else
    {
        contentomatic_log_to_file('Error while getting api url: ' . $feed_uri);
        return false;
    }
    return $featured_image;
}
function contentomatic_scrape_pixabay_image($contentomatic_Main_Settings, $query, &$original_url)
{
    $original_url = 'https://pixabay.com';
    $featured_image = '';
    $feed_uri = 'https://pixabay.com/en/photos/';
    if($query != '')
    {
        $feed_uri .= '?q=' . urlencode($query);
    }

    if($contentomatic_Main_Settings['scrapeimgtype'] != 'all')
    {
        $feed_uri .= '&image_type=' . $contentomatic_Main_Settings['scrapeimgtype'];
    }
    if($contentomatic_Main_Settings['scrapeimg_orientation'] != '')
    {
        $feed_uri .= '&orientation=' . $contentomatic_Main_Settings['scrapeimg_orientation'];
    }
    if($contentomatic_Main_Settings['scrapeimg_order'] != '' && $contentomatic_Main_Settings['scrapeimg_order'] != 'any')
    {
        $feed_uri .= '&order=' . $contentomatic_Main_Settings['scrapeimg_order'];
    }
    if($contentomatic_Main_Settings['scrapeimg_cat'] != '')
    {
        $feed_uri .= '&category=' . $contentomatic_Main_Settings['scrapeimg_cat'];
    }
    if($contentomatic_Main_Settings['scrapeimg_height'] != '')
    {
        $feed_uri .= '&min_height=' . $contentomatic_Main_Settings['scrapeimg_height'];
    }
    if($contentomatic_Main_Settings['scrapeimg_width'] != '')
    {
        $feed_uri .= '&min_width=' . $contentomatic_Main_Settings['scrapeimg_width'];
    }
    $exec = contentomatic_get_web_page($feed_uri);
    if ($exec !== FALSE) 
    {
        preg_match_all('/<a href="([^"]+?)".+?(?:data-lazy|src)="([^"]+?\.jpg|png)"/i', $exec, $matches);
        if (!empty($matches[2])) {
            $p = array_combine($matches[1], $matches[2]);
            if(count($p) > 0)
            {
                shuffle($p);
                foreach ($p as $key => $val) {
                    $featured_image = $val;
                    if(!is_numeric($key))
                    {
                        if(substr($key, 0, 4) !== "http")
                        {
                            $key = 'https://pixabay.com' . $key;
                        }
                        $original_url = $key;
                    }
                    else
                    {
                        $original_url = 'https://pixabay.com';
                    }
                    break;
                }
            }
        }
    }
    else
    {
        contentomatic_log_to_file('Error while getting api url: ' . $feed_uri);
        return false;
    }
    return $featured_image;
}
function contentomatic_get_morguefile_image($app_id, $app_secret, $query, &$original_url)
{
    $featured_image = '';
    if(!class_exists('contentomatic_morguefile'))
    {
        require_once (dirname(__FILE__) . "/res/morguefile/mf.api.class.php");
    }
    $query = explode(' ', $query);
    $query = $query[0];
    {
        $mf = new contentomatic_morguefile($app_id, $app_secret);
        $rez = $mf->call('/images/search/sort/page/' . $query);
        if ($rez !== FALSE) 
        {
            $chosen_one = $rez->doc[array_rand($rez->doc)];
            if (isset($chosen_one->file_path_large)) 
            {
                return $chosen_one->file_path_large;
            }
            else
            {
                return false;
            }
        }
        else
        {
            contentomatic_log_to_file('Error while getting api response from morguefile.');
            return false;
        }
    }
    return $featured_image;
}
function contentomatic_get_flickr_image($contentomatic_Main_Settings, $query, &$original_url, $max)
{
    $original_url = 'https://www.flickr.com';
    $featured_image = '';
    $feed_uri = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=' . $contentomatic_Main_Settings['flickr_api'] . '&media=photos&per_page=' . esc_html($max) . '&format=php_serial&text=' . urlencode($query);
    if(isset($contentomatic_Main_Settings['flickr_license']) && $contentomatic_Main_Settings['flickr_license'] != '-1')
    {
        $feed_uri .= '&license=' . $contentomatic_Main_Settings['flickr_license'];
    }
    if(isset($contentomatic_Main_Settings['flickr_order']) && $contentomatic_Main_Settings['flickr_order'] != '')
    {
        $feed_uri .= '&sort=' . $contentomatic_Main_Settings['flickr_order'];
    }
    $feed_uri .= '&extras=description,license,date_upload,date_taken,owner_name,icon_server,original_format,last_update,geo,tags,machine_tags,o_dims,views,media,path_alias,url_sq,url_t,url_s,url_q,url_m,url_n,url_z,url_c,url_l,url_o';
     
    {
        $ch               = curl_init();
        if ($ch === FALSE) {
            contentomatic_log_to_file('Failed to init curl for flickr!');
            return false;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Referer: https://www.flickr.com/'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $feed_uri);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $exec = curl_exec($ch);
        curl_close($ch);
        if (stristr($exec, 'photos') === FALSE) {
            contentomatic_log_to_file('Unrecognized Flickr API response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        $items = unserialize ( $exec );
        if(!isset($items['photos']['photo']))
        {
            contentomatic_log_to_file('Failed to find photo node in response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        if(count($items['photos']['photo']) == 0)
        {
            return $featured_image;
        }
        $x = 0;
        shuffle($items['photos']['photo']);
        while($featured_image == '' && isset($items['photos']['photo'][$x]))
        {
            $item = $items['photos']['photo'][$x];
            if(isset($item['url_o']))
            {
                $featured_image = esc_url($item['url_o']);
            }
            elseif(isset($item['url_l']))
            {
                $featured_image = esc_url($item['url_l']);
            }
            elseif(isset($item['url_c']))
            {
                $featured_image = esc_url($item['url_c']);
            }
            elseif(isset($item['url_z']))
            {
                $featured_image = esc_url($item['url_z']);
            }
            elseif(isset($item['url_n']))
            {
                $featured_image = esc_url($item['url_n']);
            }
            elseif(isset($item['url_m']))
            {
                $featured_image = esc_url($item['url_m']);
            }
            elseif(isset($item['url_q']))
            {
                $featured_image = esc_url($item['url_q']);
            }
            elseif(isset($item['url_s']))
            {
                $featured_image = esc_url($item['url_s']);
            }
            elseif(isset($item['url_t']))
            {
                $featured_image = esc_url($item['url_t']);
            }
            elseif(isset($item['url_sq']))
            {
                $featured_image = esc_url($item['url_sq']);
            }
            if($featured_image != '')
            {
                $original_url = esc_url('https://www.flickr.com/photos/' . $item['owner'] . '/' . $item['id']);
            }
            $x++;
        }
    }
    return $featured_image;
}
function contentomatic_get_pexels_image($contentomatic_Main_Settings, $query, &$original_url, $max)
{
    $original_url = 'https://pexels.com';
    $featured_image = '';
    $feed_uri = 'https://api.pexels.com/v1/search?query=' . urlencode($query) . '&per_page=' . $max;
     
    {
        $ch               = curl_init();
        if ($ch === FALSE) {
            contentomatic_log_to_file('Failed to init curl for flickr!');
            return false;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . esc_html($contentomatic_Main_Settings['pexels_api'])));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $feed_uri);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $exec = curl_exec($ch);
        curl_close($ch);
        if (stristr($exec, 'photos') === FALSE) {
            contentomatic_log_to_file('Unrecognized Pexels API response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        $items = json_decode ( $exec, true );
        if(!isset($items['photos']))
        {
            contentomatic_log_to_file('Failed to find photo node in Pexels response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        if(count($items['photos']) == 0)
        {
            return $featured_image;
        }
        $x = 0;
        shuffle($items['photos']);
        while($featured_image == '' && isset($items['photos'][$x]))
        {
            $item = $items['photos'][$x];
            if(isset($item['src']['large']))
            {
                $featured_image = esc_url($item['src']['large']);
            }
            elseif(isset($item['src']['medium']))
            {
                $featured_image = esc_url($item['src']['medium']);
            }
            elseif(isset($item['src']['small']))
            {
                $featured_image = esc_url($item['src']['small']);
            }
            elseif(isset($item['src']['portrait']))
            {
                $featured_image = esc_url($item['src']['portrait']);
            }
            elseif(isset($item['src']['landscape']))
            {
                $featured_image = esc_url($item['src']['landscape']);
            }
            elseif(isset($item['src']['original']))
            {
                $featured_image = esc_url($item['src']['original']);
            }
            elseif(isset($item['src']['tiny']))
            {
                $featured_image = esc_url($item['src']['tiny']);
            }
            if($featured_image != '')
            {
                $original_url = esc_url($item['url']);
            }
            $x++;
        }
    }
    return $featured_image;
}

function contentomatic_meta_box_function($post)
{
    wp_register_style('contentomatic-browser-style', plugins_url('styles/contentomatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('contentomatic-browser-style');
    wp_suspend_cache_addition(true);
    $index                     = get_post_meta($post->ID, 'contentomatic_parent_rule', true);
    $img                       = get_post_meta($post->ID, 'contentomatic_featured_img', true);
    if (isset($index) && $index != '') {
        $ech = '<table class="crf_table"><tr><td><b>' . esc_html__('Post Parent Rule:', 'contentomatic-article-builder-post-generator') . '</b></td><td>&nbsp;' . esc_html($index) . '</td></tr>';
        if ($img != '') {
            $ech .= '<tr><td><b>' . esc_html__('Featured Image:', 'contentomatic-article-builder-post-generator') . '</b></td><td>&nbsp;' . esc_url($img) . '</td></tr>';
        }
        $ech .= '</table><br/>';
    } else {
        $ech = esc_html__('This is not an automatically generated post.', 'contentomatic-article-builder-post-generator');
    }
    echo $ech;
    wp_suspend_cache_addition(false);
}
function contentomatic_addPostMeta($post_id, $post, $param, $type, $featured_img)
{
    add_post_meta($post_id, 'contentomatic_parent_rule', $type . '-' . $param);
    add_post_meta($post_id, 'contentomatic_parent_rule1', $param);
    add_post_meta($post_id, 'contentomatic_parent_type', $type);
    add_post_meta($post_id, 'contentomatic_featured_img', $featured_img);
}

function contentomatic_url_is_image( $url ) {
    if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
        return FALSE;
    }
    $ext = array( 'jpeg', 'jpg', 'gif', 'png', 'jpe', 'tif', 'tiff', 'svg', 'ico' , 'webp', 'dds', 'heic', 'psd', 'pspimage', 'tga', 'thm', 'yuv', 'ai', 'eps', 'php');
    $info = (array) pathinfo( parse_url( $url, PHP_URL_PATH ) );
    return isset( $info['extension'] )
        && in_array( strtolower( $info['extension'] ), $ext, TRUE );
}

function contentomatic_generate_featured_image($image_url, $post_id)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    $upload_dir = wp_upload_dir();
    if (isset($contentomatic_Main_Settings['no_local_image']) && $contentomatic_Main_Settings['no_local_image'] == 'on') {
        
        if(!contentomatic_url_is_image($image_url))
        {
            return false;
        }
        
        $file = $upload_dir['basedir'] . '/default_img_contentomatic.jpg';
        if(!$wp_filesystem->exists($file))
        {
            $image_data = $wp_filesystem->get_contents(html_entity_decode(dirname(__FILE__) . "/images/icon.png"));
            if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE || strpos($image_data, 'ERROR: The requested URL could not be retrieved') !== FALSE) {
                return false;
            }
            $ret = $wp_filesystem->put_contents($file, $image_data);
            if ($ret === FALSE) {
                return false;
            }
        }
        $need_attach = false;
        $checking_id = get_option('contentomatic_attach_id', false);
        if($checking_id === false)
        {
            $need_attach = true;
        }
        else
        {
            $atturl = wp_get_attachment_url($checking_id);
            if($atturl === false)
            {
                $need_attach = true;
            }
        }
        if($need_attach)
        {
            $filename = basename(dirname(__FILE__) . "/images/icon.png");
            $wp_filetype = wp_check_filetype($filename, null);
            if($wp_filetype['type'] == '')
            {
                $wp_filetype['type'] = 'image/png';
            }
            $attachment  = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $attach_id   = wp_insert_attachment($attachment, $file, $post_id);
            if ($attach_id === 0) {
                return false;
            }
            update_option('contentomatic_attach_id', $attach_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);
        }
        else
        {
            $attach_id = $checking_id;
        }
        $res2 = set_post_thumbnail($post_id, $attach_id);
        if ($res2 === FALSE) {
            return false;
        }
        
        return true;
    }
    
    $image_data = contentomatic_get_web_page($image_url);
    if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE || strpos($image_data, 'You don\'t have permission') !== FALSE) {
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $image_data = $wp_filesystem->get_contents($image_url);
        if ($image_data === FALSE) {
            return false;
        }
    }
    
    $filename = basename($image_url);
    $temp     = explode("?", $filename);
    $filename = $temp[0];
    $filename = str_replace('%', '-', $filename);
    $filename = str_replace('#', '-', $filename);
    $filename = str_replace('&', '-', $filename);
    $filename = str_replace('{', '-', $filename);
    $filename = str_replace('}', '-', $filename);
    $filename = str_replace('\\', '-', $filename);
    $filename = str_replace('<', '-', $filename);
    $filename = str_replace('>', '-', $filename);
    $filename = str_replace('*', '-', $filename);
    $filename = str_replace('/', '-', $filename);
    $filename = str_replace('$', '-', $filename);
    $filename = str_replace('\'', '-', $filename);
    $filename = str_replace('"', '-', $filename);
    $filename = str_replace(':', '-', $filename);
    $filename = str_replace('@', '-', $filename);
    $filename = str_replace('+', '-', $filename);
    $filename = str_replace('|', '-', $filename);
    $filename = str_replace('=', '-', $filename);
    $filename = str_replace('`', '-', $filename);
    $filename = stripslashes(preg_replace_callback('#(%[a-zA-Z0-9_]*)#', function($matches){ return rand(0, 9); }, preg_quote($filename)));
    $file_parts = pathinfo($filename);
    $post_title = get_the_title($post_id);
    if($post_title != '')
    {
        $post_title = remove_accents( $post_title );
        $invalid = array(
            ' '   => '-',
            '%20' => '-',
            '_'   => '-',
        );
        $post_title = str_replace( array_keys( $invalid ), array_values( $invalid ), $post_title );
        $post_title = preg_replace('/[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0077}\x{E006C}\x{E0073}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0073}\x{E0063}\x{E0074}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0065}\x{E006E}\x{E0067}\x{E007F})|[\x{1F3F4}](?:\x{200D}\x{2620}\x{FE0F})|[\x{1F3F3}](?:\x{FE0F}\x{200D}\x{1F308})|[\x{0023}\x{002A}\x{0030}\x{0031}\x{0032}\x{0033}\x{0034}\x{0035}\x{0036}\x{0037}\x{0038}\x{0039}](?:\x{FE0F}\x{20E3})|[\x{1F415}](?:\x{200D}\x{1F9BA})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F468})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9BD})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9AF})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2640}\x{FE0F})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2642}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2695}\x{FE0F})|[\x{1F471}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F9CF}\x{1F647}\x{1F926}\x{1F937}\x{1F46E}\x{1F482}\x{1F477}\x{1F473}\x{1F9B8}\x{1F9B9}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F486}\x{1F487}\x{1F6B6}\x{1F9CD}\x{1F9CE}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}\x{1F9D8}](?:\x{200D}\x{2640}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B0})|[\x{1F471}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F9CF}\x{1F647}\x{1F926}\x{1F937}\x{1F46E}\x{1F482}\x{1F477}\x{1F473}\x{1F9B8}\x{1F9B9}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F486}\x{1F487}\x{1F6B6}\x{1F9CD}\x{1F9CE}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}\x{1F9D8}](?:\x{200D}\x{2642}\x{FE0F})|[\x{1F441}](?:\x{FE0F}\x{200D}\x{1F5E8}\x{FE0F})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FA}](?:\x{1F1FF})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1FA}](?:\x{1F1FE})|[\x{1F1E6}\x{1F1E8}\x{1F1F2}\x{1F1F8}](?:\x{1F1FD})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F9}\x{1F1FF}](?:\x{1F1FC})|[\x{1F1E7}\x{1F1E8}\x{1F1F1}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1FB})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1FB}](?:\x{1F1FA})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FE}](?:\x{1F1F9})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FA}\x{1F1FC}](?:\x{1F1F8})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F7})|[\x{1F1E6}\x{1F1E7}\x{1F1EC}\x{1F1EE}\x{1F1F2}](?:\x{1F1F6})|[\x{1F1E8}\x{1F1EC}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}](?:\x{1F1F5})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EE}\x{1F1EF}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1F8}\x{1F1F9}](?:\x{1F1F4})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1F3})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F4}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FF}](?:\x{1F1F2})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F1})|[\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FD}](?:\x{1F1F0})|[\x{1F1E7}\x{1F1E9}\x{1F1EB}\x{1F1F8}\x{1F1F9}](?:\x{1F1EF})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EB}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F3}\x{1F1F8}\x{1F1FB}](?:\x{1F1EE})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1ED})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1EC})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F9}\x{1F1FC}](?:\x{1F1EB})|[\x{1F1E6}\x{1F1E7}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FB}\x{1F1FE}](?:\x{1F1EA})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1E9})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FB}](?:\x{1F1E8})|[\x{1F1E7}\x{1F1EC}\x{1F1F1}\x{1F1F8}](?:\x{1F1E7})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F6}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}\x{1F1FF}](?:\x{1F1E6})|[\x{00A9}\x{00AE}\x{203C}\x{2049}\x{2122}\x{2139}\x{2194}-\x{2199}\x{21A9}-\x{21AA}\x{231A}-\x{231B}\x{2328}\x{23CF}\x{23E9}-\x{23F3}\x{23F8}-\x{23FA}\x{24C2}\x{25AA}-\x{25AB}\x{25B6}\x{25C0}\x{25FB}-\x{25FE}\x{2600}-\x{2604}\x{260E}\x{2611}\x{2614}-\x{2615}\x{2618}\x{261D}\x{2620}\x{2622}-\x{2623}\x{2626}\x{262A}\x{262E}-\x{262F}\x{2638}-\x{263A}\x{2640}\x{2642}\x{2648}-\x{2653}\x{265F}-\x{2660}\x{2663}\x{2665}-\x{2666}\x{2668}\x{267B}\x{267E}-\x{267F}\x{2692}-\x{2697}\x{2699}\x{269B}-\x{269C}\x{26A0}-\x{26A1}\x{26AA}-\x{26AB}\x{26B0}-\x{26B1}\x{26BD}-\x{26BE}\x{26C4}-\x{26C5}\x{26C8}\x{26CE}-\x{26CF}\x{26D1}\x{26D3}-\x{26D4}\x{26E9}-\x{26EA}\x{26F0}-\x{26F5}\x{26F7}-\x{26FA}\x{26FD}\x{2702}\x{2705}\x{2708}-\x{270D}\x{270F}\x{2712}\x{2714}\x{2716}\x{271D}\x{2721}\x{2728}\x{2733}-\x{2734}\x{2744}\x{2747}\x{274C}\x{274E}\x{2753}-\x{2755}\x{2757}\x{2763}-\x{2764}\x{2795}-\x{2797}\x{27A1}\x{27B0}\x{27BF}\x{2934}-\x{2935}\x{2B05}-\x{2B07}\x{2B1B}-\x{2B1C}\x{2B50}\x{2B55}\x{3030}\x{303D}\x{3297}\x{3299}\x{1F004}\x{1F0CF}\x{1F170}-\x{1F171}\x{1F17E}-\x{1F17F}\x{1F18E}\x{1F191}-\x{1F19A}\x{1F201}-\x{1F202}\x{1F21A}\x{1F22F}\x{1F232}-\x{1F23A}\x{1F250}-\x{1F251}\x{1F300}-\x{1F321}\x{1F324}-\x{1F393}\x{1F396}-\x{1F397}\x{1F399}-\x{1F39B}\x{1F39E}-\x{1F3F0}\x{1F3F3}-\x{1F3F5}\x{1F3F7}-\x{1F3FA}\x{1F400}-\x{1F4FD}\x{1F4FF}-\x{1F53D}\x{1F549}-\x{1F54E}\x{1F550}-\x{1F567}\x{1F56F}-\x{1F570}\x{1F573}-\x{1F57A}\x{1F587}\x{1F58A}-\x{1F58D}\x{1F590}\x{1F595}-\x{1F596}\x{1F5A4}-\x{1F5A5}\x{1F5A8}\x{1F5B1}-\x{1F5B2}\x{1F5BC}\x{1F5C2}-\x{1F5C4}\x{1F5D1}-\x{1F5D3}\x{1F5DC}-\x{1F5DE}\x{1F5E1}\x{1F5E3}\x{1F5E8}\x{1F5EF}\x{1F5F3}\x{1F5FA}-\x{1F64F}\x{1F680}-\x{1F6C5}\x{1F6CB}-\x{1F6D2}\x{1F6D5}\x{1F6E0}-\x{1F6E5}\x{1F6E9}\x{1F6EB}-\x{1F6EC}\x{1F6F0}\x{1F6F3}-\x{1F6FA}\x{1F7E0}-\x{1F7EB}\x{1F90D}-\x{1F93A}\x{1F93C}-\x{1F945}\x{1F947}-\x{1F971}\x{1F973}-\x{1F976}\x{1F97A}-\x{1F9A2}\x{1F9A5}-\x{1F9AA}\x{1F9AE}-\x{1F9CA}\x{1F9CD}-\x{1F9FF}\x{1FA70}-\x{1FA73}\x{1FA78}-\x{1FA7A}\x{1FA80}-\x{1FA82}\x{1FA90}-\x{1FA95}]/u', '', $post_title);
        
        $post_title = preg_replace('/\.(?=.*\.)/', '', $post_title);
        $post_title = preg_replace('/-+/', '-', $post_title);
        $post_title = str_replace('-.', '.', $post_title);
        $post_title = strtolower( $post_title );
        if($post_title == '')
        {
            $post_title = uniqid();
        }
        if(isset($file_parts['extension']))
        {
            switch($file_parts['extension'])
            {
                case "":
                $filename = sanitize_title($post_title) . '.jpg';
                break;
                case NULL:
                $filename = sanitize_title($post_title) . '.jpg';
                break;
                default:
                $filename = sanitize_title($post_title) . '.' . $file_parts['extension'];
                break;
            }
        }
        else
        {
            $filename = sanitize_title($post_title) . '.jpg';
        }
    }
    else
    {
        if(isset($file_parts['extension']))
        {
            switch($file_parts['extension'])
            {
                case "":
                if(!contentomatic_endsWith($filename, '.jpg'))
                    $filename .= '.jpg';
                break;
                case NULL:
                if(!contentomatic_endsWith($filename, '.jpg'))
                    $filename .= '.jpg';
                break;
                default:
                if(!contentomatic_endsWith($filename, '.' . $file_parts['extension']))
                    $filename .= '.' . $file_parts['extension'];
                break;
            }
        }
        else
        {
            if(!contentomatic_endsWith($filename, '.jpg'))
                $filename .= '.jpg';
        }
    }
    $filename = sanitize_file_name($filename);
    if (wp_mkdir_p($upload_dir['path'] . '/' . $post_id))
        $file = $upload_dir['path'] . '/' . $post_id . '/' . $filename;
    else
        $file = $upload_dir['basedir'] . '/' . $post_id . '/' . $filename;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $ret = $wp_filesystem->put_contents($file, $image_data);
    if ($ret === FALSE) {
        return false;
    }
    $wp_filetype = wp_check_filetype($filename, null);
    if($wp_filetype['type'] == '')
    {
        $wp_filetype['type'] = 'image/png';
    }
    $attachment  = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    if ((isset($contentomatic_Main_Settings['resize_height']) && $contentomatic_Main_Settings['resize_height'] !== '') || (isset($contentomatic_Main_Settings['resize_width']) && $contentomatic_Main_Settings['resize_width'] !== ''))
    {
        try
        {
            if(!class_exists('\Eventviva\ImageResize')){require_once (dirname(__FILE__) . "/res/ImageResize/ImageResize.php");}
            $imageRes = new ImageResize($file);
            $imageRes->quality_jpg = 100;
            if ((isset($contentomatic_Main_Settings['resize_height']) && $contentomatic_Main_Settings['resize_height'] !== '') && (isset($contentomatic_Main_Settings['resize_width']) && $contentomatic_Main_Settings['resize_width'] !== ''))
            {
                $imageRes->resizeToBestFit($contentomatic_Main_Settings['resize_width'], $contentomatic_Main_Settings['resize_height'], true);
            }
            elseif (isset($contentomatic_Main_Settings['resize_width']) && $contentomatic_Main_Settings['resize_width'] !== '')
            {
                $imageRes->resizeToWidth($contentomatic_Main_Settings['resize_width'], true);
            }
            elseif (isset($contentomatic_Main_Settings['resize_height']) && $contentomatic_Main_Settings['resize_height'] !== '')
            {
                $imageRes->resizeToHeight($contentomatic_Main_Settings['resize_height'], true);
            }
            $imageRes->save($file);
        }
        catch(Exception $e)
        {
            contentomatic_log_to_file('Failed to resize featured image: ' . $image_url . ' to sizes ' . $contentomatic_Main_Settings['resize_width'] . ' - ' . $contentomatic_Main_Settings['resize_height'] . '. Exception thrown ' . esc_html($e->getMessage()) . '!');
        }
    }
    $attach_id   = wp_insert_attachment($attachment, $file, $post_id);
    if ($attach_id === 0) {
        return false;
    }
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    $res2 = set_post_thumbnail($post_id, $attach_id);
    if ($res2 === FALSE) {
        return false;
    }
    $post_title = get_the_title($post_id);
    if($post_title != '')
    {
        update_post_meta($attach_id, '_wp_attachment_image_alt', $post_title);
    }
    return true;
}

function contentomatic_endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function contentomatic_copy_image($image_url)
{
    $upload_dir = wp_upload_dir();
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $image_data = $wp_filesystem->get_contents($image_url);
    if ($image_data === FALSE) {
        $image_data = contentomatic_get_web_page($image_url);
        if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE) {
            return false;
        }
    }
    $filename = basename($image_url);
    $temp     = explode("?", $filename);
    $filename = $temp[0];
    $filename = str_replace('%', '-', $filename);
    $filename = str_replace('#', '-', $filename);
    $filename = str_replace('&', '-', $filename);
    $filename = str_replace('{', '-', $filename);
    $filename = str_replace('}', '-', $filename);
    $filename = str_replace('\\', '-', $filename);
    $filename = str_replace('<', '-', $filename);
    $filename = str_replace('>', '-', $filename);
    $filename = str_replace('*', '-', $filename);
    $filename = str_replace('/', '-', $filename);
    $filename = str_replace('$', '-', $filename);
    $filename = str_replace('\'', '-', $filename);
    $filename = str_replace('"', '-', $filename);
    $filename = str_replace(':', '-', $filename);
    $filename = str_replace('@', '-', $filename);
    $filename = str_replace('+', '-', $filename);
    $filename = str_replace('|', '-', $filename);
    $filename = str_replace('=', '-', $filename);
    $filename = str_replace('`', '-', $filename);
    if (wp_mkdir_p($upload_dir['path'] . '/contentomatic'))
    {
        $file = $upload_dir['path'] . '/contentomatic/' . $filename;
        $retval = $upload_dir['url'] . '/contentomatic/' . $filename;
    }
    else
    {
        $file = $upload_dir['basedir'] . '/contentomatic/' . $filename;
        $retval = $upload_dir['baseurl'] . '/contentomatic/' . $filename;
    }
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $ret = $wp_filesystem->put_contents($file, $image_data);
    if ($ret === FALSE) {
        return false;
    }
    return $retval;
}

function contentomatic_repairHTML($text)
{
    $text = htmlspecialchars_decode($text);
    $text = str_replace("< ", "<", $text);
    $text = str_replace(" >", ">", $text);
    $text = str_replace("= ", "=", $text);
    $text = str_replace(" =", "=", $text);
    $text = str_replace("\/ ", "\/", $text);
    $text = str_replace("</ iframe>", "</iframe>", $text);
    $text = str_replace("frameborder ", "frameborder=\"0\" allowfullscreen></iframe>", $text);
    $doc = new DOMDocument();
    $doc->substituteEntities = false;
    $internalErrors = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $text);
    $text = $doc->saveHTML();
                    libxml_use_internal_errors($internalErrors);
	$text = preg_replace('#<!DOCTYPE html PUBLIC "-\/\/W3C\/\/DTD HTML 4\.0 Transitional\/\/EN" "http:\/\/www\.w3\.org\/TR\/REC-html40\/loose\.dtd">(?:[^<]*)<\?xml encoding="utf-8" \?><html><body>(?:<p>)?#i', '', $text);
	$text = str_replace('</p></body></html>', '', $text);
    $text = str_replace('</body></html></p>', '', $text);
    $text = str_replace('</body></html>', '', $text);
    return $text;
}
function contentomatic_hour_diff($date1, $date2)
{
    $date1 = new DateTime($date1, contentomatic_get_blog_timezone());
    $date2 = new DateTime($date2, contentomatic_get_blog_timezone());
    
    $number1 = (int) $date1->format('U');
    $number2 = (int) $date2->format('U');
    return ($number1 - $number2) / 60;
}

function contentomatic_add_hour($date, $hour)
{
    $date1 = new DateTime($date, contentomatic_get_blog_timezone());
    $date1->modify("$hour hours");
    foreach ($date1 as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return $date;
}
function contentomatic_get_blog_timezone() {

    $tzstring = get_option( 'timezone_string' );
    $offset   = get_option( 'gmt_offset' );

    if( empty( $tzstring ) && 0 != $offset && floor( $offset ) == $offset ){
        $offset_st = $offset > 0 ? "-$offset" : '+'.absint( $offset );
        $tzstring  = 'Etc/GMT'.$offset_st;
    }
    if( empty( $tzstring ) ){
        $tzstring = 'UTC';
    }
    $timezone = new DateTimeZone( $tzstring );
    return $timezone; 
}
function contentomatic_minute_diff($date1, $date2)
{
    $date1 = new DateTime($date1, contentomatic_get_blog_timezone());
    $date2 = new DateTime($date2, contentomatic_get_blog_timezone());
    
    $number1 = (int) $date1->format('U');
    $number2 = (int) $date2->format('U');
    return ($number1 - $number2);
}

function contentomatic_add_minute($date, $minute)
{
    $date1 = new DateTime($date, contentomatic_get_blog_timezone());
    $date1->modify("$minute minutes");
    foreach ($date1 as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return $date;
}

function contentomatic_wp_custom_css_files($src, $cont)
{
    wp_enqueue_style('contentomatic-thumbnail-css-' . $cont, $src, __FILE__);
}

function contentomatic_get_date_now($param = 'now')
{
    $date = new DateTime($param, contentomatic_get_blog_timezone());
    foreach ($date as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return '';
}

function contentomatic_create_terms($taxonomy, $parent, $terms_str)
{
    $terms          = explode('/', $terms_str);
    $categories     = array();
    $parent_term_id = $parent;
    foreach ($terms as $term) {
        $res = term_exists($term, $taxonomy, $parent);
        if ($res != NULL && $res != 0 && count($res) > 0 && isset($res['term_id'])) {
            $parent_term_id = $res['term_id'];
            $categories[]   = $parent_term_id;
        } else {
            $new_term = wp_insert_term($term, $taxonomy, array(
                'parent' => $parent
            ));
            if (!is_wp_error( $new_term ) && $new_term != NULL && $new_term != 0 && count($new_term) > 0 && isset($new_term['term_id'])) {
                $parent_term_id = $new_term['term_id'];
                $categories[]   = $parent_term_id;
            }
        }
    }
    
    return $categories;
}
function contentomatic_getExcerpt($the_content)
{
    $preview = contentomatic_strip_html_tags($the_content);
    $preview = wp_trim_words($preview, 55);
    return $preview;
}

function contentomatic_getPlainContent($the_content)
{
    $preview = contentomatic_strip_html_tags($the_content);
    $preview = wp_trim_words($preview, 999999);
    return $preview;
}
function contentomatic_getItemImage($img)
{
    if($img == '')
    {
        return '';
    }
    $preview = '<img src="' . esc_url($img) . '" alt="image" />';
    return $preview;
}

function contentomatic_getReadMoreButton($url, $text)
{
    $link = '';
    if (isset($url)) {
        $link = '<a href="' . esc_url($url) . '" class="button purchase" rel="nofollow noopener" target="_blank">' . esc_html($text) . '</a>';
    }
    return $link;
}
add_action('init', 'contentomatic_create_taxonomy', 0);

add_action( 'enqueue_block_editor_assets', 'contentomatic_enqueue_block_editor_assets' );
function contentomatic_enqueue_block_editor_assets() {
    wp_register_style('contentomatic-browser-style', plugins_url('styles/contentomatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('contentomatic-browser-style');
	$block_js_display   = 'scripts/display-posts.js';
	wp_enqueue_script(
		'contentomatic-display-block-js', 
        plugins_url( $block_js_display, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/list-posts.js';
	wp_enqueue_script(
		'contentomatic-list-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
}
function contentomatic_create_taxonomy()
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (isset($contentomatic_Main_Settings['contentomatic_enabled']) && $contentomatic_Main_Settings['contentomatic_enabled'] === 'on') {
        if (isset($contentomatic_Main_Settings['no_local_image']) && $contentomatic_Main_Settings['no_local_image'] == 'on') {
            add_filter('wp_get_attachment_url', 'contentomatic_replace_attachment_url', 10, 2);
            add_filter('wp_get_attachment_image_src', 'contentomatic_replace_attachment_image_src', 10, 3);
            add_filter('post_thumbnail_html', 'contentomatic_thumbnail_external_replace', 10, 6);
        }
    }
    if ( function_exists( 'register_block_type' ) ) {
        register_block_type( 'contentomatic-article-builder-post-generator/contentomatic-display', array(
            'render_callback' => 'contentomatic_display_posts_shortcode',
        ) );
        register_block_type( 'contentomatic-article-builder-post-generator/contentomatic-list', array(
            'render_callback' => 'contentomatic_list_posts',
        ) );
    }
    if(!taxonomy_exists('coderevolution_post_source'))
    {
        $labels = array(
            'name' => _x('Post Source', 'taxonomy general name', 'contentomatic-article-builder-post-generator'),
            'singular_name' => _x('Post Source', 'taxonomy singular name', 'contentomatic-article-builder-post-generator'),
            'search_items' => esc_html__('Search Post Source', 'contentomatic-article-builder-post-generator'),
            'popular_items' => esc_html__('Popular Post Source', 'contentomatic-article-builder-post-generator'),
            'all_items' => esc_html__('All Post Sources', 'contentomatic-article-builder-post-generator'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => esc_html__('Edit Post Source', 'contentomatic-article-builder-post-generator'),
            'update_item' => esc_html__('Update Post Source', 'contentomatic-article-builder-post-generator'),
            'add_new_item' => esc_html__('Add New Post Source', 'contentomatic-article-builder-post-generator'),
            'new_item_name' => esc_html__('New Post Source Name', 'contentomatic-article-builder-post-generator'),
            'separate_items_with_commas' => esc_html__('Separate Post Source with commas', 'contentomatic-article-builder-post-generator'),
            'add_or_remove_items' => esc_html__('Add or remove Post Source', 'contentomatic-article-builder-post-generator'),
            'choose_from_most_used' => esc_html__('Choose from the most used Post Source', 'contentomatic-article-builder-post-generator'),
            'not_found' => esc_html__('No Post Sources found.', 'contentomatic-article-builder-post-generator'),
            'menu_name' => esc_html__('Post Source', 'contentomatic-article-builder-post-generator')
        );
        
        $args = array(
            'hierarchical' => false,
            'public' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'description' => 'Post Source',
            'labels' => $labels,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'rewrite' => false
        );
        
        register_taxonomy('coderevolution_post_source', array(
            'post',
            'page'
        ), $args);
        add_action('pre_get_posts', function($qry) {
            if (is_admin()) return;
            if (is_tax('coderevolution_post_source')){
                $qry->set_404();
            }
        });
    }
}

register_activation_hook(__FILE__, 'contentomatic_activation_callback');
function contentomatic_activation_callback($defaults = FALSE)
{
    if (!get_option('contentomatic_Main_Settings') || $defaults === TRUE) {
        $contentomatic_Main_Settings = array(
            'contentomatic_enabled' => 'on',
            'enable_metabox' => 'on',
            'app_id' => '',
            'app_pass' => '',
            'translate' => 'disabled',
            'translate_source' => 'disabled',
            'no_title_spin' => '',
            'custom_html2' => '',
            'deepl_auth' => '',
            'custom_html' => '',
            'sentence_list' => 'This is one %adjective %noun %sentence_ending
This is another %adjective %noun %sentence_ending
I %love_it %nouns , because they are %adjective %sentence_ending
My %family says this plugin is %adjective %sentence_ending
These %nouns are %adjective %sentence_ending',
            'sentence_list2' => 'Meet this %adjective %noun %sentence_ending
This is the %adjective %noun ever %sentence_ending
I %love_it %nouns , because they are the %adjective %sentence_ending
My %family says this plugin is very %adjective %sentence_ending
These %nouns are quite %adjective %sentence_ending',
            'variable_list' => 'adjective_very => %adjective;very %adjective;

adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome

noun_with_adjective => %noun;%adjective %noun

noun => plugin;WordPress plugin;item;ingredient;component;constituent;module;add-on;plug-in;addon;extension

nouns => plugins;WordPress plugins;items;ingredients;components;constituents;modules;add-ons;plug-ins;addons;extensions

love_it => love;adore;like;be mad for;be wild about;be nuts about;be crazy about

family => %adjective %family_members;%family_members

family_members => grandpa;brother;sister;mom;dad;grandma

sentence_ending => .;!;!!',
            'auto_clear_logs' => 'No',
            'enable_logging' => 'on',
            'enable_detailed_logging' => '',
            'rule_timeout' => '3600',
            'new_category' => '',
            'email_address' => '',
            'send_email' => '',
            'best_password' => '',
            'best_user' => '',
            'exclude_words' => '',
            'spin_text' => 'disabled',
            'required_words' => '',
            'banned_words' => '',
            'max_word_content' => '',
            'min_word_content' => '',
            'max_word_title' => '',
            'min_word_title' => '',
            'resize_width' => '',
            'resize_height' => '',
            'no_local_image' => '',
            'require_all' => '',
            'secret_word' => '',
            'no_link_translate' => '',
            'skip_failed_tr' => '',
            'flickr_order' => 'date-posted-desc',
            'flickr_license' => '-1',
            'flickr_api' => '',
            'scrapeimg_height' => '',
            'attr_text' => 'Photo Credit: <a href="%%image_source_url%%" target="_blank">%%image_source_name%%</a>',
            'scrapeimg_width' => '',
            'scrapeimg_cat' => 'all',
            'scrapeimg_order' => 'any',
            'scrapeimg_orientation' => 'all',
            'imgtype' => 'all',
            'pixabay_api' => '',
            'pexels_api' => '',
            'morguefile_secret' => '',
            'morguefile_api' => '',
            'bimage' => 'on',
            'img_order' => 'popular',
            'img_cat' => 'all',
            'img_width' => '',
            'img_mwidth' => '',
            'img_ss' => '',
            'img_editor' => '',
            'img_language' => 'any',
            'pixabay_scrape' => 'on',
            'scrapeimgtype' => 'all'
        );
        if ($defaults === FALSE) {
            add_option('contentomatic_Main_Settings', $contentomatic_Main_Settings);
        } else {
            update_option('contentomatic_Main_Settings', $contentomatic_Main_Settings);
        }
    }
}
add_action('wp_loaded', 'contentomatic_run_cron', 0);
function contentomatic_run_cron()
{
    if(isset($_GET['run_contentomatic']))
    {
        $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
        if(isset($contentomatic_Main_Settings['secret_word']) && $_GET['run_contentomatic'] == $contentomatic_Main_Settings['secret_word'])
        {
            contentomatic_cron();
            die();
        }
    }
}

function contentomatic_get_words($sentence, $count = 100) {
  preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
  return $matches[0];
}

function contentomatic_generate_thumbmail( $post_id )
{
    $post = get_post($post_id);
    $post_parent_id = $post->post_parent === 0 ? $post->ID : $post->post_parent;
    if ( has_post_thumbnail($post_parent_id) )
    {
        if ($id_attachment = get_post_thumbnail_id($post_parent_id)) {
            $the_image  = wp_get_attachment_url($id_attachment, false);
            return $the_image;
        }
    }
    $attachments = array_values(get_children(array(
        'post_parent' => $post_parent_id, 
        'post_status' => 'inherit', 
        'post_type' => 'attachment', 
        'post_mime_type' => 'image', 
        'order' => 'ASC', 
        'orderby' => 'menu_order ID') 
    ));
    if( sizeof($attachments) > 0 ) {
        $the_image  = wp_get_attachment_url($attachments[0]->ID, false);
        return $the_image;
    }
    $image_url = contentomatic_extractThumbnail($post->post_content);
    return $image_url;
}
function contentomatic_extractThumbnail($content) {
    $att = contentomatic_getUrls($content);
    if(count($att) > 0)
    {
        foreach($att as $link)
        {
            $mime = contentomatic_get_mime($link);
            if(stristr($mime, "image/") !== FALSE){
                return $link;
            }
        }
    }
    else
    {
        return '';
    }
    return '';
}
function contentomatic_getUrls($string) {
    $regex = '/https?\:\/\/[^\"\' \n\s]+/i';
    preg_match_all($regex, $string, $matches);
    return ($matches[0]);
}
function contentomatic_get_mime ($filename) {
    $mime_types = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'mts' => 'video/mp2t',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'wmv' => 'video/x-ms-wmv',
        'mp4' => 'video/mp4',
        'm4p' => 'video/m4p',
        'm4v' => 'video/m4v',
        'mpg' => 'video/mpg',
        'mp2' => 'video/mp2',
        'mpe' => 'video/mpe',
        'mpv' => 'video/mpv',
        'm2v' => 'video/m2v',
        'm4v' => 'video/m4v',
        '3g2' => 'video/3g2',
        '3gpp' => 'video/3gpp',
        'f4v' => 'video/f4v',
        'f4p' => 'video/f4p',
        'f4a' => 'video/f4a',
        'f4b' => 'video/f4b',
        '3gp' => 'video/3gp',
        'avi' => 'video/x-msvideo',
        'mpeg' => 'video/mpeg',
        'mpegps' => 'video/mpeg',
        'webm' => 'video/webm',
        'mpeg4' => 'video/mp4',
        'mkv' => 'video/mkv',
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );
    $ext = array_values(array_slice(explode('.', $filename), -1));$ext = $ext[0];

    if (function_exists('mime_content_type')) {
        $mimetype = mime_content_type($filename);
        if($mimetype == '')
        {
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            } else {
                return 'application/octet-stream';
            }
        }
        return $mimetype;
    }
    elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);
        if($mimetype === false)
        {
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            } else {
                return 'application/octet-stream';
            }
        }
        return $mimetype;

    } elseif (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } else {
        return 'application/octet-stream';
    }
}

function contentomatic_spin_text($title, $content, $alt = false)
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . $titleSeparator . $content;
    $text                   = html_entity_decode($text);
    preg_match_all("/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER);
    $htmlfounds         = array_filter(array_unique($matches[0]));
    $htmlfounds[]       = '&quot;';
    $imgFoundsSeparated = array();
    foreach ($htmlfounds as $key => $currentFound) {
        if (stristr($currentFound, '<img') && stristr($currentFound, 'alt')) {
            $altSeparator   = '';
            $colonSeparator = '';
            if (stristr($currentFound, 'alt="')) {
                $altSeparator   = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt = "')) {
                $altSeparator   = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt ="')) {
                $altSeparator   = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt= "')) {
                $altSeparator   = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt=\'')) {
                $altSeparator   = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt = \'')) {
                $altSeparator   = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt= \'')) {
                $altSeparator   = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt =\'')) {
                $altSeparator   = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim($altSeparator) != '') {
                $currentFoundParts = explode($altSeparator, $currentFound);
                $preAlt            = $currentFoundParts[1];
                $preAltParts       = explode($colonSeparator, $preAlt);
                $altText           = $preAltParts[0];
                if (trim($altText) != '') {
                    unset($preAltParts[0]);
                    $imgFoundsSeparated[] = $currentFoundParts[0] . $altSeparator;
                    $imgFoundsSeparated[] = $colonSeparator . implode('', $preAltParts);
                    $htmlfounds[$key]     = '';
                }
            }
        }
    }
    if (count($imgFoundsSeparated) != 0) {
        $htmlfounds = array_merge($htmlfounds, $imgFoundsSeparated);
    }
    preg_match_all("/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER);
    $newhtmlfounds = $matches2[0];
    preg_match_all("/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER);
    $shortcodesfounds = $matches3[0];
    $htmlfounds       = array_merge($htmlfounds, $newhtmlfounds, $shortcodesfounds);
    $in               = 0;
    $cleanHtmlFounds  = array();
    foreach ($htmlfounds as $htmlfound) {
        if ($htmlfound == '[19459000]') {
        } elseif (trim($htmlfound) == '') {
        } else {
            $cleanHtmlFounds[] = $htmlfound;
        }
    }
    $htmlfounds = $cleanHtmlFounds;
    $start      = 19459001;
    foreach ($htmlfounds as $htmlfound) {
        $text = str_replace($htmlfound, '[' . $start . ']', $text);
        $start++;
    }
    try {
        require_once(dirname(__FILE__) . "/res/contentomatic-text-spinner.php");
        $phpTextSpinner = new PhpTextSpinner();
        if ($alt === FALSE) {
            $spinContent = $phpTextSpinner->spinContent($text);
        } else {
            $spinContent = $phpTextSpinner->spinContentAlt($text);
        }
        $translated = $phpTextSpinner->runTextSpinner($spinContent);
    }
    catch (Exception $e) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('Exception thrown in spinText ' . $e);
        }
        return false;
    }
    preg_match_all('{\[.*?\]}', $translated, $brackets);
    $brackets = $brackets[0];
    $brackets = array_unique($brackets);
    foreach ($brackets as $bracket) {
        if (stristr($bracket, '19')) {
            $corrrect_bracket = str_replace(' ', '', $bracket);
            $corrrect_bracket = str_replace('.', '', $corrrect_bracket);
            $corrrect_bracket = str_replace(',', '', $corrrect_bracket);
            $translated       = str_replace($bracket, $corrrect_bracket, $translated);
        }
    }
    if (stristr($translated, $titleSeparator)) {
        $start = 19459001;
        foreach ($htmlfounds as $htmlfound) {
            $translated = str_replace('[' . $start . ']', $htmlfound, $translated);
            $start++;
        }
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}

function contentomatic_builtin_spin_text($title, $content)
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . $titleSeparator . $content;
    $text                   = html_entity_decode($text);
    preg_match_all("/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER);
    $htmlfounds         = array_filter(array_unique($matches[0]));
    $htmlfounds[]       = '&quot;';
    $imgFoundsSeparated = array();
    foreach ($htmlfounds as $key => $currentFound) {
        if (stristr($currentFound, '<img') && stristr($currentFound, 'alt')) {
            $altSeparator   = '';
            $colonSeparator = '';
            if (stristr($currentFound, 'alt="')) {
                $altSeparator   = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt = "')) {
                $altSeparator   = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt ="')) {
                $altSeparator   = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt= "')) {
                $altSeparator   = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt=\'')) {
                $altSeparator   = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt = \'')) {
                $altSeparator   = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt= \'')) {
                $altSeparator   = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt =\'')) {
                $altSeparator   = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim($altSeparator) != '') {
                $currentFoundParts = explode($altSeparator, $currentFound);
                $preAlt            = $currentFoundParts[1];
                $preAltParts       = explode($colonSeparator, $preAlt);
                $altText           = $preAltParts[0];
                if (trim($altText) != '') {
                    unset($preAltParts[0]);
                    $imgFoundsSeparated[] = $currentFoundParts[0] . $altSeparator;
                    $imgFoundsSeparated[] = $colonSeparator . implode('', $preAltParts);
                    $htmlfounds[$key]     = '';
                }
            }
        }
    }
    if (count($imgFoundsSeparated) != 0) {
        $htmlfounds = array_merge($htmlfounds, $imgFoundsSeparated);
    }
    preg_match_all("/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER);
    $newhtmlfounds = $matches2[0];
    preg_match_all("/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER);
    $shortcodesfounds = $matches3[0];
    $htmlfounds       = array_merge($htmlfounds, $newhtmlfounds, $shortcodesfounds);
    $in               = 0;
    $cleanHtmlFounds  = array();
    foreach ($htmlfounds as $htmlfound) {
        if ($htmlfound == '[19459000]') {
        } elseif (trim($htmlfound) == '') {
        } else {
            $cleanHtmlFounds[] = $htmlfound;
        }
    }
    $htmlfounds = $cleanHtmlFounds;
    $start      = 19459001;
    foreach ($htmlfounds as $htmlfound) {
        $text = str_replace($htmlfound, '[' . $start . ']', $text);
        $start++;
    }
    if (isset($contentomatic_Main_Settings['exclude_words']) && $contentomatic_Main_Settings['exclude_words'] != '') {
        $excw = explode(',', $contentomatic_Main_Settings['exclude_words']);
        $excw = array_map('trim', $excw);
    }
    else
    {
        $excw = array();
    }
    try {
        $file=file(dirname(__FILE__)  .'/res/synonyms.dat');
		foreach($file as $line){
			$synonyms=explode('|',$line);
			foreach($synonyms as $word){
				if(trim($word) != ''){
                    $must_cont = false;
                    foreach($excw as $exw)
                    {
                        if(strstr($word, $exw) !== false)
                        {
                            $must_cont = true;
                            break;
                        }
                    }
                    if($must_cont == true)
                    {
                        continue;
                    }
                    $word=str_replace('/','\/',$word);
					if(preg_match('/\b'. $word .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$word.'\b/u', trim($synonyms[$rand]), $text);
					}
                    $uword=ucfirst($word);
					if(preg_match('/\b'. $uword .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$uword.'\b/u', ucfirst(trim($synonyms[$rand])), $text);
					}
				}
			}
		}
        $translated = $text;
    }
    catch (Exception $e) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('Exception thrown in spinText ' . $e);
        }
        return false;
    }
    preg_match_all('{\[.*?\]}', $translated, $brackets);
    $brackets = $brackets[0];
    $brackets = array_unique($brackets);
    foreach ($brackets as $bracket) {
        if (stristr($bracket, '19')) {
            $corrrect_bracket = str_replace(' ', '', $bracket);
            $corrrect_bracket = str_replace('.', '', $corrrect_bracket);
            $corrrect_bracket = str_replace(',', '', $corrrect_bracket);
            $translated       = str_replace($bracket, $corrrect_bracket, $translated);
        }
    }
    if (stristr($translated, $titleSeparator)) {
        $start = 19459001;
        foreach ($htmlfounds as $htmlfound) {
            $translated = str_replace('[' . $start . ']', $htmlfound, $translated);
            $start++;
        }
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}

function contentomatic_best_spin_text($title, $content)
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (!isset($contentomatic_Main_Settings['best_user']) || $contentomatic_Main_Settings['best_user'] == '' || !isset($contentomatic_Main_Settings['best_password']) || $contentomatic_Main_Settings['best_password'] == '') {
        contentomatic_log_to_file('Please insert a valid "The Best Spinner" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $newhtml          = $title . $titleSeparator . $content;
    $url              = 'http://thebestspinner.com/api.php';
    $data             = array();
    $data['action']   = 'authenticate';
    $data['format']   = 'php';
    $data['username'] = $contentomatic_Main_Settings['best_user'];
    $data['password'] = $contentomatic_Main_Settings['best_password'];
    $ch               = curl_init();
    if ($ch === FALSE) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('Failed to init curl!');
        }
        return FALSE;
    }
	
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $fdata = "";
    foreach ($data as $key => $val) {
        $fdata .= "$key=" . urlencode($val) . "&";
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $html = curl_exec($ch);
    curl_close($ch);
    if ($html === FALSE) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('"The Best Spinner" failed to exec curl.');
        }
        return FALSE;
    }
    $output = unserialize($html);
    if ($output['success'] == 'true') {
        $session                = $output['session'];
        $data                   = array();
        $data['session']        = $session;
        $data['format']         = 'php';
        $data['protectedterms'] = '';
        $data['text']           = (html_entity_decode($newhtml));
        $data['action']         = 'replaceEveryonesFavorites';
        $data['maxsyns']        = '100';
        $data['quality']        = '1';
        
        $ch = curl_init();
        if ($ch === FALSE) {
            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                contentomatic_log_to_file('Failed to init curl');
            }
            return FALSE;
        }
		
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $fdata = "";
        foreach ($data as $key => $val) {
            $fdata .= "$key=" . urlencode($val) . "&";
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        $output = curl_exec($ch);
        curl_close($ch);
        if ($output === FALSE) {
            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                contentomatic_log_to_file('"The Best Spinner" failed to exec curl after auth.');
            }
            return FALSE;
        }
        
        $output = unserialize($output);
        if ($output['success'] == 'true') {
            $result = explode($titleSeparator, $output['output']);
            if (count($result) < 2) {
                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                    contentomatic_log_to_file('"The Best Spinner" failed to spin article - titleseparator not found.' . print_r($output, true));
                }
                return FALSE;
            }
            $spintax = new Contentomatic_Spintax();
            $result[0] = $spintax->process($result[0]);
            $result[1] = $spintax->process($result[1]);
            return $result;
        } else {
            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                contentomatic_log_to_file('"The Best Spinner" failed to spin article.');
            }
            return FALSE;
        }
    } else {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('"The Best Spinner" authentification failed.');
        }
        return FALSE;
    }
}
function contentomatic_wordai_spin_text($title, $content)
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (!isset($contentomatic_Main_Settings['best_user']) || $contentomatic_Main_Settings['best_user'] == '' || !isset($contentomatic_Main_Settings['best_password']) || $contentomatic_Main_Settings['best_password'] == '') {
        contentomatic_log_to_file('Please insert a valid "Wordai" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $quality = 'Readable';
    $html             = $title . $titleSeparator . $content;
    $email = $contentomatic_Main_Settings['best_user'];
    $pass = $contentomatic_Main_Settings['best_password'];
    $html = urlencode($html);
    $ch = curl_init('http://wordai.com/users/turing-api.php');
    if($ch === false)
    {
        contentomatic_log_to_file('Failed to init curl in wordai spinning.');
        return FALSE;
    }
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, "s=$html&quality=$quality&email=$email&pass=$pass&output=json");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    
    if ($result === FALSE) {
        contentomatic_log_to_file('"Wordai" failed to exec curl after auth: ' . curl_error($ch));
        curl_close ($ch);
        return FALSE;
    }
    curl_close ($ch);
    $result = json_decode($result);
    if(!isset($result->text))
    {
        contentomatic_log_to_file('"Wordai" unrecognized response: ' . print_r($result, true));
        return FALSE;
    }
    $result = explode($titleSeparator, $result->text);
    if (count($result) < 2) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('"Wordai" failed to spin article - titleseparator not found.');
        }
        return FALSE;
    }
    $spintax = new Contentomatic_Spintax();
    $result[0] = $spintax->process($result[0]);
    $result[1] = $spintax->process($result[1]);
    return $result;
}
 
function contentomatic_spinnerchief_spin_text($title, $content)
{
    $titleSeparator = '[19459000]';
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (!isset($contentomatic_Main_Settings['best_user']) || $contentomatic_Main_Settings['best_user'] == '' || !isset($contentomatic_Main_Settings['best_password']) || $contentomatic_Main_Settings['best_password'] == '') {
        contentomatic_log_to_file('Please insert a valid "SpinnerChief" user email and password.');
        return FALSE;
    }
    $usr = $contentomatic_Main_Settings['best_user'];
    $pss = $contentomatic_Main_Settings['best_password'];
    $html = stripslashes($title). ' ' . $titleSeparator . ' ' . stripslashes($content);
    if(str_word_count($html) > 5000)
    {
        return FALSE;
    }
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36');
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$url = "http://api.spinnerchief.com:443/apikey=api2409357d02fa474d8&username=" . $usr . "&password=" . $pss . "&spinfreq=2&Wordscount=6&wordquality=0&tagprotect=[]&original=0&thesaurus=English&replacetype=0&chartype=1&convertbase=0";
	$xlurl="$url";
	$curlpost=  ( ( $html ) );
	curl_setopt($ch, CURLOPT_URL, $xlurl);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlpost); 
 	$result = curl_exec($ch);
	
    if ($result === FALSE) {
        $cer = 'Curl error: ' . curl_error($ch);
        contentomatic_log_to_file('"SpinnerChief" failed to exec curl after auth. ' . $cer);
        curl_close ($ch);
        return FALSE;
    }
    curl_close ($ch);
    $result = explode($titleSeparator, $result);
    if (count($result) < 2) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('"SpinnerChief" failed to spin article - titleseparator not found: ' . print_r($result, true));
        }
        return FALSE;
    }
    $spintax = new Contentomatic_Spintax();
    $result[0] = $spintax->process(trim($result[0]));
    $result[1] = $spintax->process(trim($result[1]));
    return $result;
}   
function contentomatic_spinrewriter_spin_text($title, $content)
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (!isset($contentomatic_Main_Settings['best_user']) || $contentomatic_Main_Settings['best_user'] == '' || !isset($contentomatic_Main_Settings['best_password']) || $contentomatic_Main_Settings['best_password'] == '') {
        contentomatic_log_to_file('Please insert a valid "SpinRewriter" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $quality = '50';
    $html             = $title . $titleSeparator . $content;
    if(str_word_count($html) > 4000)
    {
        return FALSE;
    }
	$data = array();
	$data['email_address'] = $contentomatic_Main_Settings['best_user'];
	$data['api_key'] = $contentomatic_Main_Settings['best_password'];
	$data['action'] = "unique_variation";
	$data['text'] = $html;
	 
	$data['auto_protected_terms'] = "false";					
	$data['confidence_level'] = "high";							
	$data['auto_sentences'] = "true";							
	$data['auto_paragraphs'] = "true";							
	$data['auto_new_paragraphs'] = "false";						
	$data['auto_sentence_trees'] = "false";						
	$data['use_only_synonyms'] = "false";						
	$data['reorder_paragraphs'] = "false";						
	$data['nested_spintax'] = "false";							
    $api_response = contentomatic_spinrewriter_api_post($data);
    if ($api_response === FALSE) {
        contentomatic_log_to_file('"SpinRewriter" failed to exec curl after auth.');
        return FALSE;
    }
    $api_response = json_decode($api_response);
    if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
    {
        if(isset($api_response->status) && $api_response->status == 'ERROR')
        {
            if(isset($api_response->response) && $api_response->response == 'You can only submit entirely new text for analysis once every 7 seconds.')
            {
                $api_response = contentomatic_spinrewriter_api_post($data);
                if ($api_response === FALSE) {
                    contentomatic_log_to_file('"SpinRewriter" failed to exec curl after auth (after resubmit).');
                    return FALSE;
                }
                $api_response = json_decode($api_response);
                if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
                {
                    contentomatic_log_to_file('"SpinRewriter" failed to wait and resubmit spinning: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                    return FALSE;
                }
            }
            else
            {
                contentomatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                return FALSE;
            }
        }
        else
        {
            contentomatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
            return FALSE;
        }
    }
    $api_response->response = urldecode($api_response->response);
    $resp = str_replace('% ', '%', $api_response->response);
    $resp = urldecode($resp);
    $result = explode($titleSeparator, $resp);
    if (count($result) < 2) {
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('"SpinRewriter" failed to spin article - titleseparator not found: ' . $resp);
        }
        return FALSE;
    }
    return $result;
}
function contentomatic_spinrewriter_api_post($data)
{
	$data_raw = "";
    
    $GLOBALS['wp_object_cache']->delete('crspinrewriter_spin_time', 'options');
    $spin_time = get_option('crspinrewriter_spin_time', false);
    if($spin_time !== false && is_numeric($spin_time))
    {
        $c_time = time();
        $spassed = $c_time - $spin_time;
        if($spassed < 10 && $spassed >= 0)
        {
            sleep(10 - $spassed);
        }
    }
    update_option('crspinrewriter_spin_time', time());
    
	foreach ($data as $key => $value){
		$data_raw = $data_raw . $key . "=" . urlencode($value) . "&";
	}
	$ch = curl_init();
    if($ch === false)
    {
        return false;
    }
	curl_setopt($ch, CURLOPT_URL, "http://www.spinrewriter.com/action/api");
	curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, "DHE_RSA_AES_128_CBC_SHA1,DHE_RSA_AES_128_CBC_SHA256,DHE_RSA_CAMELLIA_128_CBC_SHA1,DHE_RSA_AES_256_CBC_SHA1,DHE_RSA_AES_256_CBC_SHA256DHE_RSA_CAMELLIA_256_CBC_SHA1,DHE_RSA_3DES_EDE_CBC_SHA1,DHE_DSS_AES_128_CBC_SHA1,DHE_DSS_AES_128_CBC_SHA256,DHE_DSS_CAMELLIA_128_CBC_SHA1,DHE_DSS_AES_256_CBC_SHA1,DHE_DSS_AES_256_CBC_SHA256,DHE_DSS_CAMELLIA_256_CBC_SHA1,DHE_DSS_3DES_EDE_CBC_SHA1,DHE_DSS_ARCFOUR_SHA1,RSA_AES_128_CBC_SHA1,RSA_AES_128_CBC_SHA256,RSA_CAMELLIA_128_CBC_SHA1,RSA_AES_256_CBC_SHA1,RSA_AES_256_CBC_SHA256,RSA_CAMELLIA_256_CBC_SHA1,RSA_3DES_EDE_CBC_SHA1,RSA_ARCFOUR_SHA1,RSA_ARCFOUR_MD5");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_raw);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	$response = trim(curl_exec($ch));
	curl_close($ch);
	return $response;
}
function contentomatic_replaceExecludes($article, &$htmlfounds, $opt = false)
{
    $htmlurls = array();$article = preg_replace('{data-image-description="(?:[^\"]*?)"}i', '', $article);
	if($opt === true){
		preg_match_all( "/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*?)<\/a>/s" ,$article,$matches,PREG_PATTERN_ORDER);
		$htmlurls=$matches[0];
	}
	$urls_txt = array();
	if($opt === true){
		preg_match_all('/https?:\/\/[^<\s]+/', $article,$matches_urls_txt);
		$urls_txt = $matches_urls_txt[0];
	}
	preg_match_all("/<[^<>]+>/is",$article,$matches,PREG_PATTERN_ORDER);
	$htmlfounds=$matches[0];
	preg_match_all('{\[nospin\].*?\[/nospin\]}s', $article,$matches_ns);
	$nospin = $matches_ns[0];
	$pattern="\[.*?\]";
	preg_match_all("/".$pattern."/s",$article,$matches2,PREG_PATTERN_ORDER);
	$shortcodes=$matches2[0];
	preg_match_all("/<script.*?<\/script>/is",$article,$matches3,PREG_PATTERN_ORDER);
	$js=$matches3[0];
	preg_match_all('/\d{2,}/s', $article,$matches_nums);
	$nospin_nums = $matches_nums[0];
	sort($nospin_nums);
	$nospin_nums = array_reverse($nospin_nums);
	$capped = array();
	if($opt === true){
		preg_match_all("{\b[A-Z][a-z']+\b[,]?}", $article,$matches_cap);
		$capped = $matches_cap[0];
		sort($capped);
		$capped=array_reverse($capped);
	}
	$curly_quote = array();
	if($opt === true){
		preg_match_all('{???.*????}', $article, $matches_curly_txt);
		$curly_quote = $matches_curly_txt[0];
		preg_match_all('{???.*????}', $article, $matches_curly_txt_s);
		$single_curly_quote = $matches_curly_txt_s[0];
		preg_match_all('{&quot;.*?&quot;}', $article, $matches_curly_txt_s_and);
		$single_curly_quote_and = $matches_curly_txt_s_and[0];
		preg_match_all('{&#8220;.*?&#8221}', $article, $matches_curly_txt_s_and_num);
		$single_curly_quote_and_num = $matches_curly_txt_s_and_num[0];
		$curly_quote_regular = array();
		preg_match_all('{".*?"}', $article, $matches_curly_txt_regular);
        $curly_quote_regular = $matches_curly_txt_regular[0];
		$curly_quote = array_merge($curly_quote , $single_curly_quote ,$single_curly_quote_and,$single_curly_quote_and_num,$curly_quote_regular);
	}
	$htmlfounds = array_merge($nospin, $shortcodes, $js, $htmlurls, $htmlfounds, $curly_quote, $urls_txt, $nospin_nums, $capped);
	$htmlfounds = array_filter(array_unique($htmlfounds));
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article=str_replace($htmlfound,'('.str_repeat('*', $i).')',$article);	
		$i++;
	}
    $article = str_replace(':(*', ': (*', $article);
	return $article;
}
function contentomatic_restoreExecludes($article, $htmlfounds){
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article=str_replace( '('.str_repeat('*', $i).')', $htmlfound, $article);
		$i++;
	}
	$article = str_replace(array('[nospin]','[/nospin]'), '', $article);
    $article = preg_replace('{\(?\*[\s*]+\)?}', '', $article);
	return $article;
}
function contentomatic_fix_spinned_content($final_content, $spinner)
{
    if ($spinner == 'wordai') {
        $final_content = str_replace('-LRB-', '(', $final_content);
        $final_content = preg_replace("/{\*\|.*?}/", '*', $final_content);
        preg_match_all('/{\)[^}]*\|\)[^}]*}/', $final_content, $matches_brackets);
        $matches_brackets = $matches_brackets[0];
        foreach ($matches_brackets as $matches_bracket) {
            $matches_bracket_clean = str_replace( array('{','}') , '', $matches_bracket);
            $matches_bracket_parts = explode('|',$matches_bracket_clean);
            $final_content = str_replace($matches_bracket, $matches_bracket_parts[0], $final_content);
        }
    }
    elseif ($spinner == 'spinrewriter' || $spinner == 'translate') {
        $final_content = preg_replace('{\(\s(\**?\))\.}', '($1', $final_content);
        $final_content = preg_replace('{\(\s(\**?\))\s\(}', '($1(', $final_content);
        $final_content = preg_replace('{\s(\(\**?\))\.(\s)}', "$1$2", $final_content);
        $final_content = str_replace('( *', '(*', $final_content);
        $final_content = str_replace('* )', '*)', $final_content);
        $final_content = str_replace('& #', '&#', $final_content);
        $final_content = str_replace('& ldquo;', '"', $final_content);
        $final_content = str_replace('& rdquo;', '"', $final_content);
    }
    return $final_content;
}
function contentomatic_spin_and_translate($post_title, $final_content, $rule_translate, $rule_translate_source)
{
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if (isset($contentomatic_Main_Settings['spin_text']) && $contentomatic_Main_Settings['spin_text'] !== 'disabled') {
        
        $htmlfounds = array();
        $final_content = contentomatic_replaceExecludes($final_content, $htmlfounds, false);
        
        if ($contentomatic_Main_Settings['spin_text'] == 'builtin') {
            $translation = contentomatic_builtin_spin_text($post_title, $final_content);
        } elseif ($contentomatic_Main_Settings['spin_text'] == 'wikisynonyms') {
            $translation = contentomatic_spin_text($post_title, $final_content, false);
        } elseif ($contentomatic_Main_Settings['spin_text'] == 'freethesaurus') {
            $translation = contentomatic_spin_text($post_title, $final_content, true);
        } elseif ($contentomatic_Main_Settings['spin_text'] == 'best') {
            $translation = contentomatic_best_spin_text($post_title, $final_content);
        } elseif ($contentomatic_Main_Settings['spin_text'] == 'wordai') {
            $translation = contentomatic_wordai_spin_text($post_title, $final_content);
        } elseif ($contentomatic_Main_Settings['spin_text'] == 'spinrewriter') {
            $translation = contentomatic_spinrewriter_spin_text($post_title, $final_content);
        } elseif ($contentomatic_Main_Settings['spin_text'] == 'spinnerchief') {
            $translation = contentomatic_spinnerchief_spin_text($post_title, $final_content);
        }
        if ($translation !== FALSE) {
            if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                if (isset($contentomatic_Main_Settings['no_title_spin']) && $contentomatic_Main_Settings['no_title_spin'] == 'on') {
                }
                else
                {
                    $post_title    = $translation[0];
                }
                $final_content = $translation[1];
                
                $final_content = contentomatic_fix_spinned_content($final_content, $contentomatic_Main_Settings['spin_text']);
                $final_content = contentomatic_restoreExecludes($final_content, $htmlfounds);
                
            } else {
                $final_content = contentomatic_restoreExecludes($final_content, $htmlfounds);
                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                    contentomatic_log_to_file('Text Spinning failed - malformed data ' . $contentomatic_Main_Settings['spin_text']);
                }
            }
        } else {
            $final_content = contentomatic_restoreExecludes($final_content, $htmlfounds);
            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                contentomatic_log_to_file('Text Spinning Failed - returned false ' . $contentomatic_Main_Settings['spin_text']);
            }
        }
    }
    if($rule_translate != '' && $rule_translate != 'disabled')
    {
        if (isset($rule_translate_source) && $rule_translate_source != 'disabled' && $rule_translate_source != '') {
            $tr = $rule_translate_source;
        }
        else
        {
            $tr = 'auto';
        }
        $htmlfounds = array();
        $final_content = contentomatic_replaceExecludes($final_content, $htmlfounds, false);
        
        $translation = contentomatic_translate($post_title, $final_content, $tr, $rule_translate);
        if (is_array($translation) && isset($translation[1]))
        {
            $translation[1] = preg_replace('#(?<=[\*(])\s+(?=[\*)])#', '', $translation[1]);
            $translation[1] = preg_replace('#([^(*\s]\s)\*+\)#', '$1', $translation[1]);
            $translation[1] = preg_replace('#\(\*+([\s][^)*\s])#', '$1', $translation[1]);
            $translation[1] = contentomatic_restoreExecludes($translation[1], $htmlfounds);
        }
        else
        {
            $final_content = contentomatic_restoreExecludes($final_content, $htmlfounds);
        }
        if ($translation !== FALSE) {
            if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                $post_title    = $translation[0];
                $final_content = $translation[1];
                $final_content = str_replace('</ iframe>', '</iframe>', $final_content);
                if(stristr($final_content, '<head>') !== false)
                {
                    $d = new DOMDocument;
                    $mock = new DOMDocument;
                    $internalErrors = libxml_use_internal_errors(true);
                    $d->loadHTML('<?xml encoding="utf-8" ?>' . $final_content);
                    libxml_use_internal_errors($internalErrors);
                    $body = $d->getElementsByTagName('body')->item(0);
                    foreach ($body->childNodes as $child)
                    {
                        $mock->appendChild($mock->importNode($child, true));
                    }
                    $new_post_content_temp = $mock->saveHTML();
                    if($new_post_content_temp !== '' && $new_post_content_temp !== false)
                    {
						$new_post_content_temp = str_replace('<?xml encoding="utf-8" ?>', '', $new_post_content_temp);
                        $final_content = preg_replace("/_addload\(function\(\){([^<]*)/i", "", $new_post_content_temp); 
                    }
                }
                $final_content = contentomatic_repairHTML($final_content);
                $final_content = str_replace('%20', '', $final_content);
                $final_content = str_replace('/V/', '/v/', $final_content);
                $final_content = str_replace('?Oh=', '?oh=', $final_content);
                $final_content = htmlspecialchars_decode($final_content);
                $final_content = str_replace('</ ', '</', $final_content);
                $final_content = str_replace(' />', '/>', $final_content);
                $final_content = str_replace('< br/>', '<br/>', $final_content);
                $final_content = str_replace('< / ', '</', $final_content);
                $final_content = str_replace(' / >', '/>', $final_content);
                $final_content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $final_content);
                $post_title = htmlspecialchars_decode($post_title);
                $post_title = str_replace('</ ', '</', $post_title);
                $post_title = str_replace(' />', '/>', $post_title);
                $post_title = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $post_title);
            } else {
                if (!isset($contentomatic_Main_Settings['skip_failed_tr']) || $contentomatic_Main_Settings['skip_failed_tr'] != 'on')
                {
                    return false;
                }
                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                    contentomatic_log_to_file('Translation failed - malformed data!');
                }
            }
        } else {
            if (!isset($contentomatic_Main_Settings['skip_failed_tr']) || $contentomatic_Main_Settings['skip_failed_tr'] != 'on')
            {
                return false;
            }
            if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                contentomatic_log_to_file('Translation Failed - returned false!');
            }
        }
    }
    else
    {
        if (isset($contentomatic_Main_Settings['translate']) && $contentomatic_Main_Settings['translate'] != 'disabled') {
            if (isset($contentomatic_Main_Settings['translate_source']) && $contentomatic_Main_Settings['translate_source'] != 'disabled') {
                $tr = $contentomatic_Main_Settings['translate_source'];
            }
            else
            {
                $tr = 'auto';
            }
            $htmlfounds = array();
            $final_content = contentomatic_replaceExecludes($final_content, $htmlfounds, false);
        
            $translation = contentomatic_translate($post_title, $final_content, $tr, $contentomatic_Main_Settings['translate']);
            if (is_array($translation) && isset($translation[1]))
            {
                $translation[1] = preg_replace('#(?<=[\*(])\s+(?=[\*)])#', '', $translation[1]);
                $translation[1] = preg_replace('#([^(*\s]\s)\*+\)#', '$1', $translation[1]);
                $translation[1] = preg_replace('#\(\*+([\s][^)*\s])#', '$1', $translation[1]);
                $translation[1] = contentomatic_restoreExecludes($translation[1], $htmlfounds);
            }
            else
            {
                $final_content = contentomatic_restoreExecludes($final_content, $htmlfounds);
            }
            if ($translation !== FALSE) {
                if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                    $post_title    = $translation[0];
                    $final_content = $translation[1];
                    $final_content = str_replace('</ iframe>', '</iframe>', $final_content);
                    if(stristr($final_content, '<head>') !== false)
                    {
                        $d = new DOMDocument;
                        $mock = new DOMDocument;
                        $internalErrors = libxml_use_internal_errors(true);
                        $d->loadHTML('<?xml encoding="utf-8" ?>' . $final_content);
                    libxml_use_internal_errors($internalErrors);
                        $body = $d->getElementsByTagName('body')->item(0);
                        foreach ($body->childNodes as $child)
                        {
                            $mock->appendChild($mock->importNode($child, true));
                        }
                        $new_post_content_temp = $mock->saveHTML();
                        if($new_post_content_temp !== '' && $new_post_content_temp !== false)
                        {
                            $final_content = preg_replace("/_addload\(function\(\){([^<]*)/i", "", $new_post_content_temp); 
                        }
                    }
                    $final_content = contentomatic_repairHTML($final_content);
                    $final_content = str_replace('%20', '', $final_content);
                    $final_content = str_replace('/V/', '/v/', $final_content);
                    $final_content = str_replace('?Oh=', '?oh=', $final_content);
                    $final_content = htmlspecialchars_decode($final_content);
                    $final_content = str_replace('</ ', '</', $final_content);
                    $final_content = str_replace(' />', '/>', $final_content);
                    $final_content = str_replace('< br/>', '<br/>', $final_content);
                    $final_content = str_replace('< / ', '</', $final_content);
                    $final_content = str_replace(' / >', '/>', $final_content);
                    $final_content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $final_content);
                    $post_title = htmlspecialchars_decode($post_title);
                    $post_title = str_replace('</ ', '</', $post_title);
                    $post_title = str_replace(' />', '/>', $post_title);
                    $post_title = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $post_title);
                } else {
                    if (!isset($contentomatic_Main_Settings['skip_failed_tr']) || $contentomatic_Main_Settings['skip_failed_tr'] != 'on')
                    {
                        return false;
                    }
                    if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                        contentomatic_log_to_file('Translation failed - malformed data!');
                    }
                }
            } else {
                if (!isset($contentomatic_Main_Settings['skip_failed_tr']) || $contentomatic_Main_Settings['skip_failed_tr'] != 'on')
                {
                    return false;
                }
                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                    contentomatic_log_to_file('Translation Failed - returned false!');
                }
            }
        }
    }
    return array(
        $post_title,
        $final_content
    );
}

function contentomatic_translate($title, $content, $from, $to)
{
    $ch = FALSE;
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    try {
        if($from == 'disabled')
        {
            if(strstr($to, '-') !== false && $to != 'zh-CN' && $to != 'zh-TW')
            {
                $from = 'en-';
            }
            else
            {
                $from = 'en';
            }
        }
        if($from != 'en' && $from != 'en-' && $from == $to)
        {
            if(strstr($to, '-') !== false && $to != 'zh-CN' && $to != 'zh-TW')
            {
                $from = 'en-';
            }
            else
            {
                $from = 'en';
            }
        }
        elseif(($from == 'en' || $from == 'en-') && $from == $to)
        {
            return false;
        }
        if(strstr($to, '-') !== false && $to != 'zh-CN' && $to != 'zh-TW')
        {
            if (!isset($contentomatic_Main_Settings['deepl_auth']) || trim($contentomatic_Main_Settings['deepl_auth']) == '')
            {
                throw new Exception('You must enter a Deepl API key from plugin settings, to use this feature!');
            }
            $to = rtrim($to, '-');
            $from = rtrim($from, '-');
            if(strlen($content) > 30000)
            {
                $translated = '';
                while($content != '')
                {
                    $first30k = substr($content, 0, 30000);
                    $content = substr($content, 30000);
                    $ch = curl_init('https://api.deepl.com/v2/translate');
                    if($ch !== false)
                    {
                        $data           = array();
                        $data['text']   = $first30k;
                        $data['source_lang']   = $from;
                        $data['tag_handling']  = 'xml';
                        $data['non_splitting_tags']  = 'div';
                        $data['preserve_formatting']  = '1';
                        $data['target_lang']   = $to;
                        $data['auth_key']   = trim($contentomatic_Main_Settings['deepl_auth']);
                        $fdata = "";
                        foreach ($data as $key => $val) {
                            $fdata .= "$key=" . urlencode(trim($val)) . "&";
                        }
                        $headers = [
                            'Content-Type: application/x-www-form-urlencoded',
                            'Content-Length: ' . strlen($fdata)
                        ];
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                        $translated_temp = curl_exec($ch);
                        if($translated_temp === false)
                        {
                            throw new Exception('Failed to post to Deepl: ' . curl_error($ch));
                        }
                        curl_close($ch);
                    }
                    $trans_json = json_decode($translated_temp, true);
                    if($trans_json === false)
                    {
                        throw new Exception('Incorrect multipart response from Deepl: ' . $translated_temp);
                    }
                    if(!isset($trans_json['translations'][0]['text']))
                    {
                        throw new Exception('Unrecognized multipart response from Deepl: ' . $translated_temp);
                    }
                    $translated .= ' ' . $trans_json['translations'][0]['text'];
                }
            }
            else
            {
                $ch = curl_init('https://api.deepl.com/v2/translate');
                if($ch !== false)
                {
                    $data           = array();
                    $data['text']   = $content;
                    $data['source_lang']   = $from;
                    $data['tag_handling']  = 'xml';
                    $data['non_splitting_tags']  = 'div';
                    $data['preserve_formatting']  = '1';
                    $data['target_lang']   = $to;
                    $data['auth_key']   = trim($contentomatic_Main_Settings['deepl_auth']);
                    $fdata = "";
                    foreach ($data as $key => $val) {
                        $fdata .= "$key=" . urlencode(trim($val)) . "&";
                    }
                    curl_setopt($ch, CURLOPT_POST, 1);
                    $headers = [
                        'Content-Type: application/x-www-form-urlencoded',
                        'Content-Length: ' . strlen($fdata)
                    ];
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                    $translated = curl_exec($ch);
                    if($translated === false)
                    {
                        throw new Exception('Failed to post to Deepl: ' . curl_error($ch));
                    }
                    curl_close($ch);
                }
                $trans_json = json_decode($translated, true);
                if($trans_json === false)
                {
                    throw new Exception('Incorrect text response from Deepl: ' . $translated);
                }
                if(!isset($trans_json['translations'][0]['text']))
                {
                    throw new Exception('Unrecognized text response from Deepl: ' . 'https://api.deepl.com/v2/translate?text=' . urlencode($content) . '&source_lang=' . $from . '&target_lang=' . $to . '&auth_key=' . trim($contentomatic_Main_Settings['deepl_auth']) . '&tag_handling=xml&preserve_formatting=1' . ' --- ' . $translated);
                }
                $translated = $trans_json['translations'][0]['text'];
            }
            $translated = str_replace('<strong>', ' <strong>', $translated);
            $translated = str_replace('</strong>', '</strong> ', $translated);
            $translated_title = contentomatic_get_web_page('https://api.deepl.com/v2/translate?text=' . urlencode($title) . '&source_lang=' . $from . '&target_lang=' . $to . '&auth_key=' . trim($contentomatic_Main_Settings['deepl_auth']) . '&tag_handling=xml&preserve_formatting=1');
            $trans_json = json_decode($translated_title, true);
            if($trans_json === false)
            {
                throw new Exception('Incorrect title response from Deepl: ' . $translated_title);
            }
            if(!isset($trans_json['translations'][0]['text']))
            {
                throw new Exception('Unrecognized title response from Deepl: ' . $translated_title);
            }
            $translated_title = $trans_json['translations'][0]['text'];
        }
        else
        {
            require_once(dirname(__FILE__) . "/res/contentomatic-translator.php");
            $ch = curl_init();
            if ($ch === FALSE) {
                if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
                    contentomatic_log_to_file('Failed to init cURL in translator!');
                }
                return false;
            }
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $GoogleTranslator = new GoogleTranslator($ch);
            if(strlen($content) > 30000)
            {
                $translated = '';
                while($content != '')
                {
                    $first30k = substr($content, 0, 30000);
                    $content = substr($content, 30000);
                    $translated_temp       = $GoogleTranslator->translateText($first30k, $from, $to);
                    if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                        throw new Exception('Page content already in ' . $to);
                    }
                    if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                        throw new Exception('Unexpected error while translating page!');
                    }
                    if(substr_compare($translated_temp, '</pre>', -strlen('</pre>')) === 0){$translated_temp = substr_replace($translated_temp ,"", -6);}if(substr( $translated_temp, 0, 5 ) === "<pre>"){$translated_temp = substr($translated_temp, 5);}
                    $translated .= ' ' . $translated_temp;
                }
            }
            else
            {
                $translated       = $GoogleTranslator->translateText($content, $from, $to);
                if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                    throw new Exception('Page content already in ' . $to);
                }
                if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                    throw new Exception('Unexpected error while translating page!');
                }
            }
            $translated_title = $GoogleTranslator->translateText($title, $from, $to);
            if (strpos($translated_title, '<h2>The page you have attempted to translate is already in ') !== false) {
                throw new Exception('Page title already in ' . $to);
            }
            if (strpos($translated_title, 'Error 400 (Bad Request)!!1') !== false) {
                throw new Exception('Unexpected error while translating page title!');
            }
            curl_close($ch);
        }
    }
    catch (Exception $e) {
        if($ch !== false)
        {
            curl_close($ch);
        }
        if (isset($contentomatic_Main_Settings['enable_detailed_logging'])) {
            contentomatic_log_to_file('Exception thrown in Translator ' . $e);
        }
        return false;
    }
    if(substr_compare($translated_title, '</pre>', -strlen('</pre>')) === 0){$title = substr_replace($translated_title ,"", -6);}else{$title = $translated_title;}if(substr( $title, 0, 5 ) === "<pre>"){$title = substr($title, 5);}
    if(substr_compare($translated, '</pre>', -strlen('</pre>')) === 0){$text = substr_replace($translated ,"", -6);}else{$text = $translated;}if(substr( $text, 0, 5 ) === "<pre>"){$text = substr($text, 5);}
    $text  = preg_replace('/' . preg_quote('html lang=') . '.*?' . preg_quote('>') . '/', '', $text);
    $text  = preg_replace('/' . preg_quote('!DOCTYPE') . '.*?' . preg_quote('<') . '/', '', $text);
    $text = str_replace('%% item_cat %%', '%%item_cat%%', $text);
    $text = str_replace('%% item_tags %%', '%%item_tags%%', $text);
    $text = str_replace('%% item_url %%', '%%item_url%%', $text);
    $text = str_replace('%% item_image_URL %%', '%%item_image_URL%%', $text);
    $text = str_replace('%% custom_html2 %%', '%%custom_html2%%', $text);
    $text = str_replace('%% custom_html %%', '%%custom_html%%', $text);
    $text = str_replace('%% random_sentence %%', '%%random_sentence%%', $text);
    $text = str_replace('%% random_sentence2 %%', '%%random_sentence2%%', $text);
    $text = str_replace('%% item_title %%', '%%item_title%%', $text);
    $text = str_replace('%% item_content %%', '%%item_content%%', $text);
    $text = str_replace('%% item_original_content %%', '%%item_original_content%%', $text);
    $text = str_replace('%% item_content_plain_text %%', '%%item_content_plain_text%%', $text);
    $text = str_replace('%% item_description %%', '%%item_description%%', $text);
    $text = str_replace('%% author %%', '%%author%%', $text);
    $text = str_replace('%% item_media %%', '%%item_media%%', $text);
    $text = str_replace('%% item_date %%', '%%item_date%%', $text);
    $text = str_replace('&amp; # 039;', '\'', $text);
    $text = str_replace('&amp; ldquo;', '"', $text);
    $text = str_replace('&amp; rdquo;', '"', $text);
    $text = str_replace(' \' ', '\'', $text);
    $text = preg_replace('{<iframe src="https://translate.google.com/translate(?:.*?)></iframe>}i', "", html_entity_decode($text, ENT_QUOTES));
    $text = preg_replace('{<span class="google-src-text.*?>.*?</span>}', "", $text);
    $text = preg_replace('{<span class="notranslate.*?>(.*?)</span>}', "$1", $text);
    $title = str_replace('%% random_sentence %%', '%%random_sentence%%', $title);
    $title = str_replace('%% random_sentence2 %%', '%%random_sentence2%%', $title);
    $title = str_replace('%% item_title %%', '%%item_title%%', $title);
    $title = str_replace('%% item_description %%', '%%item_description%%', $title);
    $title = str_replace('%% item_url %%', '%%item_url%%', $title);
    $title = str_replace('%% item_date %%', '%%item_date%%', $title);
    $title = str_replace('%% author %%', '%%author%%', $title);
    $title = str_replace('%% item_cat %%', '%%item_cat%%', $title);
    $title = str_replace('%% item_tags %%', '%%item_tags%%', $title);
    $title = str_replace('&amp; # 039;', '\'', $title);
    $title = str_replace('&amp; ldquo;', '"', $title);
    $title = str_replace('&amp; rdquo;', '"', $title);
    $title = str_replace(' \' ', '\'', $title);

    return array(
        $title,
        $text
    );
}

function contentomatic_strip_html_tags($str)
{
    $str = html_entity_decode($str);
    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
    $str = preg_replace(array(
        '@<head[^>]*?>.*?</head>@siu',
        '@<style[^>]*?>.*?</style>@siu',
        '@<script[^>]*?.*?</script>@siu',
        '@<noscript[^>]*?.*?</noscript>@siu'
    ), "", $str);
    $str = strip_tags($str);
    return $str;
}

function contentomatic_DOMinnerHTML(DOMNode $element)
{
    $innerHTML = "";
    $children  = $element->childNodes;
    
    foreach ($children as $child) {
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }
    
    return $innerHTML;
}

function contentomatic_url_exists($url)
{
    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);
    $headers = get_headers($url);
    if (!isset($headers[0]) || strpos($headers[0], '200') === false)
        return false;
    return true;
}

register_activation_hook(__FILE__, 'contentomatic_check_version');
function contentomatic_check_version()
{
    if (!function_exists('curl_init')) {
        echo '<h3>'.esc_html__('Please enable curl PHP extension. Please contact your hosting provider\'s support to help you in this matter.', 'contentomatic-article-builder-post-generator').'</h3>';
        die;
    }
    global $wp_version;
    if (!current_user_can('activate_plugins')) {
        echo '<p>' . esc_html__('You are not allowed to activate plugins!', 'contentomatic-article-builder-post-generator') . '</p>';
        die;
    }
    $php_version_required = '5.6';
    $wp_version_required  = '2.7';
    
    if (version_compare(PHP_VERSION, $php_version_required, '<')) {
        deactivate_plugins(basename(__FILE__));
        echo '<p>' . sprintf(esc_html__('This plugin can not be activated because it requires a PHP version greater than %1$s. Please update your PHP version before you activate it.', 'contentomatic-article-builder-post-generator'), $php_version_required) . '</p>';
        die;
    }
    
    if (version_compare($wp_version, $wp_version_required, '<')) {
        deactivate_plugins(basename(__FILE__));
        echo '<p>' . sprintf(esc_html__('This plugin can not be activated because it requires a WordPress version greater than %1$s. Please go to Dashboard -> Updates to get the latest version of WordPress.', 'contentomatic-article-builder-post-generator'), $wp_version_required) . '</p>';
        die;
    }
}

function contentomatic_register_mysettings()
{
    contentomatic_cron_schedule();
    register_setting('contentomatic_option_group', 'contentomatic_Main_Settings');
    if (is_multisite()) {
        if (!get_option('contentomatic_Main_Settings')) {
            contentomatic_activation_callback(TRUE);
        }
    }
}

function contentomatic_get_plugin_url()
{
    return plugins_url('', __FILE__);
}

function contentomatic_get_file_url($url)
{
    return esc_url(contentomatic_get_plugin_url() . '/' . $url);
}

function contentomatic_admin_load_files()
{
    wp_register_style('contentomatic-browser-style', plugins_url('styles/contentomatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('contentomatic-browser-style');
    wp_register_style('contentomatic-custom-style', plugins_url('styles/coderevolution-style.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('contentomatic-custom-style');
    wp_enqueue_script('jquery');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    $rating_th = get_option('contentomatic_rating_trigger', false);
    if($rating_th === '1')
    {
        wp_enqueue_script( 'contentomatic-rate-notice-js', plugins_url("js/rating.js", __FILE__));
        add_action( 'admin_notices', 'contentomatic_five_star_wp_rate_notice');
    }
}
add_action('wp_ajax_contentomatic-five-star-wp-rate', 'contentomatic_rate_clicked');
function contentomatic_rate_clicked()
{
    update_option('contentomatic_rating_trigger', '2');
    die();
}
function contentomatic_five_star_wp_rate_notice()
{
?>
<div class="notice notice-success is-dismissible contentomatic-five-star-wp-rate-action">
<div>
	<?php echo sprintf( wp_kses( __( 'Hey, I noticed you created quite a lot of posts using the Contentomatic plugin - that\'s really awesome! Could you please do me a BIG favor and give it <b><a href=\'%s\' target=\'_blank\'>a 5-star rating on CodeCanyon</a></b>? Just to help us spread the word and boost our motivation. Thank you!', 'contentomatic-article-builder-post-generator'), array(  'b' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url('//codecanyon.net/user/coderevolution/portfolio') ); ?>
	<br/>
	<strong><em>Szabi Kisded - CodeRevolution</em></strong>
</div>
<ul>
	<li><a
	       href="//codecanyon.net/downloads" target="_blank"><?php echo esc_html__('Yes, you deserve it!', 'contentomatic-article-builder-post-generator');?></a>
	</li>
	<li><a href="#"><?php echo esc_html__('I already did.', 'contentomatic-article-builder-post-generator');?></a></li>
	<li><a href="#"><?php echo esc_html__('No, sorry.', 'contentomatic-article-builder-post-generator');?></a></li>
</ul>
</div>
<?php
}

function contentomatic_random_sentence_generator($first = true)
{
    $current_lang = apply_filters( 'wpml_current_language', NULL );
    do_action( 'wpml_switch_language', $current_lang );
    $contentomatic_Main_Settings = get_option('contentomatic_Main_Settings', false);
    if ($first == false) {
        $r_sentences = $contentomatic_Main_Settings['sentence_list2'];
    } else {
        $r_sentences = $contentomatic_Main_Settings['sentence_list'];
    }
    $r_variables = $contentomatic_Main_Settings['variable_list'];
    $r_sentences = trim($r_sentences);
    $r_variables = trim($r_variables, ';');
    $r_variables = trim($r_variables);
    $r_sentences = str_replace("\r\n", "\n", $r_sentences);
    $r_sentences = str_replace("\r", "\n", $r_sentences);
    $r_sentences = explode("\n", $r_sentences);
    $r_variables = str_replace("\r\n", "\n", $r_variables);
    $r_variables = str_replace("\r", "\n", $r_variables);
    $r_variables = explode("\n", $r_variables);
    $r_vars      = array();
    for ($x = 0; $x < count($r_variables); $x++) {
        $var = explode("=>", trim($r_variables[$x]));
        if (isset($var[1])) {
            $key          = strtolower(trim($var[0]));
            $words        = explode(";", trim($var[1]));
            $r_vars[$key] = $words;
        }
    }
    $max_s    = count($r_sentences) - 1;
    $rand_s   = rand(0, $max_s);
    $sentence = $r_sentences[$rand_s];
    $sentence = str_replace(' ,', ',', ucfirst(contentomatic_replace_words($sentence, $r_vars)));
    $sentence = str_replace(' .', '.', $sentence);
    $sentence = str_replace(' !', '!', $sentence);
    $sentence = str_replace(' ?', '?', $sentence);
    $sentence = trim($sentence);
    return $sentence;
}

function contentomatic_get_word($key, $r_vars)
{
    if (isset($r_vars[$key])) {
        
        $words  = $r_vars[$key];
        $w_max  = count($words) - 1;
        $w_rand = rand(0, $w_max);
        return contentomatic_replace_words(trim($words[$w_rand]), $r_vars);
    } else {
        return "";
    }
    
}

function contentomatic_replace_words($sentence, $r_vars)
{
    
    if (str_replace('%', '', $sentence) == $sentence)
        return $sentence;
    
    $words = explode(" ", $sentence);
    
    $new_sentence = array();
    for ($w = 0; $w < count($words); $w++) {
        
        $word = trim($words[$w]);
        
        if ($word != '') {
            if (preg_match('/^%([^%\n]*)$/', $word, $m)) {
                $varkey         = trim($m[1]);
                $new_sentence[] = contentomatic_get_word($varkey, $r_vars);
            } else {
                $new_sentence[] = $word;
            }
        }
    }
    return implode(" ", $new_sentence);
}

function contentomatic_fetch_url($url){
    $url = "https://translate.google.com/translate?hl=en&ie=UTF8&prev=_t&sl=ar&tl=en&u=".urlencode($url);
    $exec = contentomatic_get_web_page($url);
    if($exec === false)
    {
        return false;
    }
	preg_match('{(https://translate.googleusercontent.com.*?)"}', $exec, $get_urls);
	$get_url = $get_urls[1];
	if(!stristr($get_url, '_p')){
		return false;
    }
    $exec = contentomatic_get_web_page($get_url);
    if($exec === false)
    {
        return false;
    }
	preg_match('{URL=(.*?)"}', $exec ,$final_url);
	$get_url2 = html_entity_decode( $final_url[1] );
	if(!stristr($get_url2, '_c')){
		return false;
	}
    $exec = contentomatic_get_web_page($get_url2);
	if(trim($exec) == ''){
		return false;
    }
    $exec = str_replace('id=article-content"', 'id="article-content"', $exec);
    $exec = str_replace('article-content>','article-content">',$exec);
	$exec = preg_replace('{<span class="google-src-text.*?>.*?</span>}', "", $exec);
    $exec = preg_replace('{<span class="notranslate.*?>(.*?)</span>}', "$1", $exec);
    
    return $exec;
}

class Contentomatic_keywords{ 
    public static $charset = 'UTF-8';
    public static $banned_words = array('adsbygoogle', 'able', 'about', 'above', 'act', 'add', 'afraid', 'after', 'again', 'against', 'age', 'ago', 'agree', 'all', 'almost', 'alone', 'along', 'already', 'also', 'although', 'always', 'am', 'amount', 'an', 'and', 'anger', 'angry', 'animal', 'another', 'answer', 'any', 'appear', 'apple', 'are', 'arrive', 'arm', 'arms', 'around', 'arrive', 'as', 'ask', 'at', 'attempt', 'aunt', 'away', 'back', 'bad', 'bag', 'bay', 'be', 'became', 'because', 'become', 'been', 'before', 'began', 'begin', 'behind', 'being', 'bell', 'belong', 'below', 'beside', 'best', 'better', 'between', 'beyond', 'big', 'body', 'bone', 'born', 'borrow', 'both', 'bottom', 'box', 'boy', 'break', 'bring', 'brought', 'bug', 'built', 'busy', 'but', 'buy', 'by', 'call', 'came', 'can', 'cause', 'choose', 'close', 'close', 'consider', 'come', 'consider', 'considerable', 'contain', 'continue', 'could', 'cry', 'cut', 'dare', 'dark', 'deal', 'dear', 'decide', 'deep', 'did', 'die', 'do', 'does', 'dog', 'done', 'doubt', 'down', 'during', 'each', 'ear', 'early', 'eat', 'effort', 'either', 'else', 'end', 'enjoy', 'enough', 'enter', 'even', 'ever', 'every', 'except', 'expect', 'explain', 'fail', 'fall', 'far', 'fat', 'favor', 'fear', 'feel', 'feet', 'fell', 'felt', 'few', 'fill', 'find', 'fit', 'fly', 'follow', 'for', 'forever', 'forget', 'from', 'front', 'gave', 'get', 'gives', 'goes', 'gone', 'good', 'got', 'gray', 'great', 'green', 'grew', 'grow', 'guess', 'had', 'half', 'hang', 'happen', 'has', 'hat', 'have', 'he', 'hear', 'heard', 'held', 'hello', 'help', 'her', 'here', 'hers', 'high', 'hill', 'him', 'his', 'hit', 'hold', 'hot', 'how', 'however', 'I', 'if', 'ill', 'in', 'indeed', 'instead', 'into', 'iron', 'is', 'it', 'its', 'just', 'keep', 'kept', 'knew', 'know', 'known', 'late', 'least', 'led', 'left', 'lend', 'less', 'let', 'like', 'likely', 'likr', 'lone', 'long', 'look', 'lot', 'make', 'many', 'may', 'me', 'mean', 'met', 'might', 'mile', 'mine', 'moon', 'more', 'most', 'move', 'much', 'must', 'my', 'near', 'nearly', 'necessary', 'neither', 'never', 'next', 'no', 'none', 'nor', 'not', 'note', 'nothing', 'now', 'number', 'of', 'off', 'often', 'oh', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'out', 'please', 'prepare', 'probable', 'pull', 'pure', 'push', 'put', 'raise', 'ran', 'rather', 'reach', 'realize', 'reply', 'require', 'rest', 'run', 'said', 'same', 'sat', 'saw', 'say', 'see', 'seem', 'seen', 'self', 'sell', 'sent', 'separate', 'set', 'shall', 'she', 'should', 'side', 'sign', 'since', 'so', 'sold', 'some', 'soon', 'sorry', 'stay', 'step', 'stick', 'still', 'stood', 'such', 'sudden', 'suppose', 'take', 'taken', 'talk', 'tall', 'tell', 'ten', 'than', 'thank', 'that', 'the', 'their', 'them', 'then', 'there', 'therefore', 'these', 'they', 'this', 'those', 'though', 'through', 'till', 'to', 'today', 'told', 'tomorrow', 'too', 'took', 'tore', 'tought', 'toward', 'tried', 'tries', 'trust', 'try', 'turn', 'two', 'under', 'until', 'up', 'upon', 'us', 'use', 'usual', 'various', 'verb', 'very', 'visit', 'want', 'was', 'we', 'well', 'went', 'were', 'what', 'when', 'where', 'whether', 'which', 'while', 'white', 'who', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'yes', 'yet', 'you', 'young', 'your', 'br', 'img', 'p','lt', 'gt', 'quot', 'copy');
    public static $min_word_length = 4;
    
    public static function text($text, $length = 160)
    {
        return self::limit_chars(self::clean($text), $length,'',TRUE);
    } 

    public static function keywords($text, $max_keys = 3)
    {
        $wordcount = array_count_values(str_word_count(self::clean($text),1));
        foreach ($wordcount as $key => $value) 
        {
            if ( (strlen($key)<= self::$min_word_length) OR in_array($key, self::$banned_words))
                unset($wordcount[$key]);
        }
        uasort($wordcount,array('self','cmp'));
        $wordcount = array_slice($wordcount,0, $max_keys);
        return implode(' ', array_keys($wordcount));
    } 

    private static function clean($text)
    { 
        $text = html_entity_decode($text,ENT_QUOTES,self::$charset);
        $text = strip_tags($text);
        $text = preg_replace('/\s\s+/', ' ', $text);
        $text = str_replace (array('\r\n', '\n', '+'), ',', $text);
        return trim($text); 
    } 

    private static function cmp($a, $b) 
    {
        if ($a == $b) return 0; 

        return ($a < $b) ? 1 : -1; 
    } 

    private static function limit_chars($str, $limit = 100, $end_char = NULL, $preserve_words = FALSE)
    {
        $end_char = ($end_char === NULL) ? '&#8230;' : $end_char;
        $limit = (int) $limit;
        if (trim($str) === '' OR strlen($str) <= $limit)
            return $str;
        if ($limit <= 0)
            return $end_char;
        if ($preserve_words === FALSE)
            return rtrim(substr($str, 0, $limit)).$end_char;
        if ( ! preg_match('/^.{0,'.$limit.'}\s/us', $str, $matches))
            return $end_char;
        return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
    }
} 
class Contentomatic_Spintax
{
    public function process($text)
    {
        return stripslashes(preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
            array($this, 'replace'),
            preg_quote($text)
        ));
    }
    public function replace($text)
    {
        $text = $this->process($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }
}

?>