<?php
/**
 * K2K - Register Vocab List Post Type.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a custom post type called "Vocab List".
 *
 * @see get_post_type_labels() for label keys.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function k2k_register_post_type_vocab_list() {

	$labels = array(
		'name'                  => _x( 'Vocab List', 'Post type general name', 'k2k' ),
		'singular_name'         => _x( 'Vocab List', 'Post type singular name', 'k2k' ),
		'menu_name'             => _x( 'Vocab List', 'Admin Menu text', 'k2k' ),
		'name_admin_bar'        => _x( 'Vocab List', 'Add New on Toolbar', 'k2k' ),
		'add_new'               => __( 'Add New', 'k2k' ),
		'add_new_item'          => __( 'Add New Vocab List', 'k2k' ),
		'new_item'              => __( 'New Vocab List', 'k2k' ),
		'edit_item'             => __( 'Edit Vocab List', 'k2k' ),
		'view_item'             => __( 'View Vocab List', 'k2k' ),
		'all_items'             => __( 'All Vocab Lists', 'k2k' ),
		'search_items'          => __( 'Search Vocab Lists', 'k2k' ),
		'parent_item_colon'     => __( 'Root Vocab List:', 'k2k' ),
		'not_found'             => __( 'No Vocab Lists found.', 'k2k' ),
		'not_found_in_trash'    => __( 'No Vocab Lists found in Trash.', 'k2k' ),
		'featured_image'        => _x( 'Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'k2k' ),
		'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'archives'              => _x( 'Vocab List Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'k2k' ),
		'insert_into_item'      => _x( 'Insert into Vocab List', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'k2k' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Vocab List', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'k2k' ),
		'filter_items_list'     => _x( 'Filter Vocab Lists', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'k2k' ),
		'items_list_navigation' => _x( 'Vocab List navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'k2k' ),
		'items_list'            => _x( 'Vocab Lists', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'k2k' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'rest_base'          => 'vocab-list',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'vocab-list' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => K2K_MENU_POSITION + 1,
		'menu_icon'          => 'dashicons-pdf',
		'supports'           => array( 'title', 'excerpt', 'thumbnail', 'comments', 'revisions' ),
		// 'taxonomies'         => array( 'post_tag' ),
	);

	register_post_type( 'k2k-vocab-list', $args );

}
add_action( 'init', 'k2k_register_post_type_vocab_list' );

/**
 * Change Post Editor Title.
 *
 * @param string $title The title in the Editor.
 * @param object $post The Post object.
 *
 * @link https://wordpress.stackexchange.com/questions/213979/change-post-title-edit-box
 */
function k2k_change_editor_title_vocab_list( $title, $post ) {

	if ( 'k2k-vocab-list' === $post->post_type ) {
		$title = __( 'Vocab List (KO)', 'k2k' );
	}

	return $title;

}
add_filter( 'enter_title_here', 'k2k_change_editor_title_vocab_list', 10, 2 );

/**
 * Change Post List Title Column Name.
 *
 * @param array $columns The array of Posts columns.
 */
function k2k_change_post_list_column_vocab_list( $columns ) {
	$columns['title'] = 'Vocabulary (KO)';
	return $columns;
}
add_filter( 'manage_k2k-vocab_list_posts_columns', 'k2k_change_post_list_column_vocab_list' );

/**
 * Remove Taxonomy Meta boxes from the side menu.
 *
 * @link https://codex.wordpress.org/Function_Reference/remove_meta_box
 */
// function k2k_remove_taxonomy_meta_boxes_vocab_list() {

// 	remove_meta_box( 'k2k-vocab-leveldiv', 'k2k-vocab-list', 'side' );
// 	remove_meta_box( 'tagsdiv-k2k-vocab-part-of-speech', 'k2k-vocab-list', 'side' );
// 	remove_meta_box( 'tagsdiv-k2k-vocab-topic', 'k2k-vocab-list', 'side' );

// }
// add_action( 'admin_menu', 'k2k_remove_taxonomy_meta_boxes_vocab_list' );
