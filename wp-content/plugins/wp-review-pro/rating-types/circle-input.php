<?php
/**
 * Star rating type output template
 * 
 * @since     2.0
 * @copyright Copyright (c) 2013, MyThemesShop
 * @author    MyThemesShop
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_script( 'jquery-knob', trailingslashit( WP_REVIEW_ASSETS ) . 'js/jquery.knob.min.js', array( 'jquery' ), '1.1', true );
wp_enqueue_script( 'wp-review-circle-input', trailingslashit( WP_REVIEW_URI ) . 'rating-types/circle-input.js', array( 'jquery' ) );

$class = 'review-circle';
if (!empty($rating['args']['class']))
	$class .= ' '.sanitize_html_class( $rating['args']['class'] );

$knob_attrs = array(
	'width' => '100',
	'height' => '100',
	'displayInput' => 'true',
	'displayPrevious' => 'true',
	'fgColor' => $rating['color']
);
	

$knob_attrs_str = '';
foreach ($knob_attrs as $attr_name => $attr_value) {
	$knob_attrs_str .= 'data-' . $attr_name . '="' . $attr_value . '" ';
}
?>
<div class="<?php echo $class; ?>">
	<div class="review-result-wrapper">
		<input type="text" class="wp-review-circle-rating-user wp-review-user-rating-val" value="<?php echo esc_attr( $rating['value'] ); ?>" <?php echo $knob_attrs_str; ?> name="wp-review-user-rating-val" />
	</div>
	<div class="wp-review-circle-rating-send-button"><a href="#" class="wp-review-circle-rating-send"><?php _e('Send Rating', 'wp-review'); ?></a></div>

	<input type="hidden" class="wp-review-user-rating-nonce" value="<?php echo esc_attr( wp_create_nonce( 'wp-review-security' ) ); ?>" />
	<input type="hidden" class="wp-review-user-rating-postid" value="<?php echo esc_attr( $rating['post_id'] ); ?>" />
</div><!-- .review-circle -->

<style type="text/css">
.wp-review-<?php echo $rating['post_id']; ?> .wp-review-circle-rating-send {
	color: <?php echo $rating['color']; ?>;
}
.wp-review-<?php echo $rating['post_id']; ?> .wp-review-circle-rating-send:hover {
	color: <?php echo $rating['colors']['fontcolor']; ?>;
}
</style>
