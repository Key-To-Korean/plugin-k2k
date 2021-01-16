<?php
/**
 * K2K - Register Grammar Post Type.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create filters for custom categories on the CPT admin list page
 *
 * @param object $post_type The custom Post Type object.
 * @param mixed  $which Which it is? Check the link below...
 *
 * @link https://generatewp.com/filtering-posts-by-taxonomies-in-the-dashboard/
 */
function k2k_filters( $post_type, $which ) {

	// Apply this only on a specific post type.
	if ( ! ( 'k2k-grammar' === $post_type
				|| 'k2k-vocabulary' === $post_type
				|| 'k2k-phrases' === $post_type )
				|| 'k2k-reading' === $post_type
				|| 'k2k-writing' === $post_type ) {
		return;
	}

	// A list of taxonomy slugs to filter by.
	// We need ONLY the taxonomies assigned to this $post_type.
	$taxonomies = get_object_taxonomies( $post_type );

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data.
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );

		if ( ! empty( $taxonomy_obj ) ) {
			$taxonomy_name = $taxonomy_obj->labels->name;

			// Retrieve taxonomy terms.
			$terms = get_terms( $taxonomy_slug );

			// Display filter HTML.
			echo "<select name='" . esc_html( $taxonomy_slug ) . "' id='" . esc_html( $taxonomy_slug ) . "' class='postform'>";
			echo '<option value="">';
			// Translators: The taxonomy term.
			echo sprintf( esc_html__( 'Show All %ss', 'k2k' ), esc_html( $taxonomy_name ) );
			echo '</option>';
			foreach ( $terms as $term ) {
				printf(
					'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
					esc_html( $term->slug ),
					( ( isset( $_GET[ $taxonomy_slug ] ) && ( $_GET[ $taxonomy_slug ] == $term->slug ) ) ? ' selected="selected"' : '' ),
					esc_html( $term->name ),
					esc_attr( $term->count )
				);
			}
			echo '</select>';
		}
	}

}
add_action( 'restrict_manage_posts', 'k2k_filters', 10, 2 );
