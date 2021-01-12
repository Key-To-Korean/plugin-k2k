<?php
/**
 * K2K - Register Grammar Expression Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Grammar Expression taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_grammar_exp() {

	// EXPRESSION taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Grammar Expression', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Grammar Expression', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Grammar Expression', 'k2k' ),
		'popular_items'              => __( 'Popular Grammar Expressions', 'k2k' ),
		'all_items'                  => __( 'All Grammar Expression', 'k2k' ),
		'parent_item'                => __( 'Parent Grammar Expression', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Grammar Expression:', 'k2k' ),
		'edit_item'                  => __( 'Edit Grammar Expression', 'k2k' ),
		'update_item'                => __( 'Update Grammar Expression', 'k2k' ),
		'add_new_item'               => __( 'Add New Grammar Expression', 'k2k' ),
		'new_item_name'              => __( 'New Grammar Expression Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Grammar Expressions with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Grammar Expressions', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Grammar Expressions', 'k2k' ),
		'not_found'                  => __( 'No Grammar Expressions found.', 'k2k' ),
		'menu_name'                  => __( 'Grammar Expressions', 'k2k' ),
		'view_item'                  => __( 'View Grammar Expression', 'k2k' ),
		'back_to_items'              => __( '← Back to Grammar Expressions', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'grammar/expressing' ),
	);

	register_taxonomy( 'k2k-grammar-exp', 'k2k-grammar', $args );

}
add_action( 'init', 'k2k_register_taxonomy_grammar_exp' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_grammar_exp() {

	$taxonomy = 'k2k-grammar-exp';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Negation', 'k2k' ),
			'slug'        => 'grammar-negation',
			'description' => __( 'Negation expressions', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Particles', 'k2k' ),
			'slug'        => 'grammar-particles',
			'description' => __( 'Particles, articles, markers', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Listing', 'k2k' ),
			'slug'        => 'grammar-listing',
			'description' => __( 'Listing expressions', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_grammar_exp' );
}
