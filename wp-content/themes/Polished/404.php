<?php get_header(); ?>
	<div id="wrap">
	<!-- Main Content-->
		<img src="<?php echo get_template_directory_uri(); ?>/images/content-top.gif" alt="content top" class="content-wrap" />
		<div id="content">
			<!-- Start Main Window -->
			<div id="main">
				<div class="postcontent">
				<!--If no results are found-->
					<h1 id="error"><?php esc_html_e('No Results Found','Polished'); ?></h1>
					<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Polished'); ?></p>
				<!--End if no results are found-->
				</div>
			</div>
			<!-- End Main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>