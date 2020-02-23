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

	$importOptions = 'YToxMDI6e3M6MDoiIjtOO3M6OToiYm9sZF9sb2dvIjtzOjA6IiI7czoxMjoiYm9sZF9mYXZpY29uIjtzOjA6IiI7czoxNzoiYm9sZF9jb2xvcl9zY2hlbWUiO3M6OToiTGlnaHQtUmVkIjtzOjE1OiJib2xkX2Jsb2dfc3R5bGUiO047czoxNToiYm9sZF9ncmFiX2ltYWdlIjtOO3M6MTY6ImJvbGRfZGF0ZV9mb3JtYXQiO3M6NjoiTSBqLCBZIjtzOjE3OiJib2xkX2NhdG51bV9wb3N0cyI7czoxOiI1IjtzOjIxOiJib2xkX2FyY2hpdmVudW1fcG9zdHMiO3M6MToiNSI7czoyMDoiYm9sZF9zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoxNzoiYm9sZF90YWdudW1fcG9zdHMiO3M6MToiNSI7czoxNjoiYm9sZF91c2VfZXhjZXJwdCI7TjtzOjE5OiJib2xkX2hvbWVwYWdlX3Bvc3RzIjtzOjE6IjUiO3M6MTE6ImJvbGRfcmFuZG9tIjtzOjE6IjgiO3M6MTg6ImJvbGRfcG9wdWxhcl9jb3VudCI7czoxOiI4IjtzOjE5OiJib2xkX2V4bGNhdHNfcmVjZW50IjtOO3M6MTM6ImJvbGRfZmVhdHVyZWQiO3M6Mjoib24iO3M6MTQ6ImJvbGRfZHVwbGljYXRlIjtOO3M6MTM6ImJvbGRfZmVhdF9jYXQiO3M6ODoiRmVhdHVyZWQiO3M6MjI6ImJvbGRfaG9tZXBhZ2VfZmVhdHVyZWQiO3M6MToiMiI7czoxNDoiYm9sZF9tZW51cGFnZXMiO047czoyMToiYm9sZF9lbmFibGVfZHJvcGRvd25zIjtzOjI6Im9uIjtzOjE0OiJib2xkX2hvbWVfbGluayI7czoyOiJvbiI7czoxNToiYm9sZF9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoxNToiYm9sZF9zb3J0X3BhZ2VzIjtzOjEwOiJwb3N0X3RpdGxlIjtzOjIyOiJib2xkX3RpZXJzX3Nob3duX3BhZ2VzIjtzOjE6IjMiO3M6MTM6ImJvbGRfbWVudWNhdHMiO047czozMjoiYm9sZF9lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6Mjc6ImJvbGRfdGllcnNfc2hvd25fY2F0ZWdvcmllcyI7czoxOiIzIjtzOjEzOiJib2xkX3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTQ6ImJvbGRfb3JkZXJfY2F0IjtzOjM6ImFzYyI7czoxNjoiYm9sZF9zd2FwX25hdmJhciI7TjtzOjIwOiJib2xkX2Rpc2FibGVfdG9wdGllciI7TjtzOjI1OiJib2xkX2ljb25fdHdpdHRlcl9kaXNwbGF5IjtzOjI6Im9uIjtzOjI2OiJib2xkX2ljb25fZmFjZWJvb2tfZGlzcGxheSI7czoyOiJvbiI7czoyNToiYm9sZF9pY29uX215c3BhY2VfZGlzcGxheSI7czoyOiJvbiI7czoyMToiYm9sZF9pY29uX3Jzc19kaXNwbGF5IjtzOjI6Im9uIjtzOjE3OiJib2xkX2ljb25fdHdpdHRlciI7czoxOiIjIjtzOjE4OiJib2xkX2ljb25fZmFjZWJvb2siO3M6MToiIyI7czoxNzoiYm9sZF9pY29uX215c3BhY2UiO3M6MToiIyI7czoxMzoiYm9sZF9pY29uX3JzcyI7czoxOiIjIjtzOjE0OiJib2xkX3Bvc3RpbmZvMSI7YTozOntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjg6ImNvbW1lbnRzIjt9czoxNToiYm9sZF90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjIyOiJib2xkX3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjI2OiJib2xkX3RodW1ibmFpbF93aWR0aF9wb3N0cyI7czozOiIyMDAiO3M6Mjc6ImJvbGRfdGh1bWJuYWlsX2hlaWdodF9wb3N0cyI7czozOiIyMDAiO3M6MjA6ImJvbGRfcGFnZV90aHVtYm5haWxzIjtOO3M6MjM6ImJvbGRfc2hvd19wYWdlc2NvbW1lbnRzIjtOO3M6MjY6ImJvbGRfdGh1bWJuYWlsX3dpZHRoX3BhZ2VzIjtzOjM6IjIwMCI7czoyNzoiYm9sZF90aHVtYm5haWxfaGVpZ2h0X3BhZ2VzIjtzOjM6IjIwMCI7czoyMDoiYm9sZF9wb3B1bGFyX2Rpc3BsYXkiO3M6Mjoib24iO3M6MTk6ImJvbGRfcmFuZG9tX2Rpc3BsYXkiO3M6Mjoib24iO3M6MjA6ImJvbGRfZGlzcGxheV9zaWRlYmFyIjtzOjI6Im9uIjtzOjIwOiJib2xkX2Rpc3BsYXlfY29ubmVjdCI7czoyOiJvbiI7czoxOToiYm9sZF9kaXNwbGF5X3Nsb2dhbiI7czoyOiJvbiI7czoxOToiYm9sZF9kaXNwbGF5X2Zvb3RlciI7czoyOiJvbiI7czoxODoiYm9sZF9jdXN0b21fY29sb3JzIjtOO3M6MTQ6ImJvbGRfY2hpbGRfY3NzIjtOO3M6MTc6ImJvbGRfY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoxOToiYm9sZF9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MTk6ImJvbGRfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjE5OiJib2xkX2NvbG9yX3BhZ2VsaW5rIjtzOjA6IiI7czoyNToiYm9sZF9jb2xvcl9wYWdlbGlua19ob3ZlciI7czowOiIiO3M6MjU6ImJvbGRfY29sb3JfcmVjZW50aGVhZGluZ3MiO3M6MDoiIjtzOjI1OiJib2xkX2NvbG9yX3NpZGViYXJfdGl0bGVzIjtzOjA6IiI7czoyNDoiYm9sZF9jb2xvcl9mb290ZXJfdGl0bGVzIjtzOjA6IiI7czoyNDoiYm9sZF9jb2xvcl9zaWRlYmFyX2xpbmtzIjtzOjA6IiI7czoyMjoiYm9sZF9jb2xvcl9mb290ZXJfbGluayI7czowOiIiO3M6MTc6ImJvbGRfY29sb3Jfc2xvZ2FuIjtzOjA6IiI7czoxOToiYm9sZF9zZW9faG9tZV90aXRsZSI7TjtzOjI1OiJib2xkX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjI6ImJvbGRfc2VvX2hvbWVfa2V5d29yZHMiO047czoyMzoiYm9sZF9zZW9faG9tZV9jYW5vbmljYWwiO047czoyMzoiYm9sZF9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjI5OiJib2xkX3Nlb19ob21lX2Rlc2NyaXB0aW9udGV4dCI7czowOiIiO3M6MjY6ImJvbGRfc2VvX2hvbWVfa2V5d29yZHN0ZXh0IjtzOjA6IiI7czoxODoiYm9sZF9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjI6ImJvbGRfc2VvX2hvbWVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjIxOiJib2xkX3Nlb19zaW5nbGVfdGl0bGUiO047czoyNzoiYm9sZF9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6MjQ6ImJvbGRfc2VvX3NpbmdsZV9rZXl3b3JkcyI7TjtzOjI1OiJib2xkX3Nlb19zaW5nbGVfY2Fub25pY2FsIjtOO3M6Mjc6ImJvbGRfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6MzM6ImJvbGRfc2VvX3NpbmdsZV9maWVsZF9kZXNjcmlwdGlvbiI7czoxNToic2VvX2Rlc2NyaXB0aW9uIjtzOjMwOiJib2xkX3Nlb19zaW5nbGVfZmllbGRfa2V5d29yZHMiO3M6MTI6InNlb19rZXl3b3JkcyI7czoyMDoiYm9sZF9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyNDoiYm9sZF9zZW9fc2luZ2xlX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNDoiYm9sZF9zZW9faW5kZXhfY2Fub25pY2FsIjtOO3M6MjY6ImJvbGRfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MTk6ImJvbGRfc2VvX2luZGV4X3R5cGUiO3M6MjQ6IkNhdGVnb3J5IG5hbWUgfCBCbG9nTmFtZSI7czoyMzoiYm9sZF9zZW9faW5kZXhfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjI4OiJib2xkX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjI2OiJib2xkX2ludGVncmF0ZV9ib2R5X2VuYWJsZSI7czoyOiJvbiI7czozMToiYm9sZF9pbnRlZ3JhdGVfc2luZ2xldG9wX2VuYWJsZSI7czoyOiJvbiI7czozNDoiYm9sZF9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyMToiYm9sZF9pbnRlZ3JhdGlvbl9oZWFkIjtzOjA6IiI7czoyMToiYm9sZF9pbnRlZ3JhdGlvbl9ib2R5IjtzOjA6IiI7czoyNzoiYm9sZF9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozMDoiYm9sZF9pbnRlZ3JhdGlvbl9zaW5nbGVfYm90dG9tIjtzOjA6IiI7czoxNToiYm9sZF80NjhfZW5hYmxlIjtOO3M6MTQ6ImJvbGRfNDY4X2ltYWdlIjtzOjA6IiI7czoxMjoiYm9sZF80NjhfdXJsIjtzOjA6IiI7fQ==';

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