<div id="container">
	<div id="left-div">
		<div id="left-inside">

			<?php if (is_category()) { ?>
				<span class="current-category">
					<?php single_cat_title(esc_html__('Currently Browsing: ','GrungeMag'), 'display'); ?>
				</span>
			<?php }; ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="home-post-wrap2">
					<div style="clear: both;"></div>

					<div class="single-entry">
						<?php get_template_part('includes/postinfo'); ?>
						<div style="clear: both;"></div>

						<h2 class="titles<?php if (get_option('grungemag_blog_style')=='false') echo('2'); else echo('3'); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>">
							<?php the_title() ?></a></h2>
						<div style="clear: both;"></div>

						<?php $thumb = '';
							  $width = 60;
							  $height = 60;
							  $classtext = 'no_border';
							  $titletext = get_the_title();

							  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							  $thumb = $thumbnail["thumb"]; ?>

						<?php if (get_option('grungemag_thumbnails') == 'false' && get_option('grungemag_blog_style')=='on') $thumb = ''; ?>

						<?php if($thumb != '') { ?>
							<div class="thumbnail-div-3">
								<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								</a>
							</div>
						<?php }; ?>

						<?php if (get_option('grungemag_blog_style')=='false') truncate_post(310);
							  else the_content(); ?>
						<div style="clear: both;"></div>

						<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>"><?php esc_html_e('Read More','GrungeMag'); ?></a></div>
					</div> <!-- end.single-entry -->
				</div> <!-- end.home-post-wrap2 -->

			<?php endwhile; ?>
				<div style="clear: both;"></div>
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
					  else { ?>
							<p class="pagination">
								<?php next_posts_link(esc_html__('&laquo; Older Entries','GrungeMag')) ?>
								<?php previous_posts_link(esc_html__('Next Entries &raquo;', 'GrungeMag')) ?>
							</p>
				<?php } ?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
			 <div style="clear: both;"></div>
		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>