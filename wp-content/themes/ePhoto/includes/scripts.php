<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scrollTo.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/serialScroll.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/init.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bg.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/custom.js"></script>

<script type="text/javascript">
//<![CDATA[
	jQuery(function(){
<?php if (get_option('ephoto_disable_toptier') == 'on') echo('jQuery("ul.nav > li > a > span.sf-sub-indicator").parent().attr("href","#");'); ?>
<?php if (get_option('ephoto_slider_pause') == 'on') { ?>
	jQuery("div.featured").hover(
		function () {
			jQuery("#sections, #sections2").trigger( 'stop' );
		},
		function () {
			jQuery("#sections, #sections2").trigger( 'start' );
		}
	);
<?php }; ?>
<?php if (get_option('ephoto_slider_auto') == 'false') { ?>
	jQuery("#sections, #sections2").trigger( 'stop' );
<?php }; ?>
	});
//]]>
</script>