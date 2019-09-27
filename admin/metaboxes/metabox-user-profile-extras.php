<?php
/**
 * K2K - Register Extra User Profile Metabox.
 *
 * @package K2K
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link    https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_user_profile_metabox' );
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
function k2k_register_user_profile_metabox() {
	$prefix = 'k2k_user_';

	/**
	 * Metabox for the user profile screen
	 */
	$cmb_user = new_cmb2_box(
		array(
			'id'               => $prefix . 'edit',
			'title'            => esc_html__( 'User Profile Metabox', 'k2k' ), // Doesn't output for user boxes.
			'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta.
			'show_names'       => true,
			'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
		)
	);

	$cmb_user->add_field(
		array(
			'name'     => esc_html__( 'Extra Info', 'k2k' ),
			'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'extra_info',
			'type'     => 'title',
			'on_front' => false,
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Full-size "action" image', 'k2k' ),
			'desc' => esc_html__( 'field description (optional)', 'k2k' ),
			'id'   => $prefix . 'avatar',
			'type' => 'file',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Facebook URL', 'k2k' ),
			'desc' => esc_html__( 'field description (optional)', 'k2k' ),
			'id'   => $prefix . 'facebookurl',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Twitter URL', 'k2k' ),
			'desc' => esc_html__( 'field description (optional)', 'k2k' ),
			'id'   => $prefix . 'twitterurl',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Linkedin URL', 'k2k' ),
			'desc' => esc_html__( 'field description (optional)', 'k2k' ),
			'id'   => $prefix . 'linkedinurl',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'User Field', 'k2k' ),
			'desc' => esc_html__( 'field description (optional)', 'k2k' ),
			'id'   => $prefix . 'user_text_field',
			'type' => 'text',
		)
	);

}
