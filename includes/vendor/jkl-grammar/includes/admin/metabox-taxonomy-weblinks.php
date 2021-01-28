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

add_action( 'cmb2_admin_init', 'k2k_register_taxonomy_weblink_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function k2k_register_taxonomy_weblink_metabox() {
	$prefix = 'k2k_taxonomy_';

	/**
	 * Metabox to add fields to categories and tags
	 */
	$k2k_tax_term = new_cmb2_box(
		array(
			'id'           => $prefix . 'weblinks',
			'title'        => esc_html__( 'Book Web Link', 'k2k' ), // Doesn't output for term boxes.
			'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta.
			'taxonomies'   => 'k2k-grammar-book', // Tells CMB2 which taxonomies should have these fields.
			// 'new_term_section' => true, // Will display in the "Add New Category" section.
		)
	);

	$k2k_tax_term->add_field(
		array(
			'name' => esc_html__( 'Web Link', 'k2k' ),
			'desc' => esc_html__( 'Add an optional web link for this taxonomy.', 'k2k' ),
			'id'   => $prefix . 'term_link',
			'type' => 'text',
		)
	);

	$k2k_tax_term->add_field(
		array(
			'name' => esc_html__( 'Affiliate link?', 'k2k' ),
			'desc' => esc_html__( 'If the link is an affiliate link, output a small notice.', 'k2k' ),
			'id'   => $prefix . 'term_affiliate',
			'type' => 'checkbox',
		)
	);

}
