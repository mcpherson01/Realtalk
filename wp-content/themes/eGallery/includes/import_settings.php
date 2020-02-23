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

	$importOptions = 'YTo3OTp7czowOiIiO047czoxMzoiZWdhbGxlcnlfbG9nbyI7czowOiIiO3M6MTY6ImVnYWxsZXJ5X2Zhdmljb24iO3M6MDoiIjtzOjIxOiJlZ2FsbGVyeV9jb2xvcl9zY2hlbWUiO3M6NDoiQmx1ZSI7czoxOToiZWdhbGxlcnlfZ3JhYl9pbWFnZSI7TjtzOjIwOiJlZ2FsbGVyeV9yYW5kb21fc2hvdyI7czoyOiJvbiI7czoxOToiZWdhbGxlcnlfcmFuZG9tX251bSI7czoxOiI2IjtzOjIxOiJlZ2FsbGVyeV9jYXRudW1fcG9zdHMiO3M6MToiNiI7czoyNToiZWdhbGxlcnlfYXJjaGl2ZW51bV9wb3N0cyI7czoxOiI1IjtzOjI0OiJlZ2FsbGVyeV9zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoyMToiZWdhbGxlcnlfdGFnbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjA6ImVnYWxsZXJ5X2RhdGVfZm9ybWF0IjtzOjY6Ik0gaiwgWSI7czoyMDoiZWdhbGxlcnlfdXNlX2V4Y2VycHQiO047czoyMzoiZWdhbGxlcnlfaG9tZXBhZ2VfcG9zdHMiO3M6MToiNiI7czoyMzoiZWdhbGxlcnlfZXhsY2F0c19yZWNlbnQiO047czoxNzoiZWdhbGxlcnlfZmVhdHVyZWQiO3M6Mjoib24iO3M6MTc6ImVnYWxsZXJ5X2ZlYXRfY2F0IjtzOjg6IkZlYXR1cmVkIjtzOjIxOiJlZ2FsbGVyeV9mZWF0dXJlZF9udW0iO3M6MToiMyI7czoxODoiZWdhbGxlcnlfbWVudXBhZ2VzIjtOO3M6MTg6ImVnYWxsZXJ5X2hvbWVfbGluayI7czoyOiJvbiI7czoxOToiZWdhbGxlcnlfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoxOToiZWdhbGxlcnlfb3JkZXJfcGFnZSI7czozOiJhc2MiO3M6MTc6ImVnYWxsZXJ5X21lbnVjYXRzIjtOO3M6MjU6ImVnYWxsZXJ5X2NhdGVnb3JpZXNfZW1wdHkiO3M6Mjoib24iO3M6MTc6ImVnYWxsZXJ5X3NvcnRfY2F0IjtzOjQ6Im5hbWUiO3M6MTg6ImVnYWxsZXJ5X29yZGVyX2NhdCI7czozOiJhc2MiO3M6MjA6ImVnYWxsZXJ5X3N3YXBfbmF2YmFyIjtOO3M6MTg6ImVnYWxsZXJ5X3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MTk6ImVnYWxsZXJ5X3RodW1ibmFpbHMiO3M6Mjoib24iO3M6MjY6ImVnYWxsZXJ5X3Nob3dfcG9zdGNvbW1lbnRzIjtzOjI6Im9uIjtzOjI0OiJlZ2FsbGVyeV9wYWdlX3RodW1ibmFpbHMiO047czoyNzoiZWdhbGxlcnlfc2hvd19wYWdlc2NvbW1lbnRzIjtOO3M6MzA6ImVnYWxsZXJ5X3RodW1ibmFpbF93aWR0aF9wYWdlcyI7czozOiIxODUiO3M6MzE6ImVnYWxsZXJ5X3RodW1ibmFpbF9oZWlnaHRfcGFnZXMiO3M6MzoiMTg1IjtzOjIyOiJlZ2FsbGVyeV9jdXN0b21fY29sb3JzIjtOO3M6MTg6ImVnYWxsZXJ5X2NoaWxkX2NzcyI7TjtzOjIxOiJlZ2FsbGVyeV9jaGlsZF9jc3N1cmwiO3M6MDoiIjtzOjIzOiJlZ2FsbGVyeV9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjM6ImVnYWxsZXJ5X2NvbG9yX21haW5saW5rIjtzOjA6IiI7czoyMzoiZWdhbGxlcnlfY29sb3JfcGFnZWxpbmsiO3M6MDoiIjtzOjMwOiJlZ2FsbGVyeV9jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjIzOiJlZ2FsbGVyeV9jb2xvcl9oZWFkaW5ncyI7czowOiIiO3M6Mjg6ImVnYWxsZXJ5X2NvbG9yX3NpZGViYXJfbGlua3MiO3M6MDoiIjtzOjI0OiJlZ2FsbGVyeV9mb290ZXJfaGVhZGluZ3MiO3M6MDoiIjtzOjI2OiJlZ2FsbGVyeV9jb2xvcl9mb290ZXJsaW5rcyI7czowOiIiO3M6MjM6ImVnYWxsZXJ5X3Nlb19ob21lX3RpdGxlIjtOO3M6Mjk6ImVnYWxsZXJ5X3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MjY6ImVnYWxsZXJ5X3Nlb19ob21lX2tleXdvcmRzIjtOO3M6Mjc6ImVnYWxsZXJ5X3Nlb19ob21lX2Nhbm9uaWNhbCI7TjtzOjI3OiJlZ2FsbGVyeV9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjMzOiJlZ2FsbGVyeV9zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjMwOiJlZ2FsbGVyeV9zZW9faG9tZV9rZXl3b3Jkc3RleHQiO3M6MDoiIjtzOjIyOiJlZ2FsbGVyeV9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MjY6ImVnYWxsZXJ5X3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyNToiZWdhbGxlcnlfc2VvX3NpbmdsZV90aXRsZSI7TjtzOjMxOiJlZ2FsbGVyeV9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6Mjg6ImVnYWxsZXJ5X3Nlb19zaW5nbGVfa2V5d29yZHMiO047czoyOToiZWdhbGxlcnlfc2VvX3NpbmdsZV9jYW5vbmljYWwiO047czozMToiZWdhbGxlcnlfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6Mzc6ImVnYWxsZXJ5X3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozNDoiZWdhbGxlcnlfc2VvX3NpbmdsZV9maWVsZF9rZXl3b3JkcyI7czoxMjoic2VvX2tleXdvcmRzIjtzOjI0OiJlZ2FsbGVyeV9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czoyODoiZWdhbGxlcnlfc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjg6ImVnYWxsZXJ5X3Nlb19pbmRleF9jYW5vbmljYWwiO047czozMDoiZWdhbGxlcnlfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6MjM6ImVnYWxsZXJ5X3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6Mjc6ImVnYWxsZXJ5X3Nlb19pbmRleF9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MzI6ImVnYWxsZXJ5X2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjMwOiJlZ2FsbGVyeV9pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6MzU6ImVnYWxsZXJ5X2ludGVncmF0ZV9zaW5nbGV0b3BfZW5hYmxlIjtzOjI6Im9uIjtzOjM4OiJlZ2FsbGVyeV9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyNToiZWdhbGxlcnlfaW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MjU6ImVnYWxsZXJ5X2ludGVncmF0aW9uX2JvZHkiO3M6MDoiIjtzOjMxOiJlZ2FsbGVyeV9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozNDoiZWdhbGxlcnlfaW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MTk6ImVnYWxsZXJ5XzQ2OF9lbmFibGUiO047czoxODoiZWdhbGxlcnlfNDY4X2ltYWdlIjtzOjA6IiI7czoxNjoiZWdhbGxlcnlfNDY4X3VybCI7czowOiIiO3M6MjA6ImVnYWxsZXJ5XzQ2OF9hZHNlbnNlIjtzOjA6IiI7fQ==';

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