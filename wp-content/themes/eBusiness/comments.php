<?php
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die (esc_html__('Please do not load this page directly. Thanks!','eBusiness'));

    if ( post_password_required() ) { ?>

<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.','eBusiness') ?></p>
<?php
        return;
    }
?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
<div class="post-info-wrap" style="margin-top: 20px;"> <img src="<?php bloginfo('template_directory'); ?>/images/home-title-2-left-<?php echo(get_option('ebusiness_color_scheme')); ?>.gif" alt="home title" class="home-title-image" /> <span class="post-info">
    <?php comments_number(esc_html__('No Responses','eBusiness'), esc_html__('One Response','eBusiness'), esc_html__('% Responses','eBusiness') );?>
    </span> <img src="<?php bloginfo('template_directory'); ?>/images/home-title-2-right-<?php echo(get_option('ebusiness_color_scheme')); ?>.gif" alt="home title" class="home-title-image" /> </div>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <div class="navigation comment_navigation_top clearfix">
            <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Basic' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Basic' ) ); ?></div>
        </div> <!-- .navigation -->
    <?php endif; // check for comment navigation ?>

    <?php if ( ! empty($comments_by_type['comment']) ) : ?>
        <ol class="commentlist clearfix">
            <?php wp_list_comments( array('type'=>'comment', 'avatar_size'=>'42') ); ?>
        </ol>
    <?php endif; ?>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <div class="navigation comment_navigation_bottom clearfix">
            <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Basic' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Basic' ) ); ?></div>
        </div> <!-- .navigation -->
    <?php endif; // check for comment navigation ?>

    <?php if ( ! empty($comments_by_type['pings']) ) : ?>
        <div id="trackbacks">
            <h3 id="trackbacks-title"><?php esc_html_e('Trackbacks/Pingbacks','Basic') ?></h3>
            <ol class="pinglist">
                <?php wp_list_comments('type=pings&callback=et_list_pings'); ?>
            </ol>
        </div>
    <?php endif; ?>
<?php else : // this is displayed if there are no comments so far ?>
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"><?php esc_html_e('Comments are closed.','eBusiness') ?></p>
<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status) : ?>
<div id="comments">
    <div class="post-info-wrap"> <img src="<?php bloginfo('template_directory'); ?>/images/home-title-2-left-2-<?php echo(get_option('ebusiness_color_scheme')); ?>.png" alt="home title" class="home-title-image" /> <span class="post-info">
        <?php comment_form_title( esc_html__('Leave a Reply','eBusiness'), esc_html__('Leave a Reply to %s','eBusiness' )); ?>
        </span> <img src="<?php bloginfo('template_directory'); ?>/images/home-title-2-right-<?php echo(get_option('ebusiness_color_scheme')); ?>.gif" alt="home title" class="home-title-image" /> </div>
    <div class="cancel-comment-reply"> <small>
        <?php cancel_comment_reply_link(); ?>
        </small> </div>
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
    <p><?php esc_html_e('You must be','eBusiness')?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php esc_html_e('logged in','eBusiness') ?></a> <?php esc_html_e('to post a comment.','eBusiness') ?></p>
    <?php else : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        <?php if ( $user_ID ) : ?>
        <p><?php esc_html_e('Logged in as','eBusiness') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php esc_html_e('Log out &raquo;','eBusiness') ?></a></p>
        <?php else : ?>
        <p>
            <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
            <label for="author"><small><?php esc_html_e('Name','eBusiness') ?>
                <?php if ($req) esc_html_e('(required)','eBusiness'); ?>
                </small></label>
        </p>
        <p>
            <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
            <label for="email"><small><?php esc_html_e('Mail (will not be published)','eBusiness') ?>
                <?php if ($req) esc_html_e('(required)','eBusiness'); ?>
                </small></label>
        </p>
        <p>
            <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
            <label for="url"><small><?php esc_html_e('Website','eBusiness') ?></small></label>
        </p>
        <?php endif; ?>
        <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
        <p>
            <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea>
        </p>
        <p>
            <input name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_attr_e('Submit Comment','eBusiness')?>" />
            <?php comment_id_fields(); ?>
        </p>
        <?php do_action('comment_form', $post->ID); ?>
    </form>
    <?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>