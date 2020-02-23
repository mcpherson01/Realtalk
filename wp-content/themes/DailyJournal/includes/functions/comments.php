<?php if ( ! function_exists( 'et_custom_comments_display' ) ) :
function et_custom_comments_display($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<article id="comment-<?php comment_ID(); ?>" class="note-block comment-body">
			<div class="note">
				<div class="note-inner">
					<div class="note-content">
						<div class="post-title">
							<div class="comment-meta commentmetadata clearfix">
								<div class="avatar-box">
									<?php echo get_avatar($comment,$size='53'); ?>
									<span class="avatar-overlay"></span>
								</div> <!-- end .avatar-box -->

								<?php printf('<span class="fn">%s</span>', get_comment_author_link()) ?>
								<span class="comment_date">
									<?php
										/* translators: 1: date, 2: time */
										printf( __( '%1$s', 'DailyJournal' ), get_comment_date() );
									?>
								</span>
								<?php edit_comment_link( esc_html__( '(Edit)', 'DailyJournal' ), ' ' ); ?>
							</div><!-- .comment-meta .commentmetadata -->

							<?php if ($comment->comment_approved == '0') : ?>
								<em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.','DailyJournal') ?></em>
								<br />
							<?php endif; ?>
						</div> <!-- end .post-title -->

						<div class="post-content">
							<div class="comment-wrap clearfix">
								<div class="comment-content clearfix">
									<?php comment_text() ?>
								</div> <!-- end comment-content-->
							</div> <!-- end comment-wrap -->
						</div> <!-- end .post-content -->

					</div> <!-- end .note-content-->
				</div> <!-- end .note-inner-->

				<?php
					$et_comment_reply_link = get_comment_reply_link( array_merge( $args, array('reply_text' => esc_attr__('Reply','DailyJournal'),'depth' => $depth, 'max_depth' => $args['max_depth'])) );
					if ( $et_comment_reply_link ) echo '<div class="reply-container">' . $et_comment_reply_link . '</div>';
				?>
			</div> <!-- end .note-->
			<div class="note-bottom-left">
				<div class="note-bottom-right">
					<div class="note-bottom-center"></div>
				</div>
			</div>
		</article> <!-- end comment-body -->
<?php }
endif; ?>