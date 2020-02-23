<?php get_header(); ?>
<!--Begin Featured Article-->
<?php if (get_option('ephoto_featured') == 'on') { ?>
	<?php get_template_part('includes/featured'); ?>
<?php } ?>
<!--End Feaured Article-->

<div id="container">
    <div id="left-div">
		<div id="home-wrapper">
			<!--Begind recent post-->
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/thumbnail2'); ?>
			<?php endwhile; ?>
			<!--End recent post-->
		</div> <!-- end home-wrapper -->

		<?php if (get_option('ephoto_home_pagenavi') == 'on') { ?>
			<?php get_template_part('includes/page-navigation'); ?>
		<?php } ?>

	  <?php else : ?>
		 <?php get_template_part('includes/no-results'); ?>
	  <?php endif; ?>
    </div> <!-- end left-div -->

    <div id="sidebar" style="margin-top: 15px;">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Homepage") ) : ?>
        <?php endif; ?>
    </div> <!-- end sidebar -->
    <div id="bottom">
		<?php get_template_part('includes/footer-area'); ?>
    </div> <!-- end bottom -->
</div> <!-- end container -->
<?php get_footer(); ?>
</body>
</html>