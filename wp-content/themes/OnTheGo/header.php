<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('ul#top-menu li ul, ul#top-menu li ul li.dropdown-bottom, img#logo, div#manlayer, ul.control li.recent a, div.entries h3 span, .widget_entries h3, #buildings');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie7style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

	<div class="container">
		<div id="header">
			<?php $menuClass = 'superfish nav';
			$menuID = 'top-menu';
			$primaryNav = '';

			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('onthego_home_link') == 'on') { ?>
						<li <?php if (is_front_page()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','OnTheGo'); ?></a></li>
					<?php }; ?>

					<?php show_categories_menu($menuClass,false); ?>

					<?php show_page_menu($menuClass,false,false); ?>
				</ul> <!-- end ul.nav -->
			<?php }
			else echo($primaryNav); ?>
		</div> <!-- end header -->

		<div id="contentwrap">
			<div id="content">

				<div id="manlayer"></div>

				<!-- LOGO -->
				<div id="logowrap">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('onthego_logo') <> '') ? get_option('onthego_logo') : get_template_directory_uri().'/images/logo.png'; ?>
						<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>
				</div>
				<!-- end LOGO -->

				<div id="main-area" class="clearfix">