jQuery.noConflict();

jQuery(document).ready(function(){
	var et_is_ie = jQuery.browser.msie;

	var $et_background_image = jQuery('#backgrounds img'),
		$et_featured_slide = jQuery('#featured-text .slide'),
		et_animating = false,
		et_bg_image_speed = jQuery("meta[name=et_bg_image_speed]").attr('content'),
		et_service_image_speed = jQuery("meta[name=et_service_image_speed]").attr('content'),
		et_disable_toptier = jQuery("meta[name=et_disable_toptier]").attr('content');

	if ( et_bg_image_speed === '' ) et_bg_image_speed = 8000;
	if ( et_service_image_speed === '' ) et_service_image_speed = 1000;

	if ( $et_background_image.length > 1 ) {
		$et_background_image.css({'visibility':'hidden','display':'none'}).filter(':first').css({'visibility':'visible','display':'block'}).addClass('active');

		if ( !et_is_ie )
			$et_featured_slide.css({'visibility':'hidden','display':'none'}).filter(':first').css({'visibility':'visible','display':'block'}).addClass('active');
		else
			$et_featured_slide.css({'display':'none'}).filter(':first').css({'display':'block'}).addClass('active');

		var et_current_slide = 0;

		function et_animate_bg(){
			et_animating = true;
			var $et_active_bg_image = $et_background_image.filter('.active'),
				$et_active_featured_slide = $et_featured_slide.filter('.active');

			$et_active_bg_image.animate({'opacity': 'hide'}, 1000);

			if ( $et_active_bg_image.next('img').length )
				$et_nextImg = $et_active_bg_image.next('img');
			else $et_nextImg = $et_background_image.filter(':first');

			$et_active_bg_image.removeClass('active');

			$et_nextImg.css({'visibility': 'visible', 'opacity': 'hide'}).animate({'opacity': 'show'}, 1000, function(){
				jQuery(this).addClass('active');
				et_animating = false;

				var animateBg = setTimeout( et_animate_bg, et_bg_image_speed );
			});

			et_featured_slide_animate();
		}

		setTimeout( et_animate_bg, et_bg_image_speed );
	} else {
		if ( $et_featured_slide.length > 1 ) {
			if ( !et_is_ie )
			   $et_featured_slide.css({'visibility':'hidden','display':'none'}).filter(':first').css({'visibility':'visible','display':'block'}).addClass('active');
			else
				$et_featured_slide.css({'display':'none'}).filter(':first').css({'display':'block'}).addClass('active');

			et_current_slide = 0;

			function et_animate_slides(){
				var animateFeaturedSlides = setTimeout( et_animate_slides, et_bg_image_speed );
				et_featured_slide_animate();
			}

			setTimeout( et_animate_slides, et_bg_image_speed );
		}
	}

	function et_featured_slide_animate(){
		if ( $et_featured_slide.length > 1 ) {
			if ( !et_is_ie )
				$et_featured_slide.filter('.active').removeClass('active').animate({'opacity': 'hide'}, 1000);
			else
				$et_featured_slide.filter('.active').removeClass('active').hide();

			if ( $et_featured_slide.filter(':eq('+(et_current_slide+1)+')').length ) et_current_slide = et_current_slide + 1;
			else et_current_slide = 0;

			$et_featured_slide.filter(':eq('+et_current_slide+')').css({'visibility': 'visible', 'opacity': 'hide'}).animate({'opacity': 'show'}, 1000, function(){
				jQuery(this).addClass('active');
			});
		}
	}


	var $et_service = jQuery('.service'),
		$et_hovered_service;

	if ( $et_service.length ){
		$et_service.each(function (index, domEle) {
			jQuery(domEle).find('.service-slide').css({'visibility':'hidden','display':'none'}).filter(':first').css({'visibility':'visible','display':'block'}).addClass('active');
		});

		function et_rotate_service_images(){
			if ( et_animating ) return;
			var $et_service_slide = $et_hovered_service.find('.service-slide');

			if ( $et_service_slide.length === 1 ) return;
			var current_active_element = $et_hovered_service.find('.active').removeClass('active').prevAll().length;

			if ($et_service_slide.filter(':eq('+(current_active_element+1)+')').length) current_active_element = current_active_element + 1;
			else current_active_element = 0;

			$et_service_slide.stop(true,true).animate({'opacity': 'hide'}, 700).filter(':eq('+current_active_element+')').css({'visibility': 'visible', 'opacity': 'hide'}).stop(true,true).animate({'opacity': 'show'}, 700, function(){
				jQuery(this).addClass('active');
			});
		}

		$et_service.hover(function(){
			$et_hovered_service = jQuery(this);
			animateService = setInterval( et_rotate_service_images, et_service_image_speed );
		},function(){
			clearInterval(animateService);
		});
	}

	jQuery('ul.nav').superfish({
		delay:       500,                            // one second delay on mouseout
		animation:   {'marginLeft':'0px',opacity:'show'},  // fade-in and slide-down animation
		speed:       'fast',                          // faster animation speed
		onBeforeShow: function(){ this.css('marginLeft','20px'); },
		autoArrows:  true,                           // disable generation of arrow mark-up
		dropShadows: false                            // disable drop shadows
	}).find('> li > ul').prepend('<span class="top-arrow"></span>');
	jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');

	et_search_bar();

	function et_search_bar(){
		var $searchform = jQuery('#header div#search-form'),
			$searchinput = $searchform.find("input#searchinput"),
			searchvalue = $searchinput.val();

		$searchinput.focus(function(){
			if (jQuery(this).val() === searchvalue) jQuery(this).val("");
		}).blur(function(){
			if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
		});
	};

	if ( et_disable_toptier == 1 ) jQuery("ul.nav > li > ul").prev("a").attr("href","#");
});