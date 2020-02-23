
<div class="entry clearfix nobg">
	<h2 class="title"><?php the_title(); ?></h2>

	<?php
		$post_title = get_the_title();
		$width = 140;
		$height = 140;
		$classtext = 'thumbnail alignleft';

		$thumbnail = get_thumbnail($width,$height,$classtext,$post_title,$post_title);
		$thumb = $thumbnail["thumb"];

		if ($thumb != '') print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, $classtext); ?>

	<?php global $more;
		  $more = 0;
		  the_content(""); ?>
</div>