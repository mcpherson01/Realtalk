<?php $colorSchemePath = '';
global $shortname, $default_colorscheme;
$colorScheme = get_option($shortname . '_color_scheme');
if ($colorScheme <> $default_colorscheme) $colorSchemePath = strtolower($colorScheme) . '/'; ?>
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
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, #slider, #platforms-left, #platforms-right, #p-icons img, #buy-image img, #buy-image a#buy-now, div#controllers a, #side-tabs, #side-tabs ul, img#logo2, #buy-image2 a#get-our-app, #buy-image2 img, #breadcrumbs #search-form, div.meta-info, a.readmore2, p.meta, p.meta2, p.meta3, a.readmore2 span, h3#comments, .reply-container, .reply-container a');</script>
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
<body<?php if (is_home() || is_front_page()) echo(' id="home"'); ?> <?php body_class(); ?>>

<div id="header-top">
	<div class="container clearfix">
		<?php if (!is_home() && !is_front_page()) { ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('myapptheme_logo2') <> '') ? get_option('myapptheme_logo2') : get_template_directory_uri() .'/images/logo2.png'; ?>
				<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo2"/>
			</a>
		<?php }; ?>

		<!-- Start Menu -->
		<?php $menuClass = 'nav superfish clearfix';
		$primaryNav = '';

		if (function_exists('wp_nav_menu')) {
			$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
		};
		if ($primaryNav == '') { ?>
			<ul class="<?php echo esc_attr( $menuClass ); ?>">
				<?php if (get_option('myapptheme_home_link') == 'on') { ?>
					<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','MyAppTheme') ?></a></li>
				<?php }; ?>

				<?php show_page_menu($menuClass,false,false);
					  show_categories_menu($menuClass,false); ?>
			</ul> <!-- end ul.nav -->
		<?php }
		else echo($primaryNav); ?>

		<!-- End Menu -->
	</div> 	<!-- end .container -->
</div> 	<!-- end #header-top -->


<?php if (is_home() || is_front_page()) { ?>

	<div id="header">
		<div id="top-shadow"> </div>
			<div class="container clearfix">
				<!-- Start Logo -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('myapptheme_logo') <> '') ? get_option('myapptheme_logo') : get_template_directory_uri().'/images/logo.png'; ?>
					<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>
				<p id="slogan"><?php echo esc_html( get_bloginfo('description') ); ?></p>
				<!-- End Logo -->

				<div class="clear"></div>


				<div id="description">
					<?php echo(get_option('myapptheme_header_description')); ?>

					<div id="platforms-left"> </div>
					<div id="platforms-content">
						<p><?php esc_html_e('Supported Platforms','MyAppTheme'); ?></p>
						<div id="p-icons">
							<img src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorScheme == 'Purple' || $colorScheme == 'Black' || $colorScheme == 'Green' ) echo($colorSchemePath); ?>icon1.png" alt="" class="icon" />
							<img src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorScheme == 'Purple' || $colorScheme == 'Black' || $colorScheme == 'Green'  ) echo($colorSchemePath); ?>icon2.png" alt="" class="icon" />
							<img src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorScheme == 'Purple' || $colorScheme == 'Black' || $colorScheme == 'Green' ) echo($colorSchemePath); ?>icon3.png" alt="" class="icon" />
							<img src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorScheme == 'Purple' || $colorScheme == 'Black' || $colorScheme == 'Green' ) echo($colorSchemePath); ?>icon4.png" alt="" class="icon" />
						</div>
					</div>
					<div id="platforms-right"> </div>
				</div> <!-- end #description -->



				<div id="buy-image">

					<img src="<?php echo get_template_directory_uri(); ?>/images/<?php if ( $colorScheme == 'Purple' || $colorScheme == 'Black' ) echo($colorSchemePath); ?>iphone.png" alt="" />

					<?php $buyNowLink = get_option('myapptheme_buynow_url'); ?>
					<a href="<?php if($buyNowLink <> '') echo( esc_url( $buyNowLink ) ); else echo('#'); ?>" id="buy-now"><?php echo esc_html(get_option('myapptheme_buynow_text')); ?></a>
				</div>

				<div id="slider">
					<div class="slide">
						<?php $productsNumber = (int) get_option('myapptheme_product_images_number');
						for ($i = 1; $i <= $productsNumber; $i++) { ?>
							<?php $thumbnail = esc_url( get_option('myapptheme_product_image_'.$i) );
							if (get_option('myapptheme_product_timthumb') == 'on') $output =  et_new_thumb_resize( et_multisite_thumbnail($thumbnail), 205, 310, '', true );
							else $output = $thumbnail; ?>
							<img src="<?php echo esc_attr( $output ); ?>" alt="" class="thumb" width="205px" height="310px" />
						<?php }; ?>
					</div> <!-- end .slide -->

					<span class="image-overlay"></span>
					<span class="image-overlay2"></span>

					<div id="controllers"></div>
				</div>	<!-- end #slider -->

			</div> 	<!-- end .container -->
		<div id="bottom-shadow"> </div>
	</div> <!-- end #header -->

<?php } else { ?>

	<?php get_template_part('includes/pagetop'); ?>

	<?php get_template_part('includes/breadcrumb'); ?>

<?php }; ?>


<div id="content">
	<div class="container clearfix">