<?php
/**
 * K2K - Register Taxonomy Extras Metabox.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_taxonomy_extras_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function k2k_register_taxonomy_extras_metabox() {
	$prefix = 'k2k_taxonomy_';

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box(
		array(
			'id'           => $prefix . 'edit',
			'title'        => esc_html__( 'Category Metabox', 'k2k' ), // Doesn't output for term boxes.
			'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta.
			'taxonomies'   => K2K_TAXES, // Tells CMB2 which taxonomies should have these fields.
			// 'new_term_section' => true, // Will display in the "Add New Category" section.
		)
	);

	/**
	$cmb_term->add_field(
		array(
			'name'     => esc_html__( 'K2K Extra Meta', 'k2k' ),
			'id'       => $prefix . 'extra_info',
			'type'     => 'title',
			'on_front' => false,
		)
	);
	*/

	$cmb_term->add_field(
		array(
			'name' => esc_html__( 'Term Image', 'k2k' ),
			'desc' => esc_html__( 'Featured image to show by default for posts with this Term.', 'k2k' ),
			'id'   => $prefix . 'avatar',
			'type' => 'file',
		)
	);

}
