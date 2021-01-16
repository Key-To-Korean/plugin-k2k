<?php
/**
 * K2K - Register Reading Topic Taxonomy.
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
function k2k_register_taxonomy_reading_topic() {

	// TENSES taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Reading Topic', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Reading Topic', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Reading Topic', 'k2k' ),
		'popular_items'              => __( 'Popular Reading Topic', 'k2k' ),
		'all_items'                  => __( 'All Reading Topic', 'k2k' ),
		'parent_item'                => __( 'Parent Reading Topic', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Reading Topic:', 'k2k' ),
		'edit_item'                  => __( 'Edit Reading Topic', 'k2k' ),
		'update_item'                => __( 'Update Reading Topic', 'k2k' ),
		'add_new_item'               => __( 'Add New Reading Topic', 'k2k' ),
		'new_item_name'              => __( 'New Reading Topic Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Reading Topic with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Reading Topic', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Reading Topic', 'k2k' ),
		'not_found'                  => __( 'No Reading Topic found.', 'k2k' ),
		'menu_name'                  => __( 'Reading Topic', 'k2k' ),
		'view_item'                  => __( 'View Reading Topic', 'k2k' ),
		'back_to_items'              => __( '← Back to Reading Topic', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'reading/topic' ),
	);

	register_taxonomy( 'k2k-reading-topic', 'k2k-reading', $args );

}
add_action( 'init', 'k2k_register_taxonomy_reading_topic' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_reading_topic() {

	$taxonomy = 'k2k-reading-topic';
	$terms    = array(
		'0' => array(
			'name'        => __( 'General', 'k2k' ),
			'slug'        => 'reading-topic-general',
			'description' => __( 'General reading passage.', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_reading_topic' );
}
