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

	private function set_is_update() {

		$fv  = $this -> get_file_version();
		$dbv = $this -> get_database_version();

		// returns -1 if the first version is lower than the second, 0 if they are equal, and 1 if the second is lower.
		$compare = version_compare( $fv, $dbv );

		if( $compare === 1 ) {
			$out = TRUE;
			$this -> update_database_version( $fv );
		} else {
			$out = FALSE;
		}

		$this -> is_update = $out;

	}

	public function get_is_update() {

		if( ! isset( $this -> is_update ) ) {
			$this -> set_is_update();
		}

		return $this -> is_update;

	}

	private function get_file_version() {

		return CSST_CONSECPOL_VERSION;

	}

	private function get_database_version() {

		$out = get_option( $this -> get_slug() );

		return $out;

	}

	private function update_database_version( $new_version ) {

		$out = update_option( $this -> get_slug(), $new_version );

		return $out;

	}

}