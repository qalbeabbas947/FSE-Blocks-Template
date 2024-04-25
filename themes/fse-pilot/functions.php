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


add_action( 'uagb_single_post_before_title_grid', 'add_taxonomy_before_title', 10, 2 );

/**
 *  Add taxnomy befor title
 * 
 *  @param $post_id, $attributes
 */
function add_taxonomy_before_title( $post_id, $attributes ) {

    $post_category = get_the_category( $post_id )
    ?>
    <span class="fse-post-grid-category-pd"><?php the_category(); ?></span>
    <?php
}

add_action( 'uagb_single_post_after_excerpt_grid', 'add_date_and_comment_count_after_excerpt', 10, 2 );

/**
 *  add date and comment count after post excerpt
 * 
 *  @param $post_id, $attributes
 */
function add_date_and_comment_count_after_excerpt( $post_id, $attributes ) {

    $post_date = get_post_time( 'F j, Y', false, $post_id );
    $post_comment_count = get_comments_number( $post_id );
    ?>
    <div class="date-post-grid-and-comment-wrapper">
        <span class="fse-post-grid-date"><?php echo $post_date ;?></span>
        <span class="fse-post-grid-comments">
            <i class="fa-regular fa-comment"></i>
            <p class="fse-post-grid-side-comment-count"><?php echo $post_comment_count;?></p>
        </span>
    </div>
    <?php
}