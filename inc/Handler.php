<?php

/**
 * A class for handling the content security header.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */

namespace csst_consecpol;

class Handler {

	function __construct() {

		$this -> meta = get_csst_consecpol() -> meta;

		add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );

	}

	/**
	 * Register our route.
	 * 
	 * @return mixed A call to register_rest_route().
	 */
	function rest_api_init() {

		// Is the log file still an okay size?
		$check_log_file_size = $this -> check_log_file_size();
		if( ! $check_log_file_size ) { return FALSE; }

		// Grab our args.
		$rest_version = $this -> meta -> get_rest_version();
		$rest_ep      = $this -> meta -> get_rest_ep();		

		// Make the route and declare a callback function for the route.
		$out = register_rest_route(
			CSST_CONSECPOL . '/' . $rest_version,
			'/' . $rest_ep . '/',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'cb' ),
 			)
		);

		return $out;

	}

	/**
	 * A function to handle CSP reports.
	 * 
	 * @param  \WP_REST_Request $request A WP API request.
	 * @return Record An instance of our Record class.
	 */
	function cb( \WP_REST_Request $request ) {

		// Grab the report as an array.
		$body = $request -> get_body();
		$body = json_decode( $body, TRUE );

		// Grab the parts of the report we care about.
		$csp_report   = $body['csp-report'];
		$blocked_uri  = $csp_report['blocked-uri'];
		$document_uri = $csp_report['document-uri'];

		// Bundle them into a format expected by the rest of our plugin.
		$args = array(
			'blog_id'      => get_current_blog_id(),
			'blocked_uri'  => $blocked_uri,
			'document_uri' => $document_uri,
		);

		// Pass them to our Record class, which will log them.
		$out = new Record( $args );

		return $out;

	}

	/**
	 * Check to make sure the log file is not too big.
	 * 
	 * @return boolean Returns FALSE if the log is too big, else TRUE.
	 */
	function check_log_file_size() {

		// If the file does not yet exist, it can't be too big.
		$path = $this -> meta -> get_log_file_path();
		if( ! file_exists( $path ) ) { return TRUE; }

		// The size of the file in bits.
		$size = filesize( $path );

		// Let's do a 20mb max.
		$mb  = 1000000;
		$max = 20 * $mb;

		if( $size > $max ) { return FALSE; }

		return TRUE;

	}

}