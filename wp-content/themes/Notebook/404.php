<?php get_header(); ?>

<div id="regular_content">
	<?php get_template_part('includes/breadcrumbs','index'); ?>

	<article class="single_view">
		<h1 class="main_title"><?php esc_html_e('No Results Found','Notebook'); ?></h1>
		<div id="post_content">
			<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Notebook'); ?></p>
		</div>
	</article> <!-- end .single_view -->
</div> <!-- end #regular_content -->

<?php get_footer(); ?>