<?php get_header(); ?>

<div id="content-top">
	<div id="menu-bg"></div>
	<div id="top-index-overlay"></div>
	<div id="content" class="clearfix">
		<div id="main-area">
		<?php get_template_part('includes/breadcrumbs'); ?>
			<div class="full_entry clearfix">
				<h1 class="single-title"><?php esc_html_e('No Results Found','ElegantEstate'); ?></h1>
				<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','ElegantEstate'); ?></p>
			</div>
		</div> <!-- end #main-area-->

		<?php get_sidebar(); ?>

	<?php get_footer(); ?>