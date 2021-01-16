<?php
/**
 * K2K - Register Reading Level Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Reading Level taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_reading_level() {

	// LEVEL taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Reading Level', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Reading Level', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Reading Levels', 'k2k' ),
		'all_items'         => __( 'All Reading Levels', 'k2k' ),
		'parent_item'       => __( 'Parent Reading Level', 'k2k' ),
		'parent_item_colon' => __( 'Parent Reading Level:', 'k2k' ),
		'edit_item'         => __( 'Edit Reading Level', 'k2k' ),
		'update_item'       => __( 'Update Reading Level', 'k2k' ),
		'add_new_item'      => __( 'Add New Reading Level', 'k2k' ),
		'new_item_name'     => __( 'New Reading Level Name', 'k2k' ),
		'menu_name'         => __( 'Reading Levels', 'k2k' ),
		'view_item'         => __( 'View Reading Level', 'k2k' ),
		'not_found'         => __( 'No Reading Levels found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Reading Levels', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'reading/level' ),
	);

	register_taxonomy( 'k2k-reading-level', 'k2k-reading', $args );

}
add_action( 'init', 'k2k_register_taxonomy_reading_level' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_reading_level() {

	$taxonomy = 'k2k-reading-level';
	$terms    = array(
		'0' => array(
			'name'        => __( 'True Beginner', 'k2k' ),
			'slug'        => 'reading-true-beginner',
			'description' => __( 'True Beginner Reading Level', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Beginner', 'k2k' ),
			'slug'        => 'reading-beginner',
			'description' => __( 'Beginner Reading Level', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Intermediate', 'k2k' ),
			'slug'        => 'reading-intermediate',
			'description' => __( 'Intermediate Reading Level', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Advanced', 'k2k' ),
			'slug'        => 'reading-advanced',
			'description' => __( 'Advanced Reading Level', 'k2k' ),
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_reading' ) ) {
	add_action( 'init', 'k2k_register_new_terms_reading_level' );
}
