<?php get_header(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

<div id="main-area">
	<div id="main-content" class="clearfix">
		<div id="left-column">
			<div class="post">
				<h1 class="title"><?php esc_html_e('No Results Found','eStore'); ?></h1>
				<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eStore'); ?></p>
			</div>
		</div> <!-- #left-column -->

		<?php get_sidebar(); ?>

<?php get_footer(); ?>