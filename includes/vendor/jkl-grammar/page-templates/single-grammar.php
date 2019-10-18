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

					<hgroup class="entry-titles">
						<?php
						if ( is_singular() ) :
							the_title( '<h1 class="entry-title">', '</h1>' );
						else :
							the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						endif;

						if ( array_key_exists( 'subtitle', $meta ) ) {
							echo '<h2 class="entry-subtitle translation">' . esc_html( $meta['subtitle'] ) . '</h2>';
						}
						?>
					</hgroup>

					<?php display_grammar_thumbnail(); ?>

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

						<!-- Explanation -->
						<h2 class="post-content-title"><?php esc_html_e( 'Detailed Explanation', 'k2k' ); ?>
							<?php
							if ( array_key_exists( 'related_grammar', $meta ) && array_key_exists( 'k2k_grammar_meta_related_needs_link', $meta['related_grammar'][0] ) ) {
								echo ' <i class="fas fa-unlink" title="' . esc_attr( 'Related grammar point needs link', 'k2k' ) . '"></i>';
							}
							?>
						</h2>

						<?php
						if ( array_key_exists( 'related_grammar', $meta ) && array_key_exists( 'k2k_grammar_meta_related_grammar_points', $meta['related_grammar'][0] ) ) {
							?>
							<div class="entry-meta">
								<ul class="related-grammar">
									<li class="related-grammar-title"><?php esc_html_e( 'Related Grammar:', 'k2k' ); ?></li>
									<?php
									foreach ( $meta['related_grammar'][0]['k2k_grammar_meta_related_grammar_points'] as $related ) {
										$related_post = get_post( $related );
										echo '<li class="related-term linked">';
										echo '<a class="tag-button" rel="tag" href="' . esc_url( get_the_permalink( $related_post->ID ) ) . '">' . esc_html( $related_post->post_title ) . '</a>';
										echo '</li>';
									}
									?>
								</ul>
							</div>
							<?php
						}
						?>

						<div class="detailed-explanation <?php echo array_key_exists( 'usage', $meta ) ? '' : 'no-usage'; ?>">
							<?php echo wp_kses_post( wpautop( $meta['wysiwyg'] ) ); ?></p>
						</div>

						<!-- Usage rules -->
						<?php display_grammar_usage_rules( $meta ); ?>

						<!-- Conjugations -->
						<?php build_conjugation_table( $meta ); ?>

						<?php
					endif;

					if ( array_key_exists( 'sentences', $meta ) ) :
						?>

						<!-- Sentences -->
						<div class="sentences-header">
							<h3><?php esc_html_e( 'Sentence Examples', 'k2k' ); ?></h3>
							<div class="sentence-buttons">
								<button class="expand-all" title="Show all English sentences"><i class="fas fa-caret-down"></i></button>
							</div>
						</div>

						<ol class="sentences">
							<?php
							$italic_pattern     = '/\*\*(.*?)\*\*/';
							$italic_replacement = '<em>$1</em>';

							$bold_pattern     = '/[*_](.*?)[*_]/';
							$bold_replacement = '<strong>$1</strong>';

							$part_of_speech_pattern     = '/^([VANvan]:)/';
							$part_of_speech_replacement = '<span class="part-of-speech">$1</span>';

							foreach ( $meta['sentences'] as $key => $array ) {

								echo '<h4 class="sentence-tense-title">' . esc_html( ucwords( $key ) ) . ' Tense</h4>';

								foreach ( $array as $sentence ) {
									// Check for ** doubled - for italics first.
									$italicize_ko = preg_replace( $italic_pattern, $italic_replacement, $sentence['k2k_grammar_meta_sentences_1'] );
									$italicize_en = preg_replace( $italic_pattern, $italic_replacement, $sentence['k2k_grammar_meta_sentences_2'] );

									$bold_ko = preg_replace( $bold_pattern, $bold_replacement, $italicize_ko );
									$bold_en = preg_replace( $bold_pattern, $bold_replacement, $italicize_en );

									$ps_ko = preg_replace( $part_of_speech_pattern, $part_of_speech_replacement, $bold_ko );
									$ps_en = preg_replace( $part_of_speech_pattern, $part_of_speech_replacement, $bold_en );
									?>

									<li class="sentence">
										<button class="expand" title="<?php esc_html_e( 'Show English sentence', 'k2k' ); ?>"><i class="fas fa-caret-down"></i></button>
										<p class="ko"><?php echo wp_kses_post( str_replace( ':', '', $ps_ko ) ); ?></p>
										<p class="en"><?php echo wp_kses_post( str_replace( ':', '', $ps_en ) ); ?></p>
									</li>

									<?php
								}
							}
							?>
						</ol>

						<?php
					endif;
				endif;

				if ( array_key_exists( 'exercises', $meta ) ) {

					echo '<footer class="entry-footer exercises-box">';
					echo '<h3>Practice Exercises</h3>';
					echo '<ol class="practice-exercises">';

					$pattern     = '/\s\.{3}\s/';
					$replacement = '<span class="fill-in-the-blank">$1</span>';
					$word_pattern = '/\((.*?)\)/';
					$word_replacement = '<em class="keyword">($1)</em>';

					foreach ( $meta['exercises'] as $exercise ) {
						$words  = preg_replace( $word_pattern, $word_replacement, $exercise );
						$blanks = preg_replace( $pattern, $replacement, $words );

						echo '<li class="exercise">' . wp_kses_post( $blanks ) . '</li>';

					}

					echo '</ol>';

					gaya_edit_post_link();

					echo '</footer>';

				}
				?>

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

				echo '<pre></pre><pre>';
				var_dump( $meta );
				echo '</pre>';
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
