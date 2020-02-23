<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, a.bubble, .overlay, span.comment-count, #sidebar .search, .entry .post, .entry-top, .share .share_button, .share a.arrow, .share .buttons, .share .buttons a span.tooltip span.left-arrow, .share img, .entry-bottom, .comment-icon .bubble, .comment-icon, .widget-content, div.avatar span.avatar-overlay');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7style.css" />
<![endif]-->

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/audio-player.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/League_Gothic_400.font.js" type="text/javascript"></script>
<script type="text/javascript">
	<?php if ( get_option('lightbright_cufon') == 'on' ) { ?>
		Cufon.replace('ul.nav li a',{textShadow: '-1px -1px 1px #031112', hover: { textShadow: '-1px -1px 1px #031112'}})('h1')('h2')('h3')('h4')('h5')('h6')('span.date')('span.comment-count')('.widget h3.title', {textShadow: '-1px -1px 1px #032328'})('span.fn')('span.fn a')('.wp-pagenavi span', {textShadow: '-1px -1px 1px rgba(0,0,0,0.5)'})('.wp-pagenavi a.page',{textShadow: '-1px -1px 1px rgba(0,0,0,0.5)'});
	<?php }; ?>
	AudioPlayer.setup("<?php echo get_template_directory_uri(); ?>/js/player.swf", { width: 380 });
</script>

</head>
<?php $et_body_class = get_option('lightbright_cufon') == 'false' ? ' class="cufon-disabled"' : ''; ?>
<body <?php body_class( $et_body_class ); ?>>
	<div id="container">
		<div id="header" class="clearfix">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('lightbright_logo') <> '') ? get_option('lightbright_logo') : get_template_directory_uri().'/images/logo.png'; ?>
				<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>
			<p id="slogan"><?php bloginfo('description'); ?></p>

			<?php $menuClass = 'nav superfish clearfix';
			$primaryNav = '';

			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul class="<?php echo esc_attr( $menuClass ); ?>">
					<?php if (get_option('lightbright_home_link') == 'on') { ?>
						<li class="page_item<?php if(is_home()) echo(' current_page_item'); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','LightBright') ?></a></li>
					<?php }; ?>

					<?php show_page_menu($menuClass,false,false);
					  	  show_categories_menu($menuClass,false); ?>
				</ul> <!-- end ul.nav -->
			<?php }
			else echo($primaryNav); ?>
		</div> <!-- end #header -->

		<div id="content-area" class="clearfix">

			<div id="main-area">