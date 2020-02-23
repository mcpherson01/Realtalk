jQuery.noConflict();

jQuery(document).ready(function(){
	var $featured_content = jQuery('#featured-slides'),
		et_disable_toptier = jQuery("meta[name=et_disable_toptier]").attr('content'),
		et_featured_slider_auto = jQuery("meta[name=et_featured_slider_auto]").attr('content'),
		et_featured_auto_speed = jQuery("meta[name=et_featured_auto_speed]").attr('content'),
		et_featured_slider_pause = jQuery("meta[name=et_featured_slider_pause]").attr('content'),
		$et_top_menu = jQuery('ul#top-menu > li > ul');

	jQuery('ul.nav').superfish({
		delay:       300,                            // one second delay on mouseout
		animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
		speed:       'fast',                          // faster animation speed
		autoArrows:  true,                           // disable generation of arrow mark-up
		dropShadows: false                            // disable drop shadows
	});

	if ( $et_top_menu.length ){
		$et_top_menu.prepend('<li class="menu-gradient"></li>');
	}

	jQuery(window).load( function(){
		if ($featured_content.length){
			var et_featured_options = {
				timeout: 0,
				speed: 500,
				cleartypeNoBg: true,
				prev:   '#featured a#left-arrow',
				next:   '#featured a#right-arrow'
			}
			if ( et_featured_slider_auto == 1 ) et_featured_options.timeout = et_featured_auto_speed;
			if ( et_featured_slider_pause == 1 ) et_featured_options.pause = 1;

			$featured_content.css( 'backgroundImage', 'none' );
			$featured_content.cycle( et_featured_options );

			if ( $featured_content.find('.slide').length == 1 ){
				$featured_content.find('.slide').css({'position':'absolute','top':'0','left':'0'}).show();
				jQuery('#featured a#left-arrow, #featured a#right-arrow').hide();
			}
		}
	} );

	var $footer_widget = jQuery("#footer-widgets .footer-widget");
	if ( $footer_widget.length ) {
		$footer_widget.each(function (index, domEle) {
			if ((index+1)%3 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
		});
	}

	et_search_bar();

	function et_search_bar(){
		var $searchform = jQuery('#bottom-header div#search-form'),
			$searchinput = $searchform.find("input#searchinput"),
			searchvalue = $searchinput.val();

		$searchinput.focus(function(){
			if (jQuery(this).val() === searchvalue) jQuery(this).val("");
		}).blur(function(){
			if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
		});
	}

	if ( et_disable_toptier == 1 ) jQuery("ul.nav > li > ul").prev("a").attr("href","#");

	var $comment_form = jQuery('form#commentform');


	$comment_form.find('input:text, textarea').each(function(index,domEle){
		var $et_current_input = jQuery(domEle),
			$et_comment_label = $et_current_input.siblings('label'),
			et_comment_label_value = $et_current_input.siblings('label').text();
		if ( $et_comment_label.length ) {
			$et_comment_label.hide();
			if ( $et_current_input.siblings('span.required') ) {
				et_comment_label_value += $et_current_input.siblings('span.required').text();
				$et_current_input.siblings('span.required').hide();
			}
			$et_current_input.val(et_comment_label_value);
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
});