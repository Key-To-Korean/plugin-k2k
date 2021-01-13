<?php
/**
 * JKL Phrases - Main Plugin file
 *
 * @package JKLP
 */

/*
 * Plugin Name: JKL Phrases
 * Plugin URI: https://github.com/jekkilekki/plugin-k2k
 * Description: Custom plugin to manage Phrases Post Types and Taxonomies.
 * Version: 1.0.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jkl-phrases
 * Domain Path: /languages
 */

/*
JKL Phrases is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

JKL Phrases is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JKL Phrases. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Function files */
require_once 'includes/functions-phrases.php';
require_once 'includes/template-tags-phrases.php';

/* Include Grammar Taxonomies */
require_once 'includes/admin/taxonomy-register-phrase-type.php';
require_once 'includes/admin/taxonomy-register-phrase-topic.php';

/* Post Type management */
require_once 'includes/admin/post-type-register-phrases.php';
require_once 'includes/admin/metabox-register-phrases.php';
