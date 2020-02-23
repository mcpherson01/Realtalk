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

	$importOptions = 'YTo4MDp7czowOiIiO047czoxODoicGVyc29uYWxwcmVzc19sb2dvIjtzOjA6IiI7czoyMToicGVyc29uYWxwcmVzc19mYXZpY29uIjtzOjA6IiI7czoyNjoicGVyc29uYWxwcmVzc19jb2xvcl9zY2hlbWUiO3M6MzoiUmVkIjtzOjI0OiJwZXJzb25hbHByZXNzX2Jsb2dfc3R5bGUiO047czoyNDoicGVyc29uYWxwcmVzc19ncmFiX2ltYWdlIjtOO3M6MjY6InBlcnNvbmFscHJlc3NfY2F0bnVtX3Bvc3RzIjtzOjE6IjYiO3M6MzA6InBlcnNvbmFscHJlc3NfYXJjaGl2ZW51bV9wb3N0cyI7czoxOiI1IjtzOjI5OiJwZXJzb25hbHByZXNzX3NlYXJjaG51bV9wb3N0cyI7czoxOiI1IjtzOjI2OiJwZXJzb25hbHByZXNzX3RhZ251bV9wb3N0cyI7czoxOiI1IjtzOjI1OiJwZXJzb25hbHByZXNzX3VzZV9leGNlcnB0IjtOO3M6Mjg6InBlcnNvbmFscHJlc3NfaG9tZXBhZ2VfcG9zdHMiO3M6MToiNyI7czoyODoicGVyc29uYWxwcmVzc19leGxjYXRzX3JlY2VudCI7TjtzOjIzOiJwZXJzb25hbHByZXNzX21lbnVwYWdlcyI7TjtzOjMwOiJwZXJzb25hbHByZXNzX2VuYWJsZV9kcm9wZG93bnMiO3M6Mjoib24iO3M6MjM6InBlcnNvbmFscHJlc3NfaG9tZV9saW5rIjtzOjI6Im9uIjtzOjM5OiJwZXJzb25hbHByZXNzX3Nob3dfaG9tZWxpbmtfZGVzY3JpcHRpb24iO3M6Mjoib24iO3M6MzA6InBlcnNvbmFscHJlc3NfaG9tZV9kZXNjcmlwdGlvbiI7czozNzoiQ2xpY2sgaGVyZSB0byByZXR1cm4gdG8gdGhlIGhvbWUgcGFnZSI7czoyNDoicGVyc29uYWxwcmVzc19zb3J0X3BhZ2VzIjtzOjEwOiJwb3N0X3RpdGxlIjtzOjI0OiJwZXJzb25hbHByZXNzX29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjMxOiJwZXJzb25hbHByZXNzX3RpZXJzX3Nob3duX3BhZ2VzIjtzOjE6IjMiO3M6MjI6InBlcnNvbmFscHJlc3NfbWVudWNhdHMiO047czo0MToicGVyc29uYWxwcmVzc19lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6MzA6InBlcnNvbmFscHJlc3NfY2F0ZWdvcmllc19lbXB0eSI7czoyOiJvbiI7czozNjoicGVyc29uYWxwcmVzc190aWVyc19zaG93bl9jYXRlZ29yaWVzIjtzOjE6IjMiO3M6MjI6InBlcnNvbmFscHJlc3Nfc29ydF9jYXQiO3M6NDoibmFtZSI7czoyMzoicGVyc29uYWxwcmVzc19vcmRlcl9jYXQiO3M6MzoiYXNjIjtzOjI1OiJwZXJzb25hbHByZXNzX3N3YXBfbmF2YmFyIjtOO3M6Mjk6InBlcnNvbmFscHJlc3NfZGlzYWJsZV90b3B0aWVyIjtOO3M6MjM6InBlcnNvbmFscHJlc3NfcG9zdGluZm8yIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyNDoicGVyc29uYWxwcmVzc190aHVtYm5haWxzIjtzOjI6Im9uIjtzOjMxOiJwZXJzb25hbHByZXNzX3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjI5OiJwZXJzb25hbHByZXNzX3BhZ2VfdGh1bWJuYWlscyI7TjtzOjMyOiJwZXJzb25hbHByZXNzX3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjIzOiJwZXJzb25hbHByZXNzX3Bvc3RpbmZvMSI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MzA6InBlcnNvbmFscHJlc3NfdGh1bWJuYWlsc19pbmRleCI7czoyOiJvbiI7czoyNzoicGVyc29uYWxwcmVzc19jdXN0b21fY29sb3JzIjtOO3M6MjM6InBlcnNvbmFscHJlc3NfY2hpbGRfY3NzIjtOO3M6MjY6InBlcnNvbmFscHJlc3NfY2hpbGRfY3NzdXJsIjtzOjA6IiI7czoyODoicGVyc29uYWxwcmVzc19jb2xvcl9tYWluZm9udCI7czowOiIiO3M6Mjg6InBlcnNvbmFscHJlc3NfY29sb3JfbWFpbmxpbmsiO3M6MDoiIjtzOjI4OiJwZXJzb25hbHByZXNzX2NvbG9yX3BhZ2VsaW5rIjtzOjA6IiI7czozNToicGVyc29uYWxwcmVzc19jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjI4OiJwZXJzb25hbHByZXNzX2NvbG9yX2hlYWRpbmdzIjtzOjA6IiI7czozMzoicGVyc29uYWxwcmVzc19jb2xvcl9zaWRlYmFyX2xpbmtzIjtzOjA6IiI7czozMToicGVyc29uYWxwcmVzc19jb2xvcl9mb290ZXJsaW5rcyI7czowOiIiO3M6Mjg6InBlcnNvbmFscHJlc3Nfc2VvX2hvbWVfdGl0bGUiO047czozNDoicGVyc29uYWxwcmVzc19zZW9faG9tZV9kZXNjcmlwdGlvbiI7TjtzOjMxOiJwZXJzb25hbHByZXNzX3Nlb19ob21lX2tleXdvcmRzIjtOO3M6MzI6InBlcnNvbmFscHJlc3Nfc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6MzI6InBlcnNvbmFscHJlc3Nfc2VvX2hvbWVfdGl0bGV0ZXh0IjtzOjA6IiI7czozODoicGVyc29uYWxwcmVzc19zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjM1OiJwZXJzb25hbHByZXNzX3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6Mjc6InBlcnNvbmFscHJlc3Nfc2VvX2hvbWVfdHlwZSI7czoyNzoiQmxvZ05hbWUgfCBCbG9nIGRlc2NyaXB0aW9uIjtzOjMxOiJwZXJzb25hbHByZXNzX3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czozMDoicGVyc29uYWxwcmVzc19zZW9fc2luZ2xlX3RpdGxlIjtOO3M6MzY6InBlcnNvbmFscHJlc3Nfc2VvX3NpbmdsZV9kZXNjcmlwdGlvbiI7TjtzOjMzOiJwZXJzb25hbHByZXNzX3Nlb19zaW5nbGVfa2V5d29yZHMiO047czozNDoicGVyc29uYWxwcmVzc19zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjM2OiJwZXJzb25hbHByZXNzX3Nlb19zaW5nbGVfZmllbGRfdGl0bGUiO3M6OToic2VvX3RpdGxlIjtzOjQyOiJwZXJzb25hbHByZXNzX3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozOToicGVyc29uYWxwcmVzc19zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6Mjk6InBlcnNvbmFscHJlc3Nfc2VvX3NpbmdsZV90eXBlIjtzOjIxOiJQb3N0IHRpdGxlIHwgQmxvZ05hbWUiO3M6MzM6InBlcnNvbmFscHJlc3Nfc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzM6InBlcnNvbmFscHJlc3Nfc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjM1OiJwZXJzb25hbHByZXNzX3Nlb19pbmRleF9kZXNjcmlwdGlvbiI7TjtzOjI4OiJwZXJzb25hbHByZXNzX3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6MzI6InBlcnNvbmFscHJlc3Nfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozNzoicGVyc29uYWxwcmVzc19pbnRlZ3JhdGVfaGVhZGVyX2VuYWJsZSI7czoyOiJvbiI7czozNToicGVyc29uYWxwcmVzc19pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6NDA6InBlcnNvbmFscHJlc3NfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6NDM6InBlcnNvbmFscHJlc3NfaW50ZWdyYXRlX3NpbmdsZWJvdHRvbV9lbmFibGUiO3M6Mjoib24iO3M6MzA6InBlcnNvbmFscHJlc3NfaW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MzA6InBlcnNvbmFscHJlc3NfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6MzY6InBlcnNvbmFscHJlc3NfaW50ZWdyYXRpb25fc2luZ2xlX3RvcCI7czowOiIiO3M6Mzk6InBlcnNvbmFscHJlc3NfaW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MjQ6InBlcnNvbmFscHJlc3NfNDY4X2VuYWJsZSI7TjtzOjIzOiJwZXJzb25hbHByZXNzXzQ2OF9pbWFnZSI7czowOiIiO3M6MjE6InBlcnNvbmFscHJlc3NfNDY4X3VybCI7czowOiIiO3M6MjU6InBlcnNvbmFscHJlc3NfNDY4X2Fkc2Vuc2UiO3M6MDoiIjt9';

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