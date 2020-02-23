(function($){
	$(document).ready(function(){
		et_search_bar();

		function et_search_bar(){
			var $searchform = jQuery('#listing-control div#search-form'),
				$searchinput = $searchform.find("input#searchinput"),
				searchvalue = $searchinput.val();

			$searchinput.focus(function(){
				if (jQuery(this).val() === searchvalue) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
			});
		}

		var $footer_widget = jQuery("#main-footer .footer-widget");

		if ( $footer_widget.length ) {
			$footer_widget.each(function (index, domEle) {
				if ( ( index+1 ) % 4 == 0 ) jQuery( domEle ).addClass("last").after("<div class='clear'></div>");
			});
		}

		var $comment_form = jQuery('form#commentform');
		$('form#commentform input:text, form#commentform textarea, #elist_submit_form input:text, #elist_submit_form textarea, #main_content #register-form form input:text, #main_content #register-form form input:password, #main_content #register-form form textarea').each(function(index,domEle){
			var $et_current_input = jQuery(domEle),
				$et_comment_label = $et_current_input.siblings('label'),
				et_comment_label_value = $et_current_input.siblings('label').text();
			if ( $et_comment_label.length ) {
				if ( 'file' != $et_current_input.attr( 'type' ) ) $et_comment_label.hide();
				if ( $et_current_input.siblings('span.required') ) {
					et_comment_label_value += $et_current_input.siblings('span.required').text();
					$et_current_input.siblings('span.required').hide();
				}
				if ( '' == $et_current_input.val() ) $et_current_input.val(et_comment_label_value);
			}
		}).live('focus',function(){
			var et_label_text = jQuery(this).siblings('label').text();
			if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
			if (jQuery(this).val() === et_label_text) jQuery(this).val("");
		}).live('blur',function(){
			var et_label_text = jQuery(this).siblings('label').text();
			if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
			if (jQuery(this).val() === "") jQuery(this).val( et_label_text );
		});

		// remove placeholder text before form submission
		$comment_form.submit(function(){
			$comment_form.find('input:text, textarea').each(function(index,domEle){
				var $et_current_input = jQuery(domEle),
					$et_comment_label = $et_current_input.siblings('label'),
					et_comment_label_value = $et_current_input.siblings('label').text();

				if ( $et_comment_label.length && $et_comment_label.is(':hidden') ) {
					if ( $et_comment_label.text() == $et_current_input.val() )
						$et_current_input.val( '' );
				}
			});
		});

		$('#elist_submit_form').submit(function(e){
			$(this).find('input, textarea').each(function (index, domEle) {
				var et_req = '';
				if ( $(domEle).siblings('span.required').length ) et_req = $(domEle).siblings('span.required').text();
				if ( $(domEle).val() === ( $(domEle).siblings('label').text() + et_req ) ) $(domEle).val('');
			});
		});

		var $slider = $('#featured'),
			$featured_content = $slider.find('#slides');

		$(window).load( function(){
			if ( $featured_content.length ) {
				var $featured_controllers_links = $slider.find('#controllers a'),
				et_slider_settings = {
					timeout: 0,
					cleartypeNoBg: true,
					prev: '#featured a#left-arrow',
					next: '#featured a#right-arrow',
					before: function (currSlideElement, nextSlideElement, options, forwardFlag) {
								var $et_active_slide = $(nextSlideElement),
									et_active_order = $et_active_slide.prevAll().length;

								$featured_controllers_links.removeClass('activeSlide').eq(et_active_order).addClass('activeSlide');
							}
				}

				if ( $featured_content.is('.et_slider_auto') ) {
					var et_slider_autospeed_class_value = /et_slider_autospeed_(\d+)/g
						et_slider_autospeed = et_slider_autospeed_class_value.exec( $featured_content.attr('class') );

					et_slider_settings.timeout = et_slider_autospeed[1];
					if ( $featured_content.is('.et_slider_pause') ) et_slider_settings.pause = 1;
				}

				$featured_content.css( 'backgroundImage', 'none' );
				$featured_content.cycle( et_slider_settings );

				if ( $featured_content.find('.slide').length == 1 ){
					$featured_content.find('.slide').css({'position':'absolute','top':'0','left':'0'}).show();
					jQuery('#featured a#left-arrow, #featured a#right-arrow, #featured #controllers').hide();
				}

				$featured_controllers_links.click(function(){
					et_ordernumber = jQuery(this).prevAll().length;
					$featured_content.cycle( et_ordernumber );
					return false;
				})
			}
		} );

		var $categories_dropdown = $('select#elist_categories');
		$categories_dropdown.change( function(){
			if ( $(this).val() != -1 ) location.href = elist_settings.home_url + '/?elist_taxonomy=' + $(this).val();
		} );

		$('.r-listing.last, .l-category.last').after('<div class="clear"></div>');

		var $main_content = $('#main_content'),
			$sidebar = $('#sidebar'),
			$r_listing = $('.r-listing'),
			max_height = 0;

		if ( $main_content.height() > $sidebar.height() ) $sidebar.css( 'height', $main_content.height() );
		if ( $r_listing.length ) {
			$r_listing.each(function (index, domEle) {
				if ( $(domEle).height() > max_height ) max_height = $(domEle).height();
			});
			$r_listing.css( 'min-height', max_height );
		}
	});
})(jQuery)