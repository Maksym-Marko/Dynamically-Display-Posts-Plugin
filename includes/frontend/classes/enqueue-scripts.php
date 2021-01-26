<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXDDP_Enqueue_Scripts_Frontend
{

	/*
	* MXDDP_Enqueue_Scripts_Frontend
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
		add_action( 'wp_enqueue_scripts', [ 'MXDDP_Enqueue_Scripts_Frontend', 'mxddp_enqueue' ] );

	}

		public static function mxddp_enqueue()
		{

			wp_enqueue_style( 'mxddp_font_awesome', MXDDP_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );
			
			wp_enqueue_style( 'mxddp_style', MXDDP_PLUGIN_URL . 'includes/frontend/assets/css/style.css', [ 'mxddp_font_awesome' ], MXDDP_PLUGIN_VERSION, 'all' );

			// include Vue.js
				// dev version
				wp_enqueue_script( 'mx_ddp_vue_js', MXDDP_PLUGIN_URL . 'includes/frontend/assets/add/vue_js/vue.dev.js', [], MXDDP_PLUGIN_VERSION, true );

				// production version
				//wp_enqueue_script( 'mx_ddp_vue_js', MXDDP_PLUGIN_URL . 'includes/frontend/assets/add/vue_js/vue.production.js', array(), MXDDP_PLUGIN_VERSION, true );
			
			wp_enqueue_script( 'mxddp_script', MXDDP_PLUGIN_URL . 'includes/frontend/assets/js/script.js', ['mx_ddp_vue_js', 'jquery' ], MXDDP_PLUGIN_VERSION, true );


			wp_localize_script( 'mxddp_script', 'mx_ddpdata_obj_front', array(

				'nonce' => wp_create_nonce( 'mx_ddpdata_nonce_request_front' ),

				'ajax_url' => admin_url( 'admin-ajax.php' ),

				'loading_img' => MXDDP_PLUGIN_URL . 'includes/frontend/assets/img/faq_sending.gif',

				'no_phot' => MXDDP_PLUGIN_URL . 'includes/frontend/assets/img/no-photo.jpg',

				'texts'	=> array(
					'error_getting' 	=> __( 'Error getting FAQ from database!', 'mx_ddp-domain' ),
					'no_questions'		=> __( 'There are no questions yet.', 'mx_ddp-domain' ),
					'nothing_found'		=> __( 'Nothing found!', 'mx_ddp-domain' )					
				)

			) );

		
		}

}