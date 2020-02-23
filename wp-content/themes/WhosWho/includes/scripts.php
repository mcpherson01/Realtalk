<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/slider.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.scrollable.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
	jQuery(function(){
		jQuery('ul.superfish').superfish();
		if (jQuery("#scrollable").length) jQuery("#scrollable").scrollable({horizontal:true,size: 4});
		<?php if (get_option('whoswho_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>
	});
</script>