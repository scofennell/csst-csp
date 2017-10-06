<?php

/**
 * A class for adding headers to the http response.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */

namespace csst_consecpol;

class Headers {

	function __construct() {

		$this -> meta = get_csst_consecpol() -> meta;

		add_action( 'send_headers', array( $this, 'send_headers' ) );

	}

	function send_headers() {

		$rest_version = $this -> meta -> get_rest_version();
		$rest_ep      = $this -> meta -> get_rest_ep();		
		$rest_url     = get_rest_url( NULL, CSST_CONSECPOL . '/' . $rest_version . '/' . $rest_ep );

		header( "Content-Security-Policy-Report-Only: default-src https: 'unsafe-inline' 'unsafe-eval'; report-uri $rest_url" );

	}

}