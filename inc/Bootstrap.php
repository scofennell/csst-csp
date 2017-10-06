<?php

/**
 * A class for managing plugin dependencies and loading the plugin.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */
namespace csst_consecpol;

class Bootstrap {

	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'create' ), 100 );

	}

	/**
	 * Instantiate and store a bunch of our plugin classes.
	 */
	function create() {

		$csst_consecpol = get_csst_consecpol();

		$csst_consecpol -> meta    = new Meta;
		$csst_consecpol -> log     = new Log;
		$csst_consecpol -> headers = new Headers;
		$csst_consecpol -> handler = new Handler;

		return $csst_consecpol;

	}

}