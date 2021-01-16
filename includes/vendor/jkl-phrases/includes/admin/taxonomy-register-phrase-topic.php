<?php
/**
 * K2K - Register Phrase Topic Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Phrase Topic taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_phrases_topic() {

	// THEME taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Phrase Topic', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Phrase Topic', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Phrase Topics', 'k2k' ),
		'popular_items'              => __( 'Popular Phrase Topics', 'k2k' ),
		'all_items'                  => __( 'All Phrase Topics', 'k2k' ),
		'parent_item'                => __( 'Parent Phrase Topic', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Phrase Topic:', 'k2k' ),
		'edit_item'                  => __( 'Edit Phrase Topic', 'k2k' ),
		'update_item'                => __( 'Update Phrase Topic', 'k2k' ),
		'add_new_item'               => __( 'Add New Phrase Topic', 'k2k' ),
		'new_item_name'              => __( 'New Phrase Topic Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Phrase Topics with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Phrase Topics', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Phrase Topics', 'k2k' ),
		'not_found'                  => __( 'No Phrase Topics found.', 'k2k' ),
		'menu_name'                  => __( 'Phrase Topics', 'k2k' ),
		'view_item'                  => __( 'View Phrase Topic', 'k2k' ),
		'back_to_items'              => __( '← Back to Phrase Topics', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'phrases/topic' ),
	);

	register_taxonomy( 'k2k-phrase-topic', 'k2k-phrases', $args );

}
add_action( 'init', 'k2k_register_taxonomy_phrases_topic' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_phrases_topic() {

	$taxonomy = 'k2k-phrase-topic';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Common Speech', 'k2k' ),
			'slug'        => 'phrase-topic-common',
			'description' => __( 'Common Phrases.', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_phrases_topic' );
}
