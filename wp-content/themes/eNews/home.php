<?php get_template_part('includes/recent-from'); ?>
<?php get_header(); ?>
<?php if (get_option('enews_featured') == 'on') get_template_part('includes/featured'); ?>
	<?php if (get_option('enews_blog_style') == 'on') { get_template_part('includes/blogstyle');
		  } else { get_template_part('includes/default'); } ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>