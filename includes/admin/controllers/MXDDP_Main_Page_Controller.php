<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXDDP_Main_Page_Controller extends MXDDP_Controller
{
	
	public function settings_menu_item_action()
	{

		$model_inst = new MXDDP_Main_Page_Model();

		$data['mx_name'] = 'test';

		return new MXDDP_View( 'settings-page', $data );

	}

}