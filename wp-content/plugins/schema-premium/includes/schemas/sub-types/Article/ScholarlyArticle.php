<?php
/**
 * @package Schema Premium - Class Schema ScholarlyArticle
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_ScholarlyArticle') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_ScholarlyArticle extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'ScholarlyArticle';
		
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
			
			return __('Scholarly Article', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A scholarly article.', 'schema-premium');
		}
	}
	
	//new Schema_WP_ScholarlyArticle();
	
endif;
