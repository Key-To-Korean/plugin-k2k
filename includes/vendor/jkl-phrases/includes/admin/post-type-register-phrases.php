<?php
/**
 * K2K - Register Phrases Post Type.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a custom post type called "Phrases".
 *
 * @see get_post_type_labels() for label keys.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function k2k_register_post_type_phrases() {

	$labels = array(
		'name'                  => _x( 'Phrase', 'Post type general name', 'k2k' ),
		'singular_name'         => _x( 'Phrase', 'Post type singular name', 'k2k' ),
		'menu_name'             => _x( 'Phrases', 'Admin Menu text', 'k2k' ),
		'name_admin_bar'        => _x( 'Phrases', 'Add New on Toolbar', 'k2k' ),
		'add_new'               => __( 'Add New', 'k2k' ),
		'add_new_item'          => __( 'Add New Phrase', 'k2k' ),
		'new_item'              => __( 'New Phrase', 'k2k' ),
		'edit_item'             => __( 'Edit Phrase', 'k2k' ),
		'view_item'             => __( 'View Phrase', 'k2k' ),
		'all_items'             => __( 'All Phrases', 'k2k' ),
		'search_items'          => __( 'Search Phrases', 'k2k' ),
		'parent_item_colon'     => __( 'Base Phrase:', 'k2k' ),
		'not_found'             => __( 'No Phrases found.', 'k2k' ),
		'not_found_in_trash'    => __( 'No Phrases found in Trash.', 'k2k' ),
		'featured_image'        => _x( 'Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'k2k' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'archives'              => _x( 'Phrases Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'k2k' ),
		'insert_into_item'      => _x( 'Insert into Phrase', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'k2k' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Phrase', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'k2k' ),
		'filter_items_list'     => _x( 'Filter Phrases list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'k2k' ),
		'items_list_navigation' => _x( 'Phrases list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'k2k' ),
		'items_list'            => _x( 'Phrases list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'k2k' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'rest_base'          => 'phrase',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'phrase' ),
		'capability_type'    => 'post',
		'has_archive'        => 'phrases',
		'hierarchical'       => false,
		'menu_position'      => K2K_MENU_POSITION + 3,
		'menu_icon'          => 'dashicons-format-chat',
		'supports'           => array( 'title', 'thumbnail' ),
		// 'taxonomies'         => array( 'post_tag' ),
	);

	register_post_type( 'k2k-phrases', $args );

}
add_action( 'init', 'k2k_register_post_type_phrases' );

/**
 * Change Post Editor Title.
 *
 * @param string $title The title in the Editor.
 * @param object $post The Post object.
 *
 * @link https://wordpress.stackexchange.com/questions/213979/change-post-title-edit-box
 */
function k2k_change_editor_title_phrases( $title, $post ) {

	if ( 'k2k-phrases' === $post->post_type ) {
		$title = __( 'Phrase (KO)', 'k2k' );
	}

	return $title;

}
add_filter( 'enter_title_here', 'k2k_change_editor_title_phrases', 10, 2 );

/**
 * Change Post List Title Column Name.
 *
 * @param array $columns The array of Posts columns.
 */
function k2k_change_post_list_column_phrases( $columns ) {
	$columns['title'] = 'Phrase (KO)';
	return $columns;
}
add_filter( 'manage_k2k-phrases_posts_columns', 'k2k_change_post_list_column_phrases' );

/**
 * Remove Taxonomy Meta boxes from the side menu.
 *
 * @link https://codex.wordpress.org/Function_Reference/remove_meta_box
 */
function k2k_remove_taxonomy_meta_boxes_phrases() {

	remove_meta_box( 'tagsdiv-k2k-expression', 'k2k-phrases', 'side' );
	remove_meta_box( 'tagsdiv-k2k-topic', 'k2k-phrases', 'side' );

}
add_action( 'admin_menu', 'k2k_remove_taxonomy_meta_boxes_phrases' );
