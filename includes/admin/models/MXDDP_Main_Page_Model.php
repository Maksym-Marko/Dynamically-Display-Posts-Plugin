<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Main page Model
*/
class MXDDP_Main_Page_Model extends MXDDP_Model
{

	/*
	* Observe function
	*/
	public static function mxddp_wp_ajax()
	{

		// add_action( 'wp_ajax_mxddp_update', [ 'MXDDP_Main_Page_Model', 'prepare_update_database_column' ], 10, 1 );

	}

	/*
	* Prepare for data updates
	*/
	public static function prepare_update_database_column()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxddp_nonce_request' ) ){

			// var_dump( $_POST );	

		}

		wp_die();

	}		
	
}