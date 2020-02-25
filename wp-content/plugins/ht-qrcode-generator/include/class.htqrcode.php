<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
class HTQRcode_Addons_Elementor {
    const MINIMUM_PHP_VERSION = '7.0';
    
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action('wp_enqueue_scripts', [ $this,'assets_management'] );
    }

    public function i18n() {
        load_plugin_textdomain( 'ht-qrcode' );
    }

    public function init() {
        
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Plugins Required File
        $this->includes();

        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

    }

    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ht-qrcode' ),
            '<strong>' . esc_html__( 'HT QRCode Addons', 'ht-qrcode' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'ht-qrcode' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

     /**
     * Enqueue scripts and styles
     */
    function admin_enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'ht-admin-qrcode', HTQRCODE_PL_URL . 'assets/js/admin-min.js',array(), HTQRCODE_VERSION, TRUE );
    }

    /*
    * Assest Management
    */
    public function assets_management( $hook ){
        wp_enqueue_script( 'easy-qrcode', HTQRCODE_PL_URL . 'assets/js/easy.qrcode.min.js',array('jquery'), HTQRCODE_VERSION, TRUE );
    }

    public function includes() {
        require_once HTQRCODE_PL_PATH.'include/default_widgets.php';
        require_once HTQRCODE_PL_PATH.'include/qrshortcode.php';
    }

     public function init_widgets() {
        // Include Widget files
        include( HTQRCODE_PL_INCLUDE.'/elementor_widgets.php' );
        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Htqrcode_Elementor_Widget_QRCode() );

    }


}


