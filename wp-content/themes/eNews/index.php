<?php get_header(); ?>
	<?php if (get_option('enews_blog_style') == 'on') { get_template_part('includes/blogstyleindex');
		  } else { get_template_part('includes/defaultindex'); } ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>