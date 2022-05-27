<?php namespace WSUWP\Plugin\Fields_Of_Study;

class Block_Programs_List {


	protected static $block_name    = 'wsuwp/programs-list';
	protected static $default_attrs = array(
		'className'    => '',
		'headingLevel' => 'h2',
		'showFilters'  => true,
	);


	public static function render( $attributes, $content ) {

		$attrs = array_merge( self::$default_attrs, $attributes );

		$campus_terms      = self::get_terms_array( 'wsuwp_campus' );
		$degree_type_terms = self::get_terms_array( 'wsuwp_degree_type' );
		$area_terms        = self::get_terms_array( 'wsuwp_area_of_study' );

		$program_groups   = range( 'A', 'Z' );
		$grouped_programs = self::get_grouped_programs( $program_groups );

		ob_start();

		include Plugin::get( 'template_dir' ) . '/block-programs-list.php';

		return ob_get_clean();

	}


	private static function get_grouped_programs( $groups ) {

		$programs = array();

		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'program',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		$query = new \WP_Query( $args );

		while ( $query->have_posts() ) {
			$query->the_post();
			$letter               = strtoupper( get_the_title()[0] );
			$group                = in_array( $letter, $groups, true ) ? $letter : '0';
			$programs[ $group ][] = self::map_to_program( $query->post );
		}

		wp_reset_postdata();

		return $programs;

	}


	private static function get_terms_array( $taxonomy ) {

		return self::map_to_terms_array(
			get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			)
		);

	}


	private static function map_to_terms_array( $term_objects ) {

		$terms = array();

		foreach ( $term_objects as $term_object ) {
			$terms[ $term_object->term_id ] = array(
				'name' => $term_object->name,
				'slug' => $term_object->slug,
			);
		}

		return $terms;

	}


	private static function map_to_program( $post ) {

		return array(
			'id'             => $post->ID,
			'title'          => $post->post_title,
			'url'            => get_post_meta( $post->ID, 'wsuwp_program_url', true ),
			'areas_of_study' => get_the_terms( $post->ID, 'wsuwp_area_of_study' ),
			'campus_degrees' => get_post_meta( $post->ID, 'wsuwp_program_campus_degrees', true ),
		);

	}


	public static function register_block() {

		register_block_type(
			self::$block_name,
			array(
				'render_callback' => array( __CLASS__, 'render' ),
				'api_version'     => 2,
			)
		);

	}


	public static function init() {

		add_action( 'init', __CLASS__ . '::register_block' );

	}

}

Block_Programs_List::init();
