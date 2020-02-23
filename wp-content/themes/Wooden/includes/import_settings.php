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

	$importOptions = 'YTo4MTp7czowOiIiO047czoxMToid29vZGVuX2xvZ28iO3M6MDoiIjtzOjE0OiJ3b29kZW5fZmF2aWNvbiI7czowOiIiO3M6MTk6Indvb2Rlbl9jb2xvcl9zY2hlbWUiO3M6MzoiUmVkIjtzOjE3OiJ3b29kZW5fZ3JhYl9pbWFnZSI7TjtzOjE5OiJ3b29kZW5fY2F0bnVtX3Bvc3RzIjtzOjE6IjYiO3M6MjM6Indvb2Rlbl9hcmNoaXZlbnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjI6Indvb2Rlbl9zZWFyY2hudW1fcG9zdHMiO3M6MToiNSI7czoxOToid29vZGVuX3RhZ251bV9wb3N0cyI7czoxOiI1IjtzOjE4OiJ3b29kZW5fZGF0ZV9mb3JtYXQiO3M6NjoiTSBqLCBZIjtzOjE4OiJ3b29kZW5fdXNlX2V4Y2VycHQiO047czoxOToid29vZGVuX3Nob3dfYWJvdXR1cyI7czoyOiJvbiI7czoyNzoid29vZGVuX3Nob3dfcmVjZW50X2NvbW1lbnRzIjtzOjI6Im9uIjtzOjI0OiJ3b29kZW5fc2hvd19yYW5kb21fcG9zdHMiO3M6Mjoib24iO3M6MTU6Indvb2Rlbl9hYm91dF91cyI7czowOiIiO3M6MjE6Indvb2Rlbl9leGxjYXRzX3JlY2VudCI7TjtzOjE1OiJ3b29kZW5fZmVhdHVyZWQiO3M6Mjoib24iO3M6MTY6Indvb2Rlbl9kdXBsaWNhdGUiO3M6Mjoib24iO3M6MTU6Indvb2Rlbl9mZWF0X2NhdCI7czo0OiJCbG9nIjtzOjE5OiJ3b29kZW5fZmVhdHVyZWRfbnVtIjtzOjE6IjEiO3M6MTY6Indvb2Rlbl9tZW51cGFnZXMiO047czoxNjoid29vZGVuX2hvbWVfbGluayI7czoyOiJvbiI7czoxNzoid29vZGVuX3NvcnRfcGFnZXMiO3M6MTA6InBvc3RfdGl0bGUiO3M6MTc6Indvb2Rlbl9vcmRlcl9wYWdlIjtzOjM6ImFzYyI7czoxNToid29vZGVuX21lbnVjYXRzIjtOO3M6MjM6Indvb2Rlbl9jYXRlZ29yaWVzX2VtcHR5IjtzOjI6Im9uIjtzOjE1OiJ3b29kZW5fc29ydF9jYXQiO3M6NDoibmFtZSI7czoxNjoid29vZGVuX29yZGVyX2NhdCI7czozOiJhc2MiO3M6MTg6Indvb2Rlbl9zd2FwX25hdmJhciI7TjtzOjE2OiJ3b29kZW5fcG9zdGluZm8yIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoxNzoid29vZGVuX3RodW1ibmFpbHMiO3M6Mjoib24iO3M6MjQ6Indvb2Rlbl9zaG93X3Bvc3Rjb21tZW50cyI7czoyOiJvbiI7czoyMjoid29vZGVuX3BhZ2VfdGh1bWJuYWlscyI7TjtzOjI1OiJ3b29kZW5fc2hvd19wYWdlc2NvbW1lbnRzIjtOO3M6MTY6Indvb2Rlbl9wb3N0aW5mbzEiO2E6NDp7aTowO3M6NjoiYXV0aG9yIjtpOjE7czo0OiJkYXRlIjtpOjI7czoxMDoiY2F0ZWdvcmllcyI7aTozO3M6ODoiY29tbWVudHMiO31zOjIzOiJ3b29kZW5fdGh1bWJuYWlsc19pbmRleCI7czoyOiJvbiI7czoxNzoid29vZGVuX3Nob3dfc2hhcmUiO3M6Mjoib24iO3M6MjA6Indvb2Rlbl9jdXN0b21fY29sb3JzIjtOO3M6MTY6Indvb2Rlbl9jaGlsZF9jc3MiO047czoxOToid29vZGVuX2NoaWxkX2Nzc3VybCI7czowOiIiO3M6MjE6Indvb2Rlbl9jb2xvcl9tYWluZm9udCI7czowOiIiO3M6MjE6Indvb2Rlbl9jb2xvcl9tYWlubGluayI7czowOiIiO3M6MjE6Indvb2Rlbl9jb2xvcl9wYWdlbGluayI7czowOiIiO3M6Mjg6Indvb2Rlbl9jb2xvcl9wYWdlbGlua19hY3RpdmUiO3M6MDoiIjtzOjIxOiJ3b29kZW5fY29sb3JfaGVhZGluZ3MiO3M6MDoiIjtzOjI2OiJ3b29kZW5fY29sb3Jfc2lkZWJhcl9saW5rcyI7czowOiIiO3M6MTg6Indvb2Rlbl9mb290ZXJfdGV4dCI7czowOiIiO3M6MjQ6Indvb2Rlbl9jb2xvcl9mb290ZXJsaW5rcyI7czowOiIiO3M6MjE6Indvb2Rlbl9zZW9faG9tZV90aXRsZSI7TjtzOjI3OiJ3b29kZW5fc2VvX2hvbWVfZGVzY3JpcHRpb24iO047czoyNDoid29vZGVuX3Nlb19ob21lX2tleXdvcmRzIjtOO3M6MjU6Indvb2Rlbl9zZW9faG9tZV9jYW5vbmljYWwiO047czoyNToid29vZGVuX3Nlb19ob21lX3RpdGxldGV4dCI7czowOiIiO3M6MzE6Indvb2Rlbl9zZW9faG9tZV9kZXNjcmlwdGlvbnRleHQiO3M6MDoiIjtzOjI4OiJ3b29kZW5fc2VvX2hvbWVfa2V5d29yZHN0ZXh0IjtzOjA6IiI7czoyMDoid29vZGVuX3Nlb19ob21lX3R5cGUiO3M6Mjc6IkJsb2dOYW1lIHwgQmxvZyBkZXNjcmlwdGlvbiI7czoyNDoid29vZGVuX3Nlb19ob21lX3NlcGFyYXRlIjtzOjM6IiB8ICI7czoyMzoid29vZGVuX3Nlb19zaW5nbGVfdGl0bGUiO047czoyOToid29vZGVuX3Nlb19zaW5nbGVfZGVzY3JpcHRpb24iO047czoyNjoid29vZGVuX3Nlb19zaW5nbGVfa2V5d29yZHMiO047czoyNzoid29vZGVuX3Nlb19zaW5nbGVfY2Fub25pY2FsIjtOO3M6Mjk6Indvb2Rlbl9zZW9fc2luZ2xlX2ZpZWxkX3RpdGxlIjtzOjk6InNlb190aXRsZSI7czozNToid29vZGVuX3Nlb19zaW5nbGVfZmllbGRfZGVzY3JpcHRpb24iO3M6MTU6InNlb19kZXNjcmlwdGlvbiI7czozMjoid29vZGVuX3Nlb19zaW5nbGVfZmllbGRfa2V5d29yZHMiO3M6MTI6InNlb19rZXl3b3JkcyI7czoyMjoid29vZGVuX3Nlb19zaW5nbGVfdHlwZSI7czoyMToiUG9zdCB0aXRsZSB8IEJsb2dOYW1lIjtzOjI2OiJ3b29kZW5fc2VvX3NpbmdsZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6MjY6Indvb2Rlbl9zZW9faW5kZXhfY2Fub25pY2FsIjtOO3M6Mjg6Indvb2Rlbl9zZW9faW5kZXhfZGVzY3JpcHRpb24iO047czoyMToid29vZGVuX3Nlb19pbmRleF90eXBlIjtzOjI0OiJDYXRlZ29yeSBuYW1lIHwgQmxvZ05hbWUiO3M6MjU6Indvb2Rlbl9zZW9faW5kZXhfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjMwOiJ3b29kZW5faW50ZWdyYXRlX2hlYWRlcl9lbmFibGUiO3M6Mjoib24iO3M6Mjg6Indvb2Rlbl9pbnRlZ3JhdGVfYm9keV9lbmFibGUiO3M6Mjoib24iO3M6MzM6Indvb2Rlbl9pbnRlZ3JhdGVfc2luZ2xldG9wX2VuYWJsZSI7czoyOiJvbiI7czozNjoid29vZGVuX2ludGVncmF0ZV9zaW5nbGVib3R0b21fZW5hYmxlIjtzOjI6Im9uIjtzOjIzOiJ3b29kZW5faW50ZWdyYXRpb25faGVhZCI7czowOiIiO3M6MjM6Indvb2Rlbl9pbnRlZ3JhdGlvbl9ib2R5IjtzOjA6IiI7czoyOToid29vZGVuX2ludGVncmF0aW9uX3NpbmdsZV90b3AiO3M6MDoiIjtzOjMyOiJ3b29kZW5faW50ZWdyYXRpb25fc2luZ2xlX2JvdHRvbSI7czowOiIiO3M6MTc6Indvb2Rlbl80NjhfZW5hYmxlIjtOO3M6MTY6Indvb2Rlbl80NjhfaW1hZ2UiO3M6MDoiIjtzOjE0OiJ3b29kZW5fNDY4X3VybCI7czowOiIiO30=';

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