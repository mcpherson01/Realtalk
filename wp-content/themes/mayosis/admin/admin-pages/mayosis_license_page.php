<?php
$mayosistheme = wp_get_theme();
?>
<div class="wrap about-wrap mayosis-wrap">
    <h1><?php _e( 'Welcome to Mayosis', 'mayosis' ); ?></h1>

    <div class="about-text"><?php echo esc_html__( 'Mayosis theme is now installed and ready to use!', 'mayosis' ); ?></div>
<div class="mayosis-badge">
    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjNCRjg0ODQ5MEYzMTExRTk5NTVBQTQyN0QwQkY2NzU0IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjNCRjg0ODRBMEYzMTExRTk5NTVBQTQyN0QwQkY2NzU0Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6M0JGODQ4NDcwRjMxMTFFOTk1NUFBNDI3RDBCRjY3NTQiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6M0JGODQ4NDgwRjMxMTFFOTk1NUFBNDI3RDBCRjY3NTQiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6vOdMRAAACHUlEQVR42uyazSsEYRzHZ1jadXBwkpycSDnKSVxcpGhTXkopDv4ERydxkIMktEWKoi1RlJML5cDJRdIqrRyUvLPp8X3q2dqmedt9Zmdnnv396tO2M/M8z3z2mef3PPO0OmNMK6eo0MosSFj1iJgcU21Q6/RIkzAJq520HAd+gINRD5MwCZMwCZNwmQnHwCy4A5/gFHR4UG8DWATn4BgMe7Ie4DseBsxCs+HQ5Ppv0OtQzo428GhS74JDOcd7lxVuZtbxA/oKkG0HzxZ1/oFGGWHZR7rJ5lw12AMDedTXCU5Anc0QbC3lGHYaU1x6B8Rd1NUDjkCtR+v/kmXprPSgzTX94ADUqDIt8V7ZBkMm50bArvhhlJqHK8EWGDXIbso+pkFeeHDpDTAmvp+BB9VXWlw6AcZBCnSJT6WXllx6HUwI2W5DT1+FUfjNRdurOdJxsUWTBJNhFObJ6d7FPL4MWsAFmBNr5t8wCrsdn1U5mXu6mLJ+jOHs+HSSrlcpabmRvlEtS9tJ34rkpdy0lBIbAyvgGlyCeXHsxa+biGj+xhOYoj0tEibhUAh/lahsUYWt5tZ3F8tKu+BlX/Ns0xdhPr3smxxfAhmJejNijW2MpGiz8PBgXzoKZkAafIAEiEnsSWfhdayJOtOijajsvrRu8tdDZvFWE4ZwvHfK0iRMwiRMwiQcoHD7Psyoh0mYhEk4qElLpx4mYRIOTfwLMAC52ad+ryhA1wAAAABJRU5ErkJggg==" alt="mayosis admin logo">
    
    <p><?php echo esc_html($mayosistheme->get( 'Version' )); ?></p>
</div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="admin.php?page=mayosis-admin-menu" class="nav-tab">%s</a>', __( 'Welcome', 'mayosis' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'customize.php' ), __( 'Theme Options', 'mayosis' ) );
         printf( '<a href="admin.php?page=mayosis-license-menu" class="nav-tab nav-tab-active">%s</a>', __( 'License', 'mayosis' ) );
        if (class_exists('OCDI_Plugin')):
        printf( '<a href="%s" class="nav-tab ">%s</a>', admin_url( 'themes.php?page=pt-one-click-demo-import' ), __( 'Demo Import', 'mayosis' ) );
        endif;
        ?>
    </h2>
    
   
    <div class="mayosis-section nav-tab-active" id="welcome">
<?php
if ( function_exists( 'mayosis_lisense_box' ) ){
mayosis_lisense_box();
}

?>
</div>
</div>