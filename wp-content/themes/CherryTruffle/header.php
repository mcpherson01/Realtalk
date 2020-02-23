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
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie6style-<?php echo esc_attr(get_option('cherrytruffle_color_scheme'));?>.css" />
<script defer type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/pngfix.js"></script>
<![endif]-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="header">
    <!--This controls the categories navigation bar-->
    <div id="categories">
		<!-- Page Menu -->
		<?php $menuClass = 'nav superfish';
		$primaryNav = '';
		if (function_exists('wp_nav_menu')) {
			$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
		};
		if ($primaryNav == '') { ?>
			<ul class="<?php echo esc_attr( $menuClass ); ?>">
				<?php if (get_option('cherrytruffle_swap_navbar') == 'false') { ?>
					<?php show_categories_menu($menuClass,false); ?>
				<?php } else { ?>
					<?php if (get_option('cherrytruffle_home_link') == 'on') { ?>
						<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','CherryTruffle') ?></a></li>
					<?php }; ?>

					<?php show_page_menu($menuClass,false,false); ?>
				<?php } ?>
			</ul> <!-- end ul#nav -->
		<?php }
		else echo($primaryNav); ?>
    </div>
    <!--End category navigation-->
	<div id="header-inside">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('cherrytruffle_logo') <> '') ? get_option('cherrytruffle_logo') : get_template_directory_uri().'/images/logo.png'; ?><img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a>
		<?php if (get_option('cherrytruffle_display_social') == 'on') { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/separate.png" alt="separate" style="float: left; margin: 5px 15px 0px 15px;" />
			<?php if (get_option('cherrytruffle_icon_rss_display') == 'false') { ?>
			<?php { echo ''; } ?>
			<?php } else { get_template_part('includes/icon-rss'); } ?>
			<?php if (get_option('cherrytruffle_icon_twitter_display') == 'false') { ?>
			<?php { echo ''; } ?>
			<?php } else { get_template_part('includes/icon-twitter'); } ?>
			<?php if (get_option('cherrytruffle_icon_facebook_display') == 'false') { ?>
			<?php { echo ''; } ?>
			<?php } else { get_template_part('includes/icon-facebook'); } ?>
			<?php if (get_option('cherrytruffle_icon_myspace_display') == 'false') { ?>
			<?php { echo ''; } ?>
			<?php } else { get_template_part('includes/icon-myspace'); } ?>
			<?php if (get_option('cherrytruffle_icon_linkedin_display') == 'false') { ?>
			<?php { echo ''; } ?>
			<?php } else { get_template_part('includes/icon-linkedin'); } ?>
			<?php if (get_option('cherrytruffle_icon_stumble_display') == 'false') { ?>
			<?php { echo ''; } ?>
			<?php } else { get_template_part('includes/icon-stumble'); } ?>
			<?php if (get_option('cherrytruffle_icon_youtube_display') == 'false') { ?>
			<?php { echo ''; } ?>
			<?php } else { get_template_part('includes/icon-youtube'); } ?>
		<?php }; ?>

        <?php if (get_option('cherrytruffle_display_search') == 'on') { ?>
			<div class="search_bg">
				<div id="search">
					<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="padding:0px 0px 0px 0px; margin:0px 0px 0px 0px">
						<input type="text"  name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
						<input type="image" class="input" src="<?php echo get_template_directory_uri(); ?>/images/search-button.png" value="submit"/>
					</form>
				</div>
			</div>
        <?php }; ?>

        <div style="clear: both;"></div>
        <div id="slogan">
            <?php echo esc_html( get_bloginfo('description') ); ?>
        </div>
        <?php if (get_option('cherrytruffle_468_enable') == 'on') { ?>
			<?php get_template_part('includes/468x60'); ?>
        <?php } ?>
    </div>
</div>
<div style="clear: both;"></div>

<!--This controls pages navigation bar-->
<div id="pages">
	<?php $menuClass = 'nav superfish';
	$menuID = 'nav2';
	$secondaryNav = '';
	if (function_exists('wp_nav_menu')) {
		$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
	};
	if ($secondaryNav == '') { ?>
		<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
			<?php if (get_option('cherrytruffle_swap_navbar') == 'false') { ?>
				<?php if (get_option('cherrytruffle_home_link') == 'on') { ?>
					<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','CherryTruffle') ?></a></li>
				<?php }; ?>

				<?php show_page_menu($menuClass,false,false); ?>
			<?php } else { ?>
				<?php show_categories_menu($menuClass,false); ?>
			<?php } ?>
		</ul> <!-- end ul#nav -->
	<?php }
	else echo($secondaryNav); ?>
</div>
<!--End pages navigation-->

<div id="wrapper2" <?php global $fullwidth; if (is_page_template('page-full.php') || $fullwidth ) echo" class='no_sidebar'";?> >
	<?php if (get_option('cherrytruffle_leader_enable') == 'on') { ?>
		<div style="margin: 30px 100px;">
			<a href="<?php echo esc_url(get_option('cherrytruffle_leader_url')); ?>"><img src="<?php echo esc_attr(get_option('cherrytruffle_leader_image')); ?>" alt="banner" style="border: none;" /></a>
		</div>
	<?php } ?>