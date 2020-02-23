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

	$importOptions = 'YTo5Mzp7czowOiIiO047czoxMToiZXBob3RvX2xvZ28iO3M6MDoiIjtzOjE0OiJlcGhvdG9fZmF2aWNvbiI7czowOiIiO3M6MTk6ImVwaG90b19jb2xvcl9zY2hlbWUiO3M6NToiQmxhY2siO3M6MTc6ImVwaG90b19ncmFiX2ltYWdlIjtOO3M6MTU6ImVwaG90b19mb290ZXJfMSI7czoyOiJvbiI7czoxNToiZXBob3RvX2Zvb3Rlcl8yIjtzOjI6Im9uIjtzOjE1OiJlcGhvdG9fZm9vdGVyXzMiO3M6Mjoib24iO3M6MTM6ImVwaG90b19yYW5kb20iO3M6MToiMyI7czoxODoiZXBob3RvX2RhdGVfZm9ybWF0IjtzOjc6Ik0galMsIFkiO3M6MTg6ImVwaG90b191c2VfZXhjZXJwdCI7TjtzOjIxOiJlcGhvdG9faG9tZXBhZ2VfcG9zdHMiO3M6MToiOCI7czoyMToiZXBob3RvX2V4bGNhdHNfcmVjZW50IjthOjE6e2k6MDtzOjE6IjMiO31zOjE1OiJlcGhvdG9fZmVhdHVyZWQiO3M6Mjoib24iO3M6MTY6ImVwaG90b19kdXBsaWNhdGUiO047czoxODoiZXBob3RvX3NsaWRlcl9hdXRvIjtzOjI6Im9uIjtzOjE5OiJlcGhvdG9fc2xpZGVyX3BhdXNlIjtOO3M6MTU6ImVwaG90b19mZWF0X2NhdCI7czo4OiJGZWF0dXJlZCI7czoyNDoiZXBob3RvX2hvbWVwYWdlX2ZlYXR1cmVkIjtzOjE6IjMiO3M6MTY6ImVwaG90b19tZW51cGFnZXMiO047czoyMzoiZXBob3RvX2VuYWJsZV9kcm9wZG93bnMiO3M6Mjoib24iO3M6MTY6ImVwaG90b19ob21lX2xpbmsiO3M6Mjoib24iO3M6MjQ6ImVwaG90b190aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjE3OiJlcGhvdG9fc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoxNzoiZXBob3RvX29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjE2OiJlcGhvdG9fYmxvZ19saW5rIjtzOjI6Im9uIjtzOjE1OiJlcGhvdG9fYmxvZ19jYXQiO3M6NDoiQmxvZyI7czoxNToiZXBob3RvX21lbnVjYXRzIjthOjE6e2k6MDtzOjE6IjMiO31zOjE1OiJlcGhvdG9fc29ydF9jYXQiO3M6NDoibmFtZSI7czoxNjoiZXBob3RvX29yZGVyX2NhdCI7czozOiJhc2MiO3M6MjI6ImVwaG90b19kaXNhYmxlX3RvcHRpZXIiO047czoxNjoiZXBob3RvX3Bvc3RpbmZvMSI7YTozOntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjg6ImNvbW1lbnRzIjt9czoyMzoiZXBob3RvX3RodW1ibmFpbHNfcGhvdG8iO3M6Mjoib24iO3M6MzA6ImVwaG90b19zaG93X3Bvc3Rjb21tZW50c19waG90byI7czoyOiJvbiI7czoxNjoiZXBob3RvX3Bvc3RpbmZvMiI7YTozOntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjg6ImNvbW1lbnRzIjt9czoyNjoiZXBob3RvX3RodW1ibmFpbHNfYmxvZ3Bvc3QiO3M6Mjoib24iO3M6MzM6ImVwaG90b19zaG93X3Bvc3Rjb21tZW50c19ibG9ncG9zdCI7czoyOiJvbiI7czozMToiZXBob3RvX3RodW1ibmFpbF93aWR0aF9ibG9ncG9zdCI7czozOiIyMDAiO3M6MzI6ImVwaG90b190aHVtYm5haWxfaGVpZ2h0X2Jsb2dwb3N0IjtzOjM6IjIwMCI7czoyMjoiZXBob3RvX3BhZ2VfdGh1bWJuYWlscyI7TjtzOjI1OiJlcGhvdG9fc2hvd19wYWdlc2NvbW1lbnRzIjtOO3M6Mjg6ImVwaG90b190aHVtYm5haWxfd2lkdGhfcGFnZXMiO3M6MzoiMjAwIjtzOjI5OiJlcGhvdG9fdGh1bWJuYWlsX2hlaWdodF9wYWdlcyI7czozOiIyMDAiO3M6MjA6ImVwaG90b19ob21lX3BhZ2VuYXZpIjtzOjI6Im9uIjtzOjIxOiJlcGhvdG9fYmxvZ3BhZ2VfcG9zdHMiO3M6MjoiMTAiO3M6MjM6ImVwaG90b19kZWZhdWx0Y2F0X3Bvc3RzIjtzOjI6IjEwIjtzOjIwOiJlcGhvdG9fY3VzdG9tX2NvbG9ycyI7TjtzOjE2OiJlcGhvdG9fY2hpbGRfY3NzIjtOO3M6MTk6ImVwaG90b19jaGlsZF9jc3N1cmwiO3M6MDoiIjtzOjIwOiJlcGhvdG9fY29sb3JfYmdjb2xvciI7czowOiIiO3M6MjE6ImVwaG90b19jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjE6ImVwaG90b19jb2xvcl9tYWlubGluayI7czowOiIiO3M6MjE6ImVwaG90b19jb2xvcl9wYWdlbGluayI7czowOiIiO3M6MjE6ImVwaG90b19jb2xvcl9jYXRzbGluayI7czowOiIiO3M6MjE6ImVwaG90b19jb2xvcl9wb3N0aW5mbyI7czowOiIiO3M6MjM6ImVwaG90b19jb2xvcl9mZWF0aGVhZGVyIjtzOjA6IiI7czoyNzoiZXBob3RvX2NvbG9yX3NpZGViYXJfdGl0bGVzIjtzOjA6IiI7czoyNjoiZXBob3RvX2NvbG9yX2Zvb3Rlcl90aXRsZXMiO3M6MDoiIjtzOjI1OiJlcGhvdG9fY29sb3JfZm9vdGVyX2xpbmtzIjtzOjA6IiI7czoyMDoiZXBob3RvX2NvbG9yX2hlYWRpbmciO3M6MDoiIjtzOjIxOiJlcGhvdG9fc2VvX2hvbWVfdGl0bGUiO047czoyNzoiZXBob3RvX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjQ6ImVwaG90b19zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjI1OiJlcGhvdG9fc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6MjU6ImVwaG90b19zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMxOiJlcGhvdG9fc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czoyODoiZXBob3RvX3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjA6ImVwaG90b19zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjQ6ImVwaG90b19zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjM6ImVwaG90b19zZW9fc2luZ2xlX3RpdGxlIjtOO3M6Mjk6ImVwaG90b19zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6MjY6ImVwaG90b19zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6Mjc6ImVwaG90b19zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjI5OiJlcGhvdG9fc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6MzU6ImVwaG90b19zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MzI6ImVwaG90b19zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6MjI6ImVwaG90b19zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyNjoiZXBob3RvX3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI2OiJlcGhvdG9fc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjI4OiJlcGhvdG9fc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjE6ImVwaG90b19zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjI1OiJlcGhvdG9fc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMDoiZXBob3RvX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjI4OiJlcGhvdG9faW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjMzOiJlcGhvdG9faW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6MzY6ImVwaG90b19pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyMzoiZXBob3RvX2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjIzOiJlcGhvdG9faW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6Mjk6ImVwaG90b19pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozMjoiZXBob3RvX2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjE3OiJlcGhvdG9fNDY4X2VuYWJsZSI7TjtzOjE2OiJlcGhvdG9fNDY4X2ltYWdlIjtzOjA6IiI7czoxNDoiZXBob3RvXzQ2OF91cmwiO3M6MDoiIjt9';

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