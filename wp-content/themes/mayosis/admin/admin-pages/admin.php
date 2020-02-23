<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $pagenow;
function mayosis_welcome_page(){
    require_once 'mayosis-welcome.php';
}

function mayosis_license_page(){
    require_once 'mayosis_license_page.php';
}


function mayosis_admin_menu(){
    if ( current_user_can( 'edit_theme_options' ) ) {
        add_menu_page( 'Mayosis', 'Mayosis', 'administrator', 'mayosis-admin-menu', 'mayosis_welcome_page', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OEJBQkU2ODc3M0UzMTFFOEI2MzNDMjQ2OTlDNzdERjgiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OEJBQkU2ODY3M0UzMTFFOEI2MzNDMjQ2OTlDNzdERjgiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6M0Y0NzBFODI0NTgxMTFFOEEyOUY4MkVBNUExNUM0QzQiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6M0Y0NzBFODM0NTgxMTFFOEEyOUY4MkVBNUExNUM0QzQiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5X/xoEAAABVElEQVR42mKct3jFMwYGBh4G6oAvLEBCkoF6gBdk4GcQA4gPAvEBMg1yAGJ7kFksSIKrgHgaqSYlxoQzzF+yMgtqIAMTkpwYEpuDRHPhepmwSJoC8UMgPgvEoljk+YB4DxBfA2I9dElsBoZDbTQC4mNALI4kJwoVcwZiTSCOQdfMgsXAb0hsFagBIM3sQHwXGoEw8JMYF/5D4ytBDVUE4rdQsf9Q+i8xBsIASPMbKNsYiGcAcQIQNwLxK1ya8Bn4HogtgfgGlG8JjZAGqPexAhY8BoJy0B0gtgbidVDvnQJiRnz6WPC4GqSRH4jfQXMCDPAjqWEixsvcUJoLiP9gkf8DlUNWi9fAVdDIWAbEX7HIf4XKvYGqJejlk0AsB8Tf8YRvNBBzYlOD7ELkpPCdiPz7HZteZBeGoRUQRAFgScOAHGksSFnJHlYEUVrAPqdmFQAQYACu3T3ZynYAKAAAAABJRU5ErkJggg==', 4 );
        add_submenu_page( 'mayosis-admin-menu', 'mayosis', esc_html__('Welcome','mayosis'), 'administrator', 'mayosis-admin-menu', 'mayosis_welcome_page' );
         add_submenu_page('mayosis-admin-menu', '', 'Theme Options', 'manage_options', 'customize.php' );
         add_submenu_page( 'mayosis-admin-menu', 'mayosis', esc_html__('License','mayosis'), 'administrator', 'mayosis-license-menu', 'mayosis_license_page' );
         if (class_exists('OCDI_Plugin')):
         add_submenu_page( 'mayosis-admin-menu', esc_html__( 'Demo Import', 'mayosis' ), esc_html__( 'Demo Import', 'mayosis' ), 'administrator', 'demo_install', 'demo_install_function' );
 endif;
         
        
        
     
    }
}

add_action( 'admin_menu', 'mayosis_admin_menu' );
  
function demo_install_function(){
    $url = admin_url().'themes.php?page=pt-one-click-demo-import';
    ?>
    <script>location.href='<?php echo esc_url($url);?>';</script>
    <?php
  }
  
if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

	wp_redirect(admin_url("admin.php?page=mayosis-admin-menu"));
	
}