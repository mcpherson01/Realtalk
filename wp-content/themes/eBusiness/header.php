<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/iestyle-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.css" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie8style-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie6style-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.css" />
<script defer type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/pngfix.js"></script>
<![endif]-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="bg">
<!--This controls pages navigation bar-->
<div id="pages">
    <div id="pages-inside">

		<a href="<?php echo esc_url( home_url( '/' ) );?>" class="title" title="home again woohoo"><?php $logo = (get_option('ebusiness_logo') <> '') ? get_option('ebusiness_logo') : get_template_directory_uri().'/images/logo-'.esc_attr( get_option('ebusiness_color_scheme') ).'.png'; ?>
			<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo"/></a>

		<?php $menuClass = 'superfish nav';
		$primaryNav = '';

		if (function_exists('wp_nav_menu')) {
			$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
		};
		if ($primaryNav == '') { ?>
			<ul class="<?php echo esc_attr( $menuClass ); ?>">
				<?php if (get_option('ebusiness_home_link') == 'on') { ?>
					<li class="page_item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','eBusiness') ?></a></li>
				<?php } ?>

				<?php if (get_option('ebusiness_blog_link') == 'on') { ?>
					<?php wp_list_categories("include=".get_catId(get_option('ebusiness_blog_cat'))."&depth=1&title_li="); ?>
				<?php }; ?>

				<?php show_page_menu($menuClass,false,false); ?>
			</ul> <!-- end ul.nav -->
		<?php }
		else echo($primaryNav); ?>

    </div>
</div>

<div style="clear: both;"></div>
<!--End pages navigation-->

<div id="wrapper2" <?php if (get_option('ebusiness_blog_style') == 'on') : ?><?php else : ?><?php if (is_home()) : ?>class="wrapper2-home"<?php endif; ?><?php endif; ?>>