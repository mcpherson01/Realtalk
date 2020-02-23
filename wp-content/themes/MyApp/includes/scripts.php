<?php global $shortname; ?>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js" type="text/javascript"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js" type="text/javascript"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.backgroundPosition.js" type="text/javascript"></script>

	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		jQuery.noConflict();

		jQuery('ul.superfish').superfish({
			delay:       300,                            // one second delay on mouseout
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			autoArrows:  true,                           // disable generation of arrow mark-up
			dropShadows: false                            // disable drop shadows
		}).find("> li > ul > li:last, > li > ul > li > ul > li:last, > li > ul > li > ul > li > ul > li:last").addClass("last");

		var $featured_content = jQuery('#slider .slide'),
			$tabbed_area = jQuery('#side-tabs ul'),
			$tab_content = jQuery('.tab-content'),
			$controllers = jQuery('div#controllers');

		et_search_bar();

		jQuery(window).load( function(){
			if ($featured_content.length) {
				$featured_content.cycle({
					fx: 'scrollHorz',
					timeout: 0,
					speed: 700,
					cleartypeNoBg: true,
					pager:  'div#controllers'
				});

				var controllersWidth = $controllers.width(),
					controllersLeft = Math.round((280 - controllersWidth) / 2);
					$controllers.css('left',controllersLeft);
			};

			if ($tabbed_area.length) {

				var animating = false,
					divAnimated = false;
				jQuery('body.home #main-area').css('backgroundImage','none');
				$tab_content.hide().filter(':first').show();
				$tabbed_area.css( {backgroundPosition: "0px 0px"} );

				$tabbed_area.find('li a').click(function(){
					this_element = jQuery(this);

					tab_order = this_element.parent('li').prevAll().length;
					previouslyActiveTab = jQuery('.tab-content').filter(':visible').prevAll('.tab-content').length;

					if ( (tab_order != previouslyActiveTab) && !animating ) {
						$tabbed_area.find('li a.activeTab').removeClass('activeTab');
						activeTop = this_element.position().top - 43;

						animating = true;
						var $visibleDiv = $tab_content.filter(':visible'),
							$divToAnimate = $tab_content.filter(':eq('+tab_order+')');


						$visibleDiv.fadeOut(500,function(){
						   $visibleDiv.css({opacity:0});
						   $divToAnimate.css({opacity:1}).fadeIn(500,function(){if (jQuery.browser.msie) this.style.removeAttribute('filter');});
						   divAnimated = true;
						});

						$tabbed_area.stop().animate({backgroundPosition:"(0px "+activeTop+"px)"}, 500,function(){
							this_element.addClass('activeTab');
							if (divAnimated) {
								animating = false;
								divAnimated = false;
							} else {
								var wait = setInterval(function() {
									if (divAnimated) {
										animating = false;
										divAnimated = false;
										clearInterval(wait);
									};
								}, 100);
							};
						});
					};

					return false;
				});
			};
		} );

		<!---- Search Bar Improvements ---->
		function et_search_bar(){
			var $searchform = jQuery('#breadcrumbs div#search-form'),
				$searchinput = $searchform.find("input#searchinput"),
				searchvalue = $searchinput.val();

			$searchinput.focus(function(){
				if (jQuery(this).val() === searchvalue) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
			});
		};

		<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>

	//]]>
	</script>