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
 * Enqueue Grammar Post Type styles and scripts on public facing pages.
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
 * Enqueue Grammar Post Type styles and scripts on admin pages.
 */
function jkl_grammar_enqueue_admin_scripts() {

	/* Grammar Scripts */
	if ( 'k2k-grammar' === get_post_type() ) {
		wp_enqueue_style(
			'k2k-grammar-admin-style',
			plugins_url( 'css/grammar-admin.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'css/grammar-admin.css' )
		);
	}

}
add_action( 'admin_enqueue_scripts', 'jkl_grammar_enqueue_admin_scripts' );

/**
 * Function to retrieve the subtitle.
 */
function get_grammar_subtitle() {
	return get_post_meta( get_the_ID(), 'k2k_grammar_meta_subtitle', true );
}

if ( ! function_exists( 'get_grammar_part_of_speech' ) ) {
	/**
	 * Function to retrieve the (first letter of the) Part of Speech.
	 */
	function get_grammar_part_of_speech() {

		$ps = get_the_terms( get_the_ID(), 'k2k-gramamr-part-of-speech' );

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
 * Function to return all Post and Meta data for JKL Grammar Post Types in a single array.
 *
 * @return array All the Post and Meta data.
 */
function jkl_grammar_get_meta_data() {

	$meta = [];

	// Featured Image.
	$meta['featured_image'] = get_the_post_thumbnail_url( get_the_ID() );

	// Get post meta data.
	$meta_prefix = 'k2k_grammar_meta_';

	$meta['subtitle']                 = get_post_meta( get_the_ID(), $meta_prefix . 'subtitle', true );                 // Subtitle (translation).
	$meta['video']                    = get_post_meta( get_the_ID(), $meta_prefix . 'video', true );                    // YouTube video lesson.
	$meta['wysiwyg']                  = get_post_meta( get_the_ID(), $meta_prefix . 'wysiwyg', true );                  // Explanation (html).
	$meta['adjectives']               = get_post_meta( get_the_ID(), $meta_prefix . 'adjectives', true );               // Adjective Conjugations (array).
	$meta['verbs']                    = get_post_meta( get_the_ID(), $meta_prefix . 'verbs', true );                    // Verb Conjugations (array).
	$meta['nouns']                    = get_post_meta( get_the_ID(), $meta_prefix . 'nouns', true );                    // Noun Conjugations (array).
	$meta['exercises']                = get_post_meta( get_the_ID(), $meta_prefix . 'exercises', true );                // Exercises (array).
	$meta['related_grammar']          = get_post_meta( get_the_ID(), $meta_prefix . 'related_grammar', true );          // Related Grammar Points (array).
	$meta['conjugation_note']         = get_post_meta( get_the_ID(), $meta_prefix . 'conjugation_note', true );         // Conjugation Note.
	$meta['sentences_note']           = get_post_meta( get_the_ID(), $meta_prefix . 'sentences_note', true );           // Sentences Note.
	$meta['exercises_note']           = get_post_meta( get_the_ID(), $meta_prefix . 'exercises_note', true );           // Exercises Note.
	$meta['conjugation_note_special'] = get_post_meta( get_the_ID(), $meta_prefix . 'conjugation_note_special', true ); // Conjugation Note Special.
	$meta['sentences_video']          = get_post_meta( get_the_ID(), $meta_prefix . 'sentences_video', true );                    // Sentences video (optional).

	// Special stuff.
	// Get any special conjugation rules.
	$declaratives     = get_post_meta( get_the_ID(), $meta_prefix . 'declaratives', true );         // Sentences (array).
	$interrogatives   = get_post_meta( get_the_ID(), $meta_prefix . 'interrogatives', true );       // Questions (array).
	$propositives     = get_post_meta( get_the_ID(), $meta_prefix . 'propositives', true );         // Suggestions (array).
	$imperatives      = get_post_meta( get_the_ID(), $meta_prefix . 'imperatives', true );          // Commands (array).
	$special_wysiwyg  = get_post_meta( get_the_ID(), $meta_prefix . 'special_conjugations', true ); // Special Conjugations (Wysiwyg).
	$special_dialogue = get_post_meta( get_the_ID(), $meta_prefix . 'special_dialogue', true );     // Special Dialogue (Wysiwyg).

	if ( '' !== $declaratives ) {
		$meta['special']['declaratives'] = $declaratives;
	}
	if ( '' !== $interrogatives ) {
		$meta['special']['interrogatives'] = $interrogatives;
	}
	if ( '' !== $propositives ) {
		$meta['special']['propositives'] = $propositives;
	}
	if ( '' !== $imperatives ) {
		$meta['special']['imperatives'] = $imperatives;
	}

	$meta['special_conjugations'] = get_post_meta( get_the_ID(), $meta_prefix . 'special_conjugations', true ); // Special Conjugations (Wysiwyg).
	$meta['special_dialogue']     = get_post_meta( get_the_ID(), $meta_prefix . 'special_dialogue', true );     // Special Dialogue (Wysiwyg).

	// Get the Related Grammar Points.
	$related_needs_link = get_post_meta( get_the_ID(), $meta_prefix . 'related_needs_link', true ); // Needs Link.
	$similar_grammar    = get_post_meta( get_the_ID(), $meta_prefix . 'ul_similar_grammar', true ); // Similar Grammar (unlinked).
	$opposite_grammar   = get_post_meta( get_the_ID(), $meta_prefix . 'ul_opposite_grammar', true ); // Opposite Grammar (unlinked).

	if ( '' !== $related_needs_link ) {
		$meta['related_grammar']['needs_link'] = $related_needs_link;
	}
	if ( '' !== $similar_grammar ) {
		$meta['related_grammar']['similar'] = $similar_grammar;
	}
	if ( '' !== $opposite_grammar ) {
		$meta['related_grammar']['opposite'] = $opposite_grammar;
	}

	// Get the Sentences.
	$sent_past = get_post_meta( get_the_ID(), $meta_prefix . 'sentences_past', true );    // Sentences Past (array).
	$sent_pres = get_post_meta( get_the_ID(), $meta_prefix . 'sentences_present', true ); // Sentences Present (array).
	$sent_futr = get_post_meta( get_the_ID(), $meta_prefix . 'sentences_future', true );  // Sentences Future (array).
	$sent_othr = get_post_meta( get_the_ID(), $meta_prefix . 'sentences_other', true );   // Sentences Other (array).

	// Add sentences to our meta array - if we have any.
	if ( '' !== $sent_past ) {
		$meta['sentences']['past'] = $sent_past;
	}
	if ( '' !== $sent_pres ) {
		$meta['sentences']['present'] = $sent_pres;
	}
	if ( '' !== $sent_futr ) {
		$meta['sentences']['future'] = $sent_futr;
	}
	if ( '' !== $sent_past ) {
		$meta['sentences']['other'] = $sent_othr;
	}

	// Term Meta.
	$term_prefix        = 'k2k_taxonomy_';
	$grammar_taxonomies = array( // Taxonomy Data.
		'k2k-grammar-level',          // Level (1).
		'k2k-grammar-part-of-speech', // Part of Speech (multiple).
		'k2k-grammar-expression',     // Expression (1).
		'k2k-grammar-book',           // Book (multiple).
		'k2k-grammar-tenses',         // Tenses (multiple).
		'k2k-grammar-usage',          // Usage (multiple).
	);

	foreach ( $grammar_taxonomies as $taxonomy ) {

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

	// Additional Usage meta.
	$meta_usage = get_post_meta( get_the_ID(), $meta_prefix . 'usage', true );
	if ( '' !== $meta_usage ) {
		if ( $meta_usage[0][ $meta_prefix . 'usage_mu' ] ) {
			$meta['usage']['must_use'] = $meta_usage[0][ $meta_prefix . 'usage_mu' ];
		}
		if ( $meta_usage[0][ $meta_prefix . 'usage_no' ] ) {
			$meta['usage']['prohibited'] = $meta_usage[0][ $meta_prefix . 'usage_no' ];
		}
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

/**
 * Function to retrieve the color assigned for a taxonomy term.
 *
 * @return array An array of color strings distinguished by term name.
 */
function get_part_of_speech_term_color() {

	$parts_of_speech = array();
	$tax_terms       = get_terms( array( 'taxonomy' => 'k2k-grammar-part-of-speech' ) ); // Get ALL part of speech colors, not just for current post.
	// get_the_terms( get_the_ID(), 'k2k-part-of-speech' ); // Translation, Image, Weblink, or Term Color.

	// If there are no terms saved for this taxonomy, move on to the next one.
	if ( ! $tax_terms ) {
		return 'No colors found';
	}

	foreach ( $tax_terms as $tax_term ) {
		$parts_of_speech[ strtolower( $tax_term->name ) ] = get_term_meta( $tax_term->term_id, 'k2k_taxonomy_term_color', true );
	}

	return $parts_of_speech;

}
