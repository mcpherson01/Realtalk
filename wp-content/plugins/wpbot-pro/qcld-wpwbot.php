<?php
/**
 * Plugin Name: WPBot Pro Wordpress Chatbot
 * Plugin URI: https://wordpress.org/plugins/wpbot-wordpress-chatbot/
 * Description: Wordpress Chatbot by QuantumCloud.
 * Donate link: http://www.quantumcloud.com
 * Version: 9.4.3
 * @author    QuantumCloud
 * Author: QunatumCloud
 * Author URI: https://www.quantumcloud.com/
 * Requires at least: 4.6
 * Tested up to: 5.3
 * Text Domain: wpchatbot
 * Domain Path: /languages
 * License: GPL2
 */

if(!class_exists('qcld_wb_Chatbot')){
if (!defined('ABSPATH')) exit; // Exit if accessed directly
define('QCLD_wpCHATBOT_VERSION', '9.4.3');
define('QCLD_wpCHATBOT_REQUIRED_wpCOMMERCE_VERSION', 2.2);
define('QCLD_wpCHATBOT_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('QCLD_wpCHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('QCLD_wpCHATBOT_IMG_URL', QCLD_wpCHATBOT_PLUGIN_URL . "images/");
define('QCLD_wpCHATBOT_IMG_ABSOLUTE_PATH', plugin_dir_path(__FILE__) . "images");
define('QCLD_wpCHATBOT_INDEX_TABLE', 'wpwbot_index');

$gcdirpath = __DIR__.'/../../wpbot-dfv2-client';
define('QCLD_wpCHATBOT_GC_DIRNAME', $gcdirpath);
$wpcontentpath = __DIR__.'/../../';
define('QCLD_wpCHATBOT_GC_ROOT', $wpcontentpath);


require_once("qcld-wpwbot-search.php");
require_once("qc-support-promo-page/class-qc-support-promo-page.php");
require_once('plugin-upgrader/plugin-upgrader.php');
require_once("functions.php");
require_once('qcld_df_api.php');
require_once('qcld-df-webhook.php');
require_once('includes/class-wpbot-gc-download.php');

/**
 * Main Class.
 */
class qcld_wb_Chatbot
{
    private $id = 'wpbot';
    private static $instance;
    /**
     *  Get Instance creates a singleton class that's cached to stop duplicate instances
     */
    public static function qcld_wb_chatbot_get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->qcld_wb_chatbot_init();
        }
        return self::$instance;
    }
    /**
     *  Construct empty on purpose
     */
    private function __construct()
    {
    }
    /**
     *  Init behaves like, and replaces, construct
     */
    public function qcld_wb_chatbot_init()
    {
        // Check if wpCommerce is active, and is required wpCommerce version.

        add_action('admin_menu', array($this, 'qcld_wb_chatbot_admin_menu'));
        if ((!empty($_GET["page"])) && ($_GET["page"] == "wpbot")) {
            add_action('admin_init', array($this, 'qcld_wb_chatbot_save_options'));
        }
        if (is_admin() && !empty($_GET["page"]) && ($_GET["page"] == "wpbot")) {
            add_action('admin_enqueue_scripts', array($this, 'qcld_wb_chatbot_admin_scripts'));
            if( get_option('wp_chatbot_index_count')<=0 && get_option('qlcd_wp_chatbot_search_option')=='advanced'){
                add_action( 'admin_notices', array( $this, 'admin_notice_reindex' ) );
            }
        }
		if (is_admin() && !empty($_GET["page"]) && ($_GET["page"] == "email-subscription" || $_GET["page"] == "wbca-chat-history" || $_GET["page"] == "wbcs-botsessions-page"  || $_GET["page"] == "chatbot-crawl-page-list" || $_GET["page"] == "stop-word" || $_GET["page"] == "wpbot-panel" || $_GET["page"] == "wpwc-settings-page")) {
            add_action('admin_enqueue_scripts', array($this, 'qcld_wb_chatbot_admin_scripts'));
        }
        if (!is_admin() && get_option('disable_wp_chatbot')!=1) {
            add_action('wp_enqueue_scripts', array($this, 'qcld_wb_chatbot_frontend_scripts'));
        }

    }
    /**
     * Add a submenu item to the wpCommerce menu
     */
    public function qcld_wb_chatbot_admin_menu()
    {

        add_menu_page( wpbot_menu_text(), wpbot_menu_text(), 'manage_options','wpbot-panel', array($this, 'qcld_wb_chatbot_admin_page'),'dashicons-format-status', 6 );
		
        add_submenu_page( 'wpbot-panel', 'Settings', 'Settings', 'manage_options','wpbot', array($this, 'qcld_wb_chatbot_admin_page_settings') );

        add_submenu_page( 'wpbot-panel', 'User Data', 'User Data', 'manage_options','email-subscription', array($this, 'qcld_wb_chatbot_admin_page1') );


        add_submenu_page( 'wpbot-panel', 'Stop Words', 'Stop Words', 'manage_options','stop-word', array($this, 'qcld_wb_chatbot_admin_stop_word') );


        
        if(!qcld_wpbot_is_active_white_label()){
            add_submenu_page( 'wpbot-panel', 'Support', 'Support', 'manage_options','wpbot_support_page', 'qcpromo_support_page_callback_func' );
        }
        
        add_submenu_page( 'wpbot-panel', 'Help & License', 'Help & License', 'manage_options','wpbot_license_page', 'wpbot_License_page_callback_func' );
        
    }
	
	public function qcld_wb_chatbot_admin_page1(){
		require_once("includes/email_subscription.php");
    }
    
    public function qcld_wb_chatbot_admin_stop_word(){

        $msg = '';

        if (isset($_POST["qlcd_wp_chatbot_stop_words_name"])) {
            $qlcd_wp_chatbot_stop_words_name = $_POST["qlcd_wp_chatbot_stop_words_name"];
            update_option('qlcd_wp_chatbot_stop_words_name', sanitize_text_field($qlcd_wp_chatbot_stop_words_name));
        }
        if (isset($_POST["qlcd_wp_chatbot_stop_words"])) {
            $qlcd_wp_chatbot_stop_words = $_POST["qlcd_wp_chatbot_stop_words"];
            update_option('qlcd_wp_chatbot_stop_words', sanitize_text_field($qlcd_wp_chatbot_stop_words));
            $msg = 'Stop Words has been saved successfully';
        }

        require_once("includes/stop-word.php");
    }
	
    /**
     * Include admin scripts
     */
    public function qcld_wb_chatbot_admin_scripts($hook)
    {
        global $woocommerce, $wp_scripts;
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        if (((!empty($_GET["page"])) && ($_GET["page"] == "wpbot")) || ($hook == "widgets.php") || ($_GET["page"] == "stop-word") || ($_GET["page"] == "wpbot-panel") || ($_GET["page"] == "wpwc-settings-page")) {
            wp_enqueue_script('jquery');
            
            wp_register_style('qlcd-wp-chatbot-admin-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/admin-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-admin-style');
            wp_register_style('qlcd-wp-chatbot-font-awe', QCLD_wpCHATBOT_PLUGIN_URL . 'css/font-awesome.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-font-awe');
            wp_register_style('qlcd-wp-chatbot-tabs-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/wp-chatbot-tabs.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-tabs-style');
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_style( 'wp-color-picker');
            wp_enqueue_script( 'wp-color-picker');
            wp_enqueue_script( 'jquery-ui-sortable');
            wp_register_script('qcld-wp-chatbot-qcFWTabs', QCLD_wpCHATBOT_PLUGIN_URL . 'js/cbpFWTabs.js', array(), true);
            wp_enqueue_script('qcld-wp-chatbot-qcFWTabs');
            wp_register_script('qcld-wp-chatbot-modernizrqc-custc', QCLD_wpCHATBOT_PLUGIN_URL . 'js/modernizr.custom.js', array(), true);

            $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 7 days'));
            if($date < date('Y-m-d')){
                $wp_chatbot_obj = array(
                    'wp_qc_img_check'=> true
                );
            }else{
                $wp_chatbot_obj = array(
                    'wp_qc_img_check'=> false
                );
            }

            wp_enqueue_script('qcld-wp-chatbot-modernizrqc-custc');
            wp_localize_script('qcld-wp-chatbot-modernizrqc-custc', 'wp_chatbot_obj', $wp_chatbot_obj);

            wp_register_script('qcld-wp-chatbot-bootcampqc-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/bootstrap.js', array('jquery'), true);
            wp_enqueue_script('qcld-wp-chatbot-bootcampqc-js');
            wp_register_style('qcld-wp-chatbot-bootcampqc-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/bootstrap.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-bootcampqc-css');
            //jquery time picker
            wp_register_script('qcld-wp-chatbot-qcpickertm-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.timepicker.js', array('jquery'), true);
            wp_enqueue_script('qcld-wp-chatbot-qcpickertm-js');
            wp_register_style('qcld-wp-chatbot-qcpickertm-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/jquery.timepicker.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-qcpickertm-css');
            wp_register_script('qcld-wp-chatbot-admin-js', QCLD_wpCHATBOT_PLUGIN_URL . '/js/qcld-wp-chatbot-admin.js', array('jquery', 'jquery-ui-core','jquery-ui-sortable','wp-color-picker','qcld-wp-chatbot-qcpickertm-js'), true);
            wp_enqueue_script('qcld-wp-chatbot-admin-js');
            wp_localize_script('qcld-wp-chatbot-admin-js', 'ajax_object',
                array('ajax_url' => admin_url('admin-ajax.php'),'image_path' => QCLD_wpCHATBOT_IMG_URL, 'intents' => qc_get_all_intents()));
            // WordPress  Media library
            wp_enqueue_media();
        }
		
		wp_register_style('qlcd-wp-chatbot-admin-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/admin-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-admin-style');
		
    }
    
    public function qcld_wb_chatbot_frontend_scripts()
    {
		
        global $woocommerce, $wp_scripts, $post, $current_user;
		
		
        $display_name = '';
        $user_image = get_option('wp_custom_client_icon');
		if ( is_user_logged_in() ) { 
            $display_name = $current_user->display_name;
            $user_image = esc_url( get_avatar_url( $current_user->ID ) );
		}
		
		$flag = false;
		if(strpos($post->post_content, '[wpbot-skip-gretting]' ) !== false){
			$flag = true;
        }
        
        $data = get_option('wbca_options');
		
        $wp_chatbot_obj = array(
            'wp_chatbot_position_x' => get_option('wp_chatbot_position_x'),
            'wp_chatbot_position_y' => get_option('wp_chatbot_position_y'),
            'wp_chatbot_position_in' => get_option('wp_chatbot_position_in'),
            'disable_icon_animation' => get_option('disable_wp_chatbot_icon_animation'),
            'disable_wp_chatbot_history' => get_option('disable_wp_chatbot_history'),
            'disable_featured_product' => get_option('disable_wp_chatbot_featured_product'),
            'disable_product_search' => get_option('disable_wp_chatbot_product_search'),
            'disable_catalog' => get_option('disable_wp_chatbot_catalog'),
            'skip_wp_greetings' => ($flag==true?1:get_option('skip_wp_greetings')),
            'show_menu_after_greetings'=> (get_option('show_menu_after_greetings')!=''?get_option('show_menu_after_greetings'):0),
            'disable_first_msg' => get_option('disable_first_msg'),
            'ask_email_wp_greetings' => get_option('ask_email_wp_greetings'),
            'ask_phone_wp_greetings' => get_option('ask_phone_wp_greetings'),
            'enable_wp_chatbot_open_initial' => get_option('enable_wp_chatbot_open_initial'),
            'disable_order_status' => get_option('disable_wp_chatbot_order_status'),
            'disable_sale_product' => get_option('disable_wp_chatbot_sale_product'),
            'open_product_detail' => get_option('wp_chatbot_open_product_detail'),
            'order_user' => get_option('qlcd_wp_chatbot_order_user'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'image_path' => QCLD_wpCHATBOT_IMG_URL,
            'client_image'=> $user_image,
            'yes' => str_replace('\\', '',get_option('qlcd_wp_chatbot_yes')),
            'no' => str_replace('\\', '',get_option('qlcd_wp_chatbot_no')),
            'or' => str_replace('\\', '',get_option('qlcd_wp_chatbot_or')),
            'host' => str_replace('\\', '',get_option('qlcd_wp_chatbot_host')),
            'agent' => str_replace('\\', '',get_option('qlcd_wp_chatbot_agent')),
            'agent_image' => get_option('wp_chatbot_agent_image'),
            'agent_image_path' => $this->qcld_wb_chatbot_agent_icon(),
            'shopper_demo_name' => str_replace('\\', '',get_option('qlcd_wp_chatbot_shopper_demo_name')),
            'shopper_call_you' => str_replace('\\', '',get_option('qlcd_wp_chatbot_shopper_call_you')),
            'agent_join' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_agent_join'))),
            'welcome' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_welcome'))),
            'welcome_back' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_welcome_back'))),
            'hi_there' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_hi_there'))),
            'asking_name' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_asking_name'))),
            'asking_emailaddress' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_asking_emailaddress'))),
            'got_email' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_got_email'))),
            'email_ignore' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_email_ignore'))),

            'asking_phone_gt' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_asking_phone_gt'))),
            'got_phone' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_got_phone'))),
            'phone_ignore' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_phone_ignore'))),

            'i_am' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_i_am'))),
            'name_greeting' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_name_greeting'))),
            'wildcard_msg' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_wildcard_msg'))),
            'empty_filter_msg' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_empty_filter_msg'))),
            'do_you_want_to_subscribe' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('do_you_want_to_subscribe'))),
            'do_you_want_to_unsubscribe' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('do_you_want_to_unsubscribe'))),
            'we_do_not_have_your_email' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('we_do_not_have_your_email'))),
            'you_have_successfully_unsubscribe' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('you_have_successfully_unsubscribe'))),
            'is_typing' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_is_typing'))),
            'send_a_msg' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_send_a_msg'))),
            'viewed_products' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_viewed_products'))),
            'shopping_cart' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_shopping_cart'))),
            'cart_updating' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_cart_updating'))),
            'cart_removing' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_cart_removing'))),
            'sys_key_help' => get_option('qlcd_wp_chatbot_sys_key_help'),
            'sys_key_product' => get_option('qlcd_wp_chatbot_sys_key_product'),
            'auto_hide_floating_button' => get_option('qc_auto_hide_floating_button'),
            
            'sys_key_catalog' => get_option('qlcd_wp_chatbot_sys_key_catalog'),
            'sys_key_order' => get_option('qlcd_wp_chatbot_sys_key_order'),
            'sys_key_support' => get_option('qlcd_wp_chatbot_sys_key_support'),
            'sys_key_reset' => get_option('qlcd_wp_chatbot_sys_key_reset'),
            'sys_key_livechat' => (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'),
            'help_welcome' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_help_welcome'))),
            'back_to_start' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_back_to_start'))),
            'help_msg' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_help_msg'))),
            'reset' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_reset'))),
            'wildcard_product' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_wildcard_product'))),
            'wildcard_catalog' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_wildcard_catalog'))),
            'featured_products' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_featured_products'))),
            'sale_products' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_sale_products'))),
            'wildcard_order' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_wildcard_order'))),
            'wildcard_support' => get_option('qlcd_wp_chatbot_wildcard_support'),
            'product_asking' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_product_asking'))),
            'product_suggest' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_product_suggest'))),
            'product_infinite' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_product_infinite'))),
            'product_success' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_product_success'))),
            'product_fail' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_product_fail'))),
            'support_welcome' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_support_welcome'))),
			'typing_animation' => (get_option('wp_custom_typing_icon')?get_option('wp_custom_typing_icon'):''),
            'site_search' => get_option('qlcd_wp_site_search'),
            'livechat_label' => (isset($data['qlcd_wp_livechat']) && $data['qlcd_wp_livechat']!=''?$data['qlcd_wp_livechat']:'Livechat'),
            'email_subscription' => get_option('qlcd_wp_email_subscription'),
            'unsubscribe' => get_option('qlcd_wp_email_unsubscription'),
            'send_us_email' => get_option('qlcd_wp_send_us_email'),
            'leave_feedback' => get_option('qlcd_wp_leave_feedback'),
            'livechat' => get_option('enable_wp_custom_intent_livechat_button'),
			
            'support_email' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_support_email'))),
            'support_option_again' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_support_option_again'))),
            'asking_email' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_asking_email'))),
            'asking_search_keyword' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_search_keyword'))),
            'asking_msg' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_asking_msg'))),
            'support_phone' => get_option('qlcd_wp_chatbot_support_phone'),
            'asking_phone' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_asking_phone'))),
            'thank_for_phone' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_thank_for_phone'))),
            'support_query' =>$this->qcld_wb_chatbot_str_replace(unserialize( get_option('support_query'))),
			
            'custom_intent' =>$this->qcld_wb_chatbot_str_replace(unserialize( get_option('qlcd_wp_custon_intent'))),
            'custom_intent_label' =>$this->qcld_wb_chatbot_str_replace(unserialize( get_option('qlcd_wp_custon_intent_label'))),
            'custom_intent_email' =>$this->qcld_wb_chatbot_str_replace(unserialize( get_option('qlcd_wp_custon_intent_checkbox'))),

            'custom_menu' =>$this->qcld_wb_chatbot_str_replace(unserialize( get_option('qlcd_wp_custon_menu'))),
            'custom_menu_link' =>$this->qcld_wb_chatbot_str_replace(unserialize( get_option('qlcd_wp_custon_menu_link'))),
            'custom_menu_target' =>$this->qcld_wb_chatbot_str_replace(unserialize( get_option('qlcd_wp_custon_menu_checkbox'))),
			
            'support_ans' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('support_ans'))),
            'notification_interval' => get_option('qlcd_wp_chatbot_notification_interval'),
            'notifications' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications'))),
            'notification_intents' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications_intent'))),  
            
            'order_welcome' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_order_welcome'))),
            'order_username_asking' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_order_username_asking'))),
            'order_username_password' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_order_username_password'))),
            'order_user' => $display_name,
            'order_login' => is_user_logged_in(),
            'order_nonce' => wp_create_nonce("wpwbot-order-nonce"),
            'order_email_support' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_order_email_support'))),
            'email_fail' => str_replace('\\', '', get_option('qlcd_wp_chatbot_email_fail')),
            'invalid_email' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_invalid_email'))),
            'stop_words' => $this->qcld_get_stopwords(),
            
            'enable_messenger' => get_option('enable_wp_chatbot_messenger'),
            'messenger_label' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_messenger_label'))),
            'fb_page_id' => get_option('qlcd_wp_chatbot_fb_page_id'),
            'enable_skype' => get_option('enable_wp_chatbot_skype'),
            'enable_whats' => get_option('enable_wp_chatbot_whats'),
            'whats_label' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_whats_label'))),
            'whats_num' => get_option('qlcd_wp_chatbot_whats_num'),
            'ret_greet' => get_option('qlcd_wp_chatbot_ret_greet'),
            'enable_exit_intent' => get_option('enable_wp_chatbot_exit_intent'),
            'exit_intent_msg' => str_replace('\\', '', get_option('wp_chatbot_exit_intent_msg')),
            'exit_intent_custom_intent' => str_replace('\\', '', get_option('wp_chatbot_exit_intent_custom')),
            'exit_intent_bargain_pro_single_page' => get_option('wp_chatbot_exit_intent_bargain_pro_single_page'),
            'exit_intent_bargain_is_product_page' => (function_exists('is_product')?is_product():false),
            'exit_intent_bargain_msg' => str_replace('\\', '', get_option('wp_chatbot_exit_intent_bargain_msg')),
            'exit_intent_email' => str_replace('\\', '', get_option('wp_chatbot_exit_intent_email')),
            'exit_intent_once' => get_option('wp_chatbot_exit_intent_once'),
            'enable_scroll_open' => get_option('enable_wp_chatbot_scroll_open'),
            'scroll_open_msg' => str_replace('\\', '', get_option('wp_chatbot_scroll_open_msg')),
            'scroll_open_custom_intent' => str_replace('\\', '', get_option('wp_chatbot_scroll_open_custom')),
            'scroll_open_email' => str_replace('\\', '', get_option('wp_chatbot_scroll_open_email')),
            'scroll_open_percent' => get_option('wp_chatbot_scroll_percent'),
            'scroll_open_once' => get_option('wp_chatbot_scroll_once'),
            'enable_auto_open' => get_option('enable_wp_chatbot_auto_open'),
            'auto_open_msg' => str_replace('\\', '', get_option('wp_chatbot_auto_open_msg')),
            'auto_open_custom_intent' => str_replace('\\', '', get_option('wp_chatbot_auto_open_custom')),
            'auto_open_email' => str_replace('\\', '', get_option('wp_chatbot_auto_open_email')),
            'auto_open_time' => get_option('wp_chatbot_auto_open_time'),
            'auto_open_once' => get_option('wp_chatbot_auto_open_once'),
            'proactive_bg_color' => get_option('wp_chatbot_proactive_bg_color'),
            'disable_feedback' => get_option('disable_wp_chatbot_feedback'),
            'disable_leave_feedback' => get_option('disable_wp_leave_feedback'),
            'disable_sitesearch' => get_option('disable_wp_chatbot_site_search'),
			'no_result' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_no_result'))),
			'email_subscription_success' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_email_subscription_success'))),
			'email_already_subscribe' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_email_already_subscribe'))),
            'disable_faq' => get_option('disable_wp_chatbot_faq'),
            'disable_email_subscription' => get_option('disable_email_subscription'),
            'disable_livechat' => (isset($data['disable_livechat'])?$data['disable_livechat']:''),
            'feedback_label' =>$this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_feedback_label'))),
            'enable_meta_title' =>get_option('enable_wp_chatbot_meta_title'),
            'meta_label' =>str_replace('\\', '', get_option('qlcd_wp_chatbot_meta_label')),
            'phone_number' => get_option('qlcd_wp_chatbot_phone'),
            'livechatlink' => get_option('qlcd_wp_chatbot_livechatlink'),
            'livechat_button_label' => get_option('qlcd_wp_livechat_button_label'),
            'call_gen' => get_option('disable_wp_chatbot_call_gen'),
            'call_sup' => get_option('disable_wp_chatbot_call_sup'),
            'enable_ret_sound' => get_option('enable_wp_chatbot_ret_sound'),
            'enable_ret_user_show' => get_option('enable_wp_chatbot_ret_user_show'),
            'enable_inactive_time_show' => get_option('enable_wp_chatbot_inactive_time_show'),
            'ret_inactive_user_once' => get_option('wp_chatbot_inactive_once'),
            'mobile_full_screen' => get_option('enable_wp_chatbot_mobile_full_screen'),
            'enable_gdpr' => get_option('enable_wp_chatbot_gdpr_compliance'),
            'wpbot_search_result_number' => get_option('wpbot_search_result_number'),
            'gdpr_text' => get_option('wpbot_gdpr_text'),
			'no_result_attempt_count' => get_option('no_result_attempt_count'),
            'inactive_time' => get_option('wp_chatbot_inactive_time'),
            'checkout_msg' => str_replace('\\', '', get_option('wp_chatbot_checkout_msg')),
            'ai_df_enable' => get_option('enable_wp_chatbot_dailogflow'),
            'df_api_version' => (get_option('wp_chatbot_df_api')==''?'v1':get_option('wp_chatbot_df_api')),
            'ai_df_token' => get_option('qlcd_wp_chatbot_dialogflow_client_token'),
            'df_defualt_reply' => str_replace('\\', '', get_option('qlcd_wp_chatbot_dialogflow_defualt_reply')),
            'df_agent_lan' => get_option('qlcd_wp_chatbot_dialogflow_agent_language'),
			'clear_cache'	=> ($flag==true?1:0),
			'template'	=> get_option('qcld_wb_chatbot_theme'),
			'is_operator_online'=> qcld_wpbot_is_operator_online(),
			'disable_livechat_operator_offline'=> (isset($data['disable_livechat_operator_offline'])?$data['disable_livechat_operator_offline']:''),
			'is_livechat_active'=> qcld_wpbot_is_active_livechat(),
            'imgurl' => QCLD_wpCHATBOT_IMG_URL,
            'hello'=> get_option('qlcd_wp_chatbot_hello'),
            'ajax_nonce'=> wp_create_nonce('qcsecretbotnonceval123qc'),
            'exitintent_all_page' => get_option('wp_chatbot_exitintent_show_pages'),
			'exitintent_pages' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('wp_chatbot_exitintent_show_pages_list'))),
            'current_pageid' => $post->ID,
            'disable_repeatative'  => get_option('wpbot_disable_repeatative'),
            'start_menu'    => stripslashes(get_option('qc_wpbot_menu_order')),
            'forms' => $this->qcld_wb_chatbot_str_replace(qc_get_formbuilder_forms()),
            'form_commands'=> $this->qcld_wb_chatbot_str_replace(qc_get_formbuilder_form_commands()),
            'form_ids'  => $this->qcld_wb_chatbot_str_replace(qc_get_formbuilder_form_ids()),
            'is_formbuilder_active' => qc_is_formbuilder_active(),
            //'v2_client_url'=> esc_url(get_site_url().'/?action=qcld_dfv2_api'),
            'v2_client_url' => esc_url(get_rest_url().'wpbot/v1/dialogflow_api'),
            'open_livechat_window_first' => (isset($data['show_livechat_window_first'])?$data['show_livechat_window_first']:''),
            'is_chat_session_active' => qcld_wpbot_is_active_chat_history(),
            'disable_auto_focus' => get_option('disable_auto_focus_message_area'),
            'woocommerce' => (function_exists('qcpd_wpwc_addon_lang_init')?true:false),
            //bargain bot
            'your_offer_price'  => (get_option('qcld_minimum_accept_price_heading_text')!=''?get_option('qcld_minimum_accept_price_heading_text'):'Please, tell me what is your offer price.'),
            'your_offer_price_again'  => (get_option('qcld_minimum_accept_price_heading_text_again')!=''?get_option('qcld_minimum_accept_price_heading_text_again'):'It seems like you have not provided any offer amount. Please give me a number!'),
            'your_low_price_alert' => (get_option('qcld_minimum_accept_price_low_alert_text_two')!=''?get_option('qcld_minimum_accept_price_low_alert_text_two'):'Your offered price {offer price} is too low for us.'),
            'your_too_low_price_alert' => (get_option('qcld_minimum_accept_price_too_low_alert_text')!=''?get_option('qcld_minimum_accept_price_too_low_alert_text'):'The best we can do for you is {minimum amount}. Do you accept?'),
            'map_talk_to_boss' => (get_option('qcld_minimum_accept_price_talk_to_boss')!=''?get_option('qcld_minimum_accept_price_talk_to_boss'):'Please tell me your final price. I will talk to my boss.'),
            'map_get_email_address' => (get_option('qcld_minimum_accept_price_get_email_address')!=''?get_option('qcld_minimum_accept_price_get_email_address'):'Please tell me your email address so I can get back to you.'),
            'map_thanks_test' => (get_option('qcld_minimum_accept_price_thanks_test')!=''?get_option('qcld_minimum_accept_price_thanks_test'):'Thank you.'),
            'map_acceptable_price' => (get_option('qcld_minimum_accept_price_acceptable_price')!=''?get_option('qcld_minimum_accept_price_acceptable_price'):'Your offered price {offer price} is acceptable.'),
            'map_checkout_now_button_text' => (get_option('qcld_minimum_accept_modal_checkout_now_button_text')!=''?get_option('qcld_minimum_accept_modal_checkout_now_button_text'):'Checkout Now'),
            'map_get_checkout_url' => (function_exists('wc_get_checkout_url')?wc_get_checkout_url():''),
            'map_get_ajax_nonce' => (wp_create_nonce( 'woo-minimum-acceptable-price')),
            'currency_symbol' => (function_exists('get_woocommerce_currency_symbol')?get_woocommerce_currency_symbol():''),
            'order_status_without_login' => (get_option('wp_chatbot_order_status_without_login')?get_option('wp_chatbot_order_status_without_login'):0),
            'order_email_asking' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_order_email'))),
            'order_id_asking' => $this->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_order_id'))),

        );
		
        wp_register_script('qcld-wp-chatbot-slimsqccrl-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.slimscroll.min.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);

       // wp_register_style('qcld-wp-chatbot-widget-css', plugins_url(basename(plugin_dir_path(__FILE__)) . '/css/widget_area_css.css', basename(__FILE__)), '', QCLD_wpCHATBOT_VERSION, 'screen');


        wp_register_style('qcld-wp-chatbot-widget-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/widget_area_css.css', '', QCLD_wpCHATBOT_VERSION, 'screen');


        wp_enqueue_script('qcld-wp-chatbot-slimsqccrl-js');

        wp_register_script('qcld-wp-chatbot-qcquery-cake', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.cookie.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-qcquery-cake');
        

        

        wp_register_script('qcld-wp-chatbot-magnifict-qcpopup', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.magnific-popup.min.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-magnifict-qcpopup');

        wp_register_script('qcld-wp-chatbot-datetime-jquery', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.datetimepicker.full.min.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-datetime-jquery');


        wp_register_script('qcld-wp-chatbot-plugin', QCLD_wpCHATBOT_PLUGIN_URL . 'js/qcld-wp-chatbot-plugin.js', array('jquery', 'qcld-wp-chatbot-qcquery-cake','qcld-wp-chatbot-magnifict-qcpopup'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-plugin');
        wp_register_script('qcld-wp-chatbot-front-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/qcld-wp-chatbot-front.js', array('jquery', 'qcld-wp-chatbot-qcquery-cake'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-front-js');
        wp_localize_script('qcld-wp-chatbot-front-js', 'wp_chatbot_obj', $wp_chatbot_obj);

        wp_localize_script('qcld-wp-chatbot-frontend', 'wp_chatbot_obj', $wp_chatbot_obj);

        wp_register_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-common-style');

        wp_register_style('qcld-wp-chatbot-datetime-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/jquery.datetimepicker.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-datetime-style');

        $custom_colors = '';
        if(get_option('enable_wp_chatbot_custom_color')==1){

            $custom_colors .="
                #wp-chatbot-chat-container, .wp-chatbot-product-description, .wp-chatbot-product-description p,.wp-chatbot-product-quantity label, .wp-chatbot-product-variable label {
                    color: ". get_option('wp_chatbot_text_color')." !important;
                }
                #wp-chatbot-chat-container a {
                    color: ". get_option('wp_chatbot_link_color')." !important;
                }
                #wp-chatbot-chat-container a:hover {
                    color: ". get_option('wp_chatbot_link_hover_color')." !important;
                }
                ul.wp-chatbot-messages-container > li.wp-chatbot-msg .wp-chatbot-paragraph,
                .wp-chatbot-agent-profile .wp-chatbot-bubble {
                    color: ". get_option('wp_chatbot_bot_msg_text_color')." !important;
                    background-color: ". get_option('wp_chatbot_bot_msg_bg_color')." !important;
                    word-break: break-word;
                }
                span.qcld-chatbot-product-category, span.qcld-chatbot-support-items, span.qcld-chatbot-wildcard, span.qcld-chatbot-suggest-email, span.qcld-chatbot-reset-btn, #woo-chatbot-loadmore, .wp-chatbot-shortcode-template-container span.qcld-chatbot-product-category, .wp-chatbot-shortcode-template-container span.qcld-chatbot-support-items, .wp-chatbot-shortcode-template-container span.qcld-chatbot-wildcard, .wp-chatbot-shortcode-template-container span.wp-chatbot-card-button, .wp-chatbot-shortcode-template-container span.qcld-chatbot-suggest-email, span.qcld-chatbot-suggest-phone, .wp-chatbot-shortcode-template-container span.qcld-chatbot-reset-btn, .wp-chatbot-shortcode-template-container #wp-chatbot-loadmore, .wp-chatbot-ball-cart-items, .wpbd_subscription, .qcld-chatbot-site-search, .qcld_subscribe_confirm, .qcld-chat-common, .qcld-chatbot-custom-intent {
                    color: ". get_option('wp_chatbot_buttons_text_color') ." !important;
                    background-color: ". get_option('wp_chatbot_buttons_bg_color') ." !important;
                background-image: none !important;
                }

                span.qcld-chatbot-product-category:hover, span.qcld-chatbot-support-items:hover, span.qcld-chatbot-wildcard:hover, span.qcld-chatbot-suggest-email:hover, span.qcld-chatbot-reset-btn:hover, #woo-chatbot-loadmore:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-product-category:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-support-items:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-wildcard:hover, .wp-chatbot-shortcode-template-container:hover span.wp-chatbot-card-button:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-suggest-email:hover, span.qcld-chatbot-suggest-phone:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-reset-btn:hover, .wp-chatbot-shortcode-template-container:hover #wp-chatbot-loadmore:hover, .wp-chatbot-ball-cart-items:hover, .wpbd_subscription:hover, .qcld-chatbot-site-search:hover, .qcld_subscribe_confirm:hover, .qcld-chat-common:hover, .qcld-chatbot-custom-intent:hover {
                    color: ". get_option('wp_chatbot_buttons_text_color_hover') ." !important;
                    background-color: ". get_option('wp_chatbot_buttons_bg_color_hover') ." !important;
                background-image: none !important;
                }

                li.wp-chat-user-msg .wp-chatbot-paragraph {
                    color: ". get_option('wp_chatbot_user_msg_text_color')." !important;
                    background-color: ". get_option('wp_chatbot_user_msg_bg_color')." !important;
                }
                ul.wp-chatbot-messages-container > li.wp-chatbot-msg > .wp-chatbot-paragraph:before,
                .wp-chatbot-bubble:before {
                    border-right: 10px solid ". get_option('wp_chatbot_bot_msg_bg_color')." !important;

                }
                ul.wp-chatbot-messages-container > li.wp-chat-user-msg > .wp-chatbot-paragraph:before {
                    border-left: 10px solid ". get_option('wp_chatbot_user_msg_bg_color')." !important;
                }
            ";

        }

        if(get_option('wp_chatbot_custom_css')!="") {
            $custom_colors .= get_option('wp_chatbot_custom_css');
        }
        wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_colors );


        wp_register_style('qcld-wp-chatbot-magnifict-qcpopup-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/magnific-popup.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-magnifict-qcpopup-css');
        $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');

        //Loading shortcode style
		
		wp_register_style('qlcd-wp-chatbot-font-awe', QCLD_wpCHATBOT_PLUGIN_URL . 'css/font-awesome.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-font-awe');
		
		
        if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/shortcode.css')) {
            wp_register_style('qcld-wp-chatbot-shortcode-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/' . $qcld_wb_chatbot_theme . '/shortcode.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-shortcode-style');
        }
    }
    public function qcld_wb_chatbot_str_replace($messages=array()){
        $refined_mesgses=array();
        if(!empty($messages)){
            foreach ($messages as $message){
                $refined_msg=str_replace('\\', '', $message);
                array_push($refined_mesgses,$refined_msg);
            }
        }
        return $refined_mesgses;
    }

    public function qcld_get_stopwords(){

        $words = str_replace('\\', '', get_option('qlcd_wp_chatbot_stop_words'));
        if(get_option('qlcd_wp_chatbot_stop_words_name')!='english'){
            $words .="a,able,about,above,abst,accordance,according,accordingly,across,act,actually,added,adj,affected,affecting,affects,after,afterwards,again,against,ah,all,almost,alone,along,already,also,although,always,am,among,amongst,an,and,announce,another,any,anybody,anyhow,anymore,anyone,anything,anyway,anyways,anywhere,apparently,approximately,are,aren,arent,arise,around,as,aside,ask,asking,at,auth,available,away,awfully,b,back,be,became,because,become,becomes,becoming,been,before,beforehand,begin,beginning,beginnings,begins,behind,being,believe,below,beside,besides,between,beyond,biol,both,brief,briefly,but,by,c,ca,came,can,cannot,can't,cause,causes,certain,certainly,co,com,come,comes,contain,containing,contains,could,couldnt,d,date,did,didn't,different,do,does,doesn't,doing,done,don't,down,downwards,due,during,e,each,ed,edu,effect,eg,eight,eighty,either,else,elsewhere,end,ending,enough,especially,et,et-al,etc,even,ever,every,everybody,everyone,everything,everywhere,ex,except,f,far,few,ff,fifth,first,five,fix,followed,following,follows,for,former,formerly,forth,found,four,from,further,furthermore,g,gave,get,gets,getting,give,given,gives,giving,go,goes,gone,got,gotten,h,had,happens,hardly,has,hasn't,have,haven't,having,he,hed,hence,her,here,hereafter,hereby,herein,heres,hereupon,hers,herself,hes,hi,hid,him,himself,his,hither,home,how,howbeit,however,hundred,i,id,ie,if,i'll,im,immediate,immediately,importance,important,in,inc,indeed,index,information,instead,into,invention,inward,is,isn't,it,itd,it'll,its,itself,i've,j,just,k,keep,keeps,kept,kg,km,know,known,knows,l,largely,last,lately,later,latter,latterly,least,less,lest,let,lets,like,liked,likely,line,little,'ll,look,looking,looks,ltd,m,made,mainly,make,makes,many,may,maybe,me,mean,means,meantime,meanwhile,merely,mg,might,million,miss,ml,more,moreover,most,mostly,mr,mrs,much,mug,must,my,myself,n,na,name,namely,nay,nd,near,nearly,necessarily,necessary,need,needs,neither,never,nevertheless,new,next,nine,ninety,no,nobody,non,none,nonetheless,noone,nor,normally,nos,not,noted,nothing,now,nowhere,o,obtain,obtained,obviously,of,off,often,oh,ok,okay,old,omitted,on,once,one,ones,only,onto,or,ord,other,others,otherwise,ought,our,ours,ourselves,out,outside,over,overall,owing,own,p,page,pages,part,particular,particularly,past,per,perhaps,placed,please,plus,poorly,possible,possibly,potentially,pp,predominantly,present,previously,primarily,probably,promptly,proud,provides,put,q,que,quickly,quite,qv,r,ran,rather,rd,re,readily,really,recent,recently,ref,refs,regarding,regardless,regards,related,relatively,research,respectively,resulted,resulting,results,right,run,s,said,same,saw,say,saying,says,sec,section,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sent,seven,several,shall,she,shed,she'll,shes,should,shouldn't,show,showed,shown,showns,shows,significant,significantly,similar,similarly,since,six,slightly,so,some,somebody,somehow,someone,somethan,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specifically,specified,specify,specifying,still,stop,strongly,sub,substantially,successfully,such,sufficiently,suggest,sup,sure,t,take,taken,taking,tell,tends,th,than,thank,thanks,thanx,that,that'll,thats,that've,the,their,theirs,them,themselves,then,thence,there,thereafter,thereby,thered,therefore,therein,there'll,thereof,therere,theres,thereto,thereupon,there've,these,they,theyd,they'll,theyre,they've,think,this,those,thou,though,thoughh,thousand,throug,through,throughout,thru,thus,til,tip,to,together,too,took,toward,towards,tried,tries,truly,try,trying,ts,twice,two,u,un,under,unfortunately,unless,unlike,unlikely,until,unto,up,upon,ups,us,use,used,useful,usefully,usefulness,uses,using,usually,v,value,various,'ve,very,via,viz,vol,vols,vs,w,want,wants,was,wasnt,way,we,wed,welcome,we'll,went,were,werent,we've,what,whatever,what'll,whats,when,whence,whenever,where,whereafter,whereas,whereby,wherein,wheres,whereupon,wherever,whether,which,while,whim,whither,who,whod,whoever,whole,who'll,whom,whomever,whos,whose,why,widely,willing,wish,with,within,without,wont,words,world,would,wouldnt,www,x,y,yes,yet,you,youd,you'll,your,youre,yours,yourself,yourselves,you've,z,zero";
        }
        return $words;
    }

    //getting exact agent icon path
    public  function qcld_wb_chatbot_agent_icon(){
		
        if(get_option('wp_chatbot_custom_agent_path')!="" && get_option('wp_chatbot_agent_image')=="custom-agent.png"  ){
            $wp_chatbot_custom_icon_path=get_option('wp_chatbot_custom_agent_path');
        }
		else if(get_option('wp_chatbot_custom_agent_path')!="" && get_option('wp_chatbot_agent_image')!="custom-agent.png"){
            $wp_chatbot_custom_icon_path=QCLD_wpCHATBOT_IMG_URL.get_option('wp_chatbot_agent_image');
        }
		else
		{
			if(get_option('wp_chatbot_agent_image')!=''){
				$wp_chatbot_custom_icon_path=QCLD_wpCHATBOT_IMG_URL.get_option('wp_chatbot_agent_image');
			}else{
				$wp_chatbot_custom_icon_path=QCLD_wpCHATBOT_IMG_URL.'custom-agent.png';
			}
            
        }
		
        return $wp_chatbot_custom_icon_path;
    }
	public function qcld_wb_chatbot_dynamic_multi_option($options = array(), $option_name = "", $option_text = "")
    {
        ?>
        <h4 class="qc-opt-title"><?php echo esc_html__($option_text, 'wpchatbot'); ?></h4>
        <div class="wp-chatbot-lng-items">
            <?php
            if (is_array($options) && count($options) > 0) {
                foreach ($options as $key => $value) {
                    ?>
                    <div class="row" class="wp-chatbot-lng-item">
                        <div class="col-xs-10">
                            <textarea type="text"
                                   class="form-control qc-opt-dcs-font"
                                   name="<?php echo esc_html($option_name); ?>[]"
                                   ><?php echo esc_html(str_replace('\\', '', $value)); ?></textarea>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else { ?>
                <div class="row" class="wp-chatbot-lng-item">
                    <div class="col-xs-10">
                        <textarea type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>[]"
                               ><?php echo esc_html($option_text); ?></textarea>
                    </div>
                    <div class="col-xs-2">
                        <span class="wp-chatbot-lng-item-remove"><?php echo esc_html__('X', 'wpchatbot'); ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-10">
                <button type="button" class="btn btn-success btn-sm wp-chatbot-lng-item-add"> <span class="glyphicon glyphicon-plus"></span> </button>
            </div>
        </div>
        <?php
    }
	public function qcld_wb_chatbot_dynamic_multi_option_custom($options = array(), $option_name = "", $option_text = "")
    {
        ?>
        <h4 class="qc-opt-title"><?php echo esc_html__($option_text, 'wpchatbot'); ?></h4>
        <div class="wp-chatbot-lng-items">
			<?php if (is_array($options) && count($options) > 0) { 
				$checkboxes = unserialize(get_option($option_name.'_checkbox'));
				$labels = unserialize(get_option($option_name.'_label'));
				foreach($options as $key=>$value){
			?>
                <div class="row" class="wp-chatbot-lng-item">
                    <div class="col-xs-10">
						<p><?php echo esc_html__('Intent Name - Must match EXACTLY as what you Added in DialogFlow. This will show the intent in the Start Menu','wpchatbot'); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>[]"
                               value="<?php echo esc_html(str_replace('\\', '', $value)); ?>">
							   
						<p class="wpbot_multi_option" ><?php echo esc_html__('Intent Label','wpchatbot'); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>_label[]"
                               value="<?php echo esc_html(str_replace('\\', '', $labels[$key])); ?>">
							   
						<div class="cxsc-settings-blocks wpb_custom_checkbox">
                            
							<p><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                   name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo ($checkboxes[$key]==1?'checked="checked"':''); ?> >
							&nbsp;&nbsp;<?php echo esc_html__('If you have created a Step by Step Question Answer Intent in DialogFlow, you can Enable the Option to have the Answers emailed to you. This can be used to create a Poll or Survey. See documentation for more details!','wpchatbot'); ?>
                            <input value="0" class="wp_check_hidden" type="hidden"
                                                   name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo ($checkboxes[$key]==1?'disabled="disabled"':''); ?> >
                            </p>
						</div>
                    </div>
                    <div class="col-xs-2 wpb_custom_remove">
                        <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                    </div>
                </div>
			<?php 
				}
			}else{ 
			?>
				<div class="row" class="wp-chatbot-lng-item">
                    <div class="col-xs-10">
						<p><?php echo esc_html__('Intent Name','wpchatbot'); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>[]"
                               value="<?php echo esc_html($option_text); ?>" placeholder="Intent Name">
							   
						<p class="wpbot_multi_option"><?php echo esc_html(esc_html__('Intent Label','wpchatbot')); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>_label[]"
                               value="<?php echo esc_html($option_text); ?>" placeholder="Intent Name">
							   
						<div class="cxsc-settings-blocks wpb_custom_checkbox">
							<p><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                   name="<?php echo esc_html($option_name); ?>_checkbox[]" >
							&nbsp;&nbsp;<?php echo esc_html(esc_html__('If you have created a Step by Step Question Answer Intent in DialogFlow, you can Enable the Option to have the Answers emailed to you. This can be used to create a Poll or Survey. See documentation for more details!','wpchatbot')); ?></p>
						</div>
                    </div>
                    <div class="col-xs-2 wpb_custom_remove">
                        <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                </div>
			<?php } ?>
				
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-10">
                <button type="button" class="btn btn-success btn-sm wp-chatbot-lng-item-add"> <span class="glyphicon glyphicon-plus"></span> </button>
            </div>
        </div>
        <?php
    }

    public function qcld_wb_chatbot_dynamic_multi_option_menu($options = array(), $option_name = "", $option_text = "")
    {
        ?>
        <h4 class="qc-opt-title"><?php echo esc_html__($option_text, 'wpchatbot'); ?></h4>
        <div class="wp-chatbot-lng-items">
			<?php if (is_array($options) && count($options) > 0) { 
				$checkboxes = unserialize(get_option($option_name.'_checkbox'));
				$labels = unserialize(get_option($option_name.'_link'));
				foreach($options as $key=>$value){
			?>
                <div class="row" class="wp-chatbot-lng-item">
                    <div class="col-xs-10">
						<p><?php echo esc_html__('Button Label','wpchatbot'); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>[]"
                               value="<?php echo esc_html(str_replace('\\', '', $value)); ?>">
							   
						<p class="wpbot_multi_option" ><?php echo esc_html__('Button Link','wpchatbot'); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>_link[]"
                               value="<?php echo esc_html(str_replace('\\', '', $labels[$key])); ?>">
							   
						<div class="cxsc-settings-blocks wpb_custom_checkbox">
                            
							<p style="display: flex;align-items: center;"><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                   name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo ($checkboxes[$key]==1?'checked="checked"':''); ?> >
							&nbsp;&nbsp;<?php echo esc_html__('Open in New Tab','wpchatbot'); ?>
                            <input value="0" class="wp_check_hidden" type="hidden"
                                                   name="<?php echo esc_html($option_name); ?>_checkbox[]" <?php echo ($checkboxes[$key]==1?'disabled="disabled"':''); ?> >
                            </p>
						</div>
                    </div>
                    <div class="col-xs-2 wpb_custom_remove">
                        <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                    </div>
                </div>
			<?php 
				}
			}else{ 
			?>
				<div class="row" class="wp-chatbot-lng-item">
                    <div class="col-xs-10">
						<p><?php echo esc_html__('Button Label','wpchatbot'); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>[]"
                               value="<?php echo esc_html($option_text); ?>" placeholder="Button Label">
							   
						<p class="wpbot_multi_option"><?php echo esc_html(esc_html__('Button Link','wpchatbot')); ?></p>
                        <input type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>_link[]"
                               value="<?php echo esc_html($option_text); ?>" placeholder="Button Link">
							   
						<div class="cxsc-settings-blocks wpb_custom_checkbox">
							<p style="display: flex;align-items: center;"><input value="1" type="checkbox" class="wpb_repeatable_checkbox"
                                                   name="<?php echo esc_html($option_name); ?>_checkbox[]" >
							&nbsp;&nbsp;<?php echo esc_html(esc_html__('Open in New Tab','wpchatbot')); ?></p>
						</div>
                    </div>
                    <div class="col-xs-2 wpb_custom_remove">
                        <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                </div>
			<?php } ?>
				
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-10">
                <button type="button" class="btn btn-success btn-sm wp-chatbot-lng-item-add"> <span class="glyphicon glyphicon-plus"></span> </button>
            </div>
        </div>
        <?php
    }

    /**
     * Render the admin page
     */
    public function qcld_wb_chatbot_admin_page()
    {
        global $woocommerce;
        $action = 'admin.php?page=wpbot-panel';
        require_once("admin_ui2.php");
    }

    public function qcld_wb_chatbot_admin_page_settings()
    {
        global $woocommerce;
        $action = 'admin.php?page=wpbot';
        $data = get_option('wbca_options');
        require_once("admin_ui.php");
    }
    
    public function wp_chatbot_opening_hours($day_name,$wpwbot_times){
        if(!empty($wpwbot_times) && isset($wpwbot_times[$day_name])){
            $day_times=$wpwbot_times[$day_name];
            if(!empty($day_times)){
                $segment=0;
                foreach ($day_times as $day_time ){
        ?>
            <div class="wp-chatbot-hours-container">
                <div class="wp-chatbot-hours">
                    <input type="text" class="wp-chatbot-hour" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][<?php echo esc_html($segment); ?>][]" value="<?php if(isset($day_time[0])){echo $day_time[0];}else{ echo "00:00";}  ?>" >
                    <input type="text" class="wp-chatbot-hour" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][<?php echo esc_html($segment); ?>][]" value="<?php if(isset($day_time[1])){echo $day_time[1];}else{ echo "00:00";}  ?>" >
                </div>
                <div class="wp-chatbot-hours-remove">
                    <button type="button" class="btn btn-danger btn-sm wp-chatbot-hours-remove-btn">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

        <?php
            $segment++;
            }
          }
        }else{
        ?>
            <div class="wp-chatbot-hours-container">
                <div class="wp-chatbot-hours">
                    <input type="text" class="wp-chatbot-hour" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][0][]" value="00:00" > <input type="text" name="wpwbot_hours[<?php echo esc_html($day_name); ?>][0][]" value="00:00">
                </div>
                <div class="wp-chatbot-hours-remove">
                    <button type="button" class="btn btn-danger btn-sm wp-chatbot-hours-remove-btn">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        <?php
        }
    }
    function qcld_wb_chatbot_save_options()
    {
        
        if (isset($_POST['_wpnonce']) && $_POST['_wpnonce']) {
            wp_verify_nonce($_POST['_wpnonce'], 'wp_chatbot');
            // Check if the form is submitted or not
            if (isset($_POST['submit'])) {
                //wpwboticon position settings.
                if (isset($_POST["wp_chatbot_position_x"])) {
                    $wp_chatbot_position_x = stripslashes(sanitize_text_field($_POST["wp_chatbot_position_x"]));
                    update_option('wp_chatbot_position_x', $wp_chatbot_position_x);
                }
                if (isset($_POST["wp_chatbot_position_y"])) {
                    $wp_chatbot_position_y = stripslashes(sanitize_text_field($_POST["wp_chatbot_position_y"]));
                    update_option('wp_chatbot_position_y', $wp_chatbot_position_y);
                }

                if (isset($_POST["wp_chatbot_position_in"])) {
                    $wp_chatbot_position_in = stripslashes(sanitize_text_field($_POST["wp_chatbot_position_in"]));
                    update_option('wp_chatbot_position_in', $wp_chatbot_position_in);
                }

                

                //product search options
                if(isset($_POST['qlcd_wp_chatbot_search_option'])){
                    $qlcd_wp_chatbot_search_option = $_POST['qlcd_wp_chatbot_search_option'];
                    update_option('qlcd_wp_chatbot_search_option', sanitize_text_field($qlcd_wp_chatbot_search_option));
                }


                if(isset( $_POST["enable_wp_chatbot_custom_color"])) {
                    $enable_wp_chatbot_custom_color = $_POST["enable_wp_chatbot_custom_color"];
                }else{ $enable_wp_chatbot_custom_color='';}
                update_option('enable_wp_chatbot_custom_color', sanitize_text_field($enable_wp_chatbot_custom_color));


                


               $wp_chatbot_text_color = $_POST["wp_chatbot_text_color"];
                update_option('wp_chatbot_text_color', sanitize_text_field($wp_chatbot_text_color));

                $wp_chatbot_link_color = $_POST["wp_chatbot_link_color"];
                update_option('wp_chatbot_link_color', sanitize_text_field($wp_chatbot_link_color));

                $wp_chatbot_link_hover_color = $_POST["wp_chatbot_link_hover_color"];
                update_option('wp_chatbot_link_hover_color', sanitize_text_field($wp_chatbot_link_hover_color));

                $wp_chatbot_bot_msg_bg_color = $_POST["wp_chatbot_bot_msg_bg_color"];
                update_option('wp_chatbot_bot_msg_bg_color', sanitize_text_field($wp_chatbot_bot_msg_bg_color));

                $wp_chatbot_bot_msg_text_color = $_POST["wp_chatbot_bot_msg_text_color"];
                update_option('wp_chatbot_bot_msg_text_color', sanitize_text_field($wp_chatbot_bot_msg_text_color));

                $wp_chatbot_user_msg_bg_color = $_POST["wp_chatbot_user_msg_bg_color"];
                update_option('wp_chatbot_user_msg_bg_color', sanitize_text_field($wp_chatbot_user_msg_bg_color));

                $wp_chatbot_user_msg_text_color = $_POST["wp_chatbot_user_msg_text_color"];
                update_option('wp_chatbot_user_msg_text_color', sanitize_text_field($wp_chatbot_user_msg_text_color));


				$wp_chatbot_buttons_bg_color = $_POST["wp_chatbot_buttons_bg_color"];
                update_option('wp_chatbot_buttons_bg_color', sanitize_text_field($wp_chatbot_buttons_bg_color));

                $wp_chatbot_buttons_text_color = $_POST["wp_chatbot_buttons_text_color"];
                update_option('wp_chatbot_buttons_text_color', sanitize_text_field($wp_chatbot_buttons_text_color));

                $wp_chatbot_buttons_bg_color_hover = $_POST["wp_chatbot_buttons_bg_color_hover"];
                update_option('wp_chatbot_buttons_bg_color_hover', sanitize_text_field($wp_chatbot_buttons_bg_color_hover));

                $wp_chatbot_buttons_text_color_hover = $_POST["wp_chatbot_buttons_text_color_hover"];
                update_option('wp_chatbot_buttons_text_color_hover', sanitize_text_field($wp_chatbot_buttons_text_color_hover));
                
                //Enable /disable wpwbot
				
               if(isset( $_POST["disable_wp_chatbot"])){
                   $disable_wp_chatbot = sanitize_text_field($_POST["disable_wp_chatbot"]);
               }else{ $disable_wp_chatbot='';}
                update_option('disable_wp_chatbot', stripslashes($disable_wp_chatbot));

                if(isset( $_POST["disable_wp_chatbot_floating_icon"])){
                    $disable_wp_chatbot_floating_icon = sanitize_text_field($_POST["disable_wp_chatbot_floating_icon"]);
                }else{ $disable_wp_chatbot_floating_icon='';}
                 update_option('disable_wp_chatbot_floating_icon', stripslashes($disable_wp_chatbot_floating_icon));
				
				if(isset( $_POST["skip_wp_greetings"])){
                   $skip_wp_greetings = sanitize_text_field($_POST["skip_wp_greetings"]);
               }else{ $skip_wp_greetings='';}
                update_option('skip_wp_greetings', stripslashes($skip_wp_greetings));

                if(isset( $_POST["skip_wp_greetings_trigger_intent"])){
                    $skip_wp_greetings_trigger_intent = sanitize_text_field($_POST["skip_wp_greetings_trigger_intent"]);
                }else{ $skip_wp_greetings_trigger_intent='';}
                 update_option('skip_wp_greetings_trigger_intent', stripslashes($skip_wp_greetings_trigger_intent));

                if(isset( $_POST["show_menu_after_greetings"])){
                    $show_menu_after_greetings = sanitize_text_field($_POST["show_menu_after_greetings"]);
                }else{ $show_menu_after_greetings='';}
                 update_option('show_menu_after_greetings', stripslashes($show_menu_after_greetings));

                if(isset( $_POST["disable_first_msg"])){
                    $disable_first_msg = sanitize_text_field($_POST["disable_first_msg"]);
                }else{ $disable_first_msg='';}
                 update_option('disable_first_msg', stripslashes($disable_first_msg));
                 
                 if(isset( $_POST["enable_reset_close_button"])){
                    $enable_reset_close_button = sanitize_text_field($_POST["enable_reset_close_button"]);
                }else{ $enable_reset_close_button='';}
                 update_option('enable_reset_close_button', stripslashes($enable_reset_close_button));

                 if(isset( $_POST["qc_auto_hide_floating_button"])){
                    $qc_auto_hide_floating_button = sanitize_text_field($_POST["qc_auto_hide_floating_button"]);
                }else{ $qc_auto_hide_floating_button='';}
                 update_option('qc_auto_hide_floating_button', stripslashes($qc_auto_hide_floating_button));

                 

                 if(isset( $_POST["qlcd_wp_chatbot_reset_lan"])){
                    $qlcd_wp_chatbot_reset_lan = sanitize_text_field($_POST["qlcd_wp_chatbot_reset_lan"]);
                }else{ $qlcd_wp_chatbot_reset_lan='';}
                 update_option('qlcd_wp_chatbot_reset_lan', stripslashes($qlcd_wp_chatbot_reset_lan));

                 if(isset( $_POST["qlcd_wp_chatbot_close_lan"])){
                    $qlcd_wp_chatbot_close_lan = sanitize_text_field($_POST["qlcd_wp_chatbot_close_lan"]);
                }else{ $qlcd_wp_chatbot_close_lan='';}
                 update_option('qlcd_wp_chatbot_close_lan', stripslashes($qlcd_wp_chatbot_close_lan));
                
                 
                 
				if(isset( $_POST["ask_email_wp_greetings"])){
                   $ask_email_wp_greetings = sanitize_text_field($_POST["ask_email_wp_greetings"]);
               }else{ $ask_email_wp_greetings='';}
                update_option('ask_email_wp_greetings', stripslashes($ask_email_wp_greetings));

                if(isset( $_POST["ask_phone_wp_greetings"])){
                    $ask_phone_wp_greetings = sanitize_text_field($_POST["ask_phone_wp_greetings"]);
                }else{ $ask_phone_wp_greetings='';}
                 update_option('ask_phone_wp_greetings', stripslashes($ask_phone_wp_greetings));

                if(isset( $_POST["qc_email_subscription_offer"])){
                    $qc_email_subscription_offer = sanitize_text_field($_POST["qc_email_subscription_offer"]);
                }else{ $qc_email_subscription_offer='';}
                 update_option('qc_email_subscription_offer', stripslashes($qc_email_subscription_offer));

                

                if(isset( $_POST["wpbot_support_mail_to_crm_contact"])){
                   $wpbot_support_mail_to_crm_contact = sanitize_text_field($_POST["wpbot_support_mail_to_crm_contact"]);
               }else{ $wpbot_support_mail_to_crm_contact='';}
                update_option('wpbot_support_mail_to_crm_contact', stripslashes($wpbot_support_mail_to_crm_contact));

                if(isset( $_POST["enable_wp_chatbot_open_initial"])){
                    $enable_wp_chatbot_open_initial = sanitize_text_field($_POST["enable_wp_chatbot_open_initial"]);
                }else{ $enable_wp_chatbot_open_initial='';}
                 update_option('enable_wp_chatbot_open_initial', stripslashes($enable_wp_chatbot_open_initial));
				
                if(isset( $_POST["disable_wp_chatbot_on_mobile"])) {
                    $disable_wp_chatbot_on_mobile = sanitize_text_field($_POST["disable_wp_chatbot_on_mobile"]);
                }else{ $disable_wp_chatbot_on_mobile='';}
                update_option('disable_wp_chatbot_on_mobile', stripslashes($disable_wp_chatbot_on_mobile));

                if(isset( $_POST["disable_auto_focus_message_area"])) {
                    $disable_auto_focus_message_area = sanitize_text_field($_POST["disable_auto_focus_message_area"]);
                }else{ $disable_auto_focus_message_area='';}
                update_option('disable_auto_focus_message_area', stripslashes($disable_auto_focus_message_area));


                
				
				if(isset( $_POST["disable_livechat_operator_offline"])) {
                    $disable_livechat_operator_offline = sanitize_text_field($_POST["disable_livechat_operator_offline"]);
                }else{ $disable_livechat_operator_offline='';}
                update_option('disable_livechat_operator_offline', stripslashes($disable_livechat_operator_offline));
                
				
                if(isset( $_POST["disable_wp_chatbot_notification"])) {
                    $disable_wp_chatbot_notification = sanitize_text_field($_POST["disable_wp_chatbot_notification"]);
                }else{ $disable_wp_chatbot_notification='0';}
                update_option('disable_wp_chatbot_notification', stripslashes($disable_wp_chatbot_notification));

                if(isset( $_POST["wp_chatbot_exclude_post_list"])) {
                    $wp_chatbot_exclude_post_list = $_POST["wp_chatbot_exclude_post_list"];
                }else{ $wp_chatbot_exclude_post_list='';}
                update_option('wp_chatbot_exclude_post_list', serialize($wp_chatbot_exclude_post_list));

                if(isset( $_POST["wp_chatbot_exclude_pages_list"])) {
                    $wp_chatbot_exclude_pages_list = $_POST["wp_chatbot_exclude_pages_list"];
                }else{ $wp_chatbot_exclude_pages_list='';}
                update_option('wp_chatbot_exclude_pages_list', serialize($wp_chatbot_exclude_pages_list));

                if(isset( $_POST["wpbot_click_chat_text"])) {
                    $wpbot_click_chat_text = sanitize_text_field($_POST["wpbot_click_chat_text"]);
                }else{ $wpbot_click_chat_text='0';}
                update_option('wpbot_click_chat_text', stripslashes($wpbot_click_chat_text));

                if(isset( $_POST["qc_wpbot_menu_order"])) {
                    $qc_wpbot_menu_order = ($_POST["qc_wpbot_menu_order"]);
                }else{ $qc_wpbot_menu_order='';}
                update_option('qc_wpbot_menu_order', ($qc_wpbot_menu_order));
                

                if(isset( $_POST["enable_wp_chatbot_rtl"])) {
                    $enable_wp_chatbot_rtl = sanitize_text_field($_POST["enable_wp_chatbot_rtl"]);
                }else{ $enable_wp_chatbot_rtl='';}
                update_option('enable_wp_chatbot_rtl', stripslashes($enable_wp_chatbot_rtl));

                if(isset( $_POST["enable_wp_chatbot_disable_allicon"])) {
                    $enable_wp_chatbot_disable_allicon = sanitize_text_field($_POST["enable_wp_chatbot_disable_allicon"]);
                }else{ $enable_wp_chatbot_disable_allicon='';}
                update_option('enable_wp_chatbot_disable_allicon', stripslashes($enable_wp_chatbot_disable_allicon));

                if(isset( $_POST["enable_wp_chatbot_disable_helpicon"])) {
                    $enable_wp_chatbot_disable_helpicon = sanitize_text_field($_POST["enable_wp_chatbot_disable_helpicon"]);
                }else{ $enable_wp_chatbot_disable_helpicon='';}
                update_option('enable_wp_chatbot_disable_helpicon', stripslashes($enable_wp_chatbot_disable_helpicon));

                if(isset( $_POST["enable_wp_chatbot_disable_supporticon"])) {
                    $enable_wp_chatbot_disable_supporticon = sanitize_text_field($_POST["enable_wp_chatbot_disable_supporticon"]);
                }else{ $enable_wp_chatbot_disable_supporticon='';}
                update_option('enable_wp_chatbot_disable_supporticon', stripslashes($enable_wp_chatbot_disable_supporticon));

                if(isset( $_POST["enable_wp_chatbot_disable_chaticon"])) {
                    $enable_wp_chatbot_disable_chaticon = sanitize_text_field($_POST["enable_wp_chatbot_disable_chaticon"]);
                }else{ $enable_wp_chatbot_disable_chaticon='';}
                update_option('enable_wp_chatbot_disable_chaticon', stripslashes($enable_wp_chatbot_disable_chaticon));

                

               if(isset( $_POST["enable_wp_chatbot_mobile_full_screen"])) {
                    $enable_wp_chatbot_mobile_full_screen = sanitize_text_field($_POST["enable_wp_chatbot_mobile_full_screen"]);
                }else{ $enable_wp_chatbot_mobile_full_screen='';}
                update_option('enable_wp_chatbot_mobile_full_screen', stripslashes($enable_wp_chatbot_mobile_full_screen));

                if(isset( $_POST["enable_wp_chatbot_gdpr_compliance"])) {
                    $enable_wp_chatbot_gdpr_compliance = sanitize_text_field($_POST["enable_wp_chatbot_gdpr_compliance"]);
                }else{ $enable_wp_chatbot_gdpr_compliance='';}
                update_option('enable_wp_chatbot_gdpr_compliance', stripslashes($enable_wp_chatbot_gdpr_compliance));

                if(isset( $_POST["wpbot_search_result_new_window"])) {
                    $wpbot_search_result_new_window = sanitize_text_field($_POST["wpbot_search_result_new_window"]);
                }else{ $wpbot_search_result_new_window='';}
                update_option('wpbot_search_result_new_window', stripslashes($wpbot_search_result_new_window));

                if(isset( $_POST["wpbot_search_image_size"])) {
                    $wpbot_search_image_size = sanitize_text_field($_POST["wpbot_search_image_size"]);
                }else{ $wpbot_search_image_size='';}
                update_option('wpbot_search_image_size', stripslashes($wpbot_search_image_size));

                

                if(isset( $_POST["wpbot_disable_repeatative"])) {
                    $wpbot_disable_repeatative = sanitize_text_field($_POST["wpbot_disable_repeatative"]);
                }else{ $wpbot_disable_repeatative='';}
                update_option('wpbot_disable_repeatative', stripslashes($wpbot_disable_repeatative));

                

                if(isset( $_POST["wpbot_search_result_number"])) {
                    $wpbot_search_result_number = sanitize_text_field($_POST["wpbot_search_result_number"]);
                }else{ $wpbot_search_result_number='';}
                update_option('wpbot_search_result_number', stripslashes($wpbot_search_result_number));

                if(isset( $_POST["wpbot_gdpr_text"])) {

                    $wpbot_gdpr_text = wp_kses_post($_POST["wpbot_gdpr_text"]);

                }else{ $wpbot_gdpr_text='';}
                
                update_option('wpbot_gdpr_text', stripslashes($wpbot_gdpr_text));
				
				if(isset( $_POST["no_result_attempt_count"])) {
                    $no_result_attempt_count = sanitize_text_field($_POST["no_result_attempt_count"]);
                }else{ $no_result_attempt_count='';}
                update_option('no_result_attempt_count', stripslashes($no_result_attempt_count));

                if(isset( $_POST["disable_wp_chatbot_icon_animation"])) {
                    $disable_wp_chatbot_icon_animation = sanitize_text_field($_POST["disable_wp_chatbot_icon_animation"]);
                }else{ $disable_wp_chatbot_icon_animation='';}
                update_option('disable_wp_chatbot_icon_animation', stripslashes($disable_wp_chatbot_icon_animation));

                if(isset( $_POST["disable_wp_chatbot_history"])) {
                    $disable_wp_chatbot_history = sanitize_text_field($_POST["disable_wp_chatbot_history"]);
                }else{ $disable_wp_chatbot_history='';}
                update_option('disable_wp_chatbot_history', stripslashes($disable_wp_chatbot_history));

                
                //product order and order by
                if(isset($_POST['qlcd_wp_chatbot_product_orderby'])){
                    $qlcd_wp_chatbot_product_orderby = sanitize_text_field($_POST['qlcd_wp_chatbot_product_orderby']);
                    update_option('qlcd_wp_chatbot_product_orderby', sanitize_text_field($qlcd_wp_chatbot_product_orderby));
                }
                
                $wp_chatbot_exitintent_show_pages = sanitize_key(@$_POST["wp_chatbot_exitintent_show_pages"]);
                update_option('wp_chatbot_exitintent_show_pages', $wp_chatbot_exitintent_show_pages);

                if(isset( $_POST["wp_chatbot_exitintent_show_pages_list"])) {
                    $wp_chatbot_exitintent_show_pages_list = $_POST["wp_chatbot_exitintent_show_pages_list"];
                }else{ $wp_chatbot_exitintent_show_pages_list='';}
                update_option('wp_chatbot_exitintent_show_pages_list', serialize($wp_chatbot_exitintent_show_pages_list));

                $qlcd_wp_chatbot_product_order = sanitize_text_field(@$_POST['qlcd_wp_chatbot_product_order']);
                update_option('qlcd_wp_chatbot_product_order', sanitize_text_field($qlcd_wp_chatbot_product_order));
                //Product per page settings.
                if (isset($_POST["qlcd_wp_chatbot_ppp"])) {
                    $qlcd_wp_chatbot_ppp = sanitize_text_field($_POST["qlcd_wp_chatbot_ppp"]);
                    update_option('qlcd_wp_chatbot_ppp', intval($qlcd_wp_chatbot_ppp));
                }
                
                if (isset($_POST["qlcd_wp_chatbot_order_user"])) {
                    $qlcd_wp_chatbot_order_user = sanitize_text_field($_POST["qlcd_wp_chatbot_order_user"]);
                    update_option('qlcd_wp_chatbot_order_user', sanitize_text_field($qlcd_wp_chatbot_order_user));
                }
                //wpwBot Load control
                $wp_chatbot_show_home_page = sanitize_key((@$_POST["wp_chatbot_show_home_page"]));
                update_option('wp_chatbot_show_home_page', $wp_chatbot_show_home_page);
                $wp_chatbot_show_posts = sanitize_key((@$_POST["wp_chatbot_show_posts"]));
                update_option('wp_chatbot_show_posts', $wp_chatbot_show_posts);
                $wp_chatbot_show_pages = sanitize_key((@$_POST["wp_chatbot_show_pages"]));
                update_option('wp_chatbot_show_pages', $wp_chatbot_show_pages);
                if(isset( $_POST["wp_chatbot_show_pages_list"])) {
                    $wp_chatbot_show_pages_list = $_POST["wp_chatbot_show_pages_list"];
                }else{ $wp_chatbot_show_pages_list='';}
                update_option('wp_chatbot_show_pages_list', serialize($wp_chatbot_show_pages_list));
                $wp_chatbot_show_woocommerce = sanitize_key((@$_POST["wp_chatbot_show_woocommerce"]));
                update_option('wp_chatbot_show_woocommerce', $wp_chatbot_show_woocommerce);
                //Stop Words Settings
                
                //wpwbot icon settings.
                $wp_chatbot_icon = $_POST['wp_chatbot_icon'] ? $_POST['wp_chatbot_icon'] : 'icon-3.png';
                update_option('wp_chatbot_icon', sanitize_text_field($wp_chatbot_icon));
                // upload custom wpwbot icon path
                 $wp_chatbot_custom_icon_path = @$_POST['wp_chatbot_custom_icon_path'];
                 update_option('wp_chatbot_custom_icon_path', sanitize_text_field($wp_chatbot_custom_icon_path));
                 //Agent image
                //wpwbot icon settings.
                $wp_chatbot_icon = $_POST['wp_chatbot_agent_image'] ? $_POST['wp_chatbot_agent_image'] : 'agent-0.png';
                 update_option('wp_chatbot_agent_image', sanitize_text_field($wp_chatbot_icon));
                // upload custom wpwbot icon
                $wp_chatbot_custom_agent_path = @$_POST['wp_chatbot_custom_agent_path'];
                update_option('wp_chatbot_custom_agent_path', sanitize_text_field($wp_chatbot_custom_agent_path));
                //Theming
                $qcld_wb_chatbot_theme = $_POST['qcld_wb_chatbot_theme'] ? $_POST['qcld_wb_chatbot_theme'] : 'template-00';
                 update_option('qcld_wb_chatbot_theme', sanitize_text_field($qcld_wb_chatbot_theme));
                //Theme custom background option
                if(isset( $_POST["qcld_wb_chatbot_change_bg"])) {
                    $qcld_wb_chatbot_change_bg = sanitize_text_field($_POST["qcld_wb_chatbot_change_bg"]);
                }else{$qcld_wb_chatbot_change_bg='';}
                update_option('qcld_wb_chatbot_change_bg', stripslashes($qcld_wb_chatbot_change_bg));
                $qcld_wb_chatbot_board_bg_path = sanitize_text_field(@$_POST["qcld_wb_chatbot_board_bg_path"]);
                update_option('qcld_wb_chatbot_board_bg_path', stripslashes($qcld_wb_chatbot_board_bg_path));
                //To override style use custom css.
                $wp_chatbot_custom_css = sanitize_text_field($_POST["wp_chatbot_custom_css"]);
                update_option('wp_chatbot_custom_css', stripslashes($wp_chatbot_custom_css));
                /****Language center settings.   ****/
                //identity
                $qlcd_wp_chatbot_host = $_POST["qlcd_wp_chatbot_host"];
                update_option('qlcd_wp_chatbot_host', sanitize_text_field($qlcd_wp_chatbot_host));
                $qlcd_wp_chatbot_agent = $_POST["qlcd_wp_chatbot_agent"];
                update_option('qlcd_wp_chatbot_agent', sanitize_text_field($qlcd_wp_chatbot_agent));
				
                $qlcd_wp_chatbot_shopper_demo_name = $_POST["qlcd_wp_chatbot_shopper_demo_name"];
                update_option('qlcd_wp_chatbot_shopper_demo_name', sanitize_text_field($qlcd_wp_chatbot_shopper_demo_name));
				
				$qlcd_wp_chatbot_shopper_call_you = $_POST["qlcd_wp_chatbot_shopper_call_you"];
                update_option('qlcd_wp_chatbot_shopper_call_you', sanitize_text_field($qlcd_wp_chatbot_shopper_call_you));
				
                $qlcd_wp_chatbot_yes = $_POST["qlcd_wp_chatbot_yes"];
                update_option('qlcd_wp_chatbot_yes', sanitize_text_field($qlcd_wp_chatbot_yes));
                $qlcd_wp_chatbot_no = $_POST["qlcd_wp_chatbot_no"];
                update_option('qlcd_wp_chatbot_no', sanitize_text_field($qlcd_wp_chatbot_no));
                
                $qlcd_wp_chatbot_or = $_POST["qlcd_wp_chatbot_or"];
                update_option('qlcd_wp_chatbot_or', sanitize_text_field($qlcd_wp_chatbot_or));

                $qlcd_wp_chatbot_sorry = $_POST["qlcd_wp_chatbot_sorry"];
                update_option('qlcd_wp_chatbot_sorry', sanitize_text_field($qlcd_wp_chatbot_sorry));

                $qlcd_wp_chatbot_hello = $_POST["qlcd_wp_chatbot_hello"];
                update_option('qlcd_wp_chatbot_hello', sanitize_text_field($qlcd_wp_chatbot_hello));

                $qlcd_wp_chatbot_chat_with_us = $_POST["qlcd_wp_chatbot_chat_with_us"];
                update_option('qlcd_wp_chatbot_chat_with_us', sanitize_text_field($qlcd_wp_chatbot_chat_with_us));

                

                $qlcd_wp_chatbot_agent_join = $_POST["qlcd_wp_chatbot_agent_join"];
                update_option('qlcd_wp_chatbot_agent_join', serialize($qlcd_wp_chatbot_agent_join));
                //Greeting.
                $qlcd_wp_chatbot_welcome = $_POST["qlcd_wp_chatbot_welcome"];
                update_option('qlcd_wp_chatbot_welcome', serialize($qlcd_wp_chatbot_welcome));
                $qlcd_wp_chatbot_back_to_start = $_POST["qlcd_wp_chatbot_back_to_start"];
                update_option('qlcd_wp_chatbot_back_to_start', serialize($qlcd_wp_chatbot_back_to_start));
                $qlcd_wp_chatbot_hi_there = $_POST["qlcd_wp_chatbot_hi_there"];
                update_option('qlcd_wp_chatbot_hi_there', serialize($qlcd_wp_chatbot_hi_there));
                $qlcd_wp_chatbot_welcome_back = $_POST["qlcd_wp_chatbot_welcome_back"];
                update_option('qlcd_wp_chatbot_welcome_back', serialize($qlcd_wp_chatbot_welcome_back));
                $qlcd_wp_chatbot_asking_name = $_POST["qlcd_wp_chatbot_asking_name"];
                update_option('qlcd_wp_chatbot_asking_name', serialize($qlcd_wp_chatbot_asking_name));
				
				$qlcd_wp_chatbot_asking_emailaddress = $_POST["qlcd_wp_chatbot_asking_emailaddress"];
                update_option('qlcd_wp_chatbot_asking_emailaddress', serialize($qlcd_wp_chatbot_asking_emailaddress));

				$qlcd_wp_chatbot_got_email = $_POST["qlcd_wp_chatbot_got_email"];
                update_option('qlcd_wp_chatbot_got_email', serialize($qlcd_wp_chatbot_got_email));
				
				$qlcd_wp_chatbot_email_ignore = $_POST["qlcd_wp_chatbot_email_ignore"];
                update_option('qlcd_wp_chatbot_email_ignore', serialize($qlcd_wp_chatbot_email_ignore));


                $qlcd_wp_chatbot_asking_phone_gt = $_POST["qlcd_wp_chatbot_asking_phone_gt"];
                update_option('qlcd_wp_chatbot_asking_phone_gt', serialize($qlcd_wp_chatbot_asking_phone_gt));

				$qlcd_wp_chatbot_got_phone = $_POST["qlcd_wp_chatbot_got_phone"];
                update_option('qlcd_wp_chatbot_got_phone', serialize($qlcd_wp_chatbot_got_phone));
				
				$qlcd_wp_chatbot_phone_ignore = $_POST["qlcd_wp_chatbot_phone_ignore"];
                update_option('qlcd_wp_chatbot_phone_ignore', serialize($qlcd_wp_chatbot_phone_ignore));
                
				$qlcd_wp_chatbot_name_greeting = $_POST["qlcd_wp_chatbot_name_greeting"];
                update_option('qlcd_wp_chatbot_name_greeting', serialize($qlcd_wp_chatbot_name_greeting));
                $qlcd_wp_chatbot_i_am = $_POST["qlcd_wp_chatbot_i_am"];
                update_option('qlcd_wp_chatbot_i_am', serialize($qlcd_wp_chatbot_i_am));
                $qlcd_wp_chatbot_is_typing = $_POST["qlcd_wp_chatbot_is_typing"];
                update_option('qlcd_wp_chatbot_is_typing', serialize($qlcd_wp_chatbot_is_typing));
                $qlcd_wp_chatbot_send_a_msg= $_POST["qlcd_wp_chatbot_send_a_msg"];
                update_option('qlcd_wp_chatbot_send_a_msg', serialize($qlcd_wp_chatbot_send_a_msg));
                $qlcd_wp_chatbot_choose_option= $_POST["qlcd_wp_chatbot_choose_option"];
                update_option('qlcd_wp_chatbot_choose_option', serialize($qlcd_wp_chatbot_choose_option));
                

                //wpwBot wildcard  settings
                $qlcd_wp_chatbot_wildcard_msg = $_POST["qlcd_wp_chatbot_wildcard_msg"];
                update_option('qlcd_wp_chatbot_wildcard_msg', serialize($qlcd_wp_chatbot_wildcard_msg));
                //empty filter message repeat.
                $qlcd_wp_chatbot_empty_filter_msg = $_POST["qlcd_wp_chatbot_empty_filter_msg"];
                update_option('qlcd_wp_chatbot_empty_filter_msg', serialize($qlcd_wp_chatbot_empty_filter_msg));
				
				$do_you_want_to_subscribe = $_POST["do_you_want_to_subscribe"];
                update_option('do_you_want_to_subscribe', serialize($do_you_want_to_subscribe));

                $do_you_want_to_unsubscribe = $_POST["do_you_want_to_unsubscribe"];
                update_option('do_you_want_to_unsubscribe', serialize($do_you_want_to_unsubscribe));

                $we_do_not_have_your_email = $_POST["we_do_not_have_your_email"];
                update_option('we_do_not_have_your_email', serialize($we_do_not_have_your_email));

                $you_have_successfully_unsubscribe = $_POST["you_have_successfully_unsubscribe"];
                update_option('you_have_successfully_unsubscribe', serialize($you_have_successfully_unsubscribe));
               //help welcome and message
                $qlcd_wp_chatbot_help_welcome = $_POST["qlcd_wp_chatbot_help_welcome"];
                update_option('qlcd_wp_chatbot_help_welcome', serialize($qlcd_wp_chatbot_help_welcome));
                $qlcd_wp_chatbot_help_msg = $_POST["qlcd_wp_chatbot_help_msg"];
                update_option('qlcd_wp_chatbot_help_msg', serialize($qlcd_wp_chatbot_help_msg));
                //To clear Conversation history.
                $qlcd_wp_chatbot_reset = $_POST["qlcd_wp_chatbot_reset"];
                update_option('qlcd_wp_chatbot_reset', serialize($qlcd_wp_chatbot_reset));
                //systems keyword.
                $qlcd_wp_chatbot_sys_key_help = $_POST["qlcd_wp_chatbot_sys_key_help"];
                update_option('qlcd_wp_chatbot_sys_key_help', sanitize_text_field($qlcd_wp_chatbot_sys_key_help));
                
                $qlcd_wp_chatbot_sys_key_support = @$_POST["qlcd_wp_chatbot_sys_key_support"];
                update_option('qlcd_wp_chatbot_sys_key_support', sanitize_text_field($qlcd_wp_chatbot_sys_key_support));
                $qlcd_wp_chatbot_sys_key_reset = @$_POST["qlcd_wp_chatbot_sys_key_reset"];
                update_option('qlcd_wp_chatbot_sys_key_reset', sanitize_text_field($qlcd_wp_chatbot_sys_key_reset));
				$qlcd_wp_chatbot_sys_key_livechat = @$_POST["qlcd_wp_chatbot_sys_key_livechat"];
                update_option('qlcd_wp_chatbot_sys_key_livechat', sanitize_text_field($qlcd_wp_chatbot_sys_key_livechat));
                
                $qlcd_wp_chatbot_wildcard_support = @$_POST["qlcd_wp_chatbot_wildcard_support"];
                update_option('qlcd_wp_chatbot_wildcard_support', sanitize_text_field($qlcd_wp_chatbot_wildcard_support));
                $qlcd_wp_chatbot_messenger_label = @$_POST["qlcd_wp_chatbot_messenger_label"];
                update_option('qlcd_wp_chatbot_messenger_label', serialize($qlcd_wp_chatbot_messenger_label));
                //Products search .
                
				
				$qlcd_wp_chatbot_no_result = $_POST["qlcd_wp_chatbot_no_result"];
                update_option('qlcd_wp_chatbot_no_result', serialize($qlcd_wp_chatbot_no_result));
				
				$qlcd_wp_email_subscription_success = $_POST["qlcd_wp_email_subscription_success"];
                update_option('qlcd_wp_email_subscription_success', serialize($qlcd_wp_email_subscription_success));
				
				$qlcd_wp_email_already_subscribe = $_POST["qlcd_wp_email_already_subscribe"];
                update_option('qlcd_wp_email_already_subscribe', serialize($qlcd_wp_email_already_subscribe));

                $qlcd_wp_email_subscription_offer = $_POST["qlcd_wp_email_subscription_offer"];
                update_option('qlcd_wp_email_subscription_offer', serialize($qlcd_wp_email_subscription_offer));
				
				$qlcd_wp_email_subscription_offer_subject = $_POST["qlcd_wp_email_subscription_offer_subject"];
                update_option('qlcd_wp_email_subscription_offer_subject', serialize($qlcd_wp_email_subscription_offer_subject));


                
				
                
                //Support
                $qlcd_wp_chatbot_support_welcome = $_POST["qlcd_wp_chatbot_support_welcome"];
                update_option('qlcd_wp_chatbot_support_welcome', serialize($qlcd_wp_chatbot_support_welcome));
                $qlcd_wp_chatbot_support_email = $_POST["qlcd_wp_chatbot_support_email"];
                update_option('qlcd_wp_chatbot_support_email', serialize($qlcd_wp_chatbot_support_email));
                $qlcd_wp_chatbot_asking_email = $_POST["qlcd_wp_chatbot_asking_email"];
                update_option('qlcd_wp_chatbot_asking_email', serialize($qlcd_wp_chatbot_asking_email));

                $qlcd_wp_chatbot_valid_phone_number = $_POST["qlcd_wp_chatbot_valid_phone_number"];
                update_option('qlcd_wp_chatbot_valid_phone_number', serialize($qlcd_wp_chatbot_valid_phone_number));
				
				$qlcd_wp_chatbot_search_keyword = $_POST["qlcd_wp_chatbot_search_keyword"];
                update_option('qlcd_wp_chatbot_search_keyword', serialize($qlcd_wp_chatbot_search_keyword));
                $qlcd_wp_chatbot_asking_msg = $_POST["qlcd_wp_chatbot_asking_msg"];
                update_option('qlcd_wp_chatbot_asking_msg', serialize($qlcd_wp_chatbot_asking_msg));
                $qlcd_wp_chatbot_support_option_again = $_POST["qlcd_wp_chatbot_support_option_again"];
                update_option('qlcd_wp_chatbot_support_option_again', serialize($qlcd_wp_chatbot_support_option_again));
                $qlcd_wp_chatbot_invalid_email = $_POST["qlcd_wp_chatbot_invalid_email"];
                update_option('qlcd_wp_chatbot_invalid_email', serialize($qlcd_wp_chatbot_invalid_email));
                $qlcd_wp_chatbot_support_phone= $_POST["qlcd_wp_chatbot_support_phone"];
                update_option('qlcd_wp_chatbot_support_phone', sanitize_text_field($qlcd_wp_chatbot_support_phone));
                $qlcd_wp_chatbot_asking_phone= $_POST["qlcd_wp_chatbot_asking_phone"];
                update_option('qlcd_wp_chatbot_asking_phone', serialize($qlcd_wp_chatbot_asking_phone));
                $qlcd_wp_chatbot_thank_for_phone= $_POST["qlcd_wp_chatbot_thank_for_phone"];
                update_option('qlcd_wp_chatbot_thank_for_phone', serialize($qlcd_wp_chatbot_thank_for_phone));

                $qlcd_wp_chatbot_admin_email = $_POST["qlcd_wp_chatbot_admin_email"];
                update_option('qlcd_wp_chatbot_admin_email', sanitize_text_field($qlcd_wp_chatbot_admin_email));

                $qlcd_wp_chatbot_from_email = $_POST["qlcd_wp_chatbot_from_email"];
                update_option('qlcd_wp_chatbot_from_email', sanitize_text_field($qlcd_wp_chatbot_from_email));
				
				$qlcd_wp_chatbot_from_name = $_POST["qlcd_wp_chatbot_from_name"];
                update_option('qlcd_wp_chatbot_from_name', sanitize_text_field($qlcd_wp_chatbot_from_name));

                $qlcd_wp_chatbot_reply_to_email = $_POST["qlcd_wp_chatbot_reply_to_email"];
                update_option('qlcd_wp_chatbot_reply_to_email', sanitize_text_field($qlcd_wp_chatbot_reply_to_email));

                $qlcd_wp_chatbot_email_sub = $_POST["qlcd_wp_chatbot_email_sub"];
                update_option('qlcd_wp_chatbot_email_sub', sanitize_text_field($qlcd_wp_chatbot_email_sub));

                $qlcd_wp_chatbot_we_have_found = $_POST["qlcd_wp_chatbot_we_have_found"];
                update_option('qlcd_wp_chatbot_we_have_found', sanitize_text_field($qlcd_wp_chatbot_we_have_found));
				
                $qlcd_wp_chatbot_email_sent = $_POST["qlcd_wp_chatbot_email_sent"];
                update_option('qlcd_wp_chatbot_email_sent', sanitize_text_field($qlcd_wp_chatbot_email_sent));
				
				$qlcd_wp_site_search = $_POST["qlcd_wp_site_search"];
                update_option('qlcd_wp_site_search', sanitize_text_field($qlcd_wp_site_search));
				
				$qlcd_wp_livechat = @$_POST["qlcd_wp_livechat"];
                update_option('qlcd_wp_livechat', sanitize_text_field($qlcd_wp_livechat));
				
				$qlcd_wp_email_subscription = $_POST["qlcd_wp_email_subscription"];
                update_option('qlcd_wp_email_subscription', sanitize_text_field($qlcd_wp_email_subscription));

                $qlcd_wp_email_unsubscription = stripslashes($_POST["qlcd_wp_email_unsubscription"]);
                update_option('qlcd_wp_email_unsubscription', sanitize_text_field($qlcd_wp_email_unsubscription));
				
				$qlcd_wp_send_us_email = stripslashes($_POST["qlcd_wp_send_us_email"]);
                update_option('qlcd_wp_send_us_email', sanitize_text_field($qlcd_wp_send_us_email));
				
				$qlcd_wp_leave_feedback = stripslashes($_POST["qlcd_wp_leave_feedback"]);
                update_option('qlcd_wp_leave_feedback', sanitize_text_field($qlcd_wp_leave_feedback));
				
                $qlcd_wp_chatbot_email_fail = stripslashes($_POST["qlcd_wp_chatbot_email_fail"]);
                update_option('qlcd_wp_chatbot_email_fail', sanitize_text_field($qlcd_wp_chatbot_email_fail));
                //Notifications messages building.
                $qlcd_wp_chatbot_notification_interval = stripslashes($_POST["qlcd_wp_chatbot_notification_interval"]);
                update_option('qlcd_wp_chatbot_notification_interval', sanitize_text_field($qlcd_wp_chatbot_notification_interval));
                $qlcd_wp_chatbot_notifications = $_POST["qlcd_wp_chatbot_notifications"];
                update_option('qlcd_wp_chatbot_notifications', serialize($qlcd_wp_chatbot_notifications));

                $qlcd_wp_chatbot_notifications_intent = $_POST["qlcd_wp_chatbot_notifications_intent"];
                update_option('qlcd_wp_chatbot_notifications_intent', serialize($qlcd_wp_chatbot_notifications_intent));
                

                //Support building part.
                $support_query = $_POST["support_query"];
                update_option('support_query', serialize($support_query));
                $support_ans = $_POST["support_ans"];
                update_option('support_ans', serialize($support_ans));
				
				$custom_intent = $_POST["qlcd_wp_custon_intent"];
                update_option('qlcd_wp_custon_intent', serialize($custom_intent));
				$custom_intent_label = $_POST["qlcd_wp_custon_intent_label"];
                update_option('qlcd_wp_custon_intent_label', serialize($custom_intent_label));
                if(isset($_POST["qlcd_wp_custon_intent_checkbox"]) && is_array($_POST["qlcd_wp_custon_intent_checkbox"])){
                    foreach($_POST["qlcd_wp_custon_intent_checkbox"] as $key=>$val){
                        if($val==''){
                            $_POST["qlcd_wp_custon_intent_checkbox"][$key] = 1;
                        }
                    }
                }
                $custom_intent_email = @$_POST["qlcd_wp_custon_intent_checkbox"];
                update_option('qlcd_wp_custon_intent_checkbox', serialize($custom_intent_email));

                $qlcd_wp_custon_menu = $_POST["qlcd_wp_custon_menu"];
                update_option('qlcd_wp_custon_menu', serialize($qlcd_wp_custon_menu));

				$qlcd_wp_custon_menu_link = $_POST["qlcd_wp_custon_menu_link"];
                update_option('qlcd_wp_custon_menu_link', serialize($qlcd_wp_custon_menu_link));

                if(isset($_POST["qlcd_wp_custon_menu_checkbox"]) && is_array($_POST["qlcd_wp_custon_menu_checkbox"])){
                    foreach($_POST["qlcd_wp_custon_menu_checkbox"] as $key=>$val){
                        if($val==''){
                            $_POST["qlcd_wp_custon_menu_checkbox"][$key] = 1;
                        }
                    }
                }
                $qlcd_wp_custon_menu_target = @$_POST["qlcd_wp_custon_menu_checkbox"];
                update_option('qlcd_wp_custon_menu_checkbox', serialize($qlcd_wp_custon_menu_target));

                
				
                //Create Mobile app pages.
                if(isset( $_POST["wp_chatbot_app_pages"])) {
                    $wp_chatbot_app_pages = sanitize_text_field($_POST["wp_chatbot_app_pages"]);
                }else{ $wp_chatbot_app_pages='';}
                update_option('wp_chatbot_app_pages', stripslashes($wp_chatbot_app_pages));
                //Messenger Options
                if(isset( $_POST["enable_wp_chatbot_messenger"])) {
                    $enable_wp_chatbot_messenger = sanitize_text_field($_POST["enable_wp_chatbot_messenger"]);
                }else{ $enable_wp_chatbot_messenger='';}
                update_option('enable_wp_chatbot_messenger', stripslashes($enable_wp_chatbot_messenger));
                if(isset( $_POST["enable_wp_chatbot_messenger_floating_icon"])) {
                    $enable_wp_chatbot_messenger_floating_icon = sanitize_text_field($_POST["enable_wp_chatbot_messenger_floating_icon"]);
                }else{ $enable_wp_chatbot_messenger_floating_icon='';}
                update_option('enable_wp_chatbot_messenger_floating_icon', stripslashes($enable_wp_chatbot_messenger_floating_icon));
                $qlcd_wp_chatbot_fb_app_id = $_POST["qlcd_wp_chatbot_fb_app_id"];
                update_option('qlcd_wp_chatbot_fb_app_id', sanitize_text_field($qlcd_wp_chatbot_fb_app_id));
                $qlcd_wp_chatbot_fb_page_id = $_POST["qlcd_wp_chatbot_fb_page_id"];
                update_option('qlcd_wp_chatbot_fb_page_id', sanitize_text_field($qlcd_wp_chatbot_fb_page_id));
                $qlcd_wp_chatbot_fb_color= $_POST["qlcd_wp_chatbot_fb_color"];
                update_option('qlcd_wp_chatbot_fb_color', stripslashes($qlcd_wp_chatbot_fb_color));
                $qlcd_wp_chatbot_fb_in_msg = $_POST["qlcd_wp_chatbot_fb_in_msg"];
                update_option('qlcd_wp_chatbot_fb_in_msg', sanitize_text_field($qlcd_wp_chatbot_fb_in_msg));
                $qlcd_wp_chatbot_fb_out_msg = $_POST["qlcd_wp_chatbot_fb_out_msg"];
                update_option('qlcd_wp_chatbot_fb_out_msg', sanitize_text_field($qlcd_wp_chatbot_fb_out_msg));
                //Skype option
                if(isset( $_POST["enable_wp_chatbot_skype_floating_icon"])) {
                $enable_wp_chatbot_skype_floating_icon = $_POST["enable_wp_chatbot_skype_floating_icon"];
                }else{ $enable_wp_chatbot_skype_floating_icon='';}
                update_option('enable_wp_chatbot_skype_floating_icon', sanitize_text_field($enable_wp_chatbot_skype_floating_icon));
                if(isset( $_POST["enable_wp_chatbot_skype_id"])) {
                    $enable_wp_chatbot_skype_id = $_POST["enable_wp_chatbot_skype_id"];
                }else{ $enable_wp_chatbot_skype_id='';}
                update_option('enable_wp_chatbot_skype_id', sanitize_text_field($enable_wp_chatbot_skype_id));
                //WhatsApp
                if(isset( $_POST["enable_wp_chatbot_whats"])) {
                    $enable_wp_chatbot_whats= $_POST["enable_wp_chatbot_whats"];
                }else{ $enable_wp_chatbot_whats='';}
                update_option('enable_wp_chatbot_whats', sanitize_text_field($enable_wp_chatbot_whats));
                $qlcd_wp_chatbot_whats_label = $_POST["qlcd_wp_chatbot_whats_label"];
                update_option('qlcd_wp_chatbot_whats_label', serialize($qlcd_wp_chatbot_whats_label));
                if(isset( $_POST["enable_wp_chatbot_floating_whats"])) {
                    $enable_wp_chatbot_floating_whats= $_POST["enable_wp_chatbot_floating_whats"];
                }else{ $enable_wp_chatbot_floating_whats='';}
                update_option('enable_wp_chatbot_floating_whats', sanitize_text_field($enable_wp_chatbot_floating_whats));
                $qlcd_wp_chatbot_whats_num = $_POST["qlcd_wp_chatbot_whats_num"];
                update_option('qlcd_wp_chatbot_whats_num', sanitize_text_field($qlcd_wp_chatbot_whats_num));
               //Viber
                if(isset( $_POST["enable_wp_chatbot_floating_viber"])) {
                    $enable_wp_chatbot_floating_viber = $_POST["enable_wp_chatbot_floating_viber"];
                }else{ $enable_wp_chatbot_floating_viber='';}
                update_option('enable_wp_chatbot_floating_viber', sanitize_text_field($enable_wp_chatbot_floating_viber));
                $qlcd_wp_chatbot_viber_acc = $_POST["qlcd_wp_chatbot_viber_acc"];
                update_option('qlcd_wp_chatbot_viber_acc', sanitize_text_field($qlcd_wp_chatbot_viber_acc));
                //Others integration
                if(isset( $_POST["enable_wp_chatbot_floating_phone"])) {
                    $enable_wp_chatbot_floating_phone = $_POST["enable_wp_chatbot_floating_phone"];
                }else{ $enable_wp_chatbot_floating_phone='';}
                update_option('enable_wp_chatbot_floating_phone', sanitize_text_field($enable_wp_chatbot_floating_phone));
				
				if(isset( $_POST["enable_wp_chatbot_floating_livechat"])) {
                    $enable_wp_chatbot_floating_livechat = $_POST["enable_wp_chatbot_floating_livechat"];
                }else{ $enable_wp_chatbot_floating_livechat='';}
                update_option('enable_wp_chatbot_floating_livechat', sanitize_text_field($enable_wp_chatbot_floating_livechat));
				
				if(isset( $_POST["enable_wp_custom_intent_livechat_button"])) {
                    $enable_wp_custom_intent_livechat_button = $_POST["enable_wp_custom_intent_livechat_button"];
                }else{ $enable_wp_custom_intent_livechat_button='';}
                update_option('enable_wp_custom_intent_livechat_button', sanitize_text_field($enable_wp_custom_intent_livechat_button));
				
				
                $qlcd_wp_chatbot_phone = $_POST["qlcd_wp_chatbot_phone"];
                update_option('qlcd_wp_chatbot_phone', sanitize_text_field($qlcd_wp_chatbot_phone));
				
				$qlcd_wp_chatbot_livechatlink = (isset($_POST["qlcd_wp_chatbot_livechatlink"])?$_POST["qlcd_wp_chatbot_livechatlink"]:'');
                update_option('qlcd_wp_chatbot_livechatlink', sanitize_text_field($qlcd_wp_chatbot_livechatlink));
				
				$qlcd_wp_livechat_button_label = (isset($_POST["qlcd_wp_livechat_button_label"])?$_POST["qlcd_wp_livechat_button_label"]:'');
                update_option('qlcd_wp_livechat_button_label', sanitize_text_field($qlcd_wp_livechat_button_label));
				
				$wp_custom_icon_livechat = $_POST["wp_custom_icon_livechat"];
                update_option('wp_custom_icon_livechat', sanitize_text_field($wp_custom_icon_livechat));
				
				$wp_custom_help_icon = $_POST["wp_custom_help_icon"];
                update_option('wp_custom_help_icon', sanitize_text_field($wp_custom_help_icon));

                $wp_custom_client_icon = $_POST["wp_custom_client_icon"];
                update_option('wp_custom_client_icon', sanitize_text_field($wp_custom_client_icon));
				
				$wp_custom_support_icon = $_POST["wp_custom_support_icon"];
                update_option('wp_custom_support_icon', sanitize_text_field($wp_custom_support_icon));
				
				$wp_custom_chat_icon = $_POST["wp_custom_chat_icon"];
                update_option('wp_custom_chat_icon', sanitize_text_field($wp_custom_chat_icon));

                $wp_custom_typing_icon = $_POST["wp_custom_typing_icon"];
                update_option('wp_custom_typing_icon', sanitize_text_field($wp_custom_typing_icon));
                

                if(isset( $_POST["enable_wp_chatbot_floating_link"])) {
                    $enable_wp_chatbot_floating_link = $_POST["enable_wp_chatbot_floating_link"];
                }else{ $enable_wp_chatbot_floating_link='';}
                update_option('enable_wp_chatbot_floating_link', sanitize_text_field($enable_wp_chatbot_floating_link));
                $qlcd_wp_chatbot_weblink = $_POST["qlcd_wp_chatbot_weblink"];
                update_option('qlcd_wp_chatbot_weblink', sanitize_text_field($qlcd_wp_chatbot_weblink));

                //Re Targetting.
                $qlcd_wp_chatbot_ret_greet = $_POST["qlcd_wp_chatbot_ret_greet"];
                update_option('qlcd_wp_chatbot_ret_greet', sanitize_text_field($qlcd_wp_chatbot_ret_greet));

                if(isset( $_POST["enable_wp_chatbot_exit_intent"])) {
                    $enable_wp_chatbot_exit_intent = $_POST["enable_wp_chatbot_exit_intent"];
                }else{ $enable_wp_chatbot_exit_intent='';}
                update_option('enable_wp_chatbot_exit_intent', sanitize_text_field($enable_wp_chatbot_exit_intent));

                $wp_chatbot_exit_intent_msg = ($_POST["wp_chatbot_exit_intent_msg"]);
                update_option('wp_chatbot_exit_intent_msg', stripslashes($wp_chatbot_exit_intent_msg));
				
				$wp_chatbot_exit_intent_custom = sanitize_text_field($_POST["wp_chatbot_exit_intent_custom"]);
                update_option('wp_chatbot_exit_intent_custom', stripslashes($wp_chatbot_exit_intent_custom));

                
                if(isset( $_POST["wp_chatbot_exit_intent_bargain_pro_single_page"])) {
                    $wp_chatbot_exit_intent_bargain_pro_single_page = $_POST["wp_chatbot_exit_intent_bargain_pro_single_page"];
                }else{ $wp_chatbot_exit_intent_bargain_pro_single_page='';}
                update_option('wp_chatbot_exit_intent_bargain_pro_single_page', sanitize_text_field($wp_chatbot_exit_intent_bargain_pro_single_page));

                
				$wp_chatbot_exit_intent_email = sanitize_text_field(@$_POST["wp_chatbot_exit_intent_email"]);
                update_option('wp_chatbot_exit_intent_email', stripslashes($wp_chatbot_exit_intent_email));

                if(isset( $_POST["wp_chatbot_exit_intent_once"])) {
                    $wp_chatbot_exit_intent_once = sanitize_text_field($_POST["wp_chatbot_exit_intent_once"]);
                }else{ $wp_chatbot_exit_intent_once='';}
                update_option('wp_chatbot_exit_intent_once', sanitize_text_field($wp_chatbot_exit_intent_once));

                if(isset( $_POST["enable_wp_chatbot_scroll_open"])) {
                    $enable_wp_chatbot_scroll_open = sanitize_text_field($_POST["enable_wp_chatbot_scroll_open"]);
                }else{ $enable_wp_chatbot_scroll_open='';}
                update_option('enable_wp_chatbot_scroll_open', sanitize_text_field($enable_wp_chatbot_scroll_open));

                $wp_chatbot_scroll_open_msg= sanitize_text_field($_POST["wp_chatbot_scroll_open_msg"]);
                update_option('wp_chatbot_scroll_open_msg', stripslashes($wp_chatbot_scroll_open_msg));

                
                if(isset( $_POST["wp_chatbot_exit_intent_bargain_msg"])) {
                    $wp_chatbot_exit_intent_bargain_msg = sanitize_text_field($_POST["wp_chatbot_exit_intent_bargain_msg"]);
                }else{ $wp_chatbot_exit_intent_bargain_msg='';}
                update_option('wp_chatbot_exit_intent_bargain_msg', sanitize_text_field($wp_chatbot_exit_intent_bargain_msg));

                
				
				$wp_chatbot_scroll_open_custom= sanitize_text_field($_POST["wp_chatbot_scroll_open_custom"]);
                update_option('wp_chatbot_scroll_open_custom', stripslashes($wp_chatbot_scroll_open_custom));
				
				$wp_chatbot_scroll_open_email= sanitize_text_field(@$_POST["wp_chatbot_scroll_open_email"]);
                update_option('wp_chatbot_scroll_open_email', stripslashes($wp_chatbot_scroll_open_email));

                $wp_chatbot_scroll_percent= sanitize_text_field($_POST["wp_chatbot_scroll_percent"]);
                update_option('wp_chatbot_scroll_percent', stripslashes($wp_chatbot_scroll_percent));

                if(isset( $_POST["wp_chatbot_scroll_once"])) {
                    $wp_chatbot_scroll_once = $_POST["wp_chatbot_scroll_once"];
                }else{ $wp_chatbot_scroll_once='';}
                update_option('wp_chatbot_scroll_once', sanitize_text_field($wp_chatbot_scroll_once));

                if(isset( $_POST["enable_wp_chatbot_auto_open"])) {
                    $enable_wp_chatbot_auto_open = $_POST["enable_wp_chatbot_auto_open"];
                }else{ $enable_wp_chatbot_auto_open='';}
                update_option('enable_wp_chatbot_auto_open', sanitize_text_field($enable_wp_chatbot_auto_open));

                if(isset( $_POST["enable_wp_chatbot_ret_sound"])) {
                    $enable_wp_chatbot_ret_sound = $_POST["enable_wp_chatbot_ret_sound"];
                }else{ $enable_wp_chatbot_ret_sound='';}
                update_option('enable_wp_chatbot_ret_sound', sanitize_text_field($enable_wp_chatbot_ret_sound));

                if(isset( $_POST["enable_wp_chatbot_sound_initial"])) {
                    $enable_wp_chatbot_sound_initial = $_POST["enable_wp_chatbot_sound_initial"];
                }else{ $enable_wp_chatbot_sound_initial='';}
                update_option('enable_wp_chatbot_sound_initial', sanitize_text_field($enable_wp_chatbot_sound_initial));


                $wp_chatbot_auto_open_msg = sanitize_text_field($_POST["wp_chatbot_auto_open_msg"]);
                update_option('wp_chatbot_auto_open_msg', stripslashes($wp_chatbot_auto_open_msg));
				
				$wp_chatbot_auto_open_custom = sanitize_text_field($_POST["wp_chatbot_auto_open_custom"]);
                update_option('wp_chatbot_auto_open_custom', stripslashes($wp_chatbot_auto_open_custom));
				
				$wp_chatbot_auto_open_email = sanitize_text_field(@$_POST["wp_chatbot_auto_open_email"]);
                update_option('wp_chatbot_auto_open_email', stripslashes($wp_chatbot_auto_open_email));

                $wp_chatbot_auto_open_time = sanitize_text_field($_POST["wp_chatbot_auto_open_time"]);
                update_option('wp_chatbot_auto_open_time', stripslashes($wp_chatbot_auto_open_time));
                //to complate checkout
                if(isset( $_POST["enable_wp_chatbot_ret_user_show"])) {
                    $enable_wp_chatbot_ret_user_show = $_POST["enable_wp_chatbot_ret_user_show"];
                }else{ $enable_wp_chatbot_ret_user_show='';}
                update_option('enable_wp_chatbot_ret_user_show', sanitize_text_field($enable_wp_chatbot_ret_user_show));

                if(isset( $_POST["enable_wp_chatbot_inactive_time_show"])) {
                    $enable_wp_chatbot_inactive_time_show = $_POST["enable_wp_chatbot_inactive_time_show"];
                }else{ $enable_wp_chatbot_inactive_time_show='';}
                update_option('enable_wp_chatbot_inactive_time_show', sanitize_text_field($enable_wp_chatbot_inactive_time_show));

                $wp_chatbot_inactive_time = @$_POST["wp_chatbot_inactive_time"];
                update_option('wp_chatbot_inactive_time', sanitize_text_field($wp_chatbot_inactive_time));

                $wp_chatbot_checkout_msg = @$_POST["wp_chatbot_checkout_msg"];
                update_option('wp_chatbot_checkout_msg', stripslashes($wp_chatbot_checkout_msg));

                if(isset( $_POST["wp_chatbot_auto_open_once"])) {
                    $wp_chatbot_auto_open_once = $_POST["wp_chatbot_auto_open_once"];
                }else{ $wp_chatbot_auto_open_once='';}
                update_option('wp_chatbot_auto_open_once', sanitize_text_field($wp_chatbot_auto_open_once));

                if(isset( $_POST["wp_chatbot_inactive_once"])) {
                    $wp_chatbot_inactive_once = $_POST["wp_chatbot_inactive_once"];
                }else{ $wp_chatbot_inactive_once='';}
                update_option('wp_chatbot_inactive_once', sanitize_text_field($wp_chatbot_inactive_once));


                $wp_chatbot_proactive_bg_color = $_POST["wp_chatbot_proactive_bg_color"];
                update_option('wp_chatbot_proactive_bg_color', sanitize_text_field($wp_chatbot_proactive_bg_color));

                if(isset( $_POST["disable_wp_chatbot_call_gen"])) {
                    $disable_wp_chatbot_call_gen = $_POST["disable_wp_chatbot_call_gen"];
                }else{ $disable_wp_chatbot_call_gen='';}
                update_option('disable_wp_chatbot_call_gen', sanitize_text_field($disable_wp_chatbot_call_gen));

                if(isset( $_POST["disable_wp_chatbot_call_sup"])) {
                    $disable_wp_chatbot_call_sup = $_POST["disable_wp_chatbot_call_sup"];
                }else{ $disable_wp_chatbot_call_sup='';}
                update_option('disable_wp_chatbot_call_sup', sanitize_text_field($disable_wp_chatbot_call_sup));

                if(isset( $_POST["disable_wp_chatbot_feedback"])) {
                    $disable_wp_chatbot_feedback = $_POST["disable_wp_chatbot_feedback"];
                }else{ $disable_wp_chatbot_feedback='';}
                update_option('disable_wp_chatbot_feedback', sanitize_text_field($disable_wp_chatbot_feedback));
				
				if(isset( $_POST["disable_wp_leave_feedback"])) {
                    $disable_wp_leave_feedback = $_POST["disable_wp_leave_feedback"];
                }else{ $disable_wp_leave_feedback='';}
                update_option('disable_wp_leave_feedback', sanitize_text_field($disable_wp_leave_feedback));
				
				if(isset( $_POST["disable_wp_chatbot_site_search"])) {
                    $disable_wp_chatbot_site_search = $_POST["disable_wp_chatbot_site_search"];
                }else{ $disable_wp_chatbot_site_search='';}
                update_option('disable_wp_chatbot_site_search', sanitize_text_field($disable_wp_chatbot_site_search));
				
				if(isset( $_POST["disable_wp_chatbot_faq"])) {
                    $disable_wp_chatbot_faq = $_POST["disable_wp_chatbot_faq"];
                }else{ $disable_wp_chatbot_faq='';}
                update_option('disable_wp_chatbot_faq', sanitize_text_field($disable_wp_chatbot_faq));
				
				if(isset( $_POST["disable_email_subscription"])) {
                    $disable_email_subscription = $_POST["disable_email_subscription"];
                }else{ $disable_email_subscription='';}
                update_option('disable_email_subscription', sanitize_text_field($disable_email_subscription));
				
				if(isset( $_POST["disable_livechat"])) {
                    $disable_livechat = $_POST["disable_livechat"];
                }else{ $disable_livechat='';}
                update_option('disable_livechat', sanitize_text_field($disable_livechat));

                if(isset( $_POST["disable_livechat_opration_icon"])) {
                    $disable_livechat_opration_icon = $_POST["disable_livechat_opration_icon"];
                }else{ $disable_livechat_opration_icon='';}
                update_option('disable_livechat_opration_icon', sanitize_text_field($disable_livechat_opration_icon));

                $qlcd_wp_chatbot_feedback_label = $_POST["qlcd_wp_chatbot_feedback_label"];
                update_option('qlcd_wp_chatbot_feedback_label', serialize($qlcd_wp_chatbot_feedback_label));

                if(isset( $_POST["enable_wp_chatbot_meta_title"])) {
                    $enable_wp_chatbot_meta_title = $_POST["enable_wp_chatbot_meta_title"];
                }else{ $enable_wp_chatbot_meta_title='';}
                update_option('enable_wp_chatbot_meta_title', sanitize_text_field($enable_wp_chatbot_meta_title));

                $qlcd_wp_chatbot_meta_label = $_POST["qlcd_wp_chatbot_meta_label"];
                update_option('qlcd_wp_chatbot_meta_label', sanitize_text_field($qlcd_wp_chatbot_meta_label));

                $qlcd_wp_chatbot_phone_sent = $_POST["qlcd_wp_chatbot_phone_sent"];
                update_option('qlcd_wp_chatbot_phone_sent', sanitize_text_field($qlcd_wp_chatbot_phone_sent));

                $qlcd_wp_chatbot_phone_fail = $_POST["qlcd_wp_chatbot_phone_fail"];
                update_option('qlcd_wp_chatbot_phone_fail', sanitize_text_field($qlcd_wp_chatbot_phone_fail));

                if(isset( $_POST["enable_wp_chatbot_opening_hour"])) {
                    $enable_wp_chatbot_opening_hour = $_POST["enable_wp_chatbot_opening_hour"];
                }else{ $enable_wp_chatbot_opening_hour='';}
                update_option('enable_wp_chatbot_opening_hour', sanitize_text_field($enable_wp_chatbot_opening_hour));

                $wpwbot_hours= $_POST["wpwbot_hours"];
                update_option('wpwbot_hours', serialize($wpwbot_hours));

                if(isset( $_POST["enable_wp_chatbot_dailogflow"])) {
                    $enable_wp_chatbot_dailogflow = $_POST["enable_wp_chatbot_dailogflow"];
                }else{ $enable_wp_chatbot_dailogflow='';}
                update_option('enable_wp_chatbot_dailogflow', sanitize_text_field($enable_wp_chatbot_dailogflow));

                if(isset( $_POST["wpbot_trigger_intent"])) {
                    $wpbot_trigger_intent = $_POST["wpbot_trigger_intent"];
                }else{ $wpbot_trigger_intent='';}
                update_option('wpbot_trigger_intent', sanitize_text_field($wpbot_trigger_intent));

                if(isset( $_POST["enable_authentication_webhook"])) {
                    $enable_authentication_webhook = $_POST["enable_authentication_webhook"];
                }else{ $enable_authentication_webhook='';}
                update_option('enable_authentication_webhook', sanitize_text_field($enable_authentication_webhook));

                if(isset( $_POST["qcld_auth_username"])) {
                    $qcld_auth_username = $_POST["qcld_auth_username"];
                }else{ $qcld_auth_username='';}
                update_option('qcld_auth_username', sanitize_text_field($qcld_auth_username));

                if(isset( $_POST["qcld_auth_password"])) {
                    $qcld_auth_password = $_POST["qcld_auth_password"];
                }else{ $qcld_auth_password='';}
                update_option('qcld_auth_password', sanitize_text_field($qcld_auth_password));


                $qlcd_wp_chatbot_dialogflow_client_token= $_POST["qlcd_wp_chatbot_dialogflow_client_token"];
                update_option('qlcd_wp_chatbot_dialogflow_client_token', sanitize_text_field($qlcd_wp_chatbot_dialogflow_client_token));

                $qlcd_wp_chatbot_dialogflow_project_id= $_POST["qlcd_wp_chatbot_dialogflow_project_id"];
                update_option('qlcd_wp_chatbot_dialogflow_project_id', sanitize_text_field($qlcd_wp_chatbot_dialogflow_project_id));

                $wp_chatbot_df_api= @$_POST["wp_chatbot_df_api"];
                update_option('wp_chatbot_df_api', sanitize_text_field($wp_chatbot_df_api));

                
               
                $qlcd_wp_chatbot_dialogflow_project_key= $_POST["qlcd_wp_chatbot_dialogflow_project_key"];
                update_option('qlcd_wp_chatbot_dialogflow_project_key', stripslashes($qlcd_wp_chatbot_dialogflow_project_key));

                $qlcd_wp_chatbot_dialogflow_defualt_reply= $_POST["qlcd_wp_chatbot_dialogflow_defualt_reply"];
                update_option('qlcd_wp_chatbot_dialogflow_defualt_reply', sanitize_text_field($qlcd_wp_chatbot_dialogflow_defualt_reply));
				
				$qlcd_wp_chatbot_dialogflow_agent_language= $_POST["qlcd_wp_chatbot_dialogflow_agent_language"];
                update_option('qlcd_wp_chatbot_dialogflow_agent_language', sanitize_text_field($qlcd_wp_chatbot_dialogflow_agent_language));

            }
        }
    }
    /**
     * Display Notifications on specific criteria.
     *
     * @since    2.14
     */
    public static function woocommerce_inactive_notice_for_wp_chatbot()
    {
        if (current_user_can('activate_plugins')) :
            if (!class_exists('wpCommerce')) :
                deactivate_plugins(plugin_basename(__FILE__));
                ?>
                <div id="message" class="error">
                    <p>
                        <?php
                        printf(
                            esc_html__('%s WPBot for wpCommerce REQUIRES wpCommerce%s %swpCommerce%s must be active for WPBot to work. Please install & activate wpCommerce.', 'wpchatbot'),
                            '<strong>',
                            '</strong><br>',
                            '<a href="http://wordpress.org/extend/plugins/woocommerce/" target="_blank" >',
                            '</a>'
                        );
                        ?>
                    </p>
                </div>
                <?php
            elseif (version_compare(get_option('woocommerce_db_version'), QCLD_wpCHATBOT_REQUIRED_wpCOMMERCE_VERSION, '<')) :
                ?>
                <div id="message" class="error">
                   
                    <p>
                        <?php
                        printf(
                            esc_html__('%WPBot for wpCommerce is inactive%s This version of WpBot requires wpCommerce %s or newer. For more information about our wpCommerce version support %sclick here%s.', 'wpchatbot'),
                            '<strong>',
                            '</strong><br>',
                            QCLD_wpCHATBOT_REQUIRED_wpCOMMERCE_VERSION
                        );
                        ?>
                    </p>
                    <div class="wpbot_clear"></div>
                </div>
                <?php
            endif;
        endif;
    }
    /**
     * Admin notice for table reindex
     */
    public function admin_notice_reindex() { ?>
        <div class="updated notice is-dismissible">
            <p><?php printf( esc_html__( 'WPBot Pro : To Enable Title, Content, Excerpt, Categories, Tag and SKU Search Re-Index Products is required. %s', 'wpchatbot' ),'<a class="button button-secondary" href="'.esc_url( admin_url( 'admin.php?page=wpbot') ).'">'.esc_html__( 'Re-Index Products', 'wp_chatbot' ).'</a>'); ?></p>
        </div>
    <?php }
}
/**
 * Instantiate plugin.
 *
 */
if (!function_exists('qcld_wb_chatboot_plugin_init')) {
    function qcld_wb_chatboot_plugin_init()
    {
        global $qcld_wb_chatbot;
        $qcld_wb_chatbot = qcld_wb_Chatbot::qcld_wb_chatbot_get_instance();
    }
}
add_action('plugins_loaded', 'qcld_wb_chatboot_plugin_init');
/*
 * Initial Options will be insert as defualt data
 */


if(!function_exists('qcwp_isset_table_column')) {
	function qcwp_isset_table_column($table_name, $column_name)
	{
		global $wpdb;
		$columns = $wpdb->get_results("SHOW COLUMNS FROM  " . $table_name, ARRAY_A);
		foreach ($columns as $column) {
			if ($column['Field'] == $column_name) {
				return true;
			}
		}
	}
}


register_activation_hook(__FILE__, 'qcld_wb_chatboot_defualt_options');
function qcld_wb_chatboot_defualt_options($network_wide){
	
    global $wpdb;
    

    if ( is_multisite() && $network_wide ) {
        // Get all blogs in the network and activate plugin on each one
        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
        foreach ( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
            qcld_create_table_all();
            restore_current_blog();
        }
    } else {
        qcld_create_table_all();
    }

}

function qcld_create_table_all(){

    global $wpdb;

	$collate = '';
	if ( $wpdb->has_cap( 'collation' ) ) {

		if ( ! empty( $wpdb->charset ) ) {

			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {

			$collate .= " COLLATE $wpdb->collate";

		}
	}
	$table    = $wpdb->prefix.'wpbot_subscription';
	$sql_sliders_Table = "
		CREATE TABLE IF NOT EXISTS `$table` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(256) NOT NULL,
          `email` varchar(256) NOT NULL,
          `phone` varchar(256) NOT NULL,
		  `url` text NOT NULL,
		  `date` datetime NOT NULL,
		  `user_agent` text NOT NULL,
		  PRIMARY KEY (`id`)
		)  $collate AUTO_INCREMENT=1 ";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_sliders_Table );
    if ( ! qcwp_isset_table_column( $table, 'phone' ) ) {
		$sql_wp_Table_update_1 = "ALTER TABLE `$table` ADD `phone` varchar(256) NOT NULL;";
		$wpdb->query( $sql_wp_Table_update_1 );
	}

    //Bot User Table
    $table1    = $wpdb->prefix.'wpbot_user';
	$sql_sliders_Table1 = "
		CREATE TABLE IF NOT EXISTS `$table1` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `session_id` varchar(256) NOT NULL,
          `name` varchar(256) NOT NULL,
          `email` varchar(256) NOT NULL,
          `phone` varchar(256) NOT NULL,
		  `date` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		)  $collate AUTO_INCREMENT=1 ";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_sliders_Table1 );


    if ( ! qcwp_isset_table_column( $table1, 'phone' ) ) {
		$sql_wp_Table_update_1 = "ALTER TABLE `$table1` ADD `phone` varchar(256) NOT NULL;";
		$wpdb->query( $sql_wp_Table_update_1 );
	}

    //Bot User Table
    $table1    = $wpdb->prefix.'wpbot_Conversation';
	$sql_sliders_Table1 = "
		CREATE TABLE IF NOT EXISTS `$table1` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) NOT NULL,
          `conversation` LONGTEXT NOT NULL,
		  PRIMARY KEY (`id`)
		)  $collate AUTO_INCREMENT=1 ";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_sliders_Table1 );


    //Bot User Table
    $table1    = $wpdb->prefix.'wpbot_sessions';
	$sql_sliders_Table1 = "
		CREATE TABLE IF NOT EXISTS `$table1` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `session` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		)  $collate AUTO_INCREMENT=1 ";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_sliders_Table1 );
    

    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = get_option('admin_email');

    if(!get_option('wp_chatbot_position_x')) {
        update_option('wp_chatbot_position_x', 50);
    }
    if(!get_option('wp_chatbot_position_y')) {
        update_option('wp_chatbot_position_y', 50);
    }
    if(!get_option('wp_chatbot_position_in')) {
        update_option('wp_chatbot_position_in', 'px');
    }
    if(!get_option('disable_wp_chatbot')) {
        update_option('disable_wp_chatbot', '');
    }
    if(!get_option('disable_wp_chatbot_floating_icon')) {
        update_option('disable_wp_chatbot_floating_icon', '');
    }
	if(!get_option('skip_wp_greetings')) {
        update_option('skip_wp_greetings', '');
    }

    if(!get_option('skip_wp_greetings_trigger_intent')) {
        update_option('skip_wp_greetings_trigger_intent', '');
    }

    if(!get_option('show_menu_after_greetings')) {
        update_option('show_menu_after_greetings', '');
    }

    if(!get_option('enable_wp_chatbot_disable_producticon')) {
        update_option('enable_wp_chatbot_disable_producticon', '');
    }
    if(!get_option('enable_wp_chatbot_disable_carticon')) {
        update_option('enable_wp_chatbot_disable_carticon', '');
    }

    
    

    if(!get_option('wpbot_support_mail_to_crm_contact')) {
        update_option('wpbot_support_mail_to_crm_contact', 1);
    }
    
    if(!get_option('disable_first_msg')) {
        update_option('disable_first_msg', '');
    }
    if(!get_option('enable_reset_close_button')) {
        update_option('enable_reset_close_button', '');
    }
    if(!get_option('qc_auto_hide_floating_button')) {
        update_option('qc_auto_hide_floating_button', '');
    }

    

    if(!get_option('qlcd_wp_chatbot_reset_lan')) {
        update_option('qlcd_wp_chatbot_reset_lan', 'Reset');
    }

    if(!get_option('qlcd_wp_chatbot_close_lan')) {
        update_option('qlcd_wp_chatbot_close_lan', 'Close');
    }

    
	if(!get_option('ask_email_wp_greetings')) {
        update_option('ask_email_wp_greetings', '');
    }
    if(!get_option('ask_phone_wp_greetings')) {
        update_option('ask_phone_wp_greetings', '');
    }
    if(!get_option('qc_email_subscription_offer')) {
        update_option('qc_email_subscription_offer', '');
    }
    
    if(!get_option('enable_wp_chatbot_open_initial')) {
        update_option('enable_wp_chatbot_open_initial', '');
    }
    if(!get_option('disable_wp_chatbot_icon_animation')) {
        update_option('disable_wp_chatbot_icon_animation', '');
    }
    if(!get_option('disable_wp_chatbot_history')) {
        update_option('disable_wp_chatbot_history', '');
    }
    if(!get_option('disable_wp_chatbot_on_mobile')) {
        update_option('disable_wp_chatbot_on_mobile', '');
    }

    if(!get_option('disable_auto_focus_message_area')) {
        update_option('disable_auto_focus_message_area', '');
    }

    
	if(!get_option('disable_livechat_operator_offline')) {
        update_option('disable_livechat_operator_offline', '');
    }
    if(!get_option('disable_wp_chatbot_product_search')) {
        update_option('disable_wp_chatbot_product_search', '');
    }
    if(!get_option('disable_wp_chatbot_catalog')) {
        update_option('disable_wp_chatbot_catalog', '');
    }

    if(!get_option('enable_wp_chatbot_disable_chaticon')) {
        update_option('enable_wp_chatbot_disable_chaticon', '');
    }

    if(!get_option('enable_wp_chatbot_disable_supporticon')) {
        update_option('enable_wp_chatbot_disable_supporticon', '');
    }

    if(!get_option('enable_wp_chatbot_disable_helpicon')) {
        update_option('enable_wp_chatbot_disable_helpicon', '');
    }

    if(!get_option('enable_wp_chatbot_disable_allicon')) {
        update_option('enable_wp_chatbot_disable_allicon', '');
    }

    if(!get_option('disable_wp_chatbot_order_status')) {
        update_option('disable_wp_chatbot_order_status', '');
    }
    if(!get_option('enable_wp_chatbot_rtl')) {
        update_option('enable_wp_chatbot_rtl', '');
    }
    if(!get_option('enable_wp_chatbot_mobile_full_screen')) {
        update_option('enable_wp_chatbot_mobile_full_screen', '');
    }
    if(!get_option('enable_wp_chatbot_gdpr_compliance')) {
        update_option('enable_wp_chatbot_gdpr_compliance', '');
    }
    if(!get_option('wpbot_search_result_new_window')) {
        update_option('wpbot_search_result_new_window', '');
    }

    if(!get_option('wpbot_search_image_size')) {
        update_option('wpbot_search_image_size', 'thumbnail');
    }

    
    if(!get_option('wpbot_disable_repeatative')) {
        update_option('wpbot_disable_repeatative', '');
    }

    if(!get_option('qlcd_wp_chatbot_cart_total')) {
        update_option('qlcd_wp_chatbot_cart_total', serialize(array('Total')));
    }
    

    if(!get_option('wpbot_search_result_number')) {
        update_option('wpbot_search_result_number', '');
    }

    if(!get_option('wpbot_gdpr_text')) {
        update_option('wpbot_gdpr_text', 'We will never spam you! You can read our <a href="#" target="_blank">Privacy Policy here.</a>');
    }

	if(!get_option('no_result_attempt_count')) {
        update_option('no_result_attempt_count', 3);
    }

     if(!get_option('disable_wp_chatbot_notification')) {
        update_option('disable_wp_chatbot_notification', '0');
    }

    if(!get_option('wp_chatbot_exclude_post_list')) {
        update_option('wp_chatbot_exclude_post_list', serialize(array()));
    }

    if(!get_option('wp_chatbot_exclude_pages_list')) {
        update_option('wp_chatbot_exclude_pages_list', serialize(array()));
    }

    if(!get_option('wpbot_click_chat_text')) {
        update_option('wpbot_click_chat_text', 'Click to Chat');
    }
    if(!get_option('qc_wpbot_menu_order')) {
        update_option('qc_wpbot_menu_order', '');
    }

    

    if(!get_option('disable_wp_chatbot_cart_item_number')) {
        update_option('disable_wp_chatbot_cart_item_number', '');
    }
    if(!get_option('disable_wp_chatbot_featured_product')) {
        update_option('disable_wp_chatbot_featured_product', '');
    }
    if(!get_option('disable_wp_chatbot_sale_product')) {
        update_option('disable_wp_chatbot_sale_product', '');
    }
     if(!get_option('wp_chatbot_open_product_detail')) {
        update_option('wp_chatbot_open_product_detail', '');
    }
    if(!get_option('qlcd_wp_chatbot_product_orderby')) {
        update_option('qlcd_wp_chatbot_product_orderby', sanitize_text_field('title'));
    }

    if(!get_option('wp_chatbot_exitintent_show_pages')){
        update_option('wp_chatbot_exitintent_show_pages', 'on');
    }

    if(!get_option('wp_chatbot_exitintent_show_pages_list')) {
        update_option('wp_chatbot_exitintent_show_pages_list', serialize(array()));
    }

    if(!get_option('qlcd_wp_chatbot_product_order')) {
        update_option('qlcd_wp_chatbot_product_order', sanitize_text_field('ASC'));
    }
    if(!get_option('qlcd_wp_chatbot_ppp')) {
        update_option('qlcd_wp_chatbot_ppp', intval(6));
    }
    if(!get_option('wp_chatbot_exclude_stock_out_product')) {
        update_option('wp_chatbot_exclude_stock_out_product', '');
    }
    if(!get_option('wp_chatbot_show_sub_category')) {
        update_option('wp_chatbot_show_sub_category', '');
    }
    if(!get_option('wp_chatbot_vertical_custom')){
        update_option('wp_chatbot_vertical_custom', 'Go To');
    }
    if(!get_option('wp_chatbot_show_home_page')) {
        update_option('wp_chatbot_show_home_page', 'on');
    }
    if(!get_option('wp_chatbot_show_posts')) {
        update_option('wp_chatbot_show_posts', 'on');
    }
    if(!get_option('wp_chatbot_show_pages')){
        update_option('wp_chatbot_show_pages', 'on');
    }
    if(!get_option('wp_chatbot_show_pages_list')) {
        update_option('wp_chatbot_show_pages_list', serialize(array()));
    }
    if(!get_option('wp_chatbot_show_woocommerce')) {
        update_option('wp_chatbot_show_woocommerce', 'on');
    }
    if(!get_option('qlcd_wp_chatbot_stop_words_name')) {
        update_option('qlcd_wp_chatbot_stop_words_name', 'english');
    }
    if(!get_option('qlcd_wp_chatbot_stop_words')) {
        update_option('qlcd_wp_chatbot_stop_words', "a,able,about,above,abst,accordance,according,accordingly,across,act,actually,added,adj,affected,affecting,affects,after,afterwards,again,against,ah,all,almost,alone,along,already,also,although,always,am,among,amongst,an,and,announce,another,any,anybody,anyhow,anymore,anyone,anything,anyway,anyways,anywhere,apparently,approximately,are,aren,arent,arise,around,as,aside,ask,asking,at,auth,available,away,awfully,b,back,be,became,because,become,becomes,becoming,been,before,beforehand,begin,beginning,beginnings,begins,behind,being,believe,below,beside,besides,between,beyond,biol,both,brief,briefly,but,by,c,ca,came,can,cannot,can't,cause,causes,certain,certainly,co,com,come,comes,contain,containing,contains,could,couldnt,d,date,did,didn't,different,do,does,doesn't,doing,done,don't,down,downwards,due,during,e,each,ed,edu,effect,eg,eight,eighty,either,else,elsewhere,end,ending,enough,especially,et,et-al,etc,even,ever,every,everybody,everyone,everything,everywhere,ex,except,f,far,few,ff,fifth,first,five,fix,followed,following,follows,for,former,formerly,forth,found,four,from,further,furthermore,g,gave,get,gets,getting,give,given,gives,giving,go,goes,gone,got,gotten,h,had,happens,hardly,has,hasn't,have,haven't,having,he,hed,hence,her,here,hereafter,hereby,herein,heres,hereupon,hers,herself,hes,hi,hid,him,himself,his,hither,home,how,howbeit,however,hundred,i,id,ie,if,i'll,im,immediate,immediately,importance,important,in,inc,indeed,index,information,instead,into,invention,inward,is,isn't,it,itd,it'll,its,itself,i've,j,just,k,keep,keeps,kept,kg,km,know,known,knows,l,largely,last,lately,later,latter,latterly,least,less,lest,let,lets,like,liked,likely,line,little,'ll,look,looking,looks,ltd,m,made,mainly,make,makes,many,may,maybe,me,mean,means,meantime,meanwhile,merely,mg,might,million,miss,ml,more,moreover,most,mostly,mr,mrs,much,mug,must,my,myself,n,na,name,namely,nay,nd,near,nearly,necessarily,necessary,need,needs,neither,never,nevertheless,new,next,nine,ninety,no,nobody,non,none,nonetheless,noone,nor,normally,nos,not,noted,nothing,now,nowhere,o,obtain,obtained,obviously,of,off,often,oh,ok,okay,old,omitted,on,once,one,ones,only,onto,or,ord,other,others,otherwise,ought,our,ours,ourselves,out,outside,over,overall,owing,own,p,page,pages,part,particular,particularly,past,per,perhaps,placed,please,plus,poorly,possible,possibly,potentially,pp,predominantly,present,previously,primarily,probably,promptly,proud,provides,put,q,que,quickly,quite,qv,r,ran,rather,rd,re,readily,really,recent,recently,ref,refs,regarding,regardless,regards,related,relatively,research,respectively,resulted,resulting,results,right,run,s,said,same,saw,say,saying,says,sec,section,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sent,seven,several,shall,she,shed,she'll,shes,should,shouldn't,show,showed,shown,showns,shows,significant,significantly,similar,similarly,since,six,slightly,so,some,somebody,somehow,someone,somethan,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specifically,specified,specify,specifying,still,stop,strongly,sub,substantially,successfully,such,sufficiently,suggest,sup,sure,t,take,taken,taking,tell,tends,th,than,thank,thanks,thanx,that,that'll,thats,that've,the,their,theirs,them,themselves,then,thence,there,thereafter,thereby,thered,therefore,therein,there'll,thereof,therere,theres,thereto,thereupon,there've,these,they,theyd,they'll,theyre,they've,think,this,those,thou,though,thoughh,thousand,throug,through,throughout,thru,thus,til,tip,to,together,too,took,toward,towards,tried,tries,truly,try,trying,ts,twice,two,u,un,under,unfortunately,unless,unlike,unlikely,until,unto,up,upon,ups,us,use,used,useful,usefully,usefulness,uses,using,usually,v,value,various,'ve,very,via,viz,vol,vols,vs,w,want,wants,was,wasnt,way,we,wed,welcome,we'll,went,were,werent,we've,what,whatever,what'll,whats,when,whence,whenever,where,whereafter,whereas,whereby,wherein,wheres,whereupon,wherever,whether,which,while,whim,whither,who,whod,whoever,whole,who'll,whom,whomever,whos,whose,why,widely,willing,wish,with,within,without,wont,words,world,would,wouldnt,www,x,y,yes,yet,you,youd,you'll,your,youre,yours,yourself,yourselves,you've,z,zero");
    }
    if(!get_option('qlcd_wp_chatbot_order_user')) {
        update_option('qlcd_wp_chatbot_order_user', sanitize_text_field('login'));
    }
    if(!get_option('wp_chatbot_custom_agent_path')) {
        update_option('wp_chatbot_custom_agent_path', '');
    }
    if(!get_option('wp_chatbot_custom_icon_path')) {
        update_option('wp_chatbot_custom_icon_path', '');
    }

    if(!get_option('wp_chatbot_icon') || get_option('wp_chatbot_icon')=='icon-13.png') {
        update_option('wp_chatbot_icon', sanitize_text_field('icon-0.png'));
    }
    if(!get_option('wp_chatbot_agent_image')){
        update_option('wp_chatbot_agent_image',sanitize_text_field('agent-0.png'));
    }
    if(!get_option('qcld_wb_chatbot_theme')) {
        update_option('qcld_wb_chatbot_theme', sanitize_text_field('template-01'));
    }
    if(!get_option('qcld_wb_chatbot_change_bg')) {
        update_option('qcld_wb_chatbot_change_bg', '');
    }
    if(!get_option('wp_chatbot_custom_css')) {
        update_option('wp_chatbot_custom_css', '');
    }
    if(!get_option('qlcd_wp_chatbot_host')) {
        update_option('qlcd_wp_chatbot_host', sanitize_text_field('Our Website'));
    }
    if(!get_option('qlcd_wp_chatbot_agent')) {
        update_option('qlcd_wp_chatbot_agent', sanitize_text_field('Carrie'));
    }
    if(!get_option('qlcd_wp_chatbot_host')) {
        update_option('qlcd_wp_chatbot_host', sanitize_text_field('Our Website'));
    }
    if(!get_option('qlcd_wp_chatbot_shopper_demo_name')) {
        update_option('qlcd_wp_chatbot_shopper_demo_name', sanitize_text_field('Amigo'));
    }
	if(!get_option('qlcd_wp_chatbot_shopper_call_you')) {
        update_option('qlcd_wp_chatbot_shopper_call_you', sanitize_text_field('Ok, I will just call you'));
    }
    if(!get_option('qlcd_wp_chatbot_yes')) {
        update_option('qlcd_wp_chatbot_yes', sanitize_text_field('YES'));
    }
    if(!get_option('qlcd_wp_chatbot_no')) {
        update_option('qlcd_wp_chatbot_no', sanitize_text_field('NO'));
    }
    if(!get_option('qlcd_wp_chatbot_or')) {
        update_option('qlcd_wp_chatbot_or', sanitize_text_field('OR'));
    }
    if(!get_option('qlcd_wp_chatbot_sorry')) {
        update_option('qlcd_wp_chatbot_sorry', sanitize_text_field('Sorry'));
    }
    if(!get_option('qlcd_wp_chatbot_hello')) {
        update_option('qlcd_wp_chatbot_hello', sanitize_text_field('Hello'));
    }

    if(!get_option('qlcd_wp_chatbot_chat_with_us')) {
        update_option('qlcd_wp_chatbot_chat_with_us', sanitize_text_field('Chat with us!'));
    }

    
    if(!get_option('qlcd_wp_chatbot_agent_join')) {
        update_option('qlcd_wp_chatbot_agent_join', serialize(array('has joined the conversation')));
    }
    if(!get_option('qlcd_wp_chatbot_welcome')) {
        update_option('qlcd_wp_chatbot_welcome', serialize(array('Welcome to', 'Glad to have you at')));
    }
    if(!get_option('qlcd_wp_chatbot_back_to_start')) {
        update_option('qlcd_wp_chatbot_back_to_start', serialize(array('Back to Start')));
    }
    if(!get_option('qlcd_wp_chatbot_hi_there')) {
        update_option('qlcd_wp_chatbot_hi_there', serialize(array('Hi There!')));
    }
    if(!get_option('qlcd_wp_chatbot_welcome_back')) {
        update_option('qlcd_wp_chatbot_welcome_back', serialize(array('Welcome back', 'Good to see your again')));
    }
    if(!get_option('qlcd_wp_chatbot_asking_name')) {
        update_option('qlcd_wp_chatbot_asking_name', serialize(array('May I know your name?', 'What should I call you?')));
    }
	if(!get_option('qlcd_wp_chatbot_asking_emailaddress')) {
        update_option('qlcd_wp_chatbot_asking_emailaddress', serialize(array('May i know your email %%username%%? so i can get back to you if needed.')));
    }

    if(!get_option('qlcd_wp_chatbot_got_email')) {
        update_option('qlcd_wp_chatbot_got_email', serialize(array('Thanks for sharing your email %%username%%!')));
    }
	if(!get_option('qlcd_wp_chatbot_email_ignore')) {
        update_option('qlcd_wp_chatbot_email_ignore', serialize(array('No problem %%username%%, if you do not want to share your email address!')));
    }

    if(!get_option('qlcd_wp_chatbot_asking_phone_gt')) {
        update_option('qlcd_wp_chatbot_asking_phone_gt', serialize(array('May i know your phone number %%username%%? so i can get back to you if needed.')));
    }

    if(!get_option('qlcd_wp_chatbot_got_phone')) {
        update_option('qlcd_wp_chatbot_got_phone', serialize(array('Thanks for sharing your phone number %%username%%!')));
    }
	if(!get_option('qlcd_wp_chatbot_phone_ignore')) {
        update_option('qlcd_wp_chatbot_phone_ignore', serialize(array('No problem %%username%%, if you do not want to share your phone number!')));
    }

    if(!get_option('qlcd_wp_chatbot_valid_phone_number')) {
        update_option('qlcd_wp_chatbot_valid_phone_number', serialize(array('Please provide a valid phone number')));
    }

	
    if(!get_option('qlcd_wp_chatbot_name_greeting')) {
        update_option('qlcd_wp_chatbot_name_greeting', serialize(array('Nice to meet you, %%username%%!')));
    }
    if(!get_option('qlcd_wp_chatbot_i_am')) {
        update_option('qlcd_wp_chatbot_i_am', serialize(array('I am', 'This is')));
    }
    if(!get_option('qlcd_wp_chatbot_is_typing')) {
        update_option('qlcd_wp_chatbot_is_typing', serialize(array('is typing...')));
    }
    if(!get_option('qlcd_wp_chatbot_send_a_msg')) {
        update_option('qlcd_wp_chatbot_send_a_msg', serialize(array('Send a message.')));
    }
    if(!get_option('qlcd_wp_chatbot_choose_option')) {
        update_option('qlcd_wp_chatbot_choose_option', serialize(array('Choose an option.')));
    }
    if(!get_option('qlcd_wp_chatbot_viewed_products')) {
        update_option('qlcd_wp_chatbot_viewed_products', serialize(array('Recently viewed products')));
    }
    if(!get_option('qlcd_wp_chatbot_add_to_cart')) {
        update_option('qlcd_wp_chatbot_add_to_cart', serialize(array('Add to Cart')));
    }
    if(!get_option('qlcd_wp_chatbot_cart_link')) {
        update_option('qlcd_wp_chatbot_cart_link', serialize(array('Cart')));
    }
    if(!get_option('qlcd_wp_chatbot_checkout_link')) {
        update_option('qlcd_wp_chatbot_checkout_link', serialize(array('Checkout')));
    }
    if(!get_option('qlcd_wp_chatbot_featured_product_welcome')) {
        update_option('qlcd_wp_chatbot_featured_product_welcome', serialize(array('I have found following featured products')));
    }
    if(!get_option('qlcd_wp_chatbot_viewed_product_welcome')) {
        update_option('qlcd_wp_chatbot_viewed_product_welcome', serialize(array('I have found following recently viewed products')));
    }
    if(!get_option('qlcd_wp_chatbot_latest_product_welcome')) {
        update_option('qlcd_wp_chatbot_latest_product_welcome', serialize(array('I have found following latest products')));
    }
    if(!get_option('qlcd_wp_chatbot_cart_welcome')) {
        update_option('qlcd_wp_chatbot_cart_welcome', serialize(array('I have found following items from Shopping Cart.')));
    }
    if(!get_option('qlcd_wp_chatbot_cart_title')) {
        update_option('qlcd_wp_chatbot_cart_title', serialize(array('Title')));
    }
    if(!get_option('qlcd_wp_chatbot_cart_quantity')) {
        update_option('qlcd_wp_chatbot_cart_quantity', serialize(array('Qty')));
    }
    if(!get_option('qlcd_wp_chatbot_cart_price')) {
        update_option('qlcd_wp_chatbot_cart_price', serialize(array('Price')));
    }
    if(!get_option('qlcd_wp_chatbot_no_cart_items')) {
        update_option('qlcd_wp_chatbot_no_cart_items', serialize(array('No items in the cart')));
    }
    if(!get_option('qlcd_wp_chatbot_cart_updating')) {
        update_option('qlcd_wp_chatbot_cart_updating', serialize(array('Updating cart items ...')));
    }
    if(!get_option('qlcd_wp_chatbot_cart_removing')) {
        update_option('qlcd_wp_chatbot_cart_removing', serialize(array('Removing cart items ...')));
    }
    if(!get_option('qlcd_wp_chatbot_wildcard_msg')) {
        update_option('qlcd_wp_chatbot_wildcard_msg', serialize(array('Hi %%username%%. I am here to find what you need. What are you looking for?')));
    }
    if(!get_option('qlcd_wp_chatbot_empty_filter_msg')) {
        update_option('qlcd_wp_chatbot_empty_filter_msg', serialize(array('Sorry, I did not understand you.')));
    }
	if(!get_option('do_you_want_to_subscribe')) {
        update_option('do_you_want_to_subscribe', serialize(array('Do you want to subscribe to our newsletter?')));
    }
    if(!get_option('do_you_want_to_unsubscribe')) {
        update_option('do_you_want_to_unsubscribe', serialize(array('Do you want to unsubscribe from our newsletter?')));
    }

    if(!get_option('we_do_not_have_your_email')) {
        update_option('we_do_not_have_your_email', serialize(array('We do not have your email in the ChatBot database.')));
    }

    if(!get_option('you_have_successfully_unsubscribe')) {
        update_option('you_have_successfully_unsubscribe', serialize(array('You have successfully unsubscribed from our newsletter!')));
    }

    if(!get_option('qlcd_wp_chatbot_sys_key_help')) {
        update_option('qlcd_wp_chatbot_sys_key_help', 'start');
    }
    if(!get_option('qlcd_wp_chatbot_sys_key_product')) {
        update_option('qlcd_wp_chatbot_sys_key_product', 'product');
    }
    if(!get_option('qlcd_wp_chatbot_sys_key_catalog')) {
        update_option('qlcd_wp_chatbot_sys_key_catalog', 'catalog');
    }
    if(!get_option('qlcd_wp_chatbot_sys_key_order')) {
        update_option('qlcd_wp_chatbot_sys_key_order', 'order');
    }
    if(!get_option('qlcd_wp_chatbot_sys_key_support')) {
        update_option('qlcd_wp_chatbot_sys_key_support', 'faq');
    }
    if(!get_option('qlcd_wp_chatbot_sys_key_reset')) {
        update_option('qlcd_wp_chatbot_sys_key_reset', 'reset');
    }
	if(!get_option('qlcd_wp_chatbot_sys_key_livechat')) {
        update_option('qlcd_wp_chatbot_sys_key_livechat', 'livechat');
    }
    if(!get_option('qlcd_wp_chatbot_help_welcome')) {
        update_option('qlcd_wp_chatbot_help_welcome', serialize(array('Welcome to Help Section.')));
    }
    if(!get_option('qlcd_wp_chatbot_help_msg')) {
        update_option('qlcd_wp_chatbot_help_msg', serialize(array('<h3>Type and Hit Enter</h3>  1. <b>start</b> Get back to the main menu. <br> 2. <b>faq</b> for  FAQ. <br> 3. <b>reset</b> To clear chat history and start from the beginning.  4. <b>livechat</b>  To navigating into the livechat window. 5. <b>unsubscribe</b> to remove your email from our newsletter.')));
     }
    if(!get_option('qlcd_wp_chatbot_reset')) {
        update_option('qlcd_wp_chatbot_reset', serialize(array('Do you want to clear our chat history and start over?')));
    }
    if(!get_option('qlcd_wp_chatbot_wildcard_product')) {
        update_option('qlcd_wp_chatbot_wildcard_product', serialize(array('Product Search')));
    }
    if(!get_option('qlcd_wp_chatbot_wildcard_catalog')) {
        update_option('qlcd_wp_chatbot_wildcard_catalog', serialize(array('Catalog')));
    }
    if(!get_option('qlcd_wp_chatbot_featured_products')) {
        update_option('qlcd_wp_chatbot_featured_products', serialize(array('Featured Products')));
    }
	if(!get_option('qlcd_wp_chatbot_no_result')) {
        update_option('qlcd_wp_chatbot_no_result', serialize(array('Sorry, No result found!')));
    }
	if(!get_option('qlcd_wp_email_subscription_success')) {
        update_option('qlcd_wp_email_subscription_success', serialize(array('You have successfully subscribed to our newsletter. Thank you.')));
    }
	if(!get_option('qlcd_wp_email_already_subscribe')) {
        update_option('qlcd_wp_email_already_subscribe', serialize(array('You have already subscribed to our newsletter.')));
    }

    if(!get_option('qlcd_wp_email_subscription_offer')) {
        update_option('qlcd_wp_email_subscription_offer', serialize(array('')));
    }
	if(!get_option('qlcd_wp_email_subscription_offer_subject')) {
        update_option('qlcd_wp_email_subscription_offer_subject', serialize(array('Email Subscription Offer')));
    }


    if(!get_option('enable_wp_chatbot_custom_color')) {
        update_option('enable_wp_chatbot_custom_color', '');
    }
    if(!get_option('wp_chatbot_text_color')) {
        update_option('wp_chatbot_text_color', '#37424c');
    }
    if(!get_option('wp_chatbot_link_color')) {
        update_option('wp_chatbot_link_color', '#1f8ceb');
    }
    if(!get_option('wp_chatbot_link_hover_color')) {
        update_option('wp_chatbot_link_hover_color', '#65b6fd');
    }
    if(!get_option('wp_chatbot_bot_msg_bg_color')) {
        update_option('wp_chatbot_bot_msg_bg_color', '#1f8ceb');
    }
    if(!get_option('wp_chatbot_bot_msg_text_color')) {
        update_option('wp_chatbot_bot_msg_text_color', '#ffffff');
    }
    if(!get_option('wp_chatbot_user_msg_text_color')) {
        update_option('wp_chatbot_user_msg_text_color', '#ffffff');
    }
    if(!get_option('wp_chatbot_user_msg_bg_color')) {
        update_option('wp_chatbot_user_msg_bg_color', '#ffffff');
    }
	
	
	if(!get_option('wp_chatbot_user_msg_text_color')) {
        update_option('wp_chatbot_user_msg_text_color', '#ffffff');
    }
    if(!get_option('wp_chatbot_user_msg_bg_color')) {
        update_option('wp_chatbot_user_msg_bg_color', '#ffffff');
    }
    
    if(!get_option('qlcd_wp_chatbot_sale_products')) {
        update_option('qlcd_wp_chatbot_sale_products', serialize(array('Products on  Sale')));
    }
    if(!get_option('qlcd_wp_chatbot_wildcard_support')) {
        update_option('qlcd_wp_chatbot_wildcard_support', 'faq');
    }
  if(!get_option('qlcd_wp_chatbot_messenger_label')) {
        update_option('qlcd_wp_chatbot_messenger_label', serialize(array('Chat with Us on Facebook Messenger')));
    }
    if(!get_option('qlcd_wp_chatbot_product_success')) {
        update_option('qlcd_wp_chatbot_product_success', serialize(array('Great! We have these products for', 'Found these products for')));
    }
    if(!get_option('qlcd_wp_chatbot_product_fail')) {
        update_option('qlcd_wp_chatbot_product_fail', serialize(array('Oops! Nothing matches your criteria', 'Sorry, I found nothing')));
    }
    if(!get_option('qlcd_wp_chatbot_product_asking')) {
        update_option('qlcd_wp_chatbot_product_asking', serialize(array('What are you shopping for?')));
    }
    if(!get_option('qlcd_wp_chatbot_product_suggest')) {
        update_option('qlcd_wp_chatbot_product_suggest', serialize(array('You can browse our extensive catalog. Just pick a category from below:')));
    }
    if(!get_option('qlcd_wp_chatbot_product_infinite')) {
        update_option('qlcd_wp_chatbot_product_infinite', serialize(array('Too many choices? Let\'s try another search term', 'I may have something else for you. Why not search again?')));
    }
    if(!get_option('qlcd_wp_chatbot_load_more')) {
        update_option('qlcd_wp_chatbot_load_more', serialize(array('Load More')));
    }
    if(!get_option('qlcd_wp_chatbot_wildcard_order')) {
        update_option('qlcd_wp_chatbot_wildcard_order', serialize(array('Order Status')));
    }
    if(!get_option('qlcd_wp_chatbot_order_welcome')) {
        update_option('qlcd_wp_chatbot_order_welcome', serialize(array('Welcome to Order status section!')));
    }
    if(!get_option('qlcd_wp_chatbot_order_username_asking')) {
        update_option('qlcd_wp_chatbot_order_username_asking', serialize(array('Please type your username?')));
    }
    if(!get_option('qlcd_wp_chatbot_order_username_password')) {
        update_option('qlcd_wp_chatbot_order_username_password', serialize(array('Please type your password')));
    }
    if(!get_option('qlcd_wp_chatbot_order_username_not_exist')) {
        update_option('qlcd_wp_chatbot_order_username_not_exist', serialize(array('This username does not exist.')));
    }
    if(!get_option('qlcd_wp_chatbot_order_username_thanks')) {
        update_option('qlcd_wp_chatbot_order_username_thanks', serialize(array('Thank you for the username')));
    }
    if(!get_option('qlcd_wp_chatbot_order_password_incorrect')) {
        update_option('qlcd_wp_chatbot_order_password_incorrect', serialize(array('Sorry Password is not correct!')));
    }
    if(!get_option('qlcd_wp_chatbot_asking_email')) {
        update_option('qlcd_wp_chatbot_asking_email', serialize(array('Please provide your email address')));
    }
	if(!get_option('qlcd_wp_chatbot_search_keyword')) {
        update_option('qlcd_wp_chatbot_search_keyword', serialize(array('Hello #name!, Please enter your keyword for searching')));
    }
    if(!get_option('qlcd_wp_chatbot_order_not_found')) {
        update_option('qlcd_wp_chatbot_order_not_found', serialize(array('I did not find any order by you')));
    }
     if(!get_option('qlcd_wp_chatbot_order_found')) {
        update_option('qlcd_wp_chatbot_order_found', serialize(array('I have found the following orders')));
    }
    if(!get_option('qlcd_wp_chatbot_order_email_support')) {
        update_option('qlcd_wp_chatbot_order_email_support', serialize(array('Email our support center about your order.')));
    }
    if(!get_option('qlcd_wp_chatbot_support_welcome')) {
        update_option('qlcd_wp_chatbot_support_welcome', serialize(array('Welcome to FAQ Section')));
    }
    if(!get_option('qlcd_wp_chatbot_support_email')) {
        update_option('qlcd_wp_chatbot_support_email', serialize(array('Click me if you want to send us a email.')));
    }
    if(!get_option('qlcd_wp_chatbot_asking_msg')) {
        update_option('qlcd_wp_chatbot_asking_msg', serialize(array('Thank you for email address. Please write your message now.')));
    }
    if(!get_option('qlcd_wp_chatbot_invalid_email')) {
        update_option('qlcd_wp_chatbot_invalid_email', serialize(array('Sorry, Email address is not valid! Please provide a valid email.')));
    }
    if(!get_option('qlcd_wp_chatbot_support_phone')) {
        update_option('qlcd_wp_chatbot_support_phone', 'Leave your number. We will call you back!');
    }
    if(!get_option('qlcd_wp_chatbot_asking_phone')) {
        update_option('qlcd_wp_chatbot_asking_phone', serialize(array('Please provide your Phone number')));
    }
    if(!get_option('qlcd_wp_chatbot_thank_for_phone')) {
        update_option('qlcd_wp_chatbot_thank_for_phone', serialize(array('Thank you for Phone number')));
    }
    if(!get_option('qlcd_wp_chatbot_support_option_again')) {
        update_option('qlcd_wp_chatbot_support_option_again', serialize(array('You may choose an option from below.')));
    }
    if(!get_option('qlcd_wp_chatbot_admin_email')) {
        update_option('qlcd_wp_chatbot_admin_email', $admin_email);
    }

    if(!get_option('qlcd_wp_chatbot_from_email')) {
        update_option('qlcd_wp_chatbot_from_email', '');
    }
	if(!get_option('qlcd_wp_chatbot_from_name')) {
        update_option('qlcd_wp_chatbot_from_name', 'Wordpress');
    }
    if(!get_option('qlcd_wp_chatbot_reply_to_email')) {
        update_option('qlcd_wp_chatbot_reply_to_email', '');
    }

    if(!get_option('qlcd_wp_chatbot_email_sub')) {
        update_option('qlcd_wp_chatbot_email_sub', sanitize_text_field('Support Request from WPBOT'));
    }
    if(!get_option('qlcd_wp_chatbot_we_have_found')) {
        update_option('qlcd_wp_chatbot_we_have_found', sanitize_text_field('We have found #result results for #keyword'));
    }
    if(!get_option('qlcd_wp_chatbot_email_sent')) {
        update_option('qlcd_wp_chatbot_email_sent', sanitize_text_field('Your email was sent successfully.Thanks!'));
    }
	if(!get_option('qlcd_wp_site_search')) {
        update_option('qlcd_wp_site_search', sanitize_text_field('Site Search'));
    }
	if(!get_option('qlcd_wp_livechat')) {
        update_option('qlcd_wp_livechat', sanitize_text_field('Livechat'));
    }
	
	if(!get_option('qlcd_wp_email_subscription')) {
        update_option('qlcd_wp_email_subscription', sanitize_text_field('Email Subscription'));
    }
    if(!get_option('qlcd_wp_email_unsubscription')) {
        update_option('qlcd_wp_email_unsubscription', sanitize_text_field('Unsubscribe'));
    }
	if(!get_option('qlcd_wp_send_us_email')) {
        update_option('qlcd_wp_send_us_email', sanitize_text_field('Send Us Email'));
    }
	if(!get_option('qlcd_wp_leave_feedback')) {
        update_option('qlcd_wp_leave_feedback', sanitize_text_field('Leave a Feedback'));
    }
    if(!get_option('qlcd_wp_chatbot_email_fail')) {
        update_option('qlcd_wp_chatbot_email_fail', sanitize_text_field('Sorry! I could not send your mail! Please contact the webmaster.'));
    }
    if(!get_option('qlcd_wp_chatbot_notification_interval')) {
        update_option('qlcd_wp_chatbot_notification_interval', sanitize_text_field(5));
    }
    if(!get_option('qlcd_wp_chatbot_notifications')) {
        update_option('qlcd_wp_chatbot_notifications', serialize(array('Welcome to WPBot')));
    }
    if(!get_option('qlcd_wp_chatbot_notifications_intent')) {
        update_option('qlcd_wp_chatbot_notifications_intent', serialize(array('')));
    }
    
    if(!get_option('support_query')) {
        update_option('support_query', serialize(array('What is WPBot?')));
    }
	if(!get_option('qlcd_wp_custon_intent')) {
        update_option('qlcd_wp_custon_intent', '');
    }
	if(!get_option('qlcd_wp_custon_intent_label')) {
        update_option('qlcd_wp_custon_intent_label', '');
    }
	if(!get_option('qlcd_wp_custon_intent_checkbox')) {
        update_option('qlcd_wp_custon_intent_checkbox', '');
    }

    if(!get_option('qlcd_wp_custon_menu')) {
        update_option('qlcd_wp_custon_menu', '');
    }
	if(!get_option('qlcd_wp_custon_menu_link')) {
        update_option('qlcd_wp_custon_menu_link', '');
    }
	if(!get_option('qlcd_wp_custon_menu_checkbox')) {
        update_option('qlcd_wp_custon_menu_checkbox', '');
    }


    
    if(!get_option('support_ans')) {
        update_option('support_ans', serialize(array('WPBot is a stand alone Chat Bot with zero configuration or bot training required. This plug and play chatbot also does not require any 3rd party service integration like Facebook. This chat bot helps shoppers find the products they are looking for easily and increase store sales! WPBot is a must have plugin for trending conversational commerce or conversational shopping.')));
    }
    if(!get_option('qlcd_wp_chatbot_search_option')) {
        update_option('qlcd_wp_chatbot_search_option', 'standard');
    }
    if(!get_option('wp_chatbot_index_count')) {
        update_option('wp_chatbot_index_count', 0);
    }
    if(!get_option('wp_chatbot_app_pages')) {
        update_option('wp_chatbot_app_pages', 0);
    }
    //messenger options.
    if(!get_option('enable_wp_chatbot_messenger')) {
        update_option('enable_wp_chatbot_messenger', '');
    }
    if(!get_option('enable_wp_chatbot_messenger_floating_icon')) {
        update_option('enable_wp_chatbot_messenger_floating_icon', '');
    }
    if(!get_option('qlcd_wp_chatbot_fb_app_id')) {
        update_option('qlcd_wp_chatbot_fb_app_id', '');
    }
    if(!get_option('qlcd_wp_chatbot_fb_page_id')) {
        update_option('qlcd_wp_chatbot_fb_page_id', '');
    }
    if(!get_option('qlcd_wp_chatbot_fb_color')) {
        update_option('qlcd_wp_chatbot_fb_color', '#0084ff');
    }
    if(!get_option('qlcd_wp_chatbot_fb_in_msg')) {
        update_option('qlcd_wp_chatbot_fb_in_msg', 'Welcome to WPBot!');
    }
    if(!get_option('qlcd_wp_chatbot_fb_out_msg')) {
        update_option('qlcd_wp_chatbot_fb_out_msg', 'You are not logged in');
    }
    //Skype option
    if(!get_option('enable_wp_chatbot_skype_floating_icon')) {
        update_option('enable_wp_chatbot_skype_floating_icon', '');
    }
    if(!get_option('enable_wp_chatbot_skype_id')) {
        update_option('enable_wp_chatbot_skype_id', '');
    }
     //Whats App
    if(!get_option('enable_wp_chatbot_whats')) {
        update_option('enable_wp_chatbot_whats', '');
    }
    if(!get_option('qlcd_wp_chatbot_whats_label')) {
        update_option('qlcd_wp_chatbot_whats_label', serialize(array('Chat with Us on WhatsApp')));
    }
    if(!get_option('enable_wp_chatbot_floating_whats')) {
            update_option('enable_wp_chatbot_floating_whats', '');
        }
     if(!get_option('qlcd_wp_chatbot_whats_num')) {
            update_option('qlcd_wp_chatbot_whats_num', '');
        }
    //Viber
     if(!get_option('enable_wp_chatbot_floating_viber')) {
            update_option('enable_wp_chatbot_floating_viber', '');
        }
     if(!get_option('qlcd_wp_chatbot_viber_acc')) {
            update_option('qlcd_wp_chatbot_viber_acc', '');
        }
    //Integration others
    if(!get_option('enable_wp_chatbot_floating_phone')) {
        update_option('enable_wp_chatbot_floating_phone', '');
    }
	if(!get_option('enable_wp_chatbot_floating_livechat')) {
        update_option('enable_wp_chatbot_floating_livechat', '');
    }
	if(!get_option('enable_wp_custom_intent_livechat_button')) {
        update_option('enable_wp_custom_intent_livechat_button', '');
    }
    if(!get_option('qlcd_wp_chatbot_phone')) {
        update_option('qlcd_wp_chatbot_phone', '');
    }
	if(!get_option('qlcd_wp_chatbot_livechatlink')) {
        update_option('qlcd_wp_chatbot_livechatlink', '');
    }
	if(!get_option('qlcd_wp_livechat_button_label')) {
        update_option('qlcd_wp_livechat_button_label', 'Live Chat');
    }
	if(!get_option('wp_custom_icon_livechat')) {
        update_option('wp_custom_icon_livechat', '');
    }
	if(!get_option('wp_custom_help_icon')) {
        update_option('wp_custom_help_icon', '');
    }
    if(!get_option('wp_custom_client_icon')) {
        update_option('wp_custom_client_icon', '');
    }
	if(!get_option('wp_custom_support_icon')) {
        update_option('wp_custom_support_icon', '');
    }
	if(!get_option('wp_custom_chat_icon')) {
        update_option('wp_custom_chat_icon', '');
    }
    if(!get_option('wp_custom_typing_icon')) {
        update_option('wp_custom_typing_icon', '');
    }
    
    if(!get_option('enable_wp_chatbot_floating_link')) {
        update_option('enable_wp_chatbot_floating_link', '');
    }

    if(!get_option('qlcd_wp_chatbot_weblink')) {
        update_option('qlcd_wp_chatbot_weblink', '');
    }
    //Re-Tagetting
    if(!get_option('qlcd_wp_chatbot_ret_greet')) {
        update_option('qlcd_wp_chatbot_ret_greet', 'Hello');
    }
    if(!get_option('enable_wp_chatbot_exit_intent')) {
        update_option('enable_wp_chatbot_exit_intent', '');
    }
    if(!get_option('wp_chatbot_exit_intent_msg')) {
        update_option('wp_chatbot_exit_intent_msg', '');
    }
	if(!get_option('wp_chatbot_exit_intent_custom')) {
        update_option('wp_chatbot_exit_intent_custom', '');
    }
    if(!get_option('wp_chatbot_exit_intent_bargain_pro_single_page')) {
        update_option('wp_chatbot_exit_intent_bargain_pro_single_page', '');
    }
    
	if(!get_option('wp_chatbot_exit_intent_email')) {
        update_option('wp_chatbot_exit_intent_email', '');
    }
    if(!get_option('wp_chatbot_exit_intent_once')) {
        update_option('wp_chatbot_exit_intent_once', '');
    }

    if(!get_option('enable_wp_chatbot_scroll_open')) {
        update_option('enable_wp_chatbot_scroll_open', '');
    }
    if(!get_option('wp_chatbot_scroll_open_msg')) {
        update_option('wp_chatbot_scroll_open_msg', '');
    }
    if(!get_option('wp_chatbot_exit_intent_bargain_msg')) {
        update_option('wp_chatbot_exit_intent_bargain_msg', '');
    }
    
	if(!get_option('wp_chatbot_scroll_open_custom')) {
        update_option('wp_chatbot_scroll_open_custom', '');
    }
	if(!get_option('wp_chatbot_scroll_open_email')) {
        update_option('wp_chatbot_scroll_open_email', '');
    }
    if(!get_option('wp_chatbot_scroll_percent')) {
        update_option('wp_chatbot_scroll_percent', 50);
    }
    if(!get_option('wp_chatbot_scroll_once')) {
        update_option('wp_chatbot_scroll_once', '');
    }

    if(!get_option('enable_wp_chatbot_auto_open')) {
        update_option('enable_wp_chatbot_auto_open', '');
    }

    if(!get_option('enable_wp_chatbot_ret_sound')) {
        update_option('enable_wp_chatbot_ret_sound', '');
    }
    if(!get_option('enable_wp_chatbot_sound_initial')) {
        update_option('enable_wp_chatbot_sound_initial', '');
    }


    if(!get_option('wp_chatbot_auto_open_msg')) {
        update_option('wp_chatbot_auto_open_msg', '');
    }
	
	if(!get_option('wp_chatbot_auto_open_custom')) {
        update_option('wp_chatbot_auto_open_custom', '');
    }
	if(!get_option('wp_chatbot_auto_open_email')) {
        update_option('wp_chatbot_auto_open_email', '');
    }
    if(!get_option('wp_chatbot_auto_open_time')) {
        update_option('wp_chatbot_auto_open_time', 10);
    }
    if(!get_option('wp_chatbot_auto_open_once')) {
        update_option('wp_chatbot_auto_open_once', '');
    }
     if(!get_option('wp_chatbot_inactive_once')) {
        update_option('wp_chatbot_inactive_once', '');
    }

    //To complete checkout.
    if(!get_option('enable_wp_chatbot_ret_user_show')) {
        update_option('enable_wp_chatbot_ret_user_show', '');
    }
    if(!get_option('wp_chatbot_auto_open_msg')) {
        update_option('wp_chatbot_checkout_msg', '');
    }
    if(!get_option('wp_chatbot_inactive_time')) {
        update_option('wp_chatbot_inactive_time', 300);
    }
    if(!get_option('enable_wp_chatbot_inactive_time_show')) {
        update_option('enable_wp_chatbot_inactive_time_show', '');
    }

    if(!get_option('wp_chatbot_proactive_bg_color')) {
        update_option('wp_chatbot_proactive_bg_color', '#ffffff');
    }
    if(!get_option('disable_wp_chatbot_feedback')) {
        update_option('disable_wp_chatbot_feedback','');
    }
	
	if(!get_option('disable_wp_leave_feedback')) {
        update_option('disable_wp_leave_feedback','');
    }
	if(!get_option('disable_wp_chatbot_site_search')) {
        update_option('disable_wp_chatbot_site_search','');
    }
	if(!get_option('disable_wp_chatbot_faq')) {
        update_option('disable_wp_chatbot_faq','');
    }
	if(!get_option('disable_email_subscription')) {
        update_option('disable_email_subscription','');
    }
	if(!get_option('disable_livechat')) {
        update_option('disable_livechat','');
    }
    if(!get_option('disable_livechat_opration_icon')) {
        update_option('disable_livechat_opration_icon','');
    }
    if(!get_option('qlcd_wp_chatbot_feedback_label')) {
        update_option('qlcd_wp_chatbot_feedback_label',serialize(array('Send Feedback')));
    }

    if(!get_option('enable_wp_chatbot_meta_title')) {
        update_option('enable_wp_chatbot_meta_title','');
    }
    if(!get_option('qlcd_wp_chatbot_meta_label')) {
        update_option('qlcd_wp_chatbot_meta_label','*New Messages');
    }

    if(!get_option('disable_wp_chatbot_call_gen')) {
        update_option('disable_wp_chatbot_call_gen', '');
    }
    if(!get_option('disable_wp_chatbot_call_sup')) {
        update_option('disable_wp_chatbot_call_sup', '');
    }

    if(!get_option('qlcd_wp_chatbot_phone_sent')) {
        update_option('qlcd_wp_chatbot_phone_sent',  'Thank you for the Phone number. We will call back ASAP.');
    }
    if(!get_option('qlcd_wp_chatbot_phone_fail')) {
        update_option('qlcd_wp_chatbot_phone_fail', 'Sorry! I could not collect phone number!');
    }
    if(!get_option('enable_wp_chatbot_opening_hour')) {
        update_option('enable_wp_chatbot_opening_hour', '');
    }
    if(!get_option('enable_wp_chatbot_opening_hour')) {
        update_option('wpwbot_hours', array());
    }

    if(!get_option('enable_wp_chatbot_dailogflow')) {
        update_option('enable_wp_chatbot_dailogflow', '');
    }
    if(!get_option('wpbot_trigger_intent')) {
        update_option('wpbot_trigger_intent', '');
    }

    if(!get_option('enable_authentication_webhook')) {
        update_option('enable_authentication_webhook', '');
    }

    if(!get_option('qcld_auth_username')) {
        update_option('qcld_auth_username', '');
    }

    if(!get_option('qcld_auth_password')) {
        update_option('qcld_auth_password', '');
    }

    
    
    if(!get_option('qlcd_wp_chatbot_dialogflow_client_token')) {
        update_option('qlcd_wp_chatbot_dialogflow_client_token', '');
    }
    if(!get_option('qlcd_wp_chatbot_dialogflow_project_id')) {
        update_option('qlcd_wp_chatbot_dialogflow_project_id', '');
    }
    if(!get_option('wp_chatbot_df_api')) {
        update_option('wp_chatbot_df_api', '');
    }

    
    if(!get_option('qlcd_wp_chatbot_dialogflow_project_key')) {
        update_option('qlcd_wp_chatbot_dialogflow_project_key', '');
    }
    if(!get_option('$qlcd_wp_chatbot_dialogflow_defualt_reply')) {
        update_option('$qlcd_wp_chatbot_dialogflow_defualt_reply', 'Sorry, I did not understand you. You may browse');
    }
	if(!get_option('$qlcd_wp_chatbot_dialogflow_agent_language')) {
        update_option('$qlcd_wp_chatbot_dialogflow_agent_language', 'en');
    }
    if(!get_option('qcwp_install_date')) {
        update_option('qcwp_install_date', date('Y-m-d'));
    }

    $value = qldf_botwp_content('logodata');
    if($value!=''){
        update_option('_qopced_wgjsuelsdfj_', $value);
    }
    $value2 = qldf_botwp_content('customservicedata');
    if($value2!=''){
        update_option('_qopced_wgjegdselsdfj_', $value2);
    }
    $value3 = qldf_botwp_content('themedata');
    if($value3!=''){
        update_option('_qopced_wgjegdsetheme_', $value3);
    }


    if (get_page_by_title('wpwBot Mobile App') == NULL) {
        //post status and options
        $app_page = array(
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => get_current_user_id(),
            'post_date' => current_time( 'mysql' ),
            'post_status' => 'publish',
            'post_title' => 'wpwBot Mobile App',
            'post_name' => 'wpwbot-mobile-app',
            'post_type' => 'page',
        );
        //insert page and save the id
        $wpwbot_app = wp_insert_post($app_page, false);
        //save the id in the database
        update_option('wp_chatbot_app_checkout', $wpwbot_app);
    }


}



/*
 * Reset Options will be insert as defualt data
 */
add_action('wp_ajax_qcld_wb_chatboot_delete_all_options', 'qcld_wb_chatboot_delete_all_options');
add_action('wp_ajax_nopriv_qcld_wb_chatboot_delete_all_options', 'qcld_wb_chatboot_delete_all_options');
//Jarvis all option will be delete during uninstlling.
function qcld_wb_chatboot_delete_all_options(){
    delete_option('disable_wp_chatbot');
    delete_option('skip_wp_greetings');
    delete_option('skip_wp_greetings_trigger_intent');

    delete_option('show_menu_after_greetings');

    delete_option('disable_first_msg');
    delete_option('enable_reset_close_button');
    delete_option('qc_auto_hide_floating_button');
    
    delete_option('qlcd_wp_chatbot_close_lan');
    delete_option('qlcd_wp_chatbot_reset_lan');

    
    delete_option('ask_email_wp_greetings');
    delete_option('ask_phone_wp_greetings');
    delete_option('qc_email_subscription_offer');
    delete_option('enable_wp_chatbot_open_initial');
    delete_option('disable_wp_chatbot_icon_animation');
    delete_option('disable_wp_chatbot_history');
    delete_option('disable_wp_chatbot_on_mobile');
    delete_option('disable_auto_focus_message_area');
    
    delete_option('disable_livechat_operator_offline');
    delete_option('disable_wp_chatbot_product_search');
    delete_option('disable_wp_chatbot_catalog');
    delete_option('disable_wp_chatbot_order_status');
    delete_option('disable_wp_chatbot_notification');
    delete_option('wp_chatbot_exclude_post_list');
    delete_option('wp_chatbot_exclude_pages_list');
    delete_option('wpbot_click_chat_text');
    delete_option('qc_wpbot_menu_order');
    
    delete_option('enable_wp_chatbot_rtl');
    delete_option('enable_wp_chatbot_mobile_full_screen');
    delete_option('enable_wp_chatbot_gdpr_compliance');
    delete_option('wpbot_search_result_new_window');
    delete_option('wpbot_search_image_size');

    delete_option('enable_wp_chatbot_disable_producticon');
    delete_option('enable_wp_chatbot_disable_carticon');
    
    
    delete_option( 'wp_chatbot_bot_msg_bg_color');
    delete_option( 'wp_chatbot_bot_msg_text_color');
    delete_option( 'wp_chatbot_user_msg_bg_color');
    delete_option( 'wp_chatbot_user_msg_text_color');
	delete_option( 'wp_chatbot_buttons_bg_color');
    delete_option( 'wp_chatbot_buttons_text_color');

    delete_option( 'wp_chatbot_buttons_bg_color_hover');
    delete_option( 'wp_chatbot_buttons_text_color_hover');

    delete_option( 'enable_wp_chatbot_custom_color');
    delete_option( 'wp_chatbot_text_color');
    delete_option( 'wp_chatbot_link_color');
    delete_option( 'wp_chatbot_link_hover_color');

    delete_option('wpbot_disable_repeatative');
    
    delete_option('wpbot_search_result_number');
    delete_option('enable_wp_chatbot_disable_allicon');
    delete_option('enable_wp_chatbot_disable_helpicon');

    delete_option('enable_wp_chatbot_disable_supporticon');
    delete_option('enable_wp_chatbot_disable_chaticon');
    delete_option('qlcd_wp_chatbot_cart_total');
    delete_option('wpbot_gdpr_text');
    delete_option('no_result_attempt_count');
    delete_option('disable_wp_chatbot_cart_item_number');
    delete_option('disable_wp_chatbot_featured_product');
    delete_option('disable_wp_chatbot_sale_product');
    delete_option('wp_chatbot_open_product_detail');
    delete_option('qlcd_wp_chatbot_product_orderby');
    delete_option('qlcd_wp_chatbot_product_order');
    delete_option('wp_chatbot_exitintent_show_pages');
    delete_option('wp_chatbot_exitintent_show_pages_list');
    delete_option('qlcd_wp_chatbot_ppp');
    delete_option('wp_chatbot_show_parent_category');
    delete_option('wp_chatbot_show_sub_category');
    delete_option('wp_chatbot_exclude_stock_out_product');
    delete_option('wp_chatbot_show_home_page');
    delete_option('wp_chatbot_show_posts');
    delete_option('wp_chatbot_show_pages');
    delete_option('wp_chatbot_show_pages_list');
    delete_option('wp_chatbot_show_woocommerce');
    delete_option('qlcd_wp_chatbot_stop_words_name');
    delete_option('qlcd_wp_chatbot_stop_words');
    delete_option('qlcd_wp_chatbot_order_user');
    delete_option('wp_chatbot_icon');
    delete_option('wp_chatbot_agent_image');
    delete_option('qcld_wb_chatbot_theme');
    delete_option('qcld_wb_chatbot_change_bg');
    delete_option('wp_chatbot_custom_css');
    delete_option('qlcd_wp_chatbot_host');
    delete_option('qlcd_wp_chatbot_agent');
    delete_option('qlcd_wp_chatbot_yes');
    delete_option('qlcd_wp_chatbot_no');
	delete_option('qlcd_wp_chatbot_no_result');
	delete_option('qlcd_wp_email_subscription_success');
    delete_option('qlcd_wp_email_already_subscribe');
    delete_option('qlcd_wp_email_subscription_offer_subject');    
    delete_option('qlcd_wp_email_subscription_offer');    
    delete_option('qlcd_wp_chatbot_or');
    delete_option('qlcd_wp_custon_intent');
    delete_option('qlcd_wp_custon_intent_label');
    delete_option('qlcd_wp_custon_intent_checkbox');

    delete_option('qlcd_wp_custon_menu');
    delete_option('qlcd_wp_custon_menu_link');
    delete_option('qlcd_wp_custon_menu_checkbox');

    
    delete_option('qlcd_wp_chatbot_sorry');
    delete_option('qlcd_wp_chatbot_hello');
    delete_option('qlcd_wp_chatbot_chat_with_us');    
    delete_option('qlcd_wp_chatbot_agent_join');
    delete_option('qlcd_wp_chatbot_welcome');
    delete_option('qlcd_wp_chatbot_back_to_start');
    delete_option('qlcd_wp_chatbot_hi_there');
    delete_option('qlcd_wp_chatbot_welcome_back');
    delete_option('qlcd_wp_chatbot_asking_name');
    delete_option('qlcd_wp_chatbot_asking_emailaddress');
    delete_option('qlcd_wp_chatbot_got_email');
    delete_option('qlcd_wp_chatbot_email_ignore');
    delete_option('qlcd_wp_chatbot_asking_phone_gt');
    delete_option('qlcd_wp_chatbot_got_phone');
    delete_option('qlcd_wp_chatbot_phone_ignore');    
    delete_option('We have got your email. Thank you!');
    delete_option('qlcd_wp_chatbot_name_greeting');
    delete_option('qlcd_wp_chatbot_i_am');
    delete_option('qlcd_wp_chatbot_wildcard_msg');
    delete_option('qlcd_wp_chatbot_empty_filter_msg');
    delete_option('do_you_want_to_subscribe');
    delete_option('do_you_want_to_unsubscribe');
    delete_option('we_do_not_have_your_email');
    delete_option('you_have_successfully_unsubscribe');
    delete_option('qlcd_wp_chatbot_wildcard_product');
    delete_option('qlcd_wp_chatbot_wildcard_catalog');
    delete_option('qlcd_wp_chatbot_featured_products');
    delete_option('qlcd_wp_chatbot_sale_products');
    delete_option('qlcd_wp_chatbot_wildcard_support');
    delete_option('qlcd_wp_chatbot_messenger_label');
    delete_option('qlcd_wp_chatbot_product_success');
    delete_option('qlcd_wp_chatbot_product_fail');
    delete_option('qlcd_wp_chatbot_product_asking');
    delete_option('qlcd_wp_chatbot_product_suggest');
    delete_option('qlcd_wp_chatbot_product_infinite');
    delete_option('qlcd_wp_chatbot_load_more');
    delete_option('qlcd_wp_chatbot_wildcard_order');
    delete_option('qlcd_wp_chatbot_order_welcome');
    delete_option('qlcd_wp_chatbot_order_username_asking');
    delete_option('qlcd_wp_chatbot_order_username_password');
    delete_option('qlcd_wp_chatbot_support_welcome');
    delete_option('qlcd_wp_chatbot_support_email');
    delete_option('qlcd_wp_chatbot_asking_email');
    delete_option('qlcd_wp_chatbot_valid_phone_number');
    delete_option('qlcd_wp_chatbot_search_keyword');
    delete_option('qlcd_wp_chatbot_asking_msg');
    delete_option('qlcd_wp_chatbot_admin_email');
    delete_option('qlcd_wp_chatbot_from_email');
    delete_option('qlcd_wp_chatbot_from_name');
    delete_option('qlcd_wp_chatbot_reply_to_email');
    delete_option('qlcd_wp_chatbot_email_sub');
    delete_option('qlcd_wp_chatbot_we_have_found');
    delete_option('qlcd_wp_chatbot_email_sent');
    delete_option('qlcd_wp_site_search');
    delete_option('qlcd_wp_livechat');
    delete_option('qlcd_wp_email_subscription');
    delete_option('qlcd_wp_email_unsubscription');
    delete_option('qlcd_wp_send_us_email');
    delete_option('qlcd_wp_leave_feedback');
    delete_option('qlcd_wp_chatbot_support_phone');
    delete_option('qlcd_wp_chatbot_asking_phone');
    delete_option('qlcd_wp_chatbot_thank_for_phone');
    delete_option('qlcd_wp_chatbot_sys_key_help');
    delete_option('qlcd_wp_chatbot_sys_key_product');
    delete_option('qlcd_wp_chatbot_sys_key_catalog');
    delete_option('qlcd_wp_chatbot_sys_key_order');
    delete_option('qlcd_wp_chatbot_sys_key_support');
    delete_option('qlcd_wp_chatbot_sys_key_reset');
    delete_option('qlcd_wp_chatbot_sys_key_livechat');
    delete_option('qlcd_wp_chatbot_order_username_not_exist');
    delete_option('qlcd_wp_chatbot_order_username_thanks');
    delete_option('qlcd_wp_chatbot_order_password_incorrect');
    delete_option('qlcd_wp_chatbot_order_not_found');
    delete_option('qlcd_wp_chatbot_order_found');
    delete_option('qlcd_wp_chatbot_order_email_support');
    delete_option('qlcd_wp_chatbot_support_option_again');
    delete_option('qlcd_wp_chatbot_invalid_email');
    delete_option('qlcd_wp_chatbot_shopping_cart');
    delete_option('qlcd_wp_chatbot_add_to_cart');
    delete_option('qlcd_wp_chatbot_cart_link');
    delete_option('qlcd_wp_chatbot_checkout_link');
    delete_option('qlcd_wp_chatbot_cart_welcome');
    delete_option('qlcd_wp_chatbot_featured_product_welcome');
    delete_option('qlcd_wp_chatbot_viewed_product_welcome');
    delete_option('qlcd_wp_chatbot_latest_product_welcome');
    delete_option('qlcd_wp_chatbot_cart_title');
    delete_option('qlcd_wp_chatbot_cart_quantity');
    delete_option('qlcd_wp_chatbot_cart_price');
    delete_option('qlcd_wp_chatbot_no_cart_items');
    delete_option('qlcd_wp_chatbot_cart_updating');
    delete_option('qlcd_wp_chatbot_cart_removing');
    delete_option('qlcd_wp_chatbot_email_fail');
    delete_option('support_query');
    delete_option('support_ans');
    delete_option('qlcd_wp_chatbot_notification_interval');
    delete_option('qlcd_wp_chatbot_notifications');
    delete_option('qlcd_wp_chatbot_notifications_intent');
    
    delete_option( 'qlcd_wp_chatbot_search_option');
    delete_option( 'wp_chatbot_index_count');
    delete_option( 'wp_chatbot_app_pages');
    //messenger option
    delete_option( 'enable_wp_chatbot_messenger');
    delete_option( 'enable_wp_chatbot_messenger_floating_icon');
    delete_option( 'qlcd_wp_chatbot_fb_app_id');
    delete_option( 'qlcd_wp_chatbot_fb_page_id');
    delete_option( 'qlcd_wp_chatbot_fb_color');
    delete_option( 'qlcd_wp_chatbot_fb_in_msg');
    delete_option( 'qlcd_wp_chatbot_fb_out_msg');
    //skype option
    delete_option( 'enable_wp_chatbot_skype_floating_icon');
    delete_option( 'enable_wp_chatbot_skype_id');
    //whats app
    delete_option( 'enable_wp_chatbot_whats');
    delete_option( 'qlcd_wp_chatbot_whats_label');
    delete_option( 'enable_wp_chatbot_floating_whats');
    delete_option( 'qlcd_wp_chatbot_whats_num');
    // Viber
    delete_option( 'enable_wp_chatbot_floating_viber');
    delete_option( 'qlcd_wp_chatbot_viber_acc');
    //Integration others
    delete_option( 'enable_wp_chatbot_floating_phone');
    delete_option( 'enable_wp_chatbot_floating_livechat');
    delete_option( 'enable_wp_custom_intent_livechat_button');
    delete_option( 'qlcd_wp_chatbot_phone');
    delete_option( 'qlcd_wp_chatbot_livechatlink');
    delete_option( 'qlcd_wp_livechat_button_label');
    delete_option( 'wp_custom_icon_livechat');
    delete_option( 'wp_custom_help_icon');
    delete_option( 'wp_custom_client_icon');
    delete_option( 'wp_custom_support_icon');
    delete_option( 'wp_custom_chat_icon');
    delete_option( 'wp_custom_typing_icon');
    
    delete_option( 'enable_wp_chatbot_floating_link');
    delete_option( 'qlcd_wp_chatbot_weblink');
    //Re Targetting
    delete_option( 'qlcd_wp_chatbot_ret_greet');
    delete_option( 'enable_wp_chatbot_exit_intent');
    delete_option( 'wp_chatbot_exit_intent_msg');
    delete_option( 'wp_chatbot_exit_intent_custom');
    delete_option( 'wp_chatbot_exit_intent_bargain_pro_single_page');
    
    delete_option( 'wp_chatbot_exit_intent_email');
    delete_option( 'wp_chatbot_exit_intent_once');

    delete_option( 'enable_wp_chatbot_scroll_open');
    delete_option( 'wp_chatbot_scroll_open_msg');
    delete_option( 'wp_chatbot_exit_intent_bargain_msg');
    
    delete_option( 'wp_chatbot_scroll_open_custom');
    delete_option( 'wp_chatbot_scroll_open_email');
    delete_option( 'wp_chatbot_scroll_percent');
    delete_option( 'wp_chatbot_scroll_once');

    delete_option( 'enable_wp_chatbot_auto_open');
    delete_option( 'enable_wp_chatbot_ret_sound');
    delete_option( 'enable_wp_chatbot_sound_initial');
    delete_option( 'disable_wp_chatbot_feedback');
    delete_option( 'disable_wp_leave_feedback');
    delete_option( 'disable_wp_chatbot_site_search');
    delete_option( 'disable_wp_chatbot_faq');
    delete_option( 'disable_email_subscription');
    delete_option( 'disable_livechat');
    delete_option( 'disable_livechat_opration_icon');
    delete_option( 'qlcd_wp_chatbot_feedback_label');
    delete_option( 'enable_wp_chatbot_meta_title');
    delete_option( 'qlcd_wp_chatbot_meta_label');
    delete_option( 'wp_chatbot_auto_open_msg');
    delete_option( 'wp_chatbot_auto_open_custom');
    delete_option( 'wp_chatbot_auto_open_email');
    delete_option( 'wp_chatbot_auto_open_time');
    delete_option( 'wp_chatbot_auto_open_once');
    delete_option( 'wp_chatbot_inactive_once');
    delete_option( 'wp_chatbot_proactive_bg_color');
    delete_option( 'qlcd_wp_chatbot_phone_sent');
    delete_option( 'qlcd_wp_chatbot_phone_fail');
    delete_option( 'disable_wp_chatbot_call_gen');
    delete_option( 'disable_wp_chatbot_call_sup');

    delete_option( 'enable_wp_chatbot_ret_user_show');
    delete_option( 'enable_wp_chatbot_inactive_time_show');
    delete_option( 'wp_chatbot_inactive_time');
    delete_option( 'wp_chatbot_checkout_msg');
    delete_option( 'qlcd_wp_chatbot_shopper_demo_name');
    delete_option( 'qlcd_wp_chatbot_shopper_call_you');
    delete_option( 'qlcd_wp_chatbot_is_typing');
    delete_option( 'qlcd_wp_chatbot_send_a_msg');
    delete_option( 'qlcd_wp_chatbot_choose_option');
    delete_option( 'qlcd_wp_chatbot_viewed_products');
    delete_option( 'qlcd_wp_chatbot_help_welcome');
    delete_option( 'qlcd_wp_chatbot_help_msg');
    delete_option( 'qlcd_wp_chatbot_reset');
    delete_option( 'enable_wp_chatbot_opening_hour');
    delete_option( 'wpwbot_hours');
    delete_option( 'enable_wp_chatbot_dailogflow');
    delete_option( 'wpbot_trigger_intent');
    delete_option( 'enable_authentication_webhook');
    delete_option( 'qcld_auth_username');
    delete_option( 'qcld_auth_password');

    delete_option( 'qlcd_wp_chatbot_dialogflow_client_token');
    delete_option( 'qlcd_wp_chatbot_dialogflow_project_id');
    delete_option( 'wp_chatbot_df_api');    
    delete_option( 'qlcd_wp_chatbot_dialogflow_project_key');
    delete_option( '$qlcd_wp_chatbot_dialogflow_defualt_reply');
    delete_option( '$qlcd_wp_chatbot_dialogflow_agent_language');

    qcld_wb_chatboot_defualt_options();
    $html='Reset all options to default successfully.';
    wp_send_json($html);
}
/**
 *
 * Function to load translation files.
 *
 */
function wp_chatbot_lang_init() {
    load_plugin_textdomain( 'wpchatbot', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'wp_chatbot_lang_init');

//plugin activate redirect codecanyon

function qc_wpbotpro_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url('admin.php?page=wpbot_license_page') ) );
    }
}
add_action( 'activated_plugin', 'qc_wpbotpro_activation_redirect' );


/*
* Registering custom end point for Webhook
* @Since 9.3.8
*/
add_action( 'rest_api_init', function () {
    register_rest_route( 'wpbot/v1', '/dialogflow_webhook/', array(
      'methods' => 'POST',
      'callback' => 'qcld_wpbot_dfwebhookcallback',
    ) );
} );

/**
 * Validate Authorization header for the webhook.
 */
function qcld_validate_authorization_header() {
 
    $headers = apache_request_headers();
    if(get_option('enable_authentication_webhook') == 1){
        $username = get_option('qcld_auth_username');
        $password = get_option('qcld_auth_password');
        if ( isset( $headers['authorization'] ) ) {
            $wc_header = 'Basic ' . base64_encode( $username . ':' . $password );
            if ( $headers['authorization'] == $wc_header ) {
                return true;
            }
        }else{
            return false;
        }
    }else{
        return true;
    }

    
}


function qc_apppage_remove_all_scripts() {
    global $wp_scripts;
    $wpbot_script = array('qcld-wp-chatbot-slimsqccrl-js', 'qcld-wp-chatbot-qcquery-cake', 'qcld-wp-chatbot-magnifict-qcpopup', 'qcld-wp-chatbot-plugin', 'qcld-wp-chatbot-front-js', 'wbca_ajax');
    $current_script = $wp_scripts->queue;
    if (is_page('wpwbot-mobile-app')) {
        foreach($current_script as $key=>$value){
            if(!in_array($value, $wpbot_script)){
                unset($current_script[$key]);
            }
        }
        $wp_scripts->queue = array_values($current_script);
    }
    
}

add_action( 'wp_print_scripts', 'qc_apppage_remove_all_scripts', 99 );

add_action('init', 'qc_wp_latest_update_check_pro');
function qc_wp_latest_update_check_pro(){
	if(!get_option('qc_wp_ludate_ck_pro')){
		update_option('qlcd_wp_chatbot_support_phone', 'Leave your number. We will call you back!');
		update_option('qlcd_wp_chatbot_wildcard_support', 'FAQ');
		update_option('qc_wp_ludate_ck_pro', 'done');
	}
}

}