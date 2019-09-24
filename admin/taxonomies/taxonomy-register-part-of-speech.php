<?php
/**
 * JKL Grammar - Register Part of Speech Taxonomy.
 *
 * @package JKL Grammar
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Part of Speech taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function jkl_grammar_register_taxonomy_ps() {

	// PARTS OF SPEECH taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Part of Speech', 'taxonomy general name', 'jkl-grammar' ),
		'singular_name'              => _x( 'Part of Speech', 'taxonomy singular name', 'jkl-grammar' ),
		'search_items'               => __( 'Search Parts of Speech', 'jkl-grammar' ),
		'popular_items'              => __( 'Popular Parts of Speech', 'jkl-grammar' ),
		'all_items'                  => __( 'All Parts of Speech', 'jkl-grammar' ),
		'parent_item'                => __( 'Parent Part of Speech', 'jkl-grammar' ),
		'parent_item_colon'          => __( 'Parent Part of Speech:', 'jkl-grammar' ),
		'edit_item'                  => __( 'Edit Part of Speech', 'jkl-grammar' ),
		'update_item'                => __( 'Update Part of Speech', 'jkl-grammar' ),
		'add_new_item'               => __( 'Add New Part of Speech', 'jkl-grammar' ),
		'new_item_name'              => __( 'New Part of Speech Name', 'jkl-grammar' ),
		'separate_items_with_commas' => __( 'Separate Parts of Speech with commas', 'jkl-grammar' ),
		'add_or_remove_items'        => __( 'Add or remove Parts of Speech', 'jkl-grammar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Parts of Speech', 'jkl-grammar' ),
		'not_found'                  => __( 'No Parts of Speech found.', 'jkl-grammar' ),
		'menu_name'                  => __( 'Parts of Speech', 'jkl-grammar' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => false,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'part-of-speech' ),
	);

	register_taxonomy( 'jkl-grammar-part-of-speech', array( 'jkl-grammar' ), $args );

}
add_action( 'init', 'jkl_grammar_register_taxonomy_ps' );
