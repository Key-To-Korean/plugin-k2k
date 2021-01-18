<?php
/**
 * K2K - Register Writing Level Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Writing Level taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_writing_level() {

	// LEVEL taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'              => _x( 'Writing Level', 'taxonomy general name', 'k2k' ),
		'singular_name'     => _x( 'Writing Level', 'taxonomy singular name', 'k2k' ),
		'search_items'      => __( 'Search Writing Levels', 'k2k' ),
		'all_items'         => __( 'All Writing Levels', 'k2k' ),
		'parent_item'       => __( 'Parent Writing Level', 'k2k' ),
		'parent_item_colon' => __( 'Parent Writing Level:', 'k2k' ),
		'edit_item'         => __( 'Edit Writing Level', 'k2k' ),
		'update_item'       => __( 'Update Writing Level', 'k2k' ),
		'add_new_item'      => __( 'Add New Writing Level', 'k2k' ),
		'new_item_name'     => __( 'New Writing Level Name', 'k2k' ),
		'menu_name'         => __( 'Writing Levels', 'k2k' ),
		'view_item'         => __( 'View Writing Level', 'k2k' ),
		'not_found'         => __( 'No Writing Levels found.', 'k2k' ),
		'back_to_items'     => __( '← Back to Writing Levels', 'k2k' ),
	);

	$args = array(
		'hierarchical'       => true,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'writing/level' ),
	);

	register_taxonomy( 'k2k-writing-level', 'k2k-writing', $args );

}
add_action( 'init', 'k2k_register_taxonomy_writing_level' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_writing_level() {

	$taxonomy = 'k2k-writing-level';
	$terms    = array(
		'0' => array(
			'name'        => __( 'True Beginner', 'k2k' ),
			'slug'        => 'writing-true-beginner',
			'description' => __( 'True Beginner Writing Level', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Beginner', 'k2k' ),
			'slug'        => 'writing-beginner',
			'description' => __( 'Beginner Writing Level', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Intermediate', 'k2k' ),
			'slug'        => 'writing-intermediate',
			'description' => __( 'Intermediate Writing Level', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Advanced', 'k2k' ),
			'slug'        => 'writing-advanced',
			'description' => __( 'Advanced Writing Level', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_writing_level' );
}
