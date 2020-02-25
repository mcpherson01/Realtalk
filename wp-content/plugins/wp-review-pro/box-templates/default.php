<?php
/**
 * WP Review: Default
 * Description: Default Review Box template for WP Review
 * Version: 1.0.2
 * Author: MyThemesShop
 * Author URI: http://mythemeshop.com/
 *
 * @since     2.0
 * @copyright Copyright (c) 2013, MyThemesShop
 * @author    MyThemesShop
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
 *	Available items in $review array:
 *	
 *		'post_id', 
		'type',
		'heading', 
		'author', 
		'items', 
		'hide_desc', 
		'desc', 
		'desc_title', 
		'total', 
		'colors', 
		'width',
		'align',
		'schema',
		'schema_data',
		'show_schema_data',
		'rating_schema',
		'links',
		'user_review',
		'user_review_type',
		'user_review_total',
		'user_review_count',
		'user_has_reviewed',
		'comments_review'
 * 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wp_review_rating_types;

$classes = array();
if ( isset( $review['width'] ) && $review['width'] < 100 ) {
	$classes[] = 'wp-review-box-floating';
	if ( isset( $review['align'] ) && $review['align'] == 'right' ) {
		$classes[] = 'wp-review-box-float-right';
	} else {
		$classes[] = 'wp-review-box-float-left';
	}
} else {
	$classes[] = 'wp-review-box-full-width';
}
?>
<div id="review" class="review-wrapper wp-review-<?php echo $review['post_id']; ?> wp-review-<?php echo $review['type']; ?>-type delay-animation <?php echo join(' ', $classes); ?>">
	<?php if ( empty( $review['heading'] ) ) : ?>
		<?php echo apply_filters( 'wp_review_item_title_fallback', '' ); ?>
	<?php else: ?>
		<h5 class="review-title"><?php echo esc_html( $review['heading'] ); ?></h5>
	<?php endif; ?>
	<?php if ( $review['show_schema_data'] ) : ?>
		<div class="reviewed-item">
		<?php
		$schemas = wp_review_schema_types();
		$fields = isset( $schemas[ $review['schema'] ] ) && isset( $schemas[ $review['schema'] ]['fields'] ) ? $schemas[ $review['schema'] ]['fields'] : array();
		$image = $reviewed_item_data = $url = '';
		foreach ( $fields as $key => $data ) {
			if ( isset( $review['schema_data'][ $review['schema'] ][ $data['name'] ] ) && !empty( $review['schema_data'][ $review['schema'] ][ $data['name'] ] ) ) {
				if ( isset( $data['multiline'] ) && $data['multiline'] ) {
					$reviewed_item_data .= '<p><strong class="reviewed-item-data-label">'.$data['label'].':</strong> '. preg_replace('/\r\n|[\r\n]/', ', ', $review['schema_data'][ $review['schema'] ][ $data['name'] ] ).'</p>';
				} else {
					if ( 'image' === $data['name'] && !isset( $data['part_of'] ) ) {
						$image = wp_get_attachment_image( $review['schema_data'][ $review['schema'] ]['image']['id'], apply_filters( 'wp_review_item_reviewed_image_size', 'medium' ) );
					} else if ( 'url' === $data['name'] && !isset( $data['part_of'] ) ) {
						$url = '<p><a href="'.esc_url( $review['schema_data'][ $review['schema'] ][ $data['name'] ] ).'" class="reviewed-item-link">'.__('More...', 'wp-review').'</a></p>';
					} else {
						$reviewed_item_data .= '<p><strong class="reviewed-item-data-label">'.$data['label'].':</strong> '. $review['schema_data'][ $review['schema'] ][ $data['name'] ].'</p>';
					}
				}
			}
		}
		if ( !empty( $image ) ) echo '<div class="reviewed-item-image">'.$image.'</div>';
		if ( !empty( $reviewed_item_data ) ) echo '<div class="reviewed-item-data">'.$reviewed_item_data.$url.'</div>';
		?>
		</div>
	<?php endif; ?>
	<?php if ( $review['items'] && is_array( $review['items'] ) ) : ?>
		<ul class="review-list">
			<?php foreach ( $review['items'] as $item ) :
				$value_text = '';
				if ($review['type'] != 'star') {
					$value_text = ' - <span>'.sprintf($wp_review_rating_types[$review['type']]['value_text'], $item['wp_review_item_star']).'</span>';
				}
			 ?>
				<li>
					<?php 
					if(isset( $item['wp_review_item_star'] )) {
						echo wp_review_rating( $item['wp_review_item_star'], $review['post_id'] );
					}
					 ?>
					<span><?php echo wp_kses_post( $item['wp_review_item_title'] ); ?><?php echo $value_text; ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php if ( ! $review['hide_desc'] ) : ?>
		<?php if ( ! empty( $review['total'] ) ) :
			$total_text = $review['total'];
			if ( $review['type'] != 'star' ) {
				$total_text = sprintf( $wp_review_rating_types[$review['type']]['value_text'], $total_text );
			} else {
				$total_text = number_format_i18n( $review['total'], 1 );
			}
		 ?>
			<div class="review-total-wrapper">
				<span class="review-total-box"><?php echo $total_text; ?></span>
				<?php if ($review['type'] != 'point' && $review['type'] != 'percentage') : ?>
					<?php echo wp_review_rating( $review['total'], $review['post_id'], array('class' => 'review-total') ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ( $review['desc'] ) : ?>
			<div class="review-desc">
				<p class="review-summary-title"><strong><?php echo $review['desc_title']; ?></strong></p>
				<?php // echo do_shortcode( shortcode_unautop( wp_kses_post( wpautop( $review['desc'] ) ) ) ); ?>
				<?php echo apply_filters( 'wp_review_desc', $review['desc'] ); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( $review['user_review'] ) : ?>
		<div class="user-review-area visitors-review-area">
			<?php echo wp_review_user_rating( $review['post_id'] ); ?>
			<div class="user-total-wrapper">
				<span class="user-review-title"><?php _e( 'User Rating', 'wp-review' ); ?></span>
				<span class="review-total-box">
					<?php 
					$usertotal_text = $review['user_review_total'];
					if ($review['user_review_type'] != 'star') {
						$usertotal_text = sprintf( $wp_review_rating_types[$review['user_review_type']]['value_text'], $review['user_review_total'] );
					}
					?>
					<span class="wp-review-user-rating-total"><?php echo esc_html( $usertotal_text ); ?></span>
					<small>(<span class="wp-review-user-rating-counter"><?php echo esc_html( $review['user_review_count'] ); ?></span> <?php echo _n( 'vote', 'votes', $review['user_review_count'], 'wp-review' ); ?>)</small>
				</span>
			</div>
		</div>
	<?php endif; // $review['user_review'] ?>
	<?php if ( $review['comments_review'] ) : ?>
		<?php $hide_comments_total = get_post_meta( $post->ID, 'wp_review_hide_comments_total', true ); ?>
		<?php if ( '1' !== $hide_comments_total ) : ?>
		<div class="user-review-area comments-review-area">
			<?php echo wp_review_user_comments_rating( $review['post_id'] ); ?>
			<div class="user-total-wrapper">
				<span class="user-review-title"><?php _e( 'Comments Rating', 'wp-review' ); ?></span>
				<span class="review-total-box">
					<?php
					$commentReviews        = mts_get_post_comments_reviews( $review['post_id'] );
					$comments_review_total = $commentReviews['rating'];
					$comments_review_count = $commentReviews['count'];
					$commentstotal_text = $comments_review_total;
					if ($review['user_review_type'] != 'star') {
						$commentstotal_text = sprintf( $wp_review_rating_types[$review['user_review_type']]['value_text'], $comments_review_total );
					}
					?>
					<span class="wp-review-user-rating-total"><?php echo esc_html( $commentstotal_text ); ?></span>
					<small>(<span class="wp-review-user-rating-counter"><?php echo esc_html( $comments_review_count ); ?></span> <?php echo _n( 'review', 'reviews', $comments_review_count, 'wp-review' ); ?>)</small>
				</span>
			</div>
		</div>
		<?php endif; // $review['comments_review'] ?>
	<?php endif; // $review['comments_review'] ?>

	<?php if (!empty($review['links']) && is_array($review['links'])) : ?>
		<div class="review-links">
			<?php foreach ( $review['links'] as $link ) : ?>
				<li>
					<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank"><?php echo wp_kses_post( $link['text'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</div>
	<?php endif; // is_array($review['links']) ?>
</div>

<?php 
$colors = $review['colors'];
$color_output = <<<EOD

<style type="text/css">
	.wp-review-{$review['post_id']}.review-wrapper { width: {$review['width']}%; float: {$review['align']} }
	.wp-review-{$review['post_id']}.review-wrapper, .wp-review-{$review['post_id']} .review-title, .wp-review-{$review['post_id']} .review-desc p, .wp-review-{$review['post_id']} .reviewed-item p  { color: {$colors['fontcolor']};}
	.wp-review-{$review['post_id']} .review-links a { color: {$colors['color']};}
	.wp-review-{$review['post_id']} .review-links a:hover { color: {$colors['fontcolor']};}
	.wp-review-{$review['post_id']} .review-list li, .wp-review-{$review['post_id']}.review-wrapper{ background: {$colors['bgcolor2']};}
	.wp-review-{$review['post_id']} .review-title, .wp-review-{$review['post_id']} .review-list li:nth-child(2n){background: {$colors['bgcolor1']};}
	.wp-review-{$review['post_id']}.review-wrapper, .wp-review-{$review['post_id']} .review-title, .wp-review-{$review['post_id']} .review-list li, .wp-review-{$review['post_id']} .review-list li:last-child, .wp-review-{$review['post_id']} .user-review-area, .wp-review-{$review['post_id']} .reviewed-item {border-color: {$colors['bordercolor']};}
</style>

EOD;

// Apply legacy filter
echo apply_filters( 'wp_review_color_output', $color_output, $review['post_id'], $review['colors'] );
// Schema json-dl
echo wp_review_get_schema( $review );
