<?php if (in_category(get_catId(get_option('ephoto_blog_cat'))) ) { ?>
	<?php get_template_part('includes/single-blog'); ?>
<?php } else { get_template_part('includes/single-photo'); } ?>