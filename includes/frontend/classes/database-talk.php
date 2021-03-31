<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MX_DDP_Database_Talk
{

	/*
	* Search page
	*/
	public static function mxffi_db_ajax_sp()
	{

		// get count of ddp items
		add_action( 'wp_ajax_mx_get_count_ddp_items_sp', array( 'MX_DDP_Database_Talk', 'mx_get_count_ddp_items_sp' ) );

			add_action( 'wp_ajax_nopriv_mx_get_count_ddp_items_sp', array( 'MX_DDP_Database_Talk', 'mx_get_count_ddp_items_sp' ) );

		// get ddp items
		add_action( 'wp_ajax_mx_get_ddp_items_sp', array( 'MX_DDP_Database_Talk', 'mx_get_ddp_items_sp' ) );

			add_action( 'wp_ajax_nopriv_mx_get_ddp_items_sp', array( 'MX_DDP_Database_Talk', 'mx_get_ddp_items_sp' ) );

		// load more items
		add_action( 'wp_ajax_mx_ddp_load_more_items_sp', array( 'MX_DDP_Database_Talk', 'mx_ddp_load_more_items_sp' ) );

			add_action( 'wp_ajax_nopriv_mx_ddp_load_more_items_sp', array( 'MX_DDP_Database_Talk', 'mx_ddp_load_more_items_sp' ) );

	}

		// get count of ddp items
		public static function mx_get_count_ddp_items_sp()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mx_ddpdata_nonce_request_front' ) ) {

				$post_type = 'post';

				if( isset( $_POST['post_type'] ) ) {

					$post_type = sanitize_text_field( $_POST['post_type'] );

				}	

				$query = sanitize_text_field( $_POST['query'] );

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$term_relationships_table = $wpdb->prefix . 'term_relationships';

				$sql_str = "SELECT COUNT(ID)
					FROM $posts_table
					WHERE post_type IN( 'post', 'page' )
						AND post_status = 'publish'
						AND ( post_title LIKE '%$query%'
							OR post_content LIKE '%$query%' )
				";

				if( isset( $_POST["tax_query"] ) ) {

					$tax_ids = implode( ',', $_POST['tax_query'] );

					$tax_ids = sanitize_text_field( $tax_ids );

					$sql_str = "SELECT COUNT(ID)				
						FROM $posts_table
						INNER JOIN $term_relationships_table ON $posts_table.ID = $term_relationships_table.object_id
						WHERE $term_relationships_table.term_taxonomy_id IN( $tax_ids )
							AND $posts_table.post_type IN( 'post', 'page' )
							AND $posts_table.post_status = 'publish'
							AND ( $posts_table.post_title LIKE '%$query%'
								OR $posts_table.post_content LIKE '%$query%' )
					";

				}

				$ddp_coung = $wpdb->get_var( $sql_str );

				echo $ddp_coung;

			}

			wp_die();

		}

		// get ddp item
		public static function mx_get_ddp_items_sp()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mx_ddpdata_nonce_request_front' ) ) {	

				$post_type = 'post';

				if( isset( $_POST['post_type'] ) ) {

					$post_type = sanitize_text_field( $_POST['post_type'] );

				}		

				$query = sanitize_text_field( $_POST['query'] );

				$current_page = sanitize_text_field( $_POST['current_page'] );

				$current_page = intval( $current_page );

				$ddp_per_page = sanitize_text_field( $_POST['ddp_per_page'] );

				$current_page = ( $current_page * $ddp_per_page ) - $ddp_per_page;

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$term_relationships_table = $wpdb->prefix . 'term_relationships';

				$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt FROM $posts_table
						WHERE post_type IN( 'post', 'page' )
							AND post_status = 'publish'
							AND ( post_title LIKE '%$query%'
								OR post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page";				

				if( isset( $_POST['tax_query'] ) ) {

					$tax_ids = implode( ',', $_POST['tax_query'] );

					$tax_ids = sanitize_text_field( $tax_ids );

					$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt				
						FROM $posts_table
						INNER JOIN $term_relationships_table ON $posts_table.ID = $term_relationships_table.object_id
						WHERE $term_relationships_table.term_taxonomy_id IN( $tax_ids )
							AND $posts_table.post_type IN( 'post', 'page' )
							AND $posts_table.post_status = 'publish'
							AND ( $posts_table.post_title LIKE '%$query%'
								OR $posts_table.post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page
					";

				}

				$posts_id_results = $wpdb->get_results( $sql_str );

				// thumbnail size
				$thumbnail_size = 'full';

				if( $post_type === 'post' ) {

					$thumbnail_size = 'mx_news_thumb';

				}	

				foreach ( $posts_id_results as $key => $value ) {

					$the_thumbnail = get_the_post_thumbnail_url( $value->ID, $thumbnail_size );

					$posts_id_results[$key]->the_thumbnail = $the_thumbnail;

					$the_permalink = get_the_permalink( $value->ID );

					$posts_id_results[$key]->the_permalink = $the_permalink;

					// tags
					$tags = get_the_tags( $value->ID  );

					if( $tags ) {

						foreach ( $tags as $tag_key => $tag ) {

							$link = mxddp_get_tag_link( $tag->term_id );

							$tags[$tag_key]->tag_link = $link;

						}

					}

					$posts_id_results[$key]->tags = $tags;

					// date
					$posts_id_results[$key]->post_date = get_the_date( 'j F Y', $value->ID ) . ' г.';

					// short title
					$short_title = get_post_meta(
						$value->ID,
						'_mx_small-title_post_id',
						true
					);

					$posts_id_results[$key]->short_title = $short_title;
			
				}				

				$items_stuff = json_encode( $posts_id_results );

				echo $items_stuff;

			}

			wp_die();

		}

		// load more
		public static function mx_ddp_load_more_items_sp()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mx_ddpdata_nonce_request_front' ) ) {

				$post_type = 'post';

				if( isset( $_POST['post_type'] ) ) {

					$post_type = sanitize_text_field( $_POST['post_type'] );

				}

				$query = sanitize_text_field( $_POST['query'] );

				$current_page = sanitize_text_field( $_POST['current_page'] );

				$current_page = intval( $current_page );

				$ddp_per_page = sanitize_text_field( $_POST['ddp_per_page'] );

				$current_page = ( $current_page * $ddp_per_page ) - $ddp_per_page;

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$term_relationships_table = $wpdb->prefix . 'term_relationships';

				$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt FROM $posts_table
						WHERE post_type IN( 'post', 'page' )
							AND post_status = 'publish'
							AND ( post_title LIKE '%$query%'
								OR post_content LIKE '%$query%'
								OR post_excerpt LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page";

				if( isset( $_POST["tax_query"] ) ) {

					$tax_ids = implode( ',', $_POST['tax_query'] );

					$tax_ids = sanitize_text_field( $tax_ids );

					$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt				
						FROM $posts_table
						INNER JOIN $term_relationships_table ON $posts_table.ID = $term_relationships_table.object_id
						WHERE $term_relationships_table.term_taxonomy_id IN( $tax_ids )
							AND $posts_table.post_type IN( 'post', 'page' )
							AND $posts_table.post_status = 'publish'
							AND ( $posts_table.post_title LIKE '%$query%'
								OR $posts_table.post_content LIKE '%$query%'
								OR $posts_table.post_excerpt LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page
					";

				}

				$posts_id_results = $wpdb->get_results( $sql_str );

				// thumbnail size
				$thumbnail_size = 'full';

				if( $post_type === 'post' ) {

					$thumbnail_size = 'mx_news_thumb';

				}

				foreach ( $posts_id_results as $key => $value ) {

					$the_thumbnail = get_the_post_thumbnail_url( $value->ID, $thumbnail_size );

					$posts_id_results[$key]->the_thumbnail = $the_thumbnail;

					$the_permalink = get_the_permalink( $value->ID );

					$posts_id_results[$key]->the_permalink = $the_permalink;

					// tags
					$tags = get_the_tags( $value->ID  );

					$posts_id_results[$key]->tags = $tags;

					// short title
					$short_title = get_post_meta(
						$value->ID,
						'_mx_small-title_post_id',
						true
					);

					$posts_id_results[$key]->short_title = $short_title;
			
				}				

				$items_stuff = json_encode( $posts_id_results );

				echo $items_stuff;

				wp_die();

			}

		}













	/*
	* Registration of styles and scripts
	*/
	public static function mxffi_db_ajax()
	{

		// get count of ddp items
		add_action( 'wp_ajax_mx_get_count_ddp_items', array( 'MX_DDP_Database_Talk', 'mx_get_count_ddp_items' ) );

			add_action( 'wp_ajax_nopriv_mx_get_count_ddp_items', array( 'MX_DDP_Database_Talk', 'mx_get_count_ddp_items' ) );

		// get ddp items
		add_action( 'wp_ajax_mx_get_ddp_items', array( 'MX_DDP_Database_Talk', 'mx_get_ddp_items' ) );

			add_action( 'wp_ajax_nopriv_mx_get_ddp_items', array( 'MX_DDP_Database_Talk', 'mx_get_ddp_items' ) );

		// search items
		add_action( 'wp_ajax_mx_search_ddp_items', array( 'MX_DDP_Database_Talk', 'mx_search_ddp_items' ) );

			add_action( 'wp_ajax_nopriv_mx_search_ddp_items', array( 'MX_DDP_Database_Talk', 'mx_search_ddp_items' ) );

		// load more items
		add_action( 'wp_ajax_mx_ddp_load_more_items', array( 'MX_DDP_Database_Talk', 'mx_ddp_load_more_items' ) );

			add_action( 'wp_ajax_nopriv_mx_ddp_load_more_items', array( 'MX_DDP_Database_Talk', 'mx_ddp_load_more_items' ) );
			
	}

		// load more
		public static function mx_ddp_load_more_items()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mx_ddpdata_nonce_request_front' ) ) {

				$post_type = 'post';

				if( isset( $_POST['post_type'] ) ) {

					$post_type = sanitize_text_field( $_POST['post_type'] );

				}

				$query = sanitize_text_field( $_POST['query'] );

				$current_page = sanitize_text_field( $_POST['current_page'] );

				$current_page = intval( $current_page );

				$ddp_per_page = sanitize_text_field( $_POST['ddp_per_page'] );

				$current_page = ( $current_page * $ddp_per_page ) - $ddp_per_page;

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$term_relationships_table = $wpdb->prefix . 'term_relationships';

				$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt FROM $posts_table
						WHERE post_type = '$post_type'
							AND post_status = 'publish'
							AND ( post_title LIKE '%$query%'
								OR post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page";

				if( isset( $_POST["tax_query"] ) ) {

					$tax_ids = implode( ',', $_POST['tax_query'] );

					$tax_ids = sanitize_text_field( $tax_ids );

					$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt				
						FROM $posts_table
						INNER JOIN $term_relationships_table ON $posts_table.ID = $term_relationships_table.object_id
						WHERE $term_relationships_table.term_taxonomy_id IN( $tax_ids )
							AND $posts_table.post_type = '$post_type'
							AND $posts_table.post_status = 'publish'
							AND ( $posts_table.post_title LIKE '%$query%'
								OR $posts_table.post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page
					";

				}

				$posts_id_results = $wpdb->get_results( $sql_str );

				// thumbnail size
				$thumbnail_size = 'full';

				if( $post_type === 'post' ) {

					$thumbnail_size = 'mx_news_thumb';

				}

				foreach ( $posts_id_results as $key => $value ) {

					$the_thumbnail = get_the_post_thumbnail_url( $value->ID, $thumbnail_size );

					$posts_id_results[$key]->the_thumbnail = $the_thumbnail;

					$the_permalink = get_the_permalink( $value->ID );

					$posts_id_results[$key]->the_permalink = $the_permalink;

					// tags
					$tags = get_the_tags( $value->ID  );

					$posts_id_results[$key]->tags = $tags;

					// short title
					$short_title = get_post_meta(
						$value->ID,
						'_mx_small-title_post_id',
						true
					);

					$posts_id_results[$key]->short_title = $short_title;

					// fake date
					$fake_date = get_post_meta(
						$value->ID,
						'_mx_fake-date_post_id',
						true
					);

					$posts_id_results[$key]->fake_date = $fake_date;
			
				}				

				$items_stuff = json_encode( $posts_id_results );

				echo $items_stuff;

				wp_die();

			}

		}

		// get ddp item
		public static function mx_get_ddp_items()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mx_ddpdata_nonce_request_front' ) ) {	

				$post_type = 'post';

				if( isset( $_POST['post_type'] ) ) {

					$post_type = sanitize_text_field( $_POST['post_type'] );

				}		

				$query = sanitize_text_field( $_POST['query'] );

				$current_page = sanitize_text_field( $_POST['current_page'] );

				$current_page = intval( $current_page );

				$ddp_per_page = sanitize_text_field( $_POST['ddp_per_page'] );

				$current_page = ( $current_page * $ddp_per_page ) - $ddp_per_page;

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$term_relationships_table = $wpdb->prefix . 'term_relationships';

				$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt FROM $posts_table
						WHERE post_type = '$post_type'
							AND post_status = 'publish'
							AND ( post_title LIKE '%$query%'
								OR post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page";				

				if( isset( $_POST['tax_query'] ) ) {

					$tax_ids = implode( ',', $_POST['tax_query'] );

					$tax_ids = sanitize_text_field( $tax_ids );

					$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt				
						FROM $posts_table
						INNER JOIN $term_relationships_table ON $posts_table.ID = $term_relationships_table.object_id
						WHERE $term_relationships_table.term_taxonomy_id IN( $tax_ids )
							AND $posts_table.post_type = '$post_type'
							AND $posts_table.post_status = 'publish'
							AND ( $posts_table.post_title LIKE '%$query%'
								OR $posts_table.post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page
					";

				}

				$posts_id_results = $wpdb->get_results( $sql_str );

				// thumbnail size
				$thumbnail_size = 'full';

				if( $post_type === 'post' ) {

					$thumbnail_size = 'mx_news_thumb';

				}	

				foreach ( $posts_id_results as $key => $value ) {

					$the_thumbnail = get_the_post_thumbnail_url( $value->ID, $thumbnail_size );

					$posts_id_results[$key]->the_thumbnail = $the_thumbnail;

					$the_permalink = get_the_permalink( $value->ID );

					$posts_id_results[$key]->the_permalink = $the_permalink;

					// tags
					$tags = get_the_tags( $value->ID  );

					if( $tags ) {

						foreach ( $tags as $tag_key => $tag ) {

							$link = mxddp_get_tag_link( $tag->term_id );

							$tags[$tag_key]->tag_link = $link;

						}

					}

					$posts_id_results[$key]->tags = $tags;

					// date
					$posts_id_results[$key]->post_date = get_the_date( 'j F Y', $value->ID ) . ' г.';

					// short title
					$short_title = get_post_meta(
						$value->ID,
						'_mx_small-title_post_id',
						true
					);

					$posts_id_results[$key]->short_title = $short_title;

					// fake date
					$fake_date = get_post_meta(
						$value->ID,
						'_mx_fake-date_post_id',
						true
					);

					$posts_id_results[$key]->fake_date = $fake_date;

			
				}				

				$items_stuff = json_encode( $posts_id_results );

				echo $items_stuff;

			}

			wp_die();

		}

		// get count of ddp items
		public static function mx_get_count_ddp_items()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mx_ddpdata_nonce_request_front' ) ) {

				$post_type = 'post';

				if( isset( $_POST['post_type'] ) ) {

					$post_type = sanitize_text_field( $_POST['post_type'] );

				}	

				$query = sanitize_text_field( $_POST['query'] );

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$term_relationships_table = $wpdb->prefix . 'term_relationships';

				$sql_str = "SELECT COUNT(ID)
					FROM $posts_table
					WHERE post_type = '$post_type'
						AND post_status = 'publish'
						AND ( post_title LIKE '%$query%'
							OR post_content LIKE '%$query%' )
				";

				if( isset( $_POST["tax_query"] ) ) {

					$tax_ids = implode( ',', $_POST['tax_query'] );

					$tax_ids = sanitize_text_field( $tax_ids );

					$sql_str = "SELECT COUNT(ID)				
						FROM $posts_table
						INNER JOIN $term_relationships_table ON $posts_table.ID = $term_relationships_table.object_id
						WHERE $term_relationships_table.term_taxonomy_id IN( $tax_ids )
							AND $posts_table.post_type = '$post_type'
							AND $posts_table.post_status = 'publish'
							AND ( $posts_table.post_title LIKE '%$query%'
								OR $posts_table.post_content LIKE '%$query%' )
					";

				}

				$ddp_coung = $wpdb->get_var( $sql_str );

				echo $ddp_coung;

			}

			wp_die();

		}

		// get ddp item by search
		public static function mx_search_ddp_items()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mx_ddpdata_nonce_request_front' ) ) {

				$post_type = 'post';

				if( isset( $_POST['post_type'] ) ) {

					$post_type = sanitize_text_field( $_POST['post_type'] );

				}	

				$query = sanitize_text_field( $_POST['query'] );

				$current_page = sanitize_text_field( $_POST['current_page'] );

				$current_page = intval( $current_page );

				$ddp_per_page = sanitize_text_field( $_POST['ddp_per_page'] );

				$current_page = ( $current_page * $ddp_per_page ) - $ddp_per_page;

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$term_relationships_table = $wpdb->prefix . 'term_relationships';

				$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt FROM $posts_table
					WHERE post_type = '$post_type'
						AND post_status = 'publish'
						AND ( post_title LIKE '%$query%'
							OR post_content LIKE '%$query%'							
							OR post_excerpt LIKE '%$query%' )
					ORDER BY post_date DESC
					LIMIT $current_page, $ddp_per_page";

				if( isset( $_POST["tax_query"] ) ) {

					$tax_ids = implode( ',', $_POST['tax_query'] );

					$tax_ids = sanitize_text_field( $tax_ids );

					$sql_str = "SELECT ID, post_title, post_date, post_title, post_content, post_excerpt
						FROM $posts_table
						INNER JOIN $term_relationships_table ON $posts_table.ID = $term_relationships_table.object_id
						WHERE $term_relationships_table.term_taxonomy_id IN( $tax_ids )
							AND $posts_table.post_type = '$post_type'
							AND $posts_table.post_status = 'publish'
							AND ( $posts_table.post_title LIKE '%$query%'
								OR $posts_table.post_content LIKE '%$query%'
								OR $posts_table.post_excerpt LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $ddp_per_page
					";

				}

				$posts_id_results = $wpdb->get_results( $sql_str );

				// thumbnail size
				$thumbnail_size = 'full';

				if( $post_type === 'post' ) {

					$thumbnail_size = 'mx_news_thumb';

				}

				foreach ( $posts_id_results as $key => $value ) {

					$the_thumbnail = get_the_post_thumbnail_url( $value->ID, $thumbnail_size );

					$posts_id_results[$key]->the_thumbnail = $the_thumbnail;

					$the_permalink = get_the_permalink( $value->ID );

					$posts_id_results[$key]->the_permalink = $the_permalink;

					// short title
					$short_title = get_post_meta(
						$value->ID,
						'_mx_small-title_post_id',
						true
					);

					$posts_id_results[$key]->short_title = $short_title;

					// fake date
					$fake_date = get_post_meta(
						$value->ID,
						'_mx_fake-date_post_id',
						true
					);

					$posts_id_results[$key]->fake_date = $fake_date;		

				}					

				$items_stuff = json_encode( $posts_id_results );

				echo $items_stuff;

			}

			wp_die();

		}

}

MX_DDP_Database_Talk::mxffi_db_ajax();

MX_DDP_Database_Talk::mxffi_db_ajax_sp()

?>