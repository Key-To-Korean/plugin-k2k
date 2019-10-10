<?php
/**
 * Template Tags - return HTML for functions in single & archive templates.
 *
 * @package K2K
 */

/**
 * Function to retrieve ALL meta data (post meta and term meta) for a Post.
 *
 * @param array $args A list of taxonomies to retrieve meta data for.
 * @return array All the meta and data associated with the post.
 */
function get_all_the_post_meta( $args ) {

	// Post Meta.
	$post_meta['post'] = get_post_meta( get_the_ID() );

	// Term Meta.
	$term_prefix = 'k2k_taxonomy_';

	foreach ( $args as $taxonomy ) {

		$tax_terms = get_the_terms( get_the_ID(), $taxonomy ); // Translation, Image.
		if ( ! $tax_terms ) {
			continue;
		}
		$tax_name = $tax_terms[0]->name;
		$tax_slug = $tax_terms[0]->slug;

		$tax_term['_slug']        = $tax_slug;
		$tax_term['_name']        = $tax_name;
		$tax_term['_translation'] = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'term_translation', true );
		$tax_term['_image']       = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'avatar', true );
		$tax_term['_weblink']     = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'weblink', true );
		$tax_term['_term_color']  = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'term_color', true );

		$post_meta['post'][ $taxonomy ] = array_filter( $tax_term ); // Use array_filter() to remove null values.

		unset( $tax_term );

	}

	return $post_meta;

}

/**
 * Custom Taxonomy Index Header.
 */
function k2k_index_header() {

	$archive_page_title = '';

	if ( is_archive() && 'k2k-vocabulary' === get_post_type() ) {

		$archive_page_title = __( 'Vocabulary', 'k2k' );

	} elseif ( is_archive() && 'k2k-grammar' === get_post_type() ) {

		$archive_page_title = __( 'Grammar Index', 'k2k' );

	} elseif ( is_archive() && 'k2k-phrases' === get_post_type() ) {

		$archive_page_title = __( 'Phrases', 'k2k' );

	} elseif ( is_archive() && 'k2k-reading' === get_post_type() ) {

		$archive_page_title = __( 'Reading', 'k2k' );

	} elseif ( is_archive() && 'k2k-writing' === get_post_type() ) {

		$archive_page_title = __( 'Writing', 'k2k' );

	}
	?>

	<header class="page-header">
		<h1 class="page-title">
			<?php
			/* translators: %s is the Archive Title. */
			printf( esc_html__( 'Archives: %s', 'k2k' ), '<span>' . esc_attr( $archive_page_title ) . '</span>' );
			?>
		</h1>
	</header>

	<?php
}

/**
 * Output HTML stars based on Difficulty Level.
 */
function get_level_stars() {

	$level = get_the_terms( get_the_ID(), 'k2k-level' )[0]; // Translation, Image.
	$stars = '';

	switch ( $level->slug ) {
		case 'level-advanced':
			$stars = '<div class="level-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>';
			break;
		case 'level-intermediate':
			$stars = '<div class="level-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i></div>';
			break;
		case 'level-beginner':
			$stars = '<div class="level-stars"><i class="fas fa-star"></i></div>';
			break;
		default:
			$stars = '';
	}

	echo wp_kses_post( $stars );

}

/**
 * Get Custom Meta for a post simply based on the meta_key
 *
 * @param string $meta_key The meta value we are retrieving.
 *
 * @return string The meta value we retrieved.
 */
function get_custom_meta( $meta_key ) {

	$meta = get_post_meta( get_the_ID(), $meta_key, true );
	return $meta;

}

/**
 * Create a button (or link) for the custom meta value.
 *
 * @param string $type Whether we want a 'button' or 'link' (default).
 * @param string $taxonomy The taxonomy we are querying for a value.
 * @param bool   $multiple Whether or not to output more than one item.
 */
function custom_meta_button( $type, $taxonomy, $multiple = false ) {

	$meta       = get_all_the_post_meta( array( $taxonomy ) );
	$classnames = 'button' === $type ? 'btn button' : '';

	if ( array_key_exists( $taxonomy, $meta['post'] ) ) {

		$output  = '<a class="' . $classnames . '" title="' . $meta['post'][ $taxonomy ]['_name'];
		$output .= '" href="' . home_url() . '/' . substr( $taxonomy, 4 ) . '/' . $meta['post'][ $taxonomy ]['_slug'];
		$output .= '">';

		if ( array_key_exists( '_translation', $meta['post'][ $taxonomy ] ) ) {
			$output .= $meta['post'][ $taxonomy ]['_translation'];
		} else {
			$output .= $meta['post'][ $taxonomy ]['_name'];
		}

		$output .= '</a>';

		echo wp_kses_post( $output );

	}

}

/**
 * Output related footer meta.
 *
 * @param string $title The name of the Related values (synonyms, antonyms, etc.).
 * @param array  $array Array of values to output.
 */
function custom_footer_meta( $title, $array ) {

	$output  = '<ul class="related-terms">';
	$output .= '<li><h4>' . $title . '</h4></li>';

	foreach ( $array as $item ) {
		$post    = get_post( $item );
		$output .= '<li>';
		$output .= '<a class="btn button" rel="tag" href="' . get_the_permalink( $post->ID ) . '">' . $post->post_title . '</a>';
		$output .= '</li>';
	}

	$output .= '</ul>';

	echo wp_kses_post( $output );

}
