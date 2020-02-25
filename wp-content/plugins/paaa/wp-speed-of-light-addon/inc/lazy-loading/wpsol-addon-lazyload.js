"use strict";

var WPSOL_LAZYLOADING = {
    _ticking: false,

    check: function () {

        if ( WPSOL_LAZYLOADING._ticking ) {
            return;
        }

        WPSOL_LAZYLOADING._ticking = true;

        var winH = document.documentElement.clientHeight || body.clientHeight;

        var updated = false;

        var els = document.getElementsByClassName('wpsol-lazy-hidden');
        [].forEach.call( els, function( el, index, array ) {

            var elemRect = el.getBoundingClientRect();

            if ( winH - elemRect.top > 0 ) {
                WPSOL_LAZYLOADING.show( el );
                updated = true;
            }

        } );

        WPSOL_LAZYLOADING._ticking = false;
        if ( updated ) {
            WPSOL_LAZYLOADING.check();
        }
    },

    show: function( el ) {
        el.className = el.className.replace( /(?:^|\s)wpsol-lazy-hidden(?!\S)/g , '' );
        el.addEventListener( 'load', function() {
            el.className += " wpsol-lazy-loaded";
            WPSOL_LAZYLOADING.customEvent( el, 'lazyloaded' );
        }, false );

        if ( null != el.getAttribute('data-wpsollazy-srcset') ) {
            el.setAttribute( 'srcset', el.getAttribute('data-wpsollazy-srcset') );
        }

        el.setAttribute( 'src', el.getAttribute('data-wpsollazy-src') );

    },
    customEvent: function( el, eventName ) {
        var event;

        if ( document.createEvent ) {
            event = document.createEvent( "HTMLEvents" );
            event.initEvent( eventName, true, true );
        } else {
            event = document.createEventObject();
            event.eventType = eventName;
        }

        event.eventName = eventName;

        if ( document.createEvent ) {
            el.dispatchEvent( event );
        } else {
            el.fireEvent( "on" + event.eventType, event );
        }
    }
};

window.addEventListener( 'load', WPSOL_LAZYLOADING.check, false );
window.addEventListener( 'scroll', WPSOL_LAZYLOADING.check, false );
window.addEventListener( 'resize', WPSOL_LAZYLOADING.check, false );
document.getElementsByTagName( 'body' ).item( 0 ).addEventListener( 'post-load', WPSOL_LAZYLOADING.check, false );
