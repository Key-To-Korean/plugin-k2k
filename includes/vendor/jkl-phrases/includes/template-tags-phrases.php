<?php
/**
 * JKL Phrases Template Tags.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Search Form for Phrases Post Type.
 */
function display_phrases_search_form() {
	?>
	<form action="/" method="get" class="phrases-search k2k-search">
		<label for="search" class="screen-reader-text"><?php esc_html_e( 'Search Phrases', 'k2k' ); ?></label>
		<input type="text" name="s" id="search" placeholder="<?php esc_html_e( 'Search Phrases', 'k2k' ); ?>" value="<?php the_search_query(); ?>" />
		<!-- <input type="submit" value="<?php esc_html_e( 'Search', 'k2k' ); ?>" /> -->
		<input type="hidden" value="k2k-phrases" name="post_type" id="post_type" />
	</form>
	<?php
}

/**
 * Custom navigation for Phrases Post Type.
 *
 * Default Taxonomy is 'Expression' - but can pass in a different taxonomy if desired.
 * Possible taxonomies for Phrases are 'Expression', 'Topic', 'Phrase Type'.
 *
 * @param string $taxonomy The taxonomy to display post navigation for.
 */
function display_phrases_navigation( $taxonomy = 'k2k-expression' ) {
	?>
	<nav id="nav-above" class="navigation post-navigation phrases-navigation" role="navigation">
		<p class="screen-reader-text"><?php esc_html_e( 'Phrases Navigation', 'k2k' ); ?></p>
		<div class="nav-index">
			<span class="meta-nav"><a href="<?php echo esc_url( get_home_url() ) . '/phrases/'; ?>"><?php esc_html_e( 'Phrases Index', 'k2k' ); ?></a></span>
		</div>
		<div class="nav-links">
			<div class="nav-previous">
				<?php previous_post_link( '%link', '&#9668; %title', true, '', $taxonomy ); ?>
			</div>
			<div class="nav-next">
				<?php next_post_link( '%link', '%title &#9658;', true, '', $taxonomy ); ?>
			</div>
		</div>
	</nav><!-- #nav-above -->
	<?php
}

/**
 * Function to display the Phrase meaning and / or translation.
 *
 * @param array $meta The array of meta data associated with the post.
 */
function display_phrase_subtitle( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_phrases_get_meta_data();
	}

	if ( ! array_key_exists( 'meaning', $meta ) && ! array_key_exists( 'translation', $meta ) ) {
		return;
	}

	$subtitle   = array_key_exists( 'meaning', $meta ) ? $meta['meaning'] : $meta['translation'];
	$definition = array_key_exists( 'meaning', $meta ) ? $meta['translation'] : '';
	?>

	<?php echo is_archive() ? '<hgroup class="archive-titles">' : ''; ?>
		<h2 class="entry-subtitle translation"><?php echo esc_html( $subtitle ); ?></h2>
		<?php echo '' !== $definition ? '<p class="entry-definition">' . esc_html( $definition ) . '</p>' : ''; ?>
	<?php echo is_archive() ? '</hgroup>' : ''; ?>

	<?php
}

/**
 * Function to display the entry meta for the Phrases Post.
 *
 * @param array $meta The post meta.
 */
function display_phrases_entry_meta( $meta ) {

	// Topic.
	if ( array_key_exists( 'topic', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list topic-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Topic: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-topic' );
		echo '</ul>';
	}

	// Expression.
	if ( array_key_exists( 'expression', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list expression-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Expression: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-expression' );
		echo '</ul>';
	}

	// Post Edit Link.
	gaya_edit_post_link();

}
