<?php
/**
 * @package Schema Premium - Class Schema NewsArticle
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_NewsArticle') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_NewsArticle extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'NewsArticle';
		
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
			
			return __('News Article', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A NewsArticle is an article whose content reports news, or provides background context and supporting materials for understanding the news.', 'schema-premium');
		}
	}
	
	//new Schema_WP_NewsArticle();
	
endif;
