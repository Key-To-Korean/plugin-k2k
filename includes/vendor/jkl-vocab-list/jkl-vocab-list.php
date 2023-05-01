<?php
/**
 * JKL Vocab LISTS - Main Plugin file
 *
 * @package JKLVL
 */

/*
 * Plugin Name: JKL Vocab LISTS
 * Plugin URI: https://github.com/Key-To-Korean/plugin-k2k
 * Description: Custom plugin to manage Vocab LISTS Post Types and Taxonomies.
 * Version: 2.0.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jklv
 * Domain Path: /languages
 */

/*
JKL Vocab LISTS is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

JKL Vocab LISTS is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JKL Vocab LISTS. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Function files */
require_once 'includes/functions-vocab-list.php';
require_once 'includes/template-tags-vocab-list.php';

/* Taxonomies */
require_once 'includes/admin/taxonomy-register-vocab-list-level.php';
require_once 'includes/admin/taxonomy-register-vocab-list-book.php';

/* Post Type management */
require_once 'includes/admin/post-type-register-vocab-list.php';
require_once 'includes/admin/metabox-register-vocab-list.php';

