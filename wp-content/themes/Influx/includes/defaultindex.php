<?php if (is_category()) { ?>
	<span class="current-category">
		<?php single_cat_title(esc_html__('Currently Browsing: ','Influx'), 'display'); ?>
	</span>
<?php }; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';
		  $width = 60;
		  $height = 60;
		  $classtext = 'no_border';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

	<div class="home-post-wrap2">
		<div style="clear: both;"></div>
		<div class="single-entry">
			<?php get_template_part('includes/postinfo'); ?>
			<h2 class="titles2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
				<?php the_title() ?>
				</a></h2>
			<div style="clear: both;"></div>

			<!--Display thumbnail if found-->
			<?php if($thumb != '') { ?>
				<div class="thumbnail-div-3">
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				</div>
			<?php }; ?>

			<?php truncate_post(310) ?>
			<div style="clear: both;"></div>

			<div class="readmore">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>"><?php esc_html_e('Read More','Influx'); ?></a>
			</div>
		</div>
	</div>
<?php endwhile; ?>
	<div style="clear: both;"></div>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
			  else get_template_part('includes/navigation'); ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>