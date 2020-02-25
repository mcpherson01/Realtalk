<?php
/*
Plugin Name:       WordPress Preloader Unlimited |  VestaThemes.com
Plugin URI:        http://www.wppreloader.com/
Description: 	   This plugin will enable custom preloader in your wordpress site. You can change color & other setting from <a href="admin.php?page=wppu_options">WPPU</a>
Version: 		   2.9.9
Author:     	   pixiefy
Author URI:  	   http://pixiefy.com
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:       wppu
Domain Path:       /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WPPS_NAME',                 'WordPress Preloader Unlimited' );
define( 'WPPS_REQUIRED_PHP_VERSION', '5.2.17' );                          // because of get_called_class()
define( 'WPPS_REQUIRED_WP_VERSION',  '3.8' );                          // because of esc_textarea()

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function wpps_requirements_met() {
	global $wp_version;

	if ( version_compare( PHP_VERSION, WPPS_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}

	if ( version_compare( $wp_version, WPPS_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function wpps_requirements_error() {
	global $wp_version;

	require_once( dirname( __FILE__ ) . '/requirements-error.php' );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( wpps_requirements_met() ) {


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wppu-activator.php
 */
function activate_WP_Preloader_unlimited() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wppu-activator.php';
	WP_Preloader_unlimited_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wppu-deactivator.php
 */
function deactivate_WP_Preloader_unlimited() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wppu-deactivator.php';
	WP_Preloader_unlimited_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_WP_Preloader_unlimited' );
register_deactivation_hook( __FILE__, 'deactivate_WP_Preloader_unlimited' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wppu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wordpress_preloader_unlimited() {

	$plugin = new WP_Preloader_unlimited();
	$plugin->run();

}
run_wordpress_preloader_unlimited();

require_once plugin_dir_path( __FILE__ ) . 'admin/settings_admin_options.php';
require_once plugin_dir_path( __FILE__ ) . 'public/settings-frontend.php';
if (!class_exists('Mobile_Detect')) {
	require_once plugin_dir_path( __FILE__ ) . 'public/inc/Mobile_Detect.php';
}


} else {
	add_action( 'admin_notices', 'wpps_requirements_error' );
}

function wppu_preloader_ajaxurl(){ ?>
	<script>
		var ajaxurl = '<?php echo admin_url("admin-ajax.php") ?>';
	</script>
<?php }
add_action('wp_head','wppu_preloader_ajaxurl');


add_action( 'admin_init', 'wppu_admin_scripts' );
function wppu_admin_scripts() {
   if ( is_admin() ){
      if ( isset($_GET['page']) && $_GET['page'] == 'wppu_options' ) {
         wp_enqueue_script('jquery');
         wp_enqueue_script( 'jquery-form' );
      }
   }
}


add_action( 'plugins_loaded', 'wppu_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function wppu_load_textdomain() {
  load_plugin_textdomain( 'wppu', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}