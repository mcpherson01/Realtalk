<?php $thumb = '';

	$width = 30;
	$height = 30;
	$classtext = 'thumb';
	$titletext = get_the_title();

	$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	$thumb = $thumbnail["thumb"];
?>

<div class="post clearfix">
	<?php if ($thumb <> '') { ?>
		<div class="post-thumb">
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'OnTheGo'), $titletext) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
		</div> <!-- end .post-thumb -->
	<?php }; ?>

	<div class="description">
		<h4><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'OnTheGo'), $titletext) ?>"><?php truncate_title(20); ?></a></h4>

		<?php if (get_option('onthego_postinfo_fromblog') ) { ?>
			<p class="meta">
				<?php esc_html_e('Posted ','OnTheGo'); ?>
				<?php if (in_array('author', get_option('onthego_postinfo_fromblog'))) { esc_html_e(' by ','OnTheGo'); the_author_posts_link(); };
					  if (in_array('date', get_option('onthego_postinfo_fromblog'))) { esc_html_e(' on ','OnTheGo'); the_time(get_option('onthego_date_format')); }; ?>
			</p>
		<?php }; ?>

	</div>
</div> <!-- end post -->