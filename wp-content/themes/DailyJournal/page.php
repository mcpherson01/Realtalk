<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs','single'); ?>
<?php get_template_part('loop','page'); ?>
<?php if ( 'on' == get_option('dailyjournal_show_pagescomments') ) comments_template('', true); ?>

<?php get_footer(); ?>