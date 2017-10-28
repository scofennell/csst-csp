<?php

/**
 * Register our plugin update routine.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */

namespace csst_consecpol;

class Update {

	public function __construct() {}

	private function get_slug() {

		$out = sanitize_key( __CLASS__ );

		return $out;

	}

	/**
	 * Is this the first page load on a new version number?
	 */
	private function set_is_update() {

		// Grab the two sources of what the version number is.
		$fv  = $this -> get_file_version();
		$dbv = $this -> get_database_version();

		// returns -1 if the first version is lower than the second, 0 if they are equal, and 1 if the second is lower.
		$compare = version_compare( $fv, $dbv );

		// If this is an update, record that.
		if( $compare === 1 ) {

			$out = TRUE;
			$this -> update_database_version( $fv );

		} else {

			$out = FALSE;

		}

		$this -> is_update = $out;

	}

	/**
	 * Return whether or not this is the first page load on a new plugin version number.
	 * 
	 * @return boolean Returns TRUE if this is the first page load on a new version number, else FALSE.
	 */
	public function get_is_update() {

		if( ! isset( $this -> is_update ) ) {
			$this -> set_is_update();
		}

		return $this -> is_update;

	}

	/**
	 * Get the file version number.
	 * 
	 * @return string The version number from the main plugin file.
	 */
	private function get_file_version() {

		return CSST_CONSECPOL_VERSION;

	}

	/**
	 * Get the db version number.
	 * 
	 * @return string The version number from the database.
	 */
	private function get_database_version() {

		$out = get_option( $this -> get_slug() );

		return $out;

	}

	/**
	 * Update the db version number.
	 * 
	 * @return mixed A call to update_option().
	 */
	private function update_database_version( $new_version ) {

		$out = update_option( $this -> get_slug(), $new_version );

		return $out;

	}

}