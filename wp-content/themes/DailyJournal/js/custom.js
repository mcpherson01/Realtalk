(function($){
	var $et_content = $('#content'),
		$et_mobile_nav_button = $('#mobile_nav'),
		$et_nav = $('#main-menu'),
		et_container_width = $et_content.width();

	$(document).ready(function(){
		$et_content.css( 'minHeight', $(window).height() );
		$('#widgets').clone().appendTo('#left-column');

		$et_nav.find('> ul').superfish({
			delay:       500,                            // one second delay on mouseout
			animation:   {'marginLeft':'0px',opacity:'show'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			onBeforeShow: function(){ this.css('marginLeft','10px'); },
			autoArrows:  true,                           // disable generation of arrow mark-up
			dropShadows: false                            // disable drop shadows
		});

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
		}).bind('focus',function(){
			var et_label_text = jQuery(this).siblings('label').text();
			if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
			if (jQuery(this).val() === et_label_text) jQuery(this).val("");
		}).bind('blur',function(){
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

		if ( $('ul.et_disable_top_tier').length ) $("ul.et_disable_top_tier > li > ul").prev('a').attr('href','#');
	});

	$(window).load( calculate_content_height );
	$(window).resize( calculate_content_height );

	function calculate_content_height(){
		var max_height = $(window).height(),
			left_sidebar_height = $('#left-column').height(),
			right_widgets_height;

		if ( left_sidebar_height > max_height ) max_height = left_sidebar_height;

		if ( $et_content.find('> #widgets').is(':visible') ){
			right_widgets_height = $et_content.find('> #widgets').height();
			if ( right_widgets_height > max_height ) max_height = right_widgets_height;
		}
		$et_content.css( 'minHeight', max_height );
	}

	if ( et_container_width <= 418 ){
		$et_nav.addClass('mobile_nav').find('> ul').removeClass('nav');
	}

	$(window).resize( function(){
		if ( et_container_width != $et_content.width() ) {
			et_container_width = $et_content.width();
			if ( et_container_width <= 418 ){
				$et_nav.addClass('mobile_nav').find('> ul').removeClass('nav').css({ 'display' : 'none', 'opacity' : '0', 'height' : '0' });
				$et_mobile_nav_button.removeClass( 'opened' ).addClass( 'closed' );
			} else {
				$et_nav.removeClass('mobile_nav').find('> ul').addClass('nav').css({ 'display' : 'block', 'opacity' : '1', 'height' : '100%' });
			}
		}
	});

	$et_mobile_nav_button.click( function(){
		if ( $(this).hasClass('closed') ){
			$(this).removeClass( 'closed' ).addClass( 'opened' );
			$et_nav.find('> ul').css({ opacity : 0, 'display' : 'block', height : 0 }).animate( { opacity: 1, height: '100%' }, 500 );
		} else {
			$(this).removeClass( 'opened' ).addClass( 'closed' );
			$et_nav.find('> ul').animate( { opacity: 0, height: 0 }, 500, function(){
				$(this).css( { 'display' : 'none' } );
			} );
		}
		return false;
	} );
})(jQuery)