<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// require Route-Registrar.php
require_once MXDDP_PLUGIN_ABS_PATH . 'includes/core/Route-Registrar.php';

/*
* Routes class
*/
class MXDDP_Route
{

	public function __construct()
	{
		// ...
	}
	
	public static function mxddp_get( ...$args )
	{

		return new MXDDP_Route_Registrar( ...$args );

	}
	
}