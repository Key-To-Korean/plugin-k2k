<?php
/**
 * K2K - Register Expression Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Expression taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_exp() {

	// EXPRESSION taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Expression', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Expression', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Expression', 'k2k' ),
		'popular_items'              => __( 'Popular Expressions', 'k2k' ),
		'all_items'                  => __( 'All Expression', 'k2k' ),
		'parent_item'                => __( 'Parent Expression', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Expression:', 'k2k' ),
		'edit_item'                  => __( 'Edit Expression', 'k2k' ),
		'update_item'                => __( 'Update Expression', 'k2k' ),
		'add_new_item'               => __( 'Add New Expression', 'k2k' ),
		'new_item_name'              => __( 'New Expression Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Expressions with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Expressions', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Expressions', 'k2k' ),
		'not_found'                  => __( 'No Expressions found.', 'k2k' ),
		'menu_name'                  => __( 'Expressions', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'expression' ),
	);

	register_taxonomy( 'k2k-expression', array( 'k2k-grammar', 'k2k-phrases' ), $args );

}
add_action( 'init', 'k2k_register_taxonomy_exp' );
