<?php get_header(); ?>

<div id="container">
	<div id="container2">
		<div id="left-div">
			<div class="heading-content">
				<div class="heading-left"></div>
				<div class="heading-inside"><?php esc_html_e('Recent Entries','Simplism'); ?></div>
				<div class="heading-right"></div>
			</div> <!-- end .heading-content -->

			<!--Begin Featured Article-->
			<?php if (get_option('simplism_featured') == 'on') get_template_part('includes/featured'); ?>
			<!--End Featured Article-->

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
			</div> <!-- end #left-inside -->

			<!--Begin Tabbed Content-->
			<?php if (get_option('simplism_tabs') == 'on') get_template_part('includes/tabs'); ?>
			<!--End Tabbed Content-->

		</div> <!-- end #left-div -->
	</div> <!-- end #container2 -->

	<?php get_sidebar(); ?>
</div> <!-- end #container -->
<?php get_footer(); ?>
</body>
</html>