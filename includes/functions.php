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
function k2k_single( $template_path ) {

	$post_type_here = get_post_type();
	$post_type_slug = explode( '-', $post_type_here )[1];
	$k2k_post_types = array( 'k2k-vocabulary', 'k2k-grammar', 'k2k-phrases', 'k2k-reading', 'k2k-writing' );

	if ( in_array( $post_type_here, $k2k_post_types, true ) ) {

		if ( is_single() ) {

			$single_template = locate_template( array( 'single-' . $post_type_slug . '.php' ), false );

			// checks if the file exists in the theme first,
			// otherwise serve the file from the plugin.
			if ( $single_template ) {
				$template_path = $single_template;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . 'vendor/jkl-vocab/single-' . $post_type_slug . '.php';
			}
		} elseif ( is_archive() ) {

			$archive_template = locate_template( array( 'archive-.php' ), false );

			if ( $archive_template ) {
				$template_path = $archive_template;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . 'public/page-templates/archive-grammar.php';
			}
		}
	}
	return $template_path;

}
add_filter( 'template_include', 'k2k_single', 1 );

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
