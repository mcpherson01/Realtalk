<?php
/*
|--------------------------------------------------------------------------
| USER FOLLOW
|--------------------------------------------------------------------------
*/

if(!defined('TECONCE_FOLLOW_DIR')) define('TECONCE_FOLLOW_DIR', dirname( __FILE__ ) );
if(!defined('TECONCE_FOLLOW_URL')) define('TECONCE_FOLLOW_URL', plugin_dir_url( __FILE__ ) );


/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function teconce_textdomain() {
    load_plugin_textdomain( 'teconce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('init', 'teconce_textdomain');


/*
|--------------------------------------------------------------------------
| FILE INCLUDES
|--------------------------------------------------------------------------
*/

include_once( TECONCE_FOLLOW_DIR . '/includes/actions.php' );
include_once( TECONCE_FOLLOW_DIR . '/includes/scripts.php' );
include_once( TECONCE_FOLLOW_DIR . '/includes/shortcodes.php' );
include_once( TECONCE_FOLLOW_DIR . '/includes/follow-functions.php' );
include_once( TECONCE_FOLLOW_DIR . '/includes/display-functions.php' );