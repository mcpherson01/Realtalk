<?php
if ( !function_exists( 'add_action' ) ) {
    exit;
}

/*
* Menu Settings
*/
add_action( 'admin_menu', 'DCPA_menu' );

function DCPA_menu(){
    add_menu_page( __('Progress Ads', 'DCPA-plugin'), __('Progress Ads', 'DCPA-plugin'), 'administrator', 'DCPA_plugin_dashboard', 'DCPA_plugin_dashboard', "dashicons-tide" );
	
	add_submenu_page( 'DCPA_plugin_dashboard', 'Dashboard &lsaquo; Progress Ads', __( 'Dashboard', 'DCPA-plugin' ), 'administrator', 'DCPA_plugin_dashboard' );
	
	add_submenu_page( 'DCPA_plugin_dashboard', 'Editor &lsaquo; Progress Ads', __( 'Editor', 'DCPA-plugin' ), 'administrator', 'DCPA_plugin_editor', 'DCPA_plugin_editor' );
	
	add_submenu_page( 'DCPA_plugin_dashboard', 'Settings &lsaquo; Progress Ads', __( 'Settings', 'DCPA-plugin' ), 'administrator', 'DCPA_plugin_styles', 'DCPA_plugin_styles' );	
}


/*
* Call
*/
require DCPA_DIR . 'admin/admin.php';
require DCPA_DIR . 'admin/editor.php';
require DCPA_DIR . 'admin/styles.php';