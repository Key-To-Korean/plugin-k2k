<?php
/**
 * JKL Phrases Post Type Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Phrases Post Type styles and scripts on public facing pages.
 */
function jkl_phrases_enqueue_scripts() {

	/* Phrases Scripts */
	if ( 'k2k-phrases' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-phrases-style',
			plugins_url( 'css/phrases.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/phrases.css' )
		);

		if ( is_singular( 'k2k-phrases' ) ) {
			wp_enqueue_script(
				'k2k-phrases-script',
				plugins_url( 'js/phrases.js', __DIR__ ),
				array(),
				filemtime( plugin_dir_path( __DIR__ ) . 'js/phrases.js' ),
				true
			);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'jkl_phrases_enqueue_scripts' );

/**
 * Enqueue Phrases Post Type styles and scripts on admin pages.
 */
function jkl_phrases_enqueue_admin_scripts() {

	/* Phrases Scripts */
	if ( 'k2k-phrases' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-phrases-admin-style',
			plugins_url( 'css/phrases-admin.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/phrases-admin.css' )
		);
	}

}
add_action( 'admin_enqueue_scripts', 'jkl_phrases_enqueue_admin_scripts' );

/**
 * Function to retrieve the subtitle.
 */
function get_phrases_subtitle() {
	return get_post_meta( get_the_ID(), 'k2k_phrases_meta_subtitle', true );
}

/**
 * Function to return all Post and Meta data for JKL Phrases Post Types in a single array.
 *
 * @return array All the Post and Meta data.
 */
function jkl_phrases_get_meta_data() {

	$meta = [];

	// Featured Image.
	$meta['featured_image'] = get_the_post_thumbnail_url( get_the_ID() );

	// Get post meta data.
	$meta_prefix = 'k2k_phrase_meta_';

	$meta['translation'] = get_post_meta( get_the_ID(), $meta_prefix . 'translation', true );     // Translation.
	$meta['meaning']     = get_post_meta( get_the_ID(), $meta_prefix . 'meaning', true );         // Meaning.
	$meta['wysiwyg']     = get_post_meta( get_the_ID(), $meta_prefix . 'wysiwyg', true );         // Explanation (html).
	// $meta['related_phrases'] = get_post_meta( get_the_ID(), $meta_prefix . 'related_phrases', true ); // Related Phrases (array).

	// Term Meta.
	$term_prefix        = 'k2k_taxonomy_';
	$phrases_taxonomies = array( // Taxonomy Data.
		'k2k-expression',        // Expression (1).
		'k2k-topic',             // Book (multiple).
		'k2k-phrase-type',       // Phrase Type.
	);

	foreach ( $phrases_taxonomies as $taxonomy ) {

		$tax_terms = get_the_terms( get_the_ID(), $taxonomy ); // Translation, Image, Weblink, or Term Color.

		// If there are no terms saved for this taxonomy, move on to the next one.
		if ( ! $tax_terms ) {
			continue;
		}

		foreach ( $tax_terms as $tax_term ) {

			$tt['slug']        = $tax_term->slug;
			$tt['name']        = $tax_term->name;
			$tt['description'] = $tax_term->description;
			$tt['translation'] = get_term_meta( $tax_term->term_id, $term_prefix . 'term_translation', true );
			$tt['image']       = get_term_meta( $tax_term->term_id, $term_prefix . 'avatar', true );
			$tt['weblink']     = get_term_meta( $tax_term->term_id, $term_prefix . 'weblink', true );
			$tt['term_color']  = get_term_meta( $tax_term->term_id, $term_prefix . 'term_color', true );

			$meta[ substr( $taxonomy, 4 ) ][] = array_filter( $tt ); // Use array_filter() to remove null values.

			unset( $tt );

		}
	}

	return array_filter( $meta ); // Use array_filter() to remove null values.

}
