<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<span class="current-category">
		<?php single_cat_title(esc_html__('Currently Browsing: ','Cion'), 'display'); ?>
		</span>
		<!--Begin recent post (single)-->

		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>

				<div class="home-post-wrap2">
					<h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>">
						<?php the_title(); ?>
						</a></h2>

					<?php if (get_option('cion_postinfo2') ) { ?>
						<div class="post-info"><?php esc_html_e('Posted','Cion') ?> <?php if (in_array('author', get_option('cion_postinfo2'))) { ?> <?php esc_html_e('by','Cion') ?> <?php the_author() ?><?php }; ?><?php if (in_array('date', get_option('cion_postinfo2'))) { ?> <?php esc_html_e('on','Cion') ?> <?php the_time(get_option('cion_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('cion_postinfo2'))) { ?> <?php esc_html_e('in','Cion') ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('cion_postinfo2'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','Cion'), esc_html__('1 comment','Cion'), '% '.esc_html__('comments','Cion')); ?><?php }; ?>
						</div>
					<?php }; ?>

					<div style="clear: both;"></div>

					<?php if (get_option('cion_blog_style') == 'on') { ?>

						<?php if (get_option('cion_thumbnails') == 'on') { ?>

							<?php $width = (int) get_option('cion_thumbnail_width_posts');
								  $height = (int) get_option('cion_thumbnail_height_posts');

								  $classtext = 'thumbnail';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb != '') { ?>

								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>" class="thumbnail-link">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								</a>
							<?php } ?>

						<?php }; ?>

						<?php the_content(); ?>
					<?php } else { ?>

						<?php if (get_option('cion_index_thumbnails') == 'on') { ?>

							<?php $width = (int) get_option('cion_thumbnail_width_index');
								  $height = (int) get_option('cion_thumbnail_height_index');

								  $classtext = 'thumbnail';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb != '') { ?>
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>" class="thumbnail-link">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								</a>
							<?php }; ?>
						<?php }; ?>
						<?php truncate_post(460); ?>
						<div style="clear: both;"></div>

					<?php }; ?>

					<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>"><?php esc_html_e('Read More','Cion') ?></a></div>
				</div>
			<?php endwhile; ?>
			<!--end recent post (single)-->

			<div style="clear: both;"></div>

			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
			else { ?>
				<p class="pagination">
					<?php next_posts_link(esc_html__('&laquo; Previous Entries','Cion')) ?>
					<?php previous_posts_link(esc_html__('Next Entries &raquo;','Cion')) ?>
				</p>
			<?php } ?>

    <?php else : ?>
    <!--If no results are found-->
    <div class="home-post-wrap2">
        <h1><?php esc_html_e('No Results Found','Cion') ?></h1>
        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Cion') ?></p>
    </div>
    <!--End if no results are found-->
    <?php endif; ?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>