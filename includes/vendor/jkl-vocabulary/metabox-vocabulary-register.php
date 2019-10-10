<?php
/**
 * K2K - Register Vocabulary Metabox.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_metabox_vocabulary' );
/**
 * Register a custom metabox for the 'k2k-vocabulary' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function k2k_register_metabox_vocabulary() {

	$prefix = 'k2k_vocab_meta_';

	$k2k_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Vocabulary Meta', 'k2k' ),
			'object_types' => array( 'k2k-vocabulary' ),
			'closed'       => false,
			'tabs'         => array(
				array(
					'id'     => 'tab-info',
					'icon'   => 'dashicons-editor-alignleft',
					'title'  => esc_html__( 'Info', 'k2k' ),
					'fields' => array(
						$prefix . 'subtitle',
						$prefix . 'level',
						$prefix . 'part_of_speech',
						$prefix . 'definitions',
						$prefix . 'sentences',
					),
				),
				array(
					'id'     => 'tab-related',
					'icon'   => 'dashicons-editor-quote',
					'title'  => esc_html__( 'Related', 'k2k' ),
					'fields' => array(
						$prefix . 'topic',
						$prefix . 'synonyms',
						$prefix . 'antonyms',
						$prefix . 'hanja',
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
	 * Info - Topic Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Topic', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'topic',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-topic', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
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
	 * Meta - Part of Speech
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Part of Speech', 'k2k' ),
			'id'       => $prefix . 'part_of_speech',
			'type'     => 'taxonomy_radio_inline', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-part-of-speech', // Taxonomy Slug.
		)
	);

	/**
	 * Repeating text field for definitions.
	 */
	$k2k_metabox->add_field(
		array(
			'id'             => $prefix . 'definitions',
			'name'           => __( 'Definition(s)', 'k2k' ),
			'type'           => 'text',
			'sortable'       => true,
			'repeatable'     => true,
			'repeatable_max' => 10,
			'text'           => array(
				'add_row_text' => __( 'Add Definition', 'k2k' ),
			),
		)
	);

	/**
	 * Info - Synonyms
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Synonyms', 'k2k' ),
			'id'      => $prefix . 'synonyms',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'filter_boxes' => true,
				'query_args'   => array(
					'posts_per_page' => 10,
					'post_type'      => 'k2k-vocabulary',
				),
			),
		)
	);

	/**
	 * Info - Antonyms
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Antonyms', 'k2k' ),
			'id'      => $prefix . 'antonyms',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'filter_boxes' => true,
				'query_args'   => array(
					'posts_per_page' => 10,
					'post_type'      => 'k2k-vocabulary',
				),
			),
		)
	);

	/**
	 * Info - Hanja
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Hanja', 'k2k' ),
			'id'      => $prefix . 'hanja',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'filter_boxes' => true,
				'query_args'   => array(
					'posts_per_page' => 10,
					'post_type'      => 'k2k-vocabulary',
				),
			),
		)
	);

	/**
	 * Repeating text field for sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentence_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'sentences',
			'type'        => 'group',
			'description' => __( 'Example Sentences. Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Sentence', 'k2k' ),
				'add_button'    => __( 'Add Another Sentence', 'k2k' ),
				'remove_button' => __( 'Remove Sentence', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_group,
		array(
			'id'              => $prefix . 'sentences_1',
			'name'            => __( 'Original (KO)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_group,
		array(
			'id'              => $prefix . 'sentences_2',
			'name'            => __( 'Translation (EN)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

}

/**
 * Custom sanitization function for sentences.
 *
 * @param string $value The value to be sanitized and saved.
 * @param array  $field_args The arguments for sanitization.
 * @param string $field The field we are using.
 *
 * @return string The sanitized value - with allowed tags.
 */
function k2k_sanitize_sentence_callback( $value, $field_args, $field ) {

	/* Custom sanitization - with strip_tags to allow certain tags. */
	$value = strip_tags( $value, '<b><strong><em><span>' );

	return $value;

}
