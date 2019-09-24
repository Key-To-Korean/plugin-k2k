<?php
/**
 * JKL Grammar - Register Expression Taxonomy.
 *
 * @package JKL Grammar
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Expression taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function jkl_grammar_register_taxonomy_exp() {

	// EXPRESSION taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Expression', 'taxonomy general name', 'jkl-grammar' ),
		'singular_name'              => _x( 'Expression', 'taxonomy singular name', 'jkl-grammar' ),
		'search_items'               => __( 'Search Expression', 'jkl-grammar' ),
		'popular_items'              => __( 'Popular Expressions', 'jkl-grammar' ),
		'all_items'                  => __( 'All Expression', 'jkl-grammar' ),
		'parent_item'                => __( 'Parent Expression', 'jkl-grammar' ),
		'parent_item_colon'          => __( 'Parent Expression:', 'jkl-grammar' ),
		'edit_item'                  => __( 'Edit Expression', 'jkl-grammar' ),
		'update_item'                => __( 'Update Expression', 'jkl-grammar' ),
		'add_new_item'               => __( 'Add New Expression', 'jkl-grammar' ),
		'new_item_name'              => __( 'New Expression Name', 'jkl-grammar' ),
		'separate_items_with_commas' => __( 'Separate Expressions with commas', 'jkl-grammar' ),
		'add_or_remove_items'        => __( 'Add or remove Expressions', 'jkl-grammar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Expressions', 'jkl-grammar' ),
		'not_found'                  => __( 'No Expressions found.', 'jkl-grammar' ),
		'menu_name'                  => __( 'Expressions', 'jkl-grammar' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => false,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'expression' ),
	);

	register_taxonomy( 'jkl-grammar-expression', array( 'jkl-grammar' ), $args );

}
add_action( 'init', 'jkl_grammar_register_taxonomy_exp' );
