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
<![endif]-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!--This controls pages navigation bar-->
<div id="pages">
    <div id="pages-inside">
        <div id="pages-inside-2">
			<?php $menuClass = 'nav superfish';
			$menuID = 'nav2';
			$primaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('puretype_home_link') == 'on') { ?>
						<li class="page_item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="title" title="home again woohoo"><?php esc_html_e('Home','PureType') ?></a></li>
					<?php }; ?>

					<?php show_page_menu($menuClass,false,false); ?>
				</ul> <!-- end ul#nav -->
			<?php }
			else echo($primaryNav); ?>

            <div class="search_bg">
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
                    <div>
                        <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
                        <input type="submit" id="searchsubmit" value="<?php esc_attr_e('Search','PureType') ?>" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="clear: both;"></div>
<!--End pages navigation-->
<div id="wrapper2" <?php global $fullwidth; if (is_page_template('page-full.php') || $fullwidth) echo (' class="no_sidebar"'); ?>>
	<div class="logo"> <span class="bluetitle"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html(get_option('puretype_title_red')); ?></a></span><span class="redtitle"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_attr(get_option('puretype_title_blue')); ?></a></span> </div>
	<div class="slogan">
		<?php bloginfo('description'); ?>
	</div>
	<!--This controls the categories navigation bar-->
	<div id="categories">
		<?php $menuClass = 'nav superfish';
		$secondaryNav = '';
		if (function_exists('wp_nav_menu')) {
			$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
		};
		if ($secondaryNav == '') { ?>
			<ul class="<?php echo esc_attr( $menuClass ); ?>">
				<?php show_categories_menu($menuClass,false); ?>
			</ul> <!-- end ul.nav -->
		<?php }
		else echo($secondaryNav); ?>
	</div>
	<!--End category navigation-->