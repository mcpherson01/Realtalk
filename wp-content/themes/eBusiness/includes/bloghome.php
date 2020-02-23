<?php get_header(); ?>

<?php if (get_option('ebusiness_categories') == 'on') : ?>
	<div id="categories"> <img src="<?php echo get_template_directory_uri(); ?>/images/categories-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left;" />
		<?php $menuClass = 'nav superfish';
		$menuID = 'nav2';
		$secondaryNav = '';
		if (function_exists('wp_nav_menu')) {
			$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
		};
		if ($secondaryNav == '') { ?>
			<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
				<?php show_categories_menu($menuClass,false); ?>
			</ul> <!-- end ul#nav -->
		<?php }
		else echo($secondaryNav); ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/categories-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left;" /> </div>
<?php endif; ?>

<div id="container">
    <div id="left-div">
        <?php if (get_option('ebusiness_full_post') == 'on') { ?>
        <?php get_template_part('includes/blogstyle'); ?>
        <?php } else { get_template_part('includes/defaultindex'); } ?>
    </div>
    <?php get_sidebar(); ?>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left; margin-top: 15px;" /> </div>
<?php get_footer(); ?>
</body></html>