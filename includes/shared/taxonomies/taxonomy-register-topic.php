<?php
/**
 * K2K - Register Topic Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Topic taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_topic() {

	// THEME taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Topic', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Topic', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Topics', 'k2k' ),
		'popular_items'              => __( 'Popular Topics', 'k2k' ),
		'all_items'                  => __( 'All Topics', 'k2k' ),
		'parent_item'                => __( 'Parent Topic', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Topic:', 'k2k' ),
		'edit_item'                  => __( 'Edit Topic', 'k2k' ),
		'update_item'                => __( 'Update Topic', 'k2k' ),
		'add_new_item'               => __( 'Add New Topic', 'k2k' ),
		'new_item_name'              => __( 'New Topic Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Topics with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Topics', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Topics', 'k2k' ),
		'not_found'                  => __( 'No Topics found.', 'k2k' ),
		'menu_name'                  => __( 'Topics', 'k2k' ),
		'view_item'                  => __( 'View Topic', 'k2k' ),
		'back_to_items'              => __( '← Back to Topics', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'topics' ),
	);

	register_taxonomy( 'k2k-topic', array( 'k2k-vocabulary', 'k2k-phrases' ), $args );

}
add_action( 'init', 'k2k_register_taxonomy_topic' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_topic() {

	$taxonomy = 'k2k-topic';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Negation', 'k2k' ),
			'slug'        => 'expression-negation',
			'description' => __( 'Negation expressions', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Particles', 'k2k' ),
			'slug'        => 'expression-particles',
			'description' => __( 'Particles, articles, markers', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Listing', 'k2k' ),
			'slug'        => 'expression-listing',
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
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) &&
		// Only register Topic terms if Vocab or Phrases are enabled.
		( 'on' === k2k_get_option( 'k2k_enable_vocab' ) || 'on' === k2k_get_option( 'k2k_enable_phrases' ) )
) {
	add_action( 'init', 'k2k_register_new_terms_topic' );
}
