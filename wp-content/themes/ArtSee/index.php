<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="home-post-wrap">
					<?php get_template_part('includes/buttons'); ?>

					<!--Begin Post Single-->
					<div class="entry">
						<?php $width = 573;
						$height = 187;
						$classtext = '';
						$titletext = get_the_title();

						$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
						$thumb = $thumbnail["thumb"]; ?>

						<?php if($thumb != '' && get_option('artsee_thumbnails_index') == 'on') { ?>
							<div class="thumbnail-div">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
							</div> <!-- end .thumbnail-div -->
						<?php }; ?>

						<?php if (get_option('artsee_postinfo1') ) { ?>
							<div class="post-info"><?php esc_html_e('Posted','ArtSee'); ?> <?php if (in_array('author', get_option('artsee_postinfo1'))) { ?> <?php esc_html_e('by','ArtSee'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('artsee_postinfo1'))) { ?> <?php esc_html_e('on','ArtSee'); ?> <?php the_time(esc_attr(get_option('artsee_date_format'))) ?><?php }; ?><?php if (in_array('categories', get_option('artsee_postinfo1'))) { ?> <?php esc_html_e('in','ArtSee'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('artsee_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','ArtSee'), esc_html__('1 comment','ArtSee'), '% '.esc_html__('comments','ArtSee')); ?><?php }; ?></div>
						<?php }; ?>

						<h2 class="titles">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ArtSee'), the_title()) ?>">
								<?php if (get_option('artsee_blog_style') == 'false') { ?>
									<?php truncate_title(40); ?>
								<?php } else { ?>
									<?php the_title(); ?>
								<?php }; ?>
							</a>
						</h2>

						<?php if (get_option('artsee_blog_style') == 'false') { ?>
							<?php truncate_post(580); ?>
						<?php } else { ?>
							<?php the_content(); ?>
						<?php }; ?>
						<div style="clear: both;"></div>

						<div class="readmore">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ArtSee'), the_title()) ?>"><?php esc_html_e('Read More','ArtSee'); ?></a>
						</div> <!-- end .readmore -->
					</div> <!-- end .entry -->
				</div> <!-- end .home-post-wrap -->
				<!--End Post Single-->
			<?php endwhile; ?>
				<div style="clear: both;"></div>
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				else { ?>
				     <?php get_template_part('includes/navigation'); ?>
				<?php } ?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->

	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->

</div> <!-- end #container -->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</div>
</body>
</html>