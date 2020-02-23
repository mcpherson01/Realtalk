<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/inc/visionary.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/inc/superfish.js"></script>
<script type="text/javascript">
	jQuery(function(){
		jQuery('ul.superfish').superfish();

		var tabContainers = jQuery('div.tabs > div');

		jQuery('div.tabs ul.tabNavigation a').click(function () {
			tabContainers.hide().filter(this.hash).show();

			jQuery('div.tabs ul.tabNavigation a').removeClass('selected');
			jQuery(this).addClass('selected');

			return false;
		}).filter(':first').click();

		<?php if (get_option('coldstone_disable_toptier') == 'on') echo('jQuery("ul.nav > li > a > span.sf-sub-indicator").parent().attr("href","#");'); ?>
	});
</script>