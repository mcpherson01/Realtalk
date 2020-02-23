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

	$importOptions = 'YTo5Nzp7czowOiIiO047czoxMjoid2hvc3dob19sb2dvIjtzOjA6IiI7czoxNToid2hvc3dob19mYXZpY29uIjtzOjA6IiI7czoyMDoid2hvc3dob19jb2xvcl9zY2hlbWUiO3M6NDoiQmx1ZSI7czoxODoid2hvc3dob19ibG9nX3N0eWxlIjtOO3M6MTg6Indob3N3aG9fZ3JhYl9pbWFnZSI7TjtzOjIwOiJ3aG9zd2hvX2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjI0OiJ3aG9zd2hvX2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyMzoid2hvc3dob19zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoyMDoid2hvc3dob190YWdudW1fcG9zdHMiO3M6MToiNSI7czoxOToid2hvc3dob19kYXRlX2Zvcm1hdCI7czo2OiJNIGosIFkiO3M6MTk6Indob3N3aG9fdXNlX2V4Y2VycHQiO047czoyMToid2hvc3dob19zaG93X2NhdGJveGVzIjtzOjI6Im9uIjtzOjIwOiJ3aG9zd2hvX3Nob3dfcG9wdWxhciI7czoyOiJvbiI7czoyNzoid2hvc3dob19zaG93X3JlY2VudGNvbW1lbnRzIjtzOjI6Im9uIjtzOjEyOiJ3aG9zd2hvX2ZlZWQiO3M6MDoiIjtzOjIwOiJ3aG9zd2hvX2hvbWVfY2F0X29uZSI7czo0OiJCbG9nIjtzOjIwOiJ3aG9zd2hvX2hvbWVfY2F0X3R3byI7czo4OiJGZWF0dXJlZCI7czoyMjoid2hvc3dob19ob21lX2NhdF90aHJlZSI7czo0OiJCbG9nIjtzOjIxOiJ3aG9zd2hvX2hvbWVfY2F0X2ZvdXIiO3M6OToiUG9ydGZvbGlvIjtzOjE4OiJ3aG9zd2hvX3JhbmRvbV9udW0iO3M6MjoiMTAiO3M6MTk6Indob3N3aG9fcG9wdWxhcl9udW0iO3M6MToiNiI7czoyMzoid2hvc3dob19yZWNlbnRfY29tbWVudHMiO3M6MToiNSI7czoyMjoid2hvc3dob19ob21lcGFnZV9wb3N0cyI7czoxOiI3IjtzOjIyOiJ3aG9zd2hvX2V4bGNhdHNfcmVjZW50IjtOO3M6Mjg6Indob3N3aG9fcG9zdGluZm9faG9tZWRlZmF1bHQiO2E6Mjp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjt9czoxNjoid2hvc3dob19mZWF0dXJlZCI7czoyOiJvbiI7czoxNzoid2hvc3dob19kdXBsaWNhdGUiO3M6Mjoib24iO3M6MTY6Indob3N3aG9fZmVhdF9jYXQiO3M6ODoiRmVhdHVyZWQiO3M6MTc6Indob3N3aG9fbWVudXBhZ2VzIjtOO3M6MjQ6Indob3N3aG9fZW5hYmxlX2Ryb3Bkb3ducyI7czoyOiJvbiI7czoxNzoid2hvc3dob19ob21lX2xpbmsiO3M6Mjoib24iO3M6MTg6Indob3N3aG9fc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoxODoid2hvc3dob19vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoyNToid2hvc3dob190aWVyc19zaG93bl9wYWdlcyI7czoxOiIzIjtzOjE2OiJ3aG9zd2hvX21lbnVjYXRzIjtOO3M6MzU6Indob3N3aG9fZW5hYmxlX2Ryb3Bkb3duc19jYXRlZ29yaWVzIjtzOjI6Im9uIjtzOjI0OiJ3aG9zd2hvX2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6MzA6Indob3N3aG9fdGllcnNfc2hvd25fY2F0ZWdvcmllcyI7czoxOiIzIjtzOjE2OiJ3aG9zd2hvX3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTc6Indob3N3aG9fb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxOToid2hvc3dob19zd2FwX25hdmJhciI7TjtzOjIzOiJ3aG9zd2hvX2Rpc2FibGVfdG9wdGllciI7TjtzOjE3OiJ3aG9zd2hvX3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MTg6Indob3N3aG9fdGh1bWJuYWlscyI7czoyOiJvbiI7czoyNToid2hvc3dob19zaG93X3Bvc3Rjb21tZW50cyI7czoyOiJvbiI7czoyMzoid2hvc3dob19wYWdlX3RodW1ibmFpbHMiO047czoyNjoid2hvc3dob19zaG93X3BhZ2VzY29tbWVudHMiO047czoyOToid2hvc3dob190aHVtYm5haWxfd2lkdGhfcGFnZXMiO3M6MzoiMTg1IjtzOjMwOiJ3aG9zd2hvX3RodW1ibmFpbF9oZWlnaHRfcGFnZXMiO3M6MzoiMTg1IjtzOjE3OiJ3aG9zd2hvX3Bvc3RpbmZvMSI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MTg6Indob3N3aG9fc2hvd19zaGFyZSI7czoyOiJvbiI7czoyMToid2hvc3dob19jdXN0b21fY29sb3JzIjtOO3M6MTc6Indob3N3aG9fY2hpbGRfY3NzIjtOO3M6MjA6Indob3N3aG9fY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoyMjoid2hvc3dob19jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjI6Indob3N3aG9fY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjIyOiJ3aG9zd2hvX2NvbG9yX3BhZ2VsaW5rIjtzOjA6IiI7czoyOToid2hvc3dob19jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjIyOiJ3aG9zd2hvX2NvbG9yX2hlYWRpbmdzIjtzOjA6IiI7czoyNzoid2hvc3dob19jb2xvcl9zaWRlYmFyX2xpbmtzIjtzOjA6IiI7czoyMzoid2hvc3dob19mb290ZXJfaGVhZGluZ3MiO3M6MDoiIjtzOjI1OiJ3aG9zd2hvX2NvbG9yX2Zvb3RlcmxpbmtzIjtzOjA6IiI7czoyMjoid2hvc3dob19zZW9faG9tZV90aXRsZSI7TjtzOjI4OiJ3aG9zd2hvX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjU6Indob3N3aG9fc2VvX2hvbWVfa2V5d29yZHMiO047czoyNjoid2hvc3dob19zZW9faG9tZV9jYW5vbmljYWwiO047czoyNjoid2hvc3dob19zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMyOiJ3aG9zd2hvX3Nlb19ob21lX2Rlc2NyaXB0aW9udGV4dCI7czowOiIiO3M6Mjk6Indob3N3aG9fc2VvX2hvbWVfa2V5d29yZHN0ZXh0IjtzOjA6IiI7czoyMToid2hvc3dob19zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjU6Indob3N3aG9fc2VvX2hvbWVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI0OiJ3aG9zd2hvX3Nlb19zaW5nbGVfdGl0bGUiO047czozMDoid2hvc3dob19zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6Mjc6Indob3N3aG9fc2VvX3NpbmdsZV9rZXl3b3JkcyI7TjtzOjI4OiJ3aG9zd2hvX3Nlb19zaW5nbGVfY2Fub25pY2FsIjtOO3M6MzA6Indob3N3aG9fc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6MzY6Indob3N3aG9fc2VvX3NpbmdsZV9maWVsZF9kZXNjcmlwdGlvbiI7czoxNToic2VvX2Rlc2NyaXB0aW9uIjtzOjMzOiJ3aG9zd2hvX3Nlb19zaW5nbGVfZmllbGRfa2V5d29yZHMiO3M6MTI6InNlb19rZXl3b3JkcyI7czoyMzoid2hvc3dob19zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyNzoid2hvc3dob19zZW9fc2luZ2xlX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNzoid2hvc3dob19zZW9faW5kZXhfY2Fub25pY2FsIjtOO3M6Mjk6Indob3N3aG9fc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjI6Indob3N3aG9fc2VvX2luZGV4X3R5cGUiO3M6MjQ6IkNhdGVnb3J5IG5hbWUgfCBCbG9nTmFtZSI7czoyNjoid2hvc3dob19zZW9faW5kZXhfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjMxOiJ3aG9zd2hvX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjI5OiJ3aG9zd2hvX2ludGVncmF0ZV9ib2R5X2VuYWJsZSI7czoyOiJvbiI7czozNDoid2hvc3dob19pbnRlZ3JhdGVfc2luZ2xldG9wX2VuYWJsZSI7czoyOiJvbiI7czozNzoid2hvc3dob19pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyNDoid2hvc3dob19pbnRlZ3JhdGlvbl9oZWFkIjtzOjA6IiI7czoyNDoid2hvc3dob19pbnRlZ3JhdGlvbl9ib2R5IjtzOjA6IiI7czozMDoid2hvc3dob19pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozMzoid2hvc3dob19pbnRlZ3JhdGlvbl9zaW5nbGVfYm90dG9tIjtzOjA6IiI7czoxODoid2hvc3dob180NjhfZW5hYmxlIjtOO3M6MTc6Indob3N3aG9fNDY4X2ltYWdlIjtzOjA6IiI7czoxNToid2hvc3dob180NjhfdXJsIjtzOjA6IiI7czoxOToid2hvc3dob180NjhfYWRzZW5zZSI7czowOiIiO30=';

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