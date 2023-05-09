<?php
/**
 * The template for displaying Single Vocab List
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

		$this_tax = $wp_query->get_queried_object();
		$meta     = jkl_vocab_list_get_meta_data();
		?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<!-- Vocab List Post Type Navigation -->
				<header class="entry-header filter-nav-header">

					<?php require_once 'sidebar-vocab-list.php'; ?>
					<?php display_vocab_list_navigation(); ?>

				</header>

				<!-- Vocab List Post Content Header -->
				<header class="entry-header content-header">

					<div class="post-cats">
						<?php display_level_stars(); ?>
					</div>

					<hgroup class="entry-titles">
						<?php
						the_title( '<h1 class="entry-title">', '</h1>' );

						if ( array_key_exists( 'subtitle', $meta ) ) {
							echo '<h2 class="entry-subtitle translation">' . esc_html( $meta['subtitle'] ) . '</h2>';
						}
						?>
					</hgroup>

				</header><!-- .entry-header -->

				<?php if ( is_singular() && has_excerpt() ) : ?>
					<h3 class="section-title" title="<?php esc_attr_e( 'Reference', 'k2k' ); ?>">
						<?php echo esc_attr_x( 'Reference', 'Reference or Source Material', 'k2k' ); ?>
					</h3>
					<div class="entry-excerpt">
						<?php if ( has_excerpt() ) : ?>
							<?php the_excerpt(); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php
				/* Ad Above Post */
				if ( is_singular() && is_active_sidebar( 'widget-ad-pre-post' ) ) :
					/* Print styles for adsense widgets */
					wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
					dynamic_sidebar( 'widget-ad-pre-post' );
				endif;
				?>

				<!-- Vocab List Taxonomy Meta -->
				<div class="entry-meta vocab-list-meta">
					<?php display_vocab_list_thumbnail(); ?>
					<?php display_vocab_list_entry_meta( $meta ); ?>

					<?php foreach( $meta as $key => $val ) : ?>
						<?php echo($key); ?>
					<?php endforeach; ?>
				</div><!-- .entry-meta -->

				<!-- Vocab List Post Content -->
				<div class="entry-content">

				<?php
				if ( array_key_exists( 'wysiwyg', $meta ) ) :
					?>

					<h2 class="post-content-title"><?php esc_html_e( 'Detailed Explanation', 'k2k' ); ?>
						<?php // display_vocab_list_needs_link( $meta ); ?>
					</h2>

					<?php // display_vocab_list_related_points( $meta ); ?>

					<!-- Detailed Explanation -->
					<div class="detailed-explanation <?php echo array_key_exists( 'usage', $meta ) ? '' : 'no-usage'; ?>">
						<?php echo wp_kses_post( wpautop( $meta['wysiwyg'] ) ); ?>
					</div>

					<?php
				endif;
				?>

				<!-- Usage rules -->
				<?php // display_grammar_usage_rules( $meta ); ?>

				<!-- Conjugations -->
				<?php // build_conjugation_table( $meta ); ?>

				<?php
				// if ( array_key_exists( 'sentences', $meta ) || array_key_exists( 'special_dialogue', $meta ) ) :
				// 	display_grammar_sentences( $meta );
				// endif;

				// if ( array_key_exists( 'exercises', $meta ) ) :
				// 	display_grammar_exercises( $meta );
				// endif;

				/**
				 * If there's any "Post Content" like from Gutenberg - which there shouldn't be.
				 */
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
				?>

				<footer class="entry-footer footer-edit-link">
					
					<?php if ( array_key_exists( 'public-files', $meta ) ) : ?>
						<?php display_vocab_list_public_files(); ?>
					<?php endif; ?>
					<?php if ( array_key_exists( 'private-files', $meta ) ) : ?>
						<?php display_vocab_list_private_files(); ?>
					<?php endif; ?>
					
					<?php
					if ( array_key_exists( 'related_vocab_list', $meta ) ) {
						display_vocab_list_related( $meta );
					}
					?>

					<?php gaya_edit_post_link(); ?>
				</footer>

				</div><!-- .entry-content -->

				<?php
				if ( is_singular() ) :

					/* Above After Post */
					if ( is_active_sidebar( 'widget-ad-post-post' ) ) :
						/* Print styles for adsense widgets */
						wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
						dynamic_sidebar( 'widget-ad-post-post' );
					endif;

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
