<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php include(TEMPLATEPATH.'/includes/entry.php'); ?>

<?php endwhile; ?>

	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { ?>
			<?php get_template_part('includes/navigation'); ?>
	<?php } ?>

<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>


	</div> <!-- end #main-area -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>