;(function($){
	
	$(document).ready( function(){
		/**
		 * Bulk playlist importing functionality (top button, next to page title)
		 */
		$('#cbc_playlist_import_trigger').click(function(e){
			e.preventDefault();
			e.stopPropagation();
			$('#cbc_import_playlists').toggle(100);
		});
		
		$('#cbc_import_playlists').click(function(e){
			e.stopPropagation();
		});
		
		$(document).click( function(){
			$('#cbc_import_playlists').hide(100);
		})
		
	});
	
})(jQuery);