<div class="cat-box-items">
	<?php $thumb = '';
		  $width = 25;
		  $height = 25;
		  $classtext = 'catbox_border';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>
	<?php if($thumb != '') { ?>
		<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','StudioBlue'), get_the_title()) ?>">
			<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
		</a>
	<?php } ?>

	<span class="titles-boxes">
		<a href="<?php the_permalink(); ?>"><?php truncate_title(35) ?></a>
	</span>
</div>