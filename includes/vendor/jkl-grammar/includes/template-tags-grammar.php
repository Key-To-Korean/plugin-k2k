<?php
/**
 * JKL Grammar Template Tags.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Search Form for Grammar Post Type.
 */
function display_grammar_search_form() {
	?>
	<form action="/" method="get" class="grammar-search k2k-search">
		<label for="search" class="screen-reader-text"><?php esc_html_e( 'Search Grammar', 'k2k' ); ?></label>
		<input type="text" name="s" id="search" placeholder="<?php esc_html_e( 'Search Grammar', 'k2k' ); ?>" value="<?php the_search_query(); ?>" />
		<!-- <input type="submit" value="<?php esc_html_e( 'Search', 'k2k' ); ?>" /> -->
		<input type="hidden" value="k2k-grammar" name="post_type" id="post_type" />
	</form>
	<?php
}
