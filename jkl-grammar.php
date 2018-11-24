<?php
/*
 * Plugin Name: JKL Grammar
 * Plugin URI: https://github.com/jekkilekki/plugin-jkl-grammar
 * Description: Custom Post Type to handle Grammar Points
 * Version: 1.0.0
 * Author: jekkilekki
 * Author URI: https://aaron.kr
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jkl-grammar
 * Domain Path: /languages
 */

 /*
JKL Grammar is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
JKL Grammar is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with JKL Grammar. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

register_activation_hook( __FILE__, 'jkl_grammar_setup' );
register_deactivation_hook( __FILE__, 'jkl_grammar_teardown' );

function jkl_grammar_setup() {
  // trigger function for CPT
  jkl_grammar_setup_cpt();

  // add page template
  // jkl_grammar_page_template();
  // jkl_grammar_redirect_page_template();

  include_once( plugin_dir_url( __FILE__ ) . 'functions.php' );

  // clear permalinks after registered CPT
  flush_rewrite_rules();
}

function jkl_grammar_teardown() {
  // unregister CPT
  unregister_post_type( 'grammar' );

  // clear permalinks 
  flush_rewrite_rules();
}

/**
 * Register a custom post type called "Grammar".
 *
 * @see get_post_type_labels() for label keys.
 */
function jkl_grammar_setup_cpt() {
  $labels = array(
      'name'                  => _x( 'Grammar', 'Post type general name', 'jkl-grammar' ),
      'singular_name'         => _x( 'Grammar', 'Post type singular name', 'jkl-grammar' ),
      'menu_name'             => _x( 'Grammar', 'Admin Menu text', 'jkl-grammar' ),
      'name_admin_bar'        => _x( 'Grammar', 'Add New on Toolbar', 'jkl-grammar' ),
      'add_new'               => __( 'Add New', 'jkl-grammar' ),
      'add_new_item'          => __( 'Add New Grammar', 'jkl-grammar' ),
      'new_item'              => __( 'New Grammar', 'jkl-grammar' ),
      'edit_item'             => __( 'Edit Grammar', 'jkl-grammar' ),
      'view_item'             => __( 'View Grammar', 'jkl-grammar' ),
      'all_items'             => __( 'All Grammar', 'jkl-grammar' ),
      'search_items'          => __( 'Search Grammar', 'jkl-grammar' ),
      'parent_item_colon'     => __( 'Parent Grammar:', 'jkl-grammar' ),
      'not_found'             => __( 'No Grammar found.', 'jkl-grammar' ),
      'not_found_in_trash'    => __( 'No Grammar found in Trash.', 'jkl-grammar' ),
      'featured_image'        => _x( 'Grammar Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'jkl-grammar' ),
      'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'jkl-grammar' ),
      'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'jkl-grammar' ),
      'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'jkl-grammar' ),
      'archives'              => _x( 'Grammar archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'jkl-grammar' ),
      'insert_into_item'      => _x( 'Insert into Grammar', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'jkl-grammar' ),
      'uploaded_to_this_item' => _x( 'Uploaded to this Grammar', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'jkl-grammar' ),
      'filter_items_list'     => _x( 'Filter Grammar list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'jkl-grammar' ),
      'items_list_navigation' => _x( 'Grammar list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'jkl-grammar' ),
      'items_list'            => _x( 'Grammar list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'jkl-grammar' ),
  );

  $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'show_in_rest'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'grammar' ),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'          => 'data:image/svg+xml;base64,' . base64_encode('<svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path fill="black" d="M1591 1448q56 89 21.5 152.5t-140.5 63.5h-1152q-106 0-140.5-63.5t21.5-152.5l503-793v-399h-64q-26 0-45-19t-19-45 19-45 45-19h512q26 0 45 19t19 45-19 45-45 19h-64v399zm-779-725l-272 429h712l-272-429-20-31v-436h-128v436z"/></svg>'),
      'supports'           => array( 'title', 'subtitles', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
      'taxonomies'         => array( 'post_tag' )
  );

  register_post_type( 'grammar', $args );
}
add_action( 'init', 'jkl_grammar_setup_cpt' );

/**
 * Create two taxonomies, level and book for the post type "grammar".
 *
 * @see register_post_type() for registering custom post types.
 */
function jkl_grammar_taxonomies() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
      'name'              => _x( 'Level', 'taxonomy general name', 'jkl-grammar' ),
      'singular_name'     => _x( 'Level', 'taxonomy singular name', 'jkl-grammar' ),
      'search_items'      => __( 'Search Levels', 'jkl-grammar' ),
      'all_items'         => __( 'All Levels', 'jkl-grammar' ),
      'parent_item'       => __( 'Parent Level', 'jkl-grammar' ),
      'parent_item_colon' => __( 'Parent Level:', 'jkl-grammar' ),
      'edit_item'         => __( 'Edit Level', 'jkl-grammar' ),
      'update_item'       => __( 'Update Level', 'jkl-grammar' ),
      'add_new_item'      => __( 'Add New Level', 'jkl-grammar' ),
      'new_item_name'     => __( 'New Level Name', 'jkl-grammar' ),
      'menu_name'         => __( 'Levels', 'jkl-grammar' ),
  );

  $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'show_in_rest'      => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'level' ),
  );

  register_taxonomy( 'level', array( 'grammar' ), $args );

  unset( $args );
  unset( $labels );

  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
      'name'              => _x( 'Book', 'taxonomy general name', 'jkl-grammar' ),
      'singular_name'     => _x( 'Book', 'taxonomy singular name', 'jkl-grammar' ),
      'search_items'      => __( 'Search Books', 'jkl-grammar' ),
      'all_items'         => __( 'All Books', 'jkl-grammar' ),
      'parent_item'       => __( 'Parent Book', 'jkl-grammar' ),
      'parent_item_colon' => __( 'Parent Book:', 'jkl-grammar' ),
      'edit_item'         => __( 'Edit Book', 'jkl-grammar' ),
      'update_item'       => __( 'Update Book', 'jkl-grammar' ),
      'add_new_item'      => __( 'Add New Book', 'jkl-grammar' ),
      'new_item_name'     => __( 'New Book Name', 'jkl-grammar' ),
      'menu_name'         => __( 'Books', 'jkl-grammar' ),
  );

  $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'show_in_rest'      => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'book' ),
  );

  register_taxonomy( 'book', array( 'grammar' ), $args );

  unset( $args );
  unset( $labels );

  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
      'name'              => _x( 'Part of Speech', 'taxonomy general name', 'jkl-grammar' ),
      'singular_name'     => _x( 'Part of Speech', 'taxonomy singular name', 'jkl-grammar' ),
      'search_items'      => __( 'Search Parts of Speech', 'jkl-grammar' ),
      'all_items'         => __( 'All Parts of Speech', 'jkl-grammar' ),
      'parent_item'       => __( 'Parent Part of Speech', 'jkl-grammar' ),
      'parent_item_colon' => __( 'Parent Part of Speech:', 'jkl-grammar' ),
      'edit_item'         => __( 'Edit Part of Speech', 'jkl-grammar' ),
      'update_item'       => __( 'Update Part of Speech', 'jkl-grammar' ),
      'add_new_item'      => __( 'Add New Part of Speech', 'jkl-grammar' ),
      'new_item_name'     => __( 'New Part of Speech Name', 'jkl-grammar' ),
      'menu_name'         => __( 'Parts of Speech', 'jkl-grammar' ),
  );

  $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => false,
      'show_in_rest'      => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'part-of-speech' ),
  );

  register_taxonomy( 'part-of-speech', array( 'grammar' ), $args );

  unset( $args );
  unset( $labels );

  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
      'name'              => _x( 'Expression', 'taxonomy general name', 'jkl-grammar' ),
      'singular_name'     => _x( 'Expression', 'taxonomy singular name', 'jkl-grammar' ),
      'search_items'      => __( 'Search Expression', 'jkl-grammar' ),
      'all_items'         => __( 'All Expression', 'jkl-grammar' ),
      'parent_item'       => __( 'Parent Expression', 'jkl-grammar' ),
      'parent_item_colon' => __( 'Parent Expression:', 'jkl-grammar' ),
      'edit_item'         => __( 'Edit Expression', 'jkl-grammar' ),
      'update_item'       => __( 'Update Expression', 'jkl-grammar' ),
      'add_new_item'      => __( 'Add New Expression', 'jkl-grammar' ),
      'new_item_name'     => __( 'New Expression Name', 'jkl-grammar' ),
      'menu_name'         => __( 'Expressions', 'jkl-grammar' ),
  );

  $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => false,
      'show_in_rest'      => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'expression' ),
  );

  register_taxonomy( 'expression', array( 'grammar' ), $args );

  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
      'name'              => _x( 'Usage', 'taxonomy general name', 'jkl-grammar' ),
      'singular_name'     => _x( 'Usage', 'taxonomy singular name', 'jkl-grammar' ),
      'search_items'      => __( 'Search Usage', 'jkl-grammar' ),
      'all_items'         => __( 'All Usage', 'jkl-grammar' ),
      'parent_item'       => __( 'Parent Usage', 'jkl-grammar' ),
      'parent_item_colon' => __( 'Parent Usage:', 'jkl-grammar' ),
      'edit_item'         => __( 'Edit Usage', 'jkl-grammar' ),
      'update_item'       => __( 'Update Usage', 'jkl-grammar' ),
      'add_new_item'      => __( 'Add New Usage', 'jkl-grammar' ),
      'new_item_name'     => __( 'New Usage Name', 'jkl-grammar' ),
      'menu_name'         => __( 'Usage', 'jkl-grammar' ),
  );

  $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => false,
      'show_in_rest'      => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'usage' ),
  );

  register_taxonomy( 'usage', array( 'grammar' ), $args );

  unset( $args );
  unset( $labels );

  unset( $args );
  unset( $labels );
}
// hook into the init action and call jkl_grammar_taxonomies when it fires
add_action( 'init', 'jkl_grammar_taxonomies', 0 );

/**
 * Include Single Grammar page template
 */
function jkl_grammar_single( $template_path ) {
  if ( get_post_type() == 'grammar' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-grammar.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-grammar.php';
      }
    } elseif ( is_archive() ) {
      if ( $theme_file = locate_template( array( 'archive-grammar.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-grammar.php';
      }
    }
  }
  return $template_path;
}
add_filter( 'template_include', 'jkl_grammar_single', 1 );