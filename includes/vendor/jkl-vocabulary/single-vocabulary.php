<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			wp_print_styles( array( 'gaya-content' ) ); // Note: If this was already done it will be skipped.
			wp_print_styles( array( 'gaya-post-formats' ) ); // Note: If this was already done it will be skipped.

			$meta = get_all_the_post_meta( array( 'k2k-level', 'k2k-part-of-speech' ) );

			?>

<?php	
	$terms = get_the_terms( get_the_ID(), 'k2k-level' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$file = get_term_meta( $term->term_id, $tax_prefix . 'avatar', true );
			echo '<div class="col-sm-12 col-md-3">';
				echo '<a href="/level/' . $term->slug . '">' . $term->name . '</a>';
				echo '<div style="border:1px solid blue;">';
					echo '<img src="';
						echo esc_attr($file);
					echo '" class="dept-img">';
				echo '</div>';
			echo "</div>";// closes .col-sm-12 and .col-md-3 div
		}
	}
?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<div class="post-cats">
						<?php
							the_terms( get_the_ID(), 'k2k-level', 'Level: ', ', ', '' );
							the_terms( get_the_ID(), 'k2k-part-of-speech', 'Part of Speech: ', ', ', '' );
						?>
					</div>

					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;
					?>

					<?php gaya_post_thumbnail(); ?>

					<?php if ( is_singular() && has_excerpt() ) : ?>
					<div class="entry-excerpt">
						<?php the_excerpt(); ?>
					</div>
					<?php endif; ?>
				</header><!-- .entry-header -->

				<?php
				/* Ad Above Post */
				if ( is_singular() && is_active_sidebar( 'widget-ad-pre-post' ) ) :
					/* Print styles for adsense widgets */
					wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
					dynamic_sidebar( 'widget-ad-pre-post' );
				endif;
				?>

				<?php
				if ( is_singular() ) :
					?>
					<div class="entry-meta">
						<?php
							the_terms( get_the_ID(), 'k2k-level', 'Level: ', ', ', '' );
							the_terms( get_the_ID(), 'k2k-part-of-speech', 'Part of Speech: ', ', ', '' );
						?>
					</div><!-- .entry-meta -->
					<?php
				endif;
				?>

				<div class="entry-content">
					<?php
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'gaya' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gaya' ),
							'after'  => '</div>',
						)
					);
					?>

					<?php if ( is_singular() ) : ?>
						<footer class="entry-footer">
							<?php
								gaya_post_tags();
								gaya_edit_post_link();
							?>
						</footer><!-- .entry-footer -->
					<?php endif; ?>
				</div><!-- .entry-content -->

				<?php if ( is_singular() ) : ?>
					<h3 class="section-title">Written by</h3>
					<div class="author-box">
						<?php gaya_author_box(); ?>
					</div>

					<?php
					/* Above After Post */
					if ( is_active_sidebar( 'widget-ad-post-post' ) ) :
						/* Print styles for adsense widgets */
						wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
						dynamic_sidebar( 'widget-ad-post-post' );
					endif;
					?>

					<?php
				endif;

				if ( function_exists( 'gaya_jp_related_posts' ) ) {
					gaya_jp_related_posts();
				}
				?>
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php
			if ( is_singular() ) :
				?>
				<div class="post-navigation-container">
					<?php
					// Previous/next post navigation.
					$next_post = get_next_post();
					$prev_post = get_previous_post();

					gaya_post_nav();
					?>
				</div>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_footer();
