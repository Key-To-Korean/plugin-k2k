<?php
/**
 * JKL Grammar - Register Level Taxonomy.
 *
 * @package JKL Grammar
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Level taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function jkl_grammar_register_taxonomy_level() {

	// LEVEL taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Level', 'taxonomy general name', 'jkl-grammar' ),
		'singular_name'     => _x( 'Level', 'taxonomy singular name', 'jkl-grammar' ),
		'search_items'      => __( 'Search Levels', 'jkl-grammar' ),
		'all_items'         => __( 'All Levels', 'jkl-grammar' ),
		'parent_item'       => __( 'Parent Level', 'jkl-grammar' ),
		'parent_item_colon' => __( 'Parent Level:', 'jkl-grammar' ),
		'edit_item'         => __( 'Edit Level', 'jkl-grammar' ),
		'update_item'       => __( 'Update Level', 'jkl-grammar' ),
		'add_new_item'      => __( 'Add New Level', 'jkl-grammar' ),
		'new_item_name'     => __( 'New Level Name', 'jkl-grammar' ),
		'menu_name'         => __( 'Levels', 'jkl-grammar' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => false,
		'show_admin_column'  => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'level' ),
	);

	register_taxonomy( 'jkl-grammar-level', array( 'jkl-grammar' ), $args );

}
add_action( 'init', 'jkl_grammar_register_taxonomy_level' );
