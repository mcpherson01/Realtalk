<?php
/**
 * @package Schema Premium - Class Schema TechArticle
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_TechArticle') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_TechArticle extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'TechArticle';
		
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
			
			return __('Tech Article', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A technical article - Example: How-to (task) topics, step-by-step, procedural troubleshooting, specifications, etc.', 'schema-premium');
		}
	}
	
	//new Schema_WP_TechArticle();
	
endif;
