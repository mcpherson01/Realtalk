<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<div class="recentposts">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<!--Begin Posts Single-->
					<div class="post-wrap">
						<div class="entry">
							<?php $width = (int) get_option('tidalforce_thumbnail_width_usual');
								$height = (int) get_option('tidalforce_thumbnail_height_usual');

								$post_title = get_the_title();

								$thumbnail = get_thumbnail($width,$height,'border-none',$post_title,$post_title,false);
								$thumb = $thumbnail["thumb"]; ?>

							<?php if ($thumb <> '' && get_option('tidalforce_thumbnails_index') == 'on') { ?>
								<div class="thumbnail-div">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'border-none'); ?>
								</div>
							<?php }; ?>

							<h2 class="titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','TidalForce'), the_title()) ?>">
								<?php the_title() ?>
								</a></h2>
							<div>
							<?php truncate_post(210); ?></div>
						</div>
						<div style="clear: both;"></div>
					</div>
					<!--End Posts Single-->
				<?php endwhile; ?>
					<div style="clear: both;"></div>
					<?php get_template_part('includes/navigation'); ?>
				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>
				<?php endif; ?>
			</div>
			<img src="<?php bloginfo('template_directory'); ?>/images/content-blue-bottom.gif" alt="bottom" style="margin-bottom: 7px; float: left;" />
		</div>
	</div>
	<!--Begin Sidebar-->
	<?php get_sidebar(); ?>
	<!--End Sidebar-->
</div> <!-- end #container -->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>