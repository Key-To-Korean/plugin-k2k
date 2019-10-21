<?php
/**
 * K2K - Register Taxonomy Term Color.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_taxonomy_term_color_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function k2k_register_taxonomy_term_color_metabox() {
	$prefix = 'k2k_taxonomy_';

	/**
	 * Metabox to add fields to categories and tags
	 */
	$k2k_tax_term = new_cmb2_box(
		array(
			'id'           => $prefix . 'term_color_box',
			'title'        => esc_html__( 'Term Color', 'k2k' ), // Doesn't output for term boxes.
			'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta.
			'taxonomies'   => array( 'k2k-level', 'k2k-part-of-speech', 'k2k-tenses' ), // Tells CMB2 which taxonomies should have these fields.
			// 'new_term_section' => true, // Will display in the "Add New Category" section.
		)
	);

	$k2k_tax_term->add_field(
		array(
			'name'       => esc_html__( 'Term Color', 'k2k' ),
			'desc'       => esc_html__( 'Select the color for this Term.', 'k2k' ),
			'id'         => $prefix . 'term_color',
			'type'       => 'colorpicker',
			'default'    => '#ffffff',
			'column'     => array( 'position' => 3 ),
			'attributes' => array(
				'data-colorpicker' => wp_json_encode(
					array(
						// Iris Options set here as values in the 'data-colorpicker' array.
						'palettes' => K2K_COLORS,
					)
				),
			),
		)
	);

}
