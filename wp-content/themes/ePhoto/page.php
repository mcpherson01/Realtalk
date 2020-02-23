<?php get_header(); ?>

<div id="container2">
<div id="left-div2">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
		<!--Start Post-->
		<div class="post-wrapper">
			<h1 class="post-title2"><?php the_title(); ?></h1>
			<div style="clear: both;"></div>

			<?php if (get_option('ephoto_page_thumbnails') == 'on') { ?>
				<?php $width = (int) get_option('ephoto_thumbnail_width_pages');
					  $height = (int) get_option('ephoto_thumbnail_height_pages');
					  $classtext = 'blogthumbnail';
					  $titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				$thumb = $thumbnail["thumb"];  ?>

					<?php if($thumb <> '') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<?php } ?>
			<?php } ?>

			<?php the_content(); ?>
			<br class="clearfix"/>
		</div>
		<?php if (get_option('ephoto_show_pagescomments') == 'on') { ?>
			<div class="comments-wrapper">
				<?php comments_template('', true); ?>
			</div>
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/comments-bottom-<?php echo esc_attr(get_option('ephoto_color_scheme')); ?>.gif" alt="comments-bottom" style="float: left;" />
		<?php }; ?>
    <?php endwhile; ?>
    <!--End Post-->
    <?php else : ?>
		<?php get_template_part('includes/no-results'); ?>
    <?php endif; ?>
</div>

<?php get_sidebar(); ?>
</div>

	<div id="bottom">
		<?php get_template_part('includes/footer-area'); ?>
    </div>

<?php get_footer(); ?>

</body>
</html>