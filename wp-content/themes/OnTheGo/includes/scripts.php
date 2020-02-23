<?php global $shortname;

if (is_front_page()) echo('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script> 		<script type="text/javascript">jQuery("div#from-blog").tabs({ hide : true });</script>');

//on Homepage; Featured slider is activated
if (is_front_page() && (get_option($shortname.'_featured')=='on')) { ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
<?php }; ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/init.js"></script>

<script type="text/javascript">
//<![CDATA[

	jQuery(".js div#from-blog div.entries").show(); //prevents a flash of unstyled content

	<?php //on Homepage; Featured slider is activated
	if (is_front_page() && (get_option($shortname.'_featured')=='on')) { ?>
		jQuery(window).load( function(){
			jQuery('#feat-content').css( 'backgroundImage', 'none' ).cycle({
				timeout: 0,
				speed: 300,
				cleartypeNoBg: true,
				fx: '<?php echo esc_js(get_option($shortname.'_slider_effect')); ?>'
			});

			var $featured_area = jQuery('#featured-slider');
			var $featured_item = jQuery('#featured-area div.featitem');
			var $slider_control = jQuery('ul#slider-control'); //tabs
			var $slider_control_tab = jQuery('ul#slider-control li');

			var ordernum;
			var pause_scroll = false;

			if ( $featured_item.length == 1 ){
				$featured_item.css({'position':'absolute','top':'31px','left':'45px'}).show();
			}

			<?php if (get_option($shortname.'_pause_hover') == 'on') { ?>
				$featured_area.mouseover(function(){
					pause_scroll = true;
				}).mouseout(function(){
					pause_scroll = false;
				});
			<?php }; ?>

			function gonext(this_element){
				$slider_control.children("li.active").removeClass('active');
				this_element.addClass('active');
				ordernum = this_element.prevAll().length+1;
				jQuery('#feat-content').cycle(ordernum - 1);
			}

			$slider_control_tab.click(function() {
				clearInterval(interval);
				gonext(jQuery(this));
				return false;
			});

			jQuery('#featured-area a#prevlink, #featured-area a#nextlink').click(function() {
				clearInterval(interval);

				if (jQuery(this).attr("id") === 'nextlink') {
					auto_number = $slider_control.children("li.active").prevAll().length+1;
					if (auto_number === $slider_control_tab.length) auto_number = 0;
				} else {
					auto_number = $slider_control.children("li.active").prevAll().length-1;
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
					auto_number = $slider_control.children("li.active").prevAll().length+1;
					if (auto_number === $slider_control_tab.length) auto_number = 0;
					$slider_control_tab.eq(auto_number).trigger('autonext');
				}, <?php echo esc_js(get_option($shortname.'_slider_autospeed')); ?>);
			<?php }; ?>
		} );
	<?php }; ?>

	<?php if (get_option($shortname.'_disable_toptier') == 'on')
			echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>


//]]>
</script>