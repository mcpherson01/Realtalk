(function () {
	"use strict";

    window.onYottieReady = function() {
		jQuery('[data-elfsight-youtube-gallery-options]').each(function() {
			var $widget = jQuery(this);
			var options = $widget.attr('data-elfsight-youtube-gallery-options');
			var data = JSON.parse(decodeURIComponent(options));

			$widget.yottie(data).removeAttr('data-elfsight-youtube-gallery-options').data('elfsight-options', options);
		});
	};

	//= ../app/yottie/dist/yottie/jquery.yottie.bundled.js
})();