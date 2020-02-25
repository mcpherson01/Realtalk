<?php
/*
Plugin Name: Meta Tags WP |  VestaThemes.com
Plugin URI: https://wordpress.metatags.io/
Description: Meta Tags WP allows you to <em>visually</em> preview and edit your meta tags
Version: 0.2.9
Author: Moe Amaya
Author URI: https://moeamaya.com/
*/


// Load css and javascript files
update_option( 'mts_license_status', 'valid');
function mts_include_assets() {
  wp_enqueue_style( 'metatags_css', plugins_url( '/css/meta_tags.css', __FILE__ ), array(), '0.2.9');
  wp_register_script( 'meta_tags', plugins_url( '/js/meta_tags.js', __FILE__ ), array( 'jquery' ), '20191102', true );
  wp_enqueue_script( 'meta_tags' );
}
add_action('admin_enqueue_scripts', 'mts_include_assets');


// Load vendor php code
require_once plugin_dir_path(__FILE__) . 'vendor/MTS_Plugin_Updater.php';

// Load plugin php code
require_once plugin_dir_path(__FILE__) . 'includes/mts-updater.php';
require_once plugin_dir_path(__FILE__) . 'includes/mts-frontend.php';
require_once plugin_dir_path(__FILE__) . 'includes/mts-functions.php';



// Easy Digital Downloads auto-updater needs
// to be at the root level of the plugin
function mts_plugin_updater() {
  // retrieve our license key from the DB
  $license_key = trim( get_option( 'mts_license_key' ) );

  // setup the updater
  $mts_updater = new MTS_Plugin_Updater( 'https://wordpress.metatags.io', __FILE__,
    array(
      'version' => '0.2.9',          // current version number
      'license' => $license_key,    // license key (used get_option above to retrieve from DB)
      'item_id' => 72,              // ID of the product
      'author'  => 'Moe Amaya',     // author of this plugin
      'beta'    => false,
    )
  );
}
add_action( 'admin_init', 'mts_plugin_updater', 0 );
