<?php get_header(); ?>

<div id="container">
<div id="left-div">
    <div id="left-inside">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Start Post-->
			<div class="post-wrapper">
				<?php get_template_part('includes/share'); ?>
				<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
					<?php the_title(); ?>
					</a></h3>
				<div style="clear: both;"></div>

				<?php $width = (int) get_option('influx_thumbnail_width_pages');
					  $height = (int) get_option('influx_thumbnail_height_pages');
					  $classtext = 'alignleft';
					  $titletext = get_the_title();

					  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					  $thumb = $thumbnail["thumb"]; ?>

				<?php if($thumb <> '' && get_option('influx_page_thumbnails') == 'on') { ?>
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
				<?php }; ?>

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Influx').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','Influx')); ?>

				<div style="clear: both;"></div>
			</div>

			<?php if (get_option('influx_show_pagescomments') == 'on') { ?>
				<div class="post-wrapper" style="margin-top: 10px;">
					<?php comments_template('', true); ?>
				</div>
			<?php }; ?>
		<?php endwhile; endif; ?>
    </div>
</div>
<!--Begin Sidebar-->
<?php get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>