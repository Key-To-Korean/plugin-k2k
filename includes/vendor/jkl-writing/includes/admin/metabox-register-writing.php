<?php
/**
 * K2K - Register Writing Metabox.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_metabox_writing' );
/**
 * Register a custom metabox for the 'k2k-writing' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function k2k_register_metabox_writing() {

	$prefix = 'k2k_writing_meta_';

	$k2k_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Writing Meta', 'k2k' ),
			'object_types' => array( 'k2k-writing' ),
			'closed'       => false,
			'tabs'         => array(
				array(
					'id'     => 'tab-info',
					'icon'   => 'dashicons-info',
					'title'  => esc_html__( 'Info', 'k2k' ),
					'fields' => array(
						$prefix . 'subtitle',
						$prefix . 'author',
						$prefix . 'level',
						$prefix . 'length',
						$prefix . 'video',
						$prefix . 'genre',
						$prefix . 'topic',
						$prefix . 'wysiwyg_ko',
						$prefix . 'wysiwyg_en',
						$prefix . 'source',
						$prefix . 'ref',
					),
				),
				array(
					'id'     => 'tab-questions',
					'icon'   => 'dashicons-editor-help',
					'title'  => esc_html__( 'Questions', 'k2k' ),
					'fields' => array(
						$prefix . 'questions',
						$prefix . 'question_text',
						$prefix . 'answers',
						$prefix . 'correct_answer',
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
			'column' => array( 'position' => 2 ),
		)
	);

	/**
	 * Info - Author Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Author', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'author',
			'type'     => 'taxonomy_select',
			'taxonomy' => 'k2k-writing-author', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Info - Level Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Level', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'level',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-writing-level', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Info - Length Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Length', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'length',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-writing-length', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Info - Video (YouTube)
	 */
	$k2k_metabox->add_field(
		array(
			'name'   => esc_html__( 'YouTube video', 'k2k' ),
			// 'desc'   => esc_html__( 'The translation will be used as the subtitle.', 'k2k' ),
			'id'     => $prefix . 'video',
			'type'   => 'text',
		)
	);

	/**
	 * Info - Genre
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Genre', 'k2k' ),
			'id'       => $prefix . 'genre',
			'type'     => 'taxonomy_select', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-writing-genre', // Taxonomy Slug.
		)
	);

	/**
	 * Info - Topic
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Topic', 'k2k' ),
			'id'       => $prefix . 'topic',
			'type'     => 'taxonomy_select', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-writing-topic', // Taxonomy Slug.
		)
	);

	/**
	 * Korean text - Wysiwyg
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Full Korean Text', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'wysiwyg_ko',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 15 ),
			),
		)
	);

	/**
	 * English text - Wysiwyg
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'English Text', 'k2k' ),
			'desc'    => esc_html__( 'Add translation text if available.', 'k2k' ),
			'id'      => $prefix . 'wysiwyg_en',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 15 ),
			),
		)
	);

	/**
	 * Info - Source
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Source', 'k2k' ),
			'id'       => $prefix . 'source',
			'type'     => 'taxonomy_select', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-writing-source', // Taxonomy Slug.
		)
	);

	/**
	 * Info - Reference
	 */
	$k2k_metabox->add_field(
		array(
			'name'   => esc_html__( 'Reference Link', 'k2k' ),
			// 'desc'   => esc_html__( 'The translation will be used as the subtitle.', 'k2k' ),
			'id'     => $prefix . 'ref',
			'type'   => 'text',
		)
	);

	/**
	 * Repeating text field for PAST TENSE sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$practice_questions = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'questions',
			'type'        => 'group',
			'name'        => __( 'Practice Questions', 'k2k' ),
			'description' => __( 'Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;.<br />You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Practice Questions', 'k2k' ),
				'add_button'    => __( 'Add Another Question', 'k2k' ),
				'remove_button' => __( 'Remove Question', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$practice_questions,
		array(
			'id'              => $prefix . 'question_text',
			'name'            => __( 'Question', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	/**
	 * Repeating text field for exercises.
	 */
	$k2k_metabox->add_group_field(
		$practice_questions,
		array(
			'id'              => $prefix . 'answers',
			'name'            => __( 'Answers', 'k2k' ),
			'description'     => __( 'Add optional answers.', 'k2k' ),
			'type'            => 'text',
			'sortable'        => true,
			'repeatable'      => true,
			'repeatable_max'  => 10,
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
			'text'            => array(
				'add_row_text' => __( 'Add Answer', 'k2k' ),
			),
		)
	);

	/**
	 * Number text input for the number of the correct answer.
	 */
	$k2k_metabox->add_group_field(
		$practice_questions,
		array(
			'name'            => __( 'Correct Answer #', 'k2k' ),
			'desc'            => __( 'Numbers only', 'k2k' ),
			'id'              => $prefix . 'correct_answer',
			'type'            => 'text',
			'attributes'      => array(
				'type'    => 'number',
				'pattern' => '\d*',
			),
			'sanitization_cb' => 'absint',
			'escape_cb'       => 'absint',
		)
	);

}
