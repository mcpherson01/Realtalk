<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/iestyle.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie6style.css" />
<script defer type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/pngfix.js"></script>
<![endif]-->

</head>

<body <?php body_class(); ?>>
<div class="logo"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('bold_logo') <> '') ? get_option('bold_logo') : get_template_directory_uri().'/images/logo.gif'; ?>
	<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo-image"/></a>
<?php if (get_option('bold_display_slogan') == 'on') { ?>
<img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo esc_attr(get_option('bold_color_scheme'));?>/slogan-left.gif" alt="logo" style="float: left; margin-top: 3px;" />
<div class="slogan">
    <?php echo esc_html( get_bloginfo('description') ); ?>
</div>
<img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo esc_attr(get_option('bold_color_scheme'));?>/slogan-right.gif" alt="logo" style="float: left; margin-top: 3px;" />
<?php }; ?>
</div>

<!--This controls pages navigation bar-->
<div id="pages">
    <div id="pages-inside">
			<?php $menuClass = 'nav superfish';
			$primaryNav = '';

			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('bold_home_link') == 'on') { ?>
						<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','Bold') ?></a></li>
					<?php }; ?>

					<?php
					if (get_option('bold_swap_navbar') == 'false') {
						show_page_menu($menuClass,false,false);
					} else {
						show_categories_menu($menuClass,false);
					}; ?>
				</ul> <!-- end ul.nav -->
			<?php }
			else echo($primaryNav); ?>

            <img src="<?php echo get_template_directory_uri(); ?>/images/search-icon.gif" alt="search" id="search-icon" />

            <div id="search-wrap">
            <div id="search-body">

                        <div class="search_bg">
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
                    <div>
                        <input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" />
                        <input type="submit" id="searchsubmit" value="<?php esc_attr_e('Search','Bold') ?>" />
                    </div>
                </form>
            </div>

            </div>
            </div>
    </div>
</div>
<div style="clear: both;"></div>
<!--End pages navigation-->
<div id="bodywrap">
<div id="bottom-bg">
<div id="wrapper2">