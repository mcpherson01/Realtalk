<?php
/*
Template Name: Full Width Page
*/
?>
<?php get_header(); ?>

<div class="container clearfix">
	<div id="main_content" class="fullwidth">
		<?php get_template_part('loop','page'); ?>
		<?php if ( 'on' == get_option('elist_show_pagescomments') ) comments_template('', true); ?>
	</div> <!-- end #main-content -->
</div> <!-- end .container -->

<?php get_footer(); ?>