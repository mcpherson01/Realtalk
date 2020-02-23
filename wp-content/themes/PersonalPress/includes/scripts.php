<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
<script type="text/javascript">
//<![CDATA[
	jQuery.noConflict();

	et_top_menu();

	<!---- Top Menu Improvements ---->
	function et_top_menu(){
		var $top_menu = jQuery('ul.superfish'),
			menuWidth = 920;

		$top_menu.superfish({
			delay:       300,                            // one second delay on mouseout
			animation:   {'marginLeft':'0px',opacity:'show'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			onBeforeShow: function(){ this.css('marginLeft','20px'); },
			autoArrows:  false,                           // disable generation of arrow mark-up
			dropShadows: false                            // disable drop shadows
		}).find('> li > ul').prepend('<span class="top-arrow"></span>');

		$top_menu.find("> li > a").each(function (index, domEle) {
			if (!jQuery(domEle).find("> strong").length) {
				var $html = '<strong>'+jQuery(domEle).html()+'</strong>';
				jQuery(domEle).html($html);
			};
		});

		var pagemenuwidth = $top_menu.width(),
			pagemleft = Math.round((menuWidth - pagemenuwidth) / 2);
		if (pagemenuwidth < menuWidth) $top_menu.css('padding-left',pagemleft);

		if (!$top_menu.find("> li > a > span").length) { $top_menu.find("> li > ul").css("top","40px"); };
	};

	<?php if (get_option('personalpress_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>

	$widget_menu = jQuery(".widget_nav_menu");
	if ($widget_menu.length) {
		$widget_menu.find("ul > li > a").each(function (index, domEle) {
			var $html = jQuery(domEle).html();

			$html = $html.replace(/\/\/\/([^<]+)/gi, "");
			jQuery(domEle).html($html);
		});
	};


//]]>
</script>