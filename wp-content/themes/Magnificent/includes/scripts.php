<?php global $shortname; ?>

	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>


	<script type="text/javascript">
	//<![CDATA[
		jQuery.noConflict();

		jQuery(document).ready(function(){
			jQuery('ul.nav').superfish({
				delay:       300,                            // one second delay on mouseout
				animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
				speed:       'fast',                          // faster animation speed
				autoArrows:  true,                           // disable generation of arrow mark-up
				dropShadows: false                            // disable drop shadows
			});

			jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');

			et_search_bar();

			var $featured_content = jQuery('#slides');

			jQuery(window).load( function(){
				if ($featured_content.length) {
					$featured_content.css( 'backgroundImage', 'none' );
					$featured_content.cycle({
						<?php if(get_option($shortname.'_slider_auto') == 'on') { ?>
							timeout: <?php echo esc_js(get_option($shortname.'_slider_autospeed')); ?>
						<?php } else { ?>
							timeout: 0
						<?php }; ?>,
						<?php if(get_option($shortname.'_pause_hover') == 'on') { ?>
							pause: true,
						<?php } ?>
						speed: 500,
						cleartypeNoBg: true,
						prev:   '#featured a#left-arrow',
						next:   '#featured a#right-arrow'
					});

					if ( $featured_content.find('.slide').length == 1 ){
						$featured_content.find('.slide').css({'position':'absolute','top':'8px','left':'8px'}).show();
					}
				}
			} );

			<!---- Search Bar Improvements ---->
			function et_search_bar(){
				var $searchform = jQuery('div#search-form'),
					$searchinput = $searchform.find("input#searchinput"),
					searchvalue = $searchinput.val();

				$searchinput.focus(function(){
					if (jQuery(this).val() === searchvalue) jQuery(this).val("");
				}).blur(function(){
					if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
				});
			};

			/* footer widgets improvements */

			var $footer_widget = jQuery("#footer .footer-widget");

			if (!($footer_widget.length == 0)) {
				$footer_widget.each(function (index, domEle) {
					// domEle == this
					if ((index+1)%4 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
				});
			};

			var $threaded_comments = jQuery('.depth-1 > ul.children');

			if ($threaded_comments.length) {
				$threaded_comments.each(function(index, domEle) {
					var $right_place = jQuery(domEle).parent('.depth-1').find('.entry-content');
					jQuery(domEle).appendTo($right_place);
				});
			}

			<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>
		});
	//]]>
	</script>