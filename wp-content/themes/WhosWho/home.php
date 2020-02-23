<?php get_header(); ?>

<?php if (get_option('whoswho_featured') == 'on') get_template_part('includes/featured'); ?>

<div id="container">
	<div id="left-div">
		<div id="left-inside">
			<?php if (get_option('whoswho_blog_style') == 'on') { ?>
				<?php get_template_part('includes/defaultindex'); ?>
			<?php } else { get_template_part('includes/newsstyle'); } ?>
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>