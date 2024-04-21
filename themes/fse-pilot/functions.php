<?php
/**
 * FSE Pilot functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FSE Pilot
 * @since FSE Pilot 1.0
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since FSE Pilot 1.0
 *
 * @return void
 */
function fse_pilot_theme_support() {

	// Enqueue editor styles.
	add_editor_style( 'style-editor.css' );

	// Make theme available for translation.
	load_theme_textdomain( 'fse-pilot' );
}
add_action( 'after_setup_theme', 'fse_pilot_theme_support' );

/**
 * Enqueue styles.
 *
 * @since FSE Pilot 1.0
 *
 * @return void
 */
function fse_pilot_theme_styles() {

	// Register theme stylesheet.
	wp_register_style(
		'fse-pilot-style',
		get_stylesheet_directory_uri() . '/style.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// Enqueue theme stylesheet.
	wp_enqueue_style( 'fse-pilot-style' );
}
add_action( 'wp_enqueue_scripts', 'fse_pilot_theme_styles' );

/**
 * Add block style variations.
 *
 * @return void
 */
function fse_pilot_register_block_styles() {

	$block_styles = array(
		'core/button' => array(
			'secondary-button' => __( 'Secondary', 'fse-pilot' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'fse_pilot_register_block_styles' );


/**
 * Load custom block styles only when the block is used.
 *
 * @return void
 */
function fse_pilot_enqueue_custom_block_styles() {

	// Scan our styles folder to locate block styles.
	$files = glob( get_template_directory() . '/assets/css/*.css' );

	foreach ( $files as $file ) {

		// Get the filename and core block name.
		$filename   = basename( $file, '.css' );
		$block_name = str_replace( 'core-', 'core/', $filename );

		wp_enqueue_block_style(
			$block_name,
			array(
				'handle' => "fse-pilot-block-{$filename}",
				'src'    => get_theme_file_uri( "assets/css/{$filename}.css" ),
				'path'   => get_theme_file_path( "assets/css/{$filename}.css" ),
			)
		);
	}
}
add_action( 'init', 'fse_pilot_enqueue_custom_block_styles' );
