<?php
/**
 * K2K - Register Grammar Level Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Grammar Level taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_grammar_level() {

	// LEVEL taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Grammar Level', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Grammar Level', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Grammar Levels', 'k2k' ),
		'all_items'         => __( 'All Grammar Levels', 'k2k' ),
		'parent_item'       => __( 'Parent Grammar Level', 'k2k' ),
		'parent_item_colon' => __( 'Parent Grammar Level:', 'k2k' ),
		'edit_item'         => __( 'Edit Grammar Level', 'k2k' ),
		'update_item'       => __( 'Update Grammar Level', 'k2k' ),
		'add_new_item'      => __( 'Add New Grammar Level', 'k2k' ),
		'new_item_name'     => __( 'New Grammar Level Name', 'k2k' ),
		'menu_name'         => __( 'Grammar Levels', 'k2k' ),
		'view_item'         => __( 'View Grammar Level', 'k2k' ),
		'not_found'         => __( 'No Grammar Levels found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Grammar Levels', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'grammar/level' ),
	);

	register_taxonomy( 'k2k-grammar-level', 'k2k-grammar', $args );

}
add_action( 'init', 'k2k_register_taxonomy_grammar_level' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_grammar_level() {

	$taxonomy = 'k2k-grammar-level';
	$terms    = array(
		'0' => array(
			'name'        => __( 'True Beginner', 'k2k' ),
			'slug'        => 'grammar-true-beginner',
			'description' => __( 'True Beginner Grammar Level', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Beginner', 'k2k' ),
			'slug'        => 'grammar-beginner',
			'description' => __( 'Beginner Grammar Level', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Intermediate', 'k2k' ),
			'slug'        => 'grammar-intermediate',
			'description' => __( 'Intermediate Level', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Advanced', 'k2k' ),
			'slug'        => 'grammar-advanced',
			'description' => __( 'Advanced Level', 'k2k' ),
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_grammar' ) ) {
	add_action( 'init', 'k2k_register_new_terms_grammar_level' );
}
