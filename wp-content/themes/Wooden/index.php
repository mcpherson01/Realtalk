<?php get_header(); ?>

<div id="<?php if (is_home()) echo('wrapper-home'); else echo('container'); ?>">
	<?php if (get_option('wooden_featured') <> 'false' && is_home()) get_template_part( 'includes/featured'); ?>

	<div id="left-div">
		<div id="left-inside">

			<div class="home-post-wrap">
				<div class="heading">
					<span style="font-size: 14px; font-weight: bold;"><?php esc_html_e('Recent Articles','Wooden'); ?></span>
				</div>

			   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php $thumb = '';

					$width = 111;
					$height = 111;
					$classtext = '';
					$titletext = get_the_title();

					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					$thumb = $thumbnail["thumb"]; ?>

					<!--Begin Post Single-->
					<div class="post clearfix">
						<?php if($thumb != '' && get_option('wooden_thumbnails_index') <> 'false') { ?>
							<div class="thumbnail-div">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							</div>
						<?php }; ?>

						<div class="home-post-content">
							<h2 class="titles">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'Wooden'), $titletext) ?>">
									<?php truncate_title(35); ?>
								</a>
							</h2>

							<?php get_template_part('includes/postinfo'); ?>

							<div>
								<?php truncate_post(240); ?>
							</div>

							<div class="readmore">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'Wooden'), $titletext) ?>"><?php esc_html_e('Read More','Wooden'); ?></a>
							</div>
						</div> <!-- end .home-post-content -->
					</div> <!-- end .post -->
			    <?php endwhile; ?>
					<div style="clear: both;"></div>
					<?php get_template_part('includes/navigation'); ?>
				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>
				<?php endif; ?>

			</div> <!-- end .home-post-wrap -->
			<div style="clear: both;"></div>

			<?php if (is_home()) { ?>

				<?php if (get_option('wooden_show_recent_comments') == 'on') { ?>
					<!--Begin Recent Comments-->
					<div class="home-squares">
						<div class="heading">
							<span style="font-size: 14px; font-weight: bold;"><?php esc_html_e('Recent Comments','Wooden'); ?></span>
						</div>
						<div class="recent-comments">
							<?php get_template_part('simple_recent_comments'); /* recent comments plugin by: www.g-loaded.eu */?>
							<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(6, 60, '', ''); } ?>
						</div>
					</div>
					<!--End Recent Comments-->
				<?php }; ?>

				<?php if (get_option('wooden_show_random_posts') == 'on') { ?>
					<!--Begin Random Posts-->
					<div class="home-squares">
						<div class="heading">
							<span style="font-size: 14px; font-weight: bold;"><?php esc_html_e('Random Articles','Wooden'); ?></span>
						</div>

						<?php query_posts("orderby=rand&posts_per_page=3");
						while (have_posts()) : the_post(); ?>
							<?php $thumb = '';

							$width = 70;
							$height = 80;
							$classtext = 'no-border';
							$titletext = get_the_title();

							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							$thumb = $thumbnail["thumb"]; ?>

							<div class="random">
								<?php if($thumb != '') { ?>
									<div class="random-image">
										<a href="<?php the_permalink() ?>">
											<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
										</a>
									</div>
								<?php }; ?>
								<div class="random-content">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'Wooden'), $titletext) ?>">
										<?php truncate_title(35); ?>
									</a>
									<?php truncate_post(90); ?>
								</div>
							</div> <!-- end. random-->
						<?php endwhile; ?>
					</div>
					<!--End Random Posts-->
				<?php }; ?>

				<?php if (get_option('wooden_show_aboutus') == 'on') { ?>
					<!--Begin About Us-->
					<div class="home-post-wrap">
						<div class="heading">
							<span style="font-size: 14px; font-weight: bold;"><?php esc_html_e('About Us','Wooden'); ?></span>
						</div>
						<?php echo(get_option('wooden_about_us')); ?>
					</div>
					<!--End About Us-->
				<?php }; ?>

			<?php }; ?>

		</div> <!-- end #left-inside -->
	</div> <!-- end #left-div -->

	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->

</div> <!-- end #wrapper-home -->

<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>