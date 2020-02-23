<?php get_header(); ?>

	<?php if(is_page() && is_front_page()) { ?>
		<div id="main-content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="entry post clearfix">
					<h1 class="title"><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div> <!-- end.entry -->
			<?php endwhile; endif; wp_reset_query(); ?>
		</div> <!-- end #main-content -->
	<?php } else { ?>
		<?php if (get_option('myapptheme_featured') == 'on') get_template_part('includes/featured');
		else { ?>

			<div id="main-content">
				<?php get_template_part('includes/entry'); ?>
			</div> <!-- end #main-content -->

		<?php }; ?>
	<?php }; ?>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>