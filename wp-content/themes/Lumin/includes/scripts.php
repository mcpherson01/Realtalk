	<?php global $shortname;

	if (is_front_page()) echo('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>');

	//on Homepage; Featured slider is activated
	if (is_front_page() && (get_option('lumin_featured')=='on')) { ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
	<?php }; ?>

	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/init.js"></script>

	<script type="text/javascript">
	//<![CDATA[
		<?php //on Homepage; Featured slider is activated
		if (is_front_page() && (get_option($shortname.'_featured')=='on')) { ?>
			var $slider_control = jQuery('#featured-slider div#slider-control'),
				$featured_item = jQuery('#featured-slider div#slider-control div.featitem'),
				$slider_control = jQuery('#featured-slider div#slider-control');
				$image_container = jQuery('div#s1 > div');

			et_featured_options = {
				timeout: 0,
				speed: 300,
				cleartypeNoBg: true,
				before: function (currSlideElement, nextSlideElement, options, forwardFlag) {
					var $et_active_slide = jQuery(nextSlideElement),
						et_active_order = $et_active_slide.prevAll().length,
						$this_element = $slider_control.find('div.featitem').eq(et_active_order);

					$slider_control
						.children("div.featitem.active")
							.fadeTo("fast", 0.5)
							.removeClass('active');
					$this_element.addClass('active').fadeTo("fast", 1);
				},
				fx: '<?php echo esc_js(get_option($shortname.'_slider_effect')); ?>'
			}

			<?php if (get_option($shortname.'_pause_hover') == 'on') { ?>
				et_featured_options.pause = 1;
			<?php } ?>

			<?php if (get_option($shortname.'_slider_auto') == 'on') { ?>
				et_featured_options.timeout = <?php echo esc_js(get_option($shortname.'_slider_autospeed')); ?>;
			<?php } ?>

			$featured_item.fadeTo("fast", 0.5);
			$slider_control.children("div.featitem.active").fadeTo("fast", 1);
			$image_container.css("background-color","#000000");

			jQuery(window).load( function(){
				jQuery('#s1, #slider-control').show();
				jQuery('#s1').cycle(et_featured_options);
			} );

			$image_container.hover(
				function () {
					jQuery(this).find("img").fadeTo("fast", 0.7);
				},
				function () {
					jQuery(this).find("img").fadeTo("fast", 1);
				}
			);

			$featured_item.click(function(){
				var et_ordernumber = jQuery(this).prevAll().length;
				jQuery('#s1').cycle(et_ordernumber);
				return false;
			});
		<?php } ?>

		<?php //on Home, Projects category/subcategory page
		$projects_cat = get_catid(get_option('lumin_projects_cat'));
		if (is_front_page() || is_category($projects_cat) || in_subcat($projects_cat,$cat)) { ?>
			<?php if (is_front_page()) { ?>
				jQuery("div#from-blog").tabs({ hide : true });
			<?php }; ?>

			var $project_item = <?php if (is_front_page()) { ?>jQuery('div.project-item');<?php } else { ?>jQuery('div.thumb-gallery');<?php } ?>

			$project_item.mouseenter(function(e) {
				jQuery(this).children("img.preview-thumb").fadeTo("fast", 0.5);
				move_thumb(jQuery(this),e);
				jQuery(this).css('z-index','15').children("div.project-popup").css({'top': y + 10,'left': x + 20,'display':'block'});
			}).mousemove(function(e) {
				move_thumb(jQuery(this),e);
				jQuery(this).children("div.project-popup").css({'top': y + 10,'left': x + 20});
			}).mouseleave(function() {
				jQuery(this).css('z-index','1')
					.children("img.preview-thumb")
					.fadeTo("fast", 1)
					.end()
				.children("div.project-popup")
				.animate({"opacity": "hide"}, "fast");
			});

			function move_thumb(this_element,event_name){
				x = event_name.pageX - this_element.offset().left;
				y = event_name.pageY - this_element.offset().top;
			};

			jQuery(".js div#recent-projects, .js div#from-blog div.content").show(); //prevents a flash of unstyled content
		<?php }; ?>
	//]]>
	</script>

	<?php if (get_option($shortname.'_disable_toptier') == 'on') { ?>
		<script type="text/javascript">
			<?php echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>
		</script>
	<?php }; ?>