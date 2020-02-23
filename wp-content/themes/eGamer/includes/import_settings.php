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

	$importOptions = 'YToxMDA6e3M6MDoiIjtOO3M6MTE6ImVnYW1lcl9sb2dvIjtzOjA6IiI7czoxNDoiZWdhbWVyX2Zhdmljb24iO3M6MDoiIjtzOjE5OiJlZ2FtZXJfY29sb3Jfc2NoZW1lIjtzOjQ6IlJ1c3QiO3M6MTc6ImVnYW1lcl9ibG9nX3N0eWxlIjtOO3M6MTc6ImVnYW1lcl9ncmFiX2ltYWdlIjtOO3M6MTg6ImVnYW1lcl9kYXRlX2Zvcm1hdCI7czo2OiJNIGosIFkiO3M6MTk6ImVnYW1lcl9jYXRudW1fcG9zdHMiO3M6MToiNSI7czoyMzoiZWdhbWVyX2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyMjoiZWdhbWVyX3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjE5OiJlZ2FtZXJfdGFnbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MTg6ImVnYW1lcl91c2VfZXhjZXJwdCI7TjtzOjIxOiJlZ2FtZXJfaG9tZXBhZ2VfcG9zdHMiO3M6MToiNSI7czoxOToiZWdhbWVyX3JhbmRvbV9jb3VudCI7czoxOiI4IjtzOjIwOiJlZ2FtZXJfcG9wdWxhcl9jb3VudCI7czoxOiI4IjtzOjIxOiJlZ2FtZXJfZXhsY2F0c19yZWNlbnQiO047czoxNToiZWdhbWVyX2ZlYXR1cmVkIjtzOjI6Im9uIjtzOjE2OiJlZ2FtZXJfZHVwbGljYXRlIjtOO3M6MTU6ImVnYW1lcl9mZWF0X2NhdCI7czo4OiJGZWF0dXJlZCI7czoyNDoiZWdhbWVyX2hvbWVwYWdlX2ZlYXR1cmVkIjtzOjE6IjMiO3M6MTY6ImVnYW1lcl9tZW51cGFnZXMiO047czoyMzoiZWdhbWVyX2VuYWJsZV9kcm9wZG93bnMiO3M6Mjoib24iO3M6MTY6ImVnYW1lcl9ob21lX2xpbmsiO3M6Mjoib24iO3M6MTc6ImVnYW1lcl9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoxNzoiZWdhbWVyX3NvcnRfcGFnZXMiO3M6MTA6InBvc3RfdGl0bGUiO3M6MjQ6ImVnYW1lcl90aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjE1OiJlZ2FtZXJfbWVudWNhdHMiO047czozNDoiZWdhbWVyX2VuYWJsZV9kcm9wZG93bnNfY2F0ZWdvcmllcyI7czoyOiJvbiI7czoyMzoiZWdhbWVyX2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6Mjk6ImVnYW1lcl90aWVyc19zaG93bl9jYXRlZ29yaWVzIjtzOjE6IjMiO3M6MTU6ImVnYW1lcl9zb3J0X2NhdCI7czo0OiJuYW1lIjtzOjE2OiJlZ2FtZXJfb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxODoiZWdhbWVyX3N3YXBfbmF2YmFyIjtOO3M6MjI6ImVnYW1lcl9kaXNhYmxlX3RvcHRpZXIiO047czoxNjoiZWdhbWVyX3Bvc3RpbmZvMSI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MTc6ImVnYW1lcl90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjI0OiJlZ2FtZXJfc2hvd19wb3N0Y29tbWVudHMiO3M6Mjoib24iO3M6Mjg6ImVnYW1lcl90aHVtYm5haWxfd2lkdGhfcG9zdHMiO3M6MzoiMjUwIjtzOjI5OiJlZ2FtZXJfdGh1bWJuYWlsX2hlaWdodF9wb3N0cyI7czozOiIyNTAiO3M6MjI6ImVnYW1lcl9wYWdlX3RodW1ibmFpbHMiO047czoyNToiZWdhbWVyX3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjI4OiJlZ2FtZXJfdGh1bWJuYWlsX3dpZHRoX3BhZ2VzIjtzOjM6IjI1MCI7czoyOToiZWdhbWVyX3RodW1ibmFpbF9oZWlnaHRfcGFnZXMiO3M6MzoiMjUwIjtzOjE2OiJlZ2FtZXJfcG9zdGluZm8zIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyMzoiZWdhbWVyX2luZGV4X3RodW1ibmFpbHMiO3M6Mjoib24iO3M6MTQ6ImVnYW1lcl9leGNlcnB0IjtOO3M6Mjg6ImVnYW1lcl90aHVtYm5haWxfd2lkdGhfaW5kZXgiO3M6MzoiMTIwIjtzOjI5OiJlZ2FtZXJfdGh1bWJuYWlsX2hlaWdodF9pbmRleCI7czozOiIxMjAiO3M6MTY6ImVnYW1lcl9wb3N0aW5mbzIiO2E6Mzp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czo4OiJjb21tZW50cyI7fXM6MTI6ImVnYW1lcl92aWRlbyI7TjtzOjEzOiJlZ2FtZXJfcmF0aW5nIjtOO3M6MjI6ImVnYW1lcl9wb3B1bGFyX2Rpc3BsYXkiO3M6Mjoib24iO3M6MjE6ImVnYW1lcl9yYW5kb21fZGlzcGxheSI7czoyOiJvbiI7czoxNjoiZWdhbWVyX2hvbWVfbmF2aSI7czoyOiJvbiI7czoyMDoiZWdhbWVyX2N1c3RvbV9jb2xvcnMiO047czoxNjoiZWdhbWVyX2NoaWxkX2NzcyI7TjtzOjE5OiJlZ2FtZXJfY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoyMToiZWdhbWVyX2NvbG9yX21haW5mb250IjtzOjA6IiI7czoyMToiZWdhbWVyX2NvbG9yX21haW5saW5rIjtzOjA6IiI7czoyMToiZWdhbWVyX2NvbG9yX3BhZ2VsaW5rIjtzOjA6IiI7czoyNzoiZWdhbWVyX2NvbG9yX3BhZ2VsaW5rX2hvdmVyIjtzOjA6IiI7czoyMDoiZWdhbWVyX2NvbG9yX2NhdGxpbmsiO3M6MDoiIjtzOjI2OiJlZ2FtZXJfY29sb3JfY2F0bGlua19ob3ZlciI7czowOiIiO3M6Mjc6ImVnYW1lcl9jb2xvcl9yZWNlbnRoZWFkaW5ncyI7czowOiIiO3M6Mjc6ImVnYW1lcl9jb2xvcl9zaWRlYmFyX3RpdGxlcyI7czowOiIiO3M6MjY6ImVnYW1lcl9jb2xvcl9zaWRlYmFyX2xpbmtzIjtzOjA6IiI7czoyMToiZWdhbWVyX2NvbG9yX3Bvc3RpbmZvIjtzOjA6IiI7czoyMToiZWdhbWVyX3Nlb19ob21lX3RpdGxlIjtOO3M6Mjc6ImVnYW1lcl9zZW9faG9tZV9kZXNjcmlwdGlvbiI7TjtzOjI0OiJlZ2FtZXJfc2VvX2hvbWVfa2V5d29yZHMiO047czoyNToiZWdhbWVyX3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjI1OiJlZ2FtZXJfc2VvX2hvbWVfdGl0bGV0ZXh0IjtzOjA6IiI7czozMToiZWdhbWVyX3Nlb19ob21lX2Rlc2NyaXB0aW9udGV4dCI7czowOiIiO3M6Mjg6ImVnYW1lcl9zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjIwOiJlZ2FtZXJfc2VvX2hvbWVfdHlwZSI7czoyNzoiQmxvZ05hbWUgfCBCbG9nIGRlc2NyaXB0aW9uIjtzOjI0OiJlZ2FtZXJfc2VvX2hvbWVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjIzOiJlZ2FtZXJfc2VvX3NpbmdsZV90aXRsZSI7TjtzOjI5OiJlZ2FtZXJfc2VvX3NpbmdsZV9kZXNjcmlwdGlvbiI7TjtzOjI2OiJlZ2FtZXJfc2VvX3NpbmdsZV9rZXl3b3JkcyI7TjtzOjI3OiJlZ2FtZXJfc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czoyOToiZWdhbWVyX3Nlb19zaW5nbGVfZmllbGRfdGl0bGUiO3M6OToic2VvX3RpdGxlIjtzOjM1OiJlZ2FtZXJfc2VvX3NpbmdsZV9maWVsZF9kZXNjcmlwdGlvbiI7czoxNToic2VvX2Rlc2NyaXB0aW9uIjtzOjMyOiJlZ2FtZXJfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjIyOiJlZ2FtZXJfc2VvX3NpbmdsZV90eXBlIjtzOjIxOiJQb3N0IHRpdGxlIHwgQmxvZ05hbWUiO3M6MjY6ImVnYW1lcl9zZW9fc2luZ2xlX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNjoiZWdhbWVyX3Nlb19pbmRleF9jYW5vbmljYWwiO047czoyODoiZWdhbWVyX3Nlb19pbmRleF9kZXNjcmlwdGlvbiI7TjtzOjIxOiJlZ2FtZXJfc2VvX2luZGV4X3R5cGUiO3M6MjQ6IkNhdGVnb3J5IG5hbWUgfCBCbG9nTmFtZSI7czoyNToiZWdhbWVyX3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzA6ImVnYW1lcl9pbnRlZ3JhdGVfaGVhZGVyX2VuYWJsZSI7czoyOiJvbiI7czoyODoiZWdhbWVyX2ludGVncmF0ZV9ib2R5X2VuYWJsZSI7czoyOiJvbiI7czozMzoiZWdhbWVyX2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjM2OiJlZ2FtZXJfaW50ZWdyYXRlX3NpbmdsZWJvdHRvbV9lbmFibGUiO3M6Mjoib24iO3M6MjM6ImVnYW1lcl9pbnRlZ3JhdGlvbl9oZWFkIjtzOjA6IiI7czoyMzoiZWdhbWVyX2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjI5OiJlZ2FtZXJfaW50ZWdyYXRpb25fc2luZ2xlX3RvcCI7czowOiIiO3M6MzI6ImVnYW1lcl9pbnRlZ3JhdGlvbl9zaW5nbGVfYm90dG9tIjtzOjA6IiI7czoxNzoiZWdhbWVyXzQ2OF9lbmFibGUiO047czoxNjoiZWdhbWVyXzQ2OF9pbWFnZSI7czowOiIiO3M6MTQ6ImVnYW1lcl80NjhfdXJsIjtzOjA6IiI7fQ==';

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