(function($){
	$(document).ready(function() {
		$('.upload_image_button').click( function( event ) {
			var $this_el = $(this);

			event.preventDefault();

			et_pb_file_frame = wp.media.frames.et_pb_file_frame = wp.media({
				title: $this_el.data( 'choose' ),
				library: {
					type: 'image'
				},
				button: {
					text: $this_el.data( 'update' ),
				},
				multiple: false
			});

			et_pb_file_frame.on( 'select', function() {
				var attachment = et_pb_file_frame.state().get('selection').first().toJSON();

				$this_el.prev( 'input' ).val( attachment.url );
			});

			et_pb_file_frame.open();
		} );

		var $format_video    = jQuery('#post-format-video'),
			$video_settings  = jQuery('.et_nexus_video_settings'),
			$format_settings = jQuery('.et_nexus_format_setting');

		if ( $format_video.is(':checked') )
			$video_settings.show();

		jQuery('.post-format').change( function() {
			var $this = jQuery(this);

			$format_settings.hide();

			if ( $this.is( '#post-format-video' ) )
				$video_settings.show();
		} );
	} );
} )(jQuery);