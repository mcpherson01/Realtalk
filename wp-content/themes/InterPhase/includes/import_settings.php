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

	$importOptions = 'YTo4OTp7czowOiIiO047czoxNToiaW50ZXJwaGFzZV9sb2dvIjtzOjA6IiI7czoxODoiaW50ZXJwaGFzZV9mYXZpY29uIjtzOjA6IiI7czoyMToiaW50ZXJwaGFzZV9ncmFiX2ltYWdlIjtOO3M6MjM6ImludGVycGhhc2VfY2F0bnVtX3Bvc3RzIjtzOjE6IjYiO3M6Mjc6ImludGVycGhhc2VfYXJjaGl2ZW51bV9wb3N0cyI7czoxOiI1IjtzOjI2OiJpbnRlcnBoYXNlX3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjIzOiJpbnRlcnBoYXNlX3RhZ251bV9wb3N0cyI7czoxOiI1IjtzOjIyOiJpbnRlcnBoYXNlX2RhdGVfZm9ybWF0IjtzOjY6Ik0gaiwgWSI7czoyMjoiaW50ZXJwaGFzZV91c2VfZXhjZXJwdCI7TjtzOjI0OiJpbnRlcnBoYXNlX3Nob3dfY2F0Ym94ZXMiO3M6Mjoib24iO3M6MzA6ImludGVycGhhc2Vfc2hvd19yZWNlbnRjb21tZW50cyI7czoyOiJvbiI7czoyMzoiaW50ZXJwaGFzZV9zaG93X3BvcHVsYXIiO3M6Mjoib24iO3M6Mjc6ImludGVycGhhc2Vfc2hvd19yYW5kb21wb3N0cyI7czoyOiJvbiI7czoyMjoiaW50ZXJwaGFzZV9zaG93X2ZsaWNrciI7czoyOiJvbiI7czoxNzoiaW50ZXJwaGFzZV9mbGlja3IiO3M6MTQ6IjI5NjIyMzU3JTQwTjA3IjtzOjIzOiJpbnRlcnBoYXNlX2hvbWVfY2F0X29uZSI7czo0OiJCbG9nIjtzOjIzOiJpbnRlcnBoYXNlX2hvbWVfY2F0X3R3byI7czo4OiJGZWF0dXJlZCI7czoyNToiaW50ZXJwaGFzZV9ob21lX2NhdF90aHJlZSI7czo5OiJQb3J0Zm9saW8iO3M6MjQ6ImludGVycGhhc2VfaG9tZV9jYXRfZm91ciI7czo0OiJCbG9nIjtzOjIxOiJpbnRlcnBoYXNlX3JhbmRvbV9udW0iO3M6MjoiMTAiO3M6MjI6ImludGVycGhhc2VfcG9wdWxhcl9udW0iO3M6MToiNiI7czoyNjoiaW50ZXJwaGFzZV9yZWNlbnRfY29tbWVudHMiO3M6MToiNSI7czoyNToiaW50ZXJwaGFzZV9ob21lcGFnZV9wb3N0cyI7czoxOiI3IjtzOjI1OiJpbnRlcnBoYXNlX2V4bGNhdHNfcmVjZW50IjtOO3M6MzE6ImludGVycGhhc2VfcG9zdGluZm9faG9tZWRlZmF1bHQiO2E6Mjp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjt9czoyMDoiaW50ZXJwaGFzZV9tZW51cGFnZXMiO047czoyMDoiaW50ZXJwaGFzZV9ob21lX2xpbmsiO3M6Mjoib24iO3M6MjE6ImludGVycGhhc2Vfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoyMToiaW50ZXJwaGFzZV9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoxOToiaW50ZXJwaGFzZV9tZW51Y2F0cyI7TjtzOjI3OiJpbnRlcnBoYXNlX2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6MTk6ImludGVycGhhc2Vfc29ydF9jYXQiO3M6NDoibmFtZSI7czoyMDoiaW50ZXJwaGFzZV9vcmRlcl9jYXQiO3M6MzoiYXNjIjtzOjIyOiJpbnRlcnBoYXNlX3N3YXBfbmF2YmFyIjtOO3M6MjA6ImludGVycGhhc2VfcG9zdGluZm8yIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyMToiaW50ZXJwaGFzZV90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjI4OiJpbnRlcnBoYXNlX3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjI2OiJpbnRlcnBoYXNlX3BhZ2VfdGh1bWJuYWlscyI7TjtzOjI5OiJpbnRlcnBoYXNlX3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjMyOiJpbnRlcnBoYXNlX3RodW1ibmFpbF93aWR0aF9wYWdlcyI7czozOiIxODUiO3M6MzM6ImludGVycGhhc2VfdGh1bWJuYWlsX2hlaWdodF9wYWdlcyI7czozOiIxODUiO3M6MjA6ImludGVycGhhc2VfcG9zdGluZm8xIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyMToiaW50ZXJwaGFzZV9zaG93X3NoYXJlIjtzOjI6Im9uIjtzOjI0OiJpbnRlcnBoYXNlX2N1c3RvbV9jb2xvcnMiO047czoyMDoiaW50ZXJwaGFzZV9jaGlsZF9jc3MiO047czoyMzoiaW50ZXJwaGFzZV9jaGlsZF9jc3N1cmwiO3M6MDoiIjtzOjI1OiJpbnRlcnBoYXNlX2NvbG9yX21haW5mb250IjtzOjA6IiI7czoyNToiaW50ZXJwaGFzZV9jb2xvcl9tYWlubGluayI7czowOiIiO3M6MjU6ImludGVycGhhc2VfY29sb3JfcGFnZWxpbmsiO3M6MDoiIjtzOjMyOiJpbnRlcnBoYXNlX2NvbG9yX3BhZ2VsaW5rX2FjdGl2ZSI7czowOiIiO3M6MjU6ImludGVycGhhc2VfY29sb3JfaGVhZGluZ3MiO3M6MDoiIjtzOjMwOiJpbnRlcnBoYXNlX2NvbG9yX3NpZGViYXJfbGlua3MiO3M6MDoiIjtzOjI2OiJpbnRlcnBoYXNlX2Zvb3Rlcl9oZWFkaW5ncyI7czowOiIiO3M6Mjg6ImludGVycGhhc2VfY29sb3JfZm9vdGVybGlua3MiO3M6MDoiIjtzOjI1OiJpbnRlcnBoYXNlX3Nlb19ob21lX3RpdGxlIjtOO3M6MzE6ImludGVycGhhc2Vfc2VvX2hvbWVfZGVzY3JpcHRpb24iO047czoyODoiaW50ZXJwaGFzZV9zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjI5OiJpbnRlcnBoYXNlX3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjI5OiJpbnRlcnBoYXNlX3Nlb19ob21lX3RpdGxldGV4dCI7czowOiIiO3M6MzU6ImludGVycGhhc2Vfc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czozMjoiaW50ZXJwaGFzZV9zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjI0OiJpbnRlcnBoYXNlX3Nlb19ob21lX3R5cGUiO3M6Mjc6IkJsb2dOYW1lIHwgQmxvZyBkZXNjcmlwdGlvbiI7czoyODoiaW50ZXJwaGFzZV9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjc6ImludGVycGhhc2Vfc2VvX3NpbmdsZV90aXRsZSI7TjtzOjMzOiJpbnRlcnBoYXNlX3Nlb19zaW5nbGVfZGVzY3JpcHRpb24iO047czozMDoiaW50ZXJwaGFzZV9zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6MzE6ImludGVycGhhc2Vfc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czozMzoiaW50ZXJwaGFzZV9zZW9fc2luZ2xlX2ZpZWxkX3RpdGxlIjtzOjk6InNlb190aXRsZSI7czozOToiaW50ZXJwaGFzZV9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MzY6ImludGVycGhhc2Vfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjI2OiJpbnRlcnBoYXNlX3Nlb19zaW5nbGVfdHlwZSI7czoyMToiUG9zdCB0aXRsZSB8IEJsb2dOYW1lIjtzOjMwOiJpbnRlcnBoYXNlX3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjMwOiJpbnRlcnBoYXNlX3Nlb19pbmRleF9jYW5vbmljYWwiO047czozMjoiaW50ZXJwaGFzZV9zZW9faW5kZXhfZGVzY3JpcHRpb24iO047czoyNToiaW50ZXJwaGFzZV9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjI5OiJpbnRlcnBoYXNlX3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzQ6ImludGVycGhhc2VfaW50ZWdyYXRlX2hlYWRlcl9lbmFibGUiO3M6Mjoib24iO3M6MzI6ImludGVycGhhc2VfaW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjM3OiJpbnRlcnBoYXNlX2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjQwOiJpbnRlcnBoYXNlX2ludGVncmF0ZV9zaW5nbGVib3R0b21fZW5hYmxlIjtzOjI6Im9uIjtzOjI3OiJpbnRlcnBoYXNlX2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjI3OiJpbnRlcnBoYXNlX2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjMzOiJpbnRlcnBoYXNlX2ludGVncmF0aW9uX3NpbmdsZV90b3AiO3M6MDoiIjtzOjM2OiJpbnRlcnBoYXNlX2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjIxOiJpbnRlcnBoYXNlXzQ2OF9lbmFibGUiO047czoyMDoiaW50ZXJwaGFzZV80NjhfaW1hZ2UiO3M6MDoiIjtzOjE4OiJpbnRlcnBoYXNlXzQ2OF91cmwiO3M6MDoiIjtzOjIyOiJpbnRlcnBoYXNlXzQ2OF9hZHNlbnNlIjtzOjA6IiI7fQ==';

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