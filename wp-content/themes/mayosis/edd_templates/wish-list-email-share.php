<?php
/**
 * Email sharing template
 */
?>

<p>
    <label for="edd-wl-from-name"><?php _e( 'Your Name', 'mayosis' ); ?></label>
    <input type="text" placeholder="<?php _e( 'Your Name', 'mayosis' ); ?>" name="edd_wl_from_name" id="edd-wl-from-name" class="edd-input" data-msg-required="<?php _e( 'Please enter your name', 'mayosis' ); ?>" data-rule-required="true" />
</p>

<p>
    <label for="edd-wl-from-email"><?php _e( 'Your Email Address', 'mayosis' ); ?></label>
    <input type="email" placeholder="<?php _e( 'Your Email address', 'mayosis' ); ?>" name="edd_wl_from_email" id="edd-wl-from-email" class="edd-input" data-rule-required="true" data-rule-email="true" data-msg-required="<?php _e( 'Please enter your email address', 'mayosis' ); ?>" data-msg-email="<?php _e( 'Please enter a valid email address', 'mayosis' ); ?>" />
</p>

<p>
    <label for="edd-wl-share-emails"><?php _e( 'Friend\'s Email Address', 'mayosis' ); ?></label>
    <span class="edd-description"><?php _e( 'To send to multiple email addresses, separate each email with a comma', 'mayosis' ); ?></span>
    <input type="text" placeholder="<?php _e( 'Friend\'s Email address', 'mayosis' ); ?>" data-rule-required="true" data-rule-multiemail="true" name="edd_wl_share_emails" id="edd-wl-share-emails" class="edd-input" data-msg-required="<?php _e( 'Please enter one or more email addresses', 'mayosis' ); ?>" data-msg-multiemail="<?php _e( 'You must enter a valid email, or comma separate multiple emails', 'mayosis' ); ?>" />
</p>

<p>
    <label for="edd-wl-share-message"><?php _e( 'Your Message', 'mayosis' ); ?></label>
    <span class="edd-description"><?php _e( 'Optional', 'mayosis' ); ?></span>
    <textarea name="edd_wl_share_message" id="edd-wl-share-message" rows="3" cols="30"></textarea>
</p>