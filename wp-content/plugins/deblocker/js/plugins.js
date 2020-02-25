/**
 * Most effective way to detect ad blockers. Ask the visitors to disable their ad blockers.
 * Exclusively on Envato Market: https://1.envato.market/deblocker
 *
 * @encoding        UTF-8
 * @version         2.0.2
 * @copyright       Copyright (C) 2018 - 2020 Merkulove ( https://merkulov.design/ ). All rights reserved.
 * @license         Commercial Software
 * @contributors    Alexander Khmelnitskiy (info@alexander.khmelnitskiy.ua), Dmitry Merkulov (dmitry@merkulov.design)
 * @support         help@merkulov.design
 **/

( function ( $ ) {
    
    "use strict";
    
    jQuery( document ).ready( function () {
        
        jQuery( '.mdp-deblocker-rating-stars' ).find( 'a' ).hover(
            function() {
                jQuery( this ).nextAll( 'a' ).children( 'span' ).removeClass( 'dashicons-star-filled' ).addClass( 'dashicons-star-empty' );
                jQuery( this ).prevAll( 'a' ).children( 'span' ).removeClass( 'dashicons-star-empty' ).addClass( 'dashicons-star-filled' );
                jQuery( this ).children( 'span' ).removeClass( 'dashicons-star-empty' ).addClass( 'dashicons-star-filled' );
            }
        );
        
    } );

} ( jQuery ) );