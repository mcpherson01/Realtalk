<?php
add_action( 'admin_enqueue_scripts', 'import_epanel_javascript' );
function import_epanel_javascript( $hook_suffix ) {
	if ( 'admin.php' == $hook_suffix && isset( $_GET['import'] ) && isset( $_GET['step'] ) && 'wordpress' == $_GET['import'] && '1' == $_GET['step'] )
		add_action( 'admin_head', 'admin_headhook' );
}

function admin_headhook(){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("p.submit").before("<p><input type='checkbox' id='importepanel' name='importepanel' value='1' style='margin-right: 5px;'><label for='importepanel'>Replace ePanel settings with sample data values</label></p>");
		});
	</script>
<?php }

add_action('import_end','importend');
function importend(){
	global $wpdb, $shortname;

	#make custom fields image paths point to sampledata/sample_images folder
	$sample_images_postmeta = $wpdb->get_results(
		$wpdb->prepare( "SELECT meta_id, meta_value FROM $wpdb->postmeta WHERE meta_value REGEXP %s", 'http://et_sample_images.com' )
	);
	if ( $sample_images_postmeta ) {
		foreach ( $sample_images_postmeta as $postmeta ){
			$template_dir = get_template_directory_uri();
			if ( is_multisite() ){
				switch_to_blog(1);
				$main_siteurl = site_url();
				restore_current_blog();

				$template_dir = $main_siteurl . '/wp-content/themes/' . get_template();
			}
			preg_match( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $postmeta->meta_value, $matches );
			$image_path = $matches[1];

			$local_image = preg_replace( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $template_dir . '/sampledata/sample_images/$1.jpg', $postmeta->meta_value );

			$local_image = preg_replace( '/s:55:/', 's:' . strlen( $template_dir . '/sampledata/sample_images/' . $image_path . '.jpg' ) . ':', $local_image );

			$wpdb->update( $wpdb->postmeta, array( 'meta_value' => esc_url_raw( $local_image ) ), array( 'meta_id' => $postmeta->meta_id ), array( '%s' ) );
		}
	}

	if ( !isset($_POST['importepanel']) )
		return;

	$importOptions = 'YTo4Mjp7czowOiIiO047czoxMDoiYmFzaWNfbG9nbyI7czowOiIiO3M6MTM6ImJhc2ljX2Zhdmljb24iO3M6MDoiIjtzOjE4OiJiYXNpY19jb2xvcl9zY2hlbWUiO3M6MzoiUmVkIjtzOjEyOiJiYXNpY19mb3JtYXQiO047czoxNjoiYmFzaWNfZ3JhYl9pbWFnZSI7TjtzOjE3OiJiYXNpY19kYXRlX2Zvcm1hdCI7czo3OiJNIGpTLCBZIjtzOjE4OiJiYXNpY19jYXRudW1fcG9zdHMiO3M6MToiNSI7czoyMjoiYmFzaWNfYXJjaGl2ZW51bV9wb3N0cyI7czoxOiI1IjtzOjIxOiJiYXNpY19zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoxODoiYmFzaWNfdGFnbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MTc6ImJhc2ljX3VzZV9leGNlcnB0IjtOO3M6MjA6ImJhc2ljX2hvbWVwYWdlX3Bvc3RzIjtzOjE6IjYiO3M6MjA6ImJhc2ljX2V4bGNhdHNfcmVjZW50IjtOO3M6MTU6ImJhc2ljX21lbnVwYWdlcyI7TjtzOjIyOiJiYXNpY19lbmFibGVfZHJvcGRvd25zIjtzOjI6Im9uIjtzOjE1OiJiYXNpY19ob21lX2xpbmsiO3M6Mjoib24iO3M6MjM6ImJhc2ljX3RpZXJzX3Nob3duX3BhZ2VzIjtzOjE6IjMiO3M6MTY6ImJhc2ljX3NvcnRfcGFnZXMiO3M6MTA6InBvc3RfdGl0bGUiO3M6MTY6ImJhc2ljX29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjE0OiJiYXNpY19tZW51Y2F0cyI7TjtzOjMzOiJiYXNpY19lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6Mjg6ImJhc2ljX3RpZXJzX3Nob3duX2NhdGVnb3JpZXMiO3M6MToiMyI7czoxNDoiYmFzaWNfc29ydF9jYXQiO3M6NDoibmFtZSI7czoxNToiYmFzaWNfb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxNzoiYmFzaWNfc3dhcF9uYXZiYXIiO047czoyMToiYmFzaWNfZGlzYWJsZV90b3B0aWVyIjtOO3M6MTU6ImJhc2ljX3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MTY6ImJhc2ljX3RodW1ibmFpbHMiO3M6Mjoib24iO3M6MjM6ImJhc2ljX3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjIxOiJiYXNpY190aHVtYm5haWxfd2lkdGgiO3M6MzoiMjAwIjtzOjIyOiJiYXNpY190aHVtYm5haWxfaGVpZ2h0IjtzOjM6IjIwMCI7czoyMToiYmFzaWNfcGFnZV90aHVtYm5haWxzIjtOO3M6MjQ6ImJhc2ljX3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjI3OiJiYXNpY190aHVtYm5haWxfd2lkdGhfcGFnZXMiO3M6MzoiMjAwIjtzOjI4OiJiYXNpY190aHVtYm5haWxfaGVpZ2h0X3BhZ2VzIjtzOjM6IjIwMCI7czoxNToiYmFzaWNfcG9zdGluZm8xIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoxOToiYmFzaWNfY3VzdG9tX2NvbG9ycyI7TjtzOjE1OiJiYXNpY19jaGlsZF9jc3MiO047czoxODoiYmFzaWNfY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoxOToiYmFzaWNfY29sb3JfYmdjb2xvciI7czowOiIiO3M6MjA6ImJhc2ljX2NvbG9yX21haW5mb250IjtzOjA6IiI7czoyMDoiYmFzaWNfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjIzOiJiYXNpY19jb2xvcl9ib3JkZXJjb2xvciI7czowOiIiO3M6MjM6ImJhc2ljX3Bvc3RpbmZvMV9iZ2NvbG9yIjtzOjA6IiI7czoyMzoiYmFzaWNfcG9zdGluZm8yX2JnY29sb3IiO3M6MDoiIjtzOjIwOiJiYXNpY19jb2xvcl9wYWdlbGluayI7czowOiIiO3M6MjY6ImJhc2ljX2NvbG9yX3NpZGViYXJfdGl0bGVzIjtzOjA6IiI7czoxOToiYmFzaWNfY29sb3JfaGVhZGluZyI7czowOiIiO3M6MjA6ImJhc2ljX3Nlb19ob21lX3RpdGxlIjtOO3M6MjY6ImJhc2ljX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjM6ImJhc2ljX3Nlb19ob21lX2tleXdvcmRzIjtOO3M6MjQ6ImJhc2ljX3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjI0OiJiYXNpY19zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMwOiJiYXNpY19zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjI3OiJiYXNpY19zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjE5OiJiYXNpY19zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjM6ImJhc2ljX3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyMjoiYmFzaWNfc2VvX3NpbmdsZV90aXRsZSI7TjtzOjI4OiJiYXNpY19zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6MjU6ImJhc2ljX3Nlb19zaW5nbGVfa2V5d29yZHMiO047czoyNjoiYmFzaWNfc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czoyODoiYmFzaWNfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6MzQ6ImJhc2ljX3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozMToiYmFzaWNfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjIxOiJiYXNpY19zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyNToiYmFzaWNfc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjU6ImJhc2ljX3Nlb19pbmRleF9jYW5vbmljYWwiO047czoyNzoiYmFzaWNfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjA6ImJhc2ljX3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6MjQ6ImJhc2ljX3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjk6ImJhc2ljX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjI3OiJiYXNpY19pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6MzI6ImJhc2ljX2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjM1OiJiYXNpY19pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyMjoiYmFzaWNfaW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MjI6ImJhc2ljX2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjI4OiJiYXNpY19pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozMToiYmFzaWNfaW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MTg6ImJhc2ljX2ZvdXJzaXhlaWdodCI7TjtzOjE2OiJiYXNpY19iYW5uZXJfNDY4IjtzOjU3OiJodHRwOi8vd3d3LmVsZWdhbnR0aGVtZXMuY29tL2ltYWdlcy9TdHVkaW9CbHVlLzQ2OHg2MC5naWYiO3M6MjA6ImJhc2ljX2Jhbm5lcl80NjhfdXJsIjtzOjE6IiMiO30=';

	/*global $options;

	foreach ($options as $value) {
		if( isset( $value['id'] ) ) {
			update_option( $value['id'], $value['std'] );
		}
	} */

	$importedOptions = unserialize(base64_decode($importOptions));

	foreach ($importedOptions as $key=>$value) {
		if ($value != '') update_option( $key, $value );
	}
} ?>