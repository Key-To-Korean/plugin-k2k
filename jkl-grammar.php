<?php
/** phpcs:ignore
 *
 * @package Aaron
 */

/*
 * Plugin Name: JKL Grammar
 * Plugin URI: https://github.com/jekkilekki/plugin-jkl-grammar
 * Description: Custom Post Type to handle Grammar Points
 * Version: 1.1.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jkl-grammar
 * Domain Path: /languages
 */

/*
JKL Grammar is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

JKL Grammar is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JKL Grammar. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) { // if ( ! defined( 'WPINC' ) ).
	exit; // die.
}

// Define plugin constants.
define( 'JKL_G_VERSION', '1.2.0' );
define( 'JKL_G_DOMAIN', 'jkl-grammar' );
define( 'JKL_G_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Load Text Domain.
 */
function jkl_grammar_load_textdomain() {
	load_plugin_textdomain( 'jkl-grammar', false, plugin_dir_path( __FILE__ ) . 'languages/' );
}
add_action( 'plugins_loaded', 'jkl_grammar_load_textdomain' );

// Include CMB2 and helpers.
require_once JKL_G_PATH . 'includes/cmb2/init.php';
require_once JKL_G_PATH . 'includes/cmb2-tabs/cmb2-tabs.php';
require_once JKL_G_PATH . 'includes/cmb2-attached-posts/cmb2-attached-posts-field.php';

// Include Metaboxes.
require_once JKL_G_PATH . 'admin/metaboxes/example-functions.php';
require_once JKL_G_PATH . 'admin/metaboxes/metabox-register.php';

// Include Post Type(s).
require_once JKL_G_PATH . 'admin/post-types/post-type-register.php';

// Include Taxonomies.
require_once JKL_G_PATH . 'admin/taxonomies/taxonomy-register-book.php';
require_once JKL_G_PATH . 'admin/taxonomies/taxonomy-register-expression.php';
require_once JKL_G_PATH . 'admin/taxonomies/taxonomy-register-level.php';
require_once JKL_G_PATH . 'admin/taxonomies/taxonomy-register-part-of-speech.php';
require_once JKL_G_PATH . 'admin/taxonomies/taxonomy-register-tenses.php';
require_once JKL_G_PATH . 'admin/taxonomies/taxonomy-register-usage.php';

// Register everything on plugin activation.
register_activation_hook( __FILE__, 'jkl_grammar_register_everything' );

// Deregister everything on plugin deactivation.
register_deactivation_hook( __FILE__, 'jkl_grammar_remove_everything' );

/**
 * Flush rewrite rules when plugin is activated.
 */
function jkl_grammar_register_everything() {

	flush_rewrite_rules();

}

/**
 * Remove Post Type, Taxonomies, and data and flush rewrite rules on deactivation.
 */
function jkl_grammar_remove_everything() {

	unregister_post_type( 'jkl-grammar' );

	flush_rewrite_rules();

}

/**
 * Add WP-Subtitle support
 *
 * @link https://github.com/benhuson/wp-subtitle/wiki/Add-support-for-a-custom-post-type
 * @source https://wordpress.org/plugins/wp-subtitle/

function jkl_grammar_add_subtitles() {
	add_post_type_support( 'jkl-grammar', 'wps_subtitle' );
}
add_action( 'init', 'jkl_grammar_add_subtitles' );

/**
 * Change WP-Subtitle title

function jkl_grammar_subtitle_title( $title, $post_type ) {
	if ( 'jkl-grammar' === $post_type ) {
		$title = __( 'Translation (subtitle)', 'jkl-grammar' );
	}
	return $title;
}
add_filter( 'wps_meta_box_title', 'jkl_grammar_subtitle_title', 10, 2 );

/**
 * Add WP-Subtitle description

function jkl_grammar_subtitle_description( $description, $post ) {
	if ( 'jkl-grammar' === get_post_type( $post ) ) {
		return '<p>' . __( 'Used for grammar translation.', 'jkl-grammar' ) . '</p>';
	}
	return $description;
}
add_filter( 'wps_subtitle_field_description', 'jkl_grammar_subtitle_description', 10, 2 );
 */

/**
 * Include Template paths
 *
 * @param string $template_path The path to the template.
 */
function jkl_grammar_single( $template_path ) {

	if ( get_post_type() === 'jkl-grammar' ) {

		if ( is_single() ) {

			$single_template = locate_template( array( 'single-grammar.php', 'single.php' ), false );

			// checks if the file exists in the theme first,
			// otherwise serve the file from the plugin.
			if ( $single_template ) {
				$template_path = $single_template;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . 'public/single-grammar.php';
			}
		} elseif ( is_archive() ) {

			$archive_template = locate_template( array( 'archive-grammar.php' ), false );

			if ( $archive_template ) {
				$template_path = $archive_template;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . 'public/archive-grammar.php';
			}
		}
	}
	return $template_path;

}
add_filter( 'template_include', 'jkl_grammar_single', 1 );

/**
 * Custom Taxonomy page
 */
function jkl_grammar_custom_taxonomy_pages( $tax_template ) {
	// if ( is_tax( 'level' ) ) {
		$tax_template = dirname( __FILE__ ) . '/taxonomy-level.php';
	// }
	return $tax_template;
}
// add_filter( 'taxonomy_template', 'jkl_grammar_custom_taxonomy_pages' );

/**
 * Create filters for custom categories on the CPT admin list page
 *
 * @link https://generatewp.com/filtering-posts-by-taxonomies-in-the-dashboard/
 */
function jkl_grammar_filters( $post_type, $which ) {

	// Apply this only on a specific post type.
	if ( 'jkl-grammar' !== $post_type )
		return;

	// A list of taxonomy slugs to filter by.
	$taxonomies = array( 'jkl-grammar-level', 'jkl-grammar-book', 'jkl-grammar-part-of-speech', 'jkl-grammar-expression', 'jkl-grammar-usage' );

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data.
		$taxonomy_obj  = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms.
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML.
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All %ss', 'jkl-grammar' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[ $taxonomy_slug ] ) && ( $_GET[ $taxonomy_slug ] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}
add_action( 'restrict_manage_posts', 'jkl_grammar_filters', 10, 2 );

/**
 * Enqueue ReactJS and other scripts
 *
 * @link https://reactjs.org/docs/add-react-to-a-website.html
 */
function jkl_grammar_scripts() {
	if ( 'jkl-grammar' === get_post_type() && is_archive() ) {
		wp_enqueue_script( 'jkl-grammar-react', 'https://unpkg.com/react@16/umd/react.development.js', array(), '20181126', true );
		wp_enqueue_script( 'jkl-grammar-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', array(), '20181126', true );
		wp_enqueue_script( 'jkl-grammar-babel', 'https://unpkg.com/babel-standalone@6/babel.min.js', array(), '20181128', true );
		wp_enqueue_script( 'jkl-grammar-components', plugins_url( 'js/GrammarArchives.js', __FILE__ ), array( 'jkl-grammar-react', 'jkl-grammar-react-dom', 'jkl-grammar-babel' ), '20181126', true );
	}
}
add_action( 'wp_enqueue_scripts', 'jkl_grammar_scripts' );

/**
 * Change script tag for JSX script
 *
 * @link https://milandinic.com/2015/12/01/using-react-jsx-in-wordpress/
 */
function jkl_grammar_script_type( $tag, $handle, $src ) {
	// Check that this is output of JSX file.
	if ( 'jkl-grammar-components' == $handle ) {
		$tag = str_replace( "<script type='text/javascript'", "<script type='text/babel'", $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'jkl_grammar_script_type', 10, 3 );
