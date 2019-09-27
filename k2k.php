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

// Load Functions file.
require_once K2K_PATH . 'includes/functions.php';

// Include CMB2 and helpers.
require_once K2K_PATH . 'includes/vendor/cmb2/init.php';
require_once K2K_PATH . 'includes/vendor/cmb2-tabs/cmb2-tabs.php';
require_once K2K_PATH . 'includes/vendor/cmb2-attached-posts/cmb2-attached-posts-field.php';

// Include General Metaboxes.
// require_once K2K_PATH . 'admin/metaboxes/example-functions.php';.
require_once K2K_PATH . 'admin/metaboxes/metabox-plugin-options.php';
require_once K2K_PATH . 'admin/metaboxes/metabox-user-profile-extras.php';
require_once K2K_PATH . 'admin/metaboxes/metabox-taxonomy-extras.php';

// Include CPT Metaboxes.
require_once K2K_PATH . 'admin/metaboxes/metabox-grammar-register.php';
// require_once K2K_PATH . 'admin/metaboxes/metabox-vocabulary-register.php';
// require_once K2K_PATH . 'admin/metaboxes/metabox-phrases-register.php';.

// Include Post Type(s).
require_once K2K_PATH . 'admin/post-types/post-type-filters.php';
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
