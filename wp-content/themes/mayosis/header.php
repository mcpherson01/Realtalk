<?php
/**
 * The Header for our theme.
 * @package mayosis
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
 <head>
<?php
 global $edd_options;
 $favicon = get_theme_mod( 'favicon-upload');
 $headerlayout = get_theme_mod( 'header_layout_type');
 $loaderwebsite = get_theme_mod( 'loader_website','hide');
 $headerlayoutmaster = get_theme_mod( 'header_layout_type','one');
 $headertypestcked = get_theme_mod( 'header_transparency','normal');
 $acccolor=get_theme_mod( 'accent_color','#5a00f0');
?>
<!-- Basic Page Info -->
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<meta name="theme-color" content="<?php echo esc_html($acccolor); ?>" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Favicon -->
<?php
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {			
		if (!empty($favicon)){
		?>
			<link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" type="image/x-icon" />
			<?php
		}else{
		?>
			<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/fav.png" type="image/x-icon">
		<?php
		}
	}
	?>
<?php
wp_head(); ?>
</head>

<!-- Begin Main Layout --> 
<body <?php
body_class(); ?>>
    
    
    <?php if ($loaderwebsite == 'show'): ?>
    <div class="load-mayosis">
 <ul class="loading reversed">
      <li></li>
      <li></li>
      <li></li>
    </ul>
    </div>
<?php endif; ?>

<?php

if ($headerlayoutmaster == 'two'): ?>
<div class="sidebar-wrapper">
    <?php else: ?>
    <div class="mayosis-wrapper">
<?php
endif; ?>

 <?php if ($headerlayoutmaster == 'two'): ?>
     <?php
		get_template_part('includes/header/header', 'sidebar');
	?>
<?php else : ?>
 <?php if ($headertypestcked == 'transparent'): ?>
        <header id="main-header" class="main-header header-stacked">
      <?php else: ?>
        <header id="main-header" class="main-header">
       <?php endif; ?>
	<?php
		get_template_part('includes/header/header', 'container');
	?>
</header>

<?php endif;?>