<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('div.info,#cats-menu ul,#page-menu ul');</script>
<?php if (is_single()) { ?><script type="text/javascript">DD_belatedPNG.fix('.post-meta-bottom p,.reply-container,.bubble');</script><?php }; ?>
<?php if (get_option('enews_blog_style') == 'on') { ?><script type="text/javascript">DD_belatedPNG.fix('.post-meta-bottom p');</script><?php };?>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie7style.css" />
<![endif]-->

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php if (is_home()) echo('id="home"');?> <?php body_class(); ?>>
	<div id="header">
		<div class="container">
			<!-- Page Menu -->
			<?php $menuClass = 'nav superfish';
			$menuID = 'page-menu';
			$primaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('enews_swap_navbar') == 'false') { ?>
						<?php if (get_option('enews_home_link') == 'on') { ?>
							<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','eNews') ?></a></li>
						<?php }; ?>

						<?php show_page_menu($menuClass,false,false); ?>
					<?php } else { ?>
						<?php show_categories_menu($menuClass,false); ?>
					<?php } ?>
				</ul> <!-- end ul#nav -->
			<?php }
			else echo($primaryNav); ?>

			<!-- Logo -->
			<br class="clear"/>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('enews_logo') <> '') ? get_option('enews_logo') : get_template_directory_uri().'/images/logo.jpg'; ?>
				<img src="<?php echo esc_attr($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>
			<div class="clear"></div>

			<!-- Categories Menu -->
			<?php $menuClass = 'nav superfish';
			$menuID = 'cats-menu';
			$secondaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
			};
			if ($secondaryNav == '') { ?>
				<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('enews_swap_navbar') == 'false') { ?>
						<?php show_categories_menu($menuClass,false); ?>
					<?php } else { ?>
						<?php if (get_option('enews_home_link') == 'on') { ?>
							<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','eNews') ?></a></li>
						<?php }; ?>

						<?php show_page_menu($menuClass,false,false); ?>
					<?php } ?>
				</ul> <!-- end ul#nav -->
			<?php }
			else echo($secondaryNav); ?>

		</div> <!-- end container -->
	</div> <!-- end header -->

	<div id="content">
		<div class="container">

			<div id="subscribe">
				<?php if (get_option('enews_feedburner') == 'on') { ?>
					<p><em><?php esc_html_e('subscribe','eNews') ?>: </em><a href="<?php echo esc_url(get_option('enews_feedburner_rss')); ?>"><?php esc_html_e('Posts','eNews') ?></a> | <a href="<?php if (get_option('enews_feedburner_comments') <> '') { echo esc_attr(get_option('enews_feedburner_comments')); } else { bloginfo('comments_rss2_url'); } ?>"><?php esc_html_e('Comments','eNews') ?></a> | <a href="<?php echo esc_attr(get_option('enews_feedburner_email')); ?>"><?php esc_html_e('Email','eNews') ?></a></p>
				<?php } else { ?>
					<p><em><?php esc_html_e('subscribe','eNews') ?>: </em><a href="<?php bloginfo('rss2_url'); ?>"><?php esc_html_e('Posts','eNews') ?></a> | <a href="<?php bloginfo('comments_rss2_url'); ?>"><?php esc_html_e('Comments','eNews') ?></a></p>
				<?php }; ?>

				<!-- Search form -->
				<div id="search">
					<h3><?php esc_html_e('search the site','eNews') ?></h3>
					<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
						<fieldset>
							<input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="search-field" />
						</fieldset>
					</form>
				</div> <!-- end search -->

				<div class="clear"></div>

			</div> <!-- end subscribe -->

			<?php if (get_option('enews_leader_enable') == 'on') { ?>
				<div class="<?php if (is_home()) echo('leader-home'); else echo('leader') ?>"><a href="<?php echo esc_url(get_option('enews_leader_url')); ?>"><img src="<?php echo esc_attr(get_option('enews_leader_image')); ?>" alt="leader" /></a></div>
            <?php } ?>