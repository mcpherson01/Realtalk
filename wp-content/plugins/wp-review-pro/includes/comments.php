<?php

$options = get_option( 'wp_review_options' );

$comments_template = ( ! empty( $options['comments_template'] ) ? $options['comments_template'] : 'theme' );
if ( $comments_template != 'theme' ) {
	add_filter( 'comments_template', 'wp_review_comments_template', 99 );
	add_filter( 'comment_form_fields', 'wp_review_move_comment_field_to_bottom' );
	add_filter( 'body_class', 'wp_review_comments_template_body_class' );
	add_filter( 'wp_enqueue_scripts', 'wp_review_comments_template_style' );
}
function wp_review_comments_template( $theme_template ) {
	global $wp_query;
	$wp_query->comments_by_type = array();

	if ( file_exists( get_stylesheet_directory().'/wp-review/comments.php' ) ) {
		return get_stylesheet_directory() . '/wp-review/comments.php';
	}
	return WP_REVIEW_DIR . 'compat/comments.php';
}
function wp_review_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
function wp_review_comments_template_body_class( $classes ) {

	if ( is_singular() ) {
		$classes[] = 'wp_review_comments_template';
	}

	return $classes;
}
function wp_review_comments_template_style(  ) {
	wp_enqueue_style( 'wp_review_comments', trailingslashit( WP_REVIEW_ASSETS ) . 'css/comments.css', array(), WP_REVIEW_PLUGIN_VERSION, 'all' );
}

add_action( 'after_setup_theme', 'wp_review_override_comments_count', 30 );
function wp_review_override_comments_count() {
	remove_filter( 'get_comments_number', 'mts_comment_count', 0 );
	add_filter( 'get_comments_number', 'wp_review_comment_count', 0 );
}
function wp_review_comment_count( $count ) {
	if ( ! is_admin() ) {
		$comments = get_comments( 'status=approve&post_id=' . get_the_ID() );
		$comments_by_type = separate_comments( $comments );
		if ( isset( $comments_by_type['comment'] ) ) {
			$wp_review_comments_count = isset( $comments_by_type['wp_review_comment'] ) ? count( $comments_by_type['wp_review_comment'] ) : 0;
			return count( $comments_by_type['comment'] ) + $wp_review_comments_count;
		} else {
			return $count;
		}
	}

	return $count;
}

if ( !function_exists( 'wp_review_comments' ) ) {
	function wp_review_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
	    //$mts_options = get_option( MTS_THEME_NAME ); ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<?php
	        switch( $comment->comment_type ) :
	            case 'pingback':
	            case 'trackback': ?>
	                <div id="comment-<?php comment_ID(); ?>">
	                    <div class="comment-author vcard">
	                        Pingback: <?php comment_author_link(); ?>
	                        <?php //if ( ! empty( $mts_options['mts_comment_date'] ) ) { ?>
	                            <span class="ago"><?php comment_date( get_option( 'date_format' ) ); ?></span>
	                        <?php //} ?>
	                        <span class="comment-meta">
	                            <?php edit_comment_link( __( '( Edit )', 'wp-review' ), '  ', '' ) ?>
	                        </span>
	                    </div>
	                    <?php if ( $comment->comment_approved == '0' ) : ?>
	                        <em><?php _e( 'Your comment is awaiting moderation.', 'wp-review' ) ?></em>
	                        <br />
	                    <?php endif; ?>
	                </div>
	            <?php
	                break;

	            default: ?>
	                <div id="comment-<?php comment_ID(); ?>" itemscope itemtype="http://schema.org/UserComments">
	                    <div class="comment-author vcard">
	                        <?php echo get_avatar( $comment->comment_author_email, 50 ); ?>
	                        <?php printf( '<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person"><span itemprop="name">%s</span></span>', get_comment_author_link() ) ?>
	                        <?php //if ( ! empty( $mts_options['mts_comment_date'] ) ) { ?>
	                            <span class="ago"><?php comment_date( get_option( 'date_format' ) ); ?></span>
	                        <?php //} ?>
	                        <span class="comment-meta">
	                            <?php edit_comment_link( __( '( Edit )', 'wp-review' ), '  ', '' ) ?>
	                        </span>
	                    </div>
	                    <?php if ( $comment->comment_approved == '0' ) : ?>
	                        <em><?php _e( 'Your comment is awaiting moderation.', 'wp-review' ) ?></em>
	                        <br />
	                    <?php endif; ?>
	                    <div class="commentmetadata">
	                        <div class="commenttext" itemprop="commentText">
	                            <?php comment_text() ?>
	                        </div>
	                        <div class="reply">
	                            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] )) ) ?>
	                        </div>
	                    </div>
	                </div>
	            <?php
	               break;
	         endswitch; ?>
		<!-- WP adds </li> -->
	<?php
	}
}

$comment_form_integration = ( ! empty( $options['comment_form_integration'] ) ? $options['comment_form_integration'] : 'replace' );
if ($comment_form_integration != 'replace')
	$comment_form_integration = 'extend';


// Filter comment fields.
if ($comment_form_integration == 'replace') {
	add_filter( 'comment_form_fields', 'wp_review_comment_fields_replace', 99 );
} else {
	add_action( 'comment_form_logged_in_after', 'wp_review_comment_fields_extend' );
	add_action( 'comment_form_after_fields', 'wp_review_comment_fields_extend' );
}

/**
 * Replace comment Name / Email / Website fields with our own for consistent styling.
 * Also pushes the "comment" field (textarea) to the end of the comment form fields.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $fields
 * @return array
 */
function wp_review_comment_fields_replace( $fields ) {
	global $post;

	// Only touch review fields
	if ( ! is_singular() || ! wp_review_get_post_user_review_type() || ! in_array( wp_review_get_user_rating_setup( $post->ID ), array( WP_REVIEW_REVIEW_COMMENT_ONLY, WP_REVIEW_REVIEW_ALLOW_BOTH ) ) ) {
		return $fields;
	}
	//echo '<!-- '.print_r($fields,1).' -->'; return $fields;

	$review_add_fields = array(
		'review_title' => '<div class="wp-review-comment-form-title"><input type="text" name="wp_review_comment_title" class="wp-review-comment-title-field-input" size="30" id="wp-review-comment-title-field" placeholder="'.esc_attr__('Review Title', 'wp-review').'" value="" /></div>',
		'review_rating' => '<div class="wp-review-comment-form-rating">'.'<label class="review-comment-field-msg">'.( empty( $options['require_rating'] ) ? __('Rating', 'wp-review') : __('Rating *', 'wp-review') ).'</label>'.wp_review_comment_rating_input().'</div>'
	);
	$fields = $review_add_fields + $fields; // prepend our new fields

	if ( isset( $fields['author'] ) ) {
		$fields['author'] = '<div class="wp-review-comment-form-author"><label for="author" class="review-comment-field-msg">'.__('Name', 'wp-review').'</label><input id="author" name="author" type="text" value="" size="30" /></div>';
	}
	if ( isset( $fields['email'] ) ) {
		$fields['email'] = '<div class="wp-review-comment-form-email"><label for="email" class="review-comment-field-msg">'.__('Email', 'wp-review').'</label><input id="email" name="email" type="text"  value="" size="30" /></div>';
	}
	if ( isset( $fields['url'] ) ) {
		$fields['url'] = '<div class="wp-review-comment-form-url"><label for="url" class="review-comment-field-msg">'.__('Website', 'wp-review').'</label><input id="url" name="url" type="text" value="" size="30" /></div>';
	}


	if ( isset( $fields['comment'] ) ) {

		// Grab the comment field.
		$comment_field = $fields['comment'];

		// Remove the comment field from its current position.
		unset( $fields['comment'] );

		// Put the comment field at the end.
		// Also add title & rating field when user is logged in
		$new_comment_field = '';
		if ( is_user_logged_in() ) {
			foreach ($review_add_fields as $field_name => $field_html) {
				$new_comment_field .= $field_html;
			}
		}
		$new_comment_field .= '<div class="wp-review-comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.esc_attr__('Review Text*', 'wp-review').'"></textarea></div>';

		$fields['comment'] = $new_comment_field;
	}

	return $fields;
}


function wp_review_comment_fields_extend() {
    global $post;
    $options = get_option('wp_review_options');
    $review_through_comment = in_array( wp_review_get_user_rating_setup( $post->ID ), array( WP_REVIEW_REVIEW_COMMENT_ONLY, WP_REVIEW_REVIEW_ALLOW_BOTH ) );

    if ( wp_review_get_post_user_review_type() && $review_through_comment ) {
        $userReview = 0;
        $user_id = 0;
	    $items = get_post_meta( $post->ID, 'wp_review_item', true );
	    $rating_required = ! empty( $options['require_rating'] );
        $ip = wp_review_get_user_ip();
	    //$type = get_post_meta( $post->ID, 'wp_review_user_review_type', true );
        $type = wp_review_get_post_user_review_type( $post->ID );

        // Title field
	    $title_html = '<div class="wp-review-comment-title-field">';
	    $title_html .= '<label for="wp-review-comment-title-field" class="wp-review-comment-title-field-msg">'.__('Review Title', 'wp-review').'</label>';
	    $title_html .= '<span class="wp-review-comment-title-field-input-wrapper">';
	    $title_html .= '<input type="text" name="wp_review_comment_title" class="wp-review-comment-title-field-input" id="wp-review-comment-title-field" />';
	    $title_html .= '</span>';
	    $title_html .= '</div>';


    	$rating_html = '';
    	$rating_html .= '<div class="wp-review-comment-field wp-review-comment-rating-'.$type.'-wrapper">';
        $rating_html .= '<label class="review-comment-field-msg">'.( empty( $options['require_rating'] ) ? __('Rating', 'wp-review') : __('Rating *', 'wp-review') ).'</label>';
        $rating_html .= '<div class="wp-review-comment-field-inner" >';
        $rating_html .= wp_review_comment_rating_input();
        $rating_html .= '</div>';
        $rating_html .= '</div>';

	    echo $title_html;
        echo $rating_html;
    }
}


/**
 * Add the title to our admin area, for editing, etc
 */
add_action( 'add_meta_boxes_comment', 'wp_review_comment_add_meta_box' );
function wp_review_comment_add_meta_box() {
	global $wp_review_rating_types, $comment;
	$type = wp_review_get_post_user_review_type( $comment->comment_post_ID );
    add_meta_box( 'wp-review-comment-rating', sprintf(__( 'WP Review Rating (%s)', 'wp-review' ), $wp_review_rating_types[$type]['label']), 'wp_review_comment_meta_box_fields', 'comment', 'normal', 'high' );
}

function wp_review_comment_meta_box_fields( $comment ) {
	$comment_id = $comment->comment_ID;
	$rating = '';
    if ( WP_REVIEW_COMMENT_TYPE_COMMENT === get_comment_type( $comment_id ) ) {
        $rating = get_comment_meta( $comment_id, WP_REVIEW_COMMENT_RATING_METAKEY, true );
    } else {
        $rating = get_comment_meta( $comment_id, WP_REVIEW_VISITOR_RATING_METAKEY, true );
    }
    $title = get_comment_meta( $comment->comment_ID, WP_REVIEW_COMMENT_TITLE_METAKEY, true );
    wp_nonce_field( 'wp_review_comment_rating_update', 'wp_review_comment_rating_update', false );
    ?>
    <label for="wp_review_comment_rating"><?php _e( 'Review Title', 'wp-review' ); ?></label>
    <input type="text" name="wp_review_comment_title" value="<?php echo esc_attr( $title ); ?>" id="wp_review_comment_title" />
    <br />
    <label for="wp_review_comment_rating"><?php _e( 'Rating', 'wp-review' ); ?></label>
    <input type="number" class="small-text" name="wp_review_comment_rating" value="<?php echo esc_attr( $rating ); ?>" id="wp_review_comment_rating" />
    <?php
}

/**
 * Save our comment (from the admin area)
 */
add_action( 'edit_comment', 'wp_review_comment_edit_comment' );
function wp_review_comment_edit_comment( $comment_id ) {
    if( ! isset( $_POST['wp_review_comment_rating'] ) || ! isset($_POST['wp_review_comment_rating_update']) || ! wp_verify_nonce( $_POST['wp_review_comment_rating_update'], 'wp_review_comment_rating_update' ) ) return;

    $metakey = '';
    if ( WP_REVIEW_COMMENT_TYPE_COMMENT === get_comment_type( $comment_id ) ) {
        $metakey = WP_REVIEW_COMMENT_RATING_METAKEY;
    } else {
        $metakey = WP_REVIEW_VISITOR_RATING_METAKEY;
    }

	/* if ( is_array( $_POST['wp_review_comment_rating'] ) ) {
		$ratings = filter_input( INPUT_POST, 'wp_review_comment_rating', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
		$current = get_comment_meta( $comment_id, $metakey, true );
		$keys = array_keys( $current );
		$rating = array();
		foreach ( $ratings as $key => $value ) {
			$rating[ $keys[ $key ] ] = $value;
		}
	} else { */
		$rating = filter_input( INPUT_POST, 'wp_review_comment_rating', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	/* } */

	if ( ! empty( $rating ) ) {
		$comment = get_comment( $comment_id );
		update_comment_meta( $comment_id, $metakey, $rating );
		mts_get_post_comments_reviews( $comment->comment_post_ID, true );
	}

	if ( ! empty( $_POST['wp_review_comment_title'] ) ) {
		$title = sanitize_text_field( $_POST['wp_review_comment_title'] );
		update_comment_meta( $comment_id, WP_REVIEW_COMMENT_TITLE_METAKEY, $title );
	}
}

/**
 * Save our title & rating (from the front end)
 */
add_action( 'comment_post', 'wp_review_comment_insert_comment', 10, 2 );
function wp_review_comment_insert_comment( $comment_id, $comment_approved ) {
	global $wp_review_rating_types;
	$rating = 0;
	$comment = get_comment( $comment_id );
	$type = wp_review_get_post_user_review_type( $comment->comment_post_ID );

	if ( isset( $_POST['wp-review-user-rating-val'] ) ) {
		/*

		if ( is_array( $_POST['wp_review_comment_rating'] ) ) {

			$comment = get_comment( $comment_id );
			$items = get_post_meta( $comment->comment_post_ID, 'wp_review_item', true );
			$raw_rating = filter_input( INPUT_POST, 'wp_review_comment_rating', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
			$rating = array();
			for ( $i = 0, $length = count( $items ); $i < $length; $i++  ) {
				$rating[ $items[ $i ]['wp_review_item_title'] ] = $raw_rating[ $i ];
			}
		} else {

		*/
			$rating = filter_input( INPUT_POST, 'wp-review-user-rating-val', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			// make sure it's below the max value
			//$comment = get_comment( $comment_id );
			//$type = wp_review_get_post_user_review_type( $comment->comment_post_ID );

			if ( $rating > $wp_review_rating_types[$type]['max'] ) {
				$rating = $wp_review_rating_types[$type]['max'];
			}
		/* } */
	}

	if ( $rating ) {
		update_comment_meta( $comment_id, WP_REVIEW_COMMENT_RATING_METAKEY, $rating );
	}

	if ( ! empty( $_POST['wp_review_comment_title'] ) ) {
		$title = sanitize_text_field( $_POST['wp_review_comment_title'] );
		update_comment_meta( $comment_id, WP_REVIEW_COMMENT_TITLE_METAKEY, $title );
	}

	if( $rating && 1 === $comment_approved ) {
		// Update total through comment rating
		mts_get_post_comments_reviews( $comment->comment_post_ID, true );
	}
}

/**
 * Add our rating and title to the comment text
 */
add_filter( 'comment_text', 'wp_review_comment_add_title_to_text', 99, 2 );
function wp_review_comment_add_title_to_text( $text, $comment ) {

    if ( is_admin() ) {
		$comment_id = $comment->comment_ID;
    	$title = get_comment_meta( $comment_id, WP_REVIEW_COMMENT_TITLE_METAKEY, true );
    	$title_html = '';
    	if ($title)
			$title_html = '<h4 class="wp-review-comment-title">'.$title.'</h4>';

		$post_id = $comment->comment_post_ID;
		$rating_html = '';
		$type = get_comment_type( $comment_id );
		$rating = '';
	    if ( WP_REVIEW_COMMENT_TYPE_COMMENT === $type ) {
	        $rating = get_comment_meta( $comment_id, WP_REVIEW_COMMENT_RATING_METAKEY, true );
	    } else if ( WP_REVIEW_COMMENT_TYPE_VISITOR === $type ) {
	        $rating = get_comment_meta( $comment_id, WP_REVIEW_VISITOR_RATING_METAKEY, true );
	        $text = ''; // Don't show text for Visitor Ratings
	    }
	    if ( $rating ) {
	        $rating_html = wp_review_comment_rating( $rating, $comment_id );
	    }

    	$text .= '<div id="inline-commentreview-'.$comment_id.'" class="hidden">
    	<input type="hidden" class="comment-review-title" value="'.esc_attr($title).'">
    	<input type="hidden" class="comment-review-rating" value="'.esc_attr($rating).'">
    	<input type="hidden" class="comment-review-type" value="'.esc_attr(get_comment_type( $comment_id )).'">
    	</div>';

    	return $title_html . $rating_html . $text;
    }


	$title = '';
	$review = '';
	$feedback = '';

	$options = get_option('wp_review_options');

	if ( $title_meta = get_comment_meta( $comment->comment_ID, WP_REVIEW_COMMENT_TITLE_METAKEY, true ) ) {
		$title = '<h4 class="wp-review-comment-title">'.$title_meta.'</h4>';
	}

    if( $rating = get_comment_meta( $comment->comment_ID, WP_REVIEW_COMMENT_RATING_METAKEY, true ) ) {
        $review .= wp_review_comment_rating( $rating );

        /*
         * user can give review feedback (useful or not)
         */


	    if ( ! empty( $options['allow_comment_feedback'] ) ) {
		    $user_id = get_current_user_id();
		    $user_ip = wp_review_get_user_ip();
		    $voted_helpful = get_comment_meta( $comment->comment_ID, 'wp_review_voted_h' );
		    $voted_unhelpful = get_comment_meta( $comment->comment_ID, 'wp_review_voted_uh' );
		    $helpful = absint( get_comment_meta( $comment->comment_ID, 'wp_review_comment_helpful', true ) );
		    $unhelpful = absint( get_comment_meta( $comment->comment_ID, 'wp_review_comment_unhelpful', true ) );

		    $feedback = '<p class="wp-review-feedback">';
		    $feedback .= __( 'Did you find this review helpful?', 'wp-review' ) . ' ';
		    $feedback .= '<a class="review-btn' . ( in_array( $user_ip, $voted_helpful ) ? ' voted' : '' ) . '" data-value="yes" data-comment-id="' . $comment->comment_ID . '" href="#">' . __( 'Yes', 'wp-review' );
		    $feedback .= ( $helpful > 0 ? ( ' <span class="feedback-count">(' . $helpful . ')</span>' ) : ' <span class="feedback-count"></span>')  . '</a>';
		    $feedback .= '<a class="review-btn' . ( in_array( $user_ip, $voted_unhelpful ) ? ' voted' : '' ) . '" data-value="no" data-comment-id="' . $comment->comment_ID . '" href="#">' . __( 'No', 'wp-review' );
		    $feedback .= ( $unhelpful > 0 ? ( ' <span class="feedback-count">(' . $unhelpful . ')</span>' ) : ' <span class="feedback-count"></span>')  . '</a>';
		    $feedback .= '</p>';
	    }

    }

    return $title . $review . '<div class="comment-text-inner">' . $text . '</div>' . $feedback;
}

/**
 * Add rating and title to the comment quick edit
 */
add_filter( 'wp_comment_reply', 'wp_review_comment_reply_filter', 10, 2 );
function wp_review_comment_reply_filter( $output, $args ) {
	extract($args);
	$table_row = true;
	global $wp_list_table;
	if ( ! $wp_list_table ) {
		if ( $mode == 'single' ) {
			$wp_list_table = _get_list_table('WP_Post_Comments_List_Table');
		} else {
			$wp_list_table = _get_list_table('WP_Comments_List_Table');
		}
	}
	ob_start();
	?>
	<form method="get">
	<?php if ( $table_row ) : ?>
	<table style="display:none;"><tbody id="com-reply"><tr id="replyrow" class="inline-edit-row" style="display:none;"><td colspan="<?php echo $wp_list_table->get_column_count(); ?>" class="colspanchange">
	<?php else : ?>
	<div id="com-reply" style="display:none;"><div id="replyrow" style="display:none;">
	<?php endif; ?>
	<fieldset class="comment-reply">
	<legend>
	<span class="hidden" id="editlegend"><?php _e( 'Edit Comment', 'wp-review' ); ?></span>
	<span class="hidden" id="replyhead"><?php _e( 'Reply to Comment', 'wp-review' ); ?></span>
	<span class="hidden" id="addhead"><?php _e( 'Add new Comment', 'wp-review' ); ?></span>
	</legend>

	<div id="editwpreview">
	<div class="inside">
	<label for="wp_review_comment_title"><?php _e( 'Review Title', 'wp-review' ) ?></label>
	<input type="text" name="wp_review_comment_title" size="50" value="" id="wp_review_comment_title" />
	</div>

	<div class="inside">
	<label for="wp_review_comment_title"><?php _e( 'Rating', 'wp-review' ) ?></label>
	<input type="text" name="wp_review_comment_rating" size="50" value="" id="wp_review_comment_rating" />
	</div>
	</div>
	</div>

	<div id="replycontainer">
	<label for="replycontent" class="screen-reader-text"><?php _e( 'Comment', 'wp-review' ); ?></label>
	<?php
	$quicktags_settings = array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close' );
	wp_editor( '', 'replycontent', array( 'media_buttons' => false, 'tinymce' => false, 'quicktags' => $quicktags_settings ) );
	?>
	</div>

	<div id="edithead" style="display:none;">
	<div class="inside">
	<label for="author-name"><?php _e( 'Name', 'wp-review' ) ?></label>
	<input type="text" name="newcomment_author" size="50" value="" id="author-name" />
	</div>

	<div class="inside">
	<label for="author-email"><?php _e( 'Email', 'wp-review' ) ?></label>
	<input type="text" name="newcomment_author_email" size="50" value="" id="author-email" />
	</div>

	<div class="inside">
	<label for="author-url"><?php _e( 'URL', 'wp-review' ) ?></label>
	<input type="text" id="author-url" name="newcomment_author_url" class="code" size="103" value="" />
	</div>
	</div>

	<p id="replysubmit" class="submit">
	<a href="#comments-form" class="save button-primary alignright">
	<span id="addbtn" style="display:none;"><?php _e( 'Add Comment', 'wp-review' ); ?></span>
	<span id="savebtn" style="display:none;"><?php _e( 'Update Comment', 'wp-review' ); ?></span>
	<span id="replybtn" style="display:none;"><?php _e( 'Submit Reply', 'wp-review' ); ?></span></a>
	<a href="#comments-form" class="cancel button-secondary alignleft"><?php _e( 'Cancel', 'wp-review' ); ?></a>
	<span class="waiting spinner"></span>
	<span class="error" style="display:none;"></span>
	</p>

	<input type="hidden" name="action" id="action" value="" />
	<input type="hidden" name="comment_ID" id="comment_ID" value="" />
	<input type="hidden" name="comment_post_ID" id="comment_post_ID" value="" />
	<input type="hidden" name="status" id="status" value="" />
	<input type="hidden" name="position" id="position" value="<?php echo $position; ?>" />
	<input type="hidden" name="checkbox" id="checkbox" value="<?php echo $checkbox ? 1 : 0; ?>" />
	<input type="hidden" name="mode" id="mode" value="<?php echo esc_attr($mode); ?>" />
	<?php
	wp_nonce_field( 'replyto-comment', '_ajax_nonce-replyto-comment', false );
	if ( current_user_can( 'unfiltered_html' ) )
		wp_nonce_field( 'unfiltered-html-comment', '_wp_unfiltered_html_comment', false );

	wp_nonce_field( 'wp_review_comment_rating_update', 'wp_review_comment_rating_update', false );

	?>
	</fieldset>
	<?php if ( $table_row ) : ?>
	</td></tr></tbody></table>
	<?php else : ?>
	</div></div>
	<?php endif; ?>
	</form>
	<?php

	return ob_get_clean();
}
/**
 * Script for Comments quick edit
 */
add_action('admin_footer', 'wp_review_comment_quick_edit_javascript');
function wp_review_comment_quick_edit_javascript() {
?>
    <script type="text/javascript">
    function wpreview_expandedOpen(id) {
        var editRow = jQuery('#replyrow');
        var rowData = jQuery('#inline-commentreview-'+id);
        var type = jQuery('.comment-review-type', rowData).val();
        console.log(type)
        if (type == 'wp_review_comment') {
    		jQuery('#wp_review_comment_title', editRow).val( jQuery('.comment-review-title', rowData).val() ).closest('.inside').show();
            jQuery('#wp_review_comment_rating', editRow).val( jQuery('.comment-review-rating', rowData).val() ).closest('.inside').show();
		} else if (type == 'wp_review_visitor') {
    		jQuery('#wp_review_comment_title', editRow).val( '' ).closest('.inside').hide();
            jQuery('#wp_review_comment_rating', editRow).val( jQuery('.comment-review-rating', rowData).val() ).closest('.inside').show();
		} else {
			jQuery('#wp_review_comment_title', editRow).val( '' ).closest('.inside').hide();
            jQuery('#wp_review_comment_rating', editRow).val( '' ).closest('.inside').hide();
		}

    }
    </script>
   <?php
}
add_filter( 'comment_row_actions', 'wp_review_comment_quick_edit_action', 10, 2);
function wp_review_comment_quick_edit_action($actions, $comment ) {
    global $post;
    //$actions['quickedit'] = '<a onclick="commentReply.close();if (typeof(wpreview_expandedOpen) == \'function\') wpreview_expandedOpen('.$comment->comment_ID.');commentReply.open( \''.$comment->comment_ID.'\',\''.$post->ID.'\',\'edit\' );return false;" class="vim-q" title="'.esc_attr__( 'Quick Edit' ).'" href="#">' . __( 'Quick&nbsp;Edit' ) . '</a>';
    $actions['quickedit'] = '<span class=\'quickedit hide-if-no-js\'> | <a onclick="if (typeof(wpreview_expandedOpen) == \'function\') wpreview_expandedOpen('.$comment->comment_ID.');" data-comment-id="'.$comment->comment_ID.'" data-post-id="'.$comment->comment_post_ID.'" data-action="edit" class="vim-q comment-inline" title="'.__('Edit this item inline', 'wp-review').'" href="#">'.__('Quick Edit', 'wp-review').'</a></span>';
    return $actions;
}

add_action( 'preprocess_comment', 'wp_review_preprocess_comment');
function wp_review_preprocess_comment( $commentdata ) {
    $options = get_option( 'wp_review_options' );
    $review_through_comment = in_array( wp_review_get_user_rating_setup( $commentdata['comment_post_ID'] ), array( WP_REVIEW_REVIEW_COMMENT_ONLY, WP_REVIEW_REVIEW_ALLOW_BOTH ) );

	// if ( ! empty( $_POST['wp_review_comment_rating'] ) && is_array( $_POST['wp_review_comment_rating'] ) ) {
	//	$rating = filter_input( INPUT_POST, 'wp_review_comment_rating', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
	//} else {
		$rating = filter_input( INPUT_POST, 'wp-review-user-rating-val', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	//}

	$user_id = 0;
	if ( is_user_logged_in() ) { $user_id = get_current_user_id(); }
	$ip = wp_review_get_user_ip();

    /* if ( is_array( $rating ) ) {
	    foreach ( $rating as $rating_num ) {
		    if ( $rating_num <= 0 ) {
			    wp_die( esc_html__( 'Ratings are required! Hit the back button to add your ratings.', 'wp-review' ) );
		    }
	    }
    } */

	if( ! empty( $rating ) ) {
       $commentdata['comment_type'] = WP_REVIEW_COMMENT_TYPE_COMMENT;
    } elseif ( ( ! empty( $options['require_rating'] ) && $review_through_comment && ! is_admin() ) ) {
        wp_die( esc_html__( 'A rating is required! Hit the back button to add your rating.', 'wp-review' ) );
    }

    return $commentdata;
}

/**
 * Replace "Comment" with "Review" in submit field
 *
 */
add_filter( 'comment_form_submit_field', 'wp_review_change_submit_comment', 10 );
function wp_review_change_submit_comment( $field ) {
	global $post;
	$review_through_comment = in_array( wp_review_get_user_rating_setup( $post->ID ), array( WP_REVIEW_REVIEW_COMMENT_ONLY, WP_REVIEW_REVIEW_ALLOW_BOTH ) );
	if ( $review_through_comment ) {
		$field = str_replace( __('Comment', 'wp-review'), __('Review', 'wp-review'), $field );
	}
	return $field;
}

/*
 * Show 'all' comment types instead of only 'comment' type in MTS themes
 */
add_filter( 'wp_list_comments_args', 'wp_review_list_comments_args' );
function wp_review_list_comments_args( $args ) {
	if ( is_admin() )
		return $args;

	global $post;
	$review_through_comment = in_array( wp_review_get_user_rating_setup( $post->ID ), array( WP_REVIEW_REVIEW_COMMENT_ONLY, WP_REVIEW_REVIEW_ALLOW_BOTH ) );
	if ( ! $review_through_comment ) {
		return $args;
	}

	if ( $args['type'] == 'comment' && apply_filters( 'wp_review_to_comment_type_list', true ) ) {
		$args['type'] = 'all';
	}
	return $args;
}

function wp_review_comment_rating_input( $args = array() ) {
	global $post, $wp_review_rating_types;
	$type = wp_review_get_post_user_review_type( $post->ID );
	$rating_type_template = $wp_review_rating_types[$type]['input_template'];
	$post_id = $post->ID;
	$value = 0;
	$comment_rating = true;

	$options = get_option('wp_review_options');
	$custom_colors = get_post_meta( $post_id, 'wp_review_custom_colors', true );
	$colors['color'] = get_post_meta( $post_id, 'wp_review_color', true );
	if( empty($colors['color']) ) $colors['color'] = '#333333';
	$colors['type']  = get_post_meta( $post_id, 'wp_review_type', true );
	$colors['fontcolor'] = get_post_meta( $post_id, 'wp_review_fontcolor', true );
	$colors['bgcolor1']  = get_post_meta( $post_id, 'wp_review_bgcolor1', true );
	$colors['bgcolor2']  = get_post_meta( $post_id, 'wp_review_bgcolor2', true );
	$colors['bordercolor']  = get_post_meta( $post_id, 'wp_review_bordercolor', true );
	if ( ! $custom_colors && ! empty($options['colors'] ) && is_array($options['colors'] ) ) {
		$colors = array_merge($colors, $options['colors']);
	}
    $colors = apply_filters('wp_review_colors', $colors, $post_id);
    $color = $colors['color'];

	set_query_var( 'rating', compact( 'value', 'post_id', 'comment_rating', 'args', 'color', 'colors' ) );
	ob_start();
	load_template( $rating_type_template, false );
	$review = '<div class="wp-review-comment-rating wp-review-comment-rating-'.$type.'">'.ob_get_contents().'</div>';
	ob_end_clean();

	return $review;
}

function wp_review_comment_rating( $value, $comment_id = null, $args = array() ) {
	global $wp_review_rating_types, $post;

	if ( ! empty( $comment_id ) ) {
		$comment = get_comment( $comment_id );
		$post_id = $comment->comment_post_ID;
	} else {
		$post_id = $post->id;
	}
	$type = wp_review_get_post_user_review_type( $post_id );

	if ( empty( $type ) )
		return '';

	$options = get_option('wp_review_options');
	$custom_colors = get_post_meta( $post_id, 'wp_review_custom_colors', true );

	$colors['color'] = get_post_meta( $post_id, 'wp_review_color', true );
	if( empty($colors['color']) ) $colors['color'] = '#333333';
	$colors['type']  = get_post_meta( $post_id, 'wp_review_type', true );
	$colors['fontcolor'] = get_post_meta( $post_id, 'wp_review_fontcolor', true );
	$colors['bgcolor1']  = get_post_meta( $post_id, 'wp_review_bgcolor1', true );
	$colors['bgcolor2']  = get_post_meta( $post_id, 'wp_review_bgcolor2', true );
	$colors['bordercolor']  = get_post_meta( $post_id, 'wp_review_bordercolor', true );
	if ( ! $custom_colors && ! empty($options['colors'] ) && is_array($options['colors'] ) ) {
		$colors = array_merge($colors, $options['colors']);
	}

	if (!empty($options['custom_comment_colors'])) {
		$colors['color'] = $options['comment_color'];
	}
    $colors = apply_filters('wp_review_colors', $colors, $post_id);

    // Override colors if is_admin()
    if (is_admin() && !defined('DOING_AJAX')) {
    	$admin_colors = array(
    		'color' => '#444444',
    		'bgcolor1' => '#ffffff',
		);
		$colors = array_merge($colors, $admin_colors);
    }
    $color = $colors['color'];
    // don't allow higher rating than max
	if ($value > $wp_review_rating_types[$type]['max']) {
		$value = $wp_review_rating_types[$type]['max'];
	}
	$template = $wp_review_rating_types[$type]['output_template'];
	$comment_rating = true;
	set_query_var( 'rating', compact( 'value', 'type', 'args', 'comment_rating', 'post_id', 'color', 'colors' ) );
	ob_start();
	load_template( $template, false );
	$review = '<div class="wp-review-usercomment-rating wp-review-usercomment-rating-'.$type.'">'.ob_get_contents().'</div>';
	ob_end_clean();
	return $review;
}

// Keep "comment" class in 'wp_review_comment' comment type
add_filter( 'comment_class', 'wp_review_comment_type_classes', 10, 6 );
function wp_review_comment_type_classes( $classes, $class, $comment_ID, $comment, $post_id ) {
	if ( WP_REVIEW_COMMENT_TYPE_COMMENT === $comment->comment_type ) {
		$classes[] = 'comment';
	}

	return $classes;
}

// Enable avatar for 'wp_review_comment' comment type
add_filter( 'get_avatar_comment_types', 'wp_review_comment_type_avatar' );
function wp_review_comment_type_avatar( $types ) {
    $types[] = 'wp_review_comment';
    return $types;
}

// Update user ratings total if comment status is changed
add_action( 'transition_comment_status', 'wp_review_update_comment_ratings', 10, 3 );
function wp_review_update_comment_ratings( $new_status, $old_status, $comment ) {
	if ( WP_REVIEW_COMMENT_TYPE_COMMENT === $comment->comment_type ) {
		mts_get_post_comments_reviews( $comment->comment_post_ID, true );
	}
	if ( WP_REVIEW_COMMENT_TYPE_VISITOR === $comment->comment_type ) {
		mts_get_post_reviews( $comment->comment_post_ID, true );
	}
}
