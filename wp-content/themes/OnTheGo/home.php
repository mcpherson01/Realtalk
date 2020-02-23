<?php get_header(); ?>
<?php if (get_option('onthego_featured') == 'on') get_template_part('includes/featured'); ?>

<?php get_template_part('includes/default'); ?>

<?php get_footer(); ?>