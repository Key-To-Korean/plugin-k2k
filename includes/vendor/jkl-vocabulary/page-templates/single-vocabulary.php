<?php
/**
 * The template for displaying Single Vocabulary
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package K2K
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			wp_print_styles( array( 'gaya-content' ) ); // Note: If this was already done it will be skipped.
			wp_print_styles( array( 'gaya-post-formats' ) ); // Note: If this was already done it will be skipped.

			$meta = get_all_the_post_meta( array( 'k2k-level', 'k2k-part-of-speech', 'k2k-topic' ) );

			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php

				/*
				<header class="entry-header">

					<div class="post-cats">
						<?php
						custom_meta_button( 'button', 'k2k-level' );
						custom_meta_button( 'button', 'k2k-topic' );
						?>
					</div>

					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;

					if ( array_key_exists( 'k2k_vocab_meta_subtitle', $meta['post'] ) ) {
						echo '<h2 class="post-subtitle translation">' . esc_html( $meta['post']['k2k_vocab_meta_subtitle'][0] ) . ' (';
						custom_meta_button( 'link', 'k2k-part-of-speech' );
						echo ')</h2>';
					}
					?>

				</header><!-- .entry-header -->
				*/
				?>

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
							gaya_post_thumbnail();
							echo 'Level: ';
							custom_meta_button( 'link', 'k2k-level' );
							echo '<br />Part of Speech: ';
							custom_meta_button( 'link', 'k2k-part-of-speech' );
							echo '<br />Topic: ';
							custom_meta_button( 'link', 'k2k-topic' );
							gaya_edit_post_link();
						?>
					</div><!-- .entry-meta -->
					<?php
				endif;
				?>

				<div class="entry-content">

					<div class="post-cats">
						<?php
						get_level_stars();
						custom_meta_button( 'button', 'k2k-level' );
						custom_meta_button( 'button', 'k2k-topic' );
						?>
					</div>

					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;

					if ( array_key_exists( 'k2k_vocab_meta_subtitle', $meta['post'] ) ) {
						echo '<h2 class="post-subtitle translation">' . esc_html( $meta['post']['k2k_vocab_meta_subtitle'][0] ) . ' (';
						custom_meta_button( 'link', 'k2k-part-of-speech' );
						echo ')</h2>';
					}
					?>

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

					<?php
					if ( is_singular() ) :

						if ( array_key_exists( 'k2k_vocab_meta_definitions', $meta['post'] ) ) :
							?>

							<h3>Definitions</h3>
							<ol>
								<?php
								$definitions = get_post_meta( get_the_ID(), 'k2k_vocab_meta_definitions', true );
								foreach ( $definitions as $definition ) {
									echo '<li>' . esc_html( $definition ) . '</li>';
								}
								?>
							</ol>

							<?php
						endif;

						$jkl_meta = jkl_vocabulary_get_meta_data();
						echo '<pre>';
						var_dump( $jkl_meta );
						echo '</pre>';

						if ( array_key_exists( 'k2k_vocab_meta_sentences', $meta['post'] ) ) :
							?>

							<h3>Sentences</h3>
							<div class="sentence-buttons">
								<button class="expand-all" title="Show all English sentences"><i class="fas fa-caret-down"></i></button>
							</div>
							<ol class="sentences">
								<?php
								$sentences   = get_post_meta( get_the_ID(), 'k2k_vocab_meta_sentences', true );
								$pattern     = '/[*_](.*?)[*_]/';
								$replacement = '<strong>$1</strong>';
								foreach ( $sentences as $sentence ) {
									echo '<li>';
									echo '<button class="expand" title="Show English sentence"><i class="fas fa-caret-down"></i></button>';
									echo '<p class="ko">' . wp_kses_post( preg_replace( $pattern, $replacement, $sentence['k2k_vocab_meta_sentences_1'] ) ) . '</p>';
									echo '<p class="en">' . wp_kses_post( preg_replace( $pattern, $replacement, $sentence['k2k_vocab_meta_sentences_2'] ) ) . '</p>';
									echo '</li>';
								}
								?>
							</ol>

							<?php
						endif;
						?>

						<footer class="entry-footer">
							<div class="related-terms-container">
							<hr />
								<?php
								$synonyms = get_post_meta( get_the_ID(), 'k2k_vocab_meta_synonyms', true );
								if ( $synonyms ) {
									custom_footer_meta( 'Synonyms', $synonyms );
								}

								$antonyms = get_post_meta( get_the_ID(), 'k2k_vocab_meta_antonyms', true );
								if ( $antonyms ) {
									custom_footer_meta( 'Antonyms', $antonyms );
								}

								$hanja = get_post_meta( get_the_ID(), 'k2k_vocab_meta_hanja', true );
								if ( $hanja ) {
									custom_footer_meta( 'Hanja', $hanja );
								}
								?>
							</div>

							<?php gaya_edit_post_link(); ?>
						</footer><!-- .entry-footer -->
					<?php endif; ?>
				</div><!-- .entry-content -->

				<?php
				if ( is_singular() ) :

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
