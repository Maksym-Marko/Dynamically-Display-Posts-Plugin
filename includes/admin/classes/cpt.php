<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXDDPCPTclass
{

	/*
	* MXDDPCPTclass constructor
	*/
	public function __construct()
	{		

	}

	/*
	* Observe function
	*/
	public static function createCPT()
	{

		add_action( 'init', [ 'MXDDPCPTclass', 'mxddp_custom_init' ] );

	}

	/*
	* Create a Custom Post Type
	*/
	public static function mxddp_custom_init()
	{
		
		register_post_type( 'mxddp_books', [

			'labels'             => [
				'name'               => 'Books',
				'singular_name'      => 'Book',
				'add_new'            => 'Add a new one',
				'add_new_item'       => 'Add a new book',
				'edit_item'          => 'Edit the book',
				'new_item'           => 'New book',
				'view_item'          => 'See the book',
				'search_items'       => 'Find a book',
				'not_found'          =>  'Books not found',
				'not_found_in_trash' => 'No books found in the trash',
				'parent_item_colon'  => '',
				'menu_name'          => 'Books'

			],
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ]

		] );

		// Rewrite rules
		if( is_admin() && get_option( 'mxddp_flush_rewrite_rules' ) == 'go_flush_rewrite_rules' )
		{

			delete_option( 'mxddp_flush_rewrite_rules' );

			flush_rewrite_rules();

		}

		/*
		* add metaboxes
		*/
		
		// add text input
		new MXDDP_Metaboxes_Class(
			[
				'id'			=> 'text-metabox',
				'post_types' 	=> 'mxddp_books',
				'name'			=> esc_html( 'Text field', 'mx-domain' )
			]
		);

		// add email input
		new MXDDP_Metaboxes_Class(
			[
				'id'			=> 'email-metabox',
				'post_types' 	=> 'mxddp_books',
				'name'			=> esc_html( 'E-mail field', 'mx-domain' ),
				'metabox_type'	=> 'input-email'
			]
		);

		// add url input
		new MXDDP_Metaboxes_Class(
			[
				'id'			=> 'url-metabox',
				'post_types' 	=> 'mxddp_books',
				'name'			=> esc_html( 'URL field', 'mx-domain' ),
				'metabox_type'	=> 'input-url'
			]
		);

		// description
		new MXDDP_Metaboxes_Class(
			[
				'id'			=> 'desc-metabox',
				'post_types' 	=> 'mxddp_books',
				'name'			=> esc_html( 'Some Description', 'mx-domain' ),
				'metabox_type'	=> 'textarea'
			]
		);

		// add checkboxes
		new MXDDP_Metaboxes_Class(
			[
				'id'			=> 'checkboxes-metabox',
				'post_types' 	=> 'mxddp_books',
				'name'			=> esc_html( 'Checkbox Buttons', 'mx-domain' ),
				'metabox_type'	=> 'checkbox',
				'options' 		=> [
					[
						'value' => 'Dog',
						'checked' 	=> true
					],
					[
						'value' 	=> 'Cat'
					],
					[
						'value' 	=> 'Fish'
					]		
				]
			]
		);

		// add radio buttons
		new MXDDP_Metaboxes_Class(
			[
				'id'			=> 'radio-buttons-metabox',
				'post_types' 	=> 'mxddp_books',
				'name'			=> esc_html( 'Radio Buttons', 'mx-domain' ),
				'metabox_type'	=> 'radio',
				'options' 		=> [
					[
						'value' => 'red'
					],
					[
						'value' => 'green'
					],
					[
						'value' 	=> 'Yellow',
						'checked' 	=> true
					]		
				]
			]
		);

		// image upload
		new MXDDP_Metaboxes_Class(
			[
				'id'			=> 'featured-image-metabox',
				'post_types' 	=> 'mxddp_books',
				'name'			=> esc_html( 'Featured image', 'mx-domain' ),
				'metabox_type'	=> 'image'
			]
		);

	}

}