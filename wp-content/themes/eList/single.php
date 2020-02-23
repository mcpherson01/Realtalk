<?php get_header(); ?>

<div class="container clearfix">
	<div id="main_content">
		<?php get_template_part('loop','single'); ?>
	</div> <!-- end #main-content -->
	<?php get_sidebar(); ?>
</div> <!-- end .container -->

<?php get_footer(); ?>