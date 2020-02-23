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

	$importOptions = 'YTo4ODp7czowOiIiO047czoxMzoiYmx1ZW1pc3RfbG9nbyI7czowOiIiO3M6MTY6ImJsdWVtaXN0X2Zhdmljb24iO3M6MDoiIjtzOjE5OiJibHVlbWlzdF9ncmFiX2ltYWdlIjtOO3M6MjE6ImJsdWVtaXN0X2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjI1OiJibHVlbWlzdF9hcmNoaXZlbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjQ6ImJsdWVtaXN0X3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjIxOiJibHVlbWlzdF90YWdudW1fcG9zdHMiO3M6MToiNSI7czoyMDoiYmx1ZW1pc3RfZGF0ZV9mb3JtYXQiO3M6NjoiTSBqLCBZIjtzOjEzOiJibHVlbWlzdF90YWJzIjtzOjI6Im9uIjtzOjM1OiJibHVlbWlzdF9zaG93X3RhYmFyZWFfcmVjZW50ZW50cmllcyI7czoyOiJvbiI7czoyOToiYmx1ZW1pc3Rfc2hvd190YWJhcmVhX3BvcHVsYXIiO3M6Mjoib24iO3M6MzY6ImJsdWVtaXN0X3Nob3dfdGFiYXJlYV9yZWNlbnRjb21tZW50cyI7czoyOiJvbiI7czoyNDoiYmx1ZW1pc3RfcmVjZW50cG9zdHNfbnVtIjtzOjE6IjUiO3M6MjY6ImJsdWVtaXN0X3BvcHVsYXJfcG9zdHNfbnVtIjtzOjE6IjUiO3M6Mjc6ImJsdWVtaXN0X3JlY2VudGNvbW1lbnRzX251bSI7czoxOiI1IjtzOjIxOiJibHVlbWlzdF9zaG93X2Fkc2Vuc2UiO3M6Mjoib24iO3M6MTY6ImJsdWVtaXN0X2Fkc2Vuc2UiO3M6MDoiIjtzOjE5OiJibHVlbWlzdF9hYm91dF90ZXh0IjtzOjM2NjoiVXQgc2FnaXR0aXMgdWx0cmljZXMgdXJuYS4gU3VzcGVuZGlzc2UgZWdldCBlcmF0IG5vbiBwdXJ1cyB2YXJpdXMgc29kYWxlcy4gQWxpcXVhbSBpbXBlcmRpZXQgbG9ib3J0aXMgbGliZXJvLiBTdXNwZW5kaXNzZSBzY2VsZXJpc3F1ZSBzYWdpdHRpcyBvZGlvLiBQaGFzZWxsdXMgaW1wZXJkaWV0IGludGVyZHVtIGRvbG9yLiBNYXVyaXMgYW50ZSBhbnRlLCBncmF2aWRhIGF0LCBjb25zZWN0ZXR1ZXIgcXVpcywgdWxsYW1jb3JwZXIgb3JuYXJlLCBtYWduYS4gRHVpcyBzZWQgbWF1cmlzIHNlZCBsaWJlcm8gdGluY2lkdW50IHJ1dHJ1bS4gSW4gdnVscHV0YXRlIHByZXRpdW0gZG9sb3IuIE51bGxhIHVsdHJpY2llcyBmZWxpcyB2ZWwgZXJhdC4gIjtzOjIwOiJibHVlbWlzdF91c2VfZXhjZXJwdCI7TjtzOjIzOiJibHVlbWlzdF9ob21lcGFnZV9wb3N0cyI7czoxOiI4IjtzOjIzOiJibHVlbWlzdF9leGxjYXRzX3JlY2VudCI7TjtzOjE3OiJibHVlbWlzdF9mZWF0dXJlZCI7czoyOiJvbiI7czoxODoiYmx1ZW1pc3RfZHVwbGljYXRlIjtzOjI6Im9uIjtzOjE3OiJibHVlbWlzdF9mZWF0X2NhdCI7czo4OiJGZWF0dXJlZCI7czoxODoiYmx1ZW1pc3RfbWVudXBhZ2VzIjtOO3M6MTg6ImJsdWVtaXN0X2hvbWVfbGluayI7czoyOiJvbiI7czoxOToiYmx1ZW1pc3Rfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoxOToiYmx1ZW1pc3Rfb3JkZXJfcGFnZSI7czozOiJhc2MiO3M6MTc6ImJsdWVtaXN0X21lbnVjYXRzIjtOO3M6MjU6ImJsdWVtaXN0X2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6MTc6ImJsdWVtaXN0X3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTg6ImJsdWVtaXN0X29yZGVyX2NhdCI7czozOiJhc2MiO3M6MjA6ImJsdWVtaXN0X3N3YXBfbmF2YmFyIjtzOjI6Im9uIjtzOjE4OiJibHVlbWlzdF9wb3N0aW5mbzIiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjE5OiJibHVlbWlzdF90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjI2OiJibHVlbWlzdF9zaG93X3Bvc3Rjb21tZW50cyI7czoyOiJvbiI7czozMDoiYmx1ZW1pc3RfdGh1bWJuYWlsX3dpZHRoX3Bvc3RzIjtzOjM6IjEwMCI7czozMToiYmx1ZW1pc3RfdGh1bWJuYWlsX2hlaWdodF9wb3N0cyI7czozOiIxMDAiO3M6MjQ6ImJsdWVtaXN0X3BhZ2VfdGh1bWJuYWlscyI7TjtzOjI3OiJibHVlbWlzdF9zaG93X3BhZ2VzY29tbWVudHMiO047czozMDoiYmx1ZW1pc3RfdGh1bWJuYWlsX3dpZHRoX3BhZ2VzIjtzOjM6IjEwMCI7czozMToiYmx1ZW1pc3RfdGh1bWJuYWlsX2hlaWdodF9wYWdlcyI7czozOiIxMDAiO3M6MjU6ImJsdWVtaXN0X3RodW1ibmFpbHNfaW5kZXgiO3M6Mjoib24iO3M6MjI6ImJsdWVtaXN0X2N1c3RvbV9jb2xvcnMiO047czoxODoiYmx1ZW1pc3RfY2hpbGRfY3NzIjtOO3M6MjE6ImJsdWVtaXN0X2NoaWxkX2Nzc3VybCI7czowOiIiO3M6MjM6ImJsdWVtaXN0X2NvbG9yX21haW5mb250IjtzOjA6IiI7czoyMzoiYmx1ZW1pc3RfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjIzOiJibHVlbWlzdF9jb2xvcl9wYWdlbGluayI7czowOiIiO3M6MzA6ImJsdWVtaXN0X2NvbG9yX3BhZ2VsaW5rX2FjdGl2ZSI7czowOiIiO3M6MjM6ImJsdWVtaXN0X2NvbG9yX2hlYWRpbmdzIjtzOjA6IiI7czoyODoiYmx1ZW1pc3RfY29sb3Jfc2lkZWJhcl9saW5rcyI7czowOiIiO3M6MjA6ImJsdWVtaXN0X2Zvb3Rlcl90ZXh0IjtzOjA6IiI7czoyNjoiYmx1ZW1pc3RfY29sb3JfZm9vdGVybGlua3MiO3M6MDoiIjtzOjIzOiJibHVlbWlzdF9zZW9faG9tZV90aXRsZSI7TjtzOjI5OiJibHVlbWlzdF9zZW9faG9tZV9kZXNjcmlwdGlvbiI7TjtzOjI2OiJibHVlbWlzdF9zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjI3OiJibHVlbWlzdF9zZW9faG9tZV9jYW5vbmljYWwiO047czoyNzoiYmx1ZW1pc3Rfc2VvX2hvbWVfdGl0bGV0ZXh0IjtzOjA6IiI7czozMzoiYmx1ZW1pc3Rfc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czozMDoiYmx1ZW1pc3Rfc2VvX2hvbWVfa2V5d29yZHN0ZXh0IjtzOjA6IiI7czoyMjoiYmx1ZW1pc3Rfc2VvX2hvbWVfdHlwZSI7czoyNzoiQmxvZ05hbWUgfCBCbG9nIGRlc2NyaXB0aW9uIjtzOjI2OiJibHVlbWlzdF9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjU6ImJsdWVtaXN0X3Nlb19zaW5nbGVfdGl0bGUiO047czozMToiYmx1ZW1pc3Rfc2VvX3NpbmdsZV9kZXNjcmlwdGlvbiI7TjtzOjI4OiJibHVlbWlzdF9zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6Mjk6ImJsdWVtaXN0X3Nlb19zaW5nbGVfY2Fub25pY2FsIjtOO3M6MzE6ImJsdWVtaXN0X3Nlb19zaW5nbGVfZmllbGRfdGl0bGUiO3M6OToic2VvX3RpdGxlIjtzOjM3OiJibHVlbWlzdF9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6MzQ6ImJsdWVtaXN0X3Nlb19zaW5nbGVfZmllbGRfa2V5d29yZHMiO3M6MTI6InNlb19rZXl3b3JkcyI7czoyNDoiYmx1ZW1pc3Rfc2VvX3NpbmdsZV90eXBlIjtzOjIxOiJQb3N0IHRpdGxlIHwgQmxvZ05hbWUiO3M6Mjg6ImJsdWVtaXN0X3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI4OiJibHVlbWlzdF9zZW9faW5kZXhfY2Fub25pY2FsIjtOO3M6MzA6ImJsdWVtaXN0X3Nlb19pbmRleF9kZXNjcmlwdGlvbiI7TjtzOjIzOiJibHVlbWlzdF9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjI3OiJibHVlbWlzdF9zZW9faW5kZXhfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjMyOiJibHVlbWlzdF9pbnRlZ3JhdGVfaGVhZGVyX2VuYWJsZSI7czoyOiJvbiI7czozMDoiYmx1ZW1pc3RfaW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjM1OiJibHVlbWlzdF9pbnRlZ3JhdGVfc2luZ2xldG9wX2VuYWJsZSI7czoyOiJvbiI7czozODoiYmx1ZW1pc3RfaW50ZWdyYXRlX3NpbmdsZWJvdHRvbV9lbmFibGUiO3M6Mjoib24iO3M6MjU6ImJsdWVtaXN0X2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjI1OiJibHVlbWlzdF9pbnRlZ3JhdGlvbl9ib2R5IjtzOjA6IiI7czozMToiYmx1ZW1pc3RfaW50ZWdyYXRpb25fc2luZ2xlX3RvcCI7czowOiIiO3M6MzQ6ImJsdWVtaXN0X2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjE5OiJibHVlbWlzdF80NjhfZW5hYmxlIjtOO3M6MTg6ImJsdWVtaXN0XzQ2OF9pbWFnZSI7czowOiIiO3M6MTY6ImJsdWVtaXN0XzQ2OF91cmwiO3M6MDoiIjt9';

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