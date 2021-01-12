<?php
/**
 * K2K - Theme Options Page.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 * @link     https://github.com/CMB2/CMB2-Snippet-Library/blob/master/options-and-settings-pages/theme-options-cmb.php
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_init', 'k2k_add_admin_menu_separator' );
/**
 * Create a Separator for the Admin Menu.
 *
 * @param int $position The location of the menu separator.
 *
 * @link https://tommcfarlin.com/add-a-separator-to-the-wordpress-menu/
 */
function k2k_add_admin_menu_separator( $position ) {

	global $menu;

	// phpcs:ignore
	$menu[ $position ] = array(
		0 => '',
		1 => 'read',
		2 => 'separator' . $position,
		3 => '',
		4 => 'wp-menu-separator',
	);

}

add_action( 'admin_menu', 'k2k_set_admin_menu_separator' );
/**
 * Set the Separator before our plugin options.
 */
function k2k_set_admin_menu_separator() {
	do_action( 'admin_init', K2K_MENU_POSITION - 1 );
}

add_action( 'cmb2_admin_init', 'k2k_register_plugin_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function k2k_register_plugin_options_metabox() {

	$prefix = 'k2k_';

	/**
	 * Registers options page menu item and form.
	 */
	$k2k_options = new_cmb2_box(
		array(
			'id'           => $prefix . 'plugin_options_page',
			'title'        => esc_html__( 'K2K Plugin Options', 'k2k' ),
			'object_types' => array( 'options-page' ),

			/*
			* The following parameters are specific to the options-page box
			* Several of these parameters are passed along to add_menu_page()/add_submenu_page().
			*/

			'option_key'   => 'k2k_options', // The option key and admin menu page slug.
			'icon_url'     => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( plugin_dir_path( __FILE__ ) . '../assets/korean-pattern-sm.svg' ) ), // Menu icon. Only applicable if 'parent_slug' is left empty.
			'menu_title'   => esc_html__( 'K2K Options', 'k2k' ), // Falls back to 'title' (above).
			// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
			// 'capability'      => 'manage_options', // Cap required to view options-page.
			'position'     => K2K_MENU_POSITION, // Menu position. Only applicable if 'parent_slug' is left empty.
			// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
			// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
			'save_button'  => esc_html__( 'Save K2K Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
			// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
			'message_cb'   => 'k2k_options_page_message_cb',
			// 'tab_group'       => '', // Tab-group identifier, enables options page tab navigation.
			// 'tab_title'       => null, // Falls back to 'title' (above).
			// 'autoload'        => false, // Defaults to true, the options-page option will be autloaded.
		)
	);

	/**
	 * Additional Meta data.
	 */
	$k2k_options->add_field(
		array(
			'name' => esc_html__( 'Additional Meta Data', 'k2k' ),
			'desc' => esc_html__( 'Enable additional meta data for User Profiles and Taxonomies.', 'k2k' ),
			'id'   => $prefix . 'opt_box_meta_data',
			'type' => 'title',
		)
	);

	/*
	 * Additional User meta data.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Extra User Data', 'k2k' ),
			'desc'    => __( 'Enable additional meta information (social media URLS, and larger profile images) to be added to User Profiles.', 'k2k' ),
			'id'      => $prefix . 'enable_user_meta',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'  => __( 'Yes', 'k2k' ),
				'off' => __( 'No', 'k2k' ),
			),
		)
	);

	/*
	 * Additional taxonomy meta.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Extra Taxonomy Data', 'k2k' ),
			'desc'    => __( 'Enable additional meta information (images, translations, and colors) for taxonomies like Categories, Tags, and Custom Taxonomies.', 'k2k' ),
			'id'      => $prefix . 'enable_tax_meta',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'  => __( 'Yes', 'k2k' ),
				'off' => __( 'No', 'k2k' ),
			),
		)
	);

	/**
	 * Language Learning Post Types.
	 */
	$k2k_options->add_field(
		array(
			'name' => esc_html__( 'Language Learning Post Types', 'k2k' ),
			'desc' => esc_html__( 'Enable different types of features for language learning.', 'k2k' ),
			'id'   => $prefix . 'opt_box_language_post_types',
			'type' => 'title',
		)
	);

	/*
	 * Vocabulary Post Type.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Vocabulary', 'k2k' ),
			'desc'    => __( 'Enable Vocabulary Post Type.', 'k2k' ),
			'id'      => $prefix . 'enable_vocab',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'  => __( 'Yes', 'k2k' ),
				'off' => __( 'No', 'k2k' ),
			),
		)
	);

	/*
	 * Grammar Post Type.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Grammar', 'k2k' ),
			'desc'    => __( 'Enable Grammar Post Type.', 'k2k' ),
			'id'      => $prefix . 'enable_grammar',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'  => __( 'Yes', 'k2k' ),
				'off' => __( 'No', 'k2k' ),
			),
		)
	);

	/*
	 * Phrases Post Type.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Phrases', 'k2k' ),
			'desc'    => __( 'Enable Phrases Post Type.', 'k2k' ),
			'id'      => $prefix . 'enable_phrases',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'  => __( 'Yes', 'k2k' ),
				'off' => __( 'No', 'k2k' ),
			),
		)
	);

	/*
	 * Reading LWT Post Type.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Reading', 'k2k' ),
			'desc'    => __( 'Enable Learning With Texts Post Type.', 'k2k' ),
			'id'      => $prefix . 'enable_reading',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'  => __( 'Yes', 'k2k' ),
				'off' => __( 'No', 'k2k' ),
			),
		)
	);

	/*
	 * Writing Post Type.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Writing', 'k2k' ),
			'desc'    => __( 'Enable Writing Journal Post Type.', 'k2k' ),
			'id'      => $prefix . 'enable_writing',
			'type'    => 'switch',
			'default' => 0,
		)
	);

	/**
	 * Add Default taxonomy terms.
	 */
	$k2k_options->add_field(
		array(
			'name' => esc_html__( 'Default Taxonomy Terms', 'k2k' ),
			'desc' => esc_html__( 'Add default Taxonomy Terms for K2K\'s Custom Post Types.', 'k2k' ),
			'id'   => $prefix . 'opt_box_default_terms',
			'type' => 'title',
		)
	);

	/*
	 * Use Default taxonomy terms.
	 */
	$k2k_options->add_field(
		array(
			'name'    => __( 'Default Taxonomy Terms', 'k2k' ),
			'desc'    => __( 'Preload default taxonomy terms like Beginner, Intermediate, Advanced, and so on.', 'k2k' ),
			'id'      => $prefix . 'use_default_terms',
			'type'    => 'switch',
			'default' => 0,
			'label'   => array(
				'on'  => __( 'Yes', 'k2k' ),
				'off' => __( 'No', 'k2k' ),
			),
		)
	);

}

/**
 * Callback to define the options-saved message.
 *
 * @param CMB2  $cmb The CMB2 object.
 * @param array $args {
 *     An array of message arguments.
 *
 *     @type bool   $is_options_page Whether current page is this options page.
 *     @type bool   $should_notify   Whether options were saved and we should be notified.
 *     @type bool   $is_updated      Whether options were updated with save (or stayed the same).
 *     @type string $setting         For add_settings_error(), Slug title of the setting to which
 *                                   this error applies.
 *     @type string $code            For add_settings_error(), Slug-name to identify the error.
 *                                   Used as part of 'id' attribute in HTML output.
 *     @type string $message         For add_settings_error(), The formatted message text to display
 *                                   to the user (will be shown inside styled `<div>` and `<p>` tags).
 *                                   Will be 'Settings updated.' if $is_updated is true, else 'Nothing to update.'
 *     @type string $type            For add_settings_error(), Message type, controls HTML class.
 *                                   Accepts 'error', 'updated', '', 'notice-warning', etc.
 *                                   Will be 'updated' if $is_updated is true, else 'notice-warning'.
 * }
 */
function k2k_options_page_message_cb( $cmb, $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			// Translators: %s is the setting that was updated.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cmb2' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}

/**
 * Wrapper function around cmb2_get_option
 *
 * @since  0.1.0
 *
 * @param  string $key     Options array key.
 * @param  mixed  $default Optional default value.
 * @return mixed           Option value
 */
function k2k_get_option( $key = '', $default = false ) {

	if ( function_exists( 'cmb2_get_option' ) ) {

		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( 'k2k_options', $key, $default );

	}

	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'k2k_options', $default );
	$val  = $default;

	if ( 'all' === $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;

}
