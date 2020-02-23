<?php global $shortname; ?>

	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>

	<script type="text/javascript">
	//<![CDATA[
		jQuery.noConflict();

		jQuery('ul.nav').superfish({
			delay:       300,                            // one second delay on mouseout
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			autoArrows:  true,                           // disable generation of arrow mark-up
			dropShadows: false                            // disable drop shadows
		});

		jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');

		var primaryMenuWidth = jQuery("ul#primary").width();
		var primaryMenuLeft = Math.round((960 - primaryMenuWidth) / 2);
		if (primaryMenuWidth < 960) jQuery("ul#primary").css('padding-left',primaryMenuLeft);

		var secondaryMenuWidth = jQuery("ul#secondary").width();
		var secondaryMenuLeft = Math.round((960 - secondaryMenuWidth) / 2);
		if (secondaryMenuWidth < 960) jQuery("ul#secondary").css('padding-left',secondaryMenuLeft);

		var $smallTag = jQuery('span.price2 span');
		$smallTag.each(function(){
		   var divWidth = (jQuery(this).parents('div.thumbnail').length) ? jQuery(this).parents('div.thumbnail').width() : jQuery(this).parents('div#product-slider').width(),
			  tagWidth = jQuery(this).innerWidth(),
			  leftPos = Math.round((divWidth-tagWidth)/2);


		   jQuery(this).parent().css({left: leftPos});
		});

		var $featuredTag = jQuery('span.price span');
		$featuredTag.each(function(){
		   var divWidth = jQuery(this).parents('div.slide-info').width(),
			  tagWidth = jQuery(this).innerWidth(),
			  leftPos = Math.round((divWidth-tagWidth)/2)-3;

		   jQuery(this).parent().css({left: leftPos});
		});

		<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>

		var $featured_slides = jQuery('#slides'),
			$controllers = jQuery('#controllers'),
			controller_item = 'a.smallthumb',
			right_arrow = 'a#right-arrow',
			left_arrow = 'a#left-arrow',
			movearrow = true;

		et_search_bar();

		jQuery(window).load( function(){
			if ($featured_slides.length) et_cycle_integration();
		} );

		<!---- Featured Slider Cycle Integration ---->
		function et_cycle_integration(){
			var $et_active_arrow = jQuery('span#active-arrow'),
				$et_controller_links = jQuery('#controllers a.smallthumb');

			et_featured_options = {
				fx: '<?php echo(get_option('elegantestate_slider_effect')); ?>',
				timeout: 0,
				speed: 300,
				cleartypeNoBg: true,
				prev:   '#featured a#left-arrow',
				next:   '#featured a#right-arrow',
				before: function (currSlideElement, nextSlideElement, options, forwardFlag) {
					var $et_active_slide = jQuery(nextSlideElement),
						et_active_order = $et_active_slide.prevAll().length;

					$et_controller_links.removeClass('active').eq(et_active_order).addClass('active');
					$et_active_arrow.animate({"left": $et_controller_links.eq(et_active_order).position().left + 18}, 400);
				}
			}

			<?php if (get_option('elegantestate_slider_auto') == 'on') { ?>
				et_featured_options.timeout = <?php echo(get_option('elegantestate_slider_autospeed')); ?>;
			<?php } ?>

			$featured_slides.css( 'backgroundImage', 'none' );
			$featured_slides.cycle( et_featured_options );

			$et_controller_links.click(function(){
				var et_ordernumber = jQuery(this).prevAll('a.smallthumb').length;
				$featured_slides.cycle( et_ordernumber );
				return false;
			});
		}

		<!---- Search Bar Improvements ---->
		function et_search_bar(){
			var $searchform = jQuery('#search-container'),
				$searchinput = $searchform.find("input#searchinput"),
				searchvalue = $searchinput.val();

			$searchinput.focus(function(){
				if (jQuery(this).val() === searchvalue) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
			});
		}


		<!-- single page slider -->

		if (jQuery('#product-slides').length) {
			$small_controller = jQuery('#product-thumbs .small-controller');
			jQuery('#product-slides').cycle({
				fx: 'fade',
				timeout: 0,
				speed: 700,
				cleartypeNoBg: true,
				prev:   '#product-thumbs a#left-arrow',
				next:   '#product-thumbs a#right-arrow',
				before: function (currSlideElement, nextSlideElement, options, forwardFlag) {
					var $et_active_slide = jQuery(nextSlideElement),
						et_active_order = $et_active_slide.prevAll().length;

					$small_controller.removeClass('active').eq(et_active_order).addClass('active');
				}
			});

			$small_controller.click(function(){
				var et_ordernumber2 = jQuery(this).prevAll('a.small-controller').length;
				jQuery('#product-slides').cycle( et_ordernumber2 );
				return false;
			});
		}

	//]]>
	</script>