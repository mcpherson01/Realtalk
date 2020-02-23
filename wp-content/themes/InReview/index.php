<?php get_header(); ?>

<div id="main-content">
	<div id="main-content-wrap" class="clearfix">
		<div id="left-area">
			<?php get_template_part('includes/breadcrumbs'); ?>

			<?php get_template_part('includes/entry'); ?>
		</div> <!-- end #left-area -->

		<?php get_sidebar(); ?>
	</div> <!-- end #main-content-wrap -->
</div> <!-- end #main-content -->
<?php get_footer(); ?>