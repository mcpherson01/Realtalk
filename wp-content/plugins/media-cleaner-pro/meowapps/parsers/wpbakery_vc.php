<?php

add_action( 'wpmc_scan_post', 'wpmc_scan_html_visualcomposer', 10, 2 );
add_action( 'wpmc_scan_postmeta', 'wpmc_scan_postmeta_visualcomposer', 10, 1 );

function wpmc_scan_html_visualcomposer( $html, $id ) {
	global $wpmc;
	$posts_images_vc = array();
	$galleries_images_vc = array();

	// Support for Salient Theme
	if ( defined( 'SALIENT_VC_ACTIVE' ) ) {
		$html .= get_post_meta( $id, '_nectar_portfolio_extra_content', true );
	}

	// Single Image
	preg_match_all( "/image=\"([0-9]+)\"/", $html, $res );
	if ( !empty( $res ) && isset( $res[1] ) && count( $res[1] ) > 0 ) {
		foreach ( $res[1] as $id ) {
			array_push( $posts_images_vc, $id );
		}
	}
	$wpmc->add_reference_id( $posts_images_vc, 'PAGE BUILDER (ID)' );

	// Gallery
	preg_match_all( "/images=\"([0-9,]+)/", $html, $res );
	if ( !empty( $res ) && isset( $res[1] ) ) {
		foreach ( $res[1] as $r ) {
			$ids = explode( ',', $r );
			$galleries_images_vc = array_merge( $galleries_images_vc, $ids );
		}
	}
	$wpmc->add_reference_id( $galleries_images_vc, 'GALLERY (ID)' );
}

function wpmc_scan_postmeta_visualcomposer( $id ) {
	global $wpmc;
	$urls = get_transient( "wpmc_postmeta_images_urls" );
	if ( empty( $urls ) )
		$urls = array();
	$data = get_post_meta( $id, '_wpb_shortcodes_custom_css' );
	if ( is_array( $data ) ) {
		foreach ( $data as $d ) {
			$newurls = $wpmc->get_urls_from_html( $d );
			$urls = array_merge( $urls, $newurls );
		}
	}
	$wpmc->add_reference_url( $urls, 'PAGE BUILDER META (URL)' );
}

?>