<?php
/**
 * The template for displaying single Grammar posts
 *
 * This is the template that displays all Grammar posts.
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

			$this_tax = $wp_query->get_queried_object();
			$meta     = jkl_grammar_get_meta_data();

			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header filter-nav-header">

					<?php require_once 'sidebar-grammar.php'; ?>
					<?php display_grammar_navigation(); ?>

				</header>

				<header class="entry-header content-header">

					<div class="post-cats">
						<?php
						get_level_stars();
						/**
						// custom_meta_button( 'button', 'k2k-level' );
						// custom_meta_button( 'button', 'k2k-topic' );
						*/
						?>
					</div>

					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;

					if ( array_key_exists( 'subtitle', $meta ) ) {
						echo '<h2 class="post-subtitle translation">' . esc_html( $meta['subtitle'] ) . '</h2>';
					}

					// gaya_post_thumbnail();.
					?>

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
					<div class="entry-meta grammar-meta">
						<?php
							echo 'Level: ';
							custom_meta_button( 'link', 'k2k-level' );
							echo '<br />Book: ';
							echo get_the_term_list( $post->ID, 'k2k-book', '<p>', ' ', '</p>' );
							echo '<br />Expressing: ';
							echo get_the_term_list( $post->ID, 'k2k-expression', '<p>', ' ', '</p>' );
							echo '<br />Parts of Speech: ';
							echo get_the_term_list( $post->ID, 'k2k-part-of-speech', '<p>', ' ', '</p>' );
							echo '<br />Usage: ';
							echo get_the_term_list( $post->ID, 'k2k-usage', '<p>', ' ', '</p>' );
							gaya_edit_post_link();
						?>
					</div><!-- .entry-meta -->
					<?php
				endif;
				?>

				<div class="entry-content">
				<?php
					the_content(
						sprintf( /* translators: %s: Name of current post */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'k2k' ),
							get_the_title()
						)
					);
					wp_link_pages(
						array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'k2k' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'k2k' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						)
					);

				if ( is_singular() ) :

					if ( array_key_exists( 'wysiwyg', $meta ) ) :
						?>

						<h3>Explanation</h3>
						<div>
							<?php echo wp_kses_post( wpautop( $meta['wysiwyg'] ) ); ?></p>
						</div>

						<?php
					endif;

					if ( array_key_exists( 'sentences', $meta ) ) :
						?>

						<div class="sentences-header">
							<h3>Sentences</h3>
							<div class="sentence-buttons">
								<button class="expand-all" title="Show all English sentences"><i class="fas fa-caret-down"></i></button>
							</div>
						</div>

						<ol class="sentences">
							<?php
							$italic_pattern     = '/\*\*(.*?)\*\*/';
							$italic_replacement = '<em>$1</em>';
							$bold_pattern       = '/[*_](.*?)[*_]/';
							$bold_replacement   = '<strong>$1</strong>';
							foreach ( $meta['sentences'] as $key => $array ) {

								echo '<h4 class="sentence-tense-title">' . esc_html( ucwords( $key ) ) . ' Tense Examples</h4>';

								foreach ( $array as $sentence ) {
									// Check for ** doubled - for italics first.
									$italicize = preg_replace( $italic_pattern, $italic_replacement, $sentence['k2k_grammar_meta_sentences_1'] );
									?>

									<li>
										<button class="expand" title="Show English sentence"><i class="fas fa-caret-down"></i></button>
										<p class="ko"><?php echo wp_kses_post( preg_replace( $bold_pattern, $bold_replacement, $italicize ) ); ?></p>
										<p class="en"><?php echo wp_kses_post( preg_replace( $bold_pattern, $bold_replacement, $italicize ) ); ?></p>
									</li>

									<?php
								}
							}
							?>
						</ol>

						<?php
					endif;
				endif;
				?>

				</div><!-- .entry-content --> 

				<footer class="entry-footer">
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'k2k' ),
								get_the_title()
							),
							'<span class="edit-link">',
							'</span>'
						);
					?>
				</footer>
			</article>

			<?php
			echo '<pre>';
			var_dump( $meta );
			echo '</pre>';

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation(
					array(
						'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'k2k' ),
					)
				);
			} elseif ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation(
					array(
						'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'k2k' ) . '</span> ' .
							'<span class="screen-reader-text">' . __( 'Next post:', 'k2k' ) . '</span> ' .
							'<span class="post-title">%title</span>',
						'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'k2k' ) . '</span> ' .
							'<span class="screen-reader-text">' . __( 'Previous post:', 'k2k' ) . '</span> ' .
							'<span class="post-title">%title</span>',
					)
				);
			}

		endwhile;
		?>
	</main>
</div>

<?php get_sidebar(); ?>

<!-- .wrap for TwentySeventeen -->
</div><!-- .wrap -->
<!-- .wrap for TwentySeventeen -->

<?php get_footer(); ?>
