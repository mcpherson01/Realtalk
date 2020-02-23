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

	$importOptions = 'YTo4Njp7czowOiIiO047czoxMToiYXJ0c2VlX2xvZ28iO3M6MDoiIjtzOjE0OiJhcnRzZWVfZmF2aWNvbiI7czowOiIiO3M6MTc6ImFydHNlZV9ibG9nX3N0eWxlIjtOO3M6MTc6ImFydHNlZV9ncmFiX2ltYWdlIjtOO3M6MTk6ImFydHNlZV9jYXRudW1fcG9zdHMiO3M6MToiNiI7czoyMzoiYXJ0c2VlX2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyMjoiYXJ0c2VlX3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjE5OiJhcnRzZWVfdGFnbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MTg6ImFydHNlZV9kYXRlX2Zvcm1hdCI7czo2OiJNIGosIFkiO3M6MjA6ImFydHNlZV9kZWxldGVfYnV0dG9uIjtzOjI6Im9uIjtzOjE5OiJhcnRzZWVfc2hhcmVfYnV0dG9uIjtzOjI6Im9uIjtzOjE3OiJhcnRzZWVfc2hvd19hYm91dCI7czoyOiJvbiI7czoxODoiYXJ0c2VlX3Nob3dfcmFuZG9tIjtzOjI6Im9uIjtzOjI3OiJhcnRzZWVfc2hvd19yZWNlbnRfY29tbWVudHMiO3M6Mjoib24iO3M6MTU6ImFydHNlZV9hYm91dF91cyI7czoxMzoiQWJvdXQgdXMgdGV4dCI7czoyMzoiYXJ0c2VlX3JhbmRvbV9wb3N0c19udW0iO3M6MToiNiI7czoyNToiYXJ0c2VlX3JlY2VudGNvbW1lbnRzX251bSI7czoxOiI2IjtzOjE4OiJhcnRzZWVfdXNlX2V4Y2VycHQiO047czoyMToiYXJ0c2VlX2hvbWVwYWdlX3Bvc3RzIjtzOjE6IjgiO3M6MjE6ImFydHNlZV9leGxjYXRzX3JlY2VudCI7TjtzOjE2OiJhcnRzZWVfbWVudXBhZ2VzIjtOO3M6MjM6ImFydHNlZV9lbmFibGVfZHJvcGRvd25zIjtzOjI6Im9uIjtzOjE2OiJhcnRzZWVfaG9tZV9saW5rIjtzOjI6Im9uIjtzOjE3OiJhcnRzZWVfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoxNzoiYXJ0c2VlX29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjI0OiJhcnRzZWVfdGllcnNfc2hvd25fcGFnZXMiO3M6MToiMyI7czoxNToiYXJ0c2VlX21lbnVjYXRzIjtOO3M6MzQ6ImFydHNlZV9lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6MjM6ImFydHNlZV9jYXRlZ29yaWVzX2VtcHR5IjtzOjI6Im9uIjtzOjI5OiJhcnRzZWVfdGllcnNfc2hvd25fY2F0ZWdvcmllcyI7czoxOiIzIjtzOjE1OiJhcnRzZWVfc29ydF9jYXQiO3M6NDoibmFtZSI7czoxNjoiYXJ0c2VlX29yZGVyX2NhdCI7czozOiJhc2MiO3M6MTg6ImFydHNlZV9zd2FwX25hdmJhciI7TjtzOjIyOiJhcnRzZWVfZGlzYWJsZV90b3B0aWVyIjtOO3M6MTY6ImFydHNlZV9wb3N0aW5mbzIiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjE3OiJhcnRzZWVfdGh1bWJuYWlscyI7czoyOiJvbiI7czoyNDoiYXJ0c2VlX3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjIyOiJhcnRzZWVfcGFnZV90aHVtYm5haWxzIjtOO3M6MjU6ImFydHNlZV9zaG93X3BhZ2VzY29tbWVudHMiO047czoxNjoiYXJ0c2VlX3Bvc3RpbmZvMSI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MjM6ImFydHNlZV90aHVtYm5haWxzX2luZGV4IjtzOjI6Im9uIjtzOjIwOiJhcnRzZWVfY3VzdG9tX2NvbG9ycyI7TjtzOjE2OiJhcnRzZWVfY2hpbGRfY3NzIjtOO3M6MTk6ImFydHNlZV9jaGlsZF9jc3N1cmwiO3M6MDoiIjtzOjIxOiJhcnRzZWVfY29sb3JfbWFpbmZvbnQiO3M6MDoiIjtzOjIxOiJhcnRzZWVfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjIxOiJhcnRzZWVfY29sb3JfcGFnZWxpbmsiO3M6MDoiIjtzOjI4OiJhcnRzZWVfY29sb3JfcGFnZWxpbmtfYWN0aXZlIjtzOjA6IiI7czoyMToiYXJ0c2VlX2NvbG9yX2hlYWRpbmdzIjtzOjA6IiI7czoyNjoiYXJ0c2VlX2NvbG9yX3NpZGViYXJfbGlua3MiO3M6MDoiIjtzOjE4OiJhcnRzZWVfZm9vdGVyX3RleHQiO3M6MDoiIjtzOjI0OiJhcnRzZWVfY29sb3JfZm9vdGVybGlua3MiO3M6MDoiIjtzOjIxOiJhcnRzZWVfc2VvX2hvbWVfdGl0bGUiO047czoyNzoiYXJ0c2VlX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjQ6ImFydHNlZV9zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjI1OiJhcnRzZWVfc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6MjU6ImFydHNlZV9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMxOiJhcnRzZWVfc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czoyODoiYXJ0c2VlX3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjA6ImFydHNlZV9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjQ6ImFydHNlZV9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjM6ImFydHNlZV9zZW9fc2luZ2xlX3RpdGxlIjtOO3M6Mjk6ImFydHNlZV9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6MjY6ImFydHNlZV9zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6Mjc6ImFydHNlZV9zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjI5OiJhcnRzZWVfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6MzU6ImFydHNlZV9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MzI6ImFydHNlZV9zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6MjI6ImFydHNlZV9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyNjoiYXJ0c2VlX3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI2OiJhcnRzZWVfc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjI4OiJhcnRzZWVfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjE6ImFydHNlZV9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjI1OiJhcnRzZWVfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMDoiYXJ0c2VlX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjI4OiJhcnRzZWVfaW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjMzOiJhcnRzZWVfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6MzY6ImFydHNlZV9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyMzoiYXJ0c2VlX2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjIzOiJhcnRzZWVfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6Mjk6ImFydHNlZV9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozMjoiYXJ0c2VlX2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjE3OiJhcnRzZWVfNDY4X2VuYWJsZSI7TjtzOjE2OiJhcnRzZWVfNDY4X2ltYWdlIjtzOjA6IiI7czoxNDoiYXJ0c2VlXzQ2OF91cmwiO3M6MDoiIjt9';

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