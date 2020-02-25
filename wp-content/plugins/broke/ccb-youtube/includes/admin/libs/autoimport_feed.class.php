<?php

/**
 * Manages automatic import post type feed
 */
class CBC_Autoimport_Feed{

	/**
	 * Holds reference to post type object
	 * 
	 * @var CBC_Video_Post_Type
	 */
	private $post_type;

	/**
	 * Holds reference of post object retrieved from DB
	 */
	private $post_obj = false;

	/**
	 * Stores the current feed options
	 * 
	 * @var array
	 */
	private $options;

	/**
	 * Accepts as argument an instance of CBC_Video_Post_Type
	 * 
	 * @param CBC_Video_Post_Type $post_type_obj
	 */
	public function __construct( CBC_Video_Post_Type $post_type_obj ){
		$this->post_type = $post_type_obj;
		$this->options = $this->_defaults( 'all' );
	}

	/**
	 * Sets a post for the current instance
	 * 
	 * @param integer/WP_Post $post - post ID or WP_Post object
	 */
	public function set_post( $post ){
		if( is_a( $post, 'WP_Post' ) ){
			$this->post_obj = $post;
		}else if( is_numeric( $post ) ){
			$post = get_post( $post );
			if( $post && ! is_wp_error( $post ) ){
				$this->post_obj = $post;
			}
		}
		// check post type of the object retrieved to have the same value as the feed post type
		if( $this->post_obj ){
			if( $this->post_obj->post_type != $this->get_feed_post_type() ){
				$this->post_obj = false;
			}else{
				$meta = get_post_meta( $this->post_obj->ID, $this->get_feed_meta_name(), true );
				foreach( $this->options as $k => $v ){
					if( isset( $meta[ $k ] ) ){
						$this->options[ $k ] = $meta[ $k ];
					}
				}
				$this->options[ 'title' ] = $this->post_obj->post_title;
				$this->options[ 'status' ] = $this->post_obj->post_status;
			}
		}
		
		return $this->post_obj;
	}

	/**
	 * Get the feed options
	 * 
	 * @param string $key
	 */
	public function get( $key = false ){
		if( $key ){
			if( ! isset( $this->options[ $key ] ) ){
				return new WP_Error( 'cbc_playlist_meta_option_missing', __( 'No such option found in playlist settings.', 'cbc_video' ), $key );
			}
			return $this->options[ $key ];
		}
		return $this->options;
	}
	
	/**
	 * Change an option of the feed
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set( $key, $value ){
		if( isset( $this->options[ $key ] ) ){
			$this->options[ $key ] = $value;
		}
	}

	/**
	 * Automatic import feeds have several default options set on post
	 * meta.
	 * This method returns the defaults for those options.
	 * 
	 * @param $which - which options should be returned: basic: returns only user options; all: returns all options
	 * @return multitype:string boolean number
	 */
	private function _defaults( $which = 'all' ){
		$defaults = array( 
				'type' => 'user',  // playlist type; possible values: user, channel, playlist
				'id' => '',  // feed ID taken from YouTube
				/* Post options */
				'title' => '',  // playlist title for internal usage; will end up as post title
				'status' => 'publish',  // feed status; will end up as post status
				/* Importing options */
				'theme_import' => false,  // import videos for theme
				'native_tax' => - 1,  // selected plugin category taxonomy
				'theme_tax' => - 1,  // selected theme category taxonomy
				'import_user' => - 1,  // import as a different user other than de one logged in now
				'start_date' => false,  // import only videos published after this date
				'no_reiterate' => false, 
				'repeat' => 1,  // number of times a given playlist should be repeated in queue before going to the next automatic import
				'repeats_left' => 1 
		) // used internally by the plugin to count the number of repeats left
; // do not parse the feed again after parsing it the first time
		
		$extra = array(
				/* Feed import statistics */
				'updated' => false,  // the date when the feed was last queried
				'total' => 0,  // total videos in feed
				'imported' => 0,  // videos imported from feed
				'processed' => 0,  // videos processed from feed
				/* Processing errors and other */
				'errors' => false,  // errors that happened when importing
				'page_token' => '',  // current page token returned by YouTube
				'first_video' => '',  // the first video ID in feed
				'last_video' => '', 
				'etag' => '' 
		); // last imported video from feed
		
		switch( $which ){
			case 'user':
				return $defaults;
			break;
			case 'extra':
				return $extra;
			break;
			case 'all':
			default:
				return array_merge( $defaults, $extra );
			break;
		}
	}

	/**
	 * Creates a new feed auto import
	 * 
	 * @param string $title
	 * @param string $status
	 * @param array $settings
	 */
	public function __insert( $title = '', $status = 'draft', $settings, $post_id = 0 ){
		$defaults = $this->_defaults( 'user' );
		$settings[ 'status' ] = 'draft' == $status ? 'draft' : 'publish';
		$settings[ 'no_reiterate' ] = isset( $settings[ 'no_reiterate' ] );
		$settings[ 'theme_import' ] = isset( $settings[ 'theme_import' ] );
		$settings[ 'start_date' ] = ! empty( $settings[ 'start_date' ] ) ? $settings[ 'start_date' ] : false;
		$settings[ 'repeat' ] = isset( $settings[ 'repeat' ] ) ? $settings[ 'repeat' ] : 1;
		$settings[ 'repeats_left' ] = $settings[ 'repeat' ];
		
		foreach( $defaults as $var => $val ){
			if( isset( $settings[ $var ] ) && is_string( $val ) && empty( $settings[ $var ] ) ){
				return new WP_Error( 'cbc_empty_required_fields', __( 'Required fields were found empty.', 'cbc_video' ) );
			}
		}
		
		$post_id = wp_insert_post( array( 
				'post_title' => $title, 
				'post_type' => $this->get_feed_post_type(), 
				'post_status' => 'draft' == $status ? 'draft' : 'publish', 
				'ID' => $post_id 
		) );
		
		if( $post_id ){
			if( ! is_wp_error( $post_id ) ){
				$this->options = wp_parse_args( $settings, $this->options );
				update_post_meta( $post_id, $this->get_feed_meta_name(), $this->options );
			}
			return $post_id;
		}
		
		return false;
	}

	/**
	 * Resets a playlist.
	 * Before using this method, a playlist post must be set using method CBC_Autoimport_Feed::set_post()
	 * 
	 * @return NULL
	 */
	public function __reset(){
		if( ! $this->post_obj ){
			return;
		}
		$this->options = wp_parse_args( $this->_defaults( 'extra' ), $this->options );
		update_post_meta( $this->post_obj->ID, $this->get_feed_meta_name(), $this->options );
	}

	/**
	 * Store the options from self::$options
	 */
	public function __store(){
		if( ! $this->post_obj ){
			return;
		}
		update_post_meta( $this->post_obj->ID, $this->get_feed_meta_name(), $this->options );
	}

	/**
	 * For the current set post object, switches the post status
	 * to either the given status or on and off
	 * 
	 * @param string $status
	 */
	public function __switch_status( $status = false ){
		if( ! $this->post_obj ){
			return;
		}
		
		if( ! $status ){
			$status = 'draft' == $this->post_obj->post_status ? 'publish' : 'draft';
		}
		
		wp_update_post( array( 
				'post_status' => 'draft' == $status ? 'draft' : 'publish', 
				'ID' => $this->post_obj->ID 
		) );
		
		$this->options[ 'status' ] = $status;
	}

	/**
	 * Deletes the currently set post feed
	 */
	public function __delete(){
		if( ! $this->post_obj ){
			return;
		}
		wp_delete_post( $this->post_obj->ID, true );
		// reset
		$this->post_obj = false;
		$this->options = false;
	}
	
	/**
	 * Verifies if current playlist should repeat the import
	 * @param boolean $update - update the option in DB (true) or just return the status
	 * @return bool - playlist should repeat import (true) or not (false)
	 */
	public function repeat( $update = false ){
		if( ! $this->post_obj ){
			return;
		}
		
		$repeats_left = $this->get( 'repeats_left' ) - 1;
		$result = $repeats_left > 0;
		if( $update ){
			$value = $result ? $repeats_left : $this->get( 'repeat' );
			$this->__set( 'repeats_left' , $value );
			$this->__store();
			_cbc_debug_message( sprintf( 'Updated repeats left to %s for playlist ID %s', $value, $this->post_obj->ID ) );
		}		
		return $result;
	}
	
	/**
	 * Returns the name of the custom field that will hold the feed settings
	 * 
	 * @uses CBC_Video_Post_Type::get_playlist_meta_name()
	 * @return string
	 */
	public function get_feed_meta_name(){
		return $this->post_type->get_playlist_meta_name();
	}

	/**
	 * Returns the post type registered for automatic import feeds
	 * 
	 * @uses CBC_Video_Post_Type::get_playlist_post_type()
	 * @return string
	 */
	public function get_feed_post_type(){
		return $this->post_type->get_playlist_post_type();
	}

	/**
	 * Returns the default options for an automatic import feed
	 * 
	 * @uses CBC_Autoimport_Feed::defaults()
	 * @return multitype:string boolean number
	 */
	public function get_default_options(){
		return $this->_defaults();
	}
}