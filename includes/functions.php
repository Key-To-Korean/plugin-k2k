<?php
/**
 * K2K - Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include Template paths
 *
 * @param string $template_path The path to the template.
 */
function k2k_template( $template_path ) {

	$k2k_post_types = array( 'k2k-vocabulary', 'k2k-grammar', 'k2k-phrases', 'k2k-reading', 'k2k-writing' );
	$post_type_here = get_post_type();

	if ( ! $post_type_here || ( ! in_array( $post_type_here, $k2k_post_types, true ) ) ) {
		return $template_path;
	}

	$post_type_slug = explode( '-', $post_type_here )[1];

	if ( is_single() ) {

		$theme_template_single  = locate_template( array( 'single-' . $post_type_slug . '.php' ), false );
		$plugin_template_single = plugin_dir_path( __FILE__ ) . 'vendor/jkl-' . $post_type_slug . '/single-' . $post_type_slug . '.php';

		// checks if the file exists in the theme first,
		// otherwise serve the file from the plugin.
		if ( $theme_template_single ) {
			$template_path = $theme_template_single;
		} elseif ( file_exists( $plugin_template_single ) ) {
			$template_path = $plugin_template_single;
		}
	} elseif ( is_archive() ) {

		$theme_template_archive  = locate_template( array( 'archive-' . $post_type_slug . '.php' ), false );
		$plugin_template_archive = plugin_dir_path( __FILE__ ) . 'vendor/jkl-' . $post_type_slug . '/archive-' . $post_type_slug . '.php';

		if ( $theme_template_archive ) {
			$template_path = $theme_template_archive;
		} elseif ( file_exists( $plugin_template_archive ) ) {
			$template_path = $plugin_template_archive;
		}
	}

	return $template_path;

}
add_filter( 'template_include', 'k2k_template', 1 );

/**
 * Custom Taxonomy page
 *
 * @param string $tax_template The Taxonomy Template filename.
 */
function k2k_custom_taxonomy_pages( $tax_template ) {
	// if ( is_tax( 'level' ) ) {.
		$tax_template = dirname( __FILE__ ) . '/taxonomy-level.php';
	// }
	return $tax_template;
}
// add_filter( 'taxonomy_template', 'k2k_custom_taxonomy_pages' );.

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

		$tax_term[ substr( $taxonomy, 4 ) . '_name' ]        = $tax_name;
		$tax_term[ substr( $taxonomy, 4 ) . '_translation' ] = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'term_translation', true );
		$tax_term[ substr( $taxonomy, 4 ) . '_image' ]       = get_term_meta( $tax_terms[0]->term_id, $term_prefix . 'avatar', true );

		$post_meta['post'][ $taxonomy ] = $tax_term;

		unset( $tax_term );

	}

	echo '<pre>';
	var_dump( $post_meta );
	echo '</pre>';

	return $post_meta;

}

/**
 * Enqueue ReactJS and other scripts
 *
 * @link https://reactjs.org/docs/add-react-to-a-website.html
 */
function k2k_scripts() {
	if ( 'k2k' === get_post_type() && is_archive() ) {
		wp_enqueue_script( 'k2k-react', 'https://unpkg.com/react@16/umd/react.development.js', array(), '20181126', true );
		wp_enqueue_script( 'k2k-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', array(), '20181126', true );
		wp_enqueue_script( 'k2k-babel', 'https://unpkg.com/babel-standalone@6/babel.min.js', array(), '20181128', true );
		wp_enqueue_script( 'k2k-components', plugins_url( 'js/GrammarArchives.js', __FILE__ ), array( 'k2k-react', 'k2k-react-dom', 'k2k-babel' ), '20181126', true );
	}
}
add_action( 'wp_enqueue_scripts', 'k2k_scripts' );

/**
 * Change script tag for JSX script
 *
 * @param string $tag The script tag.
 * @param string $handle The script handle.
 * @param string $src The script source.
 *
 * @link https://milandinic.com/2015/12/01/using-react-jsx-in-wordpress/
 */
function k2k_script_type( $tag, $handle, $src ) {
	// Check that this is output of JSX file.
	if ( 'k2k-components' === $handle ) {
		$tag = str_replace( "<script type='text/javascript'", "<script type='text/babel'", $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'k2k_script_type', 10, 3 );
