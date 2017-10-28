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

	/**
	 * Make our log directory.
	 */
	function make_directory() {

		global $wp_filesystem;

		$out = NULL;

		// Is this a plugin update?  If not, don't bother.
		$update = new Update;
		if( ! $update -> get_is_update() ) { return FALSE; }

		// Does the file already exist?  If so, don't bother.
		$log_dir_path = $this -> meta -> get_log_dir_path();
		$file_exists = file_exists( $log_dir_path );
		if( $file_exists ) { return FALSE; }

		// We made it!  Make the directory.
		$out = $wp_filesystem -> mkdir( $log_dir_path, 0775, TRUE );
		
		return $out;

	}

}