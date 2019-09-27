<?php
/**
 * K2K - Register Tenses Taxonomy.
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
function k2k_register_taxonomy_tenses() {

	// TENSES taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Tense', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Tense', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Tenses', 'k2k' ),
		'popular_items'              => __( 'Popular Tenses', 'k2k' ),
		'all_items'                  => __( 'All Tenses', 'k2k' ),
		'parent_item'                => __( 'Parent Tense', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Tense:', 'k2k' ),
		'edit_item'                  => __( 'Edit Tense', 'k2k' ),
		'update_item'                => __( 'Update Tense', 'k2k' ),
		'add_new_item'               => __( 'Add New Tense', 'k2k' ),
		'new_item_name'              => __( 'New Tense Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Tenses with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Tenses', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Tenses', 'k2k' ),
		'not_found'                  => __( 'No Tenses found.', 'k2k' ),
		'menu_name'                  => __( 'Tenses', 'k2k' ),
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

	register_taxonomy( 'k2k-tenses', array( 'k2k-grammar' ), $args );

}
add_action( 'init', 'k2k_register_taxonomy_tenses' );
