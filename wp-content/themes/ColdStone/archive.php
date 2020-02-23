<?php if (get_option('coldstone_format') == 'Blog Style') { ?>
	<?php get_template_part('includes/blogstylecat'); ?>
<?php } else { get_template_part('includes/defaultarchive'); } ?>