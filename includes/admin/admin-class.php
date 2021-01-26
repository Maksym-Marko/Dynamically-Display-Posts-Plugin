<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXDDP_Admin_Main
{

	// list of model names used in the plugin
	public $models_collection = [
		'MXDDP_Main_Page_Model'
	];

	/*
	* MXDDP_Admin_Main constructor
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
		mxddp_require_class_file_admin( 'enqueue-scripts.php' );

		MXDDP_Enqueue_Scripts::mxddp_register();

		// mx metaboxes class
		// mxddp_require_class_file_admin( 'metabox.php' );

		// mxddp_require_class_file_admin( 'metabox-image-upload.php' );

		// MXDDP_Metaboxes_Image_Upload_Class::register_scrips();
		
		// CPT class
		// mxddp_require_class_file_admin( 'cpt.php' );

		// MXDDPCPTclass::createCPT();

	}

	/*
	* Models Connection
	*/
	public function mxddp_models_collection()
	{

		// require model file
		foreach ( $this->models_collection as $model ) {
			
			mxddp_use_model( $model );

		}		

	}

	/**
	* registration ajax actions
	*/
	public function mxddp_registration_ajax_actions()
	{

		// ajax requests to main page
		MXDDP_Main_Page_Model::mxddp_wp_ajax();

	}

	/*
	* Routes collection
	*/
	public function mxddp_routes_collection()
	{

		// sub settings menu item
		MXDDP_Route::mxddp_get( 'MXDDP_Main_Page_Controller', 'settings_menu_item_action', 'NULL', [
			'menu_title' => 'DDP Settings',
			'page_title' => 'DDP Settings'
		], 'mx_ddp_settings', true );

	}

}

// Initialize
$initialize_admin_class = new MXDDP_Admin_Main();

// include classes
$initialize_admin_class->mxddp_additional_classes();

// include models
$initialize_admin_class->mxddp_models_collection();

// ajax requests
$initialize_admin_class->mxddp_registration_ajax_actions();

// include controllers
$initialize_admin_class->mxddp_routes_collection();