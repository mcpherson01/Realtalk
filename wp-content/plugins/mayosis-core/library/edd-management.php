<?php
    
 $edditemlabel= get_theme_mod( 'site_product_type','default');
 
 if (  $edditemlabel=='products'):
function mayosis_edd_label($labels) {
	$labels = array(
	   'singular' => __('Product','mayosis'),
	   'plural' => __('Products','mayosis')
	);
	return $labels;
}
add_filter('edd_default_downloads_name', 'mayosis_edd_label');
define('EDD_SLUG', 'product');

 elseif ( $edditemlabel=='items'):
function mayosis_edd_label($labels) {
	$labels = array(
	   'singular' => __('Item','mayosis'),
	   'plural' => __('Items','mayosis')
	);
	return $labels;
}
add_filter('edd_default_downloads_name', 'mayosis_edd_label');
define('EDD_SLUG', 'item');

 elseif ( $edditemlabel=='music'):
     function mayosis_edd_label($labels) {
	$labels = array(
	   'singular' => __('Music','mayosis'),
	   'plural' => __('Musics','mayosis')
	);
	return $labels;
}
add_filter('edd_default_downloads_name', 'mayosis_edd_label');
define('EDD_SLUG', 'music');

 elseif ( $edditemlabel=='video'):
     
        function mayosis_edd_label($labels) {
	$labels = array(
	   'singular' => __('Video','mayosis'),
	   'plural' => __('Videos','mayosis')
	);
	return $labels;
}
add_filter('edd_default_downloads_name', 'mayosis_edd_label');
define('EDD_SLUG', 'video');

 elseif ( $edditemlabel=='photo'):
     
        function mayosis_edd_label($labels) {
	$labels = array(
	   'singular' => __('Photo','mayosis'),
	   'plural' => __('Photos','mayosis')
	);
	return $labels;
}
add_filter('edd_default_downloads_name', 'mayosis_edd_label');
define('EDD_SLUG', 'photo');

endif;

if ( class_exists( 'Easy_Digital_Downloads' ) ) :
 /**
 * Change Author Url
 *
 * @since mayosis 2.5
 */
 function mayosis_fes_author_url( $author = null ) {
     global $post;
     $author_id=$post->post_author;
	if ( ! $author ) {
		$author = wp_get_current_user();
	} else {
	
		$author = new WP_User( $author );
	}

	if ( ! class_exists( 'EDD_Front_End_Submissions' ) ) {
		return add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID',$author_id)) );
	}

	return EDD_FES()->vendors->get_vendor_store_url( $author->ID );
}


/**
 * Add a vendor archive template to vendor archive page
 *
 * @since 2.5
 */
function mayosis_vendor_template( $template ) {

	if ( ! function_exists( 'EDD_FES' ) ) {
		return $template;
	}

	$vendor_page = EDD_FES()->helper->get_option( 'fes-vendor-page', false );

	if ( ! is_page( $vendor_page ) ) {
		return $template;
	}

	$vendor = get_query_var( 'vendor' );

	if (( $vendor ) ) {
		return locate_template( 'vendor-archive.php' );
	}

	return $template;
}
add_filter( 'template_include', 'mayosis_vendor_template' );

/**
 * Avarage rating
 *
 * @since 2.5
 */
function mayosis_avarage_rating() {
	// make sure edd reviews is active
	if ( ! function_exists( 'edd_reviews' ) )
		return;
	
	$edd_reviews = edd_reviews();
	// get the average rating for this download
	$average_rating = $edd_reviews->average_rating( false );	
	$rating = $average_rating;
	
	$ratingclass = (int) $edd_reviews->average_rating( false );
	ob_start();
	?>
		<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating">
			<div class="edd_reviews_rating_box <?php if ($rating==4.5){  ?>four-half-rating<?php }?> <?php echo __( 'stars', 'mayosis' ).$ratingclass; ?>" role="img">
				<div class="edd_star_rating" aria-label="<?php echo $rating . ' ' . __( 'stars', 'mayosis' ); ?>">
				    <span class="rating-stars"></span>
				     <span class="rating-stars"></span>
				      <span class="rating-stars"></span>
				       <span class="rating-stars"></span>
				        <span class="rating-stars-last"></span>
				        <p>(<?php echo $edd_reviews->count_reviews();?>)</p>
				</div>
			</div>
			<div style="display:none" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
				<meta itemprop="worstRating" content="1" />
				<span itemprop="ratingValue"><?php echo $rating; ?></span>
				<span itemprop="bestRating">5</span>
			</div>
		</div>
	<?php
	$rating_html = ob_get_clean();
	return $rating_html;
}

/**
 * Remove default edd review from content
 *
 * @since 2.5
 */
function mayosis_remove_review() {
	if ( class_exists( 'EDD_Reviews' ) ) {
		$edd_reviews = edd_reviews();
		remove_filter( 'the_content', array( $edd_reviews, 'load_frontend' ) );
	}
}
add_action( 'template_redirect', 'mayosis_remove_review' );

endif;