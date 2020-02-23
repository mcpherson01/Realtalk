<?php $width = (int) get_option('egamer_thumbnail_width_posts');
	  $height = (int) get_option('egamer_thumbnail_height_posts');

	  $classtext = 'linkimage';
	  $titletext = get_the_title();

	  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'image_value');
	  $thumb = $thumbnail["thumb"];  ?>

<?php // if there's a thumbnail
if($thumb <> '') { ?>
	<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eGamer'), get_the_title()) ?>">
		<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
	</a>
<?php }; ?>