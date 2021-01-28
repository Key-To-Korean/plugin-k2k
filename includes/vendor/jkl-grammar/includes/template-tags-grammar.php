<?php
/**
 * JKL Grammar Template Tags.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Search Form for Grammar Post Type.
 */
function display_grammar_search_form() {
	?>
	<form action="/" method="get" class="grammar-search k2k-search">
		<label for="search" class="screen-reader-text"><?php esc_html_e( 'Search Grammar', 'k2k' ); ?></label>
		<input type="text" name="s" id="search" placeholder="<?php esc_html_e( 'Search Grammar', 'k2k' ); ?>" value="<?php the_search_query(); ?>" />
		<!-- <input type="submit" value="<?php esc_html_e( 'Search', 'k2k' ); ?>" /> -->
		<input type="hidden" value="k2k-grammar" name="post_type" id="post_type" />
	</form>
	<?php
}

/**
 * Custom navigation for Grammar Post Type.
 *
 * Default Taxonomy is 'Level' - but can pass in a different taxonomy if desired.
 * Possible taxonomies for Grammar are 'Level', 'Book', 'Part of Speech', 'Expression', 'Usage', 'Phrase Type'.
 *
 * @param string $taxonomy The taxonomy to display post navigation for.
 */
function display_grammar_navigation( $taxonomy = 'k2k-grammar-level' ) {
	?>
	<nav id="nav-above" class="navigation post-navigation grammar-navigation" role="navigation">
		<p class="screen-reader-text"><?php esc_html_e( 'Grammar Navigation', 'k2k' ); ?></p>
		<div class="nav-index">
			<span class="meta-nav"><a href="<?php echo esc_url( get_home_url() ) . '/grammar/'; ?>"><?php esc_html_e( 'Grammar Index', 'k2k' ); ?></a></span>
		</div>
		<div class="nav-links">
			<div class="nav-previous">
				<?php previous_post_link( '%link', '&#9668; %title', true, '', $taxonomy ); ?>
			</div>
			<div class="nav-next">
				<?php next_post_link( '%link', '%title &#9658;', true, '', $taxonomy ); ?>
			</div>
		</div>
	</nav><!-- #nav-above -->
	<?php
}

/**
 * Function to display a custom cropped thumbnail for Grammar Posts.
 */
function display_grammar_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail grammar-thumbnail" style="background: url(<?php the_post_thumbnail_url(); ?>)">
		</div><!-- .post-thumbnail -->

		<?php
	endif;
}

/**
 * Function to embed and display the post video, if it exists.
 *
 * @param string $url The URL of the video link.
 */
function display_grammar_video( $url ) {

	if ( '' === $url ) {
		return;
	}

	$embed_code = wp_oembed_get(
		$url,
		array(
			'width'  => 1000,
			'height' => 600,
		)
	);
	?>

	<div class="post-thumbnail post-video">
		<?php echo $embed_code; // phpcs:ignore ?>
	</div>

	<?php
}

/**
 * Function to display the entry meta for the Grammar Post.
 *
 * @param array $meta The post meta.
 */
function display_grammar_entry_meta( $meta ) {

	// Level.
	if ( array_key_exists( 'grammar-level', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list grammar-level-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Level: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-grammar-level' );
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-stars">';
		display_level_stars( 'grammar' );
		echo '</li>';
		echo '</ul>';
	}

	// Book.
	if ( array_key_exists( 'grammar-book', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list grammar-book-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Book: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-grammar-book' );
		echo '</ul>';
	}

	// Expression.
	if ( array_key_exists( 'grammar-expression', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list grammar-expression-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Expressing: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-grammar-expression' );
		echo '</ul>';
	}

	// Part of Speech.
	if ( array_key_exists( 'grammar-part-of-speech', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list grammar-part-of-speech-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Parts of Speech: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-grammar-part-of-speech' );
		echo '</ul>';
	}

	// Usage.
	if ( array_key_exists( 'grammar-usage', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list grammar-usage-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Usage: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-grammar-usage' );
		echo '</ul>';
	}

	// Post Edit Link.
	gaya_edit_post_link();

}

/**
 * Display a broken link icon if there is a related grammar point that needs linked.
 *
 * @param array $meta The post meta.
 */
function display_grammar_needs_link( $meta ) {
	if ( array_key_exists( 'related_grammar', $meta ) && array_key_exists( 'k2k_grammar_meta_related_needs_link', $meta['related_grammar'][0] ) ) {
		echo ' <i class="fas fa-unlink" title="' . esc_attr( 'Related grammar point needs link', 'k2k' ) . '"></i>';
	}
}

/**
 * Display a list of related grammar points if there are any.
 *
 * @param array $meta The post meta.
 */
function display_grammar_related_points( $meta ) {

	if ( array_key_exists( 'related_grammar', $meta ) && array_key_exists( 'k2k_grammar_meta_related_grammar_points', $meta['related_grammar'][0] ) ) {
		?>
		<div class="entry-meta">
			<ul class="related-grammar">
				<li class="related-grammar-title"><?php esc_html_e( 'See also:', 'k2k' ); ?></li>
				<?php
				foreach ( $meta['related_grammar'][0]['k2k_grammar_meta_related_grammar_points'] as $related ) {
					$related_post = get_post( $related );
					echo '<li class="related-term linked">';
					echo '<a class="tag-button" rel="tag" href="' . esc_url( get_the_permalink( $related_post->ID ) ) . '">' . esc_html( $related_post->post_title ) . '</a>';
					echo '</li>';
				}
				?>
			</ul>
		</div>
		<?php
	}

}

/**
 * Function to add Notes under various areas.
 *
 * @param array  $meta Array containing post meta data.
 * @param String $note The string of the array key for the note.
 */
function add_grammar_note( $meta, $note ) {
	if ( array_key_exists( $note, $meta ) ) {
		?>
		<p class="grammar-note <?php echo esc_attr( str_replace( '_', '-', $note ) ); ?>">
			<span class="note-text"><span class="red-text">* </span><?php esc_attr_e( 'Note: ', 'k2k' ); ?></span>
			<?php echo wp_kses_post( $meta[ $note ] ); ?>
		</p>
		<?php
	}
}

/**
 * Function to construct a simple table with verb conjugations.
 *
 * @param array $meta Array containing post meta data.
 */
function build_conjugation_table( $meta ) {

	$conjugations = [];

	if ( array_key_exists( 'adjectives', $meta ) ) {
		$conjugations['adjectives'] = $meta['adjectives'];
	}
	if ( array_key_exists( 'verbs', $meta ) ) {
		$conjugations['verbs'] = $meta['verbs'];
	}
	if ( array_key_exists( 'nouns', $meta ) ) {
		$conjugations['nouns'] = $meta['nouns'];
	}

	if ( empty( $conjugations ) ) {
		return;
	}

	echo '<h3 class="conjugations-title">' . esc_html__( 'Conjugation Table', 'k2k' ) . '</h3>';

	// Check where the Note is (if it exists).
	if ( '' !== get_post_meta( get_the_ID(), 'k2k_grammar_meta_conjugation_note_position', true ) ) {
		add_grammar_note( $meta, 'conjugation_note' );
	}

	echo '<table class="grammar-conjugations">';
	$ps_keys = array_keys( $conjugations );

	$count = 0;
	foreach ( $conjugations as $part_of_speech ) :
		$classname = 's' === substr( $ps_keys[ $count ], -1 ) ? substr( $ps_keys[ $count ], 0, -1 ) : $ps_keys[ $count ];
		?>

		<tr class="part-of-speech-conjugation">
			<th rowspan="<?php echo count( $part_of_speech[0] ); ?>" class="<?php echo esc_attr( $ps_keys[ $count ] ); ?>">
				<span class="part-of-speech <?php echo esc_attr( $classname ); ?>" title="<?php echo esc_html( ucwords( $ps_keys[ $count ] ) ); ?>">
					<?php echo esc_html( ucwords( substr( $ps_keys[ $count ], 0, 1 ) ) ); ?>
				</span>
			</th>

		<?php

		$items = 1;
		$size  = count( $part_of_speech[0] );
		foreach ( $part_of_speech[0] as $key => $value ) :
			$name = explode( '_', $key );
			?>

				<td><?php echo esc_html( ucwords( $name[ count( $name ) - 1 ] ) ); ?></td>
				<td><?php echo esc_html( $value ); ?></td>

			<?php
			if ( $items !== $size ) {
				echo '</tr><tr>';
			}

			$items++;
		endforeach;

		echo '</tr>';

		$count++;
	endforeach;

	echo '</table>';

	if ( array_key_exists( 'special_conjugations', $meta ) ) {
		echo wp_kses_post( $meta['special_conjugations'] );
	}

	// Add Conjugation Note if one exists.
	if ( '' === get_post_meta( get_the_ID(), 'k2k_grammar_meta_conjugation_note_position', true ) ) {
		add_grammar_note( $meta, 'conjugation_note' );
	}

}

/**
 * Function to return a list of usages.
 *
 * @param array $meta An string of usages separated by commas.
 */
function get_unlinked_usages( $meta ) {

	// If this is a list of terms, output them separately.
	if ( strpos( $meta, ',' ) ) {

		$output = '';

		$items = explode( ', ', $meta );
		foreach ( $items as $item ) {
			$output .= '<li class="usage-item">' . $item . '</li>';
		}

		return $output;

	} else {
		return '<li>' . $meta . '</li>';
	}

}

/**
 * Function to output the related data at the bottom of the vocabulary post.
 *
 * @param array $meta An array of vocabulary meta data.
 */
function display_grammar_usage_rules( $meta ) {

	$usage_rules = [];

	if ( ! array_key_exists( 'usage', $meta ) ) {
		return;
	}

	if ( array_key_exists( 'must_use', $meta['usage'] ) ) {
		$usage_rules['must_use'] = $meta['usage']['must_use'];
	}
	if ( array_key_exists( 'prohibited', $meta['usage'] ) ) {
		$usage_rules['prohibited'] = $meta['usage']['prohibited'];
	}

	if ( empty( $usage_rules ) ) {
		return;
	}

	echo '<h3>' . esc_html__( 'Usage Rules', 'k2k' ) . '</h3>';
	echo '<div class="usage-rules-container entry-footer">';

	foreach ( $usage_rules as $key => $value ) {
		?>

		<ul class="usage-rules">
			<li class="usage-rules-title"><?php echo esc_html( str_replace( '_', ' ', ucwords( $key ) ) ); ?>:</li>
			<?php echo wp_kses_post( get_unlinked_usages( $value ) ); ?>
		</ul>

		<?php
	}

	echo '</div>';

}

/**
 * Function to output the sentences related to the post.
 *
 * @param array $meta The post meta data.
 */
function display_grammar_sentences( $meta ) {
	$image = wp_get_attachment_image( get_post_meta( get_the_ID(), 'k2k_grammar_meta_sentences_image_id', 1 ), 'full' );

	if ( $image ) {
		echo '<figure class="sentences-image">' . wp_kses_post( $image ) . '</figure>';
	}
	?>

	<!-- Sentences -->
	<div class="sentences-header">
		<h3><?php esc_html_e( 'Sentence Examples', 'k2k' ); ?></h3>
		<div class="sentence-buttons">
			<button class="expand-all" title="<?php esc_html_e( 'Show all English sentences', 'k2k' ); ?>">
				<i class="fas fa-caret-down"></i>
			</button>
			<small id="switch-sentence-language" class="korean"><?php esc_html_e( 'Change to: EN', 'k2k' ); ?></small>
		</div>
	</div>

	<?php
	// Check where the Note is (if it exists).
	if ( '' !== get_post_meta( get_the_ID(), 'k2k_grammar_meta_sentences_note_position', true ) ) {
		add_grammar_note( $meta, 'sentences_note' );
	}

	// Will this be a dialogue?
	if ( '' !== get_post_meta( get_the_ID(), 'k2k_grammar_meta_sentences_dialogue', true ) ) {
		$dialogue        = true;
		$sentences_class = 'dialogue';
	} else {
		$dialogue        = false;
		$sentences_class = '';
	}

	if ( array_key_exists( 'sentences', $meta ) ) :
		?>

	<ol class="sentences <?php echo esc_attr( $sentences_class ); ?>">
		<?php
		// Swap out words surrounded in ** with italic markup.
		$italic_pattern     = '/\*\*(.*?)\*\*/';
		$italic_replacement = '<em>$1</em>';

		// Swap out words surrounded in _ or * with bold markup.
		$bold_pattern     = '/[*_](.*?)[*_]/';
		$bold_replacement = '<strong>$1</strong>';

		// Surround the part of speech (V / A / N) with special markup.
		$part_of_speech_a      = '/^([Aa]:)/';
		$part_of_speech_v      = '/^([Vv]:)/';
		$part_of_speech_n      = '/^([Nn]:)/';
		$part_of_speech_adj_r  = '<span class="part-of-speech adjective">$1</span>';
		$part_of_speech_verb_r = '<span class="part-of-speech verb">$1</span>';
		$part_of_speech_noun_r = '<span class="part-of-speech noun">$1</span>';

		foreach ( $meta['sentences'] as $key => $array ) {
			$titles = get_post_meta( get_the_ID(), 'k2k_grammar_meta_sentences_titles', true )[0];
			$prefix = 'k2k_grammar_meta_sentences_titles_';

			// If we have new titles, and have chosen to replace the originals.
			if ( '' !== $titles[ $prefix . $key ] && '' !== $titles[ $prefix . 'replace' ] ) :
				?>
				<h4 class="sentence-tense-title">
					<?php echo esc_attr( $titles[ $prefix . $key ] ); ?>
				</h4>
				<?php
			else :
				?>
				<h4 class="sentence-tense-title">
					<?php
					echo esc_html( ucwords( $key ) ) . esc_html__( ' Tense', 'k2k' );
					if ( '' !== $titles[ $prefix . $key ] ) {
						echo '<span>&mdash; ' . esc_attr( $titles[ $prefix . $key ] ) . '</span>';
					}
					?>
				</h4>
				<?php
			endif;

			foreach ( $array as $sentence ) {
				// Add <em> tags.
				$italicize_ko = preg_replace( $italic_pattern, $italic_replacement, $sentence['k2k_grammar_meta_sentences_1'] );
				$italicize_en = preg_replace( $italic_pattern, $italic_replacement, $sentence['k2k_grammar_meta_sentences_2'] );

				// Add <strong> tags.
				$bold_ko = preg_replace( $bold_pattern, $bold_replacement, $italicize_ko );
				$bold_en = preg_replace( $bold_pattern, $bold_replacement, $italicize_en );

				// Add <span> tags.
				$ps_ko = preg_replace( $part_of_speech_a, $part_of_speech_adj_r, $bold_ko );
				// $ps_en = preg_replace( $part_of_speech_a, $part_of_speech_adj_r, $bold_en );
				$ps_ko = preg_replace( $part_of_speech_v, $part_of_speech_verb_r, $ps_ko );
				// $ps_en = preg_replace( $part_of_speech_v, $part_of_speech_verb_r, $ps_en );
				$ps_ko = preg_replace( $part_of_speech_n, $part_of_speech_noun_r, $ps_ko );
				// $ps_en = preg_replace( $part_of_speech_n, $part_of_speech_noun_r, $ps_en );
				?>

				<li class="sentence">
					<button class="expand" title="<?php esc_html_e( 'Show English sentence', 'k2k' ); ?>">
						<i class="fas fa-caret-down"></i>
					</button>
					<p class="ko"><?php echo wp_kses_post( $dialogue ? $ps_ko : implode( '', explode( ':', $ps_ko, 2 ) ) ); // Remove only the first colon ":". ?></p>
					<p class="en"><?php echo wp_kses_post( implode( '', explode( ':', $bold_en, 1 ) ) ); // Remove no colons. ?></p>
				</li>

				<?php
			}
		}
		?>
	</ol>

		<?php
	endif;

	if ( array_key_exists( 'special_dialogue', $meta ) ) {
		echo wp_kses_post( $meta['special_dialogue'] );
	}

	// Add Sentence Note if one exists.
	if ( '' === get_post_meta( get_the_ID(), 'k2k_grammar_meta_sentences_note_position', true ) ) {
		add_grammar_note( $meta, 'sentences_note' );
	}
}

/**
 * Function to output the exercises related to the post.
 *
 * @param array $meta The post meta data.
 */
function display_grammar_exercises( $meta ) {
	?>

	<footer class="entry-footer exercises-box">

		<h3><?php esc_html_e( 'Practice Exercises', 'k2k' ); ?></h3>

		<?php
		// Check where the Note is (if it exists).
		if ( '' !== get_post_meta( get_the_ID(), 'k2k_grammar_meta_exercises_note_position', true ) ) {
			add_grammar_note( $meta, 'exercises_note' );
		}
		?>

		<ol class="practice-exercises">

			<?php
			// Replace ... in the middle of the exercise with a fill-in-the-blank.
			$pattern     = '/\s\.{3}\s/';
			$replacement = '<span class="fill-in-the-blank">$1</span>';

			// Surround the keyword in () with <em> tags.
			$word_pattern     = '/\((.*?)\)/';
			$word_replacement = '<em class="keyword">($1)</em>';

			foreach ( $meta['exercises'] as $exercise ) {
				$words  = preg_replace( $word_pattern, $word_replacement, $exercise );
				$blanks = preg_replace( $pattern, $replacement, $words );

				echo '<li class="exercise">' . wp_kses_post( $blanks ) . '</li>';

			}
			?>

		</ol>
	</footer>

	<?php
	// Add Exercises Note if one exists.
	if ( '' === get_post_meta( get_the_ID(), 'k2k_grammar_meta_exercises_note_position', true ) ) {
		add_grammar_note( $meta, 'exercises_note' );
	}
}

/**
 * Function to output the related grammar points.
 *
 * @param array $meta An array of grammar meta data.
 */
function display_grammar_related( $meta ) {

	if ( ! array_key_exists( 'related_grammar', $meta ) ) {
		return;
	}

	$related      = $meta['related_grammar'][0];
	$prefix       = 'k2k_grammar_meta_';
	$related_list = [];

	if ( array_key_exists( $prefix . 'ul_similar_related', $related ) ) {
		$related_list['similar'] = $related[ $prefix . 'ul_similar_related' ];
	}
	if ( array_key_exists( $prefix . 'ul_opposite_related', $related ) ) {
		$related_list['opposite'] = $related[ $prefix . 'ul_opposite_related' ];
	}

	echo '<!-- Related Grammar -->';
	echo '<h3 class="related-title">' . esc_html__( 'Related Grammar', 'k2k' ) . '</h3>';

	foreach ( $related_list as $key => $value ) {
		?>

		<ul class="related-grammar usage-rules related-grammar-<?php echo esc_attr( $key ); ?>">
			<li class="related-grammar-title usage-rules-title"><?php echo esc_html( str_replace( '_', ' ', ucwords( $key ) ) ); ?>:</li>
			<?php echo wp_kses_post( get_unlinked_usages( $value ) ); ?>
		</ul>

		<?php
	}

}
