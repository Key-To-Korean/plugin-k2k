<?php
/**
 * JKL Grammar Post Type Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Grammar Post Type styles and scripts.
 */
function jkl_grammar_enqueue_scripts() {

	/* Grammar Scripts */
	if ( 'k2k-grammar' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-grammar-style',
			plugins_url( 'css/grammar.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/grammar.css' )
		);

		if ( is_singular( 'k2k-grammar' ) ) {
			wp_enqueue_script(
				'k2k-grammar-script',
				plugins_url( 'js/grammar.js', __DIR__ ),
				array(),
				filemtime( plugin_dir_path( __DIR__ ) . 'js/grammar.js' ),
				true
			);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'jkl_grammar_enqueue_scripts' );

/**
 * Function to retrieve the subtitle.
 */
function get_grammar_subtitle() {
	return get_post_meta( get_the_ID(), 'k2k_grammar_meta_subtitle', true );
}

if ( ! function_exists( 'get_part_of_speech' ) ) {
	/**
	 * Function to retrieve the (first letter of the) Part of Speech.
	 */
	function get_part_of_speech() {

		$ps = get_the_terms( get_the_ID(), 'k2k-part-of-speech' );

		if ( ! $ps ) {
			return '';
		}

		$tax_term['slug']        = $ps[0]->slug;
		$tax_term['name']        = $ps[0]->name;
		$tax_term['description'] = $ps[0]->description;
		$tax_term['translation'] = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_translation', true );
		$tax_term['image']       = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_avatar', true );
		$tax_term['weblink']     = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_weblink', true );
		$tax_term['color']       = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_term_color', true );

		if ( '' !== $tax_term['translation'] ) {
			switch ( $tax_term['translation'] ) {
				case '명사':
					$tax_term['letter'] = substr( $tax_term['translation'], 0, 3 ); // There are 3 characters that make the first syllable: ㅁㅕㅇ.
					break;
				case '동사':
					$tax_term['letter'] = substr( $tax_term['translation'], 0, 3 );
					break;
				case '형용사':
					$tax_term['letter'] = substr( $tax_term['translation'], 0, 3 );
					break;
				case '부사':
					$tax_term['letter'] = substr( $tax_term['translation'], 0, 2 );
					break;
				default:
					$tax_term['letter'] = $tax_term['translation'];
			}
		} else {
				$tax_term['letter'] = substr( $tax_term['name'], 0, 1 );
		}

		return $tax_term;

	}
}

/**
 * Function to return all Post and Meta data for JKL grammar Post Types in a single array.
 *
 * @return array All the Post and Meta data.
 */
function jkl_grammar_get_meta_data() {

	$meta = [];

	// Featured Image.
	$meta['featured_image'] = get_the_post_thumbnail_url( get_the_ID() );

	// Get post meta data.
	$meta_prefix = 'k2k_grammar_meta_';

	$meta['subtitle']        = get_post_meta( get_the_ID(), $meta_prefix . 'subtitle', true );        // Subtitle (translation).
	$meta['wysiwyg']         = get_post_meta( get_the_ID(), $meta_prefix . 'wysiwyg', true );         // Explanation (html).
	$meta['adjectives']      = get_post_meta( get_the_ID(), $meta_prefix . 'adjectives', true );      // Adjective Conjugations (array).
	$meta['verbs']           = get_post_meta( get_the_ID(), $meta_prefix . 'verbs', true );           // Verb Conjugations (array).
	$meta['nouns']           = get_post_meta( get_the_ID(), $meta_prefix . 'nouns', true );           // Noun Conjugations (array).
	$meta['sentences']       = get_post_meta( get_the_ID(), $meta_prefix . 'sentences', true );       // Sentences (array).
	$meta['exercises']       = get_post_meta( get_the_ID(), $meta_prefix . 'exercises', true );       // Exercises (array).
	$meta['related_grammar'] = get_post_meta( get_the_ID(), $meta_prefix . 'related_grammar', true ); // Related Grammar Points (array).

	// Term Meta.
	$term_prefix        = 'k2k_taxonomy_';
	$grammar_taxonomies = array( // Taxonomy Data.
		'k2k-level',             // Level (1).
		'k2k-part-of-speech',    // Part of Speech (multiple).
		'k2k-expression',        // Expression (1).
		'k2k-book',              // Book (multiple).
		'k2k-tenses',            // Tenses (multiple).
		'k2k-usage',             // Usage (multiple?).
		'k2k-phrase-type',       // Phrase Type.
	);

	foreach ( $grammar_taxonomies as $taxonomy ) {

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
 * Function to check for saved grammar meta data.
 *
 * Looks for taxonomy information for Level, Part of Speech, Topic, and Vocab Group.
 *
 * @param array $meta An array of grammar meta data.
 * @return boolean
 */
function jkl_has_grammar_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_grammar_get_meta_data();
	}

	return array_key_exists( 'level', $meta )
		|| array_key_exists( 'part-of-speech', $meta )
		|| array_key_exists( 'topic', $meta )
		|| array_key_exists( 'vocab-group', $meta );

}

/**
 * Function to check for related grammar meta data.
 *
 * Looks for saved data for Related, Synonyms, Antonyms, and Hanja.
 *
 * @param array $meta An array of grammar meta data.
 * @return boolean
 */
function jkl_has_related_grammar_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_grammar_get_meta_data();
	}

	return array_key_exists( 'related', $meta )
		|| array_key_exists( 'synonyms', $meta )
		|| array_key_exists( 'antonyms', $meta )
		|| array_key_exists( 'hanja', $meta );

}
