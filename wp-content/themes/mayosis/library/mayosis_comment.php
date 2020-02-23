<?php
function mayosis_comments( $comment, $args, $depth ) {
	global $post;
	$author_id = $post->post_author;
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments. ?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'mayosis' ); ?></span> <?php comment_author_link(); ?></div>
	<?php
		break;
		default :
		// Proceed with normal comments. ?>
	<div id="li-comment-<?php comment_ID(); ?>" class="dm_comment_item">
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class('clr'); ?>>
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 60); ?>
				<div class="comment-meta">
					<cite class="dm_comment_author"><?php comment_author_link(); ?></cite>
					<span class="comment--dot"><i class="fas fa-circle"></i></span><span class="dm_comment-date">
					<?php printf( '<time datetime="%2$s">%3$s</time>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( _x( '%1$s', '1: date', 'mayosis' ), get_comment_date() )
					); ?> <?php esc_html_e( 'at', 'mayosis' ); ?> <?php comment_time(); ?>
					</span><!-- .comment-date -->
					
					<div class="comment-details clr">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'mayosis' ); ?></p>
				<?php endif; ?>
				<div class="comment-content entry clr">
					<?php comment_text(); ?>
					<?php comment_reply_link( array_merge( $args, array(
						'reply_text' => esc_html__( 'Reply', 'mayosis' ),
						'depth'      => $depth,
						'max_depth'	 => $args['max_depth'] )
					) ); ?>
				</div><!-- .comment-content -->
				
			</div><!-- .comment-details -->
				</div><!-- .comment-meta -->
			</div><!-- .comment-author -->
		
			<div class="clearfix"></div>
		</div><!-- #comment-## -->
		
	<?php
		break;
	endswitch; // End comment_type check.
}