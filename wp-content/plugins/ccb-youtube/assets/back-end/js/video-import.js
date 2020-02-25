/**
 * Video import form functionality
 * @version 1.0
 */
;(function($){
	$(document).ready(function(){
		// search criteria form functionality
		$('#cbc_feed').change(function(){
			var val = $(this).val(),
				ordVal = $('#cbc_order').val();
			
			$('label[for=cbc_query]').html($(this).find('option:selected').html()+' :');
						
			switch( val ){
				case 'query':
					$('tr.cbc_duration').show();
					$('tr.cbc_order').show();
					var hide = ['position', 'commentCount', 'duration', 'reversedPosition', 'title'],
						show = ['relevance', 'rating'];
					
					$.each( hide, function(i, el){
						$('#cbc_order option[value='+el+']').attr({'disabled':'disabled'}).css('display', 'none');
					})
					$.each( show, function(i, el){
						$('#cbc_order option[value='+el+']').removeAttr('disabled').css('display', '');
					})
					
					var hI = $.inArray( ordVal, hide );					
					if( -1 !== hI ){
						$('#cbc_order option[value='+hide[hI]+']').removeAttr('selected');
					}					
					
				break;
				case 'user':
				case 'playlist':
				case 'channel':
					$('tr.cbc_duration').hide();
					$('tr.cbc_order').hide();
					
					var show = ['position', 'commentCount', 'duration', 'reversedPosition', 'title'],
						hide = ['relevance', 'rating'];
				
					$.each( hide, function(i, el){
						$('#cbc_order option[value='+el+']').attr({'disabled':'disabled'}).css('display', 'none');
					})
					$.each( show, function(i, el){
						$('#cbc_order option[value='+el+']').removeAttr('disabled').css('display', '');
					})
					
					var hI = $.inArray( ordVal, hide );					
					if( -1 !== hI ){
						$('#cbc_order option[value='+hide[hI]+']').removeAttr('selected');
					}
					
				break;
			}			
		}).trigger('change');
		
		$('#cbc_load_feed_form').submit(function(e){
			var s = $('#cbc_query').val();
			if( '' == s ){
				e.preventDefault();
				$('#cbc_query, label[for=cbc_query]').addClass('cbc_error');
			}
		});
		$('#cbc_query').keyup(function(){
			var s = $(this).val();
			if( '' == s ){
				$('#cbc_query, label[for=cbc_query]').addClass('cbc_error');
			}else{
				$('#cbc_query, label[for=cbc_query]').removeClass('cbc_error');
			}	
		})
		
		// checkbox selectors
		var selects = $('input[name=select_all]');
		selects.click( function(){
			if( $(this).is(':checked') ){
				$('input[type=checkbox].cbc-item-check').attr('checked', true);
				$('input[type=checkbox].cbc-item-check').parents('.cbc-video-item').addClass('checked');
				$(selects).attr('checked', true);
			}else{
				$('input[type=checkbox].cbc-item-check').attr('checked', false);
				$('input[type=checkbox].cbc-item-check').parents('.cbc-video-item').removeClass('checked');
				$(selects).attr('checked', false);
			}			
		});
		
		$('input[type=checkbox].cbc-item-check').click(function(){
			if( $(this).is(':checked') ){				
				$(this).parents('.cbc-video-item').addClass('checked');
			}else{
				$(this).parents('.cbc-video-item').removeClass('checked');
			}
		})
		
		$('#cbc-new-search').click( function(e){
			e.preventDefault();
			$('#search_box').toggle(100);
		})
		
		// view switcher functionality
		var switches = $('.view-switch .cbc-view');		
		switches.click( function(e){
			e.preventDefault();
			$(switches).removeClass('current');
			$(this).addClass('current');
			
			var v = $(this).data('view'),
				c = v == 'list' ? 'grid' : 'list' ;			
			$('.cbc-video-item').removeClass(c).addClass( v );
			
			cbc_view_data.view = v;
			
			$.ajax({
				type 	: 'post',
				url 	: ajaxurl,
				data	: cbc_view_data,
				dataType: 'json'
			});			
		})
		
		/**
		 * Feed results table functionality
		 */		
		// rename table action from action (which conflicts with ajax) to action_top
		$('.ajax-submit .tablenav.top .actions select[name=action]').attr({'name' : 'action_top'});		
		// form submit on search results
		var submitted = false;
		$('.ajax-submit').submit(function(e){
			e.preventDefault();
			if( submitted ){
				$('.cbc-ajax-response')
					.html(cbc_importMessages.wait);
				return;
			}
			
			var dataString 	= $(this).serialize();
			submitted = true;
			
			$('.cbc-ajax-response')
				.removeClass('success error')
				.addClass('loading')
				.html(cbc_importMessages.loading);
			
			$.ajax({
				type 	: 'post',
				url 	: ajaxurl,
				data	: dataString,
				dataType: 'json',
				success	: function(response){
					if( response.success ){
						$('.cbc-ajax-response')
							.removeClass('loading error')
							.addClass('success')
							.html( response.success );
					}else if( response.error ){
						$('.cbc-ajax-response')
							.removeClass('loading success')
							.addClass('error')
							.html( response.error );
					}										
					submitted = false;
				},
				error: function(response){
					$('.cbc-ajax-response')
						.removeClass('loading success')
						.addClass('error')
						.html( cbc_importMessages.server_error + '<div id="cbc_server_error_output" style="display:none;">'+ response.responseText +'</div>' );
					
					$('#cbc_import_error').click(function(e){
						e.preventDefault();
						$('#cbc_server_error_output').toggle();
					});
					
					submitted = false;
				}
			});			
		});	

		// corellate value of top and bottom category select boxes
		var f = function( s1, s2 ){
			$('#' + s1).on( 'change', function(e){			
				$('#' + s2 + ' option[value=' + $(this).val() + ']').prop( 'selected', true );
			});
		}
		
		f( 'cbc_video_categories2', 'cbc_video_categories_top' );
		f( 'cbc_video_categories_top', 'cbc_video_categories2' );

	})
})(jQuery);