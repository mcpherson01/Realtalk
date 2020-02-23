<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $width = (int) get_option('lumin_thumbnail_width_usual');
		  $height = (int) get_option('lumin_thumbnail_height_usual');
		  $classtext = 'thumbnail-post alignleft category';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

	<div class="entry">
		<h2 class="cat-title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'Lumin'), get_the_title()) ?>"><?php the_title(); ?></a></h2>

		<?php get_template_part('includes/postinfo'); ?>

		<?php if($thumb <> '') { ?>
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'Lumin'), get_the_title()) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
		<?php }; ?>

		<?php if (get_option('lumin_blog_style') == 'on') the_content(""); else { ?>
			<p><?php truncate_post(400); ?></p>
		<?php }; ?>
		<a class="readmore" href="<?php the_permalink(); ?>"><span><?php esc_html_e('read more','Lumin'); ?></span></a>
		<div class="clear"></div>
	</div> <!-- end .entry -->
<?php endwhile; ?>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { ?>
		<?php get_template_part('includes/navigation'); ?>
	<?php } ?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>