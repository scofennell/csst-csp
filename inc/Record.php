<?php

/**
 * A class for adding a record to the log file.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */

namespace csst_consecpol;

class Record {

	function __construct( array $record ) {

		$this -> meta = get_csst_consecpol() -> meta;

		$this -> maybe_add_header_row();
		$this -> set_item( $record );
		$this -> add_log_entry();
	
	}

	/**
	 * Maybe add the header row to the file.
	 * 
	 * @return mixed Returns NULL if the file already exists, else a call to our add_row() method.
	 */
	function maybe_add_header_row() {

		$out = NULL;

		// Does the file exist?  If so, bail.
		$path        = $this -> meta -> get_log_file_path();
		$file_exists = file_exists( $path );
		if( $file_exists ) { return NULL; }

		// Prepare the header row.
		$array = array(
			'blog_id',
			'blocked_uri',
			'document_uri',
		);
		
		// Add the header to the file.
		$out = $this -> add_row( $array );
		
		return $out;

	}

	/**
	 * Store the CSP report.
	 * 
	 * @param array A CSP report.
	 */
	function set_item( $record ) {

		$this -> item = $record;

	}

	/**
	 * Get the CSP report.
	 * 
	 * @return array A CSP report.
	 */
	function get_item() {

		return $this -> item;

	}

	/**
	 * Add the CSP to the spreadsheet.
	 */
	function add_log_entry() {

		$item = $this -> get_item();

		$out = $this -> add_row( $item );

		return $out;

	}

	/**
	 * Add a row to the spreadsheet.
	 */
	function add_row( $array ) {

		global $wp_filesystem;

		// Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
		$mode = 'a';

		// Open the file.
		$path   = $this -> meta -> get_log_file_path();
		$handle = $wp_filesystem -> fopen( $path, $mode );

		// Add the row to the spreadsheet.
		$wp_filesystem -> fputcsv( $handle, $array );

		// Close the file.
		$wp_filesystem -> fclose( $handle );

		return TRUE;		

	}

}