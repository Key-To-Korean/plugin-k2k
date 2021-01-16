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
	$taxonomy           = '';
	$tax_term           = '';

	if ( is_archive() && is_tax() ) {

		$taxonomy = explode( '-', get_query_var( 'taxonomy' ) );
		$tax_len  = count( $taxonomy );
		$tax_str  = '';
		if ( $tax_len > 2 ) {
			for ( $i = 1; $i < $tax_len; $i++ ) {
				$tax_str .= $taxonomy[ $i ] . ' ';
			}
		} else {
			$tax_str = $taxonomy[1];
		}
		$tax_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->name; // get current term.
		$parent   = isset( $tax_term->parent ) ? get_term( $tax_term->parent, get_query_var( 'taxonomy' ) ) : ''; // get parent term.
		$children = isset( $tax_term->term_id ) ? get_term_children( $tax_term->term_id, get_query_var( 'taxonomy' ) ) : ''; // get children.

		$archive_page_title = $tax_term;

	} elseif ( is_archive() && 'k2k-vocabulary' === get_post_type() ) {

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
			if ( is_tax() ) {
				?>
				<h1 class="page-title">
					<?php echo esc_attr( $tax_str . ':' ); ?>
					<span>
						<?php echo esc_attr( $archive_page_title ); ?>
					</span>
				</h1>
				<?php
			} else {
				/* translators: %s is the Archive Title. */
				printf( esc_html__( 'Index: %s', 'k2k' ), '<span>' . esc_attr( $archive_page_title ) . '</span>' );
			}
			?>
		</h1>
	</header>

	<?php
}

/**
 * Output HTML stars based on Difficulty Level.
 *
 * @param String $cpt_type The Custom Post Type we need stars for.
 */
function display_level_stars( $cpt_type = 'grammar' ) {

	$level = get_the_terms( get_the_ID(), 'k2k-' . $cpt_type . '-level' )[0]; // Translation, Image.

	// Get out if this item doesn't have a level set.
	if ( null === $level ) {
		return;
	}

	$stars = '';

	$level_arr   = explode( '-', $level->slug );
	$level_cpt   = $level_arr[0];
	$level_value = $level_arr[1];

	switch ( $level_value ) {
		case 'advanced':
			/* translators: %s is the Custom Post Type */
			$stars  = '<div class="level-stars" title="' . sprintf( esc_html__( 'Advanced %s Level', 'k2k' ), esc_attr( $level_cpt ) ) . '">';
			$stars .= '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
			$stars .= '</div>';
			break;
		case 'intermediate':
			/* translators: %s is the Custom Post Type */
			$stars  = '<div class="level-stars" title="' . sprintf( esc_html__( 'Intermediate %s Level', 'k2k' ), esc_attr( $level_cpt ) ) . '">';
			$stars .= '<i class="fas fa-star"></i><i class="fas fa-star"></i>';
			$stars .= '</div>';
			break;
		case 'beginner':
			/* translators: %s is the Custom Post Type */
			$stars  = '<div class="level-stars" title="' . sprintf( esc_html__( 'Beginner %s Level', 'k2k' ), esc_attr( $level_cpt ) ) . '">';
			$stars .= '<i class="fas fa-star"></i>';
			$stars .= '</div>';
			break;
		case 'true':
			/* translators: %s is the Custom Post Type */
			$stars  = '<div class="level-stars" title="' . sprintf( esc_html__( 'True Beginner %s Level', 'k2k' ), esc_attr( $level_cpt ) ) . '">';
			$stars .= '<i class="fas fa-half-star"></i>';
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

	// Get the Current Post Type (ex: 'k2k-grammar').
	$post_type_here = substr( get_post_type( get_the_ID() ), 4 ); // Remove 'k2k-'.
	if ( 'vocabulary' === $post_type_here ) {
		$post_type_here = 'vocab';
	}
	$taxonomy = substr( $taxonomy, 4 ); // Remove 'k2k-'.

	// Get out of here if the meta we are seeking doesn't exist.
	if ( ! array_key_exists( $taxonomy, $meta ) ) {
		return;
	}

	$count    = 0;
	$tax_term = $single ? $meta[ $taxonomy ] : $meta[ $taxonomy ][ $count ];

	// Useful for debugging.
	$meta_data = array(
		'meta'     => $meta,
		'taxonomy' => $taxonomy,
		'cpt_here' => $post_type_here,
		'tax_term' => $tax_term,
	);

	if ( ! array_key_exists( $taxonomy, $meta ) ) {
		return;
	}

	// If there is only one item.
	if ( $single || count( $meta[ $taxonomy ] ) === 1 ) {

		$classnames = 'button' === $type ? 'btn button'
										: 'k2k-grammar-part-of-speech' === $taxonomy ? 'tag-button'
										: 'k2k-vocab-part-of-speech' === $taxonomy ? 'tag-button'
										: '';
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
