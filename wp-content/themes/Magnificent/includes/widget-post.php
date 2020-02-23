<?php $thumb = '';
$width = 40;
$height = 40;
$classtext = '';
$titletext = get_the_title();
$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
$thumb = $thumbnail['thumb']; ?>

<li class="clearfix">
	<?php if ($thumb <> '') { ?>
		<span class="box">
			<a href="<?php the_permalink(); ?>">
				<span class="overlay"></span>
				<?php print_thumbnail($thumb, $thumbnail['use_timthumb'], $titletext, $width, $height); ?>
			</a>
		</span>
	<?php } ?>
	<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
	<p class="post-info"><?php esc_html_e('Posted','Magnificent'); ?> <?php esc_html_e('on','Magnificent'); ?> <?php the_time(get_option('magnificent_date_format')) ?></p>
</li>