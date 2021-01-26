<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Error Handle calss
*/
class MXDDP_Display_Error
{

	/**
	* Error notice
	*/
	public $mxddp_error_notice = '';

	public function __construct( $mxddp_error_notice )
	{

		$this->mxddp_error_notice = $mxddp_error_notice;

	}

	public function mxddp_show_error()
	{
		add_action( 'admin_notices', function() { ?>

			<div class="notice notice-error is-dismissible">

			    <p><?php echo $this->mxddp_error_notice; ?></p>
			    
			</div>
		    
		<?php } );
	}

}