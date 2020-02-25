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

wp_enqueue_script( 'jquery-knob' );
wp_enqueue_script( 'wp-review-circle-output', trailingslashit( WP_REVIEW_URI ) . 'rating-types/circle-output.js', array( 'jquery' ) );


$class = 'review-circle';
if (!empty($rating['args']['class']))
	$class .= ' '.sanitize_html_class( $rating['args']['class'] );

// Default small knob
$knob_attrs = array(
	'width' => '32',
	'height' => '32',
	'displayInput' => 'false',
	'fgColor' => $rating['color']
);

// Total rating is large
if ( isset($rating['args']['class']) && $rating['args']['class'] == 'review-total' ) {
	$knob_attrs['width'] = '100';
	$knob_attrs['height'] = '100';
	$knob_attrs['displayInput'] = 'true';
}

// Comment rating field & admin column rating is slightly larger too
if ( ! empty( $rating['comment_rating'] ) || ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) ) {
	$knob_attrs['width'] = '64';
	$knob_attrs['height'] = '64';
	$knob_attrs['displayInput'] = 'true';
}

$knob_attrs_str = '';
foreach ($knob_attrs as $attr_name => $attr_value) {
	$knob_attrs_str .= 'data-' . $attr_name . '="' . $attr_value . '" ';
}
?>
<div class="<?php echo $class; ?>">
	<div class="review-result-wrapper">
		<input type="text" class="wp-review-circle-rating" value="<?php echo esc_attr( $rating['value'] ); ?>" readonly="readonly" <?php echo $knob_attrs_str; ?>/>
	</div>
</div><!-- .review-circle -->