<?php
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

namespace Merkulove\DeBlocker;

use Merkulove\DeBlocker;

/** Get Plugin Settings. */
$options = Settings::get_instance()->options;

/** Prepare variables. */
$style          = $options['style'];
$timeout        = $options['timeout'];
$closeable      = $options['closeable'];
$title          = $options['title'];
$content        = $options['content'];
$bg_color       = $options['bg_color'];
$modal_color    = $options['modal_color'];
$text_color     = $options['text_color'];
$blur           = $options['blur'];
$prefix         = DeBlocker::get_instance()->generate_random_name();

// language=JavaScript
return "
document.addEventListener( 'DOMContentLoaded', function () {
    
    /** Disable plugin if page have Shortcode. */
    if ( typeof( window.mdpDeBlockerDestroyer ) !== 'undefined' ) { return; }
    window.mdpDeBlockerDestroyer = true;
    
    let mdpDeBlocker = {
        style: '{$style}',      
		timeout: '{$timeout}',    
		closeable: '{$closeable}',  
		title: `{$title}`,
		content: `{$content}`,
		bg_color: '{$bg_color}',
		modal_color: '{$modal_color}',
		text_color: '{$text_color}', 
		blur: '{$blur}',
		prefix: '{$prefix}',
    };
    
    /** Detect ad blockers. */
    adsBlocked( function ( blocked ) {
        
        if ( blocked ) {
            showModal();
        
        /** Check by two different methods. */
        } else if ( ! document.getElementById( 'mdp-deblocker-ads' ) ) { 
            
            showModal();
        }
        
    } );
    
    /** Disable text selection on page. */
    function disableTextSelection( e ) {
        
        if ( typeof e.onselectstart !== 'undefined' ){
            e.onselectstart = function(){ return false; };
        } else if ( typeof e.style.MozUserSelect != 'undefined' ) {
            e.style.MozUserSelect = 'none';
        } else if ( typeof e.style.webkitUserSelect != 'undefined' ) {
            e.style.webkitUserSelect = 'none';
        } else {
            e.onmousedown = function(){ return false; };
        }
        
        e.style.cursor = 'default';
    }
    
    /** Enable text selection on page. */
    function enableSelection( e ) {
        
        if ( typeof e.onselectstart != 'undefined' ){
            e.onselectstart = function(){ return true; };
        } else if ( typeof e.style.MozUserSelect != 'undefined' ) {
            e.style.MozUserSelect = 'text';
        } else if ( typeof e.style.webkitUserSelect != 'undefined' ) {
            e.style.webkitUserSelect = 'text';
        } else {
            e.onmousedown = function(){ return true; };
        }
        
        e.style.cursor = 'auto';
    }
    
    /** Disable context menu on page. */
    function disableContextMenu() {
        document.oncontextmenu = function( e ) { 
            let t = e || window.event;
            let n = t.target || t.srcElement;
            
            if ( n.nodeName != 'A' ) {
                return false;  
            }
        };
        
        document.body.oncontextmenu = function () { return false; };
        
        document.ondragstart = function() { return false; };
    }

    /** Enable context menu on page. */
    function enableContextMenu() {
        document.oncontextmenu = null;
        document.body.oncontextmenu = null;
        document.ondragstart = null;
    }
    
    let h_win_disableHotKeys;
    let h_mac_disableHotKeys;
    
    /** Disable HotKeys on page. */
    function disableHotKeys() {
        
        h_win_disableHotKeys = function( e ) { 
            if( 
                e.ctrlKey && 
                ( 
                    e.which == 65 || 
                    e.which == 66 || 
                    e.which == 67 ||
                    e.which == 70 ||
                    e.which == 73 ||
                    e.which == 80 ||
                    e.which == 83 ||
                    e.which == 85 ||
                    e.which == 86
                )
            ) {
                e.preventDefault();
            }
        };
        
        /** For Windows check ctrl. */
        window.addEventListener( 'keydown', h_win_disableHotKeys );
        
        document.keypress = function( e ) {
            if( 
                e.ctrlKey && 
                (
                    e.which == 65 ||
                    e.which == 66 ||
                    e.which == 70 ||
                    e.which == 67 ||
                    e.which == 73 ||
                    e.which == 80 ||
                    e.which == 83 ||
                    e.which == 85 ||
                    e.which == 86
                ) 
            ) {
                return false;
            }
            
        };
        
        h_mac_disableHotKeys = function( e ) { 
            if( 
                e.metaKey && 
                (
                    e.which == 65 ||
                    e.which == 66 ||
                    e.which == 67 ||
                    e.which == 70 ||
                    e.which == 73 ||
                    e.which == 80 ||
                    e.which == 83 ||
                    e.which == 85 ||
                    e.which == 86
                )
            ) { 
                e.preventDefault();
            }
        };
        
        /** For mac check metakey. */
        window.addEventListener( 'keydown', h_mac_disableHotKeys );
        
        document.keypress = function( e ) { 
            if( 
                e.metaKey &&
                (
                    e.which == 65 ||
                    e.which == 66 ||
                    e.which == 70 ||
                    e.which == 67 ||
                    e.which == 73 ||
                    e.which == 80 ||
                    e.which == 83 ||
                    e.which == 85 ||
                    e.which == 86
                )
            ) {
                return false;
            }
            
        };
        
        /** Disable DevTools. */
        document.onkeydown = function( e ) {
            if (
                e.keyCode == 123 || // F12
                ( ( e.ctrlKey || e.metaKey ) && e.shiftKey && e.keyCode == 73 ) // CTRL+SHIFT+I, CMD+OPTION+I
            ) {
                e.preventDefault();
            }
        };

    }
    
    /** Disable Disable Developer Tool on page. */
    function disableDeveloperTools() {
        
        window.addEventListener( 'keydown', function( e ) {

            if (
                e.keyCode === 123 || // F12
                ( ( e.ctrlKey || e.metaKey ) && e.shiftKey && e.keyCode === 73 ) // Ctrl+Shift+I, ⌘+⌥+I
            ) {
                e.preventDefault();
            }
            
        } );
        
        /** Remove body, if you can open dev tools. */
        let checkStatus;

        let element = new Image();
        Object.defineProperty( element, 'id', {
            get:function() {
                checkStatus = 'on';
                throw new Error( 'Dev tools checker' );
            }
        } );

        requestAnimationFrame( function check() {
            checkStatus = 'off';
            console.dir( element );
            if ( 'on' === checkStatus ) {
                document.body.parentNode.removeChild( document.body );
                document.head.parentNode.removeChild( document.head );
                /** Block JS debugger. */
                setTimeout(function() { 
                    while (true) { 
                        eval(\"debugger\");
                    }
                }, 100);
            } else {
                requestAnimationFrame( check );
            }
        } );
                
    }
    
    /** Enable HotKeys on page. */
    function enableHotKeys() {
        
        /** For Windows check ctrl. */
        window.removeEventListener( 'keydown', h_win_disableHotKeys );
        
        document.keypress = function( e ) { 
            if( 
                e.ctrlKey && 
                (
                    e.which == 65 ||
                    e.which == 66 ||
                    e.which == 70 ||
                    e.which == 67 ||
                    e.which == 73 ||
                    e.which == 80 ||
                    e.which == 83 ||
                    e.which == 85 ||
                    e.which == 86
                ) 
            ) {
                return true;
            }
        };
        
        /** For mac check metakey. */
        window.removeEventListener( 'keydown', h_mac_disableHotKeys );
        
        document.keypress = function( e ) { 
            if( 
                e.metaKey &&
                (
                    e.which == 65 ||
                    e.which == 66 ||
                    e.which == 70 ||
                    e.which == 67 ||
                    e.which == 73 ||
                    e.which == 80 ||
                    e.which == 83 ||
                    e.which == 85 ||
                    e.which == 86
                )
            ) {
                return true;
            }  
        };
        
        /** Enable DevTools. */
        document.onkeydown = function( e ) {
            e = e || window.event; 
            if ( e.keyCode == 123 || e.keyCode == 18 || ( e.ctrlKey && e.shiftKey && e.keyCode == 73 ) ) { return true; }
     
        };
    }
    
    /**
     * Adds Front-end CSS.
     **/
    function addStyles() {

        let prefix = mdpDeBlocker.prefix;

        /** Create our stylesheet. */
        let style = document.createElement( 'style' );

        // language=CSS
        style.innerHTML = `
            .${prefix}-style-compact .${prefix}-blackout,
            .${prefix}-style-compact-right-top .${prefix}-blackout,
            .${prefix}-style-compact-left-top .${prefix}-blackout,
            .${prefix}-style-compact-right-bottom .${prefix}-blackout,
            .${prefix}-style-compact-left-bottom .${prefix}-blackout,
            .${prefix}-style-compact .${prefix}-blackout {
                position: fixed;
                z-index: 9997;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                display: none;
            }

            .${prefix}-style-compact .${prefix}-blackout.active,
            .${prefix}-style-compact-right-top .${prefix}-blackout.active,
            .${prefix}-style-compact-left-top .${prefix}-blackout.active,
            .${prefix}-style-compact-right-bottom .${prefix}-blackout.active,
            .${prefix}-style-compact-left-bottom .${prefix}-blackout.active,
            .${prefix}-style-compact .${prefix}-blackout.active {
                display: block;
                -webkit-animation: deblocker-appear;
                animation: deblocker-appear;
                -webkit-animation-duration: .2s;
                animation-duration: .2s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .${prefix}-style-compact .${prefix}-wrapper,
            .${prefix}-style-compact-right-top .${prefix}-wrapper,
            .${prefix}-style-compact-left-top .${prefix}-wrapper,
            .${prefix}-style-compact-right-bottom .${prefix}-wrapper,
            .${prefix}-style-compact-left-bottom .${prefix}-wrapper,
            .${prefix}-style-compact .${prefix}-wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9998;
            }

            .${prefix}-style-compact .${prefix}-modal,
            .${prefix}-style-compact-right-top .${prefix}-modal,
            .${prefix}-style-compact-left-top .${prefix}-modal,
            .${prefix}-style-compact-right-bottom .${prefix}-modal,
            .${prefix}-style-compact-left-bottom .${prefix}-modal,
            .${prefix}-style-compact .${prefix}-modal {
                height: auto;
                width: auto;
                position: relative;
                max-width: 40%;
                padding: 4rem;
                opacity: 0;
                z-index: 9999;
                transition: all 0.5s ease-in-out;
                border-radius: 1rem;
                margin: 1rem;
            }

            .${prefix}-style-compact .${prefix}-modal.active,
            .${prefix}-style-compact-right-top .${prefix}-modal.active,
            .${prefix}-style-compact-left-top .${prefix}-modal.active,
            .${prefix}-style-compact-right-bottom .${prefix}-modal.active,
            .${prefix}-style-compact-left-bottom .${prefix}-modal.active,
            .${prefix}-style-compact .${prefix}-modal.active {
                opacity: 1;
                -webkit-animation: deblocker-appear;
                animation: deblocker-appear;
                -webkit-animation-delay: .1s;
                animation-delay: .1s;
                -webkit-animation-duration: .5s;
                animation-duration: .5s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .${prefix}-style-compact .${prefix}-modal h4,
            .${prefix}-style-compact-right-top .${prefix}-modal h4,
            .${prefix}-style-compact-left-top .${prefix}-modal h4,
            .${prefix}-style-compact-right-bottom .${prefix}-modal h4,
            .${prefix}-style-compact-left-bottom .${prefix}-modal h4,
            .${prefix}-style-compact .${prefix}-modal h4 {
                margin: 0 0 1rem 0;
                padding-right: .8rem;
            }

            .${prefix}-style-compact .${prefix}-modal p,
            .${prefix}-style-compact-right-top .${prefix}-modal p,
            .${prefix}-style-compact-left-top .${prefix}-modal p,
            .${prefix}-style-compact-right-bottom .${prefix}-modal p,
            .${prefix}-style-compact-left-bottom .${prefix}-modal p,
            .${prefix}-style-compact .${prefix}-modal p {
                margin: 0;
            }

            @media only screen and (max-width: 1140px) {
                .${prefix}-style-compact .${prefix}-modal,
                .${prefix}-style-compact-right-top .${prefix}-modal,
                .${prefix}-style-compact-left-top .${prefix}-modal,
                .${prefix}-style-compact-right-bottom .${prefix}-modal,
                .${prefix}-style-compact-left-bottom .${prefix}-modal,
                .${prefix}-style-compact .${prefix}-modal {
                    min-width: 60%;
                }
            }

            @media only screen and (max-width: 768px) {
                .${prefix}-style-compact .${prefix}-modal,
                .${prefix}-style-compact-right-top .${prefix}-modal,
                .${prefix}-style-compact-left-top .${prefix}-modal,
                .${prefix}-style-compact-right-bottom .${prefix}-modal,
                .${prefix}-style-compact-left-bottom .${prefix}-modal,
                .${prefix}-style-compact .${prefix}-modal {
                    min-width: 80%;
                }
            }

            @media only screen and (max-width: 420px) {
                .${prefix}-style-compact .${prefix}-modal,
                .${prefix}-style-compact-right-top .${prefix}-modal,
                .${prefix}-style-compact-left-top .${prefix}-modal,
                .${prefix}-style-compact-right-bottom .${prefix}-modal,
                .${prefix}-style-compact-left-bottom .${prefix}-modal,
                .${prefix}-style-compact .${prefix}-modal {
                    min-width: 90%;
                }
            }

            .${prefix}-style-compact .${prefix}-close,
            .${prefix}-style-compact-right-top .${prefix}-close,
            .${prefix}-style-compact-left-top .${prefix}-close,
            .${prefix}-style-compact-right-bottom .${prefix}-close,
            .${prefix}-style-compact-left-bottom .${prefix}-close,
            .${prefix}-style-compact .${prefix}-close {
                position: absolute;
                right: 1rem;
                top: 1rem;
                display: inline-block;
                cursor: pointer;
                opacity: .3;
                width: 32px;
                height: 32px;
                -webkit-animation: deblocker-close-appear;
                animation: deblocker-close-appear;
                -webkit-animation-delay: 1s;
                animation-delay: 1s;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .${prefix}-style-compact .${prefix}-close:hover,
            .${prefix}-style-compact-right-top .${prefix}-close:hover,
            .${prefix}-style-compact-left-top .${prefix}-close:hover,
            .${prefix}-style-compact-right-bottom .${prefix}-close:hover,
            .${prefix}-style-compact-left-bottom .${prefix}-close:hover,
            .${prefix}-style-compact .${prefix}-close:hover {
                opacity: 1;
            }

            .${prefix}-style-compact .${prefix}-close:before,
            .${prefix}-style-compact .${prefix}-close:after,
            .${prefix}-style-compact-right-top .${prefix}-close:before,
            .${prefix}-style-compact-right-top .${prefix}-close:after,
            .${prefix}-style-compact-left-top .${prefix}-close:before,
            .${prefix}-style-compact-left-top .${prefix}-close:after,
            .${prefix}-style-compact-right-bottom .${prefix}-close:before,
            .${prefix}-style-compact-right-bottom .${prefix}-close:after,
            .${prefix}-style-compact-left-bottom .${prefix}-close:before,
            .${prefix}-style-compact-left-bottom .${prefix}-close:after,
            .${prefix}-style-compact .${prefix}-close:before,
            .${prefix}-style-compact .${prefix}-close:after {
                position: absolute;
                left: 15px;
                content: ' ';
                height: 33px;
                width: 2px;
            }

            .${prefix}-style-compact .${prefix}-close:before,
            .${prefix}-style-compact-right-top .${prefix}-close:before,
            .${prefix}-style-compact-left-top .${prefix}-close:before,
            .${prefix}-style-compact-right-bottom .${prefix}-close:before,
            .${prefix}-style-compact-left-bottom .${prefix}-close:before,
            .${prefix}-style-compact .${prefix}-close:before {
                transform: rotate(45deg);
            }

            .${prefix}-style-compact .${prefix}-close:after,
            .${prefix}-style-compact-right-top .${prefix}-close:after,
            .${prefix}-style-compact-left-top .${prefix}-close:after,
            .${prefix}-style-compact-right-bottom .${prefix}-close:after,
            .${prefix}-style-compact-left-bottom .${prefix}-close:after,
            .${prefix}-style-compact .${prefix}-close:after {
                transform: rotate(-45deg);
            }

            .${prefix}-style-compact-right-top .${prefix}-wrapper {
                justify-content: flex-end;
                align-items: flex-start;
            }

            .${prefix}-style-compact-left-top .${prefix}-wrapper {
                justify-content: flex-start;
                align-items: flex-start;
            }

            .${prefix}-style-compact-right-bottom .${prefix}-wrapper {
                justify-content: flex-end;
                align-items: flex-end;
            }

            .${prefix}-style-compact-left-bottom .${prefix}-wrapper {
                justify-content: flex-start;
                align-items: flex-end;
            }

            .${prefix}-style-full .${prefix}-blackout {
                position: fixed;
                z-index: 9998;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                display: none;
            }

            .${prefix}-style-full .${prefix}-blackout.active {
                display: block;
                -webkit-animation: deblocker-appear;
                animation: deblocker-appear;
                -webkit-animation-delay: .4s;
                animation-delay: .4s;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .${prefix}-style-full .${prefix}-modal {
                height: 100%;
                width: 100%;
                max-width: 100%;
                max-height: 100%;
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                padding: 45px;
                opacity: 0;
                z-index: 9999;
                transition: all 0.5s ease-in-out;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
            }

            .${prefix}-style-full .${prefix}-modal.active {
                opacity: 1;
                -webkit-animation: mdp-deblocker-appear;
                animation: mdp-deblocker-appear;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .${prefix}-style-full .${prefix}-modal h4 {
                margin: 0 0 1rem 0;
            }

            .${prefix}-style-full .${prefix}-modal p {
                margin: 0;
            }

            .${prefix}-style-full .${prefix}-close {
                position: absolute;
                right: 10px;
                top: 10px;
                width: 32px;
                height: 32px;
                display: inline-block;
                cursor: pointer;
                opacity: .3;
                -webkit-animation: mdp-deblocker-close-appear;
                animation: mdp-deblocker-close-appear;
                -webkit-animation-delay: 1s;
                animation-delay: 1s;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .${prefix}-style-full .${prefix}-close:hover {
                opacity: 1;
            }

            .${prefix}-style-full .${prefix}-close:before,
            .${prefix}-style-full .${prefix}-close:after {
                position: absolute;
                left: 15px;
                content: ' ';
                height: 33px;
                width: 2px;
            }

            .${prefix}-style-full .${prefix}-close:before {
                transform: rotate(45deg);
            }

            .${prefix}-style-full .${prefix}-close:after {
                transform: rotate(-45deg);
            }

            @-webkit-keyframes mdp-deblocker-appear {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes mdp-deblocker-appear {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @-webkit-keyframes mdp-deblocker-close-appear {
                from {
                    opacity: 0;
                    transform: scale(0.2);
                }
                to {
                    opacity: .3;
                    transform: scale(1);
                }
            }

            @keyframes mdp-deblocker-close-appear {
                from {
                    opacity: 0;
                    transform: scale(0.2);
                }
                to {
                    opacity: .3;
                    transform: scale(1);
                }
            }

            body.${prefix}-blur { 
                -webkit-backface-visibility: none;
            }

            body.${prefix}-blur > *:not(#wpadminbar):not(.${prefix}-modal):not(.${prefix}-wrapper):not(.${prefix}-blackout) {
                -webkit-filter: blur(5px);
                filter: blur(5px);
            }
        `;

        /** Get the random script tag. */
        let ref = document.querySelectorAll('script');
        let rand = ref[ Math.floor( Math.random() * ref.length ) ];

        /** Insert our new styles before the first script tag. */
        rand.parentNode.insertBefore( style, rand );

    }
    
    /** Show DeBlocker Modal. */
    function showModal() {   	
        
        /** Open modal after timeout. */
        setTimeout( function () {

            let prefix = mdpDeBlocker.prefix;

            /** Adds Front-end CSS. */
            addStyles();

            /** Set Style class. */
            document.body.classList.add( `${prefix}-style-` + mdpDeBlocker.style );

            /** Blur Content: */
            if ( mdpDeBlocker.blur === 'on' ) {
                document.body.classList.add( `${prefix}-blur` );
            }

            /** Create body overlay. */
            let overlay = document.createElement( 'div' );
            overlay.classList.add( `${prefix}-blackout` );
            overlay.style.backgroundColor = mdpDeBlocker.bg_color; // Set Overlay Color.
            overlay.classList.add( 'active' );
            document.body.appendChild( overlay );

            /** Create the Modal Wrapper. */
            let modalWrapper = document.createElement( 'div' );
            modalWrapper.classList.add( `${prefix}-wrapper` );
            document.body.appendChild( modalWrapper );

            /** Create Modal. */
            let modal = document.createElement( 'div' );
            modal.classList.add( `${prefix}-modal` );
            modal.style.backgroundColor = mdpDeBlocker.modal_color; // Set Modal Color.
            modal.classList.add( 'active' );
            modalWrapper.appendChild(modal);

            /** Is it possible to close? */
            if (mdpDeBlocker.closeable === 'on') {

                /** Create Close Button. */
                let close = document.createElement( 'span' );
                close.classList.add( `${prefix}-close` );
                close.innerHTML = '&nbsp;';
                close.setAttribute( 'href', '#' );

                let style = document.createElement( 'style' );
                style.type = 'text/css';
                style.innerHTML =
                    `.${prefix}-close:after,` +
                    `.${prefix}-close:before {` +
                    'background-color: ' + mdpDeBlocker.text_color + ';' +
                '}';

                let head = document.head || document.getElementsByTagName( 'head' )[0];
                head.appendChild( style );

                /** Close Event. */
                close.addEventListener( 'click', function (e) {
                    e.preventDefault();
                    let elem = document.querySelector( `.${prefix}-modal` );
                    elem.parentNode.removeChild(elem);
                    elem = document.querySelector( `.${prefix}-wrapper` );
                    elem.parentNode.removeChild(elem);
                    elem = document.querySelector( `.${prefix}-blackout` );
                    elem.parentNode.removeChild(elem);

                    /** Remove Blur. */
                    document.body.classList.remove( `${prefix}-blur` );
                    enableSelection( document.body );
                    enableContextMenu();
                    enableHotKeys();
                });

                modal.appendChild(close);
            }

            /** Create Title. */
            let title = document.createElement( 'h4' );
            title.innerHTML = mdpDeBlocker.title;
            title.style.color = mdpDeBlocker.text_color; // Set Text Color.
            modal.appendChild( title );

            /** Create Content. */
            let content = document.createElement( 'div' );
            content.classList.add( `${prefix}-content` );
            content.innerHTML = mdpDeBlocker.content;
            content.style.color = mdpDeBlocker.text_color; // Set Text Color.
            modal.appendChild( content );

            disableTextSelection( document.body );
            disableContextMenu();
            disableHotKeys();
            disableDeveloperTools();

        }, ( mdpDeBlocker.timeout ) );

    }

    /** Detect ad blockers. */
    function adsBlocked( callback ) {
        
        let AdsURL = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';

        let RequestSettings = {
            method: 'HEAD',
            mode: 'no-cors'
        };

        let DeBlockerRequest = new Request( AdsURL, RequestSettings );

        fetch( DeBlockerRequest ).then( function ( response ) {
            return response;
        } ).then( function ( response ) {
            callback( false );
        } ).catch( function ( e ) {
            callback( true );
        });
    }
    
}, false );
";