<div class="mx-main-page-text-wrap">
	
	<h1><?php echo __( 'Dynamically Display Posts Settings Page', 'mxddp-domain' ); ?></h1>

	<!-- <form id="mxddp_form_update" class="mx-settings mx-settings-form" method="post" action="">

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

	</form> -->

	<div class="mx-ddp_shortcodes">
		<h3><?php echo __( 'Display posts on any page.', 'mxddp-domain' ); ?></h3>
		<p>
			You should use the shortcode below to place it on the page. 
		</p>
		<p style="font-weight: bold;">
			[mx_ddp_post_template post_type="news_sport" term_ids="18,19" posts_per_page="5" pagination="none" default_image_url="<?php echo MXDDP_PLUGIN_URL . 'includes/frontend/assets/img/no-photo.jpg'; ?>" search_bar="on"]
		</p>

		<h3>Where the properties are:</h3>

		<ul>
			<li>
				<b>post_type</b> - The post type to display (default value = 'post')
			</li>
			<li>
				<b>term_ids</b> - The exists taxonomy IDs of the current (post_type prop.) post type. You should place list of category IDs separated by comma (,). (default value is not specified)
			</li>
			<li>
				<b>posts_per_page</b> - Number of posts on each page (default value = '10')
			</li>
			<li>
				<b>pagination</b> - Type of navigation. Defined values: none, numbers, load_more (default value = 'numbers')
			</li>
			<li>
				<b>default_image_url</b> - If a post doesn't have any thumbnail, you can set up the default image (default value = '<?php echo MXDDP_PLUGIN_URL . 'includes/frontend/assets/img/no-photo.jpg'; ?>')
			</li>
			<li>
				<b>search_bar</b> - Display search bar. Defined values: on, off (default value = 'on')
			</li>
		</ul>
	</div>

</div>