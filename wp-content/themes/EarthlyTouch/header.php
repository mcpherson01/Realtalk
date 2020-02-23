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
	<!--Begin Pages Navigation-->
	<div id="pages">
		<img src="<?php echo get_template_directory_uri(); ?>/images/navigation-left.gif" style="float: left;" alt="nav-left" />

		<?php $menuClass = 'nav superfish';
		$primaryNav = '';
		if (function_exists('wp_nav_menu')) {
			$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
		};
		if ($primaryNav == '') { ?>
			<ul class="<?php echo esc_attr( $menuClass ); ?>">
				<?php if (get_option('earthlytouch_swap_navbar') == 'false') { ?>
					<?php if (get_option('earthlytouch_home_link') == 'on') { ?>
						<li class="page_item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','EarthlyTouch') ?></a></li>
					<?php }; ?>

					<?php show_page_menu($menuClass,false,false); ?>
				<?php } else { ?>
					<?php show_categories_menu($menuClass,false); ?>
				<?php } ?>
			</ul> <!-- end ul#nav -->
		<?php }
		else echo($primaryNav); ?>

		<img src="<?php echo get_template_directory_uri(); ?>/images/navigation-right.gif" style="float: right;" alt="cat-right" />
	</div>
	<!--End Pages Navigation-->
	<div style="clear: both;"></div>

	<div id="header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php $logo = (get_option('earthlytouch_logo') <> '') ? get_option('earthlytouch_logo') : get_template_directory_uri().'/images/logo.gif'; ?>
			<img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/>
		</a>
		<!--Begin Search Form-->
		<div class="search_bg">
			<div id="search">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="padding:0px 0px 0px 0px; margin:0px 0px 0px 0px">
					<input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
					<input type="image" class="input" src="<?php echo get_template_directory_uri(); ?>/images/search-<?php echo esc_attr(get_option('earthlytouch_color_scheme')); ?>.gif" value="submit"/>
				</form>
			</div>
		</div>
		<!--Begin Search Form-->
	</div> <!-- end #header -->
	<div style="clear: both;"></div>

	<div id="wrapper2">
		<!--Begin Categories Navigation Bar-->
		<div id="categories">
			<?php $menuClass = 'nav superfish';
			$menuID = 'nav2';
			$secondaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
			};
			if ($secondaryNav == '') { ?>
				<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('earthlytouch_swap_navbar') == 'false') { ?>
						<?php show_categories_menu($menuClass,false); ?>
					<?php } else { ?>
						<?php if (get_option('earthlytouch_home_link') == 'on') { ?>
							<li class="page_item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','EarthlyTouch') ?></a></li>
						<?php }; ?>

						<?php show_page_menu($menuClass,false,false); ?>
					<?php } ?>
				</ul> <!-- end ul#nav -->
			<?php }
			else echo($secondaryNav); ?>

			<img src="<?php echo get_template_directory_uri(); ?>/images/categories-right-<?php echo esc_attr(get_option('earthlytouch_color_scheme')); ?>.gif" style="float: right;" alt="cat-right" />
			<div style="clear:both;"></div>
		</div>