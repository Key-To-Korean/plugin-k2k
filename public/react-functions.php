<?php
/**
 * Build Page for React App
 */
$my_page = get_option( 'k2k_index' );
if ( ! $my_page || FALSE === get_post_status( $my_page ) ) {
  // Create post/page object
  $my_new_page = array(
    'post_title' => 'K2K Index',
    'post_content' => '',
    'post_status' => 'publish',
    'post_type' => 'page'
  );
  // Insert the post into the database
  $my_page = wp_insert_post( $my_new_page );
  update_option( 'k2k_index', $my_page );
}

/**
 * Enqueue React Styles
 */
$my_page = get_option( 'k2k_index' );
if ( $my_page && is_page( $my_page ) ) {
  if ( ! in_array( $_SERVER[ 'REMOTE_ADDR' ], array( '127.0.0.1', '::1' ) ) ) {
    $CSSfiles = scandir( dirname( __FILE__ ) . '/k2k_react/build/static/css/' );
    foreach( $CSSfiles as $filename ) {
      if ( strpos( $filename, '.css' ) && ! strpos( $filename, '.css.map' ) ) {
        wp_enqueue_style( 'k2k_react_css', plugin_dir_url( __FILE__ ) . 'k2k_react/build/static/css/' . $filename, array(), mt_rand( 10,1000 ), 'all' );
      }
    }
  }
} else {
  wp_enqueue_style( 'k2k-styles', plugin_dir_url( __FILE__ ) . 'css/k2k_react-public.css', array(), mt_rand(10,1000), 'all' );
}

/**
 * Enqueue React Scripts
 */
$my_page = get_option( 'k2k_index' );
if ( $my_page && is_page( $my_page ) ) {
  if ( ! in_array( $_SERVER['REMOTE_ADDR' ], array( '127.0.0.1', '::1' ) ) ) {
    // code for localhost here
    // PROD
    $JSfiles = scandir( dirname( __FILE__ ) . '/k2k_react/build/static/js/' );
    $react_js_to_load = '';
    foreach ( $JSfiles as $filename ) {
      if ( strpos( $filename, '.js' ) && ! strpos( $filename, '.js.map' ) ) {
        $react_js_to_load = plugin_dir_url( __FILE__ ) . 'k2k_react/build/static/js/' . $filename;
      }
    }
  } else {
    $react_js_to_load = 'http://localhost:3000/static/js/bundle.js';
  }
  // DEV
  // React dynamic loading
  wp_enqueue_script( 'k2k_react', $react_js_to_load, '', mt_rand(10,1000), true );
  // wp_register_script('k2k_react', $react_js_to_load, '', mt_rand(10,1000), true);
  //
  // wp_localize_script('k2k_react, 'params', array(
  //     'nonce' => wp_create_nonce('wp_rest'),
  //     'nonce_verify' => wp_verify_nonce($_REQUEST['X-WP-Nonce'], 'wp_rest')
  // ));
  // wp_enqueue_script( 'k2k_react' );
} else {
  wp_enqueue_script( 'k2k-scripts', plugin_dir_url( __FILE__ ) . 'js/k2k_react-public.js', array( 'jquery' ), mt_rand(10,1000), false );
}