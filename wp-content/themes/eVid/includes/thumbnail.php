<?php if (is_page()) {
		  $width = (int) get_option('evid_thumbnail_width_pages');
		  $height = (int) get_option('evid_thumbnail_height_pages');
	  } else {
		  $width = (int) get_option('evid_thumbnail_width');
		  $height = (int) get_option('evid_thumbnail_height');
	  };

	  $classtext = 'thumbnail';
	  $titletext = get_the_title();

	  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	  $thumb = $thumbnail["thumb"];  ?>

<?php if($thumb != '') { ?>
	<div class="thumbnail-div-single">
		<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eVid'), get_the_title()) ?>">
			<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
		</a>
	</div>
<?php } ?>