<?php
/**
 * K2K - Register Writing Topic Taxonomy.
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
function k2k_register_taxonomy_writing_topic() {

	// TENSES taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Writing Topic', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Writing Topic', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Writing Topic', 'k2k' ),
		'popular_items'              => __( 'Popular Writing Topic', 'k2k' ),
		'all_items'                  => __( 'All Writing Topic', 'k2k' ),
		'parent_item'                => __( 'Parent Writing Topic', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Writing Topic:', 'k2k' ),
		'edit_item'                  => __( 'Edit Writing Topic', 'k2k' ),
		'update_item'                => __( 'Update Writing Topic', 'k2k' ),
		'add_new_item'               => __( 'Add New Writing Topic', 'k2k' ),
		'new_item_name'              => __( 'New Writing Topic Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Writing Topic with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Writing Topic', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Writing Topic', 'k2k' ),
		'not_found'                  => __( 'No Writing Topic found.', 'k2k' ),
		'menu_name'                  => __( 'Writing Topic', 'k2k' ),
		'view_item'                  => __( 'View Writing Topic', 'k2k' ),
		'back_to_items'              => __( '← Back to Writing Topic', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writing/topic' ),
	);

	register_taxonomy( 'k2k-writing-topic', 'k2k-writing', $args );

}
add_action( 'init', 'k2k_register_taxonomy_writing_topic' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_writing_topic() {

	$taxonomy = 'k2k-writing-topic';
	$terms    = array(
		'0' => array(
			'name'        => __( 'General', 'k2k' ),
			'slug'        => 'writing-topic-general',
			'description' => __( 'General writing passage.', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_writing_topic' );
}
