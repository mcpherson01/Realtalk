/**
 * 
 */
;(function($){
	$(document).ready(function(){
		
		$(document).on('change', '.cbc_aspect_ratio', function(){
			var aspect_ratio_input 	= this,
				parent				= $(this).parents('.cbc-player-settings-options'),
				width_input			= $(parent).find('.cbc_width'),
				height_output		= $(parent).find('.cbc_height');		
			
			var val = $(this).val(),
				w 	= Math.round( parseInt($(width_input).val()) ),
				h 	= 0;
			switch( val ){
				case '4x3':
					h = (w*3)/4;
				break;
				case '16x9':
					h = (w*9)/16;
				break;	
			}
			
			$(height_output).html(h);						
		});
		
		
		$(document).on( 'keyup', '.cbc_width', function(){
			var parent				= $(this).parents('.cbc-player-settings-options'),
				aspect_ratio_input	= $(parent).find('.cbc_aspect_ratio');		
						
			if( '' == $(this).val() ){
				return;				
			}
			var val = Math.round( parseInt( $(this).val() ) );
			$(this).val( val );	
			$(aspect_ratio_input).trigger('change');
		});
				
		
		// hide options dependant on controls visibility
		$('.cbc_controls').click(function(e){
			if( $(this).is(':checked') ){
				$('.controls_dependant').show();
			}else{
				$('.controls_dependant').hide();
			}
		})
		
		// in widgets, show/hide player options if latest videos isn't displayed as playlist
		$(document).on('click', '.cbc-show-as-playlist-widget', function(){
			var parent 		= $(this).parents('.cbc-player-settings-options'),
				player_opt 	= $(parent).find('.cbc-recent-videos-playlist-options'),
				list_thumbs = $(parent).find('.cbc-widget-show-yt-thumbs');
			if( $(this).is(':checked') ){
				$(player_opt).show();
				$(list_thumbs).hide();
			}else{
				$(player_opt).hide();
				$(list_thumbs).show();
			}
			
		})
		
	});
})(jQuery);