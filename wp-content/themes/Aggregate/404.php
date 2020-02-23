<?php get_header(); ?>

<div id="main-content" class="clearfix">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs'); ?>
		<div id="entries">
			<h1><?php esc_html_e('No Results Found','Aggregate'); ?></h1>
			<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Aggregate'); ?></p>
		</div> <!-- end #entries -->
	</div> <!-- end #left-area -->
	<?php get_sidebar(); ?>

<?php get_footer(); ?>