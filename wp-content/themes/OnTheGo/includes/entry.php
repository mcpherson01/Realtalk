<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';

	//if not (Single Post -> Place Thumbs on Posts disabled and Blog style mode enabled)
	if (!(get_option('onthego_thumbnails') == 'false' && get_option('onthego_blog_style') == 'on')) {
		$width = (int) get_option('onthego_thumbnail_width_usual');
		$height = (int) get_option('onthego_thumbnail_height_usual');
		$classtext = 'thumbnail-post alignleft category';
		$titletext = get_the_title();

		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		$thumb = $thumbnail["thumb"];
	}; ?>

	<div class="entry category clearfix">

		<h2 class="title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'OnTheGo'), $titletext) ?>"><span><?php the_title(); ?></span></a></h2>

		<?php if (get_option('onthego_postinfo1') ) get_template_part('includes/postinfo'); ?>

		<?php if($thumb <> '') { ?>
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'OnTheGo'), $titletext) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
			</a>
		<?php }; ?>

		<?php if (get_option('onthego_blog_style') == 'on') the_content(""); else { ?>
			<p><?php truncate_post(400); ?></p>
		<?php }; ?>
		<a class="readmore" href="<?php the_permalink(); ?>"><span><?php esc_html_e('Read More','OnTheGo'); ?></span></a>

	</div> <!-- end .entry -->
<?php endwhile; ?>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { ?>
		<?php get_template_part('includes/navigation'); ?>
	<?php } ?>

<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>