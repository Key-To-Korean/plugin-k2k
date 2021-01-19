<?php
/**
 * K2K - Register Vocabulary Post Type.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a custom post type called "Vocabulary".
 *
 * @see get_post_type_labels() for label keys.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function k2k_register_post_type_vocabulary() {

	$labels = array(
		'name'                  => _x( 'Vocabulary', 'Post type general name', 'k2k' ),
		'singular_name'         => _x( 'Vocabulary', 'Post type singular name', 'k2k' ),
		'menu_name'             => _x( 'Vocabulary', 'Admin Menu text', 'k2k' ),
		'name_admin_bar'        => _x( 'Vocabulary', 'Add New on Toolbar', 'k2k' ),
		'add_new'               => __( 'Add New', 'k2k' ),
		'add_new_item'          => __( 'Add New Vocabulary Word', 'k2k' ),
		'new_item'              => __( 'New Vocabulary Word', 'k2k' ),
		'edit_item'             => __( 'Edit Vocabulary Word', 'k2k' ),
		'view_item'             => __( 'View Vocabulary Word', 'k2k' ),
		'all_items'             => __( 'All Vocabulary Words', 'k2k' ),
		'search_items'          => __( 'Search Vocabulary Words', 'k2k' ),
		'parent_item_colon'     => __( 'Root Vocabulary Word:', 'k2k' ),
		'not_found'             => __( 'No Vocabulary Words found.', 'k2k' ),
		'not_found_in_trash'    => __( 'No Vocabulary Words found in Trash.', 'k2k' ),
		'featured_image'        => _x( 'Defining Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'k2k' ),
		'set_featured_image'    => _x( 'Set defining image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'remove_featured_image' => _x( 'Remove defining image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'use_featured_image'    => _x( 'Use as defining image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'k2k' ),
		'archives'              => _x( 'Vocabulary Archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'k2k' ),
		'insert_into_item'      => _x( 'Insert into Vocabulary Word', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'k2k' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Vocabulary Word', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'k2k' ),
		'filter_items_list'     => _x( 'Filter Vocabulary Words list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'k2k' ),
		'items_list_navigation' => _x( 'Vocabulary Words list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'k2k' ),
		'items_list'            => _x( 'Vocabulary Words list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'k2k' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'rest_base'          => 'vocabulary',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'dictionary' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => K2K_MENU_POSITION + 1,
		'menu_icon'          => 'dashicons-translation',
		'supports'           => array( 'title', 'thumbnail' ),
		// 'taxonomies'         => array( 'post_tag' ),
	);

	register_post_type( 'k2k-vocabulary', $args );

}
add_action( 'init', 'k2k_register_post_type_vocabulary' );

/**
 * Change Post Editor Title.
 *
 * @param string $title The title in the Editor.
 * @param object $post The Post object.
 *
 * @link https://wordpress.stackexchange.com/questions/213979/change-post-title-edit-box
 */
function k2k_change_editor_title_vocabulary( $title, $post ) {

	if ( 'k2k-vocabulary' === $post->post_type ) {
		$title = __( 'Vocabulary Word (KO)', 'k2k' );
	}

	return $title;

}
add_filter( 'enter_title_here', 'k2k_change_editor_title_vocabulary', 10, 2 );

/**
 * Change Post List Title Column Name.
 *
 * @param array $columns The array of Posts columns.
 */
function k2k_change_post_list_column_vocabulary( $columns ) {
	$columns['title'] = 'Vocabulary (KO)';
	return $columns;
}
add_filter( 'manage_k2k-vocabulary_posts_columns', 'k2k_change_post_list_column_vocabulary' );

/**
 * Remove Taxonomy Meta boxes from the side menu.
 *
 * @link https://codex.wordpress.org/Function_Reference/remove_meta_box
 */
function k2k_remove_taxonomy_meta_boxes_vocab() {

	remove_meta_box( 'k2k-vocab-leveldiv', 'k2k-vocabulary', 'side' );
	remove_meta_box( 'tagsdiv-k2k-vocab-part-of-speech', 'k2k-vocabulary', 'side' );
	remove_meta_box( 'tagsdiv-k2k-vocab-topic', 'k2k-vocabulary', 'side' );

}
add_action( 'admin_menu', 'k2k_remove_taxonomy_meta_boxes_vocab' );
