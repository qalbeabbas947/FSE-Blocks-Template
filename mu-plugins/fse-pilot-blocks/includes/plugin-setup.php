<?php

defined( 'ABSPATH' ) || exit;

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets, so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @since   0.1.0
 * @version 0.1.0
 *
 * @return  void
 */
function fse_pilot_blocks_init(): void {
	register_block_type( FSE_PILOT_BLOCKS_DIR . 'build/dummy-subscribe-form' );
	register_block_type( FSE_PILOT_BLOCKS_DIR . 'build/table-of-contents' );
	
	$args = array();
	$args['category'] = 'widgets';
	$args['attributes'] = array(
						"category" => array(
							"type" => "string",
							"default" => "custom"
						),
						"post_type"  => array(
							"type" => "string",
							"default" => ""
						),
						// "is_featured"  => array(
						// 	"type" => "boolean",
						// 	"default" => false
						// ),
					);

	register_block_type( FSE_PILOT_BLOCKS_DIR . 'build/custom-post-display', $args );
	
}
add_action( 'init', 'fse_pilot_blocks_init' );

/**
 * Loads the blocks plugin's translated strings.
 *
 * @since   0.1.0
 * @version 0.1.0
 *
 * @return  void
 */
function fse_pilot_blocks_load_textdomain(): void {
	load_muplugin_textdomain( FSE_PILOT_BLOCKS_METADATA['TextDomain'], dirname( plugin_basename( FSE_PILOT_BLOCKS_DIR ) ) . FSE_PILOT_BLOCKS_METADATA['DomainPath'] );

	foreach ( glob( FSE_PILOT_BLOCKS_DIR . 'build/*', GLOB_ONLYDIR ) as $fse_pilot_block_dir ) {
		$fse_pilot_block_name = basename( $fse_pilot_block_dir );
		wp_set_script_translations(
			generate_block_asset_handle( "fse-pilot/$fse_pilot_block_name", 'editorScript' ),
			FSE_PILOT_BLOCKS_METADATA['TextDomain'],
			untrailingslashit( FSE_PILOT_BLOCKS_DIR ) . FSE_PILOT_BLOCKS_METADATA['DomainPath']
		);
	}
}
add_action( 'init', 'fse_pilot_blocks_load_textdomain', 11 );

/**
 * Plugin Constants
 */
function fse_register_routes() {
	
	add_action( 'rest_api_init', function () {
		register_rest_route( 'fse', '/post-types', array(
			'methods' => 'GET',
			'callback' => 'fse_get_post_types',
			'permission_callback' => '__return_true',
			) );

			register_rest_route( 'fse', '/categories/(?P<type>[a-zA-Z0-9_-]+)', array(
				'methods' => 'GET',
				'callback' => 'fse_get_categories',
				'permission_callback' => '__return_true',
				) );
		} ); 
	
		
}
add_action( 'init', 'fse_register_routes' );
/**add_action( 'init', 'fse_get_categories' );
/**
     * Plugin Constants
     */
	function fse_get_categories($request) {
		
		$type     = sanitize_text_field( $request['type'] );
		$types = explode( '_-_', $type );
		$taxonomies = [];
		foreach( $types as $tvp ) {
			$tax = get_object_taxonomies($tvp);
			$taxonomies = array_merge( $tax, $taxonomies );
		}

		$data = [];
		foreach( $taxonomies as $taxonomy ) {
			$taxterms = get_terms( $taxonomy, 'orderby=count&offset=1&hide_empty=0&fields=all' );
			foreach( $taxterms as $tax_term ) {
				$data[]  = [ 'value' => $tax_term->term_id, 'label' => $tax_term->name ];
			}
		}
		
		wp_send_json( $data ); 
		// $taxterms = get_terms( $tax, 'orderby=count&offset=1&hide_empty=0&fields=all' );
		// wp_send_json( $tax ); 
		// $args = array(
		// 	'name' => array(
		// 		'post',
		// 	),
		// );
		// $args = array(
		// 	'name' => 'post'
		// );
		// $output = 'names'; // or names
		// $taxonomies= get_taxonomies( $args, $output ); 

		// //$taxonomies = get_taxonomies( $args );

		// echo '<pre>';print_r($taxterms);
		// //print_r($taxonomies);
		// $args = array(
		// 	'post_type' => 'post'
		// );
		// $categories = get_terms( $args );
		// print_r($categories);

		// $taxObject = get_taxonomy('category');
    	// $postTypeArray = $taxObject->object_type;
		// print_r($postTypeArray);


		// echo '</pre>';
		// exit;
		// $post_types_arr = [];
		// $post_types = get_post_types(array(
		// 'public' => true,
		// ), 'objects');
	
		// // sort post types by name
		// uasort($post_types, function($a, $b) {
		// 	return strcmp($a->labels->name, $b->labels->name);
		// });
	
		// $types  = [];
		// foreach( $post_types as $key=>$value ) {
		// 	if( $key!='attachment' ) {
		// 		$types[]  = [ 'value'=> $key, 'label'=>$value->labels->name];
		// 	}
		// }
		// $types = [
		// 	['value'=> '1', 'label'=>'lbl1' ],
		// 	['value'=> '2', 'label'=>'lbl2' ],
		// 	['value'=> '3', 'label'=>'lbl3' ]
		// ];
		// wp_send_json( $types ); 
	}

/**
     * Plugin Constants
     */
function fse_get_post_types() {

	$post_types_arr = [];
	$post_types = get_post_types(array(
	'public' => true,
	), 'objects');

	// sort post types by name
	uasort($post_types, function($a, $b) {
		return strcmp($a->labels->name, $b->labels->name);
	});

	$types  = [];
	foreach( $post_types as $key=>$value ) {
		if( $key!='attachment' ) {
			$types[]  = [ 'value'=> $key, 'label'=>$value->labels->name];
		}
	}
	
	wp_send_json( $types ); 
}