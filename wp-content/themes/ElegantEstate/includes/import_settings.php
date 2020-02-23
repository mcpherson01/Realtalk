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

	$importOptions = 'YTo2OTp7czoxODoiZWxlZ2FudGVzdGF0ZV9sb2dvIjtzOjA6IiI7czoyMToiZWxlZ2FudGVzdGF0ZV9mYXZpY29uIjtzOjA6IiI7czoyNjoiZWxlZ2FudGVzdGF0ZV9jb2xvcl9zY2hlbWUiO3M6NzoiRGVmYXVsdCI7czoyMjoiZWxlZ2FudGVzdGF0ZV9ibG9nX2NhdCI7czo0OiJCbG9nIjtzOjI2OiJlbGVnYW50ZXN0YXRlX2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjMwOiJlbGVnYW50ZXN0YXRlX2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyOToiZWxlZ2FudGVzdGF0ZV9zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoyNjoiZWxlZ2FudGVzdGF0ZV90YWdudW1fcG9zdHMiO3M6MToiNSI7czoyNToiZWxlZ2FudGVzdGF0ZV9kYXRlX2Zvcm1hdCI7czo2OiJNIGosIFkiO3M6Mjg6ImVsZWdhbnRlc3RhdGVfaG9tZXBhZ2VfcG9zdHMiO3M6MToiNCI7czoyODoiZWxlZ2FudGVzdGF0ZV9leGxjYXRzX3JlY2VudCI7YToyOntpOjA7czoxOiIzIjtpOjE7czoxOiIxIjt9czoyMzoiZWxlZ2FudGVzdGF0ZV9kdXBsaWNhdGUiO3M6Mjoib24iO3M6MjI6ImVsZWdhbnRlc3RhdGVfZmVhdF9jYXQiO3M6ODoiRmVhdHVyZWQiO3M6MjY6ImVsZWdhbnRlc3RhdGVfZmVhdHVyZWRfbnVtIjtzOjE6IjMiO3M6MzA6ImVsZWdhbnRlc3RhdGVfc2xpZGVyX2F1dG9zcGVlZCI7czo0OiIzMDAwIjtzOjI3OiJlbGVnYW50ZXN0YXRlX3NsaWRlcl9lZmZlY3QiO3M6NDoiZmFkZSI7czoyMjoiZWxlZ2FudGVzdGF0ZV9saXN0aW5ncyI7czoyOiJvbiI7czoyMzoiZWxlZ2FudGVzdGF0ZV9saXN0aW5nczEiO2E6Mjp7aTowO3M6MToiMyI7aToxO3M6MToiNCI7fXM6MjM6ImVsZWdhbnRlc3RhdGVfbGlzdGluZ3MyIjthOjI6e2k6MDtzOjE6IjQiO2k6MTtzOjE6IjUiO31zOjIzOiJlbGVnYW50ZXN0YXRlX2xpc3RpbmdzMyI7YToyOntpOjA7czoxOiIzIjtpOjE7czoxOiI1Ijt9czoyMzoiZWxlZ2FudGVzdGF0ZV9saXN0aW5nczQiO2E6Mzp7aTowO3M6MToiMyI7aToxO3M6MToiNCI7aToyO3M6MToiNSI7fXM6MzA6ImVsZWdhbnRlc3RhdGVfZW5hYmxlX2Ryb3Bkb3ducyI7czoyOiJvbiI7czoyMzoiZWxlZ2FudGVzdGF0ZV9ob21lX2xpbmsiO3M6Mjoib24iO3M6MjQ6ImVsZWdhbnRlc3RhdGVfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoyNDoiZWxlZ2FudGVzdGF0ZV9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czozMToiZWxlZ2FudGVzdGF0ZV90aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjQxOiJlbGVnYW50ZXN0YXRlX2VuYWJsZV9kcm9wZG93bnNfY2F0ZWdvcmllcyI7czoyOiJvbiI7czozMDoiZWxlZ2FudGVzdGF0ZV9jYXRlZ29yaWVzX2VtcHR5IjtzOjI6Im9uIjtzOjM2OiJlbGVnYW50ZXN0YXRlX3RpZXJzX3Nob3duX2NhdGVnb3JpZXMiO3M6MToiMyI7czoyMjoiZWxlZ2FudGVzdGF0ZV9zb3J0X2NhdCI7czo0OiJuYW1lIjtzOjIzOiJlbGVnYW50ZXN0YXRlX29yZGVyX2NhdCI7czozOiJhc2MiO3M6MjM6ImVsZWdhbnRlc3RhdGVfcG9zdGluZm8yIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyNDoiZWxlZ2FudGVzdGF0ZV90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjMxOiJlbGVnYW50ZXN0YXRlX3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjI3OiJlbGVnYW50ZXN0YXRlX2NvbnRhY3RfYWdlbnQiO3M6MToiIyI7czoyMzoiZWxlZ2FudGVzdGF0ZV9wb3N0aW5mbzEiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjMwOiJlbGVnYW50ZXN0YXRlX3RodW1ibmFpbHNfaW5kZXgiO3M6Mjoib24iO3M6MjY6ImVsZWdhbnRlc3RhdGVfY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoyNzoiZWxlZ2FudGVzdGF0ZV9jb2xvcl9iZ2NvbG9yIjtzOjA6IiI7czoyODoiZWxlZ2FudGVzdGF0ZV9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6Mjg6ImVsZWdhbnRlc3RhdGVfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjI4OiJlbGVnYW50ZXN0YXRlX2NvbG9yX3BhZ2VsaW5rIjtzOjA6IiI7czoyODoiZWxlZ2FudGVzdGF0ZV9jb2xvcl9jYXRzbGluayI7czowOiIiO3M6MzQ6ImVsZWdhbnRlc3RhdGVfY29sb3Jfc2lkZWJhcl90aXRsZXMiO3M6MDoiIjtzOjI3OiJlbGVnYW50ZXN0YXRlX3NpZGViYXJfbGlua3MiO3M6MDoiIjtzOjMyOiJlbGVnYW50ZXN0YXRlX2NvbG9yX2Zvb3Rlcl9saW5rcyI7czowOiIiO3M6MzI6ImVsZWdhbnRlc3RhdGVfc2VvX2hvbWVfdGl0bGV0ZXh0IjtzOjA6IiI7czozODoiZWxlZ2FudGVzdGF0ZV9zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjM1OiJlbGVnYW50ZXN0YXRlX3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6Mjc6ImVsZWdhbnRlc3RhdGVfc2VvX2hvbWVfdHlwZSI7czoyNzoiQmxvZ05hbWUgfCBCbG9nIGRlc2NyaXB0aW9uIjtzOjMxOiJlbGVnYW50ZXN0YXRlX3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czozNjoiZWxlZ2FudGVzdGF0ZV9zZW9fc2luZ2xlX2ZpZWxkX3RpdGxlIjtzOjk6InNlb190aXRsZSI7czo0MjoiZWxlZ2FudGVzdGF0ZV9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6Mzk6ImVsZWdhbnRlc3RhdGVfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjI5OiJlbGVnYW50ZXN0YXRlX3Nlb19zaW5nbGVfdHlwZSI7czoyMToiUG9zdCB0aXRsZSB8IEJsb2dOYW1lIjtzOjMzOiJlbGVnYW50ZXN0YXRlX3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI4OiJlbGVnYW50ZXN0YXRlX3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6MzI6ImVsZWdhbnRlc3RhdGVfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozNzoiZWxlZ2FudGVzdGF0ZV9pbnRlZ3JhdGVfaGVhZGVyX2VuYWJsZSI7czoyOiJvbiI7czozNToiZWxlZ2FudGVzdGF0ZV9pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6NDA6ImVsZWdhbnRlc3RhdGVfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6NDM6ImVsZWdhbnRlc3RhdGVfaW50ZWdyYXRlX3NpbmdsZWJvdHRvbV9lbmFibGUiO3M6Mjoib24iO3M6MzA6ImVsZWdhbnRlc3RhdGVfaW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MzA6ImVsZWdhbnRlc3RhdGVfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6MzY6ImVsZWdhbnRlc3RhdGVfaW50ZWdyYXRpb25fc2luZ2xlX3RvcCI7czowOiIiO3M6Mzk6ImVsZWdhbnRlc3RhdGVfaW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MjM6ImVsZWdhbnRlc3RhdGVfNDY4X2ltYWdlIjtzOjA6IiI7czoyMToiZWxlZ2FudGVzdGF0ZV80NjhfdXJsIjtzOjA6IiI7czoyNToiZWxlZ2FudGVzdGF0ZV80NjhfYWRzZW5zZSI7czowOiIiO30';

	/*global $options;

	foreach ($options as $value) {
		if( isset( $value['id'] ) && isset( $value['std'] ) ) {
			update_option( $value['id'], $value['std'] );
		}
	}*/

	$importedOptions = unserialize(base64_decode($importOptions));

	foreach ($importedOptions as $key=>$value) {
		if ($value != '') update_option( $key, $value );
	}

	update_option( $shortname . '_use_pages', 'false' );
} ?>