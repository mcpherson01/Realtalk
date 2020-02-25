<?php

/*
Plugin Name: AIT Languages
Version: 3.0.36

Author: AitThemes.Club
Plugin URI: https://www.ait-themes.club/multilingual-support/
Author URI: https://www.ait-themes.club
Description: Adds multilingual capability to WordPress
Text Domain: polylang
Domain Path: /languages
*/

/* stable@r748 */

// don't access directly
if(!function_exists('add_action')){
	exit;
}

define('AIT_LANGUAGES_ENABLED', true);

define('POLYLANG_BASENAME', plugin_basename(__FILE__));
define('PLL_LINGOTEK_AD', false);
define('PLL_DISPLAY_ABOUT', false);
define('PLL_OLT', false);


require_once __DIR__ . '/ait/AitLanguages.php';


// Add actions/filters before include Polylang
AitLanguages::before();


// Original Polylang plugin
require_once __DIR__ . '/polylang.php';

// Our OLT Manager
require_once __DIR__ . '/ait/AitOltManager.php';

// Add actions/filters after include Polylang
AitLanguages::after();


//  Hyyan WooCommerce Polylang Integration
require_once __DIR__ . '/ait/woo-poly-integration/__init__.php';
require_once __DIR__ . '/ait/AitWpiPlugin.php';

new AitWpiPlugin();
