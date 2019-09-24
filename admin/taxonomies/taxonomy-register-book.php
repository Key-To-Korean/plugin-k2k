<?php
/**
 * JKL Grammar - Register Book Taxonomy.
 *
 * @package JKL Grammar
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Book taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function jkl_grammar_register_taxonomy_book() {

	// BOOK taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Book', 'taxonomy general name', 'jkl-grammar' ),
		'singular_name'     => _x( 'Book', 'taxonomy singular name', 'jkl-grammar' ),
		'search_items'      => __( 'Search Books', 'jkl-grammar' ),
		'all_items'         => __( 'All Books', 'jkl-grammar' ),
		'parent_item'       => __( 'Parent Book', 'jkl-grammar' ),
		'parent_item_colon' => __( 'Parent Book:', 'jkl-grammar' ),
		'edit_item'         => __( 'Edit Book', 'jkl-grammar' ),
		'update_item'       => __( 'Update Book', 'jkl-grammar' ),
		'add_new_item'      => __( 'Add New Book', 'jkl-grammar' ),
		'new_item_name'     => __( 'New Book Name', 'jkl-grammar' ),
		'menu_name'         => __( 'Books', 'jkl-grammar' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => false,
		'show_admin_column'  => false,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
	);

	register_taxonomy( 'jkl-grammar-book', array( 'jkl-grammar' ), $args );

}
add_action( 'init', 'jkl_grammar_register_taxonomy_book' );
