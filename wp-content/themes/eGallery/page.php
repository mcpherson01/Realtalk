<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<!--Start Post-->
				<div class="post-wrapper">
					<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eGallery'), get_the_title()) ?>">
						<?php the_title(); ?>
						</a></h1>
					<div style="clear: both;"></div>

					<?php $width = (int) get_option('egallery_thumbnail_width_pages');
						  $height = (int) get_option('egallery_thumbnail_height_pages');
						  $classtext = 'single-image';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('egallery_page_thumbnails') == 'on') { ?>
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
					<?php }; ?>

					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','eGallery').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link(esc_html__('Edit this page','eGallery')); ?>

					<div style="clear: both;"></div>

				</div>
			<?php endwhile; endif; ?>
			<?php if (get_option('egallery_show_pagescomments') == 'on') { ?>
				<div class="post-wrapper">
					<?php comments_template('', true); ?>
				</div>
			<?php }; ?>

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