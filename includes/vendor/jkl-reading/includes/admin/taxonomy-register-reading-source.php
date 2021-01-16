<?php
/**
 * K2K - Register Reading Source Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Reading Source taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_reading_source() {

	// USAGE taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Reading Source', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Reading Source', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Reading Source', 'k2k' ),
		'popular_items'              => __( 'Popular Reading Sources', 'k2k' ),
		'all_items'                  => __( 'All Reading Source', 'k2k' ),
		'parent_item'                => __( 'Parent Reading Source', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Reading Source:', 'k2k' ),
		'edit_item'                  => __( 'Edit Reading Source', 'k2k' ),
		'update_item'                => __( 'Update Reading Source', 'k2k' ),
		'add_new_item'               => __( 'Add New Reading Source', 'k2k' ),
		'new_item_name'              => __( 'New Reading Source Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Reading Sources with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Reading Sources', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Reading Sources', 'k2k' ),
		'not_found'                  => __( 'No Reading Sources found.', 'k2k' ),
		'menu_name'                  => __( 'Reading Source', 'k2k' ),
		'view_item'                  => __( 'View Reading Source', 'k2k' ),
		'back_to_items'              => __( '← Back to Reading Sources', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		// 'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'reading/source' ),
		'meta_box_cb'           => false, // Working on removing metabox in the sidebar.
	);

	register_taxonomy( 'k2k-reading-source', 'k2k-reading', $args );

}
add_action( 'init', 'k2k_register_taxonomy_reading_source' );


/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_reading_source() {

	$taxonomy = 'k2k-reading-source';
	$terms    = array(
		'0' => array(
			'name'        => __( 'YouTube', 'k2k' ),
			'slug'        => 'reading-from-youtube',
			'description' => __( 'Reading with a YouTube video.', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_reading_source' );
}
