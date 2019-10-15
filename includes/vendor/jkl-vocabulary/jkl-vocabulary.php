<?php
/**
 * JKL Vocabulary Post Type.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Function files */
require_once 'includes/functions-vocabulary.php';
require_once 'includes/template-tags-vocabulary.php';

/* Post Type management */
require_once 'includes/post-type-register-vocabulary.php';
require_once 'includes/metabox-register-vocabulary.php';

/* Taxonomies */
// require_once 'includes/taxonomy-register-vocab-level.php';
// require_once 'includes/taxonomy-register-vocab-part-of-speech.php';
// require_once 'includes/taxonomy-register-vocab-topic.php';
require_once 'includes/taxonomy-register-vocab-group.php';

