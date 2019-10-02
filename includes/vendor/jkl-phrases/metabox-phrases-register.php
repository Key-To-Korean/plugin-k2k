<?php
/**
 * K2K - Register Phrases Metabox.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_metabox_phrases' );
/**
 * Register a custom metabox for the 'k2k' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function k2k_register_metabox_phrases() {

	$prefix = 'k2k_phrase_meta_';

	$k2k_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Phrases Meta', 'k2k' ),
			'object_types' => array( 'k2k-phrases' ),
			'closed'       => false,
		)
	);

	/**
	 * Info - Translation (Subtitle)
	 */
	$k2k_metabox->add_field(
		array(
			'name'   => esc_html__( 'Translation (EN)', 'k2k' ),
			'desc'   => esc_html__( 'The translation will be used as the subtitle.', 'k2k' ),
			'id'     => $prefix . 'subtitle',
			'type'   => 'text',
			'column' => array( 'position' => 2 ),
		)
	);

	/**
	 * Info - Detailed Description
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Detailed Explanation', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'wysiwyg',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
			),
		)
	);

	/**
	 * Info - Expression Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Expression', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'expression',
			'type'     => 'taxonomy_checkbox',
			'taxonomy' => 'k2k-expressions', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

}
