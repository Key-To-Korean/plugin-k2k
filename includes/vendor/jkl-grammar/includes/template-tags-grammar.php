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
 * Possible taxonomies for Vocabulary are 'Level', 'Book', 'Part of Speech', 'Expression', 'Usage', 'Phrase Type'.
 *
 * @param string $taxonomy The taxonomy to display post navigation for.
 */
function display_grammar_navigation( $taxonomy = 'k2k-level' ) {
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
	echo '<table class="grammar-conjugations">';
	$ps_keys = array_keys( $conjugations );

	$count = 0;
	foreach ( $conjugations as $part_of_speech ) :
		?>

		<tr class="part-of-speech-conjugation">
			<th rowspan="<?php echo count( $part_of_speech[0] ); ?>" class="<?php echo esc_attr( $ps_keys[ $count ] ); ?>">
				<span class="part-of-speech" title="<?php echo esc_html( ucwords( $ps_keys[ $count ] ) ); ?>">
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
