<?php
/**
 * JKL Writing Post Type Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Writing Post Type styles and scripts on public facing pages.
 */
function jkl_writing_enqueue_scripts() {

	/* Writing Scripts */
	if ( 'k2k-writing' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-writing-style',
			plugins_url( 'css/writing.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/writing.css' )
		);

		if ( is_singular( 'k2k-writing' ) ) {
			wp_enqueue_script(
				'k2k-writing-script',
				plugins_url( 'js/writing.js', __DIR__ ),
				array(),
				filemtime( plugin_dir_path( __DIR__ ) . 'js/writing.js' ),
				true
			);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'jkl_writing_enqueue_scripts' );

/**
 * Enqueue Writing Post Type styles and scripts on admin pages.
 */
function jkl_writing_enqueue_admin_scripts() {

	/* Writing Scripts */
	if ( 'k2k-writing' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-writing-admin-style',
			plugins_url( 'css/writing-admin.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/writing-admin.css' )
		);
	}

}
add_action( 'admin_enqueue_scripts', 'jkl_writing_enqueue_admin_scripts' );

/**
 * Function to retrieve the subtitle.
 */
function get_writing_subtitle() {
	return get_post_meta( get_the_ID(), 'k2k_writing_meta_subtitle', true );
}

/**
 * Function to return all Post and Meta data for JKL Writing Post Types in a single array.
 *
 * @return array All the Post and Meta data.
 */
function jkl_writing_get_meta_data() {

	$meta = [];

	// Featured Image.
	$meta['featured_image'] = get_the_post_thumbnail_url( get_the_ID() );

	// Get post meta data.
	$meta_prefix = 'k2k_writing_meta_';

	$meta['short_group']  = get_post_meta( get_the_ID(), $meta_prefix . 'short_group', true );  // Short Group (array).
	$meta['medium_group'] = get_post_meta( get_the_ID(), $meta_prefix . 'medium_group', true ); // Medium Group (array).
	$meta['long_group']   = get_post_meta( get_the_ID(), $meta_prefix . 'long_group', true );   // Long Group (array).

	// Term Meta.
	$term_prefix        = 'k2k_taxonomy_';
	$writing_taxonomies = array( // Taxonomy Data.
		'k2k-writing-level',       // Level (1).
		'k2k-writing-topic',       // Topic (multiple).
		'k2k-writing-type',        // Type (1).
		'k2k-writing-length',      // Length (1).
		'k2k-writing-source',      // Source (multiple).
	);

	foreach ( $writing_taxonomies as $taxonomy ) {

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

/**
 * Function to check for saved writing meta data.
 *
 * Looks for taxonomy information for Level, Genre, Topic, Type, Source, and Author.
 *
 * @param array $meta An array of writing meta data.
 * @return boolean
 */
function jkl_has_writing_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_writing_get_meta_data();
	}

	return array_key_exists( 'level', $meta )
		|| array_key_exists( 'topic', $meta )
		|| array_key_exists( 'type', $meta )
		|| array_key_exists( 'source', $meta )
		|| array_key_exists( 'length', $meta );

}

/**
 * Function to check for related writing meta data.
 *
 * Looks for saved data for Related.
 *
 * @param array $meta An array of writing meta data.
 * @return boolean
 */
function jkl_has_related_writing_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_writing_get_meta_data();
	}

	return array_key_exists( 'related', $meta );

}
