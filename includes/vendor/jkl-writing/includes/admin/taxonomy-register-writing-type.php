<?php
/**
 * K2K - Register Writing Type Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Usage taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_writing_type() {

	// TENSES taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Writing Type', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Writing Type', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Writing Types', 'k2k' ),
		'popular_items'              => __( 'Popular Writing Types', 'k2k' ),
		'all_items'                  => __( 'All Writing Types', 'k2k' ),
		'parent_item'                => __( 'Parent Writing Type', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Writing Type:', 'k2k' ),
		'edit_item'                  => __( 'Edit Writing Type', 'k2k' ),
		'update_item'                => __( 'Update Writing Type', 'k2k' ),
		'add_new_item'               => __( 'Add New Writing Type', 'k2k' ),
		'new_item_name'              => __( 'New Writing Type Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Writing Types with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Writing Types', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Writing Types', 'k2k' ),
		'not_found'                  => __( 'No Writing Type found.', 'k2k' ),
		'menu_name'                  => __( 'Writing Type', 'k2k' ),
		'view_item'                  => __( 'View Writing Type', 'k2k' ),
		'back_to_items'              => __( '← Back to Writing Types', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writing/type' ),
	);

	register_taxonomy( 'k2k-writing-type', 'k2k-writing', $args );

}
add_action( 'init', 'k2k_register_taxonomy_writing_type' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_writing_type() {

	$taxonomy = 'k2k-writing-type';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Folk Tale', 'k2k' ),
			'slug'        => 'writing-folk-tale',
			'description' => __( 'A writing passage from a common folk tale.', 'k2k' ),
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_writing' ) ) {
	add_action( 'init', 'k2k_register_new_terms_writing_type' );
}
