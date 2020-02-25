<?php

class CBC_About_Page extends CBC_Page_Init implements CBC_Page{

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::get_html()
	 */
	public function get_html(){
		// view
		ccb_enqueue_player();
		include CBC_PATH . '/views/about.php';
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::on_load()
	 */
	public function on_load(){
		
	}
}