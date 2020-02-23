<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/iestyle.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie6style.css" />
<![endif]-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper2">
		<img src="<?php echo get_template_directory_uri(); ?>/images/header-left.gif" alt="logo" style="float: left;" />
		<div id="header">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('tidalforce_logo') <> '') ? get_option('tidalforce_logo') : get_template_directory_uri().'/images/logo.gif'; ?>
				<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a>

			<!--Begin Pages Navigation Bar-->
			<img src="<?php echo get_template_directory_uri(); ?>/images/pages-left.gif" alt="logo" style="float: left; margin-left: 22px;" />
			<div id="navigation">
				<?php $menuClass = 'nav superfish';
				$menuID = 'nav2';
				$primaryNav = '';
				if (function_exists('wp_nav_menu')) {
					$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
				};
				if ($primaryNav == '') { ?>
					<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
						<?php if (get_option('tidalforce_swap_navbar') == 'false') { ?>
							<?php if (get_option('tidalforce_home_link') == 'on') { ?>
								<li class="page_item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','TidalForce') ?></a></li>
							<?php }; ?>
							<?php show_page_menu($menuClass,false,false); ?>
						<?php } else { ?>
							<?php show_categories_menu($menuClass,false); ?>
						<?php } ?>
					</ul> <!-- end ul#nav -->
				<?php }
				else echo($primaryNav); ?>
			</div>
			<img src="<?php echo get_template_directory_uri(); ?>/images/pages-right.gif" alt="logo" style="float: left;" />
			<!--End Pages Navigation Bar-->

			<div style="clear: both;"></div>

			<!--Begin Categories Navigation Bar-->
			<img src="<?php echo get_template_directory_uri(); ?>/images/categories-top.gif" alt="cat top" style="float: left; margin-top: 20px; margin-left: 7px;" />
			<div style="clear: both;"></div>
			<div id="categories-inside">
				<div style="clear: both;"></div>

				<?php $menuClass = 'nav superfish';
				$secondaryNav = '';
				if (function_exists('wp_nav_menu')) {
					$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
				};
				if ($secondaryNav == '') { ?>
					<ul class="<?php echo esc_attr( $menuClass ); ?>">
						<?php if (get_option('tidalforce_swap_navbar') == 'false') { ?>
							<?php show_categories_menu($menuClass,false); ?>
						<?php } else { ?>
							<?php if (get_option('tidalforce_home_link') == 'on') { ?>
								<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','TidalForce') ?></a></li>
							<?php }; ?>

							<?php show_page_menu($menuClass,false,false); ?>
						<?php } ?>
					</ul> <!-- end ul#nav -->
				<?php }
				else echo($secondaryNav); ?>

				<div style="clear: both;"></div>
				<img src="<?php echo get_template_directory_uri(); ?>/images/categories-bottom.gif" alt="cat top" style="float: left;" />
			</div>
			<!--End Categories Navigation Bar-->

		</div>
		<img src="<?php echo get_template_directory_uri(); ?>/images/header-right.gif" alt="logo" style="float: left;" />