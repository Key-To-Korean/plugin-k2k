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

			$meta     = jkl_vocabulary_get_meta_data();
			$this_tax = $wp_query->get_queried_object();

			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
				if ( is_singular() ) :
					?>
					<div class="entry-header">

						<?php require_once 'sidebar-vocabulary.php'; ?>
						<?php display_vocabulary_navigation(); ?>

					</div>

					<div class="entry-meta">

						<?php
						display_level_stars();
						display_vocabulary_top_meta( $meta );

						gaya_post_thumbnail();

						if ( is_singular() ) :
							the_title( '<h1 class="entry-title">', '</h1>' );
						else :
							the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						endif;

						if ( array_key_exists( 'subtitle', $meta ) ) {
							?>
							<p class="post-subtitle translation"><?php echo esc_html( $meta['subtitle'] ); ?></p>
							<?php display_meta_buttons( $meta, 'k2k-part-of-speech', true ); ?>
							<?php
						}

						gaya_edit_post_link();
						?>
					</div><!-- .entry-meta -->

					<?php
					/* Ad Above Post */
					if ( is_singular() && is_active_sidebar( 'widget-ad-pre-post' ) ) :
						/* Print styles for adsense widgets */
						wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
						dynamic_sidebar( 'widget-ad-pre-post' );
					endif;
					?>

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
					?>

					<?php
					if ( is_singular() ) :
						?>

						<h3><?php esc_html_e( 'Definitions', 'k2k' ); ?></h3>
						<ol class="definitions-list">
							<?php
							if ( array_key_exists( 'definitions', $meta ) ) {
								foreach ( $meta['definitions'] as $definition ) {
									echo '<li>' . esc_html( $definition ) . '</li>';
								}
							} elseif ( array_key_exists( 'subtitle', $meta ) ) {
								echo '<li>' . esc_html( $meta['subtitle'] ) . '</li>';
							}
							?>
						</ol>

						<?php
						if ( array_key_exists( 'sentences', $meta ) ) :
							?>

							<div class="sentences-header">
								<h3><?php esc_html_e( 'Sentences', 'k2k' ); ?></h3>
								<div class="sentence-buttons">
									<button class="expand-all" title="<?php esc_html_e( 'Show all English sentences', 'k2k' ); ?>"><i class="fas fa-caret-down"></i></button>
								</div>
							</div>

							<ol class="sentences">
								<?php
								$italic_pattern     = '/\*\*(.*?)\*\*/';
								$italic_replacement = '<em>$1</em>';
								$bold_pattern       = '/[*_](.*?)[*_]/';
								$bold_replacement   = '<strong>$1</strong>';
								foreach ( $meta['sentences'] as $sentence ) {
									$italicize_ko = preg_replace( $italic_pattern, $italic_replacement, $sentence['k2k_vocab_meta_sentences_1'] );
									$italicize_en = preg_replace( $italic_pattern, $italic_replacement, $sentence['k2k_vocab_meta_sentences_2'] );
									?>

									<li class="sentence">
										<button class="expand" title="<?php esc_html_e( 'Show English sentence', 'k2k' ); ?>"><i class="fas fa-caret-down"></i></button>
										<p class="ko"><?php echo wp_kses_post( preg_replace( $bold_pattern, $bold_replacement, $italicize_ko ) ); ?></p>
										<p class="en"><?php echo wp_kses_post( preg_replace( $bold_pattern, $bold_replacement, $italicize_en ) ); ?></p>
									</li>

									<?php
								}
								?>
							</ol>

							<?php
						endif;
						?>

						<footer class="entry-footer">

							<div class="related-terms-container">
								<?php
								if ( jkl_has_related_vocabulary_meta( $meta ) ) {
									?>
									<h3><?php esc_html_e( 'Related', 'k2k' ); ?></h3>
									<?php
									display_vocabulary_related_meta( $meta );
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
