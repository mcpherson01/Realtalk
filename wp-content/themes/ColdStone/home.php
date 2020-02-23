<?php get_header(); ?>
<?php if (get_option('coldstone_featured') == 'on') { get_template_part('includes/featured'); } ?>

<?php if (get_option('coldstone_format') == 'Blog Style') { ?>
	<?php get_template_part('includes/blogstylehome'); ?>
<?php } else { get_template_part('includes/defaultif'); } ?>

<?php get_footer(); ?>