<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Require class for admin panel
*/
function mxddp_require_class_file_admin( $file ) {

	require_once MXDDP_PLUGIN_ABS_PATH . 'includes/admin/classes/' . $file;

}


/*
* Require class for frontend panel
*/
function mxddp_require_class_file_frontend( $file ) {

	require_once MXDDP_PLUGIN_ABS_PATH . 'includes/frontend/classes/' . $file;

}

/*
* Require a Model
*/
function mxddp_use_model( $model ) {

	require_once MXDDP_PLUGIN_ABS_PATH . 'includes/admin/models/' . $model . '.php';

}

function mxddp_get_tag_link( $tag_id ) {

	return get_tag_link( $tag_id ); 

}

/*
* Debugging
*/
function mxddp_debug_to_file( $content ) {

	$content = mxddp_content_to_string( $content );

	$path = MXDDP_PLUGIN_ABS_PATH . 'mx-debug' ;

	if( ! file_exists( $path ) ) :

		mkdir( $path, 0777, true );

		file_put_contents( $path . '/mx-debug.txt', $content );

	else :

		file_put_contents( $path . '/mx-debug.txt', $content );

	endif;

}
	// pretty debug text to the file
	function mxddp_content_to_string( $content ) {

		ob_start();

		var_dump( $content );

		return ob_get_clean();

	}