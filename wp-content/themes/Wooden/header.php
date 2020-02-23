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
<div id="bgdiv">
	<div id="header">

		<!--Begin Pages Navigation Bar-->
		<div id="pages">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('wooden_logo') <> '') ? get_option('wooden_logo') : get_template_directory_uri().'/images/logo.png'; ?>
				<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a>
			<img src="<?php echo get_template_directory_uri(); ?>/images/nav-line-<?php echo esc_attr(get_option('wooden_color_scheme')); ?>.gif" alt="logo" style="float: left; margin-left: 15px; margin-top: 8px;" />

			<?php $menuClass = '';
			$primaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'depth' => 1, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('wooden_home_link') == 'on') { ?>
						<li class="page_item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','Wooden') ?></a></li>
					<?php }; ?>

					<?php if (get_option('wooden_swap_navbar') == 'false') { ?>
						<?php show_page_menu($menuClass,false,false); ?>
					<?php } else { ?>
						<?php show_categories_menu($menuClass,false); ?>
					<?php } ?>
				</ul>
			<?php }
			else echo($primaryNav); ?>

		</div>
		<!--End Pages Navigation Bar-->

		<div style="clear: both;"></div>
	</div>

	<div id="wrapper2">

		<!--Begin Search Bar-->
		<div class="search_bg">
			<div id="search">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="padding:0px 0px 0px 0px; margin:0px 0px 0px 0px">
					<input type="text"  name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
					<input type="image" class="input" src="<?php echo get_template_directory_uri(); ?>/images/search.gif" value="submit"/>
				</form>
			</div>
		</div>
		<!--End Search Bar-->