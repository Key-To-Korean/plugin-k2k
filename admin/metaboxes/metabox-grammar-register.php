<?php
/**
 * K2K - Register Grammar Metabox.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_metabox' );
/**
 * Register a custom metabox for the 'k2k' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function k2k_register_metabox() {

	$prefix = 'k2k_';

	$k2k_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Grammar Meta', 'k2k' ),
			'object_types' => array( 'k2k-grammar' ),
			'closed'       => true,
			'tabs'         => array(
				array(
					'id'     => 'tab-info',
					'icon'   => 'dashicons-editor-alignleft',
					'title'  => esc_html__( 'Info', 'k2k' ),
					'fields' => array(
						$prefix . 'subtitle',
						$prefix . 'related_grammar',
					),
				),
				array(
					'id'     => 'tab-conjugations',
					'icon'   => 'dashicons-editor-quote',
					'title'  => esc_html__( 'Conjugations', 'k2k' ),
					'fields' => array(
						$prefix . 'past_tense',
						$prefix . 'present_tense',
						$prefix . 'future_tense',
						$prefix . 'other_tense',
					),
				),
				array(
					'id'     => 'tab-meta',
					'icon'   => 'dashicons-nametag',
					'title'  => esc_html__( 'Meta', 'k2k' ),
					'fields' => array(
						$prefix . 'book',
						$prefix . 'level',
						$prefix . 'expression',
						$prefix . 'part_of_speech',
						$prefix . 'usage',
					),
				),
			),
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
			'column' => true,
		)
	);

	/**
	 * Info - Related Grammar Points
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Related Grammar Points', 'k2k' ),
			'desc'    => __( 'Drag posts from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'k2k' ),
			'id'      => $prefix . 'related_grammar',
			'type'    => 'custom_attached_posts',
			'column'  => true,
			'options' => array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page' => 10,
					'post_type'      => 'k2k',
				),
			),
		)
	);

	/**
	 * Conjugations - Past Tense
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Past Tense', 'k2k' ),
			'desc' => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'   => $prefix . 'past_tense',
			'type' => 'text',
		)
	);

	/**
	 * Conjugations - Present Tense
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Present Tense', 'k2k' ),
			// 'desc' => esc_html__( 'Leave blank if no conjugation.', 'k2k' ),
			'id'   => $prefix . 'present_tense',
			'type' => 'text',
		)
	);

	/**
	 * Conjugations - Future Tense
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Future Tense', 'k2k' ),
			// 'desc' => esc_html__( 'Leave blank if no conjugation.', 'k2k' ),
			'id'   => $prefix . 'future_tense',
			'type' => 'text',
		)
	);

	/**
	 * Conjugations - Other
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Other Tense', 'k2k' ),
			// 'desc' => esc_html__( 'Leave blank if no conjugation.', 'k2k' ),
			'id'   => $prefix . 'other_tense',
			'type' => 'text',
		)
	);

	/**
	 * Meta - Level Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Level', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'level',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-level', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Meta - Book Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Book', 'k2k' ),
			'id'       => $prefix . 'book',
			'type'     => 'taxonomy_multicheck_hierarchical', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-book', // Taxonomy Slug.
		)
	);

	/**
	 * Meta - Expression Type
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Expression', 'k2k' ),
			'id'       => $prefix . 'expression',
			'type'     => 'taxonomy_radio', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-expression', // Taxonomy Slug.
		)
	);

	/**
	 * Meta - Part of Speech
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Part of Speech', 'k2k' ),
			'id'       => $prefix . 'part_of_speech',
			'type'     => 'taxonomy_multicheck_inline', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-part-of-speech', // Taxonomy Slug.
		)
	);

	/**
	 * Meta - Usage Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Usage', 'k2k' ),
			'id'       => $prefix . 'usage',
			'type'     => 'taxonomy_multicheck_hierarchical', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-usage', // Taxonomy Slug.
		)
	);

}
