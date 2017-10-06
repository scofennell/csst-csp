<?php

/**
 * A plugin for sending and handling content security policy.
 *
 * @package WordPress
 * @subpackage CSST_ConSecPol
 * @since CSST_ConSecPol 0.1
 * 
 * Plugin Name: CSST ConSecPol
 * Plugin URI: https://www.lexblog.com
 * Description: A plugin for sending and handling content security policy.
 * Author: Angelo Carosio & Scott Fennell
 * Version: 0.6.3
 * Author URI: http://www.lexblog.com
 * Network: True
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
	
// Peace out if you're trying to access this up front.
if( ! defined( 'ABSPATH' ) ) { exit; }

// Watch out for plugin naming collisions.
if( defined( 'CSST_CONSECPOL' ) ) { exit; }
if( isset( $csst_consecpol ) ) { exit; }

// A slug for our plugin.
define( 'CSST_CONSECPOL', 'csst_consecpol' );

// Establish a value for plugin version to bust file caches.
define( 'CSST_CONSECPOL_VERSION', '0.6.3' );

// A constant to define the paths to our plugin folders.
define( 'CSST_CONSECPOL_FILE', __FILE__ );
define( 'CSST_CONSECPOL_PATH', trailingslashit( plugin_dir_path( CSST_CONSECPOL_FILE ) ) );

// A constant to define the urls to our plugin folders.
define( 'CSST_CONSECPOL_URL', trailingslashit( plugin_dir_url( CSST_CONSECPOL_FILE ) ) );

// Our master plugin object, which will own instances of various classes in our plugin.
$csst_consecpol  = new stdClass();
$csst_consecpol -> bootstrap = CSST_CONSECPOL . '\Bootstrap';

// Register an autoloader.
require_once( CSST_CONSECPOL_PATH . 'autoload.php' );

// Execute the plugin code!
new $csst_consecpol -> bootstrap;

function get_csst_consecpol() {

	return $GLOBALS['csst_consecpol'];

}