<?php if (is_category()) { ?>
	<span class="current-category">
		<?php single_cat_title(esc_html__('Currently Browsing: ','Influx'), 'display'); ?>
	</span>
<?php }; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="post-wrapper" style="margin-bottom: 15px !important;">
		<?php get_template_part('includes/share'); ?>

		<?php if (get_option('influx_thumbnails') == 'on') { ?>
			<?php $thumb = '';
				  $width = 80;
				  $height = 80;
				  $classtext = 'no_border';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
				  $thumb = $thumbnail["thumb"];

				  if($thumb != '') { ?>
						<div class="thumbnail-div-2">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						</div>
				  <?php }; ?>
		<?php }; ?>

		<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Influx'), get_the_title()) ?>">
			<?php the_title(); ?></a></h2>

		<?php get_template_part('includes/postinfo'); ?>
		<div style="clear: both;"></div>

		<?php the_content(); ?>
		<div style="clear: both;"></div>
	</div>
<?php endwhile; ?>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		  else get_template_part('includes/navigation'); ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>