<?php
/**
 * JKL Vocabulary Post Type Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Vocabulary Post Type styles and scripts.
 */
function jkl_vocabulary_enqueue_scripts() {

	/* Vocabulary Scripts */
	if ( 'k2k-vocabulary' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-vocab-style',
			plugins_url( 'css/vocab.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/vocab.css' )
		);

		if ( is_singular( 'k2k-vocabulary' ) ) {
			wp_enqueue_script(
				'k2k-vocab-script',
				plugins_url( 'js/vocab.js', __DIR__ ),
				array(),
				filemtime( plugin_dir_path( __DIR__ ) . 'js/vocab.js' ),
				true
			);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'jkl_vocabulary_enqueue_scripts' );

/**
 * Function to return all Post and Meta data for JKL Vocabulary Post Types in a single array.
 *
 * @return array All the Post and Meta data.
 */
function jkl_vocabulary_get_meta_data() {

	$meta = [];

	// Get post meta data.
	$meta_prefix = 'k2k_vocab_meta_';

	// Subtitle (translation).
	$meta['subtitle'] = get_post_meta( get_the_ID(), $meta_prefix . 'subtitle', true );
	// Definitions (array).
	$meta['definitions'] = get_post_meta( get_the_ID(), $meta_prefix . 'definitions', true );
	// Sentences (array).
	$meta['sentences'] = get_post_meta( get_the_ID(), $meta_prefix . 'sentences', true );
	// Common Usage (array).
	$meta['usage'] = get_post_meta( get_the_ID(), $meta_prefix . 'common_usage', true );
	// Synonyms (array).
	$meta['synonyms'] = get_post_meta( get_the_ID(), $meta_prefix . 'synonym_group', true );
	// Antonyms (array).
	$meta['antonyms'] = get_post_meta( get_the_ID(), $meta_prefix . 'antonym_group', true );
	// Hanja (array).
	$meta['hanja'] = get_post_meta( get_the_ID(), $meta_prefix . 'hanja_group', true );

	// Term Meta.
	$term_prefix      = 'k2k_taxonomy_';
	$vocab_taxonomies = array( // Taxonomy Data.
		'k2k-level',             // Level (1).
		'k2k-part-of-speech',    // Part of Speech (1).
		'k2k-topic',             // Topic.
		'k2k-vocab-group',       // Vocab Group.
	);

	foreach ( $vocab_taxonomies as $taxonomy ) {

		$tax_terms = get_the_terms( get_the_ID(), $taxonomy ); // Translation, Image.
		if ( ! $tax_terms ) {
			continue;
		}
		$tax_name = $tax_terms[0]->name;
		$tax_slug = $tax_terms[0]->slug;

		$tax_term['_slug']        = $tax_slug;
		$tax_term['_name']        = $tax_name;
		$tax_term['_translation'] = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'term_translation', true );
		$tax_term['_image']       = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'avatar', true );
		$tax_term['_weblink']     = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'weblink', true );
		$tax_term['_term_color']  = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'term_color', true );

		$meta[ substr( $taxonomy, 4 ) ] = array_filter( $tax_term ); // Use array_filter() to remove null values.

		unset( $tax_term );

	}

	return $meta;

}
