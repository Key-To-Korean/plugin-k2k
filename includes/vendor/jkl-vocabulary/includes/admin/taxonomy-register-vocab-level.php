<?php
/**
 * K2K - Register Vocabulary Level Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Vocabulary Level taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_vocab_level() {

	// LEVEL taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Vocabulary Level', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Vocabulary Level', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Vocabulary Levels', 'k2k' ),
		'all_items'         => __( 'All Vocabulary Levels', 'k2k' ),
		'parent_item'       => __( 'Parent Vocabulary Level', 'k2k' ),
		'parent_item_colon' => __( 'Parent Vocabulary Level:', 'k2k' ),
		'edit_item'         => __( 'Edit Vocabulary Level', 'k2k' ),
		'update_item'       => __( 'Update Vocabulary Level', 'k2k' ),
		'add_new_item'      => __( 'Add New Vocabulary Level', 'k2k' ),
		'new_item_name'     => __( 'New Vocabulary Level Name', 'k2k' ),
		'menu_name'         => __( 'Vocabulary Levels', 'k2k' ),
		'view_item'         => __( 'View Vocabulary Level', 'k2k' ),
		'not_found'         => __( 'No Vocabulary Levels found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Vocabulary Levels', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'vocabulary/level' ),
	);

	register_taxonomy( 'k2k-vocab-level', 'k2k-vocabulary', $args );

}
add_action( 'init', 'k2k_register_taxonomy_vocab_level' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_vocab_level() {

	$taxonomy = 'k2k-vocab-level';
	$terms    = array(
		'0' => array(
			'name'        => __( 'True Beginner', 'k2k' ),
			'slug'        => 'vocab-true-beginner',
			'description' => __( 'True Beginner Vocabulary Level', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Beginner', 'k2k' ),
			'slug'        => 'vocab-beginner',
			'description' => __( 'Beginner Vocabulary Level', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Intermediate', 'k2k' ),
			'slug'        => 'vocab-intermediate',
			'description' => __( 'Intermediate Vocabulary Level', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Advanced', 'k2k' ),
			'slug'        => 'vocab-advanced',
			'description' => __( 'Advanced Vocabulary Level', 'k2k' ),
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_vocab' ) ) {
	add_action( 'init', 'k2k_register_new_terms_vocab_level' );
}
