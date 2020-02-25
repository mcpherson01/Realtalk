<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php if ($header === true) : ?>
<h3>
    <?php _e('Please click the button below to connect to Facebook.'); ?>
</h3>
<?php endif; ?>
<a href="<?php echo $login_facebook_url; ?>" class="button button-primary"><?php _e('Connect to Facebook', NJT_FB_PR_I18N); ?></a>