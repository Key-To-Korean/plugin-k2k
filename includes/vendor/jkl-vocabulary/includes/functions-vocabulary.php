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

	// Featured Image.
	$meta['featured_image'] = get_the_post_thumbnail_url( get_the_ID() );

	// Get post meta data.
	$meta_prefix = 'k2k_vocab_meta_';

	$meta['subtitle']    = get_post_meta( get_the_ID(), $meta_prefix . 'subtitle', true );      // Subtitle (translation).
	$meta['definitions'] = get_post_meta( get_the_ID(), $meta_prefix . 'definitions', true );   // Definitions (array).
	$meta['sentences']   = get_post_meta( get_the_ID(), $meta_prefix . 'sentences', true );     // Sentences (array).
	$meta['usage']       = get_post_meta( get_the_ID(), $meta_prefix . 'common_usage', true );  // Common Usage (array).
	$meta['related']     = get_post_meta( get_the_ID(), $meta_prefix . 'related_group', true ); // Related Words (array).
	$meta['synonyms']    = get_post_meta( get_the_ID(), $meta_prefix . 'synonym_group', true ); // Synonyms (array).
	$meta['antonyms']    = get_post_meta( get_the_ID(), $meta_prefix . 'antonym_group', true ); // Antonyms (array).
	$meta['hanja']       = get_post_meta( get_the_ID(), $meta_prefix . 'hanja_group', true );   // Hanja (array).

	// Term Meta.
	$term_prefix      = 'k2k_taxonomy_';
	$vocab_taxonomies = array( // Taxonomy Data.
		'k2k-level',             // Level (1).
		'k2k-part-of-speech',    // Part of Speech (1).
		'k2k-topic',             // Topic.
		'k2k-vocab-group',       // Vocab Group.
	);

	foreach ( $vocab_taxonomies as $taxonomy ) {

		$tax_terms = get_the_terms( get_the_ID(), $taxonomy ); // Translation, Image, Weblink, or Term Color.

		// If there are no terms saved for this taxonomy, move on to the next one.
		if ( ! $tax_terms ) {
			continue;
		}

		$tax_term['slug']        = $tax_terms[0]->slug;
		$tax_term['name']        = $tax_terms[0]->name;
		$tax_term['description'] = $tax_terms[0]->description;
		$tax_term['translation'] = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'term_translation', true );
		$tax_term['image']       = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'avatar', true );
		$tax_term['weblink']     = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'weblink', true );
		$tax_term['term_color']  = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'term_color', true );

		$meta[ substr( $taxonomy, 4 ) ] = array_filter( $tax_term ); // Use array_filter() to remove null values.

		unset( $tax_term );

	}

	return array_filter( $meta ); // Use array_filter() to remove null values.

}

/**
 * Function to check for saved vocabulary meta data.
 *
 * Looks for taxonomy information for Level, Part of Speech, Topic, and Vocab Group.
 *
 * @param array $meta An array of vocabulary meta data.
 * @return boolean
 */
function jkl_has_vocabulary_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocabulary_get_meta_data();
	}

	return array_key_exists( 'level', $meta )
		|| array_key_exists( 'part-of-speech', $meta )
		|| array_key_exists( 'topic', $meta )
		|| array_key_exists( 'vocab-group', $meta );

}

/**
 * Function to check for related vocabulary meta data.
 *
 * Looks for saved data for Related, Synonyms, Antonyms, and Hanja.
 *
 * @param array $meta An array of vocabulary meta data.
 * @return boolean
 */
function jkl_has_related_vocabulary_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocabulary_get_meta_data();
	}

	return array_key_exists( 'related', $meta )
		|| array_key_exists( 'synonyms', $meta )
		|| array_key_exists( 'antonyms', $meta )
		|| array_key_exists( 'hanja', $meta );

}
