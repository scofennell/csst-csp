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
		$this -> set_log_entry();
	
	}

	function set_item( $record ) {

		$this -> item = $record;

	}

	function get_item() {

		return $this -> item;

	}

	function set_log_entry() {

		$item = $this -> get_item();

		$out = $this -> add_row( $item );

		return $out;

	}

	function maybe_add_header_row() {

		$out = NULL;

		$path = $this -> meta -> get_log_file_path();

		$file_exists = file_exists( $path );
		if( ! $file_exists ) {
		
			$array = array(
				'blog_id',
				'blocked_uri',
				'document_uri',
			);
		
			$out = $this -> add_row( $array );
		
		}

		return $out;

	}

	function add_row( $array ) {

		// Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
		$mode = 'a';

		$path = $this -> meta -> get_log_file_path();

		$handle = fopen( $path, $mode );

		// $item is an array of string values here.
		fputcsv( $handle, $array );

		fclose( $handle );

		return TRUE;		

	}

	function get_log_entry() {

		return $this -> log_entry;

	}

}