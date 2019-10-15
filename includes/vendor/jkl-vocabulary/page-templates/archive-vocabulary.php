<?php
/**
 * The template for displaying Vocabulary archive pages.
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

		require_once 'sidebar-vocabulary.php';

		echo '<ul class="vocabulary-posts-grid archive-posts-grid">';

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
			<li class="vocabulary-item">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php $part_of_speech = get_part_of_speech(); ?>

					<a class="part-of-speech-circle" style="background:
						<?php echo $part_of_speech['color'] ? esc_attr( $part_of_speech['color'] ) : '#543210'; ?>
						" href="/part-of-speech/<?php echo esc_attr( $part_of_speech['slug'] ); ?>">
						<?php echo esc_attr( $part_of_speech['letter'] ); ?>
					</a>

					<header class="entry-header">
						<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
							<?php
								get_level_stars();
								the_title( '<h2 class="entry-title">', '</h2>' );
								echo '<span class="entry-subtitle">' . esc_html( get_subtitle() ) . '</span>';
							?>
						</a>
					</header><!-- .entry-header -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</li>
			<?php

			$count++;
		endwhile;

		echo '</ul>';

		/*
			Finally a Posts Navigation
		*/
		the_posts_navigation();
		// // gaya_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

	endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
