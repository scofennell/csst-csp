<?php

/**
 * A singleton for getting meta data about this plugin.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */

namespace csst_consecpol;

class Meta {

	function get_rest_version() {
	
		return 'v1';
	
	}

	function get_rest_ep() {
	
		return 'incidents';
	
	}

	function get_log_dir_path() {
		
		$wp_content_path = trailingslashit( WP_CONTENT_DIR );

		$out = trailingslashit( $wp_content_path . CSST_CONSECPOL );

		return $out;

	}

	function get_log_file_name() {

		return 'log.csv';

	}

	function get_log_file_path() {
		
		$log_dir_path = $this -> get_log_dir_path();

		$log_file_name = $this -> get_log_file_name();

		$out = $log_dir_path . $log_file_name;

		return $out;

	}

}