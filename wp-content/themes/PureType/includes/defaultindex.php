<?php $loopcounter = 0; ?>
<?php if (have_posts()) : while (have_posts()) : the_post();
   $loopcounter++; ?>

<div class="home-post-wrap-2">
	<?php get_template_part('includes/postinfo-create'); ?>
    <div style="clear: both;"></div>
            <?php if (($loopcounter % 2) <> 0) : ?>
            <h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>
            <?php else : ?>
            <h2 class="titles-orange"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>
            <?php endif; ?>
    <div style="clear: both;"></div>

	<?php $width = 98;
		  $height = 98;

		  $classtext = '';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"];  ?>

	<?php if($thumb != '') { ?>
		<div class="thumbnail-div">
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
		</div>
	<?php }  ?>

    <?php truncate_post(420) ?>
	 <div style="clear: both;"></div>
</div>
<?php endwhile; ?>
<?php get_template_part('includes/page-navigation'); ?>
<?php else : ?>
<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>