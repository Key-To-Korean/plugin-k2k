<?php
/**
 * The template for displaying Grammar archive pages.
 *
 * The template for displaying Grammar archive pages
 *
 * @package K2K
 */

get_header(); ?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Display the appropriate header when required. */
		k2k_index_header();

		require_once 'sidebar-grammar.php';

		echo '<ul class="grammar-posts-grid archive-posts-grid">';

		/* Start the "Official" Loop */
		$count = 0;
		while ( have_posts() && $count < 16 ) :
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

			<li class="grammar-post">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php gaya_archive_thumbnails(); ?>

				<header class="entry-header">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
						<?php
							get_level_stars();
							the_title( '<h2 class="entry-title">', '</h2>' );
							echo '<span class="entry-subtitle">' . esc_html( get_grammar_subtitle() ) . '</span>';
						?>
					</a>
				</header><!-- .entry-header -->

				</article><!-- #post-<?php the_ID(); ?> -->
			</li>

			<?php
			$count++;
		endwhile;
		?>

		</ul><!-- .grammar-list -->

		<hr />
		<section class="page-section archive-taxonomies grammar-taxonomies-list">
			<?php
				display_taxonomy_list( 'k2k-level', __( 'All Levels', 'k2k' ) );
				display_taxonomy_list( 'k2k-book', __( 'All Books', 'k2k' ) );
				display_taxonomy_list( 'k2k-part-of-speech', __( 'All Parts of Speech', 'k2k' ) );
				display_taxonomy_list( 'k2k-expression', __( 'All Expressions', 'k2k' ) );
				display_taxonomy_list( 'k2k-usage', __( 'All Usages', 'k2k' ) );
				display_taxonomy_list( 'k2k-phrase-type', __( 'All Phrase Types', 'k2k' ) );
			?>
		</section>

			<?php
			// Previous/next page navigation.
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'k2k' ),
					'next_text'          => __( 'Next page', 'k2k' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'k2k' ) . ' </span>',
				)
			);

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>

	</main><!-- #primary -->

<?php
get_footer();
