<?php
/**
 * K2K - Register Vocab List Level Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Vocab List Level taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_vocab_list_level() {

	// LEVEL taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Vocab List Level', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Vocab List Level', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Vocab List Levels', 'k2k' ),
		'all_items'         => __( 'All Vocab List Levels', 'k2k' ),
		'parent_item'       => __( 'Parent Vocab List Level', 'k2k' ),
		'parent_item_colon' => __( 'Parent Vocab List Level:', 'k2k' ),
		'edit_item'         => __( 'Edit Vocab List Level', 'k2k' ),
		'update_item'       => __( 'Update Vocab List Level', 'k2k' ),
		'add_new_item'      => __( 'Add New Vocab List Level', 'k2k' ),
		'new_item_name'     => __( 'New Vocab List Level Name', 'k2k' ),
		'menu_name'         => __( 'Vocab List Levels', 'k2k' ),
		'view_item'         => __( 'View Vocab List Level', 'k2k' ),
		'not_found'         => __( 'No Vocab List Levels found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Vocab List Levels', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'vocab-list/level' ),
	);

	register_taxonomy( 'k2k-vocab-list-level', 'k2k-vocab-list', $args );

}
add_action( 'init', 'k2k_register_taxonomy_vocab_list_level' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_vocab_list_level() {

	$taxonomy = 'k2k-vocab-list-level';
	$terms    = array(
		'0' => array(
			'name'        => __( 'True Beginner', 'k2k' ),
			'slug'        => 'vocab-list-true-beginner',
			'description' => __( 'True Beginner Vocab List Level', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Beginner', 'k2k' ),
			'slug'        => 'vocab-list-beginner',
			'description' => __( 'Beginner Vocab List Level', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Intermediate', 'k2k' ),
			'slug'        => 'vocab-list-intermediate',
			'description' => __( 'Intermediate Vocab List Level', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Advanced', 'k2k' ),
			'slug'        => 'vocab-list-advanced',
			'description' => __( 'Advanced Vocab List Level', 'k2k' ),
		),
	);

	foreach ( $terms as $term ) {

		if ( ! term_exists( $term['slug'], $taxonomy ) ) {

			wp_insert_term(
				$term['name'], // The term.
				$taxonomy,     // The taxonomy.
				array(
					'description' => $term['description'],
					'slug'        => $term['slug'],
				)
			);

			unset( $term );

		}
	}
}
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_vocab_list' ) ) {
	add_action( 'init', 'k2k_register_new_terms_vocab_list_level' );
}
