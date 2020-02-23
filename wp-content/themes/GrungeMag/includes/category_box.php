<?php $thumb = '';
	  $width = 100;
	  $height = 100;
	  $classtext = 'no_border';
	  $titletext = get_the_title();

	  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	  $thumb = $thumbnail["thumb"]; ?>

<div class="home-post-wrap-box">
	<?php global $cat_option; ?>
	<span class="headings"><?php esc_html_e('recent from','GrungeMag'); ?> <?php echo esc_html(get_option($cat_option)); ?></span>
	<span class="titles-boxes">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</span>
	<div style="clear: both;"></div>

	<?php if($thumb != '') { ?>
		<div class="cat-thumb">
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','GrungeMag'), get_the_title()) ?>" class="dblock">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
			</a>
		</div>
	<?php }; ?>

	<?php truncate_post(310); ?>

	<div style="clear:both;"></div>
</div>