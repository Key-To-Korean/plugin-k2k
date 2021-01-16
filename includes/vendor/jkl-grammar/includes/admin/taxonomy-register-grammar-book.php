<?php
/**
 * K2K - Register Grammar Book Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Grammar Book taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_grammar_book() {

	// BOOK taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Grammar Book', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Grammar Book', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Grammar Books', 'k2k' ),
		'all_items'         => __( 'All Grammar Books', 'k2k' ),
		'parent_item'       => __( 'Parent Grammar Book', 'k2k' ),
		'parent_item_colon' => __( 'Parent Grammar Book:', 'k2k' ),
		'edit_item'         => __( 'Edit Grammar Book', 'k2k' ),
		'update_item'       => __( 'Update Grammar Book', 'k2k' ),
		'add_new_item'      => __( 'Add New Grammar Book', 'k2k' ),
		'new_item_name'     => __( 'New Grammar Book Name', 'k2k' ),
		'menu_name'         => __( 'Grammar Books', 'k2k' ),
		'view_item'         => __( 'View Grammar Book', 'k2k' ),
		'not_found'         => __( 'No Grammar Books found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Grammar Books', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => false,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'grammar/book' ),
	);

	register_taxonomy( 'k2k-grammar-book', 'k2k-grammar', $args );

}
add_action( 'init', 'k2k_register_taxonomy_grammar_book' );
