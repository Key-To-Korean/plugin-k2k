<?php
/**
 * Import Vocabulary from JSON file.
 *
 * @package K2K
 *
 * Our Vocabulary JSON data looks like this:
	{
		"ranking": 1195,     // none yet
		"id": 1,
		"korean": "가게",     // post title
		"origin": "",        // hanja
		"english": "Store",  // subtitle
		"partOfSpeech": "명", // part-of-speech (terms)
		"level": "A",        // level (terms)
		"sentences": [       // sentences_ko (or none - this is the only entry with this)
			"언니의 가게에서 샀어요.",
			"꽃가게가 어디 있어요?"
		]
	}
 * @link https://codeable.io/how-to-import-json-into-wordpress/
 * @link https://wordpress.org/support/topic/insert-custom-post-via-json/
 * @link https://wordpress.stackexchange.com/questions/211908/importing-third-party-json-feed-as-custom-post-type
 */

add_action( 'wp_ajax_import_k2k_vocabulary', 'import_k2k_vocabulary' );
add_action( 'wp_ajax_nopriv_import_k2k_vocabulary', 'import_k2k_vocabulary' );

/**
 * Import Vocabulary from JSON data.
 */
function import_k2k_vocabulary() {

	// Get file.
	$data = json_decode( file_get_contents( 'php://input' ) );

	if ( compare_keys() ) {
		insert_or_update( $data );
	}

	wp_die();

}

/**
 * Security function to be sure we CAN perform this action.
 *
 * @throws Exception If the header is missing or if the $hash doesn't match.
 */
function compare_keys() {

	// Signature should be in a form of algorithm=hash
	// for example: X-K2K-Signature: sha1=246d2e58593645b1f261b1bbc867fe2a9fc1a682.
	if ( ! isset( $_SERVER['HTTP_X_K2K_SIGNATURE'] ) ) {
		throw new Exception( "HTTP header 'X-K2K-Signature' is missing." );
	}

	list( $algo, $hash ) = explode( '=', $_SERVER['HTTP_X_K2K_SIGNATURE'], 2 ) + array( '', '' ); // phpcs:ignore
	$raw_post            = file_get_contents( 'php://input' );

	// Don't forget to define the key!
	if ( hash_hmac( $algo, $raw_post, K2K_KEY ) !== $hash ) {
		throw new Exception( 'Secret hash does not match.' );
	}

	return true;

}

/**
 * Function to either insert data into WordPress or update a pre-existing post.
 *
 * @param string $data The string of JSON data we are working with.
 */
function insert_or_update( $data ) {

	if ( ! $data ) {
		return false;
	}

	// Search by the custom field 'developer_id' which stores the id of
	// the object that is stored in the external service.
	$args = array(
		'meta_query'     => array(
			array(
				'key'   => 'vocabulary_id',
				'value' => $data->id,
			),
		),
		'post_type'      => 'k2k-vocabulary',
		'post_status'    => array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit' ),
		'posts_per_page' => 1,
	);

	$vocabulary    = get_posts( $args );
	$vocabulary_id = '';

	if ( $vocabulary ) {
		$vocabulary_id = $vocabulary[0]->ID;
	}

	$vocabulary_post = array(
		'ID'           => $vocabulary_id,
		'post_title'   => $data->korean,
		'post_content' => '',
		'post_type'    => 'k2k-vocabulary',
		// If $vocabulary exists, reuse its post status.
		'post_status'  => ( $vocabulary ) ? $vocabulary[0]->post_status : 'publish',
	);

	$vocabulary_id = wp_insert_post( $vocabulary_post );

	if ( $vocabulary_id ) {

		update_post_meta( $vocabulary_id, 'vocabulary_id', $data->id );
		update_post_meta( $vocabulary_id, 'json', addslashes( file_get_contents( 'php://input' ) ) ); // update post meta.
		wp_set_object_terms( $vocabulary_id, $data->tags, 'vocabulary_tag' ); // update post terms.

	}

	print_r( $vocabulary_id );

}
