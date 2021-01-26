<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXDDP_FrontEnd_Main
{

	/*
	* MXDDP_FrontEnd_Main constructor
	*/
	public function __construct()
	{

	}

	/*
	* Additional classes
	*/
	public function mxddp_additional_classes()
	{

		// enqueue_scripts class
		mxddp_require_class_file_frontend( 'enqueue-scripts.php' );

		MXDDP_Enqueue_Scripts_Frontend::mxddp_register();

		// DDP database talk
		mxddp_require_class_file_frontend( 'database-talk.php' );

		MX_DDP_Database_Talk::mxffi_db_ajax();

		// shortcodes
		mxddp_require_class_file_frontend( 'add-shortcodes.php' );

		MX_DDP_Add_Shortcodes::mx_add_shortcodes();

	}

}

// Initialize
$initialize_admin_class = new MXDDP_FrontEnd_Main();

// include classes
$initialize_admin_class->mxddp_additional_classes();