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
					'icon'   => 'dashicons-info',
					'title'  => esc_html__( 'Info', 'k2k' ),
					'fields' => array(
						$prefix . 'subtitle',
						$prefix . 'level',
						$prefix . 'part_of_speech',
						$prefix . 'definitions',
						$prefix . 'sentences',
						$prefix . 'vocab_group',
					),
				),
				array(
					'id'     => 'tab-related',
					'icon'   => 'dashicons-editor-quote',
					'title'  => esc_html__( 'Related', 'k2k' ),
					'fields' => array(
						$prefix . 'topic',
						$prefix . 'related_group',
						$prefix . 'synonym_group',
						$prefix . 'antonym_group',
						$prefix . 'hanja_group',
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
	 * Meta - Level Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Level', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'level',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-vocab-level', // Taxonomy Slug.
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
			'taxonomy' => 'k2k-vocab-part-of-speech', // Taxonomy Slug.
		)
	);

	/**
	 * Repeating text field for definitions.
	 */
	$k2k_metabox->add_field(
		array(
			'id'             => $prefix . 'definitions',
			'name'           => __( 'Definition(s) (Optional)', 'k2k' ),
			'description'    => __( 'Add additional definitions. If none are added, the translation will be used.', 'k2k' ),
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
	 * Repeating text field for sentences.
	 */
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$sentence_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'sentences',
			'type'        => 'group',
			'name'        => __( 'Example Sentences.', 'k2k' ),
			'description' => __( 'Allowed tags: &lt;b&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;span&gt;.<br />You can also wrap a word or phrase in * or _ to make it bold.', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Sentence', 'k2k' ),
				'add_button'    => __( 'Add Another Sentence', 'k2k' ),
				'remove_button' => __( 'Remove Sentence', 'k2k' ),
				'sortable'      => true,
			),
		)
	);

	$sent_ko = $k2k_metabox->add_group_field(
		$sentence_group,
		array(
			'id'              => $prefix . 'sentences_1',
			'name'            => __( 'Original (KO)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
		)
	);

	$sent_en = $k2k_metabox->add_group_field(
		$sentence_group,
		array(
			'id'              => $prefix . 'sentences_2',
			'name'            => __( 'Translation (EN)', 'k2k' ),
			'type'            => 'text',
			'sanitization_cb' => 'k2k_sanitize_sentence_callback',
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
			'type'     => 'taxonomy_multicheck_inline',
			'taxonomy' => 'k2k-vocab-topic', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Repeating text field for common usages.
	 *
	$k2k_metabox->add_field(
		array(
			'id'             => $prefix . 'common_usage',
			'name'           => __( 'Common Usage', 'k2k' ),
			'type'           => 'text',
			'sortable'       => true,
			'repeatable'     => true,
			'repeatable_max' => 10,
			'text'           => array(
				'add_row_text' => __( 'Add', 'k2k' ),
			),
		)
	);
	*/

		/**
	 * Info - Related Words
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$related_group = $k2k_metabox->add_field(
		array(
			'id'         => $prefix . 'related_group',
			// 'name' => __( 'Related', 'k2k' ),
			'type'       => 'group',
			'repeatable' => false,
			'options'    => array(
				'group_title' => __( 'Related Words', 'k2k' ),
				'closed'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$related_group,
		array(
			'id'   => $prefix . 'related_unlinked',
			'name' => __( 'Related Words (unlinked)', 'k2k' ),
			'type' => 'text',
		)
	);

	$k2k_metabox->add_group_field(
		$related_group,
		array(
			'name'    => esc_html__( 'Related Words (linked)', 'k2k' ),
			'id'      => $prefix . 'related_linked',
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
	 * Info - Synonyms
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$synonym_group = $k2k_metabox->add_field(
		array(
			'id'         => $prefix . 'synonym_group',
			// 'name' => __( 'Synonyms', 'k2k' ),
			'type'       => 'group',
			'repeatable' => false,
			'options'    => array(
				'group_title' => __( 'Synonyms', 'k2k' ),
				'closed'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$synonym_group,
		array(
			'id'   => $prefix . 'synonyms_unlinked',
			'name' => __( 'Synonyms (unlinked)', 'k2k' ),
			'type' => 'text',
		)
	);

	$k2k_metabox->add_group_field(
		$synonym_group,
		array(
			'name'    => esc_html__( 'Synonyms (linked)', 'k2k' ),
			'id'      => $prefix . 'synonyms_linked',
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
	$antonym_group = $k2k_metabox->add_field(
		array(
			'id'         => $prefix . 'antonym_group',
			// 'name' => __( 'Antonyms', 'k2k' ),
			'type'       => 'group',
			'repeatable' => false,
			'options'    => array(
				'group_title' => __( 'Antonyms', 'k2k' ),
				'closed'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$antonym_group,
		array(
			'id'   => $prefix . 'antonyms_unlinked',
			'name' => __( 'Antonyms (unlinked)', 'k2k' ),
			'type' => 'text',
		)
	);

	$k2k_metabox->add_group_field(
		$antonym_group,
		array(
			'name'    => esc_html__( 'Antonyms (linked)', 'k2k' ),
			'id'      => $prefix . 'antonyms_linked',
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
	$hanja_group = $k2k_metabox->add_field(
		array(
			'id'         => $prefix . 'hanja_group',
			// 'name' => __( 'Hanja', 'k2k' ),
			'type'       => 'group',
			'repeatable' => false,
			'options'    => array(
				'group_title' => __( 'Hanja', 'k2k' ),
				'closed'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$hanja_group,
		array(
			'id'   => $prefix . 'hanja_unlinked',
			'name' => __( 'Hanja (unlinked)', 'k2k' ),
			'type' => 'text',
		)
	);

	$k2k_metabox->add_group_field(
		$hanja_group,
		array(
			'name'    => esc_html__( 'Hanja (linked)', 'k2k' ),
			'id'      => $prefix . 'hanja_linked',
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
	 * Info - Vocab Group
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Vocab Group', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'vocab_group',
			'type'     => 'taxonomy_multicheck_hierarchical',
			'taxonomy' => 'k2k-vocab-group', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	if ( ! is_admin() ) {
		return;
	}

	/**
	// Create a default Grid.
	$cmb2_grid = new \Cmb2Grid\Grid\Cmb2Grid( $k2k_metabox );

	// Create a grid of Group fields.
	$cmb2_group_grid = $cmb2_grid->addCmb2GroupGrid( $sentence_group );
	$row             = $cmb2_group_grid->addRow();
	$row->addColumns(
		array(
			$sent_ko,
			$sent_en,
		)
	);

	// Now setup columns like normal.
	$row = $cmb2_grid->addRow();
	// $row->addColumns( array( $cmb2_group_grid ) );.
	*/
}
