<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style-Default.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/cluetip/jquery.cluetip.css" type="text/css" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/iestyle.css" />
	<![endif]-->
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie6style.css" />
	<![endif]-->

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper2">
		<!--This controls pages navigation bar-->
		<div id="pages">
			<?php $menuClass = '';
			$primaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'depth' => 1, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if(get_option('interphase_swap_navbar') == 'false') { ?>
						<?php if (get_option('interphase_home_link') == 'on') { ?>
							<li class="page_item<?php if (is_front_page()) echo(' current_page_item') ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','InterPhase'); ?></a></li>
						<?php }; ?>

						<?php show_page_menu($menuClass,false,false); ?>
					<?php } else { ?>
						<?php show_categories_menu($menuClass,false); ?>
					<?php } ?>
				</ul>
			<?php }
			else echo($primaryNav); ?>
		</div>
		<!--End category navigation-->
		<!--This controls the categories navigation bar-->
		<div id="categories">
			<?php $menuClass = '';
			$secondaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false, 'depth' => 1 ) );
			};
			if ($secondaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if(get_option('interphase_swap_navbar') == 'false') { ?>
						<?php show_categories_menu($menuClass,false); ?>
					<?php } else { ?>
						<?php if (get_option('interphase_home_link') == 'on') { ?>
							<li class="page_item<?php if (is_front_page()) echo(' current_page_item') ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','InterPhase'); ?></a></li>
						<?php }; ?>

						<?php show_page_menu($menuClass,false,false); ?>
					<?php } ?>
				</ul>
			<?php }
			else echo($secondaryNav); ?>

		</div>
		<!--End category navigation-->

		<div id="header">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('interphase_logo') <> '') ? get_option('interphase_logo') : get_template_directory_uri().'/images/logo.gif'; ?>
				<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a>
			<!--This is your company's logo-->
		</div>
		<div style="clear: both;"></div>
		<img src="<?php echo get_template_directory_uri(); ?>/images/content-bg-top<?php global $fullwidth; if ( is_page_template('page-full.php') || $fullwidth) echo('-full');?>.gif" style="float: left;" alt="content top" />