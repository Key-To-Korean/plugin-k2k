<?php
/**
 * JKL Grammar - Register Tenses Taxonomy.
 *
 * @package JKL Grammar
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
function jkl_grammar_register_taxonomy_tenses() {

	// TENSES taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Tense', 'taxonomy general name', 'jkl-grammar' ),
		'singular_name'              => _x( 'Tense', 'taxonomy singular name', 'jkl-grammar' ),
		'search_items'               => __( 'Search Tenses', 'jkl-grammar' ),
		'popular_items'              => __( 'Popular Tenses', 'jkl-grammar' ),
		'all_items'                  => __( 'All Tenses', 'jkl-grammar' ),
		'parent_item'                => __( 'Parent Tense', 'jkl-grammar' ),
		'parent_item_colon'          => __( 'Parent Tense:', 'jkl-grammar' ),
		'edit_item'                  => __( 'Edit Tense', 'jkl-grammar' ),
		'update_item'                => __( 'Update Tense', 'jkl-grammar' ),
		'add_new_item'               => __( 'Add New Tense', 'jkl-grammar' ),
		'new_item_name'              => __( 'New Tense Name', 'jkl-grammar' ),
		'separate_items_with_commas' => __( 'Separate Tenses with commas', 'jkl-grammar' ),
		'add_or_remove_items'        => __( 'Add or remove Tenses', 'jkl-grammar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Tenses', 'jkl-grammar' ),
		'not_found'                  => __( 'No Tenses found.', 'jkl-grammar' ),
		'menu_name'                  => __( 'Tenses', 'jkl-grammar' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => false,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'grammar/tenses' ),
	);

	register_taxonomy( 'jkl-grammar-tenses', array( 'jkl-grammar' ), $args );

}
add_action( 'init', 'jkl_grammar_register_taxonomy_tenses' );
