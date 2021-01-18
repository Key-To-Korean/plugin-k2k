<?php
/**
 * K2K - Register Phrase Keywords Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Phrase Keywords taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_phrases_keywords() {

	// THEME taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Phrase Keywords', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Phrase Keywords', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Phrase Keywords', 'k2k' ),
		'popular_items'              => __( 'Popular Phrase Keywords', 'k2k' ),
		'all_items'                  => __( 'All Phrase Keywords', 'k2k' ),
		'parent_item'                => __( 'Parent Phrase Keywords', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Phrase Keywords:', 'k2k' ),
		'edit_item'                  => __( 'Edit Phrase Keywords', 'k2k' ),
		'update_item'                => __( 'Update Phrase Keywords', 'k2k' ),
		'add_new_item'               => __( 'Add New Phrase Keywords', 'k2k' ),
		'new_item_name'              => __( 'New Phrase Keywords Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Phrase Keywordss with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Phrase Keywords', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Phrase Keywords', 'k2k' ),
		'not_found'                  => __( 'No Phrase Keywords found.', 'k2k' ),
		'menu_name'                  => __( 'Phrase Keywords', 'k2k' ),
		'view_item'                  => __( 'View Phrase Keywords', 'k2k' ),
		'back_to_items'              => __( '← Back to Phrase Keywords', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'phrases/keywords' ),
	);

	register_taxonomy( 'k2k-phrase-keywords', 'k2k-phrases', $args );

}
add_action( 'init', 'k2k_register_taxonomy_phrases_keywords' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_phrases_keywords() {

	$taxonomy = 'k2k-phrase-keywords';
	$terms    = array(
		'0' => array(
			'name'        => __( 'None', 'k2k' ),
			'slug'        => 'phrase-keywords-none',
			'description' => __( 'Default keyword.', 'k2k' ),
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_phrases' ) ) {
	add_action( 'init', 'k2k_register_new_terms_phrases_keywords' );
}
