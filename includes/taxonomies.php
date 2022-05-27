<?php namespace WSUWP\Plugin\Fields_Of_Study;

class Taxonomies {

	public static function register_taxonomies() {

		$labels = array(
			'name'          => 'Areas of Study',
			'singular_name' => 'Area of Study',
			'search_items'  => 'Search Areas of Study',
			'all_items'     => 'All Areas of Study',
			'edit_item'     => 'Edit Area of Study',
			'update_item'   => 'Update Area of Study',
			'add_new_item'  => 'Add New Area of Study',
			'new_item_name' => 'New Area of Study',
			'menu_name'     => 'Areas of Study',
		);
		$args   = array(
			'labels'       => $labels,
			'description'  => 'Taxonomy for areas of study',
			'public'       => true,
			'hierarchical' => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'show_in_rest' => true,
			'rewrite'      => false,
			'query_var'    => 'wsuwp_area_of_study',
		);
		register_taxonomy( 'wsuwp_area_of_study', array( 'program' ), $args );

		$labels = array(
			'name'          => 'Degree Types',
			'singular_name' => 'Degree Type',
			'search_items'  => 'Search Degree Types',
			'all_items'     => 'All Degree Types',
			'edit_item'     => 'Edit Degree Type',
			'update_item'   => 'Update Degree Type',
			'add_new_item'  => 'Add New Degree Type',
			'new_item_name' => 'New Degree Type',
			'menu_name'     => 'Degree Types',
		);
		$args   = array(
			'labels'       => $labels,
			'description'  => 'Taxonomy for degree types',
			'public'       => true,
			'hierarchical' => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'show_in_rest' => true,
			'rewrite'      => false,
			'query_var'    => 'wsuwp_degree_type',
		);
		register_taxonomy( 'wsuwp_degree_type', array( 'program' ), $args );

		$labels = array(
			'name'          => 'Campuses',
			'singular_name' => 'Campus',
			'search_items'  => 'Search Campuses',
			'all_items'     => 'All Campuses',
			'edit_item'     => 'Edit Campus',
			'update_item'   => 'Update Campus',
			'add_new_item'  => 'Add New Campus',
			'new_item_name' => 'New Campus',
			'menu_name'     => 'Campuses',
		);
		$args   = array(
			'labels'       => $labels,
			'description'  => 'Taxonomy for campuses',
			'public'       => true,
			'hierarchical' => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'show_in_rest' => true,
			'rewrite'      => false,
			'query_var'    => 'wsuwp_campus',
		);
		register_taxonomy( 'wsuwp_campus', array( 'program' ), $args );

		$labels = array(
			'name'          => 'Colleges',
			'singular_name' => 'College',
			'search_items'  => 'Search Colleges',
			'all_items'     => 'All Colleges',
			'edit_item'     => 'Edit College',
			'update_item'   => 'Update College',
			'add_new_item'  => 'Add New College',
			'new_item_name' => 'New College',
			'menu_name'     => 'Colleges',
		);
		$args   = array(
			'labels'       => $labels,
			'description'  => 'Taxonomy for Colleges',
			'public'       => true,
			'hierarchical' => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'show_in_rest' => true,
			'rewrite'      => false,
			'query_var'    => 'wsuwp_college',
		);
		register_taxonomy( 'wsuwp_college', array( 'program' ), $args );

	}

	public static function init() {

		add_action( 'init', __CLASS__ . '::register_taxonomies' );

	}
}

Taxonomies::init();
