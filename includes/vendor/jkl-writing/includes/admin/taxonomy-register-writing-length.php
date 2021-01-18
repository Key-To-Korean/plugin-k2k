<?php
/**
 * K2K - Register Writing Length Taxonomy.
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
function k2k_register_taxonomy_writing_length() {

	// TENSES taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Writing Length', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Writing Length', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Writing Lengths', 'k2k' ),
		'popular_items'              => __( 'Popular Writing Lengths', 'k2k' ),
		'all_items'                  => __( 'All Writing Lengths', 'k2k' ),
		'parent_item'                => __( 'Parent Writing Length', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Writing Length:', 'k2k' ),
		'edit_item'                  => __( 'Edit Writing Length', 'k2k' ),
		'update_item'                => __( 'Update Writing Length', 'k2k' ),
		'add_new_item'               => __( 'Add New Writing Length', 'k2k' ),
		'new_item_name'              => __( 'New Writing Length Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Writing Lengths with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Writing Lengths', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Writing Lengths', 'k2k' ),
		'not_found'                  => __( 'No Writing Length found.', 'k2k' ),
		'menu_name'                  => __( 'Writing Length', 'k2k' ),
		'view_item'                  => __( 'View Writing Length', 'k2k' ),
		'back_to_items'              => __( '← Back to Writing Lengths', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writing/length' ),
	);

	register_taxonomy( 'k2k-writing-length', 'k2k-writing', $args );

}
add_action( 'init', 'k2k_register_taxonomy_writing_length' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_writing_length() {

	$taxonomy = 'k2k-writing-length';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Short', 'k2k' ),
			'slug'        => 'writing-length-short',
			'description' => __( 'A short writing of 100-200 characters or less. Typically only a single paragraph.', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Medium', 'k2k' ),
			'slug'        => 'writing-length-medium',
			'description' => __( 'A medium-length writing of 200-500 characters. Typically consisting of a few paragraphs.', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Long', 'k2k' ),
			'slug'        => 'writing-length-long',
			'description' => __( 'A long writing of 500-1000 characters. A short story.', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Extended', 'k2k' ),
			'slug'        => 'writing-length-extended',
			'description' => __( 'An extended writing of more than 1000 characters. A full-length story or speech.', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_writing_length' );
}
