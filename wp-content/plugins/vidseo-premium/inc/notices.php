<?php

function vidseo_notice_rate()
{
    if ( !PAnD::is_admin_notice_active( 'vidseo-rating-120' ) ) {
        return;
    }
    ?>
    
            <div data-dismissible="vidseo-rating-120" class="notice vidseo-notice notice-success is-dismissible">
                <p class="vidseo-p"><?php 
    $rating_url = "https://wordpress.org/support/plugin/vidseo/reviews/?rate=5#new-post";
    $show_support = sprintf( wp_kses( __( 'Show support for Video SEO Transcription Embedder with a 5-star rating » <a href="%s" target="_blank">Click here</a>', 'vidseo' ), array(
        'a' => array(
        'href'   => array(),
        'target' => array(),
    ),
    ) ), esc_url( $rating_url ) );
    echo  $show_support ;
    ?></p>
            </div>
    <?php 
}

add_action( 'admin_init', array( 'PAnD', 'init' ) );
//add_action( 'admin_notices', 'vidseo_notice_subscribe' );
add_action( 'admin_notices', 'vidseo_notice_rate' );
// end free only