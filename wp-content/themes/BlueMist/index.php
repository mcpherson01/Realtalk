<?php get_header(); ?>

<?php if (get_option('bluemist_featured') == 'on' && is_home()) get_template_part('includes/featured'); ?>

<div id="container">
	<div id="container2">
		<div id="left-div">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-wrapper">
					<div class="post">

						<div class="homepost-left">
							<div class="thumbnailwrap">
								<?php $width = 94;
								$height = 94;
								$classtext = 'thumbnail-home';
								$titletext = get_the_title();

								$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								$thumb = $thumbnail["thumb"]; ?>

								<?php if($thumb != '' && get_option('bluemist_thumbnails_index') == 'on') { ?>
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
								<?php } ?>
							</div>
							<?php if (function_exists('Show_Dropdown')) Show_Dropdown(); ?>
						</div> <!-- end .homepost-left -->

						<div class="homepost-right">
							<h2 class="titles">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','BlueMist'), get_the_title()) ?>">
									<?php the_title(); ?>
								</a>
							</h2>

							<?php if (get_option('bluemist_blog_style') == 'false') truncate_post(350);
							else the_content(); ?>
							<div style="clear: both;"></div>
						</div> <!-- end .homepost-right -->

					</div> <!-- end .post -->
				</div> <!-- end .post-wrapper -->
			<?php endwhile; ?>
				 <?php get_template_part('includes/navigation'); ?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->

	<?php get_sidebar(); ?>

</div> <!-- end #container -->
<?php get_footer(); ?>
</body>
</html>