<?php
/**
 * Retrieves the follow / unfollow links
 *
 * @access      public
 * @since       1.0
 * @param 	    int $user_id - the ID of the user to display follow / unfollow links for
 * @return      string
 */

function teconce_get_follow_unfollow_links( $follow_id = null ) {

    global $user_ID;

    if( empty( $follow_id ) )
        return;

    if( ! is_user_logged_in() )
        return;

    if ( $follow_id == $user_ID )
        return;

    ob_start(); ?>
    
        <?php if ( teconce_is_following( $user_ID, $follow_id ) ) { ?>
            <a href="#" class="unfollow followed tec-follow-link" data-user-id="<?php echo $user_ID; ?>" data-follow-id="<?php echo $follow_id; ?>">Unfollow</a>
            <a href="#" class="follow tec-follow-link" style="display:none;" data-user-id="<?php echo $user_ID; ?>" data-follow-id="<?php echo $follow_id; ?>">Follow</a>
        <?php } else { ?>
            <a href="#" class="follow tec-follow-link" data-user-id="<?php echo $user_ID; ?>" data-follow-id="<?php echo $follow_id; ?>">Follow</a>
            <a href="#" class="followed unfollow tec-follow-link" style="display:none;" data-user-id="<?php echo $user_ID; ?>" data-follow-id="<?php echo $follow_id; ?>">Unfollow</a>
        <?php } ?>
     
    <?php
    return ob_get_clean();
}