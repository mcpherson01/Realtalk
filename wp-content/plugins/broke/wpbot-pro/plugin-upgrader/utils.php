<?php
function wpbotpro_show_empty_license_notification_on_plugin_row( $plugin_file, $plugin_data, $status ) {
	
	$qcld_renew_subscription = get_wpbotpro_renew_transient();

	if( !get_wpbotpro_license_purchase_code() ){		
		$params = array(
					'body' => array(
						'action'       => 'info',
						'plugin-slug'  => wpbotpro_LICENSING_PLUGIN_SLUG,
					),
				);
		$request = wp_remote_post(wpbotpro_LICENSING_REMOTE_PATH, $params, array('timeout' => 60) );

		$remote_data = '';
		if ( !is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$remote_data = unserialize( $request['body'] );
			$get_plugin_data = get_wpbotpro_licensing_plugin_data();

			$plugin_current_version = $get_plugin_data['Version'];
			
			if ( $remote_data && version_compare( $plugin_current_version, $remote_data->new_version, '<' ) ) {
				echo '<tr class="plugin-update-tr wpbotpro-empty-license">
			  			<td colspan="3" class="plugin-update colspanchange">
				        	<div class="update-message notice inline notice-warning notice-alt">
				        		<p>There is a new version available. <a href="'.esc_url('https://www.ultrawebmedia.com/li/plugins/wpbot-pro/changelog.txt').'" target="_blank">View version details</a>. Automatic update is unavailable for this plugin. To receive automatic updates, valid license is required.Updates are crucial for compatibility and security.</p>
				        	</div>
				        </td>
				    </tr>';
			}
		}
	}
}
add_action("after_plugin_row_".wpbotpro_LICENSING_PLUGIN_SLUG, 'wpbotpro_show_empty_license_notification_on_plugin_row', 9, 3 );

function qcld_wpbotpro_activate_au()
{
	$plugin_slug = wpbotpro_LICENSING_PLUGIN_SLUG;
	$get_plugin_data = get_wpbotpro_licensing_plugin_data();
	

	$plugin_current_version = $get_plugin_data['Version'];
	$plugin_remote_path =  wpbotpro_LICENSING_REMOTE_PATH;
	$license_key = get_wpbotpro_licensing_key();
	$buy_from = get_wpbotpro_licensing_buy_from();
	
	if( $buy_from == 'quantumcloud' ){
		$upgrader_instance = new QCLD_wpbotpro_AutoUpdate ( $plugin_current_version, $plugin_remote_path, $plugin_slug, '', $license_key );
	}
}
add_action( 'init', 'qcld_wpbotpro_activate_au' );


function qcld_wpbotpro_upgrade_completed( $upgrader_object, $options ) {
	// The path to our plugin's main file
	$plugin_slug = wpbotpro_LICENSING_PLUGIN_SLUG;
	// If an update has taken place and the updated type is plugins and the plugins element exists
	if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		// Iterate through the plugins being updated and check if ours is there
		foreach( $options['plugins'] as $plugin ) {
			if( $plugin == $plugin_slug ) {
				delete_wpbotpro_update_transient();
				delete_wpbotpro_renew_transient();
			}
		}
	}
}
add_action( 'upgrader_process_complete', 'qcld_wpbotpro_upgrade_completed', 10, 2 );

add_action('admin_enqueue_scripts', 'qcld_wpbotpro_licensing_scripts');

function qcld_wpbotpro_licensing_scripts(){
	wp_enqueue_style('qcld_wpbotpro_licensing_style', plugin_dir_url( __FILE__ ).'/assets/css/style.css');

	//start new-update-for-codecanyon
	wp_enqueue_script('qcld_wpbotpro_licensing_script', plugin_dir_url( __FILE__ ).'/assets/js/script.js', array('jquery'), false, true );

	wp_localize_script( 'qcld_wpbotpro_licensing_script', 'wpbotpro_licensing_admin_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce( "wpbotpro_licensing_admin_nonce" )
		)
	);
	//end new-update-for-codecanyon
}