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

		$archive_page_title = __( 'Grammar', 'k2k' );

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
			printf( esc_html__( 'Index: %s', 'k2k' ), '<span>' . esc_attr( $archive_page_title ) . '</span>' );
			?>
		</h1>
	</header>

	<?php
}

/**
 * Output HTML stars based on Difficulty Level.
 */
function display_level_stars() {

	$level = get_the_terms( get_the_ID(), 'k2k-level' )[0]; // Translation, Image.
	$stars = '';

	switch ( $level->slug ) {
		case 'level-advanced':
			$stars  = '<div class="level-stars" title="' . esc_html__( 'Advanced Level', 'k2k' ) . '">';
			$stars .= '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
			$stars .= '</div>';
			break;
		case 'level-intermediate':
			$stars  = '<div class="level-stars" title="' . esc_html__( 'Intermediate Level', 'k2k' ) . '">';
			$stars .= '<i class="fas fa-star"></i><i class="fas fa-star"></i>';
			$stars .= '</div>';
			break;
		case 'level-beginner':
			$stars  = '<div class="level-stars" title="' . esc_html__( 'Beginner Level', 'k2k' ) . '">';
			$stars .= '<i class="fas fa-star"></i>';
			$stars .= '</div>';
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

	// Returns the first (single) meta key.
	$meta = get_post_meta( get_the_ID(), $meta_key, true );
	return $meta;

}

/**
 * Create a button (or link) for the custom meta value.
 *
 * @param array  $meta The meta for the post.
 * @param string $taxonomy The taxonomy we are querying for a value.
 * @param bool   $single Whether or not to output a single (the first) item.
 * @param string $type Whether we want a 'button' or 'link' (default).
 */
function display_meta_buttons( $meta, $taxonomy, $single = false, $type = 'link' ) {

	$taxonomy = substr( $taxonomy, 4 );
	$count    = 0;
	$tax_term = $single ? $meta[ $taxonomy ] : $meta[ $taxonomy ][ $count ];

	if ( ! array_key_exists( $taxonomy, $meta ) ) {
		return;
	}

	// If there is only one item.
	if ( $single || count( $meta[ $taxonomy ] ) === 1 ) {

		$classnames = 'button' === $type ? 'btn button' : 'k2k-part-of-speech' === $taxonomy ? 'tag-button' : '';
		$style      = ( 'k2k-part-of-speech' === $taxonomy && array_key_exists( 'term_color', $meta[ $taxonomy ] ) )
									? 'background: ' . $meta[ $taxonomy ]['term_color'] : '';

		display_meta_item(
			array(
				'taxonomy'    => $taxonomy,
				'classnames'  => $classnames,
				'style'       => $style,
				'name'        => $tax_term['name'],
				'slug'        => $tax_term['slug'],
				'translation' => array_key_exists( 'translation', $tax_term )
					? $tax_term['translation']
					: $tax_term['name'],
			)
		);

	} else {

		foreach ( $meta[ $taxonomy ] as $item ) {

			// Ignore anything that's not an array.
			if ( ! is_array( $item ) ) {
				continue;
			}

			$classnames = 'button' === $type ? 'btn button' : 'part-of-speech' === $taxonomy ? 'tag-button' : '';
			$style      = ( 'part-of-speech' === $taxonomy && array_key_exists( 'term_color', $meta[ $taxonomy ] ) )
									? 'background: ' . $meta[ $taxonomy ]['term_color'] : '';

			display_meta_item(
				array(
					'taxonomy'    => $taxonomy,
					'classnames'  => $classnames,
					'style'       => $style,
					'name'        => $item['name'],
					'slug'        => $item['slug'],
					'translation' => array_key_exists( 'translation', $item )
						? $item['translation']
						: $item['name'],
				)
			);

			$count++;

		}
	}

}

/**
 * Function to display a single taxonomy item with special styles, or the translation.
 *
 * @param array $args All the relevant data needed to build and output the taxonomy item.
 */
function display_meta_item( $args ) {

	$class  = strpos( $args['name'], ' ' ) ? 'long' : '';
	$class .= 'part-of-speech' === $args['taxonomy'] ? 'part-of-speech ' . strtolower( $args['name'] ) : '';

	$output  = '<li class="k2k-taxonomy-item ' . $class . '">';
	$output .= '<a class="' . $args['classnames'];
	$output .= '" title="' . $args['name'];
	$output .= '" href="' . home_url() . '/' . $args['taxonomy'] . '/' . $args['slug'];
	$output .= '" style="' . $args['style'];
	$output .= '">';
	$output .= $args['translation'];
	$output .= '</a>';
	$output .= '</li>';

	echo wp_kses_post( $output );

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

/**
 * Display lists of Taxonomies associated with the Custom Post Type.
 *
 * @param string $taxonomy Slug of the taxonomy we want a list of terms for.
 * @param string $title Title to display (optional).
 */
function display_taxonomy_list( $taxonomy, $title = '' ) {

	echo '<div class="archive-taxonomies-list">';
	if ( '' !== $title ) {
		?>
	<h3 class="taxonomy-title all-categories"><?php echo esc_html( $title ); ?></h3>
	<?php } ?>

	<ul class="blog-categories k2k-taxonomies">
		<?php
		$categories = get_category( get_query_var( 'cat' ) );
		// use $categories->parent and '&child_of' . $categories->parent . if you want only SUB categories.
		$categories = wp_list_categories(
			'orderby=id&depth=1&show_count=0' .
			'&title_li=&use_desc_for_title=1' .
			'&echo=0&taxonomy=' . $taxonomy
		);
		echo wp_kses_post( $categories );
		?>
	</ul>

	<?php
	echo '</div>';

}
