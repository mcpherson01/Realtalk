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

	$importOptions = 'YTo3ODp7czowOiIiO047czoxNjoibGlnaHRicmlnaHRfbG9nbyI7czowOiIiO3M6MTk6ImxpZ2h0YnJpZ2h0X2Zhdmljb24iO3M6MDoiIjtzOjI0OiJsaWdodGJyaWdodF9jb2xvcl9zY2hlbWUiO3M6NzoiRGVmYXVsdCI7czoyMjoibGlnaHRicmlnaHRfYmxvZ19zdHlsZSI7TjtzOjIyOiJsaWdodGJyaWdodF9ncmFiX2ltYWdlIjtOO3M6MzE6ImxpZ2h0YnJpZ2h0X2FyY2hpdmVfY3VzdG9tcG9zdHMiO3M6MToiNSI7czoyODoibGlnaHRicmlnaHRfYXJjaGl2ZW51bV9wb3N0cyI7czoxOiI1IjtzOjI0OiJsaWdodGJyaWdodF9jYXRudW1fcG9zdHMiO3M6MToiNiI7czoyNzoibGlnaHRicmlnaHRfc2VhcmNobnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjQ6ImxpZ2h0YnJpZ2h0X3RhZ251bV9wb3N0cyI7czoxOiI1IjtzOjIzOiJsaWdodGJyaWdodF9kYXRlX2Zvcm1hdCI7czo2OiJNIGosIFkiO3M6MjM6ImxpZ2h0YnJpZ2h0X3VzZV9leGNlcnB0IjtOO3M6MTc6ImxpZ2h0YnJpZ2h0X2N1Zm9uIjtzOjI6Im9uIjtzOjI2OiJsaWdodGJyaWdodF9ob21lcGFnZV9wb3N0cyI7czoxOiI4IjtzOjIxOiJsaWdodGJyaWdodF9tZW51cGFnZXMiO047czoyODoibGlnaHRicmlnaHRfZW5hYmxlX2Ryb3Bkb3ducyI7czoyOiJvbiI7czoyMToibGlnaHRicmlnaHRfaG9tZV9saW5rIjtzOjI6Im9uIjtzOjIyOiJsaWdodGJyaWdodF9zb3J0X3BhZ2VzIjtzOjEwOiJwb3N0X3RpdGxlIjtzOjIyOiJsaWdodGJyaWdodF9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoyOToibGlnaHRicmlnaHRfdGllcnNfc2hvd25fcGFnZXMiO3M6MToiMyI7czoyMDoibGlnaHRicmlnaHRfbWVudWNhdHMiO047czozOToibGlnaHRicmlnaHRfZW5hYmxlX2Ryb3Bkb3duc19jYXRlZ29yaWVzIjtzOjI6Im9uIjtzOjI4OiJsaWdodGJyaWdodF9jYXRlZ29yaWVzX2VtcHR5IjtzOjI6Im9uIjtzOjM0OiJsaWdodGJyaWdodF90aWVyc19zaG93bl9jYXRlZ29yaWVzIjtzOjE6IjMiO3M6MjA6ImxpZ2h0YnJpZ2h0X3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MjE6ImxpZ2h0YnJpZ2h0X29yZGVyX2NhdCI7czozOiJhc2MiO3M6Mjc6ImxpZ2h0YnJpZ2h0X2Rpc2FibGVfdG9wdGllciI7TjtzOjIyOiJsaWdodGJyaWdodF90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjI5OiJsaWdodGJyaWdodF9zaG93X3Bvc3Rjb21tZW50cyI7czoyOiJvbiI7czoyNzoibGlnaHRicmlnaHRfcGFnZV90aHVtYm5haWxzIjtOO3M6MzA6ImxpZ2h0YnJpZ2h0X3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjI4OiJsaWdodGJyaWdodF90aHVtYm5haWxzX2luZGV4IjtzOjI6Im9uIjtzOjI1OiJsaWdodGJyaWdodF9jdXN0b21fY29sb3JzIjtOO3M6MjE6ImxpZ2h0YnJpZ2h0X2NoaWxkX2NzcyI7TjtzOjI0OiJsaWdodGJyaWdodF9jaGlsZF9jc3N1cmwiO3M6MDoiIjtzOjI2OiJsaWdodGJyaWdodF9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjY6ImxpZ2h0YnJpZ2h0X2NvbG9yX21haW5saW5rIjtzOjA6IiI7czoyNjoibGlnaHRicmlnaHRfY29sb3JfcGFnZWxpbmsiO3M6MDoiIjtzOjMzOiJsaWdodGJyaWdodF9jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjI2OiJsaWdodGJyaWdodF9jb2xvcl9oZWFkaW5ncyI7czowOiIiO3M6MzE6ImxpZ2h0YnJpZ2h0X2NvbG9yX3NpZGViYXJfbGlua3MiO3M6MDoiIjtzOjIzOiJsaWdodGJyaWdodF9mb290ZXJfdGV4dCI7czowOiIiO3M6Mjk6ImxpZ2h0YnJpZ2h0X2NvbG9yX2Zvb3RlcmxpbmtzIjtzOjA6IiI7czoyNjoibGlnaHRicmlnaHRfc2VvX2hvbWVfdGl0bGUiO047czozMjoibGlnaHRicmlnaHRfc2VvX2hvbWVfZGVzY3JpcHRpb24iO047czoyOToibGlnaHRicmlnaHRfc2VvX2hvbWVfa2V5d29yZHMiO047czozMDoibGlnaHRicmlnaHRfc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6MzA6ImxpZ2h0YnJpZ2h0X3Nlb19ob21lX3RpdGxldGV4dCI7czowOiIiO3M6MzY6ImxpZ2h0YnJpZ2h0X3Nlb19ob21lX2Rlc2NyaXB0aW9udGV4dCI7czowOiIiO3M6MzM6ImxpZ2h0YnJpZ2h0X3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjU6ImxpZ2h0YnJpZ2h0X3Nlb19ob21lX3R5cGUiO3M6Mjc6IkJsb2dOYW1lIHwgQmxvZyBkZXNjcmlwdGlvbiI7czoyOToibGlnaHRicmlnaHRfc2VvX2hvbWVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI4OiJsaWdodGJyaWdodF9zZW9fc2luZ2xlX3RpdGxlIjtOO3M6MzQ6ImxpZ2h0YnJpZ2h0X3Nlb19zaW5nbGVfZGVzY3JpcHRpb24iO047czozMToibGlnaHRicmlnaHRfc2VvX3NpbmdsZV9rZXl3b3JkcyI7TjtzOjMyOiJsaWdodGJyaWdodF9zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjM0OiJsaWdodGJyaWdodF9zZW9fc2luZ2xlX2ZpZWxkX3RpdGxlIjtzOjk6InNlb190aXRsZSI7czo0MDoibGlnaHRicmlnaHRfc2VvX3NpbmdsZV9maWVsZF9kZXNjcmlwdGlvbiI7czoxNToic2VvX2Rlc2NyaXB0aW9uIjtzOjM3OiJsaWdodGJyaWdodF9zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6Mjc6ImxpZ2h0YnJpZ2h0X3Nlb19zaW5nbGVfdHlwZSI7czoyMToiUG9zdCB0aXRsZSB8IEJsb2dOYW1lIjtzOjMxOiJsaWdodGJyaWdodF9zZW9fc2luZ2xlX3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMToibGlnaHRicmlnaHRfc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjMzOiJsaWdodGJyaWdodF9zZW9faW5kZXhfZGVzY3JpcHRpb24iO047czoyNjoibGlnaHRicmlnaHRfc2VvX2luZGV4X3R5cGUiO3M6MjQ6IkNhdGVnb3J5IG5hbWUgfCBCbG9nTmFtZSI7czozMDoibGlnaHRicmlnaHRfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozNToibGlnaHRicmlnaHRfaW50ZWdyYXRlX2hlYWRlcl9lbmFibGUiO3M6Mjoib24iO3M6MzM6ImxpZ2h0YnJpZ2h0X2ludGVncmF0ZV9ib2R5X2VuYWJsZSI7czoyOiJvbiI7czozODoibGlnaHRicmlnaHRfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6NDE6ImxpZ2h0YnJpZ2h0X2ludGVncmF0ZV9zaW5nbGVib3R0b21fZW5hYmxlIjtzOjI6Im9uIjtzOjI4OiJsaWdodGJyaWdodF9pbnRlZ3JhdGlvbl9oZWFkIjtzOjA6IiI7czoyODoibGlnaHRicmlnaHRfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6MzQ6ImxpZ2h0YnJpZ2h0X2ludGVncmF0aW9uX3NpbmdsZV90b3AiO3M6MDoiIjtzOjM3OiJsaWdodGJyaWdodF9pbnRlZ3JhdGlvbl9zaW5nbGVfYm90dG9tIjtzOjA6IiI7czoyMjoibGlnaHRicmlnaHRfNDY4X2VuYWJsZSI7TjtzOjIxOiJsaWdodGJyaWdodF80NjhfaW1hZ2UiO3M6MDoiIjtzOjE5OiJsaWdodGJyaWdodF80NjhfdXJsIjtzOjA6IiI7czoyMzoibGlnaHRicmlnaHRfNDY4X2Fkc2Vuc2UiO3M6MDoiIjt9';

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