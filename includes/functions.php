<?php
/**
 * K2K - Functions.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom sanitization function for sentences.
 *
 * @param string $value The value to be sanitized and saved.
 * @param array  $field_args The arguments for sanitization.
 * @param string $field The field we are using.
 *
 * @return string The sanitized value - with allowed tags.
 */
function k2k_sanitize_sentence_callback( $value, $field_args, $field ) {

	if ( is_array( $value ) ) {

		$new_value = array_map( 'strip_tags', $value );
		return $new_value;

	} elseif ( ! is_array( $value ) ) {

		/* Custom sanitization - with strip_tags to allow certain tags. */
		$value = strip_tags( $value, '<b><strong><em><span>' );

	}

	return $value;

}

/**
 * Include Template paths
 *
 * @param string $template_path The path to the template.
 */
function k2k_template( $template_path ) {

	$k2k_post_types = K2K_POST_TYPES; // defined in k2k.php - the main plugin file.
	$post_type_here = get_post_type();
	$tax_slug       = is_tax() ? explode( '-', get_query_var( 'taxonomy' ) )[1] : '';

	if ( ! $post_type_here || ( ! in_array( $post_type_here, $k2k_post_types, true ) ) ) {
		return $template_path;
	}

	// Remove 'k2k-' from Post Type name.
	$post_type_slug = explode( '-', $post_type_here )[1];

	if ( is_single() ) {

		$theme_template_single  = locate_template( array( 'single-' . $post_type_slug . '.php' ), false );
		$plugin_template_single = plugin_dir_path( __FILE__ ) . 'vendor/jkl-' . $post_type_slug . '/page-templates/single-' . $post_type_slug . '.php';

		// checks if the file exists in the theme first,
		// otherwise serve the file from the plugin.
		if ( $theme_template_single ) {
			$template_path = $theme_template_single;
		} elseif ( file_exists( $plugin_template_single ) ) {
			$template_path = $plugin_template_single;
		}
	} elseif ( is_archive() ) {

		$theme_template_archive  = locate_template( array( 'archive-' . $post_type_slug . '.php' ), false );
		$plugin_template_archive = plugin_dir_path( __FILE__ ) . 'vendor/jkl-' . $post_type_slug . '/page-templates/archive-' . $post_type_slug . '.php';

		if ( $theme_template_archive ) {
			$template_path = $theme_template_archive;
		} elseif ( file_exists( $plugin_template_archive ) ) {
			$template_path = $plugin_template_archive;
		}
	}

	return $template_path;

}
add_filter( 'template_include', 'k2k_template', 1 );

/**
 * Custom Taxonomy page
 *
 * @param string $tax_template The Taxonomy Template filename.
function k2k_custom_taxonomy_pages( $tax_template ) {
	// if ( is_tax( 'level' ) ) {.
		$tax_template = dirname( __FILE__ ) . '/taxonomy-level.php';
	// }
	return $tax_template;
}
// add_filter( 'taxonomy_template', 'k2k_custom_taxonomy_pages' );
 */

/**
 * Enqueue ReactJS and other scripts
 *
 * @link https://reactjs.org/docs/add-react-to-a-website.html
 */
function k2k_scripts() {

	/* General Purpose Scripts */
	if ( 'k2k' === get_post_type() && is_archive() ) {
		wp_enqueue_script( 'k2k-react', 'https://unpkg.com/react@16/umd/react.development.js', array(), '20181126', true );
		wp_enqueue_script( 'k2k-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', array(), '20181126', true );
		wp_enqueue_script( 'k2k-babel', 'https://unpkg.com/babel-standalone@6/babel.min.js', array(), '20181128', true );
		wp_enqueue_script( 'k2k-components', plugins_url( 'js/GrammarArchives.js', __FILE__ ), array( 'k2k-react', 'k2k-react-dom', 'k2k-babel' ), '20181126', true );
	}

	/* Common Scripts */
	if ( k2k_any_cpt_enabled() ) {
		wp_enqueue_style(
			'k2k-common-style',
			plugins_url( 'includes/shared/css/common-styles.css', __DIR__ ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'includes/shared/css/common-styles.css' )
		);

		if ( is_single() ) { // Still loading on archive pages though...
			wp_enqueue_script(
				'k2k-common-script',
				plugins_url( 'includes/shared/js/common-functions.js', __DIR__ ),
				array(),
				filemtime( plugin_dir_path( __DIR__ ) . 'includes/shared/js/common-functions.js' ),
				true
			);
		}
	}

}
add_action( 'wp_enqueue_scripts', 'k2k_scripts' );

/**
 * Change script tag for JSX script
 *
 * @param string $tag The script tag.
 * @param string $handle The script handle.
 * @param string $src The script source.
 *
 * @link https://milandinic.com/2015/12/01/using-react-jsx-in-wordpress/
 */
function k2k_script_type( $tag, $handle, $src ) {
	// Check that this is output of JSX file.
	if ( 'k2k-components' === $handle ) {
		$tag = str_replace( "<script type='text/javascript'", "<script type='text/babel'", $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'k2k_script_type', 10, 3 );

/**
 * Function to set part of speech styles on a page.
 */
function set_part_of_speech_term_colors() {

	$colors = get_part_of_speech_term_color();

	if ( ( is_singular( 'k2k-grammar' ) || 'k2k-vocabulary' === get_post_type() ) && ! empty( $colors ) ) {
		?>
		<style>
			.part-of-speech { color: #fff; }
			.part-of-speech.adjective { background: <?php echo esc_attr( $colors['adjective'] ); ?> }
			.part-of-speech.verb { background: <?php echo esc_attr( $colors['verb'] ); ?> }
			.part-of-speech.noun { background: <?php echo esc_attr( $colors['noun'] ); ?> }
			.part-of-speech.noun-special { background: <?php echo esc_attr( $colors['noun-special'] ); ?> }
			.part-of-speech.adverb { background: <?php esc_attr( $colors['adverb'] ); ?> }
			.part-of-speech.number { background: <?php esc_attr( $colors['number'] ); ?> }
			.part-of-speech.other { background: <?php esc_attr( $colors['other'] ); ?> }
		</style>
		<?php
	}

}
add_action( 'wp_head', 'set_part_of_speech_term_colors' );

/**
 * Function to return meta box WYSIWYG content with working embeds and shortcodes.
 *
 * @param string  $meta_key The meta box ID to retrieve content for.
 * @param integer $post_id The ID of the post.
 */
function k2k_get_wysiwyg_output( $meta_key, $post_id = 0 ) {

	global $wp_embed;

	$post_id = $post_id ? $post_id : get_the_ID();

	$content = get_post_meta( $post_id, $meta_key, true );
	$content = $wp_embed->autoembed( $content );
	$content = $wp_embed->run_shortcode( $content );
	$content = wpautop( $content );
	$content = do_shortcode( $content );

	return $content;

}

/**
 * Customize Taxonomy Query using Post Meta.
 *
 * @param Object $query The main WordPress query.

function k2k_filter_taxonomy_archive_query( $query ) {

	// Check that we're in a taxonomy archive and using the main query.
	if ( is_tax() ) {

		// Check that our Custom Post Type filter is set.
		if ( isset( $_GET['tax-cpt'], $_POST['tax-filter-nonce'] )
				&& wp_verify_nonce( sanitize_key( $_POST['tax-filter-nonce'] ), $filter_nonce ) ) :

			$filter_post_type = array();
			$filter_nonce     = wp_create_nonce( 'tax-filter-nonce' );

			// Add the Vocabulary CPT to the WP_Query.
			if ( 'vocab' === $_GET['tax-cpt'] ) {
				$filter_post_type[] = 'k2k-vocabulary';
			}
			// Add the Grammar CPT to the WP_Query.
			if ( 'grammar' === $_GET['tax-cpt'] ) {
				$filter_post_type[] = 'k2k-grammar';
			}
			// Add the Phrases CPT to the WP_Query.
			if ( 'phrases' === $_GET['tax-cpt'] ) {
				$filter_post_type[] = 'k2k-phrases';
			}
			// Add the Reading CPT to the WP_Query.
			if ( 'reading' === $_GET['tax-cpt'] ) {
				$filter_post_type[] = 'k2k-reading';
			}
			// Add the Writing CPT to the WP_Query.
			if ( 'writing' === $_GET['tax-cpt'] ) {
				$filter_post_type[] = 'k2k-writing';
			}

			$query->set( 'post_type', $filter_post_type );

		endif;
	}
	$query->set( 'posts_per_page', 50 );

}
add_action( 'pre_get_posts', 'k2k_filter_taxonomy_archive_query' );
*/
