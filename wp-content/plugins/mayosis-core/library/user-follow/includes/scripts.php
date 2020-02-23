<?php

/**
 * Loads plugin scripts
 *
 * @access      private
 * @since       1.0
 * @return      void
 */

function teconce_load_scripts() {
    wp_enqueue_script( 'teconce-follow', TECONCE_FOLLOW_URL . 'js/follow.js', array( 'jquery' ) );
    wp_localize_script( 'teconce-follow', 'teconce_vars', array(
        'processing_error' => __( 'There was a problem processing your request.', 'teconce' ),
        'login_required'   => __( 'Oops, you must be logged-in to follow users.', 'teconce' ),
        'logged_in'        => is_user_logged_in() ? 'true' : 'false',
        'ajaxurl'          => admin_url( 'admin-ajax.php' ),
        'nonce'            => wp_create_nonce( 'follow_nonce' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'teconce_load_scripts' );