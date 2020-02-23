<?php get_header(); ?>
	<div id="post-top">
		<div class="breadcrumb">
			<?php if(function_exists('bcn_display')) { bcn_display(); }
			else { ?>
				<?php esc_html_e('You are currently viewing','eNews') ?>: <em><?php esc_html_e('No results found','eNews'); ?></em>
			<?php }; ?>
		</div> <!-- end breadcrumb -->
	</div> <!-- end post-top -->

	<div id="main-area-wrap">
		<div id="wrapper">
			<div id="main" class="noborder">
				<h1 class="page-title"><?php esc_html_e('No Results Found','eNews'); ?></h1>
				<div id="post-content">
					 <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','eNews'); ?></p>
				</div>
			</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>