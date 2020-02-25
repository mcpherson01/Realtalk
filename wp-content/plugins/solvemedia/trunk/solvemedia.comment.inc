<?php

/*
 * Copyright (c) 2012 by Solve Media, Inc.
 * Author: Ilia Fishbein
 * Function: Portion of the WordPress plugin related to the comments section
 *
 * $Id$
 */

//If solvemedia captchas for comments are enabled, load comment_reply.js
function adcopy_wp_enable_comment_reply_reload() {

	global $WP_type, $adcopy_opt, $wp_plugin_url;

	if ( $adcopy_opt['re_comments'] ) {
		wp_enqueue_script('solvemedia_comment_reply',
			$wp_plugin_url . '/solvemedia/solvemedia_comment_reply.js',
			array( 'jquery', 'jquery-form' )
		);
	}
}

add_action( 'init', 'adcopy_wp_enable_comment_reply_reload' );

function adcopy_wp_hash_comment( $id ) {

	global $adcopy_opt;

	if ( function_exists( 'wp_hash' ) ) {
		return wp_hash( ADCOPY_WP_HASH_SALT . $id ); } else { 		return md5( ADCOPY_WP_HASH_SALT . $adcopy_opt['privkey'] . $id ); }
}

/**
 *  Embeds the solvemedia widget into the comment form.
 *
 */
function adcopy_comment_form() {
	global $adcopy_opt;

	$needed_capability = null;
	// set the minimum capability needed to skip the captcha if there is one
	if ( $adcopy_opt['re_bypass'] && $adcopy_opt['re_bypasslevel'] ) {
		$needed_capability = $adcopy_opt['re_bypasslevel'];
	}

	// skip the solvemedia display if the minimum capability is met
	if ( ($needed_capability && current_user_can( $needed_capability )) || ! $adcopy_opt['re_comments'] ) {
		return; }

	// Did the user fail to match the CAPTCHA? If so, let them know
	if ( isset( $_GET['rerror'] ) && ('incorrect-solution' == $_GET['rerror'] || 'wronganswer' == $_GET['rerror']) ) {
		echo '<p class="adcopy-error">' . $adcopy_opt['error_incorrect'] . '</p>';
	}

	$theme = $adcopy_opt['re_theme'];

	$comment_string = <<<COMMENT_FORM
        <div id="adcopy-submit-btn-area"><br /></div>
        <script type='text/javascript'>
            var sub = document.getElementById('submit');
            if (sub.parentNode != 'undefined' && sub.parentNode.tagName.toLowerCase() == 'p')
                sub = sub.parentNode;
            sub.parentNode.removeChild(sub);
            document.getElementById('adcopy-submit-btn-area').appendChild (sub);
            document.getElementById('submit').tabIndex = 6;
            if ( typeof _adcopy_wordpress_savedcomment != 'undefined') {
                document.getElementById('comment').value = _adcopy_wordpress_savedcomment;
            }
        </script>
COMMENT_FORM;

	if ( $adcopy_opt['re_xhtml'] ) {
		$comment_string .= <<<COMMENT_FORM
             <noscript>
                <style type='text/css'>#submit {display:none;}</style>
                <input name="submit" type="submit" id="submit-alt" tabindex="6" value="Submit Comment"/>
            </noscript>
COMMENT_FORM;
	}

	$html  = solvemedia_wp_get_html( null, $theme );
	$html .= $comment_string;

	echo $html;
}

add_action( 'comment_form', 'adcopy_comment_form' );

$adcopy_saved_error = '';

/**
 * Checks if the solvemedia guess was correct and sets an error session variable if not
 * @param array $comment_data
 * @return array $comment_data
 */
function adcopy_wp_check_comment( $comment_data ) {
	global $user_ID, $adcopy_opt, $adcopy_saved_error;

	// set the minimum capability needed to skip the captcha if there is one
	if ( $adcopy_opt['re_bypass'] && $adcopy_opt['re_bypasslevel'] ) {
		$needed_capability = $adcopy_opt['re_bypasslevel']; }

	// skip the filtering if the minimum capability is met
	if ( ($needed_capability && current_user_can( $needed_capability )) || ! $adcopy_opt['re_comments'] ) {
		return $comment_data; }

	if ( ! is_null( $comment_data['comment_type'] ) && '' == $comment_data['comment_type'] ) { // Do not check trackbacks/pingbacks
		$response = solvemedia_wp_check_answer();

		if ( $response->is_valid ) {
			return $comment_data; } else {
			$adcopy_saved_error = $response->error;
			add_filter( 'pre_comment_approved', create_function( '$a', 'return \'spam\';' ) );
			return $comment_data;
			}
	}
	return $comment_data;
}

/*
 * If the solvemedia guess was incorrect from adcopy_wp_check_comment, then redirect back to the comment form
 * @param string $location
 * @param OBJECT $comment
 * @return string $location
 */
function adcopy_wp_relative_redirect( $location, $comment ) {
	global $adcopy_saved_error;
	if ( '' != $adcopy_saved_error ) {
		//replace the '#comment-' chars on the end of $location with '#commentform'.
		$location = substr( $location, 0,strrpos( $location, '#' ) ) .
					((strrpos( $location, '?' ) === false) ? '?' : '&') .
					'rcommentid=' . $comment->comment_ID .
					'&rerror=' . $adcopy_saved_error .
					'&rchash=' . adcopy_wp_hash_comment( $comment->comment_ID ) .
					'#commentform';
	}
	return $location;
}

/*
 * If the solvemedia guess was incorrect from adcopy_wp_check_comment, then insert their saved comment text
 * back in the comment form.
 * @param boolean $approved
 * @return boolean $approved
 */
function adcopy_wp_saved_comment() {
	if ( ! is_single() && ! is_page() ) {
		return; }

	if ( isset( $_GET['rcommentid'] ) && adcopy_wp_hash_comment( $_GET['rcommentid'] == $_GET['rchash'] ) ) {
		$comment = get_comment( $_GET['rcommentid'] );
		if ( null !== $comment ) {
			$com = urlencode( $comment->comment_content );
			$com = preg_replace( '/\\r\\n/m', '\\\n', $com );

			echo <<<SAVED_COMMENT
    	    <script type='text/javascript'>
        	    var _adcopy_wordpress_savedcomment =  '$com';
	            _adcopy_wordpress_savedcomment = unescape(_adcopy_wordpress_savedcomment);
    	    </script>
SAVED_COMMENT;

			wp_delete_comment( $comment->comment_ID );
		}
	}
}

add_filter( 'wp_head', 'adcopy_wp_saved_comment',0 );
add_filter( 'preprocess_comment', 'adcopy_wp_check_comment',0 );
add_filter( 'comment_post_redirect', 'adcopy_wp_relative_redirect',0,2 );
