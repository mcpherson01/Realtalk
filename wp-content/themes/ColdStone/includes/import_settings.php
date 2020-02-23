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

	$importOptions = 'YTo5ODp7czowOiIiO047czoxNDoiY29sZHN0b25lX2xvZ28iO3M6MDoiIjtzOjE3OiJjb2xkc3RvbmVfZmF2aWNvbiI7czowOiIiO3M6MjI6ImNvbGRzdG9uZV9jb2xvcl9zY2hlbWUiO3M6NToiU3RvbmUiO3M6MTY6ImNvbGRzdG9uZV9mb3JtYXQiO3M6ODoiQnVzaW5lc3MiO3M6MjA6ImNvbGRzdG9uZV9ncmFiX2ltYWdlIjtOO3M6MjE6ImNvbGRzdG9uZV9kYXRlX2Zvcm1hdCI7czo3OiJNIGpTLCBZIjtzOjIyOiJjb2xkc3RvbmVfY2F0bnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjY6ImNvbGRzdG9uZV9hcmNoaXZlbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjU6ImNvbGRzdG9uZV9zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoyMjoiY29sZHN0b25lX3RhZ251bV9wb3N0cyI7czoxOiI1IjtzOjIxOiJjb2xkc3RvbmVfdXNlX2V4Y2VycHQiO047czoyNDoiY29sZHN0b25lX2hvbWVwYWdlX3Bvc3RzIjtzOjE6IjQiO3M6MjQ6ImNvbGRzdG9uZV9leGxjYXRzX3JlY2VudCI7TjtzOjE4OiJjb2xkc3RvbmVfZmVhdHVyZWQiO3M6Mjoib24iO3M6Mjg6ImNvbGRzdG9uZV9kdXBsaWNhdGVfZmVhdHVyZWQiO047czoxODoiY29sZHN0b25lX2ZlYXRfY2F0IjtzOjg6IkZlYXR1cmVkIjtzOjI1OiJjb2xkc3RvbmVfZmVhdHVyZWRfbnVtYmVyIjtzOjE6IjMiO3M6MTk6ImNvbGRzdG9uZV9tZW51cGFnZXMiO047czoyNjoiY29sZHN0b25lX2VuYWJsZV9kcm9wZG93bnMiO3M6Mjoib24iO3M6MTk6ImNvbGRzdG9uZV9ob21lX2xpbmsiO3M6Mjoib24iO3M6Mjc6ImNvbGRzdG9uZV90aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjIwOiJjb2xkc3RvbmVfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoyMDoiY29sZHN0b25lX29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjE4OiJjb2xkc3RvbmVfbWVudWNhdHMiO047czoyNjoiY29sZHN0b25lX2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6Mzc6ImNvbGRzdG9uZV9lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6MzI6ImNvbGRzdG9uZV90aWVyc19zaG93bl9jYXRlZ29yaWVzIjtzOjE6IjMiO3M6MTg6ImNvbGRzdG9uZV9zb3J0X2NhdCI7czo0OiJuYW1lIjtzOjE5OiJjb2xkc3RvbmVfb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoyNToiY29sZHN0b25lX2Rpc2FibGVfdG9wdGllciI7TjtzOjIxOiJjb2xkc3RvbmVfc3dhcF9uYXZiYXIiO047czoxNjoiY29sZHN0b25lX3NlYXJjaCI7czoyOiJvbiI7czoxOToiY29sZHN0b25lX3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MjA6ImNvbGRzdG9uZV90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjI3OiJjb2xkc3RvbmVfc2hvd19wb3N0Y29tbWVudHMiO3M6Mjoib24iO3M6MjU6ImNvbGRzdG9uZV90aHVtYm5haWxfd2lkdGgiO3M6MzoiMjUwIjtzOjI2OiJjb2xkc3RvbmVfdGh1bWJuYWlsX2hlaWdodCI7czozOiIyNTAiO3M6MjU6ImNvbGRzdG9uZV9wYWdlX3RodW1ibmFpbHMiO047czoyODoiY29sZHN0b25lX3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjMxOiJjb2xkc3RvbmVfdGh1bWJuYWlsX3dpZHRoX3BhZ2VzIjtzOjM6IjI1MCI7czozMjoiY29sZHN0b25lX3RodW1ibmFpbF9oZWlnaHRfcGFnZXMiO3M6MzoiMjUwIjtzOjE5OiJjb2xkc3RvbmVfcG9zdGluZm8xIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoxODoiY29sZHN0b25lX3BhZ2VuYXZpIjtzOjI6Im9uIjtzOjE0OiJjb2xkc3RvbmVfdGFicyI7czoyOiJvbiI7czoyMzoiY29sZHN0b25lX2N1c3RvbV9jb2xvcnMiO047czoxOToiY29sZHN0b25lX2NoaWxkX2NzcyI7TjtzOjIyOiJjb2xkc3RvbmVfY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoyMzoiY29sZHN0b25lX2NvbG9yX2JnY29sb3IiO3M6MDoiIjtzOjI0OiJjb2xkc3RvbmVfY29sb3JfbWFpbmZvbnQiO3M6MDoiIjtzOjI0OiJjb2xkc3RvbmVfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjI0OiJjb2xkc3RvbmVfY29sb3JfcGFnZWxpbmsiO3M6MDoiIjtzOjI0OiJjb2xkc3RvbmVfY29sb3JfY2F0c2xpbmsiO3M6MDoiIjtzOjI0OiJjb2xkc3RvbmVfY29sb3JfcG9zdGluZm8iO3M6MDoiIjtzOjI2OiJjb2xkc3RvbmVfY29sb3JfZmVhdGhlYWRlciI7czowOiIiO3M6MjQ6ImNvbGRzdG9uZV9jb2xvcl9mZWF0dGV4dCI7czowOiIiO3M6MzA6ImNvbGRzdG9uZV9jb2xvcl9zaWRlYmFyX3RpdGxlcyI7czowOiIiO3M6MzA6ImNvbGRzdG9uZV9jb2xvcl9oZWFkaW5nc190aXRsZSI7czowOiIiO3M6MzI6ImNvbGRzdG9uZV9jb2xvcl9oZWFkaW5nc2JnX3RpdGxlIjtzOjA6IiI7czoyMzoiY29sZHN0b25lX2NvbG9yX2hlYWRpbmciO3M6MDoiIjtzOjI0OiJjb2xkc3RvbmVfc2VvX2hvbWVfdGl0bGUiO047czozMDoiY29sZHN0b25lX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6Mjc6ImNvbGRzdG9uZV9zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjI4OiJjb2xkc3RvbmVfc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6Mjg6ImNvbGRzdG9uZV9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjM0OiJjb2xkc3RvbmVfc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czozMToiY29sZHN0b25lX3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjM6ImNvbGRzdG9uZV9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6Mjc6ImNvbGRzdG9uZV9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjY6ImNvbGRzdG9uZV9zZW9fc2luZ2xlX3RpdGxlIjtOO3M6MzI6ImNvbGRzdG9uZV9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6Mjk6ImNvbGRzdG9uZV9zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6MzA6ImNvbGRzdG9uZV9zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjMyOiJjb2xkc3RvbmVfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6Mzg6ImNvbGRzdG9uZV9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MzU6ImNvbGRzdG9uZV9zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6MjU6ImNvbGRzdG9uZV9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyOToiY29sZHN0b25lX3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI5OiJjb2xkc3RvbmVfc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjMxOiJjb2xkc3RvbmVfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjQ6ImNvbGRzdG9uZV9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjI4OiJjb2xkc3RvbmVfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMzoiY29sZHN0b25lX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjMxOiJjb2xkc3RvbmVfaW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjM2OiJjb2xkc3RvbmVfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6Mzk6ImNvbGRzdG9uZV9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyNjoiY29sZHN0b25lX2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjI2OiJjb2xkc3RvbmVfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6MzI6ImNvbGRzdG9uZV9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozNToiY29sZHN0b25lX2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjEzOiJjb2xkc3RvbmVfYWRzIjtOO3M6MjI6ImNvbGRzdG9uZV9mb3Vyc2l4ZWlnaHQiO047czoyNDoiY29sZHN0b25lX2Jhbm5lcl91cmxfb25lIjtzOjA6IiI7czoyNjoiY29sZHN0b25lX2Jhbm5lcl9pbWFnZV9vbmUiO3M6MDoiIjtzOjI0OiJjb2xkc3RvbmVfYmFubmVyX3VybF90d28iO3M6MDoiIjtzOjI2OiJjb2xkc3RvbmVfYmFubmVyX2ltYWdlX3R3byI7czowOiIiO3M6MjA6ImNvbGRzdG9uZV9iYW5uZXJfNDY4IjtzOjA6IiI7czoyNDoiY29sZHN0b25lX2Jhbm5lcl80NjhfdXJsIjtzOjA6IiI7fQ==';

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