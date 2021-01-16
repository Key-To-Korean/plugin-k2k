<?php
/**
 * K2K - Register Reading Genre Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Reading Genre taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_reading_genre() {

	// BOOK taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Reading Genre', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Reading Genre', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Reading Genres', 'k2k' ),
		'all_items'         => __( 'All Reading Genres', 'k2k' ),
		'parent_item'       => __( 'Parent Reading Genre', 'k2k' ),
		'parent_item_colon' => __( 'Parent Reading Genre:', 'k2k' ),
		'edit_item'         => __( 'Edit Reading Genre', 'k2k' ),
		'update_item'       => __( 'Update Reading Genre', 'k2k' ),
		'add_new_item'      => __( 'Add New Reading Genre', 'k2k' ),
		'new_item_name'     => __( 'New Reading Genre Name', 'k2k' ),
		'menu_name'         => __( 'Reading Genres', 'k2k' ),
		'view_item'         => __( 'View Reading Genre', 'k2k' ),
		'not_found'         => __( 'No Reading Genres found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Reading Genres', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => false,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'reading/genre' ),
	);

	register_taxonomy( 'k2k-reading-genre', 'k2k-reading', $args );

}
add_action( 'init', 'k2k_register_taxonomy_reading_genre' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_reading_genre() {

	$taxonomy = 'k2k-reading-genre';
	$terms    = array(
		'0' => array(
			'name'        => __( 'TOPIK', 'k2k' ),
			'slug'        => 'reading-genre-topik',
			'description' => __( 'Readings found in previous TOPIK tests.', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_reading_genre' );
}
