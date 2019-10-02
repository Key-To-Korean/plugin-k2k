<?php
/**
 * K2K - Register Level Taxonomy.
 *
 * @package K2K
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
function k2k_register_taxonomy_level() {

	// LEVEL taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Level', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Level', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Levels', 'k2k' ),
		'all_items'         => __( 'All Levels', 'k2k' ),
		'parent_item'       => __( 'Parent Level', 'k2k' ),
		'parent_item_colon' => __( 'Parent Level:', 'k2k' ),
		'edit_item'         => __( 'Edit Level', 'k2k' ),
		'update_item'       => __( 'Update Level', 'k2k' ),
		'add_new_item'      => __( 'Add New Level', 'k2k' ),
		'new_item_name'     => __( 'New Level Name', 'k2k' ),
		'menu_name'         => __( 'Levels', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'level' ),
	);

	register_taxonomy( 'k2k-level', array( 'k2k-grammar', 'k2k-vocabulary' ), $args );

}
add_action( 'init', 'k2k_register_taxonomy_level' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_level() {

	$taxonomy = 'k2k-level';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Beginner', 'k2k' ),
			'slug'        => 'level-beginner',
			'description' => __( 'Beginner Level', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Intermediate', 'k2k' ),
			'slug'        => 'level-intermediate',
			'description' => __( 'Intermediate Level', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Advanced', 'k2k' ),
			'slug'        => 'level-advanced',
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) ) {
	add_action( 'init', 'k2k_register_new_terms_level' );
}
