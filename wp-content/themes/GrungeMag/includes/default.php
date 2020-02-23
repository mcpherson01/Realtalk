<?php if (get_option('grungemag_show_scroller') == 'on') get_template_part('includes/scroller'); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">

			<?php $show_popular = get_option('grungemag_show_popular');
				  $show_random = get_option('grungemag_show_random');
				  $show_featured = get_option('grungemag_featured'); ?>

			<?php if($show_popular == 'on' || $show_random=='on' || $show_featured=='on') { ?>
				<?php if ($show_featured == 'on') { ?>
					<div class="home-post-wrap-home">
						<?php get_template_part('includes/featured'); ?>
					</div>
				<?php }; ?>

				<?php if($show_popular == 'on' || $show_random=='on') { ?>
					<div class="home-post-wrap-home">
						<?php if($show_popular == 'on') get_template_part('includes/popular'); ?>
						<?php if($show_random == 'on') get_template_part('includes/random'); ?>
					</div>
				<?php }; ?>

				<div style="clear: both;"></div>
			<?php }; ?>

			<!--The following code controls the category boxes-->
			<!--Category Box 1-->
			<?php global $cat_option;
			$cat_option='grungemag_home_cat_one'; ?>
			<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
				  while (have_posts()) : the_post(); ?>
					  <?php get_template_part('includes/category_box'); ?>
			<?php endwhile; wp_reset_query(); ?>
			<!--End Category Box 1-->

			<!--Category Box 2-->
			<?php $cat_option='grungemag_home_cat_two'; ?>
			<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
				  while (have_posts()) : the_post(); ?>
					  <?php get_template_part('includes/category_box'); ?>
			<?php endwhile; wp_reset_query(); ?>
			<!--End Category Box 2-->

			<div style="clear: both;"></div>

			<!--Category Box 3-->
			<?php $cat_option='grungemag_home_cat_three'; ?>
			<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
				  while (have_posts()) : the_post(); ?>
					  <?php get_template_part('includes/category_box'); ?>
			<?php endwhile; wp_reset_query(); ?>
			<!--Category Box 3-->

			<!--Category Box 4-->
			<?php $cat_option='grungemag_home_cat_four'; ?>
			<?php query_posts("posts_per_page=1&cat=".get_catId(get_option($cat_option)));
				  while (have_posts()) : the_post(); ?>
					  <?php get_template_part('includes/category_box'); ?>
			<?php endwhile; wp_reset_query(); ?>
			<!--Category Box 4-->
			<!--End category boxes-->

			<div style="clear: both;"></div>

			<!--Begin recent post (single)-->
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php $thumb = '';
					  $width = 281;
					  $height = 130;
					  $classtext = 'no_border';
					  $titletext = get_the_title();

					  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					  $thumb = $thumbnail["thumb"]; ?>

				<div class="home-post-wrap2">
					<?php get_template_part('includes/postinfo'); ?>

					<h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>">
						<?php the_title(); ?>
						</a></h2>
					<div style="clear: both;"></div>

					<!--Display thumbnail if found-->
					<?php if($thumb != '') { ?>
						<div class="thumbnail-div-home">
							<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
							</a>
						</div>
					<?php }; ?>
					<!--End display thumbnail if found-->
					<?php truncate_post(380); ?>
					<div style="clear: both;"></div>

					<div class="readmore">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>"><?php esc_html_e('Read More','GrungeMag'); ?></a>
					</div>
				</div> <!-- end .home-post-wrap2 -->
			<?php endwhile; ?>
			<!--end recent post (single)-->
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>

		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>