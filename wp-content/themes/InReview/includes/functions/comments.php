<?php if ( ! function_exists( 'et_custom_comments_display' ) ) :
function et_custom_comments_display($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	    <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">

			<div class="comment-bottom">
				<div class="comment-container">
					<div class="avatar-container">
						<div class="avatar-box">
							<?php echo get_avatar($comment,$size='56'); ?>
							<span class="avatar-overlay"></span>
						</div> <!-- end .avatar-box -->
					</div> <!-- end .avatar-container -->

					<div class="comment-wrap clearfix">
						<div class="comment-meta commentmetadata">
							<div class="comment-meta_main">
								<?php printf('<span class="fn">%s</span>', get_comment_author_link()) ?>
								<div class="comment-date"><?php comment_date('F j, Y'); ?> <?php edit_comment_link(esc_html__('(Edit)','InReview'),'  ','') ?></div>
							</div> <!-- end .comment-meta_main -->
							<?php do_action( 'et-comment-meta', get_comment_ID() ); ?>
						</div> <!-- end .comment-meta -->

						<?php if ($comment->comment_approved == '0') : ?>
							<em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.','InReview') ?></em>
							<br />
						<?php endif; ?>

						<div class="comment-content"><?php comment_text() ?></div> <!-- end comment-content-->
						<?php
							$et_comment_reply_link = get_comment_reply_link( array_merge( $args, array('reply_text' => esc_attr__('Reply','InReview'),'depth' => $depth, 'max_depth' => $args['max_depth'])) );
							if ( $et_comment_reply_link ) echo '<div class="reply-container">' . $et_comment_reply_link . '</div>';
						?>
					</div> <!-- end .comment-wrap-->
				</div> <!-- end .comment-container-->
			</div> <!-- end .comment-bottom-->

		</div> <!-- end .comment-body-->
<?php }
endif; ?>