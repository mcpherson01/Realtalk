<?php get_header(); ?>
<?php if (get_option('lumin_featured') == 'on') get_template_part('includes/featured'); ?>

<?php if (get_option('lumin_homedesc') <> '') { ?>
	<p id="slogan-phrase"><?php echo(get_option('lumin_homedesc')); ?></p>
<?php }; ?>

<?php get_template_part('includes/default'); ?>

<?php get_footer(); ?>