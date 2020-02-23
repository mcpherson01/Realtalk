<?php get_header(); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/entry'); ?>
			<?php endwhile; ?>
				<div style="clear: both;"></div>
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				else { ?>
				     <?php get_template_part('includes/navigation'); ?>
				<?php } ?>
			<?php else : ?>
				<?php get_template_part('includes/no-results'); ?>
			<?php endif; ?>
		</div>
	</div>

	<!--Begin sidebar-->
	<?php get_sidebar(); ?>
	<!--End sidebar-->
</div> <!-- end #container -->

<?php get_footer(); ?>

</body>
</html>