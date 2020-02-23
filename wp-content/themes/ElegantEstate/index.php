<?php get_header(); ?>

<div id="content-top">
	<div id="menu-bg"></div>
	<div id="top-index-overlay"></div>

	<div id="content" class="clearfix">
		<div id="main-area">
			<?php get_template_part('includes/entry'); ?>
		</div> <!-- end #main-area-->

		<?php get_sidebar(); ?>

	<?php get_footer(); ?>