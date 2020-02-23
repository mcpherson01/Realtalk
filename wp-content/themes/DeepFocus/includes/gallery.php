<?php $i = 1; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="item<?php if ($i%4 == 0) echo(' last'); ?>">
		<div class="item-image">
			<?php
			$width = 207;
			$height = 136;
			$titletext = get_the_title();

			$thumbnail = get_thumbnail($width,$height,'portfolio',$titletext,$titletext,true,'Portfolio');
			$thumb = $thumbnail["thumb"];
			print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'portfolio'); ?>
			<span class="overlay"></span>

			<a class="zoom-icon fancybox" title="<?php the_title(); ?>" rel="gallery" href="<?php echo esc_url( $thumbnail['fullpath'] ); ?>"><?php esc_html_e('Zoom in','DeepFocus'); ?></a>
			<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','DeepFocus'); ?></a>
		</div> <!-- end .item-image -->
	</div> <!-- end .item -->
<?php $i++; endwhile; ?>
	<div class="clear"></div>
	<?php
		if ( ! is_home() ){
			if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
			else { get_template_part('includes/navigation'); }
		}
	?>
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>