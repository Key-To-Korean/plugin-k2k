<?php
/**
 * K2K - Register Reading Author Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Reading Author taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_reading_author() {

	// USAGE taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Reading Author', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Reading Author', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Reading Author', 'k2k' ),
		'popular_items'              => __( 'Popular Reading Authors', 'k2k' ),
		'all_items'                  => __( 'All Reading Author', 'k2k' ),
		'parent_item'                => __( 'Parent Reading Author', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Reading Author:', 'k2k' ),
		'edit_item'                  => __( 'Edit Reading Author', 'k2k' ),
		'update_item'                => __( 'Update Reading Author', 'k2k' ),
		'add_new_item'               => __( 'Add New Reading Author', 'k2k' ),
		'new_item_name'              => __( 'New Reading Author Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Reading Authors with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Reading Authors', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Reading Authors', 'k2k' ),
		'not_found'                  => __( 'No Reading Authors found.', 'k2k' ),
		'menu_name'                  => __( 'Reading Author', 'k2k' ),
		'view_item'                  => __( 'View Reading Author', 'k2k' ),
		'back_to_items'              => __( '← Back to Reading Authors', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		// 'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'reading/author' ),
		'meta_box_cb'           => false, // Working on removing metabox in the sidebar.
	);

	register_taxonomy( 'k2k-reading-author', 'k2k-reading', $args );

}
add_action( 'init', 'k2k_register_taxonomy_reading_author' );


/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_reading_author() {

	$taxonomy = 'k2k-reading-author';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Unknown', 'k2k' ),
			'slug'        => 'reading-author-unknown',
			'description' => __( 'Author Unknown', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_reading_author' );
}
