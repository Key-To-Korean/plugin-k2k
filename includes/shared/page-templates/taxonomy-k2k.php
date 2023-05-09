<?php
/**
 * The template for displaying (shared) Level archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package K2K
 */

get_header();

// Check that our Custom Post Type filter is set.
if ( isset( $_GET['tax-cpt'], $_POST['tax-filter-nonce'] )
		&& wp_verify_nonce( sanitize_key( $_POST['tax-filter-nonce'] ), $filter_nonce ) ) :

	$filter_post_type = array();
	$filter_nonce     = wp_create_nonce( 'tax-filter-nonce' );

	// Add the Vocab List CPT to the WP_Query.
	if ( 'vocab-list' === $_GET['tax-cpt'] ) {
		$filter_post_type[] = 'k2k-vocab-list';
	}
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
endif;
?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Display the appropriate header when required. */
		k2k_index_header();
		?>

		<form class="page-section taxonomy-filter">
			<!-- <input type="checkbox" name="tax-cpt" value="all" checked/>All -->
			<span class="field-wrapper">
				<input id="vocab-list-cpt" type="checkbox" name="tax-cpt" value="vocab-list" <?php echo ( isset( $_GET['tax-cpt'] ) && 'vocab-list' === $_GET['tax-cpt'] ) ? 'checked' : ''; ?> />
				<label for="vocab-list-cpt"> Vocab List</label>
			</span>
			<span class="field-wrapper">
				<input id="vocab-cpt" type="checkbox" name="tax-cpt" value="vocab" <?php echo ( isset( $_GET['tax-cpt'] ) && 'vocab' === $_GET['tax-cpt'] ) ? 'checked' : ''; ?> />
				<label for="vocab-cpt"> Vocabulary</label>
			</span>
			<span class="field-wrapper">
				<input id="grammar-cpt" type="checkbox" name="tax-cpt" value="grammar" <?php echo ( isset( $_GET['tax-cpt'] ) && 'grammar' === $_GET['tax-cpt'] ) ? 'checked' : ''; ?> />
				<label for="grammar-cpt"> Grammar</label>
			</span>
			<span class="field-wrapper">
				<input id="phrases-cpt" type="checkbox" name="tax-cpt" value="phrases" <?php echo ( isset( $_GET['tax-cpt'] ) && 'phrases' === $_GET['tax-cpt'] ) ? 'checked' : ''; ?> />
				<label for="phrases-cpt"> Phrases</label>
			</span>
			<span class="field-wrapper">
				<input id="reading-cpt" type="checkbox" name="tax-cpt" value="reading" <?php echo ( isset( $_GET['tax-cpt'] ) && 'reading' === $_GET['tax-cpt'] ) ? 'checked' : ''; ?> />
				<label for="reading-cpt"> Reading</label>
			</span>
			<span class="field-wrapper">
				<input id="writing-cpt" type="checkbox" name="tax-cpt" value="writing" <?php echo ( isset( $_GET['tax-cpt'] ) && 'writing' === $_GET['tax-cpt'] ) ? 'checked' : ''; ?> />
				<label for="writing-cpt"> Writing</label>
			</span>
			<input class="btn btn-small" type="submit" value="Filter"/>
		</form>

		<?php
		// require_once 'sidebar-vocabulary.php';.

		echo '<ul class="vocabulary-posts-grid archive-posts-grid">';

		/* Start the "Official" Loop */
		$count = 0;
		while ( have_posts() && $count < 20 ) :
			the_post();

			/*
			 * Include the component stylesheet for the content.
			 * This call runs only once on index and archive pages.
			 * At some point, override functionality should be built in similar to the template part below.
			 */
			wp_print_styles( array( 'gaya-content' ) ); // Note: If this was already done it will be skipped.

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			?>
			<li class="vocabulary-item">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php $part_of_speech = get_part_of_speech(); ?>

					<?php if ( '' !== $part_of_speech ) : ?>
						<a class="part-of-speech part-of-speech-circle <?php echo esc_attr( strtolower( $part_of_speech['name'] ) ); ?>"
							href="/part-of-speech/<?php echo esc_attr( $part_of_speech['slug'] ); ?>">
							<?php echo esc_attr( $part_of_speech['letter'] ); ?>
						</a>
					<?php endif; ?>

					<header class="entry-header">
						<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
							<?php
								display_level_stars();
								the_title( '<h2 class="entry-title">', '</h2>' );
								echo '<span class="entry-subtitle">' . esc_html( get_vocab_subtitle() ) . '</span>';
							?>
						</a>
					</header><!-- .entry-header -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</li>
			<?php

			$count++;
		endwhile;
		?>

		</ul>

		<hr />
		<section class="page-section archive-taxonomies vocabulary-taxonomies-list">
			<?php
				display_taxonomy_list( 'k2k-level', __( 'All Levels', 'k2k' ) );
				display_taxonomy_list( 'k2k-part-of-speech', __( 'All Parts of Speech', 'k2k' ) );
				display_taxonomy_list( 'k2k-topic', __( 'All Topics', 'k2k' ) );
				display_taxonomy_list( 'k2k-vocab-group', __( 'All Vocab Groups', 'k2k' ) );
			?>
		</section>

		<?php

		/*
			Finally a Posts Navigation
		*/
		gaya_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

	endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
