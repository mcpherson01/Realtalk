<?php if (is_home() && get_option('egamer_featured') == 'on') { ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scrollTo.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/serialScroll.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/init.js"></script>
<?php }; ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>

<script type="text/javascript">
	jQuery(function(){
		jQuery('ul.superfish').superfish();
		<?php if (get_option('egamer_disable_toptier') == 'on') echo('jQuery("ul.nav > li > a > span.sf-sub-indicator").parent().attr("href","#")'); ?>
	});
</script>