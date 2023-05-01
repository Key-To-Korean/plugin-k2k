<?php
/**
 * K2K - Register Vocab List Book Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Vocab List Book taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_vocab_list_book() {

	// BOOK taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Vocab List Book', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Vocab List Book', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Vocab List Books', 'k2k' ),
		'all_items'         => __( 'All Vocab List Books', 'k2k' ),
		'parent_item'       => __( 'Parent Vocab List Book', 'k2k' ),
		'parent_item_colon' => __( 'Parent Vocab List Book:', 'k2k' ),
		'edit_item'         => __( 'Edit Vocab List Book', 'k2k' ),
		'update_item'       => __( 'Update Vocab List Book', 'k2k' ),
		'add_new_item'      => __( 'Add New Vocab List Book', 'k2k' ),
		'new_item_name'     => __( 'New Vocab List Book Name', 'k2k' ),
		'menu_name'         => __( 'Vocab List Books', 'k2k' ),
		'view_item'         => __( 'View Vocab List Book', 'k2k' ),
		'not_found'         => __( 'No Vocab List Books found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Vocab List Books', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => false,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'vocab-list/book' ),
	);

	register_taxonomy( 'k2k-vocab-list-book', 'k2k-vocab-list', $args );

}
add_action( 'init', 'k2k_register_taxonomy_vocab_list_book' );
