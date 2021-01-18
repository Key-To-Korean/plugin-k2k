<?php
/**
 * JKL Writing - Main Plugin file
 *
 * @package JKLW
 */

/*
 * Plugin Name: JKL Writing
 * Plugin URI: https://github.com/jekkilekki/plugin-k2k
 * Description: Custom plugin to manage Writing Post Types and Taxonomies.
 * Version: 1.2.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jkl-writing
 * Domain Path: /languages
 */

/*
JKL Writing is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

JKL Writing is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JKL Writing. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Function files */
require_once 'includes/functions-writing.php';
require_once 'includes/template-tags-writing.php';

/*
 * Include Writing Taxonomies BEFORE Post Type to be sure of the right permalink structure
 * @link https://cnpagency.com/blog/the-right-way-to-do-wordpress-custom-taxonomy-rewrites/
 */
require_once 'includes/admin/taxonomy-register-writing-level.php';
require_once 'includes/admin/taxonomy-register-writing-topic.php';
require_once 'includes/admin/taxonomy-register-writing-type.php';
require_once 'includes/admin/taxonomy-register-writing-length.php';
require_once 'includes/admin/taxonomy-register-writing-source.php';

/* Post Type management */
require_once 'includes/admin/post-type-register-writing.php';
require_once 'includes/admin/metabox-register-writing.php';

/* Additional meta - only for Writing sources */

// require_once 'includes/admin/metabox-taxonomy-weblinks.php';.
