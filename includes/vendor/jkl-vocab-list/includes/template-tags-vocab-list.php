<?php
/**
 * JKL Vocab LIST Template Tags.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create a button (or link) for the custom meta value.
 *
 * @param array  $meta The array of data to create a button for.
 * @param string $name The name of the taxonomy (used for correct permalinks).
 */
function get_vocab_list_meta_buttons( $meta, $name = '' ) {

	$classnames = '';

	$output  = '<a class="' . $classnames . '" title="' . $meta['name'];
	$output .= '" href="' . home_url() . '/' . $name . '/' . $meta['slug'] . '/';
	$output .= '">';

	if ( array_key_exists( 'translation', $meta ) ) {
		$output .= $meta['translation'];
	} else {
		$output .= $meta['name'];
	}

	$output .= '</a>';

	return $output;

}

/**
 * Function to return links of related LIST.
 *
 * @param array $meta An array of linked vocab LIST meta data.
 */
function get_linked_list( $meta ) {

	$output = '';

	foreach ( $meta as $item ) {
		$post    = get_post( $item );
		$output .= '<li class="related-list linked">';
		$output .= '<a class="tag-button" rel="tag" href="' . get_the_permalink( $post->ID ) . '">' . $post->post_title . '</a>';
		$output .= '</li>';
	}

	return $output;

}

/**
 * Function to return a list of related LIST.
 *
 * @param array $meta An array of unlinked vocab LIST meta data.
 */
function get_unlinked_list( $meta ) {

	// If this is a list of terms, output them separately.
	if ( strpos( $meta, ',' ) ) {

		$output = '';

		$items = explode( ', ', $meta );
		foreach ( $items as $item ) {
			$output .= '<li class="related-list unlinked">' . $item . '</li>';
		}

		return $output;

	} else {
		return '<li class="related-list unlinked">' . $meta . '</li>';
	}

}

/**
 * Function to output the meta data at the top of the flashcard.
 *
 * @param array $meta An array of vocab LISTS meta data.
 */
function display_vocab_list_top_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocab_list_get_meta_data();
	}

	if ( jkl_has_vocab_list_meta( $meta ) ) {
		?>
		<ul class="vocab-list-meta">
		<?php
			echo array_key_exists( 'vocab-list-level', $meta )
				? '<li>' . wp_kses_post( get_vocab_lists_meta_buttons( $meta['vocab-list-level'], 'vocab-list-level' ) ) . '</li>'
				: '';
			echo array_key_exists( 'vocab-list-book', $meta )
				? '<li class="vocab-list-book">' . wp_kses_post( get_vocab_lists_meta_buttons( $meta['vocab-list-book'], 'vocab-list-book' ) ) . '</li>'
				: '';
		?>
		</ul>
		<?php
	}

}

/**
 * Function to output the related data at the bottom of the vocab LIST post.
 *
 * @param array $meta An array of vocab LIST meta data.
 */
function display_vocab_list_related_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocab_list_get_meta_data();
	}

	$prefix       = 'k2k_vocab_list_meta_';
	$related      = [ 'related' ];
	$related_meta = [];

	foreach ( $related as $r ) {
		if ( array_key_exists( $r, $meta ) ) {
			$related_meta[ $r ] = $meta[ $r ][0];
		}
	}

	if ( ! empty( $related_meta ) ) {

		foreach ( $related_meta as $key => $value ) {

			echo '<ul class="related-list">';
			echo '<li class="related-list-title">' . esc_html( ucwords( $key ) ) . ':</li>';

			if ( array_key_exists( $prefix . $key . '_linked', $value ) ) {
				echo wp_kses_post( get_linked_terms( $value[ $prefix . $key . '_linked' ] ) );
			}
			if ( array_key_exists( $prefix . $key . '_unlinked', $value ) ) {
				echo wp_kses_post( get_unlinked_terms( $value[ $prefix . $key . '_unlinked' ] ) );
			}

			echo '</ul>';

		}
	}

}

/**
 * Custom Search Form for Vocab LIST Post Type.
 */
function display_vocab_list_search_form() {
	?>
	<form action="/" method="get" class="vocab-list-search k2k-search">
		<label for="search" class="screen-reader-text"><?php esc_html_e( 'Search Vocab Lists', 'k2k' ); ?></label>
		<input type="text" name="s" id="search" placeholder="<?php esc_html_e( 'Search Vocab Lists', 'k2k' ); ?>" value="<?php the_search_query(); ?>" />
		<!-- <input type="submit" value="<?php esc_html_e( 'Search', 'k2k' ); ?>" /> -->
		<input type="hidden" value="k2k-vocab-list" name="post_type" id="post_type" />
	</form>
	<?php
}

/**
 * Custom navigation for Vocab LIST Post Type.
 *
 * Default Taxonomy is 'Level' - but can pass in a different taxonomy if desired.
 * Possible taxonomies for Vocab LIST are 'Level', 'Book'.
 *
 * @param string $taxonomy The taxonomy to display post navigation for.
 */
function display_vocab_list_navigation( $taxonomy = 'k2k-vocab-list-level' ) {
	?>
	<nav id="nav-above" class="navigation post-navigation vocab-list-navigation" role="navigation">
		<p class="screen-reader-text"><?php esc_html_e( 'Vocab List Navigation', 'k2k' ); ?></p>
		<div class="nav-index">
			<span class="meta-nav"><a href="<?php echo esc_url( get_home_url() ) . '/vocab-list/'; ?>"><?php esc_html_e( 'Vocab List Index', 'k2k' ); ?></a></span>
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
