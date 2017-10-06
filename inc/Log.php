<?php

/**
 * A class for making the log file.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */

namespace csst_consecpol;

class Log {

	function __construct() {

		$this -> meta = get_csst_consecpol() -> meta;

		add_action( 'admin_init', array( $this, 'make_directory' ) );
	
	}

	function make_directory() {

		$out = NULL;

		$update = new Update;
		if( ! $update -> get_is_update() ) { return FALSE; }

		$log_dir_path = $this -> meta -> get_log_dir_path();

		$file_exists = file_exists( $log_dir_path );

		if( ! $file_exists ) {
			$out = mkdir( $log_dir_path, 0775, TRUE );
		}

		return $out;

	}

}