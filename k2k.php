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
define( 'K2K_POST_TYPES', array( 'k2k-vocabulary', 'k2k-grammar', 'k2k-phrases', 'k2k-reading', 'k2k-writing' ) ); // Used in functions.php.
define(
	'K2K_TAXES', // Used in /includes/shared/metaboxes/metabox-taxonomy-extras.php.
	array(
		'category',
		'post_tag',
		'k2k-expression',
		'k2k-book',
		'k2k-tenses',
		'k2k-usage',
		'k2k-level',
		'k2k-part-of-speech',
		'k2k-phrase-type',
		'k2k-topic',
		'k2k-vocab-group',
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
	require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-level.php';          // Grammar, Vocabulary, Phrases.
	require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-part-of-speech.php'; // Grammar, Vocabulary.
	require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-expression.php';     // Grammar, Phrases.
	require_once K2K_PATH . 'includes/shared/taxonomies/taxonomy-register-topic.php';          // Vocabulary, Phrases.
	require_once K2K_PATH . 'includes/shared/metaboxes/metabox-taxonomy-term-color.php';

}

/**
 * Vocabulary Post Type.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_vocab' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-vocabulary/post-type-vocabulary-register.php';
	require_once K2K_PATH . 'includes/vendor/jkl-vocabulary/taxonomy-register-vocab-group.php';
	require_once K2K_PATH . 'includes/vendor/jkl-vocabulary/metabox-vocabulary-register.php';
}

/**
 * Grammar Post Type.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_grammar' ) ) {

	require_once K2K_PATH . 'includes/vendor/jkl-grammar/post-type-grammar-register.php';
	require_once K2K_PATH . 'includes/vendor/jkl-grammar/metabox-grammar-register.php';

	// Include Grammar Taxonomies.
	require_once K2K_PATH . 'includes/vendor/jkl-grammar/taxonomy-register-grammar-book.php';
	require_once K2K_PATH . 'includes/vendor/jkl-grammar/taxonomy-register-grammar-tenses.php';
	require_once K2K_PATH . 'includes/vendor/jkl-grammar/taxonomy-register-grammar-usage.php';
	require_once K2K_PATH . 'includes/vendor/jkl-grammar/metabox-taxonomy-weblinks.php';


}

/**
 * Phrases Post Type.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_phrases' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-phrases/post-type-phrases-register.php';
	require_once K2K_PATH . 'includes/vendor/jkl-phrases/metabox-phrases-register.php';
	require_once K2K_PATH . 'includes/vendor/jkl-phrases/taxonomy-register-phrase-type.php';
}

/**
 * Reading (LWT) Post Type.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_reading' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-reading/post-type-reading-register.php';
	// require_once K2K_PATH . 'includes/vendor/jkl-reading/metabox-reading-register.php';.
}

/**
 * Writing Post Type.
 */
if ( 'on' === k2k_get_option( 'k2k_enable_writing' ) ) {
	require_once K2K_PATH . 'includes/vendor/jkl-writing/post-type-writing-register.php';
	// require_once K2K_PATH . 'includes/vendor/jkl-writing/metabox-writing-register.php';.
}

/**
 * Return true if any of our Custom Post Types are enabled.
 */
function k2k_any_cpt_enabled() {
	return (
		'on' === k2k_get_option( 'k2k_enable_vocab' )
		|| 'on' === k2k_get_option( 'k2k_enable_grammar' )
		|| 'on' === k2k_get_option( 'k2k_enable_phrases' )
		|| 'on' === k2k_get_option( 'k2k_enable_reading' )
		|| 'on' === k2k_get_option( 'k2k_enable_writing' )
	);
}

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
