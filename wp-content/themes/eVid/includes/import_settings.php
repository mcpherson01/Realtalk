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

	$importOptions = 'YTo5NDp7czowOiIiO047czo5OiJldmlkX2xvZ28iO3M6MDoiIjtzOjEyOiJldmlkX2Zhdmljb24iO3M6MDoiIjtzOjE3OiJldmlkX2NvbG9yX3NjaGVtZSI7czo1OiJXaGl0ZSI7czoxNToiZXZpZF9ncmFiX2ltYWdlIjtOO3M6MTY6ImV2aWRfZGF0ZV9mb3JtYXQiO3M6NzoiTSBqUywgWSI7czoxNzoiZXZpZF9jYXRudW1fcG9zdHMiO3M6MToiNSI7czoyMToiZXZpZF9hcmNoaXZlbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjA6ImV2aWRfc2VhcmNobnVtX3Bvc3RzIjtzOjE6IjUiO3M6MTc6ImV2aWRfdGFnbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MTY6ImV2aWRfdXNlX2V4Y2VycHQiO047czoxODoiZXZpZF9yYW5kb21wb3B1bGFyIjtzOjI6Im9uIjtzOjEzOiJldmlkX2hvbWVfbmF2IjtzOjI6Im9uIjtzOjIxOiJldmlkX2hvbWVwYWdlX3BvcHVsYXIiO3M6MToiNiI7czoyMDoiZXZpZF9ob21lcGFnZV9yYW5kb20iO3M6MToiNiI7czoxOToiZXZpZF9ob21lcGFnZV9wb3N0cyI7czoxOiI2IjtzOjE5OiJldmlkX2V4bGNhdHNfcmVjZW50IjtOO3M6MTE6ImV2aWRfY2F0Ym94IjtzOjI6Im9uIjtzOjE3OiJldmlkX2hvbWVfY2F0X29uZSI7czo5OiJQb3J0Zm9saW8iO3M6MjM6ImV2aWRfaG9tZV9jYXRfb25lX3RpdGxlIjtzOjE3OiJQb3J0Zm9saW8gVXBkYXRlcyI7czoyNDoiZXZpZF9ob21lX2NhdF9vbmVfbnVtYmVyIjtzOjE6IjYiO3M6MTc6ImV2aWRfaG9tZV9jYXRfdHdvIjtzOjQ6IkJsb2ciO3M6MjM6ImV2aWRfaG9tZV9jYXRfdHdvX3RpdGxlIjtzOjEyOiJCbG9nIFVwZGF0ZXMiO3M6MjQ6ImV2aWRfaG9tZV9jYXRfdHdvX251bWJlciI7czoxOiI2IjtzOjEzOiJldmlkX2ZlYXR1cmVkIjtzOjI6Im9uIjtzOjE0OiJldmlkX2R1cGxpY2F0ZSI7TjtzOjEzOiJldmlkX2ZlYXRfY2F0IjtzOjg6IkZlYXR1cmVkIjtzOjIyOiJldmlkX2hvbWVwYWdlX2ZlYXR1cmVkIjtzOjE6IjMiO3M6MTQ6ImV2aWRfbWVudXBhZ2VzIjtOO3M6MjE6ImV2aWRfZW5hYmxlX2Ryb3Bkb3ducyI7czoyOiJvbiI7czoyMjoiZXZpZF90aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjE1OiJldmlkX3NvcnRfcGFnZXMiO3M6MTA6InBvc3RfdGl0bGUiO3M6MTU6ImV2aWRfb3JkZXJfcGFnZSI7czozOiJhc2MiO3M6MTM6ImV2aWRfbWVudWNhdHMiO047czozMjoiZXZpZF9lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6Mjc6ImV2aWRfdGllcnNfc2hvd25fY2F0ZWdvcmllcyI7czoxOiIzIjtzOjEzOiJldmlkX3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTQ6ImV2aWRfb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxNjoiZXZpZF9zd2FwX25hdmJhciI7TjtzOjIwOiJldmlkX2Rpc2FibGVfdG9wdGllciI7TjtzOjE0OiJldmlkX2hvbWVfbGluayI7czoyOiJvbiI7czoxNDoiZXZpZF9wb3N0aW5mbzIiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjE1OiJldmlkX3RodW1ibmFpbHMiO3M6Mjoib24iO3M6MjI6ImV2aWRfc2hvd19wb3N0Y29tbWVudHMiO3M6Mjoib24iO3M6MjA6ImV2aWRfdGh1bWJuYWlsX3dpZHRoIjtzOjM6IjIwMCI7czoyMToiZXZpZF90aHVtYm5haWxfaGVpZ2h0IjtzOjM6IjIwMCI7czoyMDoiZXZpZF9wYWdlX3RodW1ibmFpbHMiO047czoyMzoiZXZpZF9zaG93X3BhZ2VzY29tbWVudHMiO047czoyNjoiZXZpZF90aHVtYm5haWxfd2lkdGhfcGFnZXMiO3M6MzoiMjAwIjtzOjI3OiJldmlkX3RodW1ibmFpbF9oZWlnaHRfcGFnZXMiO3M6MzoiMjAwIjtzOjE0OiJldmlkX3Bvc3RpbmZvMSI7YTozOntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjg6ImNvbW1lbnRzIjt9czoxODoiZXZpZF9jdXN0b21fY29sb3JzIjtOO3M6MTQ6ImV2aWRfY2hpbGRfY3NzIjtOO3M6MTc6ImV2aWRfY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoxODoiZXZpZF9jb2xvcl9iZ2NvbG9yIjtzOjA6IiI7czoxOToiZXZpZF9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MTk6ImV2aWRfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjE5OiJldmlkX3Bvc3RpbmZvX2NvbG9yIjtzOjA6IiI7czoxOToiZXZpZF9jb2xvcl9wYWdlbGluayI7czowOiIiO3M6MjU6ImV2aWRfY29sb3Jfc2lkZWJhcl90aXRsZXMiO3M6MDoiIjtzOjE4OiJldmlkX2NvbG9yX2hlYWRpbmciO3M6MDoiIjtzOjE5OiJldmlkX3Nlb19ob21lX3RpdGxlIjtOO3M6MjU6ImV2aWRfc2VvX2hvbWVfZGVzY3JpcHRpb24iO047czoyMjoiZXZpZF9zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjIzOiJldmlkX3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjIzOiJldmlkX3Nlb19ob21lX3RpdGxldGV4dCI7czowOiIiO3M6Mjk6ImV2aWRfc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czoyNjoiZXZpZF9zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjE4OiJldmlkX3Nlb19ob21lX3R5cGUiO3M6Mjc6IkJsb2dOYW1lIHwgQmxvZyBkZXNjcmlwdGlvbiI7czoyMjoiZXZpZF9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjE6ImV2aWRfc2VvX3NpbmdsZV90aXRsZSI7TjtzOjI3OiJldmlkX3Nlb19zaW5nbGVfZGVzY3JpcHRpb24iO047czoyNDoiZXZpZF9zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6MjU6ImV2aWRfc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czoyNzoiZXZpZF9zZW9fc2luZ2xlX2ZpZWxkX3RpdGxlIjtzOjk6InNlb190aXRsZSI7czozMzoiZXZpZF9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MzA6ImV2aWRfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjIwOiJldmlkX3Nlb19zaW5nbGVfdHlwZSI7czoyMToiUG9zdCB0aXRsZSB8IEJsb2dOYW1lIjtzOjI0OiJldmlkX3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI0OiJldmlkX3Nlb19pbmRleF9jYW5vbmljYWwiO047czoyNjoiZXZpZF9zZW9faW5kZXhfZGVzY3JpcHRpb24iO047czoxOToiZXZpZF9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjIzOiJldmlkX3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjg6ImV2aWRfaW50ZWdyYXRlX2hlYWRlcl9lbmFibGUiO3M6Mjoib24iO3M6MjY6ImV2aWRfaW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjMxOiJldmlkX2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjM0OiJldmlkX2ludGVncmF0ZV9zaW5nbGVib3R0b21fZW5hYmxlIjtzOjI6Im9uIjtzOjIxOiJldmlkX2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjIxOiJldmlkX2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjI3OiJldmlkX2ludGVncmF0aW9uX3NpbmdsZV90b3AiO3M6MDoiIjtzOjMwOiJldmlkX2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjE3OiJldmlkX2ZvdXJzaXhlaWdodCI7TjtzOjE1OiJldmlkX2Jhbm5lcl80NjgiO3M6NTc6Imh0dHA6Ly93d3cuZWxlZ2FudHRoZW1lcy5jb20vaW1hZ2VzL1N0dWRpb0JsdWUvNDY4eDYwLmdpZiI7czoxOToiZXZpZF9iYW5uZXJfNDY4X3VybCI7czoxOiIjIjt9';

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