<?php

	/**
	 * The controller to process the page 404.
	 */
	class WHM_Page404Controller {

		public function __construct()
		{
			if( !WHM_Helpers::isHideModeActive() ) {
				return;
			}
			if( !isset($_GET['hmwp_404']) ) {
				return;
			}

			$_SERVER['REQUEST_URI'] = '/hmwp_404?hmwp_404';
		}
	}

	WHM_Plugin::$page_404_controller = new WHM_Page404Controller();