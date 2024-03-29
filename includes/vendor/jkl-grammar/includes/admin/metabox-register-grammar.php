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
					'icon'   => 'dashicons-info',
					'title'  => esc_html__( 'Info', 'k2k' ),
					'fields' => array(
						$prefix . 'subtitle',
						$prefix . 'level',
						$prefix . 'wysiwyg',
						$prefix . 'video',
						$prefix . 'expression',
						$prefix . 'usage',
						$prefix . 'book',
					),
				),
				array(
					'id'     => 'tab-conjugations',
					'icon'   => 'dashicons-editor-quote',
					'title'  => esc_html__( 'Conjugations', 'k2k' ),
					'fields' => array(
						$prefix . 'part_of_speech',
						$prefix . 'tenses',
						$prefix . 'adjectives',
						$prefix . 'verbs',
						$prefix . 'nouns',
						$prefix . 'conjugation_note',
						$prefix . 'conjugation_note_position',
					),
				),
				array(
					'id'     => 'tab-sentences',
					'icon'   => 'dashicons-editor-alignleft',
					'title'  => esc_html__( 'Sentences', 'k2k' ),
					'fields' => array(
						$prefix . 'sentences_dialogue',
						$prefix . 'sentences_past',
						$prefix . 'sentences_present',
						$prefix . 'sentences_future',
						$prefix . 'sentences_other',
						$prefix . 'sentences_titles',
						$prefix . 'sentences_image',
						$prefix . 'sentences_video',
						$prefix . 'sentences_note',
						$prefix . 'sentences_note_position',
					),
				),
				array(
					'id'     => 'tab-exercises',
					'icon'   => 'dashicons-welcome-write-blog',
					'title'  => esc_html__( 'Exercises', 'k2k' ),
					'fields' => array(
						$prefix . 'exercises',
						$prefix . 'exercises_note',
						$prefix . 'exercises_note_position',
					),
				),
				array(
					'id'     => 'tab-related',
					'icon'   => 'dashicons-admin-links',
					'title'  => esc_html__( 'Related', 'k2k' ),
					'fields' => array(
						$prefix . 'unlinked_related_grammar',
						$prefix . 'related_grammar',
					),
				),
				array(
					'id'     => 'tab-special',
					'icon'   => 'dashicons-warning',
					'title'  => esc_html__( 'Special', 'k2k' ),
					'fields' => array(
						$prefix . 'declaratives',
						$prefix . 'interrogatives',
						$prefix . 'propositives',
						$prefix . 'imperatives',
						$prefix . 'special_conjugations',
						$prefix . 'conjugation_note_special',
						$prefix . 'conjugation_note_position_special',
						$prefix . 'special_dialogue',
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
			'taxonomy' => 'k2k-grammar-level', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Info - Video (YouTube)
	 */
	$k2k_metabox->add_field(
		array(
			'name'   => esc_html__( 'YouTube lesson', 'k2k' ),
			// 'desc'   => esc_html__( 'The translation will be used as the subtitle.', 'k2k' ),
			'id'     => $prefix . 'video',
			'type'   => 'text',
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
			'taxonomy' => 'k2k-grammar-part-of-speech', // Taxonomy Slug.
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
			'taxonomy' => 'k2k-grammar-tenses', // Taxonomy Slug.
		)
	);

	/**
	 * Details - Wysiwyg
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
	 * Info - Unlinked Related Grammar
	 */
	$unlinked_related_grammar = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'unlinked_related_grammar',
			'type'        => 'group',
			'repeatable' => false,
			// 'description' => __( 'Adjective Conjugations', 'k2k' ),
			'options'     => array(
				'group_title' => __( 'Unlinked Related Grammar', 'k2k' ),
			),
		)
	);
	$k2k_metabox->add_group_field(
		$unlinked_related_grammar,
		array(
			'name' => esc_html__( 'Similar Grammar', 'k2k' ),
			'id'   => $prefix . 'ul_similar_related',
			'type' => 'text',
		)
	);
	$k2k_metabox->add_group_field(
		$unlinked_related_grammar,
		array(
			'name' => esc_html__( 'Opposite Grammar', 'k2k' ),
			'id'   => $prefix . 'ul_opposite_related',
			'type' => 'text',
		)
	);

	/**
	 * Info - Usage Selection
	 */
	$usage_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'usage',
			'type'        => 'group',
			'repeatable' => false,
			// 'description' => __( 'Adjective Conjugations', 'k2k' ),
			'options'     => array(
				'group_title' => __( 'How to Use', 'k2k' ),
			),
		)
	);
	$k2k_metabox->add_group_field(
		$usage_group,
		array(
			'name'     => esc_html__( 'Usage type', 'k2k' ),
			'id'       => $prefix . 'usage_tax',
			'type'     => 'taxonomy_multicheck_inline', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-grammar-usage', // Taxonomy Slug.
		)
	);
	$k2k_metabox->add_group_field(
		$usage_group,
		array(
			'name' => esc_html__( 'Must use', 'k2k' ),
			'id'   => $prefix . 'usage_mu',
			'type' => 'text',
		)
	);
	$k2k_metabox->add_group_field(
		$usage_group,
		array(
			'name' => esc_html__( 'Prohibited', 'k2k' ),
			'id'   => $prefix . 'usage_no',
			'type' => 'text',
		)
	);

	/**
	 * Info - Expression Type
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Expression', 'k2k' ),
			'id'       => $prefix . 'expression',
			'type'     => 'taxonomy_radio', // Or taxonomy_multicheck_inline/taxonomy_multicheck_hierarchical.
			'taxonomy' => 'k2k-grammar-expression', // Taxonomy Slug.
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
			'repeatable' => false,
			// 'description' => __( 'Adjective Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Adjective Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
				'closed'        => true,
			),
		)
	);
	/** Conjugations - Adjective Past */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name' => esc_html__( 'Past', 'k2k' ),
			'id'   => $prefix . 'adjective_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Adjective Present */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name' => esc_html__( 'Present', 'k2k' ),
			'id'   => $prefix . 'adjective_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Adjective Future */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name' => esc_html__( 'Future', 'k2k' ),
			'id'   => $prefix . 'adjective_future',
			'type' => 'text',
		)
	);
	/** Conjugations - Adjective Supposition */
	$k2k_metabox->add_group_field(
		$adjectives_group,
		array(
			'name' => esc_html__( 'Supposition', 'k2k' ),
			'id'   => $prefix . 'adjective_supposition',
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
			'repeatable'  => false,
			// 'description' => __( 'Verb Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Verb Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
				'closed'        => true,
			),
		)
	);
	/** Conjugations - Verb Past */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name' => esc_html__( 'Past', 'k2k' ),
			'id'   => $prefix . 'verb_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Verb Present */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name' => esc_html__( 'Present', 'k2k' ),
			'id'   => $prefix . 'verb_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Verb Future */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name' => esc_html__( 'Future', 'k2k' ),
			'id'   => $prefix . 'verb_future',
			'type' => 'text',
		)
	);
	/** Conjugations - Verb Supposition */
	$k2k_metabox->add_group_field(
		$verbs_group,
		array(
			'name' => esc_html__( 'Supposition', 'k2k' ),
			'id'   => $prefix . 'verb_supposition',
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
			'repeatable'  => false,
			// 'description' => __( 'Noun Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Noun Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
				'closed'        => true,
			),
		)
	);
	/** Conjugations - Noun Past */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name' => esc_html__( 'Past', 'k2k' ),
			'id'   => $prefix . 'noun_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Noun Present */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name' => esc_html__( 'Present', 'k2k' ),
			'id'   => $prefix . 'noun_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Noun Future */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name' => esc_html__( 'Future', 'k2k' ),
			'id'   => $prefix . 'noun_future',
			'type' => 'text',
		)
	);
	/** Conjugations - Noun Supposition */
	$k2k_metabox->add_group_field(
		$nouns_group,
		array(
			'name' => esc_html__( 'Supposition', 'k2k' ),
			'id'   => $prefix . 'noun_supposition',
			'type' => 'text',
		)
	);

	/**
	 * Conjugations - Note
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Conjugation Note', 'k2k' ),
			'desc' => esc_html__( 'Anything special to remember? Leave a note here. Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;. You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'id'   => $prefix . 'conjugation_note',
			'type' => 'text',
		)
	);

	$k2k_metabox->add_field(
		array(
			'id'   => $prefix . 'conjugation_note_position',
			'name' => __( 'Show note at the Top?', 'k2k' ),
			'type' => 'checkbox',
		)
	);

	/**
	 * Optional sentences titles.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentences_setup = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'sentences_titles',
			'type'        => 'group',
			// 'name'        => __( 'Sentences Setup', 'k2k' ),
			// 'description' => __( 'The following options add additional text to the Sentence Headings. Or you can choose to replace them entirely by checking the box below.', 'k2k' ),
			'repeatable'  => false,
			'options'     => array(
				'group_title' => __( 'Sentences Setup', 'k2k' ),
				'closed'      => true,
			),
		)
	);
	/** Sentence Titles - PAST */
	$k2k_metabox->add_group_field(
		$sentences_setup,
		array(
			'name' => esc_html__( 'Past Tense title extras', 'k2k' ),
			'desc' => esc_html__( 'Default title: Past Tense', 'k2k' ),
			'id'   => $prefix . 'sentences_titles_past',
			'type' => 'text',
		)
	);
	/** Sentence Titles - PRESENT */
	$k2k_metabox->add_group_field(
		$sentences_setup,
		array(
			'name' => esc_html__( 'Present Tense title extras', 'k2k' ),
			'desc' => esc_html__( 'Default title: Present Tense', 'k2k' ),
			'id'   => $prefix . 'sentences_titles_present',
			'type' => 'text',
		)
	);
	/** Sentence Titles - FUTURE */
	$k2k_metabox->add_group_field(
		$sentences_setup,
		array(
			'name' => esc_html__( 'Future Tense title extras', 'k2k' ),
			'desc' => esc_html__( 'Default title: Future Tense', 'k2k' ),
			'id'   => $prefix . 'sentences_titles_future',
			'type' => 'text',
		)
	);
	/** Sentence Titles - OTHER */
	$k2k_metabox->add_group_field(
		$sentences_setup,
		array(
			'name' => esc_html__( 'Other title extras', 'k2k' ),
			'desc' => esc_html__( 'Default title: Propositions &amp; Imperatives', 'k2k' ),
			'id'   => $prefix . 'sentences_titles_other',
			'type' => 'text',
		)
	);
	/** Replace Titles */
	$k2k_metabox->add_group_field(
		$sentences_setup,
		array(
			'name' => esc_html__( 'Replace original titles?', 'k2k' ),
			'desc' => esc_html__( 'If unchecked, the text entered above will be added after the Default titles.', 'k2k' ),
			'id'   => $prefix . 'sentences_titles_replace',
			'type' => 'checkbox',
		)
	);

	/** Create Sentences Dialogue */
	$k2k_metabox->add_group_field(
		$sentences_setup,
		array(
			'name' => esc_html__( 'Create dialogue?', 'k2k' ),
			'desc' => esc_html__( 'Change Sentence Headings below, and check the box to "Replace original titles" if so.', 'k2k' ),
			'id'   => $prefix . 'sentences_dialogue',
			'type' => 'checkbox',
		)
	);

	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Sentences Image (optional)', 'k2k' ),
			'desc' => esc_html__( 'Add an extra image to highlight the sentences if you want.', 'k2k' ),
			'id'   => $prefix . 'sentences_image',
			'type' => 'file',
		)
	);

	/**
	 * Sentences - Video (YouTube)
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Sentences Video (optional)', 'k2k' ),
			'desc' => esc_html__( 'If present, it will override any image selected.', 'k2k' ),
			'id'   => $prefix . 'sentences_video',
			'type' => 'text',
		)
	);

	/**
	 * Repeating text field for PAST TENSE sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentence_past_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'sentences_past',
			'type'        => 'group',
			'name'        => __( 'Example Sentences.', 'k2k' ),
			'description' => __( 'Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;.<br />You can also wrap a word or phrase in * or _ to make it bold.<br>To add a Part of Speech icon, type the Part of Speech as a single letter, followed by a colon (i.e. "V:").', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Past Tense Sentence', 'k2k' ),
				'add_button'    => __( 'Add Another Sentence', 'k2k' ),
				'remove_button' => __( 'Remove Sentence', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_past_group,
		array(
			'id'              => $prefix . 'sentences_1',
			'name'            => __( 'Original (KO)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_past_group,
		array(
			'id'              => $prefix . 'sentences_2',
			'name'            => __( 'Translation (EN)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	/**
	 * Repeating text field for PRESENT TENSE sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentence_present_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'sentences_present',
			'type'        => 'group',
			// 'description' => __( 'Example Sentences.<br />Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;.<br />You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Present Tense Sentence', 'k2k' ),
				'add_button'    => __( 'Add Another Sentence', 'k2k' ),
				'remove_button' => __( 'Remove Sentence', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_present_group,
		array(
			'id'              => $prefix . 'sentences_1',
			'name'            => __( 'Original (KO)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_present_group,
		array(
			'id'              => $prefix . 'sentences_2',
			'name'            => __( 'Translation (EN)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	/**
	 * Repeating text field for FUTURE TENSE sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentence_future_group = $k2k_metabox->add_field(
		array(
			'id'      => $prefix . 'sentences_future',
			'type'    => 'group',
			// 'description' => __( 'Example Sentences.<br />Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;.<br />You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'options' => array(
				'group_title'   => __( 'Future Tense Sentence', 'k2k' ),
				'add_button'    => __( 'Add Another Sentence', 'k2k' ),
				'remove_button' => __( 'Remove Sentence', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_future_group,
		array(
			'id'              => $prefix . 'sentences_1',
			'name'            => __( 'Original (KO)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_future_group,
		array(
			'id'              => $prefix . 'sentences_2',
			'name'            => __( 'Translation (EN)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	/**
	 * Repeating text field for OTHER sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentence_other_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'sentences_other',
			'type'        => 'group',
			'name'        => __( 'Other Sentences.', 'k2k' ),
			'description' => __( 'Propositives or Imperatives? Add them here.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Other Sentence', 'k2k' ),
				'add_button'    => __( 'Add Another Sentence', 'k2k' ),
				'remove_button' => __( 'Remove Sentence', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_other_group,
		array(
			'id'              => $prefix . 'sentences_1',
			'name'            => __( 'Original (KO)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	$k2k_metabox->add_group_field(
		$sentence_other_group,
		array(
			'id'              => $prefix . 'sentences_2',
			'name'            => __( 'Translation (EN)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	/**
	 * Sentences - Note
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Sentences Note', 'k2k' ),
			'desc' => esc_html__( 'Anything special to remember? Leave a note here. Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;. You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'id'   => $prefix . 'sentences_note',
			'type' => 'text',
		)
	);

	$k2k_metabox->add_field(
		array(
			'id'   => $prefix . 'sentences_note_position',
			'name' => __( 'Show note at the Top?', 'k2k' ),
			'type' => 'checkbox',
		)
	);

	/**
	 * Repeating text field for exercises.
	 */
	$k2k_metabox->add_field(
		array(
			'id'              => $prefix . 'exercises',
			'name'            => __( 'Practice Exercises', 'k2k' ),
			'description'     => __( 'Add optional practice exercises. Use ... to create a fill-in-the-blank.', 'k2k' ),
			'type'            => 'text',
			'sortable'        => true,
			'repeatable'      => true,
			'repeatable_max'  => 10,
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
			'text'            => array(
				'add_row_text' => __( 'Add Practice', 'k2k' ),
			),
		)
	);

	/**
	 * Exercises - Note
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Exercises Note', 'k2k' ),
			'desc' => esc_html__( 'Anything special to remember? Leave a note here. Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;. You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'id'   => $prefix . 'exercises_note',
			'type' => 'text',
		)
	);

	$k2k_metabox->add_field(
		array(
			'id'   => $prefix . 'exercises_note_position',
			'name' => __( 'Show note at the Top?', 'k2k' ),
			'type' => 'checkbox',
		)
	);

	/**
	 * More - Book Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Found in these Books', 'k2k' ),
			'id'       => $prefix . 'book',
			'type'     => 'taxonomy_multicheck_hierarchical', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`.
			'taxonomy' => 'k2k-grammar-book', // Taxonomy Slug.
		)
	);

	/**
	 * Meta - Related Grammar Points
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$related_grammar = $k2k_metabox->add_field(
		array(
			'id'         => $prefix . 'related_grammar',
			'type'       => 'group',
			'repeatable' => false,
			'options'    => array(
				'group_title' => __( 'Related Grammar (See also)', 'k2k' ),
			),
		)
	);

	$k2k_metabox->add_group_field(
		$related_grammar,
		array(
			'id'     => $prefix . 'related_needs_link',
			'name'   => __( 'Needs link', 'k2k' ),
			'type'   => 'checkbox',
			'column' => array(
				'position' => 2,
				'name'     => __( 'Needs Link', 'k2k' ),
			),
		)
	);

	$k2k_metabox->add_group_field(
		$related_grammar,
		array(
			'name'    => esc_html__( 'Related Grammar Points', 'k2k' ),
			'desc'    => __( 'Drag posts from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'k2k' ),
			'id'      => $prefix . 'related_grammar_points',
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

	/**
	 * Grouping for Declarative (Sentence) conjugations.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$declarative_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'declaratives',
			'type'        => 'group',
			'repeatable'  => false,
			'name'        => __( 'Declarative SENTENCES (.)', 'k2k' ),
			// 'description' => __( 'Declaratives are the same as SENTENCES.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Declaratives Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
				'closed'        => true,
			),
		)
	);
	/** Conjugations - Declaratives ADJ Past */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html_x( 'Adjs Past', 'Adjs is the abbreviation for Adjectives', 'k2k' ),
			'id'   => $prefix . 'declarative_a_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives ADJ Present */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html_x( 'Adjs Present', 'Adjs is the abbreviation for Adjectives', 'k2k' ),
			'id'   => $prefix . 'declarative_a_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives ADJ Future */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html_x( 'Adjs Future', 'Adjs is the abbreviation for Adjectives', 'k2k' ),
			'id'   => $prefix . 'declarative_a_future',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives V Past */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html__( 'Vbs Past', 'k2k' ),
			'id'   => $prefix . 'declarative_v_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives V Present */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html__( 'Vbs Present', 'k2k' ),
			'id'   => $prefix . 'declarative_v_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives V Future */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html__( 'Vbs Future', 'k2k' ),
			'id'   => $prefix . 'declarative_v_future',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives N Past */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html__( 'Ns Past', 'k2k' ),
			'id'   => $prefix . 'declarative_n_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives N Present */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html__( 'Ns Present', 'k2k' ),
			'id'   => $prefix . 'declarative_n_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Declaratives N Future */
	$k2k_metabox->add_group_field(
		$declarative_group,
		array(
			'name' => esc_html__( 'Ns Future', 'k2k' ),
			'id'   => $prefix . 'declarative_n_future',
			'type' => 'text',
		)
	);

	/**
	 * Grouping for Interrogative (Question) conjugations.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$interrogative_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'interrogatives',
			'type'        => 'group',
			'repeatable'  => false,
			'name'        => __( 'Interrogative QUESTIONS (?)', 'k2k' ),
			// 'description' => __( 'Interrogatives are the same as QUESTIONS.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Interrogatives Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
				'closed'        => true,
			),
		)
	);
	/** Conjugations - Interrogative A Past */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Adjs Past', 'k2k' ),
			'id'   => $prefix . 'interrogative_a_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative A Present */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Adjs Present', 'k2k' ),
			'id'   => $prefix . 'interrogative_a_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative A Future */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Adjs Future', 'k2k' ),
			'id'   => $prefix . 'interrogative_a_future',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative V Past */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Vbs Past', 'k2k' ),
			'id'   => $prefix . 'interrogative_v_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative V Present */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Vbs Present', 'k2k' ),
			'id'   => $prefix . 'interrogative_v_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative AV Future */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Vbs Future', 'k2k' ),
			'id'   => $prefix . 'interrogative_v_future',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative N Past */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Ns Past', 'k2k' ),
			'id'   => $prefix . 'interrogative_n_past',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative N Present */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Ns Present', 'k2k' ),
			'id'   => $prefix . 'interrogative_n_present',
			'type' => 'text',
		)
	);
	/** Conjugations - Interrogative N Future */
	$k2k_metabox->add_group_field(
		$interrogative_group,
		array(
			'name' => esc_html__( 'Ns Future', 'k2k' ),
			'id'   => $prefix . 'interrogative_n_future',
			'type' => 'text',
		)
	);

	/**
	 * Grouping for Propositive (Suggestion) conjugations.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$propositive_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'propositives',
			'type'        => 'group',
			'repeatable'  => false,
			'name'        => __( 'Propositive SUGGESTIONS (~)', 'k2k' ),
			// 'description' => __( 'Propositives are the same as SUGGESTIONS.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Propositives Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
				'closed'        => true,
			),
		)
	);
	/** Conjugations - Propositive Positives */
	$k2k_metabox->add_group_field(
		$propositive_group,
		array(
			'name' => esc_html__( 'Positive (+) Verbs', 'k2k' ),
			'id'   => $prefix . 'propositive_pos',
			'type' => 'text',
		)
	);
	/** Conjugations - Propositive Negatives */
	$k2k_metabox->add_group_field(
		$propositive_group,
		array(
			'name' => esc_html__( 'Negative (-) Verbs', 'k2k' ),
			'id'   => $prefix . 'propositive_neg',
			'type' => 'text',
		)
	);

	/**
	 * Grouping for Imperative (Command) conjugations.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$imperative_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'imperatives',
			'type'        => 'group',
			'repeatable'  => false,
			'name'        => __( 'Imperative COMMANDS (!)', 'k2k' ),
			// 'description' => __( 'Imperatives are the same as COMMANDS.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Imperatives Conjugation', 'k2k' ),
				'add_button'    => __( 'Add Another Conjugation', 'k2k' ),
				'remove_button' => __( 'Remove Conjugation', 'k2k' ),
				'sortable'      => true,
				'closed'        => true,
			),
		)
	);
	/** Conjugations - Imperative Positives */
	$k2k_metabox->add_group_field(
		$imperative_group,
		array(
			'name' => esc_html__( 'Positive (+) Verbs', 'k2k' ),
			'id'   => $prefix . 'imperative_pos',
			'type' => 'text',
		)
	);
	/** Conjugations - Imperative Negatives */
	$k2k_metabox->add_group_field(
		$imperative_group,
		array(
			'name' => esc_html__( 'Negative (-) Verbs', 'k2k' ),
			'id'   => $prefix . 'imperative_neg',
			'type' => 'text',
		)
	);

	/**
	 * Special - Wysiwyg Special Conjugations
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Extra Conjugations', 'k2k' ),
			'desc'    => esc_html__( 'Special Conjugations or Conjugation Notes.', 'k2k' ),
			'id'      => $prefix . 'special_conjugations',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
			),
		)
	);

	/**
	 * Conjugations - Note
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Special Conjugation Note', 'k2k' ),
			'desc' => esc_html__( 'Anything special to remember? Leave a note here. Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;. You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'id'   => $prefix . 'conjugation_note_special',
			'type' => 'text',
		)
	);

	$k2k_metabox->add_field(
		array(
			'id'   => $prefix . 'conjugation_note_position_special',
			'name' => __( 'Show note at the Top?', 'k2k' ),
			'type' => 'checkbox',
		)
	);

	/**
	 * Special - Wysiwyg Special Dialogue
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Extra Dialogue', 'k2k' ),
			'desc'    => esc_html__( 'Special Dialogue or additional Practice Sentences.', 'k2k' ),
			'id'      => $prefix . 'special_dialogue',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
			),
		)
	);

}
