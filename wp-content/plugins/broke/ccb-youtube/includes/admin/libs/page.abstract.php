<?php

/**
 * Admin page base class, all pages should extend from this
 */
abstract class CBC_Page_Init{

	/**
	 * Store object reference
	 * 
	 * @var CBC_Video_Post_Type
	 */
	protected $cpt;

	/**
	 * Constructor
	 * 
	 * @param CBC_Video_Post_Type $object
	 */
	public function __construct( CBC_Video_Post_Type $object ){
		$this->cpt = $object;
	}
}