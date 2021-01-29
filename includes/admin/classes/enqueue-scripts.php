<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXDDP_Enqueue_Scripts
{

	/*
	* MXDDP_Enqueue_Scripts
	*/
	public function __construct()
	{

	}

	/*
	* Registration of styles and scripts
	*/
	public static function mxddp_register()
	{

		// register scripts and styles
		add_action( 'admin_enqueue_scripts', [ 'MXDDP_Enqueue_Scripts', 'mxddp_enqueue' ] );

	}

		public static function mxddp_enqueue()
		{

			wp_enqueue_style( 'mxddp_font_awesome', MXDDP_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );

			wp_enqueue_style( 'mxddp_admin_style', MXDDP_PLUGIN_URL . 'includes/admin/assets/css/style.css', [ 'mxddp_font_awesome' ], MXDDP_PLUGIN_VERSION, 'all' );

			// wp_enqueue_script( 'mxddp_admin_script', MXDDP_PLUGIN_URL . 'includes/admin/assets/js/script.js', [ 'jquery' ], MXDDP_PLUGIN_VERSION, false );

			// wp_localize_script( 'mxddp_admin_script', 'mxddp_admin_localize', [

			// 	'ajaxurl' 			=> admin_url( 'admin-ajax.php' )

			// ] );

		}

}