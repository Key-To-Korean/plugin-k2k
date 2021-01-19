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
					'id'     => 'tab-short',
					'icon'   => 'dashicons-menu-alt2',
					'title'  => esc_html__( 'Short', 'k2k' ),
					'fields' => array(
						$prefix . 'short_group',
						$prefix . 'short_image',
						$prefix . 'short_prompt',
						$prefix . 'short_solving',
						$prefix . 'short_sample',
					),
				),
				array(
					'id'     => 'tab-medium',
					'icon'   => 'dashicons-menu-alt',
					'title'  => esc_html__( 'Medium', 'k2k' ),
					'fields' => array(
						$prefix . 'medium_group',
						$prefix . 'medium_image',
						$prefix . 'medium_prompt',
						$prefix . 'medium_solving',
						$prefix . 'medium_sample',
					),
				),
				array(
					'id'     => 'tab-long',
					'icon'   => 'dashicons-menu-alt3',
					'title'  => esc_html__( 'Long', 'k2k' ),
					'fields' => array(
						$prefix . 'long_group',
						$prefix . 'long_image',
						$prefix . 'long_prompt',
						$prefix . 'long_solving',
						$prefix . 'long_sample',
					),
				),
				array(
					'id'     => 'tab-meta',
					'icon'   => 'dashicons-info',
					'title'  => esc_html__( 'Meta', 'k2k' ),
					'fields' => array(
						$prefix . 'level',
						$prefix . 'topic',
						$prefix . 'type',
						$prefix . 'length',
						$prefix . 'source',
						$prefix . 'link',
						$prefix . 'download',
					),
				),
			),
		)
	);

	/**
	 * Short Group
	 */
	$short_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'short_group',
			'type'        => 'group',
			'repeatable'  => true,
			// 'description' => __( 'Noun Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Short Writing Group', 'k2k' ),
				'add_button'    => __( 'Add Another Short Writing Prompt', 'k2k' ),
				'remove_button' => __( 'Remove Short Writing Prompt', 'k2k' ),
			),
		)
	);

	/**
	 * Short Image
	 */
	$k2k_metabox->add_group_field(
		$short_group,
		array(
			'name'         => 'Short Prompt Image',
			'desc'         => 'Upload an image or enter an URL related to the short writing prompt.',
			'id'           => $prefix . 'short_image',
			'type'         => 'file',
			// Optional.
			'options'      => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'         => array(
				'add_upload_file_text' => 'Add File', // Change upload button text. Default: "Add or Upload File".
			),
			// query_args are passed to wp.media's library query.
			'query_args'   => array(
				// 'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
		)
	);

	/**
	 * Short Prompt - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$short_group,
		array(
			'name'    => esc_html__( 'Short Writing Prompt', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'short_prompt',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
			),
		)
	);

	/**
	 * Short Solving - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$short_group,
		array(
			'name'    => esc_html__( 'Solving the Short Prompt', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'short_solving',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
			),
		)
	);

	/**
	 * Short Sample - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$short_group,
		array(
			'name'    => esc_html__( 'Short Sample Answer', 'k2k' ),
			'desc'    => esc_html__( 'Add translation text if available.', 'k2k' ),
			'id'      => $prefix . 'short_sample',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
			),
		)
	);

	/**
	 * Medium Group
	 */
	$medium_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'medium_group',
			'type'        => 'group',
			'repeatable'  => false,
			// 'description' => __( 'Noun Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Medium Writing Group', 'k2k' ),
				'add_button'    => __( 'Add Another Medium Writing Prompt', 'k2k' ),
				'remove_button' => __( 'Remove Medium Writing Prompt', 'k2k' ),
			),
		)
	);

	/**
	 * Medium Image
	 */
	$k2k_metabox->add_group_field(
		$medium_group,
		array(
			'name'         => 'Medium Prompt Image',
			'desc'         => 'Upload an image or enter an URL related to the medium writing prompt.',
			'id'           => $prefix . 'medium_image',
			'type'         => 'file',
			// Optional.
			'options'      => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'         => array(
				'add_upload_file_text' => 'Add File', // Change upload button text. Default: "Add or Upload File".
			),
			// query_args are passed to wp.media's library query.
			'query_args'   => array(
				// 'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
		)
	);

	/**
	 * Medium Prompt - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$medium_group,
		array(
			'name'    => esc_html__( 'Medium Writing Prompt', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'medium_prompt',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 10 ),
			),
		)
	);

	/**
	 * Medium Solving - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$medium_group,
		array(
			'name'    => esc_html__( 'Solving the Medium Prompt', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'medium_solving',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 10 ),
			),
		)
	);

	/**
	 * Medium Sample - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$medium_group,
		array(
			'name'    => esc_html__( 'Medium Sample Answer', 'k2k' ),
			'desc'    => esc_html__( 'Add translation text if available.', 'k2k' ),
			'id'      => $prefix . 'medium_sample',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 10 ),
			),
		)
	);

	/**
	 * Long Group
	 */
	$long_group = $k2k_metabox->add_field(
		array(
			'id'          => $prefix . 'long_group',
			'type'        => 'group',
			'repeatable'  => false,
			// 'description' => __( 'Noun Conjugations', 'k2k' ),
			'options'     => array(
				'group_title'   => __( 'Long Writing Group', 'k2k' ),
				'add_button'    => __( 'Add Another Long Writing Prompt', 'k2k' ),
				'remove_button' => __( 'Remove Long Writing Prompt', 'k2k' ),
			),
		)
	);

	/**
	 * Long Image
	 */
	$k2k_metabox->add_group_field(
		$long_group,
		array(
			'name'         => 'Long Prompt Image',
			'desc'         => 'Upload an image or enter an URL related to the long writing prompt.',
			'id'           => $prefix . 'long_image',
			'type'         => 'file',
			// Optional.
			'options'      => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'         => array(
				'add_upload_file_text' => 'Add File', // Change upload button text. Default: "Add or Upload File".
			),
			// query_args are passed to wp.media's library query.
			'query_args'   => array(
				// 'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
		)
	);

	/**
	 * Long Prompt - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$long_group,
		array(
			'name'    => esc_html__( 'Long Writing Prompt', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'long_prompt',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 15 ),
			),
		)
	);

	/**
	 * Long Solving - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$long_group,
		array(
			'name'    => esc_html__( 'Solving the Long Prompt', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'      => $prefix . 'long_solving',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 15 ),
			),
		)
	);

	/**
	 * Long Sample - Wysiwyg
	 */
	$k2k_metabox->add_group_field(
		$long_group,
		array(
			'name'    => esc_html__( 'Long Sample Answer', 'k2k' ),
			'desc'    => esc_html__( 'Add translation text if available.', 'k2k' ),
			'id'      => $prefix . 'long_sample',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 15 ),
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
			'taxonomy' => 'k2k-writing-level', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Meta - Topic Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Topic', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'topic',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-writing-topic', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Meta - Type Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Type', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'type',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-writing-type', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Meta - Length Selection
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
	 * Meta - Source Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Source', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'source',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-writing-source', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Meta - External Link
	 */
	$k2k_metabox->add_field(
		array(
			'name'   => esc_html__( 'External Link', 'k2k' ),
			// 'desc'   => esc_html__( 'The translation will be used as the subtitle.', 'k2k' ),
			'id'     => $prefix . 'link',
			'type'   => 'text_url',
		)
	);

	/**
	 * Short Image
	 */
	$k2k_metabox->add_field(
		array(
			'name'         => 'Download',
			'desc'         => 'Select a file that the user can download.',
			'id'           => $prefix . 'download',
			'type'         => 'file',
			// Optional.
			'options'      => array(
				'url' => false, // Hide the text input for the url.
			),
			'text'         => array(
				'add_upload_file_text' => 'Add File', // Change upload button text. Default: "Add or Upload File".
			),
			// query_args are passed to wp.media's library query.
			// 'query_args'   => array(
				// 'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				// 'type' => array(
				// 'image/gif',
				// 'image/jpeg',
				// 'image/png'
				// ),
			// ).
			'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
		)
	);

}
