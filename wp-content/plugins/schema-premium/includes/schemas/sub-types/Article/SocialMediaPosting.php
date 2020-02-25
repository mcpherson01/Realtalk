<?php
/**
 * @package Schema Premium - Class Schema SocialMediaPosting
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_SocialMediaPosting') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_SocialMediaPosting extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'SocialMediaPosting';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			// emty __construct
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Social Media Posting', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A post to a social media platform, including blog posts, tweets, Facebook posts, etc.', 'schema-premium');
		}
	}
	
	//new Schema_WP_SocialMediaPosting();
	
endif;
