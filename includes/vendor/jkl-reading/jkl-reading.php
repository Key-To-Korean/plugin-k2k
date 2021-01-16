<?php
/**
 * JKL Reading - Main Plugin file
 *
 * @package JKLG
 */

/*
 * Plugin Name: JKL Reading
 * Plugin URI: https://github.com/jekkilekki/plugin-k2k
 * Description: Custom plugin to manage Reading Post Types and Taxonomies.
 * Version: 1.2.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jkl-reading
 * Domain Path: /languages
 */

/*
JKL Reading is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

JKL Reading is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JKL Reading. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Function files */
require_once 'includes/functions-reading.php';
require_once 'includes/template-tags-reading.php';

/*
 * Include Reading Taxonomies BEFORE Post Type to be sure of the right permalink structure
 * @link https://cnpagency.com/blog/the-right-way-to-do-wordpress-custom-taxonomy-rewrites/
 */
require_once 'includes/admin/taxonomy-register-reading-level.php';
require_once 'includes/admin/taxonomy-register-reading-genre.php';
require_once 'includes/admin/taxonomy-register-reading-topic.php';
require_once 'includes/admin/taxonomy-register-reading-type.php';
require_once 'includes/admin/taxonomy-register-reading-source.php';
require_once 'includes/admin/taxonomy-register-reading-author.php';
require_once 'includes/admin/taxonomy-register-reading-length.php';

/* Post Type management */
require_once 'includes/admin/post-type-register-reading.php';
require_once 'includes/admin/metabox-register-reading.php';

/* Additional meta - only for Reading sources */

// require_once 'includes/admin/metabox-taxonomy-weblinks.php';.
