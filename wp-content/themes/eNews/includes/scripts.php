<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/init.js"></script>


<?php if ((is_home()) && (get_option('enews_featured') == 'on') ) { //scripts for featured area are loaded only on homepage / when Display Featured Articles is set to Display ?>
	<?php global $shortname; ?>

	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>

	<script type="text/javascript">
	//<![CDATA[
		jQuery(window).load(function(){
				jQuery('#featured-area #s1').css( 'visibility', 'visible' );
				jQuery('#featured-area #s1').cycle({
					timeout: 0,
					speed: 300,
					cleartypeNoBg: true,
					fx: '<?php echo esc_js(get_option($shortname.'_slider_effect')); ?>'
				});

				var $featured_area = jQuery('#featured-area');
				var $featured_item = jQuery('#featured-area ul#nav li a');
				var $slider_control = jQuery('#featured-area ul#nav'); //tabs


				var $slider_control_tab = jQuery('#featured-area ul#nav li');


				var ordernum;
				var pause_scroll = false;

				<?php if (get_option($shortname.'_pause_hover') == 'on') { ?>
					$featured_area.mouseover(function(){
						pause_scroll = true;
					}).mouseout(function(){
						pause_scroll = false;
					});
				<?php }; ?>

				function gonext(this_element){
					$slider_control.find("li a").removeClass('activeSlide');
					this_element.find("a").addClass('activeSlide');
					ordernum = this_element.prevAll().length+1;
					jQuery('#featured-area #s1').cycle(ordernum - 1);
				}

				$slider_control_tab.click(function() {
					clearInterval(interval);
					gonext(jQuery(this));
					return false;
				});

				jQuery('#featured-area a#prev-item, #featured-area a#next-item').click(function() {
					clearInterval(interval);

					if (jQuery(this).attr("id") === 'next-item') {
						auto_number = $slider_control.find("li a.activeSlide").parent().prevAll().length+1;
						if (auto_number === $slider_control_tab.length) auto_number = 0;
					} else {
						auto_number = $slider_control.find("li a.activeSlide").parent().prevAll().length-1;
						if (auto_number === -1) auto_number = $slider_control_tab.length-1;
					};

					gonext($slider_control_tab.eq(auto_number));
					return false;
				});

				var auto_number;
				var interval;

				$slider_control_tab.bind('autonext', function autonext(){
					if (!(pause_scroll)) gonext(jQuery(this));
					return false;
				});


				<?php if (get_option($shortname.'_slider_auto') == 'on') { ?>
					interval = setInterval(function(){
						auto_number = $slider_control.find("li a.activeSlide").parent().prevAll().length+1;
						if (auto_number === $slider_control_tab.length) auto_number = 0;
						$slider_control_tab.eq(auto_number).trigger('autonext');
					}, <?php echo esc_js(get_option($shortname.'_slider_autospeed')); ?>);
				<?php }; ?>


				<?php if (get_option('enews_disable_toptier') == 'on') echo('jQuery("ul.nav > li > a > span.sf-sub-indicator").parent().attr("href","#")'); ?>
			});
	//]]>
	</script>

<?php }; ?>


<?php if (is_single()) { //script for share this block alignment and animation ?>
	<script type="text/javascript">
	//<![CDATA[
		if ( jQuery("span#prev-link").length > 0 ) { var mleftCenter = "250px"; var mLeft = "30px"; }
		else { var mleftCenter = "412px"; var mLeft = "192px"; }
		jQuery("a#share-link").css('margin-left', mleftCenter);

		jQuery("a#share-link,a#this-link").click(function () {
			if (jQuery("div#share-icons").is(":hidden")) {
				jQuery("a#share-link").css('margin-left', "30px");
				jQuery("div#share-icons").animate({"opacity": "toggle"}, "slow"); }
			else {
				jQuery("div#share-icons").animate({"opacity": "toggle"}, "fast", function(){jQuery("a#share-link").css('margin-left', mleftCenter)} );
			};
			return false;
		});
	//]]>
	</script>
<?php }; ?>


<?php if ((is_home()) && (get_option('enews_featured') == 'on') ) { //scripts for featured area are loaded only on homepage / when Display Featured Articles is set to Display ?>
	<script type="text/javascript">
		jQuery(".js #featured-area, .js ul#page-menu, .js ul#cats-menu, img#logo").show(); //prevents a flash of unstyled content
	</script>
<?php } else { ?>
	<script type="text/javascript">
		jQuery(".js ul#page-menu, .js ul#cats-menu, img#logo").show(); //prevents a flash of unstyled content
	</script>
<?php }; ?>