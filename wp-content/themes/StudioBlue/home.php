<?php get_header(); ?>

<div id="container">

	<?php if (get_option('studioblue_728_enable') == 'on') get_template_part('includes/leader'); ?>

	<div id="left-div">
		<div id="left-inside">
			<?php get_template_part('includes/default'); ?>
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
</body>
</html>