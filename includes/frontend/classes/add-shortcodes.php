<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MX_DDP_Add_Shortcodes
{


	/*
	* Registration of styles and scripts
	*/
	public static function mx_add_shortcodes()
	{

		// ddp's form
		add_shortcode( 'mx_ddp_post_template', array( 'MX_DDP_Add_Shortcodes', 'mx_ddp_add_ddp_template' ) );

		// search page
		add_shortcode( 'mx_ddp_post_template_sp', array( 'MX_DDP_Add_Shortcodes', 'mx_ddp_add_ddp_template_sp' ) );
		
	}

		// form
		public static function mx_ddp_add_ddp_template_sp( $atts )
		{
			ob_start();

			// post type
			$post_type = 'post';

			if( isset( $atts['post_type'] ) ) {

				$post_type = $atts['post_type'];

			}

			// taxonomy
			$term_ids = NULL;

			if( is_category() ) {

				$queried_object = get_queried_object();

				$term_ids = [$queried_object->term_id];

			}

			if( is_tax() ) {

				$queried_object = get_queried_object();

				$term_ids = [$queried_object->term_id];

			}

			if( isset( $atts['term_ids'] ) ) {

				$ids = preg_replace( '/[^0-9]+/', ',', $atts['term_ids'] );

				$term_ids = explode( ',', $ids );

			}

			// posts per page
			$posts_per_page 	= 10;

			if( isset( $atts['posts_per_page'] ) ) {

				$posts_per_page = intval( $atts['posts_per_page'] );

			}

			// pagination (none, numbers, load_more)
			$pagination 		= 'numbers';

			if( isset( $atts['pagination'] ) ) {

				$pagination = sanitize_text_field( $atts['pagination'] );

			}

			// default image
			$default_image_url 	= 'none';

			if( isset( $atts['default_image_url'] ) ) {

				$default_image_url = esc_url_raw( $atts['default_image_url'] );

			}

			// search bar (on, off)
			$search_bar 		= 'on';

			if( isset( $atts['search_bar'] ) ) {

				$search_bar = sanitize_text_field( $atts['search_bar'] );

			}

			?>			

			<script>

				<?php if( isset( $_GET['s'] ) ) : ?>

					window.mx_search_musin = "<?php echo $_GET['s']; ?>";

				<?php endif; ?>

				window.mx_ddp_post_type 		= '<?php echo $post_type; ?>';

				window.mx_ddp_posts_per_page 	= <?php echo $posts_per_page; ?>;

				window.mx_ddp_pagination 		= '<?php echo $pagination; ?>';

				window.mx_ddp_default_image_url = '<?php echo $default_image_url; ?>';

				window.mx_ddp_search_bar 		= '<?php echo $search_bar; ?>';

				<?php if( $term_ids !== NULL ) : ?>
			
					window.mx_ddp_tax_query = [

						<?php foreach ( $term_ids as $key => $value ) : ?>

							'<?php echo $value; ?>',

						<?php endforeach; ?>
					];

				<?php else : ?>

					window.mx_ddp_tax_query = [];

				<?php endif; ?>

			</script>					
		
			<div id="mx_ddp_container_sp">

				<!-- search -->
				<!-- <mx_ddp_search_sp
					:pageloading="pageLoading"
					@mx-search-request="searchQuestion"
					v-if="search_bar === 'on'"
				></mx_ddp_search_sp> -->

				<!-- list of items -->
				<mx_ddp_list_items_sp
					:getddpitems="ddpItems"
					:parsejsonerror="parseJSONerror"
					:pageloading="pageLoading"
					:load_img="loadImg"
					:no_items="noItemsDisplay"
					:post_type="post_type"
					:default_photo="default_photo"
					:query="query"
				></mx_ddp_list_items_sp>
				

				<mx_ddp_load_more_button_sp
					:pageloading="pageLoading"
					v-if="!parseJSONerror && ddpPaginagion === 'load_more'"
					:ddpcount="ddpCount"
					:ddpperpage="ddpPerPage"
					:ddpcurrentpage="ddpCurrentPage"
					@load_more="loadMoreItems"
					:load_img="loadImg"
					:load_more_progress="load_more_progress"
				></mx_ddp_load_more_button_sp>

			</div>

			<?php return ob_get_clean();
		}









		// form
		public static function mx_ddp_add_ddp_template( $atts )
		{
			ob_start();

			// post type
			$post_type = 'post';

			if( isset( $atts['post_type'] ) ) {

				$post_type = $atts['post_type'];

			}

			// taxonomy
			$term_ids = NULL;

			if( is_category() ) {

				$queried_object = get_queried_object();

				$term_ids = [$queried_object->term_id];

			}

			if( is_tax() ) {

				$queried_object = get_queried_object();

				$term_ids = [$queried_object->term_id];

			}

			if( isset( $atts['term_ids'] ) ) {

				$ids = preg_replace( '/[^0-9]+/', ',', $atts['term_ids'] );

				$term_ids = explode( ',', $ids );

			}

			// posts per page
			$posts_per_page 	= 10;

			if( isset( $atts['posts_per_page'] ) ) {

				$posts_per_page = intval( $atts['posts_per_page'] );

			}

			// pagination (none, numbers, load_more)
			$pagination 		= 'numbers';

			if( isset( $atts['pagination'] ) ) {

				$pagination = sanitize_text_field( $atts['pagination'] );

			}

			// default image
			$default_image_url 	= 'none';

			if( isset( $atts['default_image_url'] ) ) {

				$default_image_url = esc_url_raw( $atts['default_image_url'] );

			}

			// search bar (on, off)
			$search_bar 		= 'on';

			if( isset( $atts['search_bar'] ) ) {

				$search_bar = sanitize_text_field( $atts['search_bar'] );

			}

			?>			

			<script>

				window.mx_ddp_post_type 		= '<?php echo $post_type; ?>';

				window.mx_ddp_posts_per_page 	= <?php echo $posts_per_page; ?>;

				window.mx_ddp_pagination 		= '<?php echo $pagination; ?>';

				window.mx_ddp_default_image_url = '<?php echo $default_image_url; ?>';

				window.mx_ddp_search_bar 		= '<?php echo $search_bar; ?>';

				<?php if( $term_ids !== NULL ) : ?>
			
					window.mx_ddp_tax_query = [

						<?php foreach ( $term_ids as $key => $value ) : ?>

							'<?php echo $value; ?>',

						<?php endforeach; ?>
					];

				<?php else : ?>

					window.mx_ddp_tax_query = [];

				<?php endif; ?>

			</script>					
		
			<div id="mx_ddp_container">

				<!-- search -->
				<mx_ddp_search
					:pageloading="pageLoading"
					@mx-search-request="searchQuestion"
					v-if="search_bar === 'on'"
				></mx_ddp_search>

				<!-- list of items -->
				<mx_ddp_list_items
					:getddpitems="ddpItems"
					:parsejsonerror="parseJSONerror"
					:pageloading="pageLoading"
					:load_img="loadImg"
					:no_items="noItemsDisplay"
					:post_type="post_type"
					:default_photo="default_photo"
				></mx_ddp_list_items>

				<!-- pagination -->
				<mx_ddp_pagination
					:pageloading="pageLoading"
					v-if="!parseJSONerror && ddpPaginagion === 'numbers'"
					:ddpcount="ddpCount"
					:ddpperpage="ddpPerPage"
					:ddpcurrentpage="ddpCurrentPage"					
					@get-ddp-page="changeddpPage"
				></mx_ddp_pagination>

				<mx_ddp_load_more_button
					:pageloading="pageLoading"
					v-if="!parseJSONerror && ddpPaginagion === 'load_more'"
					:ddpcount="ddpCount"
					:ddpperpage="ddpPerPage"
					:ddpcurrentpage="ddpCurrentPage"
					@load_more="loadMoreItems"
					:load_img="loadImg"
					:load_more_progress="load_more_progress"
				></mx_ddp_load_more_button>

			</div>

			<?php return ob_get_clean();
		}

}

MX_DDP_Add_Shortcodes::mx_add_shortcodes();

?>