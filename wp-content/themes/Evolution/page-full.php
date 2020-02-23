<?php
/*
Template Name: Full Width Page
*/
?>
<?php get_header(); ?>

<div id="content_area" class="clearfix fullwidth">
	<div id="main_content">
		<?php get_template_part('includes/breadcrumbs','index'); ?>
		<?php get_template_part('loop','page'); ?>
		<?php if ( 'on' == get_option('evolution_show_pagescomments') ) comments_template('', true); ?>
	</div> <!-- end #main_content -->
</div> <!-- end #content_area -->

<?php get_footer(); ?>