<?php
/**
 * K2K - Register Phrase Type Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Phrase Type taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_phrase_type() {

	// USAGE taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Phrase Type', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Phrase Type', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Phrase Types', 'k2k' ),
		'popular_items'              => __( 'Popular Phrase Types', 'k2k' ),
		'all_items'                  => __( 'All Phrase Types', 'k2k' ),
		'parent_item'                => __( 'Parent Phrase Type', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Phrase Type:', 'k2k' ),
		'edit_item'                  => __( 'Edit Phrase Type', 'k2k' ),
		'update_item'                => __( 'Update Phrase Type', 'k2k' ),
		'add_new_item'               => __( 'Add New Phrase Type', 'k2k' ),
		'new_item_name'              => __( 'New Phrase Type Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Phrase Types with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Phrase Types', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Phrase Types', 'k2k' ),
		'not_found'                  => __( 'No Phrase Types found.', 'k2k' ),
		'menu_name'                  => __( 'Phrase Type', 'k2k' ),
		'view_item'                  => __( 'View Phrase Type', 'k2k' ),
		'back_to_items'              => __( '← Back to Phrase Types', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'phrase/type' ),
		'meta_box_cb'           => false, // Working on removing metabox in the sidebar.
	);

	register_taxonomy( 'k2k-phrase-type', array( 'k2k-phrases' ), $args );

}
add_action( 'init', 'k2k_register_taxonomy_phrase_type' );


/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_phrase_type() {

	$taxonomy = 'k2k-phrase-type';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Idiom', 'k2k' ),
			'slug'        => 'phrase-type-idiom',
			'description' => __( 'Idiomatic phrases', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Proverb', 'k2k' ),
			'slug'        => 'phrase-type-proverb',
			'description' => __( 'Proverbs', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Dialect', 'k2k' ),
			'slug'        => 'phrase-type-dialect',
			'description' => __( 'Expressions and phrases specific to certain dialects and regions.', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Common', 'k2k' ),
			'slug'        => 'phrase-type-common',
			'description' => __( 'Commonly used expressions and phrases.', 'k2k' ),
		),
		'4' => array(
			'name'        => __( 'Slang', 'k2k' ),
			'slug'        => 'phrase-type-slang',
			'description' => __( 'Slang expressions and phrases.', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_phrase_type' );
}
