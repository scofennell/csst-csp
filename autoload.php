<?php

/**
 * Register an spl autoloader per PSR4.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 */
 
spl_autoload_register( function( $class ) {

	// If the class does not pertain to our plugin, bail. 
	$prefix        = CSST_CONSECPOL . '\\';
	$len           = strlen( $prefix );
	$strncmp       = strncmp( $prefix, $class, $len );

	if( $strncmp !== 0 ) { return; }

	// All of our classes together in this folder.
	$inc = CSST_CONSECPOL_PATH . 'inc/';

	// Convert the class name to the file path for that class name.
	$relative_class = substr( $class, $len );
	$relative_class = str_replace( '\\', '', $relative_class );
	$file           = $inc . $relative_class . '.php';
	
	if( ! file_exists( $file ) ) {
		return FALSE;
	}

	require_once( $file );

	return TRUE;

});