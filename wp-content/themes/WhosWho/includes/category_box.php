<?php global $cat_option;
$thumb = '';
	  $width = 70;
	  $height = 70;
	  $classtext = 'catbox_image';
	  $titletext = get_the_title();

	  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	  $thumb = $thumbnail["thumb"]; ?>

<div class="home-categories">
	<span class="headings"><?php esc_html_e('recent from','WhosWho')?> <?php echo(get_option($cat_option)); ?></span>
	<a href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a>
	<div style="clear:both;"></div>

	<?php if($thumb != '') { ?>
		<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','WhosWho'), get_the_title()) ?>">
			<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
		</a>
	<?php } ?>
	<?php truncate_post(310) ?>
	<div style="clear:both;"></div>
</div>