<?php if (get_option('influx_show_rcenter_column') == 'on') get_template_part('includes/rightcolumn'); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php $thumb = '';
			  $width = 281;
			  $height = 130;
			  $classtext = 'no_border';
			  $titletext = get_the_title();

			  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
			  $thumb = $thumbnail["thumb"]; ?>

		<div class="home-post-wrap">
			<div class="thumbnail-div">
				<?php if($thumb != '') { ?>
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				<?php } ?>
			</div>
			<h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
				<?php truncate_title(26) ?>
				</a></h2>
			<?php truncate_post(410) ?>
			<div style="clear: both;"></div>
			<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>"><?php esc_html_e('Read More','Influx'); ?></a></div>
		</div>

<?php endwhile; ?>

	<div style="clear: both;"></div>
	<div style="clear: both; margin-bottom: 10px;">
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { ?>
			<?php get_template_part('includes/navigation'); ?>
		<?php } ?>
	</div>

<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>