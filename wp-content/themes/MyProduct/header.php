<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('#logo, #images img, #testimonial, .testimonials, .service img.icon, #footer .widget ul li, #switcher-left, #switcher-right, #switcher-content a, #switcher-content a.active');</script>
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
<body<?php if (is_front_page() || is_home()) echo(' id="home"'); ?> <?php body_class(); ?>>
	<div id="header-wrapper">
		<div id="header">

			<div class="container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('myproduct_logo') <> '') ? get_option('myproduct_logo') : get_template_directory_uri().'/images/logo.png'; ?>
					<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>

				<div id="topnav">
					<div id="topmenu-leftbg"></div>
					<div id="topmenu">
						<?php $menuClass = 'superfish nav';
						$primaryNav = '';

						if (function_exists('wp_nav_menu')) {
							$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
						};
						if ($primaryNav == '') { ?>
							<ul class="<?php echo esc_attr( $menuClass ); ?>">
								<?php if (get_option('myproduct_home_link') == 'on') { ?>
									<li <?php if (is_front_page() || is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="homelink"><span><?php esc_html_e('Home','MyProduct'); ?></span></a></li>
								<?php }; ?>

								<?php show_categories_menu($menuClass,false); ?>

								<?php show_page_menu($menuClass,false,false); ?>
							</ul> <!-- end ul#nav -->
						<?php }
						else echo($primaryNav); ?>

						<!-- Start Searchbox -->
						<div id="search-form">
							<form method="get" id="searchform1" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
								<input type="text" value="<?php esc_attr_e('search this site...','MyProduct'); ?>" name="s" id="searchinput" />
							</form>
						</div>
						<!-- End Searchbox -->
					</div> <!-- end #topmenu -->
					<div id="topmenu-rightbg"></div>
				</div> <!-- end #topnav -->

				<?php if (is_front_page() || is_home()) { ?>

					<!-- WELCOME PAGE -->
					<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('myproduct_welcome_page'))) );
						if(have_posts()) : while (have_posts()) : the_post(); ?>
							<div id="top-box">
								<h2><?php the_title(); ?></h2>
								<?php global $more;
                                $more = 0; the_content(''); ?>
                                <?php $button1 = get_post_meta(get_the_ID(), 'Button', true);
									  $button1Url = get_post_meta(get_the_ID(), 'Buttonurl', true);
									  $button2 = get_post_meta(get_the_ID(), 'Button2', true);
								      $button2Url = get_post_meta(get_the_ID(), 'Button2url', true); ?>

								<?php if ($button1 <> '') { ?>
									<a href="<?php echo esc_url($button1Url); ?>" class="featured-button"><span><?php echo esc_html($button1); ?></span></a>
								<?php }; ?>
								<?php if ($button2 <> '') { ?>
									<a href="<?php echo esc_url($button2Url); ?>" class="featured-button"><span><?php echo esc_html($button2); ?></span></a>
								<?php }; ?>
							</div> <!-- end #top-box -->
						<?php endwhile; endif; wp_reset_query(); ?>
					<!-- end WELCOME PAGE -->


					<!-- PRODUCT IMAGES SWITCHER -->
					<div id="image_slideshow">
						<div id="images">
							<?php $productsNumber = (int) get_option('myproduct_product_images_number');
							for ($i = 1; $i <= $productsNumber; $i++) { ?>
								<img src="<?php echo esc_attr(get_option('myproduct_product_image_'.$i)); ?>" alt="" />
							<?php }; ?>
						</div> <!-- end #images -->

						<?php if ($productsNumber > 1) { ?>
							<div id="switcher">
								<div id="switcher-left"></div>

								<div id="switcher-content">
									<?php for ($i = 1; $i <= $productsNumber; $i++) { ?>
										<a href="#"<?php if($i==1) echo(' class="active"'); ?>><?php echo $i; ?></a>
									<?php }; ?>
								</div> <!-- end #switcher-content -->

								<div id="switcher-right"></div>
							</div><!-- end #switcher -->
						<?php }; ?>
					</div> <!-- end #image_slideshow -->
					<!-- end PRODUCT IMAGES SWITCHER -->

				<?php } else get_template_part('includes/pagetop'); ?>

			</div> <!-- end .container -->

		</div> <!-- end #header -->
	</div> <!-- end #header-wrapper -->

	<div id="content"<?php global $fullwidth; if ( is_page_template('page-full.php') || $fullwidth ) echo 'class="fullwidth-page"'; ?>>
		<div id="content-wrap">
			<div class="container clearfix">