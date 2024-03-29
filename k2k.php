<?php
/**
 * K2K - Main Plugin file
 *
 * @package K2K
 */

/*
 * Plugin Name: K2K
 * Plugin URI: https://github.com/Key-To-Korean/plugin-k2k
 * Description: Custom plugin to manage KeyToKorean.com
 * Version: 1.3.0
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
define( 'K2K_VERSION', '1.3.0' );
define( 'K2K_DOMAIN', 'k2k' );
define( 'K2K_PATH', plugin_dir_path( __FILE__ ) );
define( 'K2K_MENU_POSITION', 50 );
define( 
	'K2K_POST_TYPES',  // Used in functions.php.
	array( 
		'k2k-vocab-list', 
		'k2k-vocabulary', 
		'k2k-grammar', 
		'k2k-phrases', 
		'k2k-reading', 
		'k2k-writing' 
		) 
	);
define(
	'K2K_TAXES', // Used in /includes/shared/metaboxes/metabox-taxonomy-extras.php.
	array(
		// WordPress.
		'category',
		'post_tag',

		// Vocab LISTS.
		'k2k-vocab-list-level',
		'k2k-vocab-list-book',

		// Vocabulary.
		'k2k-vocab-level',
		'k2k-vocab-part-of-speech',
		'k2k-vocab-topic',
		'k2k-vocab-group',

		// Grammar.
		'k2k-grammar-level',
		'k2k-grammar-part-of-speech',
		'k2k-grammar-expression',
		'k2k-grammar-book',
		'k2k-grammar-tenses',
		'k2k-grammar-usage',

		// Phrases.
		'k2k-phrase-topic',
		'k2k-phrase-type',
		'k2k-phrase-source',

		// Reading.
		'k2k-reading-level',
		'k2k-reading-length',
		'k2k-reading-genre',
		'k2k-reading-topic',
		'k2k-reading-type',
		'k2k-reading-source',
		'k2k-reading-author',

		// Writing.
		'k2k-writing-level',
		'k2k-writing-length',
		'k2k-writing-topic',
		'k2k-writing-type',
		'k2k-writing-source',
	)
);
define(
	'K2K_COLORS', // Used in /includes/shared/metaboxes/metabox-taxonomy-term-color.php.
	array(
		'#00897b', // Teal dark.
		'#00bfa5', // Teal.
		'#ff8f00', // Amber dark.
		'#ffab00', // Amber.
		'#e91e63', // Pink dark.
		'#ff4081', // Pink.
		'#9c27b0', // Purple dark.
		'#e040fb', // Purple.
		'#0277bd', // Blue dark.
		'#00b0ff', // Blue.
		'#7b8792', // Grey darkest.
		'#8795a1', // Grey darker.
		'#95a4b1', // Grey dark.
		'#a9bac9', // Grey.
		'#cf8031', // Gold.
	)
);

/**
 * Load Text Domain.
 */
function k2k_load_textdomain() {
	load_plugin_textdomain( 'k2k', false, plugin_dir_path( __FILE__ ) . 'languages/' );
}
add_action( 'plugins_loaded', 'k2k_load_textdomain' );

// Load Functions and Plugin Options files.
require_once K2K_PATH . 'includes/functions.php';
require_once K2K_PATH . 'includes/plugin-options.php';

// Include CMB2 and helpers.
require_once K2K_PATH . 'includes/vendor/cmb2/init.php';
require_once K2K_PATH . 'includes/vendor/cmb2-extras/cmb2-tabs/cmb2-tabs.php';
require_once K2K_PATH . 'includes/vendor/cmb2-extras/cmb2-attached-posts/cmb2-attached-posts-field.php';
require_once K2K_PATH . 'includes/vendor/cmb2-extras/cmb2-switch-button/class-cmb2-switch-button.php';
require_once K2K_PATH . 'includes/vendor/cmb2-extras/cmb2-grid/Cmb2GridPlugin.php';
require_once K2K_PATH . 'includes/vendor/cmb2-extras/cmb2-field-type-tags/cmb2-field-type-tags.php';

/*
 * Conditionally Load files to add additional meta data to WordPress.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_user_meta' ) ) {
	require_once K2K_PATH . 'includes/shared/metaboxes/metabox-user-profile-extras.php';
}
if ( 'on' === k2k_get_option( 'k2k_enable_tax_meta' ) ) {
	require_once K2K_PATH . 'includes/shared/metaboxes/metabox-taxonomy-extras.php';
}

// CMB2 Full Examples (Theme Options Menu item).
require_once K2K_PATH . 'includes/shared/metaboxes/example-functions.php';

/**
 * Conditionally Load Custom Post Types and Taxonomies.
 */
if ( k2k_any_cpt_enabled() ) {

	// Include Post Type(s).
	require_once K2K_PATH . 'includes/shared/post-types/post-type-filters.php';
	require_once K2K_PATH . 'includes/template-tags.php';

	// Include Shared Taxonomies.
	// require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-level.php';          // Grammar, Vocabulary, Phrases.
	// require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-part-of-speech.php'; // Grammar, Vocabulary.
	// require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-expression.php';     // Grammar, Phrases.
	// require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-topic.php';          // Vocabulary, Phrases.
	require_once K2K_PATH . 'includes/shared/metaboxes/metabox-taxonomy-term-color.php';

}

/** Vocab LISTS Post Type */
if ( 'on' === k2k_get_option( 'k2k_enable_vocab_list' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-vocab-list/jkl-vocab-list.php';
}

/** Vocabulary Post Type */
if ( 'on' === k2k_get_option( 'k2k_enable_vocab' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-vocabulary/jkl-vocabulary.php';
}

/** Grammar Post Type */
if ( 'on' === k2k_get_option( 'k2k_enable_grammar' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-grammar/jkl-grammar.php';
}

/** Phrases Post Type */
if ( 'on' === k2k_get_option( 'k2k_enable_phrases' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-phrases/jkl-phrases.php';
}

/**
 * Reading (LWT) Post Type.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_reading' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-reading/jkl-reading.php';
}

/**
 * Writing Post Type.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_writing' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-writing/jkl-writing.php';
	// require_once K2K_PATH . 'includes/vendor/jkl-writing/metabox-writing-register.php';.
}

/**
 * Return true if any of our Custom Post Types are enabled.
 */
function k2k_any_cpt_enabled() {
	return (
		'on' === k2k_get_option( 'k2k_enable_vocab_list' )
		|| 'on' === k2k_get_option( 'k2k_enable_vocab' )
		|| 'on' === k2k_get_option( 'k2k_enable_grammar' )
		|| 'on' === k2k_get_option( 'k2k_enable_phrases' )
		|| 'on' === k2k_get_option( 'k2k_enable_reading' )
		|| 'on' === k2k_get_option( 'k2k_enable_writing' )
	);
}

/**
 * Modify the main WP_Query to include our custom Post Types.
 *
 * This function modifies the main WordPress query to include an array of
 * post types including of the default 'post' post type.
 *
 * @param object $query The main WordPress query.
 */
function k2k_include_custom_post_types_in_main_query( $query ) {
	// First, figure out which post types are enabled, and so which to include.
	$post_types = array( 'post' ); // Start with the default.

	// Add k2k-vocabulary if enabled. (Disable for now.)

	// Add k2k-vocab-list if enabled. (Yes, add vocabulary _lists_ to the main query).
	if ( 'on' === k2k_get_option( 'k2k_enable_vocab_list' ) ) {
		$post_types[] = 'k2k-vocab-list';
	}

	// Add k2k-grammar if enabled.
	if ( 'on' === k2k_get_option( 'k2k_enable_grammar' ) ) {
		$post_types[] = 'k2k-grammar';
	}
	// Add k2k-phrases if enabled.
	if ( 'on' === k2k_get_option( 'k2k_enable_phrases' ) ) {
		$post_types[] = 'k2k-phrases';
	}
	// Add k2k-reading if enabled.
	if ( 'on' === k2k_get_option( 'k2k_enable_reading' ) ) {
		$post_types[] = 'k2k-reading';
	}
	// Add k2k-writing if enabled.
	if ( 'on' === k2k_get_option( 'k2k_enable_writing' ) ) {
		$post_types[] = 'k2k-writing';
	}

	// Include custom post types on the Home Page.
	if ( $query->is_main_query() && ( $query->is_home() || $query->is_front_page() ) ) {
		$query->set( 'post_type', $post_types );
	}

	// Include custom post types in Search Results.
	if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
			$query->set( 'post_type', $post_types );
	}

	// Include custom post types in Archive Pages.
	if ( $query->is_main_query() && (
		$query->is_date() || $query->is_author() || $query->is_category() || $query->is_tag() || $query->is_tax()
	) ) {
		$query->set( 'post_type', $post_types );
	}

	// $query->set( 'post_type', $post_types );
}
add_action( 'pre_get_posts', 'k2k_include_custom_post_types_in_main_query', 10, 1 );

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

	// Unregister Post Types.
	unregister_post_type( 'k2k-vocab-list' );
	unregister_post_type( 'k2k-vocabulary' );
	unregister_post_type( 'k2k-grammar' );
	unregister_post_type( 'k2k-phrases' );
	unregister_post_type( 'k2k-reading' );
	unregister_post_type( 'k2k-writing' );

	// Unregister Taxonomies.
	// Vocab Lists.
	unregister_taxonomy( 'k2k-vocab-list-level' );
	unregister_taxonomy( 'k2k-vocab-list-book' );

	// Vocabulary.
	unregister_taxonomy( 'k2k-vocab-level' );
	unregister_taxonomy( 'k2k-vocab-part-of-speech' );
	unregister_taxonomy( 'k2k-vocab-topic' );
	unregister_taxonomy( 'k2k-vocab-group' );

	// Grammar.
	unregister_taxonomy( 'k2k-grammar-level' );
	unregister_taxonomy( 'k2k-grammar-part-of-speech' );
	unregister_taxonomy( 'k2k-grammar-expression' );
	unregister_taxonomy( 'k2k-grammar-book' );
	unregister_taxonomy( 'k2k-grammar-tenses' );
	unregister_taxonomy( 'k2k-grammar-usage' );

	// Phrases.
	unregister_taxonomy( 'k2k-phrase-topic' );
	unregister_taxonomy( 'k2k-phrase-type' );
	unregister_taxonomy( 'k2k-phrase-source' );

	// Reading.
	unregister_taxonomy( 'k2k-reading-level' );
	unregister_taxonomy( 'k2k-reading-length' );
	unregister_taxonomy( 'k2k-reading-genre' );
	unregister_taxonomy( 'k2k-reading-topic' );
	unregister_taxonomy( 'k2k-reading-source' );

	// Writing.
	unregister_taxonomy( 'k2k-writing-level' );
	unregister_taxonomy( 'k2k-writing-length' );
	unregister_taxonomy( 'k2k-writing-topic' );
	unregister_taxonomy( 'k2k-writing-type' );
	unregister_taxonomy( 'k2k-writing-source' );

	flush_rewrite_rules();

}
