<?php get_header(); ?>
	<?php the_post(); ?>
		<?php if (get_option('lightbright_integration_single_top') <> '' && get_option('lightbright_integrate_singletop_enable') == 'on') echo(get_option('lightbright_integration_single_top')); ?>

		<?php include( get_template_directory() . '/includes/entry.php' ); ?>

	</div> <!-- end #main-area -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>