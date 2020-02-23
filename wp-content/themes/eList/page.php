<?php get_header(); ?>

<div class="container clearfix">
	<div id="main_content">
		<?php get_template_part('loop','page'); ?>
		<?php if ( 'on' == get_option('elist_show_pagescomments') ) comments_template('', true); ?>
	</div> <!-- end #main-content -->
	<?php get_sidebar(); ?>
</div> <!-- end .container -->

<?php get_footer(); ?>