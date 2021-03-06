<?php
/**
 * @package Schema Premium - Class Schema Medical Web Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MedicalWebPage') ) :
	/**
	 * Schema MedicalWebPage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MedicalWebPage extends Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'MedicalWebPage';
		
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
			
			return __('Medical Web Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A web page that provides medical information.', 'schema-premium');
		}
	}
	
	//new Schema_WP_MedicalWebPage();
	
endif;
