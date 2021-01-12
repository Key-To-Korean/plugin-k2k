<?php
/**
 * K2K - Register Grammar Tenses Taxonomy.
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
function k2k_register_taxonomy_grammar_tenses() {

	// TENSES taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Grammar Tense', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Grammar Tense', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Grammar Tenses', 'k2k' ),
		'popular_items'              => __( 'Popular Grammar Tenses', 'k2k' ),
		'all_items'                  => __( 'All Grammar Tenses', 'k2k' ),
		'parent_item'                => __( 'Parent Grammar Tense', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Grammar Tense:', 'k2k' ),
		'edit_item'                  => __( 'Edit Grammar Tense', 'k2k' ),
		'update_item'                => __( 'Update Grammar Tense', 'k2k' ),
		'add_new_item'               => __( 'Add New Grammar Tense', 'k2k' ),
		'new_item_name'              => __( 'New Grammar Tense Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Grammar Tenses with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Grammar Tenses', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Grammar Tenses', 'k2k' ),
		'not_found'                  => __( 'No Grammar Tenses found.', 'k2k' ),
		'menu_name'                  => __( 'Grammar Tenses', 'k2k' ),
		'view_item'                  => __( 'View Grammar Tense', 'k2k' ),
		'back_to_items'              => __( '← Back to Grammar Tenses', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'grammar/tenses' ),
	);

	register_taxonomy( 'k2k-grammar-tenses', 'k2k-grammar', $args );

}
add_action( 'init', 'k2k_register_taxonomy_grammar_tenses' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_grammar_tenses() {

	$taxonomy = 'k2k-grammar-tenses';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Past', 'k2k' ),
			'slug'        => 'tense-past',
			'description' => __( 'Past Grammar Tense', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Present', 'k2k' ),
			'slug'        => 'tense-present',
			'description' => __( 'Present Grammar Tense', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Future', 'k2k' ),
			'slug'        => 'tense-future',
			'description' => __( 'Future Grammar Tense', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Supposition', 'k2k' ),
			'slug'        => 'tense-supposition',
			'description' => __( 'Supposition', 'k2k' ),
		),
		'4' => array(
			'name'        => __( 'Continuous', 'k2k' ),
			'slug'        => 'tense-continuous',
			'description' => __( 'Continuous Grammar Tense', 'k2k' ),
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_grammar' ) ) {
	add_action( 'init', 'k2k_register_new_terms_grammar_tenses' );
}
