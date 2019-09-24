<?php
/**
 * JKL Grammar - Register Usage Taxonomy.
 *
 * @package JKL Grammar
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Usage taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function jkl_grammar_register_taxonomy_usage() {

	// USAGE taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Usage', 'taxonomy general name', 'jkl-grammar' ),
		'singular_name'              => _x( 'Usage', 'taxonomy singular name', 'jkl-grammar' ),
		'search_items'               => __( 'Search Usage', 'jkl-grammar' ),
		'popular_items'              => __( 'Popular Usages', 'jkl-grammar' ),
		'all_items'                  => __( 'All Usage', 'jkl-grammar' ),
		'parent_item'                => __( 'Parent Usage', 'jkl-grammar' ),
		'parent_item_colon'          => __( 'Parent Usage:', 'jkl-grammar' ),
		'edit_item'                  => __( 'Edit Usage', 'jkl-grammar' ),
		'update_item'                => __( 'Update Usage', 'jkl-grammar' ),
		'add_new_item'               => __( 'Add New Usage', 'jkl-grammar' ),
		'new_item_name'              => __( 'New Usage Name', 'jkl-grammar' ),
		'separate_items_with_commas' => __( 'Separate Usages with commas', 'jkl-grammar' ),
		'add_or_remove_items'        => __( 'Add or remove Usages', 'jkl-grammar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Usages', 'jkl-grammar' ),
		'not_found'                  => __( 'No Usages found.', 'jkl-grammar' ),
		'menu_name'                  => __( 'Usage', 'jkl-grammar' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => false,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'grammar/usage' ),
	);

	register_taxonomy( 'jkl-grammar-usage', array( 'jkl-grammar' ), $args );

}
add_action( 'init', 'jkl_grammar_register_taxonomy_usage' );
