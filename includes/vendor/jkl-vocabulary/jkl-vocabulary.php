<?php
/**
 * JKL Vocabulary - Main Plugin file
 *
 * @package JKLV
 */

/*
 * Plugin Name: JKL Vocabulary
 * Plugin URI: https://github.com/jekkilekki/plugin-k2k
 * Description: Custom plugin to manage Vocabulary Post Types and Taxonomies.
 * Version: 1.0.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jklv
 * Domain Path: /languages
 */

/*
JKL Vocabulary is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

JKL Vocabulary is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JKL Vocabulary. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Function files */
require_once 'includes/functions-vocabulary.php';
require_once 'includes/template-tags-vocabulary.php';

/* Taxonomies */
require_once 'includes/admin/taxonomy-register-vocab-level.php';
require_once 'includes/admin/taxonomy-register-vocab-part-of-speech.php';
require_once 'includes/admin/taxonomy-register-vocab-topic.php';
require_once 'includes/admin/taxonomy-register-vocab-group.php';

/* Post Type management */
require_once 'includes/admin/post-type-register-vocabulary.php';
require_once 'includes/admin/metabox-register-vocabulary.php';

