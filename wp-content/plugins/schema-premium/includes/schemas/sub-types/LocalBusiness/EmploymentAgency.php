<?php
/**
 * @package Schema Premium - Class Schema EmploymentAgency
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_EmploymentAgency') ) :
	/**
	 * Schema EmploymentAgency
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_EmploymentAgency extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'EmploymentAgency';
		
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
			
			return __('Employment Agency', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An employment agency.', 'schema-premium');
		}
	}
	
	//new Schema_WP_EmploymentAgency();
	
endif;
