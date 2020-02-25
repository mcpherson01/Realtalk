<?php

/**
 * Interface WHM_Resolver_Interface should be implemented on the resolver class.
 *
 * For example, when new class is written to resolve conflict with
 * some third-party plugin, this interface should be implemented.
 */
interface WHM_Resolver_Interface {

	/**
	 * Used to init resolver.
	 *
	 * Should invoke filters, hooks, etc.
	 *
	 * @return mixed
	 */
	public function init();
}