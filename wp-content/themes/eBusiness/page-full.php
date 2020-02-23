<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>

<?php if (get_option('ebusiness_blog_style') == 'on') : ?>

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
			<img src="<?php echo get_template_directory_uri(); ?>/images/categories-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left;" />
		</div>
	<?php endif; ?>

<?php endif; ?>

<div id="container">
    <div id="left-div-full">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <!--Start Post-->
        <div class="home-post-wrap-2">
            <h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>
            <?php $desc = get_post_meta($post->ID, 'Description', $single = true); ?>
            <?php if($desc != '') { ?>
            <div class="post-info-wrap"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> <span class="post-info"><?php echo esc_html($desc); ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
            <?php } ?>
            <div style="clear: both;"></div>

			<?php if (get_option('ebusiness_page_thumbnails') == 'on') { ?>

				<?php $width = (int) get_option('ebusiness_thumbnail_width_pages');
					  $height = (int) get_option('ebusiness_thumbnail_height_pages');
					  $classtext = 'thumbnail';
					  $titletext = get_the_title();

				      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					  $thumb = $thumbnail["thumb"];  ?>

				<?php if($thumb != '') { ?>
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				<?php } ?>

			<?php } ?>

            <?php the_content(esc_html__('Read the rest of this entry &raquo;','eBusiness')); ?>
			<?php if (get_option('ebusiness_foursixeight') == 'on') { ?>
            <?php get_template_part('includes/468x60'); ?>
            <?php } ?>

			<?php if (get_option('ebusiness_show_pagescomments') == 'on') { ?>
				<div style="clear: both;"></div>
				<?php comments_template('', true); ?>
			<?php }; ?>
        </div>
        <?php endwhile; ?>
        <!--End Post-->
        <p class="pagination">
            <?php next_posts_link(esc_html__('&laquo; Previous Entries','eBusiness')) ?>
		<?php previous_posts_link(esc_html__('Next Entries &raquo;','eBusiness')) ?>
        </p>
        <?php else : ?>
        <h2 align="center"><?php esc_html_e('Not Found','eBusiness') ?></h2>
        <p align="center"><?php esc_html_e('Sorry, but the page you requested could not be found.','eBusiness') ?></p>
        <?php endif; ?>
    </div>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left; margin-top: 15px;" /> </div>
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body></html>