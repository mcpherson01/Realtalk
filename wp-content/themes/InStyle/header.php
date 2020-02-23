<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link href='https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:light,regular,bold&amp;subset=latin' rel='stylesheet' type='text/css'/>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, a.readmore, a.readmore span, #header, span.overlay, #search-form, ul.nav ul, ul.nav span.top-arrow, ul.nav ul li a:hover, #content-top, #content-bottom, span.post-overlay, span.avatar-overlay, .comment-arrow, .service-top, .service-description-bottom, .service-description');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7style.css" />
<![endif]-->
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie8style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div id="background">
		<div id="backgrounds">
			<?php
				if ( is_home() ) {
					$et_bg_images = get_option('instyle_home_bg_images');
				} elseif ( is_category() ) {
					$et_bg_images = get_option('instyle_category_bg_images');
				} elseif ( is_archive() ) {
					$et_bg_images = get_option('instyle_archive_bg_images');
				} elseif ( is_search() ) {
					$et_bg_images = get_option('instyle_search_bg_images');
				} elseif ( is_tag() ) {
					$et_bg_images = get_option('instyle_tag_bg_images');
				} elseif ( is_single() || is_page() ) {
					$et_instyle_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_instyle_settings',true) );
					$et_bg_images = isset( $et_instyle_settings['et_fs_bg_images'] ) ? $et_instyle_settings['et_fs_bg_images'] : '';
				}

				if ( $et_bg_images == '' )
					$et_bg_images = get_option('instyle_default_bg_images') <> '' ? get_option('instyle_default_bg_images') : apply_filters('et_default_images',get_template_directory_uri() . '/images/landscape.png');

				$et_backgrounds = explode(",", $et_bg_images);
				foreach ( $et_backgrounds as $et_background ){
					echo '<img src="'.esc_attr( trim($et_background) ).'" alt=""/>';
				}
			?>
		</div> <!-- end #backgrounds -->

		<div id="header" class="clearfix">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('instyle_logo') <> '') ? get_option('instyle_logo') : get_template_directory_uri().'/images/logo.png'; ?>
				<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/>
			</a>
			<div id="header-right">
				<?php $menuClass = 'nav';
				$menuID = 'top-menu';
				$primaryNav = '';
				if (function_exists('wp_nav_menu')) {
					$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
				};
				if ($primaryNav == '') { ?>
					<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
						<?php if (get_option('instyle_home_link') == 'on') { ?>
							<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','InStyle') ?></a></li>
						<?php } ?>

						<?php show_page_menu($menuClass,false,false); ?>
						<?php show_categories_menu($menuClass,false); ?>
					</ul> <!-- end ul#nav -->
				<?php }	else echo($primaryNav); ?>

				<div id="search-form">
					<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="text" value="<?php esc_attr_e('Search this site...','InStyle'); ?>" name="s" id="searchinput" />
						<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/search_btn.png" id="searchsubmit" />
					</form>
				</div> <!-- end #search-form -->
			</div> <!-- end #header-right -->
		</div> <!-- end #header -->

		<div id="container"<?php global $fullwidth; if ( is_page_template('page-full.php') || $fullwidth ) echo ' class="fullwidth"'; ?>>
