<?php
/**
 * K2K - Register Vocab LIST Metabox.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_metabox_vocab_list' );
/**
 * Register a custom metabox for the 'k2k-vocab-list' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function k2k_register_metabox_vocab_list() {

	$prefix = 'k2k_vocab_list_meta_';

	$k2k_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Vocab List Meta', 'k2k' ),
			'object_types' => array( 'k2k-vocab-list' ),
			'closed'       => false,
			'tabs'         => array(
				array(
					'id'     => 'tab-info',
					'icon'   => 'dashicons-info',
					'title'  => esc_html__( 'Info', 'k2k' ),
					'fields' => array(
						$prefix . 'subtitle',
						$prefix . 'public-files',
						$prefix . 'private-files',
						$prefix . 'wysiwyg',
						$prefix . 'level',
						$prefix . 'book',
					),
				),
				array(
					'id'     => 'tab-related',
					'icon'   => 'dashicons-editor-quote',
					'title'  => esc_html__( 'Related', 'k2k' ),
					'fields' => array(
						$prefix . 'related_lists_group',
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
	 * Info - Public File Upload
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Public Files', 'k2k' ),
			'desc' => esc_html__( 'Enter a URL or upload files that will be publicly available.', 'k2k' ),
			'id'   => $prefix . 'public-files',
			'type' => 'file_list',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'    => array(
				'add_upload_files_text' => esc_html__( 'Add Public File(s)', 'k2k' ), // Change upload button text. Default: "Add or Upload File"
			),
			'query_args' => array(
				'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				// 'type' => array(
				// 	'image/gif',
				// 	'image/jpeg',
				// 	'image/png',
				// ),
			),
			'preview_size' => 'large', // Image size to use when previewing in the admin.
		)
	);

	/**
	 * Info - Private File Upload
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Private Files', 'k2k' ),
			'desc' => esc_html__( 'Enter a URL or upload files that will be for Members Only.', 'k2k' ),
			'id'   => $prefix . 'private-files',
			'type' => 'file_list',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'    => array(
				'add_upload_files_text' => esc_html__( 'Add Private File(s)', 'k2k' ), // Change upload button text. Default: "Add or Upload File"
			),
			'query_args' => array(
				'type' => array(
					'application/pdf', // Make library only display PDFs.
					'application/xls', 
					'application/xlsx',
					'application/csv',
					'application/doc',
					'application/docx',
				),
				// Or only allow gif, jpg, or png images
				// 'type' => array(
				// 	'image/gif',
				// 	'image/jpeg',
				// 	'image/png',
				// ),
			),
			'preview_size' => 'large', // Image size to use when previewing in the admin.
		)
	);

	/**
	 * Details - Wysiwyg
	 */
	$k2k_metabox->add_field(
		array(
			'name'    => esc_html__( 'Page Content', 'k2k' ),
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
	 * Meta - Level Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Level', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'level',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-vocab-list-level', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
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
			'taxonomy' => 'k2k-vocab-list-book', // Taxonomy Slug.
		)
	);

	/**
	 * Info - Related Lists
	 *
	 * @link https://github.com/CMB2/cmb2-attached-posts
	 */
	$related_group = $k2k_metabox->add_field(
		array(
			'id'         => $prefix . 'related_lists_group',
			// 'name' => __( 'Related', 'k2k' ),
			'type'       => 'group',
			'repeatable' => false,
			'options'    => array(
				'group_title' => __( 'Related Lists', 'k2k' ),
				'closed'      => true,
			),
		)
	);

	$k2k_metabox->add_group_field(
		$related_group,
		array(
			'id'   => $prefix . 'related_lists_unlinked',
			'name' => __( 'Related Lists (unlinked)', 'k2k' ),
			'type' => 'text',
		)
	);

	$k2k_metabox->add_group_field(
		$related_group,
		array(
			'name'    => esc_html__( 'Related Lists (linked)', 'k2k' ),
			'id'      => $prefix . 'related_lists_linked',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'filter_boxes' => true,
				'query_args'   => array(
					'posts_per_page' => 10,
					'post_type'      => 'k2k-vocab-list',
				),
			),
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
