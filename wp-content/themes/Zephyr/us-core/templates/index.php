<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * The template for displaying the 404 page
 */

$posts_page = get_post( us_get_option( 'posts_page' ) );

// Output specific page
if ( $posts_page ) {
	$posts_page = get_post( apply_filters( 'wpml_object_id', $posts_page->ID, 'page', TRUE ) );

	get_header();

	?>
	<main id="page-content" class="l-main"<?php echo ( us_get_option( 'schema_markup' ) ) ? ' itemprop="mainContentOfPage"' : ''; ?>>

		<?php
		do_action( 'us_before_page' );

		if ( us_get_option( 'enable_sidebar_titlebar', 0 ) ) {

			// Titlebar, if it is enabled in Theme Options
			us_load_template( 'templates/titlebar' );

			// START wrapper for Sidebar
			us_load_template( 'templates/sidebar', array( 'place' => 'before' ) );
		}

		us_open_wp_query_context();

		us_add_page_shortcodes_custom_css( $posts_page->ID );

		us_close_wp_query_context();

		// Setting search page ID as $us_page_block_id for grid shortcodes
		us_add_to_page_block_ids( $posts_page->ID );

		echo apply_filters( 'the_content', $posts_page->post_content );

		us_remove_from_page_block_ids();

		if ( us_get_option( 'enable_sidebar_titlebar', 0 ) ) {
			// AFTER wrapper for Sidebar
			us_load_template( 'templates/sidebar', array( 'place' => 'after' ) );
		}

		do_action( 'us_after_page' );
		?>

	</main>
	<?php

	get_footer();

	// Output default archive layout
} else {
	us_load_template( 'templates/archive' );
}
