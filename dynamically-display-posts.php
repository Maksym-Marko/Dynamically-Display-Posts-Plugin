<?php
/*
Plugin Name: Dynamically Display Posts
Plugin URI: https://github.com/Maxim-us/wp-plugin-skeleton
Description: This plugin allows you to display a list of posts on your website on any page.
Author: Marko Maksym
Version: 1.0
Author URI: https://markomaksym.com.ua/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Unique string - MXDDP
*/

/*
* Define MXDDP_PLUGIN_PATH
*
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\dynamically-display-posts\dynamically-display-posts.php
*/
if ( ! defined( 'MXDDP_PLUGIN_PATH' ) ) {

	define( 'MXDDP_PLUGIN_PATH', __FILE__ );

}

/*
* Define MXDDP_PLUGIN_URL
*
* Return http://my-domain.com/wp-content/plugins/dynamically-display-posts/
*/
if ( ! defined( 'MXDDP_PLUGIN_URL' ) ) {

	define( 'MXDDP_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

}

/*
* Define MXDDP_PLUGN_BASE_NAME
*
* 	Return dynamically-display-posts/dynamically-display-posts.php
*/
if ( ! defined( 'MXDDP_PLUGN_BASE_NAME' ) ) {

	define( 'MXDDP_PLUGN_BASE_NAME', plugin_basename( __FILE__ ) );

}

/*
* Define MXDDP_TABLE_SLUG
*/
if ( ! defined( 'MXDDP_TABLE_SLUG' ) ) {

	define( 'MXDDP_TABLE_SLUG', 'mxddp_mx_table' );

}

/*
* Define MXDDP_PLUGIN_ABS_PATH
* 
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\dynamically-display-posts/
*/
if ( ! defined( 'MXDDP_PLUGIN_ABS_PATH' ) ) {

	define( 'MXDDP_PLUGIN_ABS_PATH', dirname( MXDDP_PLUGIN_PATH ) . '/' );

}

/*
* Define MXDDP_PLUGIN_VERSION
*/
if ( ! defined( 'MXDDP_PLUGIN_VERSION' ) ) {

	// version
	define( 'MXDDP_PLUGIN_VERSION', time() ); // Must be replaced before production on for example '1.0'

}

/*
* Define MXDDP_MAIN_MENU_SLUG
*/
if ( ! defined( 'MXDDP_MAIN_MENU_SLUG' ) ) {

	// version
	define( 'MXDDP_MAIN_MENU_SLUG', 'mxddp-dynamically-display-posts-menu' );

}

/**
 * activation|deactivation
 */
require_once plugin_dir_path( __FILE__ ) . 'install.php';

/*
* Registration hooks
*/
// Activation
register_activation_hook( __FILE__, [ 'MXDDP_Basis_Plugin_Class', 'activate' ] );

// Deactivation
register_deactivation_hook( __FILE__, [ 'MXDDP_Basis_Plugin_Class', 'deactivate' ] );


/*
* Include the main MXDDPDynamicallyDisplayPosts class
*/
if ( ! class_exists( 'MXDDPDynamicallyDisplayPosts' ) ) {

	require_once plugin_dir_path( __FILE__ ) . 'includes/final-class.php';

	/*
	* Translate plugin
	*/
	add_action( 'plugins_loaded', 'mxddp_translate' );

	function mxddp_translate()
	{

		load_plugin_textdomain( 'mxddp-domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

}