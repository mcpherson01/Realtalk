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
				$main_siteurl = get_option('siteurl');
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

	$importOptions = 'YTo4Njp7czowOiIiO047czoxMjoiYmx1ZXNreV9sb2dvIjtzOjA6IiI7czoxNToiYmx1ZXNreV9mYXZpY29uIjtzOjA6IiI7czoyMDoiYmx1ZXNreV9jb2xvcl9zY2hlbWUiO3M6NDoiQmx1ZSI7czoxODoiYmx1ZXNreV9ibG9nX3N0eWxlIjtOO3M6MTg6ImJsdWVza3lfZ3JhYl9pbWFnZSI7TjtzOjIwOiJibHVlc2t5X2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjI0OiJibHVlc2t5X2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyMzoiYmx1ZXNreV9zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoyMDoiYmx1ZXNreV90YWdudW1fcG9zdHMiO3M6MToiNSI7czoxOToiYmx1ZXNreV9kYXRlX2Zvcm1hdCI7czo2OiJNIGosIFkiO3M6MTI6ImJsdWVza3lfdGFicyI7czoyOiJvbiI7czozNDoiYmx1ZXNreV9zaG93X3RhYmFyZWFfcmVjZW50ZW50cmllcyI7czoyOiJvbiI7czoyODoiYmx1ZXNreV9zaG93X3RhYmFyZWFfcG9wdWxhciI7czoyOiJvbiI7czozNToiYmx1ZXNreV9zaG93X3RhYmFyZWFfcmVjZW50Y29tbWVudHMiO3M6Mjoib24iO3M6MjM6ImJsdWVza3lfYWRkaXRpb25hbF9kYXRlIjtzOjI6Im9uIjtzOjIzOiJibHVlc2t5X3JlY2VudHBvc3RzX251bSI7czoxOiI1IjtzOjI1OiJibHVlc2t5X3BvcHVsYXJfcG9zdHNfbnVtIjtzOjE6IjUiO3M6MjY6ImJsdWVza3lfcmVjZW50Y29tbWVudHNfbnVtIjtzOjE6IjUiO3M6MTk6ImJsdWVza3lfdXNlX2V4Y2VycHQiO047czoyMjoiYmx1ZXNreV9ob21lcGFnZV9wb3N0cyI7czoxOiI4IjtzOjIyOiJibHVlc2t5X2V4bGNhdHNfcmVjZW50IjtOO3M6MTc6ImJsdWVza3lfbWVudXBhZ2VzIjtOO3M6MTc6ImJsdWVza3lfaG9tZV9saW5rIjtzOjI6Im9uIjtzOjE4OiJibHVlc2t5X3NvcnRfcGFnZXMiO3M6MTA6InBvc3RfdGl0bGUiO3M6MTg6ImJsdWVza3lfb3JkZXJfcGFnZSI7czozOiJhc2MiO3M6MTY6ImJsdWVza3lfbWVudWNhdHMiO047czoyNDoiYmx1ZXNreV9jYXRlZ29yaWVzX2VtcHR5IjtzOjI6Im9uIjtzOjE2OiJibHVlc2t5X3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTc6ImJsdWVza3lfb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxOToiYmx1ZXNreV9zd2FwX25hdmJhciI7TjtzOjE3OiJibHVlc2t5X3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MTg6ImJsdWVza3lfdGh1bWJuYWlscyI7czoyOiJvbiI7czoyNToiYmx1ZXNreV9zaG93X3Bvc3Rjb21tZW50cyI7czoyOiJvbiI7czoyOToiYmx1ZXNreV90aHVtYm5haWxfd2lkdGhfcG9zdHMiO3M6MzoiMTAwIjtzOjMwOiJibHVlc2t5X3RodW1ibmFpbF9oZWlnaHRfcG9zdHMiO3M6MzoiMTAwIjtzOjIzOiJibHVlc2t5X3BhZ2VfdGh1bWJuYWlscyI7TjtzOjI2OiJibHVlc2t5X3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjI5OiJibHVlc2t5X3RodW1ibmFpbF93aWR0aF9wYWdlcyI7czozOiIxMDAiO3M6MzA6ImJsdWVza3lfdGh1bWJuYWlsX2hlaWdodF9wYWdlcyI7czozOiIxMDAiO3M6MTc6ImJsdWVza3lfcG9zdGluZm8xIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyNDoiYmx1ZXNreV90aHVtYm5haWxzX2luZGV4IjtzOjI6Im9uIjtzOjIxOiJibHVlc2t5X2N1c3RvbV9jb2xvcnMiO047czoxNzoiYmx1ZXNreV9jaGlsZF9jc3MiO047czoyMDoiYmx1ZXNreV9jaGlsZF9jc3N1cmwiO3M6MDoiIjtzOjIyOiJibHVlc2t5X2NvbG9yX21haW5mb250IjtzOjA6IiI7czoyMjoiYmx1ZXNreV9jb2xvcl9tYWlubGluayI7czowOiIiO3M6MjI6ImJsdWVza3lfY29sb3JfcGFnZWxpbmsiO3M6MDoiIjtzOjI5OiJibHVlc2t5X2NvbG9yX3BhZ2VsaW5rX2FjdGl2ZSI7czowOiIiO3M6MjI6ImJsdWVza3lfY29sb3JfaGVhZGluZ3MiO3M6MDoiIjtzOjI3OiJibHVlc2t5X2NvbG9yX3NpZGViYXJfbGlua3MiO3M6MDoiIjtzOjE5OiJibHVlc2t5X2Zvb3Rlcl90ZXh0IjtzOjA6IiI7czoyNToiYmx1ZXNreV9jb2xvcl9mb290ZXJsaW5rcyI7czowOiIiO3M6MjI6ImJsdWVza3lfc2VvX2hvbWVfdGl0bGUiO047czoyODoiYmx1ZXNreV9zZW9faG9tZV9kZXNjcmlwdGlvbiI7TjtzOjI1OiJibHVlc2t5X3Nlb19ob21lX2tleXdvcmRzIjtOO3M6MjY6ImJsdWVza3lfc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6MjY6ImJsdWVza3lfc2VvX2hvbWVfdGl0bGV0ZXh0IjtzOjA6IiI7czozMjoiYmx1ZXNreV9zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjI5OiJibHVlc2t5X3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjE6ImJsdWVza3lfc2VvX2hvbWVfdHlwZSI7czoyNzoiQmxvZ05hbWUgfCBCbG9nIGRlc2NyaXB0aW9uIjtzOjI1OiJibHVlc2t5X3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNDoiYmx1ZXNreV9zZW9fc2luZ2xlX3RpdGxlIjtOO3M6MzA6ImJsdWVza3lfc2VvX3NpbmdsZV9kZXNjcmlwdGlvbiI7TjtzOjI3OiJibHVlc2t5X3Nlb19zaW5nbGVfa2V5d29yZHMiO047czoyODoiYmx1ZXNreV9zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjMwOiJibHVlc2t5X3Nlb19zaW5nbGVfZmllbGRfdGl0bGUiO3M6OToic2VvX3RpdGxlIjtzOjM2OiJibHVlc2t5X3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozMzoiYmx1ZXNreV9zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6MjM6ImJsdWVza3lfc2VvX3NpbmdsZV90eXBlIjtzOjIxOiJQb3N0IHRpdGxlIHwgQmxvZ05hbWUiO3M6Mjc6ImJsdWVza3lfc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjc6ImJsdWVza3lfc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjI5OiJibHVlc2t5X3Nlb19pbmRleF9kZXNjcmlwdGlvbiI7TjtzOjIyOiJibHVlc2t5X3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6MjY6ImJsdWVza3lfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMToiYmx1ZXNreV9pbnRlZ3JhdGVfaGVhZGVyX2VuYWJsZSI7czoyOiJvbiI7czoyOToiYmx1ZXNreV9pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6MzQ6ImJsdWVza3lfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6Mzc6ImJsdWVza3lfaW50ZWdyYXRlX3NpbmdsZWJvdHRvbV9lbmFibGUiO3M6Mjoib24iO3M6MjQ6ImJsdWVza3lfaW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MjQ6ImJsdWVza3lfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6MzA6ImJsdWVza3lfaW50ZWdyYXRpb25fc2luZ2xlX3RvcCI7czowOiIiO3M6MzM6ImJsdWVza3lfaW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MTg6ImJsdWVza3lfNDY4X2VuYWJsZSI7TjtzOjE3OiJibHVlc2t5XzQ2OF9pbWFnZSI7czowOiIiO3M6MTU6ImJsdWVza3lfNDY4X3VybCI7czowOiIiO30=';

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