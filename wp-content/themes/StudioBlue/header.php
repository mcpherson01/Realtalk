<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/iestyle.css" />
	<![endif]-->
	<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie6style.css" />
	<script defer type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/pngfix.js"></script>
	<![endif]-->

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper2">
		<!--This controls pages navigation bar-->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('studioblue_logo') <> '') ? get_option('studioblue_logo') : get_template_directory_uri().'/images/logo'.get_option('studioblue_color_scheme').'.png'; ?>
			<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a>
		<div id="pages">
			<?php $menuClass = '';
			$primaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false, 'depth' => 1 ) );
			};
			if ($primaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('studioblue_home_link') == 'on') { ?>
						<li class="page_item<?php if (is_front_page()) echo(' current_page_item') ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','StudioBlue'); ?></a></li>
					<?php }; ?>

					<?php show_page_menu($menuClass,false,false); ?>
				</ul> <!-- end ul.lamp -->
			<?php }
			else echo($primaryNav); ?>
		</div>
		<!--End pages navigation-->

		<div id="categories">
			<?php $menuClass = 'nav superfish';
			$secondaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
			};
			if ($secondaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php show_categories_menu($menuClass,false); ?>
				</ul> <!-- end ul#nav -->
			<?php }
			else echo($secondaryNav); ?>
		</div>