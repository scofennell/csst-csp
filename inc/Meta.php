<?php

/**
 * A class for getting meta data about this plugin.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */

namespace csst_consecpol;

class Meta {

	/**
	 * Get the version number for our WP API endpoint.
	 * 
	 * @see https://developer.wordpress.org/reference/functions/register_rest_route/ .
	 * @return string The version number for our WP API endpoint.
	 */
	function get_rest_version() {
	
		return 'v1';
	
	}

	/**
	 * Get the slug name for our WP API endpoint.
	 * 
	 * @see https://developer.wordpress.org/reference/functions/register_rest_route/ .
	 * @return string The slug name for our WP API endpoint.
	 */
	function get_rest_ep() {
	
		return 'incidents';
	
	}

	/**
	 * Get the path to the log folder.
	 * 
	 * @return string The path to the log folder.
	 */
	function get_log_dir_path() {
		
		$wp_content_path = trailingslashit( WP_CONTENT_DIR );

		$out = trailingslashit( $wp_content_path . CSST_CONSECPOL );

		return $out;

	}

	/**
	 * Get the name of the log file.
	 * 
	 * @return string The name of the log file.
	 */
	function get_log_file_name() {

		return 'log.csv';

	}

	/**
	 * Get the path to the log file.
	 * 
	 * @return string The path to the log file.
	 */
	function get_log_file_path() {
		
		$log_dir_path = $this -> get_log_dir_path();

		$log_file_name = $this -> get_log_file_name();

		$out = $log_dir_path . $log_file_name;

		return $out;

	}

}