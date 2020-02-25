<?php
/**
 * @package Schema Premium - Class Schema DiscussionForumPosting
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_DiscussionForumPosting') ) :
	/**
	 * Schema DiscussionForumPosting
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_DiscussionForumPosting extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'DiscussionForumPosting';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			// emty __construct
			
		}
		
		/**
		* Init
		*
		* @since 1.0.0
	 	*/
		public function init() {
		
			//add_filter( 'schema_output_Article', array( $this, 'filter_output' ) );
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Discussion Forum Posting', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A posting to a discussion forum.', 'schema-premium');
		}
		
		/**
		* Apply filters to markup output
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_DiscussionForumPosting', $schema );
		}
	}
	
	//new Schema_WP_DiscussionForumPosting();
	
endif;
