<?php
/**
 * K2K - Register Grammar Usage Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Grammar Usage taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_grammar_usage() {

	// USAGE taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Grammar Usage', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Grammar Usage', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Grammar Usage', 'k2k' ),
		'popular_items'              => __( 'Popular Grammar Usages', 'k2k' ),
		'all_items'                  => __( 'All Grammar Usage', 'k2k' ),
		'parent_item'                => __( 'Parent Grammar Usage', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Grammar Usage:', 'k2k' ),
		'edit_item'                  => __( 'Edit Grammar Usage', 'k2k' ),
		'update_item'                => __( 'Update Grammar Usage', 'k2k' ),
		'add_new_item'               => __( 'Add New Grammar Usage', 'k2k' ),
		'new_item_name'              => __( 'New Grammar Usage Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Grammar Usages with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Grammar Usages', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Grammar Usages', 'k2k' ),
		'not_found'                  => __( 'No Grammar Usages found.', 'k2k' ),
		'menu_name'                  => __( 'Grammar Usage', 'k2k' ),
		'view_item'                  => __( 'View Grammar Usage', 'k2k' ),
		'back_to_items'              => __( '← Back to Grammar Usages', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'grammar/usage' ),
		'meta_box_cb'           => false, // Working on removing metabox in the sidebar.
	);

	register_taxonomy( 'k2k-grammar-usage', 'k2k-grammar', $args );

}
add_action( 'init', 'k2k_register_taxonomy_grammar_usage' );


/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_grammar_usage() {

	$taxonomy = 'k2k-grammar-usage';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Formal', 'k2k' ),
			'slug'        => 'grammar-formal',
			'description' => __( 'Formal Language', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Informal', 'k2k' ),
			'slug'        => 'grammar-informal',
			'description' => __( 'Informal Language', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Written', 'k2k' ),
			'slug'        => 'grammar-written',
			'description' => __( 'Written Language', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Spoken', 'k2k' ),
			'slug'        => 'grammar-spoken',
			'description' => __( 'Spoken Language', 'k2k' ),
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
	add_action( 'init', 'k2k_register_new_terms_grammar_usage' );
}
