<?php
/**
 * K2K - Main Plugin file
 *
 * @package K2K
 */

/*
 * Plugin Name: K2K
 * Plugin URI: https://github.com/jekkilekki/plugin-k2k
 * Description: Custom plugin to manage KeyToKorean.com
 * Version: 1.0.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: k2k
 * Domain Path: /languages
 */

/*
K2K is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

K2K is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with K2K. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) { // if ( ! defined( 'WPINC' ) ).
	exit; // die.
}

// Define plugin constants.
define( 'K2K_VERSION', '1.0.0' );
define( 'K2K_DOMAIN', 'k2k' );
define( 'K2K_PATH', plugin_dir_path( __FILE__ ) );
define( 'K2K_MENU_POSITION', 50 );
define( 'K2K_TAXES', array( 'category', 'post_tag', 'k2k-expression', 'k2k-book', 'k2k-tenses', 'k2k-usage', 'k2k-level', 'k2k-part-of-speech' ) );

/**
 * Load Text Domain.
 */
function k2k_load_textdomain() {
	load_plugin_textdomain( 'k2k', false, plugin_dir_path( __FILE__ ) . 'languages/' );
}
add_action( 'plugins_loaded', 'k2k_load_textdomain' );

// Include CMB2 and helpers.
require_once K2K_PATH . 'includes/cmb2/init.php';
require_once K2K_PATH . 'includes/cmb2-tabs/cmb2-tabs.php';
require_once K2K_PATH . 'includes/cmb2-attached-posts/cmb2-attached-posts-field.php';

// Include General Metaboxes.
// require_once K2K_PATH . 'admin/metaboxes/example-functions.php';
require_once K2K_PATH . 'admin/metaboxes/metabox-plugin-options.php';
require_once K2K_PATH . 'admin/metaboxes/metabox-user-profile-extras.php';
require_once K2K_PATH . 'admin/metaboxes/metabox-taxonomy-extras.php';

// Include CPT Metaboxes.
require_once K2K_PATH . 'admin/metaboxes/metabox-grammar-register.php';
// require_once K2K_PATH . 'admin/metaboxes/metabox-vocabulary-register.php';
// require_once K2K_PATH . 'admin/metaboxes/metabox-phrases-register.php';

// Include Post Type(s).
require_once K2K_PATH . 'admin/post-types/post-type-grammar-register.php';
require_once K2K_PATH . 'admin/post-types/post-type-vocabulary-register.php';
require_once K2K_PATH . 'admin/post-types/post-type-phrases-register.php';

// Include Shared Taxonomies.
require_once K2K_PATH . 'admin/taxonomies/taxonomy-register-level.php';          // Grammar, Vocabulary, Phrases.
require_once K2K_PATH . 'admin/taxonomies/taxonomy-register-part-of-speech.php'; // Grammar, Vocabulary.
require_once K2K_PATH . 'admin/taxonomies/taxonomy-register-expression.php';     // Grammar, Phrases.

// Include Grammar Taxonomies.
require_once K2K_PATH . 'admin/taxonomies/taxonomy-register-grammar-book.php';
require_once K2K_PATH . 'admin/taxonomies/taxonomy-register-grammar-tenses.php';
require_once K2K_PATH . 'admin/taxonomies/taxonomy-register-grammar-usage.php';

// Register everything on plugin activation.
register_activation_hook( __FILE__, 'k2k_register_everything' );

// Deregister everything on plugin deactivation.
register_deactivation_hook( __FILE__, 'k2k_remove_everything' );

/**
 * Flush rewrite rules when plugin is activated.
 */
function k2k_register_everything() {

	flush_rewrite_rules();

}

/**
 * Remove Post Type, Taxonomies, and data and flush rewrite rules on deactivation.
 */
function k2k_remove_everything() {

	unregister_post_type( 'k2k-vocabulary' );
	unregister_post_type( 'k2k-grammar' );
	unregister_post_type( 'k2k-phrases' );

	flush_rewrite_rules();

}

/**
 * Include Template paths
 *
 * @param string $template_path The path to the template.
 */
function k2k_single( $template_path ) {

	if ( get_post_type() === 'k2k-grammar' ) {

		if ( is_single() ) {

			$single_template = locate_template( array( 'single-grammar.php' ), false );

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
add_filter( 'template_include', 'k2k_single', 1 );

/**
 * Custom Taxonomy page
 */
function k2k_custom_taxonomy_pages( $tax_template ) {
	// if ( is_tax( 'level' ) ) {
		$tax_template = dirname( __FILE__ ) . '/taxonomy-level.php';
	// }
	return $tax_template;
}
// add_filter( 'taxonomy_template', 'k2k_custom_taxonomy_pages' );

/**
 * Create filters for custom categories on the CPT admin list page
 *
 * @link https://generatewp.com/filtering-posts-by-taxonomies-in-the-dashboard/
 */
function k2k_filters( $post_type, $which ) {

	// Apply this only on a specific post type.
	if ( 'k2k-grammar' !== $post_type ) {
		return;
	}

	// A list of taxonomy slugs to filter by.
	$taxonomies = array( 'k2k-level', 'k2k-book', 'k2k-part-of-speech', 'k2k-expression', 'k2k-usage' );

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data.
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		if ( empty( $taxonomy_obj ) ) {
			exit;
		}
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms.
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML.
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All %ss', 'k2k' ), $taxonomy_name ) . '</option>';
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
add_action( 'restrict_manage_posts', 'k2k_filters', 10, 2 );

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
 * @link https://milandinic.com/2015/12/01/using-react-jsx-in-wordpress/
 */
function k2k_script_type( $tag, $handle, $src ) {
	// Check that this is output of JSX file.
	if ( 'k2k-components' == $handle ) {
		$tag = str_replace( "<script type='text/javascript'", "<script type='text/babel'", $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'k2k_script_type', 10, 3 );
