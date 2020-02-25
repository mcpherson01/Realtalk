jQuery(document).ready(function($) {
	$('.wp-review-user-rating-circle, .wp-review-comment-rating-circle').each(function(index, el) {
		var $rating_wrapper = $(this);
		
		$rating_wrapper.find('.wp-review-circle-rating-user').knob({
			release: function() {
				$rating_wrapper.addClass('wp-review-input-set');
			}
		});

		$rating_wrapper.find('.wp-review-circle-rating-send').click(function(event) {
			event.preventDefault();
			wp_review_rate($rating_wrapper);
		});
	});
});
