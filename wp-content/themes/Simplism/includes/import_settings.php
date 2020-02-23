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

	$importOptions = 'YTo5NDp7czowOiIiO047czoxMzoic2ltcGxpc21fbG9nbyI7czowOiIiO3M6MTY6InNpbXBsaXNtX2Zhdmljb24iO3M6MDoiIjtzOjIxOiJzaW1wbGlzbV9jb2xvcl9zY2hlbWUiO3M6NDoiQmx1ZSI7czoxOToic2ltcGxpc21fYmxvZ19zdHlsZSI7TjtzOjE5OiJzaW1wbGlzbV9ncmFiX2ltYWdlIjtOO3M6MjE6InNpbXBsaXNtX2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjI1OiJzaW1wbGlzbV9hcmNoaXZlbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjQ6InNpbXBsaXNtX3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjIxOiJzaW1wbGlzbV90YWdudW1fcG9zdHMiO3M6MToiNSI7czoyMDoic2ltcGxpc21fZGF0ZV9mb3JtYXQiO3M6NjoiTSBqLCBZIjtzOjIzOiJzaW1wbGlzbV9oZWFkZXJfYWRzZW5zZSI7czowOiIiO3M6MjA6InNpbXBsaXNtX3VzZV9leGNlcnB0IjtOO3M6MTM6InNpbXBsaXNtX3RhYnMiO3M6Mjoib24iO3M6MzU6InNpbXBsaXNtX3Nob3dfdGFiYXJlYV9yZWNlbnRlbnRyaWVzIjtzOjI6Im9uIjtzOjI5OiJzaW1wbGlzbV9zaG93X3RhYmFyZWFfcG9wdWxhciI7czoyOiJvbiI7czozNjoic2ltcGxpc21fc2hvd190YWJhcmVhX3JlY2VudGNvbW1lbnRzIjtzOjI6Im9uIjtzOjI0OiJzaW1wbGlzbV9yZWNlbnRwb3N0c19udW0iO3M6MToiNiI7czoyNjoic2ltcGxpc21fcG9wdWxhcl9wb3N0c19udW0iO3M6MToiNiI7czoyNzoic2ltcGxpc21fcmVjZW50Y29tbWVudHNfbnVtIjtzOjE6IjYiO3M6MjM6InNpbXBsaXNtX2hvbWVwYWdlX3Bvc3RzIjtzOjE6IjgiO3M6MjM6InNpbXBsaXNtX2V4bGNhdHNfcmVjZW50IjtOO3M6MTc6InNpbXBsaXNtX2ZlYXR1cmVkIjtzOjI6Im9uIjtzOjE4OiJzaW1wbGlzbV9kdXBsaWNhdGUiO3M6Mjoib24iO3M6MTc6InNpbXBsaXNtX2ZlYXRfY2F0IjtzOjQ6IkJsb2ciO3M6MTg6InNpbXBsaXNtX21lbnVwYWdlcyI7TjtzOjI1OiJzaW1wbGlzbV9lbmFibGVfZHJvcGRvd25zIjtzOjI6Im9uIjtzOjE4OiJzaW1wbGlzbV9ob21lX2xpbmsiO3M6Mjoib24iO3M6MTk6InNpbXBsaXNtX3NvcnRfcGFnZXMiO3M6MTA6InBvc3RfdGl0bGUiO3M6MTk6InNpbXBsaXNtX29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjI2OiJzaW1wbGlzbV90aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjE3OiJzaW1wbGlzbV9tZW51Y2F0cyI7TjtzOjM2OiJzaW1wbGlzbV9lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6MjU6InNpbXBsaXNtX2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6MzE6InNpbXBsaXNtX3RpZXJzX3Nob3duX2NhdGVnb3JpZXMiO3M6MToiMyI7czoxNzoic2ltcGxpc21fc29ydF9jYXQiO3M6NDoibmFtZSI7czoxODoic2ltcGxpc21fb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoyMDoic2ltcGxpc21fc3dhcF9uYXZiYXIiO047czoyNDoic2ltcGxpc21fZGlzYWJsZV90b3B0aWVyIjtOO3M6MTg6InNpbXBsaXNtX3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MTk6InNpbXBsaXNtX3RodW1ibmFpbHMiO3M6Mjoib24iO3M6MjY6InNpbXBsaXNtX3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjMwOiJzaW1wbGlzbV90aHVtYm5haWxfd2lkdGhfcG9zdHMiO3M6MzoiMTAwIjtzOjMxOiJzaW1wbGlzbV90aHVtYm5haWxfaGVpZ2h0X3Bvc3RzIjtzOjM6IjEwMCI7czoyNDoic2ltcGxpc21fcGFnZV90aHVtYm5haWxzIjtOO3M6Mjc6InNpbXBsaXNtX3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjMwOiJzaW1wbGlzbV90aHVtYm5haWxfd2lkdGhfcGFnZXMiO3M6MzoiMTAwIjtzOjMxOiJzaW1wbGlzbV90aHVtYm5haWxfaGVpZ2h0X3BhZ2VzIjtzOjM6IjEwMCI7czoxODoic2ltcGxpc21fcG9zdGluZm8xIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyNToic2ltcGxpc21fdGh1bWJuYWlsc19pbmRleCI7czoyOiJvbiI7czoyMjoic2ltcGxpc21fY3VzdG9tX2NvbG9ycyI7TjtzOjE4OiJzaW1wbGlzbV9jaGlsZF9jc3MiO047czoyMToic2ltcGxpc21fY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoyMzoic2ltcGxpc21fY29sb3JfbWFpbmZvbnQiO3M6MDoiIjtzOjIzOiJzaW1wbGlzbV9jb2xvcl9tYWlubGluayI7czowOiIiO3M6MjM6InNpbXBsaXNtX2NvbG9yX3BhZ2VsaW5rIjtzOjA6IiI7czozMDoic2ltcGxpc21fY29sb3JfcGFnZWxpbmtfYWN0aXZlIjtzOjA6IiI7czoyMzoic2ltcGxpc21fY29sb3JfaGVhZGluZ3MiO3M6MDoiIjtzOjI4OiJzaW1wbGlzbV9jb2xvcl9zaWRlYmFyX2xpbmtzIjtzOjA6IiI7czoyMDoic2ltcGxpc21fZm9vdGVyX3RleHQiO3M6MDoiIjtzOjI2OiJzaW1wbGlzbV9jb2xvcl9mb290ZXJsaW5rcyI7czowOiIiO3M6MjM6InNpbXBsaXNtX3Nlb19ob21lX3RpdGxlIjtOO3M6Mjk6InNpbXBsaXNtX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjY6InNpbXBsaXNtX3Nlb19ob21lX2tleXdvcmRzIjtOO3M6Mjc6InNpbXBsaXNtX3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjI3OiJzaW1wbGlzbV9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMzOiJzaW1wbGlzbV9zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjMwOiJzaW1wbGlzbV9zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjIyOiJzaW1wbGlzbV9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjY6InNpbXBsaXNtX3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNToic2ltcGxpc21fc2VvX3NpbmdsZV90aXRsZSI7TjtzOjMxOiJzaW1wbGlzbV9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6Mjg6InNpbXBsaXNtX3Nlb19zaW5nbGVfa2V5d29yZHMiO047czoyOToic2ltcGxpc21fc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czozMToic2ltcGxpc21fc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6Mzc6InNpbXBsaXNtX3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozNDoic2ltcGxpc21fc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjI0OiJzaW1wbGlzbV9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyODoic2ltcGxpc21fc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjg6InNpbXBsaXNtX3Nlb19pbmRleF9jYW5vbmljYWwiO047czozMDoic2ltcGxpc21fc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjM6InNpbXBsaXNtX3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6Mjc6InNpbXBsaXNtX3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzI6InNpbXBsaXNtX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjMwOiJzaW1wbGlzbV9pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6MzU6InNpbXBsaXNtX2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjM4OiJzaW1wbGlzbV9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyNToic2ltcGxpc21faW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MjU6InNpbXBsaXNtX2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjMxOiJzaW1wbGlzbV9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozNDoic2ltcGxpc21faW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MTk6InNpbXBsaXNtXzQ2OF9lbmFibGUiO047czoxODoic2ltcGxpc21fNDY4X2ltYWdlIjtzOjA6IiI7czoxNjoic2ltcGxpc21fNDY4X3VybCI7czowOiIiO30=';

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