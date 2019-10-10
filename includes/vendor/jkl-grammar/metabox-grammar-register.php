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

add_action( 'cmb2_admin_init', 'k2k_register_metabox_grammar' );
/**
 * Register a custom metabox for the 'k2k-grammar' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function k2k_register_metabox_grammar() {

	$prefix = 'k2k_grammar_meta_';

	$k2k_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Grammar Meta', 'k2k' ),
			'object_types' => array( 'k2k-grammar' ),
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
						$prefix . 'tenses',
						$prefix . 'expression',
						$prefix . 'usage',
					),
				),
				array(
					'id'     => 'tab-conjugations',
					'icon'   => 'dashicons-editor-quote',
					'title'  => esc_html__( 'Details & Conjugations', 'k2k' ),
					'fields' => array(
						$prefix . 'wysiwyg',
						$prefix . 'adjectives',
						$prefix . 'verbs',
						$prefix . 'nouns',
					),
				),
				array(
					'id'     => 'tab-more',
					'icon'   => 'dashicons-nametag',
					'title'  => esc_html__( 'More', 'k2k' ),
					'fields' => array(
						$prefix . 'sentences',
						$prefix . 'exercises',
						$prefix . 'book',
						$prefix . 'related_grammar',
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
	 * Info - Level Selection
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
	 * Info - Part of Speech
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
	 * Info - Tenses
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Tenses', 'k2k' ),
			'id'       => $prefix . 'tenses',
			'type'     => 'taxonomy_multicheck_inline', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-tenses', // Taxonomy Slug.
		)
	);

	/**
	 * Info - Usage Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Usage', 'k2k' ),
			'id'       => $prefix . 'usage',
			'type'     => 'taxonomy_multicheck_inline', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-usage', // Taxonomy Slug.
		)
	);

	/**
	 * Info - Expression Type
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
	 * Conjugations - Wysiwyg
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
	 * Grouping for sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentence_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'sentences',
			'type'        => 'group',
			'description' => __( 'Example Sentences', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Sentence', 'k2k' ),
				'add_button'    => __( 'Add Another Sentence', 'k2k' ),
				'remove_button' => __( 'Remove Sentence', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	/**
	 * Conjugations - Noun Usage
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Noun Usage', 'k2k' ),
			// 'desc' => esc_html__( 'Leave blank if no conjugation.', 'k2k' ),
			'id'   => $prefix . 'noun_usage',
			'type' => 'text',
		)
	);

	/**
	 * Grouping for Adjectives.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$adjectives_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'adjectives',
			'type'        => 'group',
			// 'description' => __( 'Adjective Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Adjective Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
			),
		)
	);
	/** Conjugations - Adjective Tense */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name'     => esc_html__( 'Tense', 'k2k' ),
			'id'       => $prefix . 'adjective_tense',
			'type'     => 'taxonomy_select',
			'taxonomy' => 'k2k-tenses',
		)
	);
	/** Conjugations - Adjective Usage */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name' => esc_html__( 'Usage', 'k2k' ),
			'id'   => $prefix . 'adjective_usage',
			'type' => 'text',
		)
	);
	/** Conjugations - Adjective Example */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name' => esc_html__( 'Example', 'k2k' ),
			'id'   => $prefix . 'adjective_example',
			'type' => 'text',
		)
	);
	/** Conjugations - Adjective Conjugation */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name' => esc_html__( 'Conjugation', 'k2k' ),
			'id'   => $prefix . 'adjective_conjugation',
			'type' => 'text',
		)
	);

		/**
	 * Grouping for Verbs.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$verbs_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'verbs',
			'type'        => 'group',
			// 'description' => __( 'Verb Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Verb Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
			),
		)
	);
	/** Conjugations - verb Tense */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name'     => esc_html__( 'Tense', 'k2k' ),
			'id'       => $prefix . 'verb_tense',
			'type'     => 'taxonomy_select',
			'taxonomy' => 'k2k-tenses',
		)
	);
	/** Conjugations - verb Usage */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name' => esc_html__( 'Usage', 'k2k' ),
			'id'   => $prefix . 'verb_usage',
			'type' => 'text',
		)
	);
	/** Conjugations - verb Example */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name' => esc_html__( 'Example', 'k2k' ),
			'id'   => $prefix . 'verb_example',
			'type' => 'text',
		)
	);
	/** Conjugations - verb Conjugation */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name' => esc_html__( 'Conjugation', 'k2k' ),
			'id'   => $prefix . 'verb_conjugation',
			'type' => 'text',
		)
	);

		/**
	 * Grouping for nouns.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$nouns_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'nouns',
			'type'        => 'group',
			// 'description' => __( 'Noun Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Noun Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
			),
		)
	);
	/** Conjugations - noun Tense */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name'     => esc_html__( 'Tense', 'k2k' ),
			'id'       => $prefix . 'noun_tense',
			'type'     => 'taxonomy_select',
			'taxonomy' => 'k2k-tenses',
		)
	);
	/** Conjugations - noun Usage */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name' => esc_html__( 'Usage', 'k2k' ),
			'id'   => $prefix . 'noun_usage',
			'type' => 'text',
		)
	);
	/** Conjugations - noun Example */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name' => esc_html__( 'Example', 'k2k' ),
			'id'   => $prefix . 'noun_example',
			'type' => 'text',
		)
	);
	/** Conjugations - noun Conjugation */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name' => esc_html__( 'Conjugation', 'k2k' ),
			'id'   => $prefix . 'noun_conjugation',
			'type' => 'text',
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
				'group_title'   => __( 'Example Sentence', 'k2k' ),
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

	/**
	 * Repeating text field for exercises.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$exercise_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'exercises',
			'type'        => 'group',
			'description' => __( 'Exercises. Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Exercise', 'k2k' ),
				'add_button'    => __( 'Add Another Exercise', 'k2k' ),
				'remove_button' => __( 'Remove Exercise', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$exercise_group,
		array(
			'id'              => $prefix . 'exercise',
			'name'            => __( 'Practice Exercise', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	/**
	 * More - Book Selection
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
	 * Meta - Related Grammar Points
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Related Grammar Points', 'k2k' ),
			'desc'    => __( 'Drag posts from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'k2k' ),
			'id'      => $prefix . 'related_grammar',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page' => 10,
					'post_type'      => 'k2k-grammar',
				),
			),
		)
	);

}
