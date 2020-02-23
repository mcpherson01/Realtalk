<?php get_header(); ?>

<?php if (get_option('grungemag_blog_style') == 'on') { ?>
	<?php get_template_part('includes/defaultindex'); ?>
<?php } else { get_template_part('includes/default'); } ?>