<?php
/**
 * JKL Reading Post Type Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Reading Post Type styles and scripts on public facing pages.
 */
function jkl_reading_enqueue_scripts() {

	/* Reading Scripts */
	if ( 'k2k-reading' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-reading-style',
			plugins_url( 'css/reading.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/reading.css' )
		);

		if ( is_singular( 'k2k-reading' ) ) {
			wp_enqueue_script(
				'k2k-reading-script',
				plugins_url( 'js/reading.js', __DIR__ ),
				array(),
				filemtime( plugin_dir_path( __DIR__ ) . 'js/reading.js' ),
				true
			);

			wp_enqueue_script(
				'k2k-papago-script',
				plugins_url( 'js/papago.js', __DIR__ ),
				array( 'jquery' ),
				filemtime( plugin_dir_path( __DIR__ ) . 'js/papago.js' ),
				true
			);

			wp_localize_script(
				'k2k-papago-script',
				'translate',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'action'  => 'jkl_papago_dictionary_lookup',
					'nonce'   => wp_create_nonce( 'translate_nonce' ),
				)
			);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'jkl_reading_enqueue_scripts' );

/**
 * Enqueue Reading Post Type styles and scripts on admin pages.
 */
function jkl_reading_enqueue_admin_scripts() {

	/* Reading Scripts */
	if ( 'k2k-reading' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-reading-admin-style',
			plugins_url( 'css/reading-admin.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/reading-admin.css' )
		);
	}

}
add_action( 'admin_enqueue_scripts', 'jkl_reading_enqueue_admin_scripts' );

/**
 * Function to retrieve the subtitle.
 */
function get_reading_subtitle() {
	return get_post_meta( get_the_ID(), 'k2k_reading_meta_subtitle', true );
}

/**
 * Function to return all Post and Meta data for JKL Reading Post Types in a single array.
 *
 * @return array All the Post and Meta data.
 */
function jkl_reading_get_meta_data() {

	$meta = [];

	// Featured Image.
	$meta['featured_image'] = get_the_post_thumbnail_url( get_the_ID() );

	// Get post meta data.
	$meta_prefix = 'k2k_reading_meta_';

	$meta['subtitle']   = get_post_meta( get_the_ID(), $meta_prefix . 'subtitle', true );        // Subtitle (translation).
	$meta['video']      = get_post_meta( get_the_ID(), $meta_prefix . 'video', true );           // YouTube video lesson.
	$meta['wysiwyg_ko'] = get_post_meta( get_the_ID(), $meta_prefix . 'wysiwyg_ko', true );      // Korean Text (html).
	$meta['wysiwyg_en'] = get_post_meta( get_the_ID(), $meta_prefix . 'wysiwyg_en', true );      // English Translation (html).
	$meta['questions']  = get_post_meta( get_the_ID(), $meta_prefix . 'questions', true ); // Questions (array).

	// Term Meta.
	$term_prefix        = 'k2k_taxonomy_';
	$reading_taxonomies = array( // Taxonomy Data.
		'k2k-reading-level',       // Level (1).
		'k2k-reading-genre',       // Genre (multiple).
		'k2k-reading-topic',       // Topic (multiple).
		'k2k-reading-type',        // Type (1).
		'k2k-reading-source',      // Source (multiple).
		'k2k-reading-author',      // Author (multiple).
		'k2k-reading-length',      // Length (1).
	);

	foreach ( $reading_taxonomies as $taxonomy ) {

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
 * Function to check for saved reading meta data.
 *
 * Looks for taxonomy information for Level, Genre, Topic, Type, Source, and Author.
 *
 * @param array $meta An array of reading meta data.
 * @return boolean
 */
function jkl_has_reading_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_reading_get_meta_data();
	}

	return array_key_exists( 'level', $meta )
		|| array_key_exists( 'genre', $meta )
		|| array_key_exists( 'topic', $meta )
		|| array_key_exists( 'type', $meta )
		|| array_key_exists( 'source', $meta )
		|| array_key_exists( 'author', $meta );

}

/**
 * Function to check for related reading meta data.
 *
 * Looks for saved data for Related.
 *
 * @param array $meta An array of reading meta data.
 * @return boolean
 */
function jkl_has_related_reading_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_reading_get_meta_data();
	}

	return array_key_exists( 'related', $meta );

}

/**
 * Filter the Post content of Reading type posts to add a <span> tag around each word.
 * We will call on the Naver dictionary API to look it up and show a popup if clicked.
 *
 * @param String $ko_content The content to be filtered.
 */
function jkl_filter_content_with_span( $ko_content ) {

	$ko_content = strip_tags( $ko_content, '' );

	// Check the Post type and if singular().
	if ( is_singular() ) {
		$word_array   = explode( ' ', $ko_content );
		$span_content = '';

		// We could run into problems with HTML tags though...
		foreach ( $word_array as $word ) {
			if ( 'http' === substr( $word, 0, 4 ) ) {
				$span_content .= '<a href="' . $word . '">' . $word . '</a>';
			} else {
				$span_content .= '<span class="dict-word">' . $word . '</span> ';
			}
		}

		return $span_content;
	}

	return $ko_content;
}
// add_filter( 'the_content', 'jkl_filter_content_with_span' );.

/**
 * Papago Dictionary Lookup.
 *
 * Using wp_localize_script (above) and an AJAX call in the papago.js file.
 */
function jkl_papago_dictionary_lookup() {

	// Make sure our nonce (created in wp_localize_script above) matches, or die.
	if ( ! check_ajax_referer( 'translate_nonce', 'nonce' ) ) {
		wp_send_json_error();
		die();
	}

	// This is the variable we are sending through JavaScript AJAX to PHP.
	$word = isset( $_POST['word'] ) ? $_POST['word'] : ''; // phpcs:ignore

	$client_id     = 'GWOb896dIGIFUwHFiimd'; // Set these up elsewhere (secret).
	$client_secret = 'tLZGH0tcVV';           // Set these up elsewhere (secret).
	$enc_text      = rawurlencode( $word );
	$postvars      = 'source=ko&target=en&text=' . $enc_text;
	$url           = 'https://openapi.naver.com/v1/papago/n2mt';
	$is_post       = true;
	$ch            = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_POST, $is_post );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $postvars );
	$headers   = array();
	$headers[] = 'X-Naver-Client-Id: ' . $client_id;
	$headers[] = 'X-Naver-Client-Secret: ' . $client_secret;
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
	$response    = curl_exec( $ch );
	$status_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
	$deco        = json_decode( $response, false );
	curl_close( $ch );

	// This is the response we send back to JavaScript.
	// When we do console.log(res) in JS, this is what we see.
	if ( 200 === $status_code ) {
		echo esc_html( $deco->message->result->translatedText );
	} else {
		echo 'Error 내용:' . esc_attr( $response );
	}
}
add_action( 'wp_ajax_jkl_papago_dictionary_lookup', 'jkl_papago_dictionary_lookup' );
add_action( 'wp_ajax_nopriv_jkl_papago_dictionary_lookup', 'jkl_papago_dictionary_lookup' );
