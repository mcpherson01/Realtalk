<?php get_header(); ?>

<div class="container clearfix">
	<div id="main_content">
		<h1 class="title"><?php esc_html_e('No Results Found','eList'); ?></h1>
		<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eList'); ?></p>
	</div> <!-- end #main_content -->
	<?php get_sidebar(); ?>
</div> <!-- end .container -->

<?php get_footer(); ?>