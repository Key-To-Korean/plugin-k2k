<?php
/**
 * Build Page for React App
 */
$my_page = get_option( 'jkl_grammar_index' );
if ( ! $my_page || FALSE === get_post_status( $my_page ) ) {
  // Create post/page object
  $my_new_page = array(
    'post_title' => 'JKL Grammar Index',
    'post_content' => '',
    'post_status' => 'publish',
    'post_type' => 'page'
  );
  // Insert the post into the database
  $my_page = wp_insert_post( $my_new_page );
  update_option( 'jkl_grammar_index', $my_page );
}

/**
 * Enqueue React Styles
 */
$my_page = get_option( 'jkl_grammar_index' );
if ( $my_page && is_page( $my_page ) ) {
  if ( ! in_array( $_SERVER[ 'REMOTE_ADDR' ], array( '127.0.0.1', '::1' ) ) ) {
    $CSSfiles = scandir( dirname( __FILE__ ) . '/jkl_grammar_react/build/static/css/' );
    foreach( $CSSfiles as $filename ) {
      if ( strpos( $filename, '.css' ) && ! strpos( $filename, '.css.map' ) ) {
        wp_enqueue_style( 'jkl_grammar_react_css', plugin_dir_url( __FILE__ ) . 'jkl_grammar_react/build/static/css/' . $filename, array(), mt_rand( 10,1000 ), 'all' );
      }
    }
  }
} else {
  wp_enqueue_style( 'jkl-grammar-styles', plugin_dir_url( __FILE__ ) . 'css/jkl_grammar_react-public.css', array(), mt_rand(10,1000), 'all' );
}

/**
 * Enqueue React Scripts
 */
$my_page = get_option( 'jkl_grammar_index' );
if ( $my_page && is_page( $my_page ) ) {
  if ( ! in_array( $_SERVER['REMOTE_ADDR' ], array( '127.0.0.1', '::1' ) ) ) {
    // code for localhost here
    // PROD
    $JSfiles = scandir( dirname( __FILE__ ) . '/jkl_grammar_react/build/static/js/' );
    $react_js_to_load = '';
    foreach ( $JSfiles as $filename ) {
      if ( strpos( $filename, '.js' ) && ! strpos( $filename, '.js.map' ) ) {
        $react_js_to_load = plugin_dir_url( __FILE__ ) . 'jkl_grammar_react/build/static/js/' . $filename;
      }
    }
  } else {
    $react_js_to_load = 'http://localhost:3000/static/js/bundle.js';
  }
  // DEV
  // React dynamic loading
  wp_enqueue_script( 'jkl_grammar_react', $react_js_to_load, '', mt_rand(10,1000), true );
  // wp_register_script('jkl_grammar_react', $react_js_to_load, '', mt_rand(10,1000), true);
  //
  // wp_localize_script('jkl_grammar_react, 'params', array(
  //     'nonce' => wp_create_nonce('wp_rest'),
  //     'nonce_verify' => wp_verify_nonce($_REQUEST['X-WP-Nonce'], 'wp_rest')
  // ));
  // wp_enqueue_script( 'jkl_grammar_react' );
} else {
  wp_enqueue_script( 'jkl-grammar-scripts', plugin_dir_url( __FILE__ ) . 'js/jkl_grammar_react-public.js', array( 'jquery' ), mt_rand(10,1000), false );
}