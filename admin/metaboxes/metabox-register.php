<?php
/**
 * JKL Grammar - Register Grammar Metabox.
 *
 * @package JKL Grammar
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'jkl_grammar_register_metabox' );
/**
 * Register a custom metabox for the 'jkl-grammar' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function jkl_grammar_register_metabox() {

	$prefix = 'jkl_grammar_';

	$jkl_g_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Grammar Meta', 'jkl-grammar' ),
			'object_types' => array( 'jkl-grammar' ),
			'closed'       => true,
			'tabs'         => array(
				array(
					'id'     => 'tab-info',
					'icon'   => 'dashicons-editor-alignleft',
					'title'  => esc_html__( 'Info', 'jkl-grammar' ),
					'fields' => array(
						$prefix . 'subtitle',
						$prefix . 'related_grammar',
					),
				),
				array(
					'id'     => 'tab-conjugations',
					'icon'   => 'dashicons-editor-quote',
					'title'  => esc_html__( 'Conjugations', 'jkl-grammar' ),
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
					'title'  => esc_html__( 'Meta', 'jkl-grammar' ),
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
	$jkl_g_metabox->add_field(
		array(
			'name'   => esc_html__( 'Translation (EN)', 'jkl-grammar' ),
			'desc'   => esc_html__( 'The translation will be used as the subtitle.', 'jkl-grammar' ),
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
	$jkl_g_metabox->add_field(
		array(
			'name'    => esc_html__( 'Related Grammar Points', 'jkl-grammar' ),
			'desc'    => __( 'Drag posts from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'jkl-grammar' ),
			'id'      => $prefix . 'related_grammar',
			'type'    => 'custom_attached_posts',
			'column'  => true,
			'options' => array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page' => 10,
					'post_type'      => 'jkl-grammar',
				),
			),
		)
	);

	/**
	 * Conjugations - Past Tense
	 */
	$jkl_g_metabox->add_field(
		array(
			'name' => esc_html__( 'Past Tense', 'jkl-grammar' ),
			'desc' => esc_html__( 'Leave fields blank if no conjugation.', 'jkl-grammar' ),
			'id'   => $prefix . 'past_tense',
			'type' => 'text',
		)
	);

	/**
	 * Conjugations - Present Tense
	 */
	$jkl_g_metabox->add_field(
		array(
			'name' => esc_html__( 'Present Tense', 'jkl-grammar' ),
			// 'desc' => esc_html__( 'Leave blank if no conjugation.', 'jkl-grammar' ),
			'id'   => $prefix . 'present_tense',
			'type' => 'text',
		)
	);

	/**
	 * Conjugations - Future Tense
	 */
	$jkl_g_metabox->add_field(
		array(
			'name' => esc_html__( 'Future Tense', 'jkl-grammar' ),
			// 'desc' => esc_html__( 'Leave blank if no conjugation.', 'jkl-grammar' ),
			'id'   => $prefix . 'future_tense',
			'type' => 'text',
		)
	);

	/**
	 * Conjugations - Other
	 */
	$jkl_g_metabox->add_field(
		array(
			'name' => esc_html__( 'Other Tense', 'jkl-grammar' ),
			// 'desc' => esc_html__( 'Leave blank if no conjugation.', 'jkl-grammar' ),
			'id'   => $prefix . 'other_tense',
			'type' => 'text',
		)
	);

	/**
	 * Meta - Level Selection
	 */
	$jkl_g_metabox->add_field(
		array(
			'name'     => esc_html__( 'Level', 'jkl-grammar' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'jkl-grammar' ),
			'id'       => $prefix . 'level',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'jkl-grammar-level', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Meta - Book Selection
	 */
	$jkl_g_metabox->add_field(
		array(
			'name'     => esc_html__( 'Book', 'jkl-grammar' ),
			'id'       => $prefix . 'book',
			'type'     => 'taxonomy_multicheck_hierarchical', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'jkl-grammar-book', // Taxonomy Slug.
		)
	);

	/**
	 * Meta - Expression Type
	 */
	$jkl_g_metabox->add_field(
		array(
			'name'     => esc_html__( 'Expression', 'jkl-grammar' ),
			'id'       => $prefix . 'expression',
			'type'     => 'taxonomy_radio', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'jkl-grammar-expression', // Taxonomy Slug.
		)
	);

	/**
	 * Meta - Part of Speech
	 */
	$jkl_g_metabox->add_field(
		array(
			'name'     => esc_html__( 'Part of Speech', 'jkl-grammar' ),
			'id'       => $prefix . 'part_of_speech',
			'type'     => 'taxonomy_multicheck_inline', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'jkl-grammar-part-of-speech', // Taxonomy Slug.
		)
	);

	/**
	 * Meta - Usage Selection
	 */
	$jkl_g_metabox->add_field(
		array(
			'name'     => esc_html__( 'Usage', 'jkl-grammar' ),
			'id'       => $prefix . 'usage',
			'type'     => 'taxonomy_multicheck_hierarchical', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'jkl-grammar-usage', // Taxonomy Slug.
		)
	);

}
