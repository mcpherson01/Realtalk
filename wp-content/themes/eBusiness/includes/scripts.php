<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>

<?php //if (is_home()) : ?>
	<?php if (get_option('ebusiness_blog_style') == 'false') : ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scrollTo.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/serialScroll.js"></script>

		<?php if (get_option('ebusiness_home_blog') == 'on') : ?>
			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/init.js"></script>
		<?php else : ?>
			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/init2.js"></script>
		<?php endif; ?>

		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/custom.js"></script>
	<?php endif; ?>
<?php //endif; ?>

<script type="text/javascript">
	jQuery(function(){
		jQuery('ul.superfish').superfish();
		<?php if (get_option('ebusiness_disable_toptier') == 'on') echo('jQuery("ul.nav > li > a > span.sf-sub-indicator").parent().attr("href","#");'); ?>
	});
</script>