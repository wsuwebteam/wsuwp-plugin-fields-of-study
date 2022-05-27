<?php namespace WSUWP\Plugin\Fields_Of_Study;

class Assets {

	public static function register_assets() {

		$editor_asset = include Plugin::get( 'dir' ) . 'assets/dist/editor.asset.php';

		// register editor assets
		wp_register_script(
			'wsuwp-plugin-programs-editor-scripts',
			Plugin::get( 'url' ) . 'assets/dist/editor.js',
			$editor_asset['dependencies'],
			$editor_asset['version']
		);

		wp_register_style(
			'wsuwp-plugin-programs-editor-styles',
			Plugin::get( 'url' ) . 'assets/dist/editor.css',
			array(),
			$editor_asset['version']
		);

		// register front-end assets
		wp_register_script( 'wsu_design_system_script_programs_list', 'https://cdn.web.wsu.edu/designsystem/2.x/dist/bundles/standalone/programs-list/scripts.js', array(), WSUWPPLUGINGUTENBERGVERSION, true );
		wp_register_style( 'wsu_design_system_script_programs_list', 'https://cdn.web.wsu.edu/designsystem/2.x/dist/bundles/standalone/programs-list/styles-wds.css', array(), WSUWPPLUGINGUTENBERGVERSION );

	}


	public static function enqueue_block_editor_assets() {

		wp_enqueue_script( 'wsuwp-plugin-programs-editor-scripts' );
		wp_enqueue_style( 'wsuwp-plugin-programs-editor-styles' );

	}


	public static function enqueue_frontend_assets() {

		if ( is_singular() ) {
			$id = get_the_ID();

			if ( has_block( 'wsuwp/programs-list', $id ) ) {
				wp_enqueue_script( 'wsu_design_system_script_programs_list' );
				wp_enqueue_style( 'wsu_design_system_script_programs_list' );
			}
		}

	}


	public static function init() {

		add_action( 'init', array( __CLASS__, 'register_assets' ) );
		add_action( 'enqueue_block_assets', array( __CLASS__, 'enqueue_frontend_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_assets' ) );

	}
}

Assets::init();
