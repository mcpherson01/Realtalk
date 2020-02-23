<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
	<?php the_title(); ?>
	</a></h1>
<?php get_template_part('includes/postinfo-create'); ?>

<div class="rule"></div>
<div style="clear: both;"></div>
<?php if (get_option('puretype_thumbnails') == 'on') { get_template_part('includes/thumbnail'); } ?>
<?php the_content(); ?>