    "use strict";
    jQuery( document ).ready(function() {
		var container = jQuery('.contentomatic-five-star-wp-rate-action');
		if (container.length) {
			container.find('a').on('click', function() {
				container.remove();
				jQuery.post(
					ajaxurl,
					{
						action: 'contentomatic-five-star-wp-rate'
					},
					function(result) {}
				);
			});
		}
	});