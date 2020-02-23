<?php

/**
 * Ajax Actions
 *
 * @package     User Following System
 * @subpackage  Ajax Actions
 * @copyright   Copyright (c) 2012, Teconce
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


/**
 * Processes the ajax request to follow a user
 *
 * @access      private
 * @since       1.0
 * @return      void
 */

function teconce_process_new_follow() {
    if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
        if( teconce_follow_user( absint( $_POST['user_id'] ), absint( $_POST['follow_id'] ) ) ) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
    die();
}
add_action('wp_ajax_follow', 'teconce_process_new_follow');


/**
 * Processes the ajax request to unfollow a user
 *
 * @access      private
 * @since       1.0
 * @return      void
 */

function teconce_process_unfollow() {
    if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
        if( teconce_unfollow_user( absint( $_POST['user_id'] ), absint( $_POST['follow_id'] ) ) ) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
    die();
}
add_action('wp_ajax_unfollow', 'teconce_process_unfollow');