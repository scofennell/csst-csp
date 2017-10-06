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

	function rest_api_init() {

		$rest_version = $this -> meta -> get_rest_version();
		$rest_ep      = $this -> meta -> get_rest_ep();		

		register_rest_route(
			CSST_CONSECPOL . '/' . $rest_version,
			'/' . $rest_ep . '/',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'cb' ),
 			)
		);

	}

	function cb( \WP_REST_Request $request ) {

		$check_log_file_size = $this -> check_log_file_size();

		if( ! $check_log_file_size ) { return FALSE; }

		$body = $request -> get_body();

		$body = json_decode( $body, TRUE );
		$csp_report = $body['csp-report'];

		$blocked_uri  = $csp_report['blocked-uri'];
		$document_uri = $csp_report['document-uri'];

		$args = array(
			'blog_id'      => get_current_blog_id(),
			'blocked_uri'  => $blocked_uri,
			'document_uri' => $document_uri,
		);

		$record = new Record( $args );

		$out = $record -> get_log_entry();

		return $out;

	}

	function check_log_file_size() {

		$path = $this -> meta -> get_log_file_path();
		if( ! file_exists( $path ) ) { return TRUE; }

		$size = filesize( $path );

		$mb = 1000000;

		$max = 20 * $mb;

		if( $size > $max ) { return FALSE; }

		return TRUE;

	}

}