<?php
/**
 * K2K - Register Vocabulary Group Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Vocabulary Group taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_vocab_group() {

	// USAGE taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Vocabulary Group', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Vocabulary Group', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Vocabulary Groups', 'k2k' ),
		'popular_items'              => __( 'Popular Vocabulary Groups', 'k2k' ),
		'all_items'                  => __( 'All Vocabulary Groups', 'k2k' ),
		'parent_item'                => __( 'Parent Vocabulary Group', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Vocabulary Group:', 'k2k' ),
		'edit_item'                  => __( 'Edit Vocabulary Group', 'k2k' ),
		'update_item'                => __( 'Update Vocabulary Group', 'k2k' ),
		'add_new_item'               => __( 'Add New Vocabulary Group', 'k2k' ),
		'new_item_name'              => __( 'New Vocabulary Group Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Vocabulary Groups with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Vocabulary Groups', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Vocabulary Groups', 'k2k' ),
		'not_found'                  => __( 'No Vocabulary Groups found.', 'k2k' ),
		'menu_name'                  => __( 'Vocabulary Group', 'k2k' ),
		'view_item'                  => __( 'View Vocabulary Group', 'k2k' ),
		'back_to_items'              => __( '← Back to Vocabulary Groups', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'vocabulary/group' ),
		'meta_box_cb'           => false, // Working on removing metabox in the sidebar.
	);

	register_taxonomy( 'k2k-vocab-group', array( 'k2k-vocabulary' ), $args );

}
add_action( 'init', 'k2k_register_taxonomy_vocab_group' );


/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_vocab_group() {

	$taxonomy = 'k2k-vocab-group';
	$terms    = array(
		'0' => array(
			'name'        => __( 'All Vocab', 'k2k' ),
			'slug'        => 'vocab-group-all',
			'description' => __( 'A basic starting point for ordering vocabulary.', 'k2k' ),
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_vocab' ) ) {
	add_action( 'init', 'k2k_register_new_terms_vocab_group' );
}
