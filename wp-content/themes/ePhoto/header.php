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
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie8style.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie6style.css" />
<script defer type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/pngfix.js"></script>
<![endif]-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="bgdiv">
<div id="wrapper2">
<div id="logobg">

	<?php if (get_option('ephoto_468_enable') == 'on') { ?>
		<?php get_template_part('includes/468x60'); ?>
	<?php } ?>

	<div class="logowrap">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('ephoto_logo') <> '') ? get_option('ephoto_logo') : get_template_directory_uri().'/images/logo.png'; ?>
			<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a>

		<?php $menuClass = 'nav superfish';
		$menuID = 'animate';
		$primaryNav = '';
		if (function_exists('wp_nav_menu')) {
			$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
		};
		if ($primaryNav == '') { ?>
			<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
				<?php if (get_option('ephoto_home_link') == 'on') { ?>
					<li class="page_item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','ePhoto') ?></a></li>
				<?php } ?>

				<?php if (get_option('ephoto_blog_link') == 'on') { ?>
					<?php wp_list_categories("include=".get_catId(get_option('ephoto_blog_cat'))."&depth=1&title_li="); ?>
				<?php } ?>

				<?php show_page_menu($menuClass,false,false); ?>
			</ul> <!-- end ul#nav -->
		<?php }
		else echo($primaryNav); ?>

		<img src="<?php echo get_template_directory_uri(); ?>/images/categories-button-<?php echo esc_attr(get_option('ephoto_color_scheme')); ?>.gif" id="categories-button" alt="categories" />
		<div style="clear: both;"></div>
		<div style="position: relative;">
			<div id="categories-dropdown">
				<img src="<?php echo get_template_directory_uri(); ?>/images/categories-top-<?php echo esc_attr(get_option('ephoto_color_scheme')); ?>.png" class="categories-top" alt="categories" />
				<div class="categories-inside">
					<ul>
					<?php
						$exclude_cats = '';
						$ephoto_order_cat = get_option('ephoto_order_cat');
						$ephoto_sort_cat = get_option('ephoto_sort_cat');

						$exclude_categories = get_option('ephoto_menucats');

						if ( $exclude_categories ) $exclude_cats = implode( ",", et_generate_wpml_ids( $exclude_categories, 'category' ) );

						wp_list_categories("orderby=$ephoto_sort_cat&order=$ephoto_order_cat&exclude=$exclude_cats&title_li=");
					?>
					</ul>
				</div>
				<img src="<?php echo get_template_directory_uri(); ?>/images/categories-bottom-<?php echo esc_attr(get_option('ephoto_color_scheme')); ?>.png" class="categories-top" alt="categories" />
			</div>
		</div>
	</div>