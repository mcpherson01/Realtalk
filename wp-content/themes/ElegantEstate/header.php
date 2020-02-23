<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, #wrapper, #header, div#top-menu, #featured .overlay, #featured, #featured .description, #featured .description span.price, #featured span.price span, a.readmore, a.readmore span, div.hr, #controllers span#active-arrow, #featured a#left-arrow, #featured a#right-arrow, #content-top, .entry div.hr2, span.price2, span.price2 span, #content-bottom, #sidebar h4.widgettitle, #listings-bottom, #listings, input.view-button, .entry div.thumbnail span.overlay2, body.index #content-top, #menu-bg, body.index #top-index-overlay, span.overlay, .reply-container, .reply-container a, #product-thumb-items a#left-arrow , #product-thumb-items a#right-arrow');</script>
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

<?php
	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<div id="container"<?php global $fullwidth; if ( is_page_template('page-full.php') || $fullwidth ) echo 'class="fullwidth"'; ?>>
			<div id="header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('elegantestate_logo') <> '') ? get_option('elegantestate_logo') : get_template_directory_uri().'/images/logo.png'; ?>
					<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>
				<div id="top-menu">
					<?php $menuClass = 'nav';
					$menuID = 'primary';
					$primaryNav = '';
					if (function_exists('wp_nav_menu')) {
						$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
					};
					if ($primaryNav == '') { ?>
						<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
							<?php if (get_option('elegantestate_swap_navbar') == 'false') { ?>
								<?php if (get_option('elegantestate_home_link') == 'on') { ?>
									<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','ElegantEstate') ?></a></li>
								<?php }; ?>

								<?php show_page_menu($menuClass,false,false); ?>
							<?php } else { ?>
								<?php show_categories_menu($menuClass,false); ?>
							<?php } ?>
						</ul> <!-- end ul#nav -->
					<?php }
					else echo($primaryNav); ?>
				</div> <!-- end #top-menu -->

				<div id="secondary-menu">
					<?php $menuClass = 'nav';
						$menuID = 'secondary';
						$secondaryNav = '';
						if (function_exists('wp_nav_menu')) {
							$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
						};
						if ($secondaryNav == '') { ?>
							<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
								<?php if (get_option('elegantestate_swap_navbar') == 'false') { ?>
									<?php show_categories_menu($menuClass,false); ?>
								<?php } else { ?>
									<?php if (get_option('elegantestate_home_link') == 'on') { ?>
										<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','ElegantEstate') ?></a></li>
									<?php }; ?>

									<?php show_page_menu($menuClass,false,false); ?>
								<?php } ?>
							</ul> <!-- end ul#nav -->
						<?php }
						else echo($secondaryNav); ?>
				</div> <!-- end #secondary-menu -->
			</div> 	<!-- end #header -->