<?php
/**
 * The template for displaying Vocab List archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package K2K
 */

get_header(); ?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Display the appropriate header when required. */
		k2k_index_header();

		require_once 'sidebar-vocab-list.php';

		echo '<ul class="vocab-list-posts-grid archive-posts-grid">';

		/* Start the "Official" Loop */
		$count = 0;
		while ( have_posts() && $count < 40 ) :
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
			<li class="vocab-list-post">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php gaya_archive_thumbnails(); ?>

				<header class="entry-header">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
						<?php
							display_level_stars();
							the_title( '<h2 class="entry-title">', '<span class="entry-subtitle">' . esc_html( get_vocab_list_subtitle() ) . '</span></h2>' );
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
		<section class="page-section archive-taxonomies vocab-list-taxonomies-list">
			<?php
				display_taxonomy_list( 'k2k-level', __( 'All Levels', 'k2k' ) );
				display_taxonomy_list( 'k2k-book', __( 'All Books', 'k2k' ) );
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
