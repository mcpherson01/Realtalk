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

	$importOptions = 'YTo4OTp7czowOiIiO047czoxMToiaW5mbHV4X2xvZ28iO3M6MDoiIjtzOjE0OiJpbmZsdXhfZmF2aWNvbiI7czowOiIiO3M6MTk6ImluZmx1eF9jb2xvcl9zY2hlbWUiO3M6NzoiRGVmYXVsdCI7czoxNzoiaW5mbHV4X2Jsb2dfc3R5bGUiO047czoxNzoiaW5mbHV4X2dyYWJfaW1hZ2UiO047czoxODoiaW5mbHV4X3Nob3dfdGFiYmVkIjtzOjI6Im9uIjtzOjE4OiJpbmZsdXhfdGFiX2VudHJpZXMiO3M6MToiOCI7czoxOToiaW5mbHV4X3RhYl9jb21tZW50cyI7czoxOiI4IjtzOjE2OiJpbmZsdXhfYWJvdXR0ZXh0IjtzOjA6IiI7czoxOToiaW5mbHV4X2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjIzOiJpbmZsdXhfYXJjaGl2ZW51bV9wb3N0cyI7czoxOiI1IjtzOjIyOiJpbmZsdXhfc2VhcmNobnVtX3Bvc3RzIjtzOjE6IjUiO3M6MTk6ImluZmx1eF90YWdudW1fcG9zdHMiO3M6MToiNSI7czoxODoiaW5mbHV4X2RhdGVfZm9ybWF0IjtzOjY6Ik0gaiwgWSI7czoxODoiaW5mbHV4X3VzZV9leGNlcnB0IjtOO3M6MjY6ImluZmx1eF9zaG93X3JjZW50ZXJfY29sdW1uIjtzOjI6Im9uIjtzOjE5OiJpbmZsdXhfc2hvd19wb3B1bGFyIjtzOjI6Im9uIjtzOjE4OiJpbmZsdXhfc2hvd19yYW5kb20iO3M6Mjoib24iO3M6MTg6ImluZmx1eF9wb3B1bGFyX251bSI7czoxOiI2IjtzOjE3OiJpbmZsdXhfcmFuZG9tX251bSI7czoxOiI2IjtzOjIxOiJpbmZsdXhfaG9tZXBhZ2VfcG9zdHMiO3M6MToiNyI7czoyMToiaW5mbHV4X2V4bGNhdHNfcmVjZW50IjtOO3M6MTU6ImluZmx1eF9mZWF0dXJlZCI7czoyOiJvbiI7czoxNjoiaW5mbHV4X2R1cGxpY2F0ZSI7czoyOiJvbiI7czoxNToiaW5mbHV4X2ZlYXRfY2F0IjtzOjg6IkZlYXR1cmVkIjtzOjE5OiJpbmZsdXhfZmVhdHVyZWRfbnVtIjtzOjE6IjQiO3M6MTY6ImluZmx1eF9tZW51cGFnZXMiO047czoxNjoiaW5mbHV4X2hvbWVfbGluayI7TjtzOjE3OiJpbmZsdXhfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoxNzoiaW5mbHV4X29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjE1OiJpbmZsdXhfbWVudWNhdHMiO047czoyMzoiaW5mbHV4X2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6MTU6ImluZmx1eF9zb3J0X2NhdCI7czo0OiJuYW1lIjtzOjE2OiJpbmZsdXhfb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxODoiaW5mbHV4X3N3YXBfbmF2YmFyIjtOO3M6MTY6ImluZmx1eF9wb3N0aW5mbzIiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjE3OiJpbmZsdXhfdGh1bWJuYWlscyI7czoyOiJvbiI7czoyNDoiaW5mbHV4X3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjIyOiJpbmZsdXhfcGFnZV90aHVtYm5haWxzIjtOO3M6MjU6ImluZmx1eF9zaG93X3BhZ2VzY29tbWVudHMiO047czoyODoiaW5mbHV4X3RodW1ibmFpbF93aWR0aF9wYWdlcyI7czozOiIxODUiO3M6Mjk6ImluZmx1eF90aHVtYm5haWxfaGVpZ2h0X3BhZ2VzIjtzOjM6IjE4NSI7czoxNjoiaW5mbHV4X3Bvc3RpbmZvMSI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MjA6ImluZmx1eF9jdXN0b21fY29sb3JzIjtOO3M6MTY6ImluZmx1eF9jaGlsZF9jc3MiO047czoxOToiaW5mbHV4X2NoaWxkX2Nzc3VybCI7czowOiIiO3M6MjE6ImluZmx1eF9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjE6ImluZmx1eF9jb2xvcl9tYWlubGluayI7czowOiIiO3M6MjE6ImluZmx1eF9jb2xvcl9wYWdlbGluayI7czowOiIiO3M6Mjg6ImluZmx1eF9jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjIxOiJpbmZsdXhfY29sb3JfaGVhZGluZ3MiO3M6MDoiIjtzOjI2OiJpbmZsdXhfY29sb3Jfc2lkZWJhcl9saW5rcyI7czowOiIiO3M6MjI6ImluZmx1eF9mb290ZXJfaGVhZGluZ3MiO3M6MDoiIjtzOjI0OiJpbmZsdXhfY29sb3JfZm9vdGVybGlua3MiO3M6MDoiIjtzOjIxOiJpbmZsdXhfc2VvX2hvbWVfdGl0bGUiO047czoyNzoiaW5mbHV4X3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjQ6ImluZmx1eF9zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjI1OiJpbmZsdXhfc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6MjU6ImluZmx1eF9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMxOiJpbmZsdXhfc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czoyODoiaW5mbHV4X3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjA6ImluZmx1eF9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjQ6ImluZmx1eF9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjM6ImluZmx1eF9zZW9fc2luZ2xlX3RpdGxlIjtOO3M6Mjk6ImluZmx1eF9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6MjY6ImluZmx1eF9zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6Mjc6ImluZmx1eF9zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjI5OiJpbmZsdXhfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6MzU6ImluZmx1eF9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MzI6ImluZmx1eF9zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6MjI6ImluZmx1eF9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyNjoiaW5mbHV4X3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI2OiJpbmZsdXhfc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjI4OiJpbmZsdXhfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjE6ImluZmx1eF9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjI1OiJpbmZsdXhfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMDoiaW5mbHV4X2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjI4OiJpbmZsdXhfaW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjMzOiJpbmZsdXhfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6MzY6ImluZmx1eF9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyMzoiaW5mbHV4X2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjIzOiJpbmZsdXhfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6Mjk6ImluZmx1eF9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozMjoiaW5mbHV4X2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjE3OiJpbmZsdXhfNDY4X2VuYWJsZSI7TjtzOjE2OiJpbmZsdXhfNDY4X2ltYWdlIjtzOjA6IiI7czoxNDoiaW5mbHV4XzQ2OF91cmwiO3M6MDoiIjtzOjE4OiJpbmZsdXhfNDY4X2Fkc2Vuc2UiO3M6MDoiIjt9';

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