<div class="mx-main-page-text-wrap">
	
	<h1><?php echo __( 'Dynamically Display Posts Settings Page', 'mxddp-domain' ); ?></h1>

	<form id="mxddp_form_update" class="mx-settings mx-settings-form" method="post" action="">

		<div class="mx-block_wrap">

			<h2>Default script</h2>
			<textarea name="mxddp_some_string" id="mxddp_some_string"><?php echo $data['mx_name']; ?></textarea>

			<p class="mx-submit_button_wrap">
				<input type="hidden" id="mxddp_wpnonce" name="mxddp_wpnonce" value="<?php echo wp_create_nonce( 'mxddp_nonce_request' ) ;?>" />
				<input class="button-primary" type="submit" name="mxddp_submit" value="Save" />
			</p>

		</div>

		<div class="mx-block_wrap">
			
		</div>

	</form>

	<div class="mx-ddp_shortcodes">
		<h3><?php echo __( 'Display posts on any page.', 'mxddp-domain' ); ?></h3>
		<p>
			You should use the shortcode below to pase it on the page. 
		</p>
		<p style="font-weight: bold;">
			[mx_ddp_post_template post_type="news_sport" term_ids="18,19"]
		</p>
		<p>
			Where the <b>post_type</b> is a post type that you want to get and <b>term_ids</b> is list of id's of categories you want to get (You should place list of category ID's separated by comma (,)).
		</p>
	</div>

</div>