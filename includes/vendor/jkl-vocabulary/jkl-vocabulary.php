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

require_once 'includes/functions-vocabulary.php';
require_once 'includes/template-tags-vocabulary.php';

require_once 'includes/post-type-register-vocabulary.php';
require_once 'includes/taxonomy-register-vocab-group.php';
require_once 'includes/metabox-register-vocabulary.php';
