<?php
/**
 * @package Schema Premium - Class Schema AdvertiserContentArticle
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AdvertiserContentArticle') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AdvertiserContentArticle extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'AdvertiserContentArticle';
		
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
			
			return __('Advertiser Content Article', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An Article that an external entity has paid to place or to produce to its specifications. Includes advertorials, sponsored content, native advertising and other paid content.', 'schema-premium');
		}
	}
	
	//new Schema_WP_AdvertiserContentArticle();
	
endif;
