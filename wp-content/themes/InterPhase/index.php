<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php $thumb = '';
					  $width = 120;
					  $height = 120;
					  $classtext = '';
					  $titletext = get_the_title();

					  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
					  $thumb = $thumbnail["thumb"]; ?>

				<div class="home-post-wrap2">
					<div style="clear: both;"></div>

					<div class="single-entry">
						<h2 class="titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','InterPhase'), get_the_title()) ?>">
							<?php truncate_title(40); ?></a></h2>

						<?php if($thumb != '') { ?>
							<div class="thumbnail-div">
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							</div>
						<?php }; ?>

						<?php get_template_part('includes/postinfo'); ?>

						<?php truncate_post(390); ?>
						<div style="clear: both;"></div>

						<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','InterPhase'), get_the_title()) ?>"><?php esc_html_e('Read More','InterPhase'); ?></a></div>
					</div>
				</div>

			<?php endwhile; ?>
				<div style="clear: both;"></div>
				<?php get_template_part('includes/navigation'); ?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>