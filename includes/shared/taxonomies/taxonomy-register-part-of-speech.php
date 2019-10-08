<?php
/**
 * K2K - Register Part of Speech Taxonomy.
 *
 * @package K2K
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
function k2k_register_taxonomy_ps() {

	// PARTS OF SPEECH taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Part of Speech', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Part of Speech', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Parts of Speech', 'k2k' ),
		'popular_items'              => __( 'Popular Parts of Speech', 'k2k' ),
		'all_items'                  => __( 'All Parts of Speech', 'k2k' ),
		'parent_item'                => __( 'Parent Part of Speech', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Part of Speech:', 'k2k' ),
		'edit_item'                  => __( 'Edit Part of Speech', 'k2k' ),
		'update_item'                => __( 'Update Part of Speech', 'k2k' ),
		'add_new_item'               => __( 'Add New Part of Speech', 'k2k' ),
		'new_item_name'              => __( 'New Part of Speech Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Parts of Speech with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Parts of Speech', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Parts of Speech', 'k2k' ),
		'not_found'                  => __( 'No Parts of Speech found.', 'k2k' ),
		'menu_name'                  => __( 'Parts of Speech', 'k2k' ),
		'view_item'                  => __( 'View Part of Speech', 'k2k' ),
		'back_to_items'              => __( '← Back to Parts of Speech', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'part-of-speech' ),
	);

	register_taxonomy( 'k2k-part-of-speech', array( 'k2k-grammar', 'k2k-vocabulary' ), $args );

}
add_action( 'init', 'k2k_register_taxonomy_ps' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_ps() {

	$taxonomy = 'k2k-part-of-speech';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Noun', 'k2k' ),
			'slug'        => 'part-of-speech-noun',
			'description' => __( 'Nouns', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Verb', 'k2k' ),
			'slug'        => 'part-of-speech-verb',
			'description' => __( 'Verbs', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Adjective', 'k2k' ),
			'slug'        => 'part-of-speech-adjective',
			'description' => __( 'Adjectives', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Adverb', 'k2k' ),
			'slug'        => 'part-of-speech-adverb',
			'description' => __( 'Adverbs', 'k2k' ),
		),
		'4' => array(
			'name'        => __( 'Number', 'k2k' ),
			'slug'        => 'part-of-speech-number',
			'description' => __( 'Numeral or Unit of Measurement', 'k2k' ),
		),
		'5' => array(
			'name'        => __( 'Noun Special', 'k2k' ),
			'slug'        => 'part-of-speech-s-noun',
			'description' => __( 'Places, Names, Pre-nouns, and Pronouns', 'k2k' ),
		),
		'6' => array(
			'name'        => __( 'Other', 'k2k' ),
			'slug'        => 'part-of-speech-other',
			'description' => __( 'Exclamations, Articles, Markers, Supplementary Words, and Other', 'k2k' ),
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
		// Only register Level terms if Vocab or Grammar are enabled.
		( 'on' === k2k_get_option( 'k2k_enable_vocab' ) || 'on' === k2k_get_option( 'k2k_enable_grammar' ) )
) {
	add_action( 'init', 'k2k_register_new_terms_ps' );
}
