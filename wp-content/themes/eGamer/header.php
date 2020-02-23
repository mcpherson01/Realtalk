<?php global $egamer_catnum_posts, $egamer_grab_image; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<?php if (get_option('egamer_468_enable') == 'on') { ?>
<?php get_template_part('includes/468x60'); ?>
<?php } else { echo ''; } ?>
<div id="wrapper">
<!--This controls pages navigation bar-->

<div id="pages">
	<?php $menuClass = 'nav superfish';
	$menuID = 'nav2';
	$primaryNav = '';
	if (function_exists('wp_nav_menu')) {
		$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
	};
	if ($primaryNav == '') { ?>
		<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
			<?php if (get_option('egamer_swap_navbar') == 'false') { ?>
				<?php if (get_option('egamer_home_link') == 'on') { ?>
					<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','eGamer') ?></a></li>
				<?php }; ?>

				<?php show_page_menu($menuClass,false,false); ?>
			<?php } else { ?>
				<?php show_categories_menu($menuClass,false); ?>
			<?php } ?>
		</ul> <!-- end ul#nav -->
	<?php }
	else echo($primaryNav); ?>

    <img src="<?php echo get_template_directory_uri(); ?>/images/pages-bg-right-<?php echo esc_attr(get_option('egamer_color_scheme')); ?>.gif" alt="pages bg right" style="float: right;" />
    <!--Begin Search Form-->
    <div class="search_bg">
        <div id="search">
            <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="padding:0px 0px 0px 0px; margin:0px 0px 0px 0px">
                <input type="text"  name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
                <input type="image" class="input" src="<?php echo get_template_directory_uri(); ?>/images/search-button-<?php echo esc_attr(get_option('egamer_color_scheme')); ?>.gif" value="submit"/>
            </form>
        </div>
    </div>
    <!--Begin Search Form-->
</div>
<!--End pages navigation-->
<!--This controls the categories navigation bar-->
<div id="categories">
	<?php $menuClass = 'nav superfish';
	$secondaryNav = '';
	if (function_exists('wp_nav_menu')) {
		$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
	};
	if ($secondaryNav == '') { ?>
		<ul class="<?php echo esc_attr( $menuClass ); ?>">
			<?php if (get_option('egamer_swap_navbar') == 'false') { ?>
				<?php show_categories_menu($menuClass,false); ?>
			<?php } else { ?>
				<?php if (get_option('egamer_home_link') == 'on') { ?>
					<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','eGamer') ?></a></li>
				<?php }; ?>

				<?php show_page_menu($menuClass,false,false); ?>
			<?php } ?>
		</ul> <!-- end ul#nav -->
	<?php }
	else echo($secondaryNav); ?>
</div>
<!--End category navigation-->