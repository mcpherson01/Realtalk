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

	$importOptions = 'YTo5MTp7czowOiIiO047czoxMzoicHVyZXR5cGVfbG9nbyI7czowOiIiO3M6MTY6InB1cmV0eXBlX2Zhdmljb24iO3M6MDoiIjtzOjIxOiJwdXJldHlwZV9jb2xvcl9zY2hlbWUiO3M6NzoiRGVmYXVsdCI7czoxNToicHVyZXR5cGVfZm9ybWF0IjtOO3M6MTk6InB1cmV0eXBlX2dyYWJfaW1hZ2UiO047czoxODoicHVyZXR5cGVfdGl0bGVfcmVkIjtzOjQ6InB1cmUiO3M6MTk6InB1cmV0eXBlX3RpdGxlX2JsdWUiO3M6NDoidHlwZSI7czoyMDoicHVyZXR5cGVfZGF0ZV9mb3JtYXQiO3M6NzoiTSBqUywgWSI7czoyMToicHVyZXR5cGVfY2F0bnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjU6InB1cmV0eXBlX2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyNDoicHVyZXR5cGVfc2VhcmNobnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjE6InB1cmV0eXBlX3RhZ251bV9wb3N0cyI7czoxOiI1IjtzOjIwOiJwdXJldHlwZV91c2VfZXhjZXJwdCI7TjtzOjE1OiJwdXJldHlwZV9yYW5kb20iO3M6MToiOCI7czoyMzoicHVyZXR5cGVfaG9tZXBhZ2VfcG9zdHMiO3M6MToiNiI7czoyMzoicHVyZXR5cGVfZXhsY2F0c19yZWNlbnQiO047czoxNzoicHVyZXR5cGVfZmVhdHVyZWQiO3M6Mjoib24iO3M6MTY6InB1cmV0eXBlX3BvcHVsYXIiO3M6Mjoib24iO3M6MTc6InB1cmV0eXBlX2ZlYXRfY2F0IjtzOjg6IkZlYXR1cmVkIjtzOjI2OiJwdXJldHlwZV9ob21lcGFnZV9mZWF0dXJlZCI7czoxOiIxIjtzOjE4OiJwdXJldHlwZV9tZW51cGFnZXMiO047czoyNToicHVyZXR5cGVfZW5hYmxlX2Ryb3Bkb3ducyI7czoyOiJvbiI7czoxODoicHVyZXR5cGVfaG9tZV9saW5rIjtzOjI6Im9uIjtzOjI2OiJwdXJldHlwZV90aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjE5OiJwdXJldHlwZV9zb3J0X3BhZ2VzIjtzOjEwOiJwb3N0X3RpdGxlIjtzOjE5OiJwdXJldHlwZV9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoxNzoicHVyZXR5cGVfbWVudWNhdHMiO047czozNjoicHVyZXR5cGVfZW5hYmxlX2Ryb3Bkb3duc19jYXRlZ29yaWVzIjtzOjI6Im9uIjtzOjMxOiJwdXJldHlwZV90aWVyc19zaG93bl9jYXRlZ29yaWVzIjtzOjE6IjMiO3M6MTc6InB1cmV0eXBlX3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTg6InB1cmV0eXBlX29yZGVyX2NhdCI7czozOiJhc2MiO3M6MjQ6InB1cmV0eXBlX2Rpc2FibGVfdG9wdGllciI7TjtzOjI2OiJwdXJldHlwZV9zaG93X3Bvc3Rjb21tZW50cyI7czoyOiJvbiI7czoxOToicHVyZXR5cGVfdGh1bWJuYWlscyI7czoyOiJvbiI7czoyNDoicHVyZXR5cGVfdGh1bWJuYWlsX3dpZHRoIjtzOjM6IjIwMCI7czoyNToicHVyZXR5cGVfdGh1bWJuYWlsX2hlaWdodCI7czozOiIyMDAiO3M6MTg6InB1cmV0eXBlX3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MjQ6InB1cmV0eXBlX3BhZ2VfdGh1bWJuYWlscyI7TjtzOjI3OiJwdXJldHlwZV9zaG93X3BhZ2VzY29tbWVudHMiO047czozMDoicHVyZXR5cGVfdGh1bWJuYWlsX3dpZHRoX3BhZ2VzIjtzOjM6IjIwMCI7czozMToicHVyZXR5cGVfdGh1bWJuYWlsX2hlaWdodF9wYWdlcyI7czozOiIyMDAiO3M6MTg6InB1cmV0eXBlX3Bvc3RpbmZvMSI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MjI6InB1cmV0eXBlX2N1c3RvbV9jb2xvcnMiO047czoxODoicHVyZXR5cGVfY2hpbGRfY3NzIjtOO3M6MjE6InB1cmV0eXBlX2NoaWxkX2Nzc3VybCI7czowOiIiO3M6MjI6InB1cmV0eXBlX2NvbG9yX2JnY29sb3IiO3M6MDoiIjtzOjI2OiJwdXJldHlwZV9jb2xvcl9jYXRzYmdjb2xvciI7czowOiIiO3M6MjM6InB1cmV0eXBlX2NvbG9yX21haW5mb250IjtzOjA6IiI7czoyMzoicHVyZXR5cGVfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjIzOiJwdXJldHlwZV9jb2xvcl9wYWdlbGluayI7czowOiIiO3M6MjM6InB1cmV0eXBlX2NvbG9yX2NhdHNsaW5rIjtzOjA6IiI7czoyMzoicHVyZXR5cGVfY29sb3JfcG9zdGluZm8iO3M6MDoiIjtzOjMxOiJwdXJldHlwZV9jb2xvcl9zaWRlYmFyYmdfdGl0bGVzIjtzOjA6IiI7czoyOToicHVyZXR5cGVfY29sb3Jfc2lkZWJhcl90aXRsZXMiO3M6MDoiIjtzOjI4OiJwdXJldHlwZV9jb2xvcl9mb290ZXJfdGl0bGVzIjtzOjA6IiI7czoyNzoicHVyZXR5cGVfY29sb3JfZm9vdGVyX2xpbmtzIjtzOjA6IiI7czoyMjoicHVyZXR5cGVfY29sb3JfaGVhZGluZyI7czowOiIiO3M6MjM6InB1cmV0eXBlX3Nlb19ob21lX3RpdGxlIjtOO3M6Mjk6InB1cmV0eXBlX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjY6InB1cmV0eXBlX3Nlb19ob21lX2tleXdvcmRzIjtOO3M6Mjc6InB1cmV0eXBlX3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjI3OiJwdXJldHlwZV9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMzOiJwdXJldHlwZV9zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjMwOiJwdXJldHlwZV9zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjIyOiJwdXJldHlwZV9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjY6InB1cmV0eXBlX3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNToicHVyZXR5cGVfc2VvX3NpbmdsZV90aXRsZSI7TjtzOjMxOiJwdXJldHlwZV9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6Mjg6InB1cmV0eXBlX3Nlb19zaW5nbGVfa2V5d29yZHMiO047czoyOToicHVyZXR5cGVfc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czozMToicHVyZXR5cGVfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6Mzc6InB1cmV0eXBlX3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozNDoicHVyZXR5cGVfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjI0OiJwdXJldHlwZV9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyODoicHVyZXR5cGVfc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjg6InB1cmV0eXBlX3Nlb19pbmRleF9jYW5vbmljYWwiO047czozMDoicHVyZXR5cGVfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjM6InB1cmV0eXBlX3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6Mjc6InB1cmV0eXBlX3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzI6InB1cmV0eXBlX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjMwOiJwdXJldHlwZV9pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6MzU6InB1cmV0eXBlX2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjM4OiJwdXJldHlwZV9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyNToicHVyZXR5cGVfaW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MjU6InB1cmV0eXBlX2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjMxOiJwdXJldHlwZV9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozNDoicHVyZXR5cGVfaW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MjE6InB1cmV0eXBlX2ZvdXJzaXhlaWdodCI7TjtzOjE5OiJwdXJldHlwZV9iYW5uZXJfNDY4IjtzOjU3OiJodHRwOi8vd3d3LmVsZWdhbnR0aGVtZXMuY29tL2ltYWdlcy9TdHVkaW9CbHVlLzQ2OHg2MC5naWYiO3M6MjM6InB1cmV0eXBlX2Jhbm5lcl80NjhfdXJsIjtzOjE6IiMiO30=';

	/*global $options;

	foreach ($options as $value) {
		if( isset( $value['id'] ) ) {
			update_option( $value['id'], $value['std'] );
		}
	}*/

	$importedOptions = unserialize(base64_decode($importOptions));

	foreach ($importedOptions as $key=>$value) {
		if ($value != '') update_option( $key, $value );
	}
} ?>