<?php namespace WSUWP\Plugin\Fields_Of_Study;

class Post_Type_Program {

	private static $slug = 'program';

	private static $attributes = array(
		'labels'       => array(
			'name'               => 'Programs',
			'singular_name'      => 'Program',
			'all_items'          => 'All Programs',
			'view_item'          => 'View Program',
			'add_new_item'       => 'Add New Program',
			'add_new'            => 'Add New',
			'edit_item'          => 'Edit Program',
			'update_item'        => 'Update Program',
			'search_items'       => 'Search Programs',
			'not_found'          => 'Not found',
			'not_found_in_trash' => 'Not found in Trash',
		),
		'description'  => 'Fields of Study',
		'hierarchical' => false,
		'show_ui'      => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-welcome-learn-more',
		'supports'     => array(
			'title',
			'editor',
			'author',
			'revisions',
			'custom-fields',
		),
		'taxonomies'   => array(
			'wsuwp_area_of_study',
			'wsuwp_degree_type',
			'wsuwp_campus',
			'wsuwp_college',
		),
		'rewrite'      => 'program',
	);


	public static function register_post_type() {

		register_post_type( self::$slug, self::$attributes );

		// register meta fields
		register_post_meta(
			$slug,
			'wsuwp_program_url',
			array(
				'type'          => 'string',
				'show_in_rest'  => true,
				'single'        => true,
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		register_post_meta(
			$slug,
			'wsuwp_program_campus_degrees',
			array(
				'type'          => 'object',
				'show_in_rest'  => array(
					'schema' => array(
						'type'                 => 'object',
						'properties'           => array(),
						'additionalProperties' => array(
							'type' => 'array',
						),
					),
				),
				'single'        => true,
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

	}


	public static function init() {

		add_action( 'init', __CLASS__ . '::register_post_type' );

	}
}

Post_Type_Program::init();
