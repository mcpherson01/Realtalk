<?php
/*
Template Name: Submit Page
*/
?>
<?php get_header(); ?>

<div class="container clearfix">
	<div id="main_content">
		<?php get_template_part('loop','page'); ?>

		<?php do_action( 'elist_submit_before_content' ); ?>

		<?php do_action( 'elist_submit_after_content' ); ?>
	</div> <!-- end #main-content -->
	<?php get_sidebar(); ?>
</div> <!-- end .container -->

<?php get_footer(); ?>