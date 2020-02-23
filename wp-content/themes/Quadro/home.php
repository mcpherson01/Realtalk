<?php get_header(); ?>

<div id="container">
	<div id="container2">
		<div id="left-div">
			<?php if (get_option('quadro_featured') == 'on') get_template_part('includes/featured'); ?>

			<?php if (get_option('quadro_show_tabs') == 'on') get_template_part('includes/tabs'); ?>

			<div style="clear: both;"></div>

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
		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->

	<?php get_sidebar(); ?>

</div> <!-- end #container -->
<?php get_footer(); ?>
</body>
</html>