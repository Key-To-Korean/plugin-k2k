<?php
/**
 * JKL Vocab LIST Post Type Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Increase the number of Vocab LIST Posts displayed on archive pages.
 *
 * @param array $query The WP query.
 */
function jkl_vocab_list_more_archive_posts( $query ) {
	if ( $query->is_main_query() && is_archive() && is_post_type_archive( 'k2k-vocab-list' ) ) {
		$query->set( 'posts_per_page', '60' );
	}
}
add_action( 'pre_get_posts', 'jkl_vocab_list_more_archive_posts' );

/**
 * Enqueue Vocab LIST Post Type styles and scripts.
 */
function jkl_vocab_list_enqueue_scripts() {

	/* Vocab LIST Scripts */
	if ( 'k2k-vocab-list' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-vocab-list-style',
			plugins_url( 'css/vocab-list.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/vocab-list.css' )
		);

		if ( is_singular( 'k2k-vocab-list' ) ) {
			wp_enqueue_script(
				'k2k-vocab-list-script',
				plugins_url( 'js/vocab-list.js', __DIR__ ),
				array(),
				filemtime( plugin_dir_path( __DIR__ ) . 'js/vocab-list.js' ),
				true
			);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'jkl_vocab_list_enqueue_scripts' );

/**
 * Function to retrieve the subtitle.
 */
function get_vocab_list_subtitle() {
	return get_post_meta( get_the_ID(), 'k2k_vocab_list_meta_subtitle', true );
}

// if ( ! function_exists( 'get_vocab_part_of_speech' ) ) {
// 	/**
// 	 * Function to retrieve the (first letter of the) Part of Speech.
// 	 */
// 	function get_vocab_part_of_speech() {

// 		$ps = get_the_terms( get_the_ID(), 'k2k-vocab-part-of-speech' );

// 		if ( ! $ps ) {
// 			return '';
// 		}

// 		$tax_term['slug']        = $ps[0]->slug;
// 		$tax_term['name']        = $ps[0]->name;
// 		$tax_term['description'] = $ps[0]->description;
// 		$tax_term['translation'] = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_translation', true );
// 		$tax_term['image']       = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_avatar', true );
// 		$tax_term['weblink']     = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_weblink', true );
// 		$tax_term['color']       = get_term_meta( $ps[0]->term_id, 'k2k_taxonomy_term_term_color', true );

// 		if ( '' !== $tax_term['translation'] ) {
// 			switch ( $tax_term['translation'] ) {
// 				case '명사':
// 					$tax_term['letter'] = substr( $tax_term['translation'], 0, 3 ); // There are 3 characters that make the first syllable: ㅁㅕㅇ.
// 					break;
// 				case '동사':
// 					$tax_term['letter'] = substr( $tax_term['translation'], 0, 3 );
// 					break;
// 				case '형용사':
// 					$tax_term['letter'] = substr( $tax_term['translation'], 0, 3 );
// 					break;
// 				case '부사':
// 					$tax_term['letter'] = substr( $tax_term['translation'], 0, 2 );
// 					break;
// 				default:
// 					$tax_term['letter'] = $tax_term['translation'];
// 			}
// 		} else {
// 				$tax_term['letter'] = substr( $tax_term['name'], 0, 1 );
// 		}

// 		return $tax_term;

// 	}
// }

/**
 * Function to return all Post and Meta data for JKL Vocab LISTS Post Types in a single array.
 *
 * @return array All the Post and Meta data.
 */
function jkl_vocab_list_get_meta_data() {

	$meta = [];

	// Featured Image.
	$meta['featured_image'] = get_the_post_thumbnail_url( get_the_ID() );

	// Get post meta data.
	$meta_prefix = 'k2k_vocab_list_meta_';

	$meta['subtitle']      = get_post_meta( get_the_ID(), $meta_prefix . 'subtitle', true );      // Subtitle (translation).
	$meta['public-files']  = get_post_meta( get_the_ID(), $meta_prefix . 'public-files', true );  // Public Files (URL string).
	$meta['private-files'] = get_post_meta( get_the_ID(), $meta_prefix . 'private-files', true ); // Private Files (URL string).
	$meta['wysiwyg']   	   = get_post_meta( get_the_ID(), $meta_prefix . 'wysiwyg', true );       // WYSIWYG (HTML string).
	$meta['related']       = get_post_meta( get_the_ID(), $meta_prefix . 'related_group', true ); // Related LIST (array).
	// $meta['usage']       = get_post_meta( get_the_ID(), $meta_prefix . 'common_usage', true );  // Common Usage (array).
	// $meta['synonyms']    = get_post_meta( get_the_ID(), $meta_prefix . 'synonym_group', true ); // Synonyms (array).
	// $meta['antonyms']    = get_post_meta( get_the_ID(), $meta_prefix . 'antonym_group', true ); // Antonyms (array).
	// $meta['hanja']       = get_post_meta( get_the_ID(), $meta_prefix . 'hanja_group', true );   // Hanja (array).

	// Term Meta.
	$term_prefix      = 'k2k_taxonomy_';
	$vocab_lists_taxonomies = array(    // Taxonomy Data.
		'k2k-vocab-list-level',  		// Level (1).
		'k2k-vocab-list-book',   		// Part of Speech (1).
	);

	foreach ( $vocab_lists_taxonomies as $taxonomy ) {

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
 * Looks for taxonomy information for Level, and Book.
 *
 * @param array $meta An array of vocabulary meta data.
 * @return boolean
 */
function jkl_has_vocab_list_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocab_list_get_meta_data();
	}

	return array_key_exists( 'vocab-list-level', $meta )
		|| array_key_exists( 'vocab-list-book', $meta );

}

/**
 * Function to check for related vocab lists meta data.
 *
 * Looks for saved data for Related, Synonyms, Antonyms, and Hanja.
 *
 * @param array $meta An array of vocab lists meta data.
 * @return boolean
 */
function jkl_has_related_vocab_list_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocab_list_get_meta_data();
	}

	return array_key_exists( 'related', $meta );

}
