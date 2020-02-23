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
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, .entry p.date, span.overlay, span.author, span.categories, span.comments-number');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div id="page-wrap">
		<div id="header" class="clearfix">

			<!-- LOGO -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('personalpress_logo') <> '') ? get_option('personalpress_logo') : get_template_directory_uri().'/images/logo.png'; ?>
				<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>
			<div class="separator"></div>

			<!-- TOP MENU -->
			<?php $menuClass = 'nav superfish clearfix';
			$primaryNav = '';

			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
				$primaryNav = preg_replace('/(<a[^>]+>)([^\/]+)\/\/\/([^<]+)(<\/a>)/', '$1<strong>$2</strong><span>$3</span>$4', $primaryNav);
			};
			if ($primaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('personalpress_home_link') == 'on') { ?>
						<li <?php if (is_front_page()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><strong><?php esc_html_e('Home','PersonalPress'); ?></strong><?php if(get_option('personalpress_show_homelink_description') == 'on') { ?><span><?php echo(get_option('personalpress_home_description')); ?></span><?php }; ?></a></li>
					<?php }; ?>

					<?php if(get_option('personalpress_swap_navbar') == 'on') { ?>
						<?php show_categories_menu($menuClass,false); ?>
					<?php } else { ?>
						<?php show_page_menu($menuClass,false,false); ?>
					<?php }; ?>
				</ul> <!-- end ul#nav -->
			<?php }
			else echo($primaryNav); ?>

		</div> <!-- end #header-->

		<div id="content" class="clearfix">