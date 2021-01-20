<?php
/**
 * The template for displaying single Reading posts
 *
 * This is the template that displays all Reading posts.
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
			$meta     = jkl_reading_get_meta_data();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<!-- Reading Post Type Navigation -->
				<header class="entry-header filter-nav-header">

					<?php require_once 'sidebar-reading.php'; ?>
					<?php display_reading_navigation(); ?>

				</header>

				<!-- Reading Post Content Header -->
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

					<?php
					if ( array_key_exists( 'video', $meta ) ) {
						display_reading_video( $meta['video'] );
					} else {
						display_reading_thumbnail();
					}
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

				<!-- Reading Taxonomy Meta -->
				<div class="entry-meta reading-meta">
					<?php
					if ( array_key_exists( 'video', $meta ) ) {
						display_reading_thumbnail();
					}
					display_reading_entry_meta( $meta );
					?>
				</div><!-- .entry-meta -->

				<!-- Reading Post Content -->
				<div class="entry-content">

				<?php if ( array_key_exists( 'wysiwyg_ko', $meta ) ) { ?>

					<div class="reading-passages">

						<!-- Korean Text -->
						<div class="korean-text-container">
							<h2 class="post-content-title"><?php esc_html_e( 'Korean Text', 'k2k' ); ?>
								<?php display_reading_needs_link( $meta ); ?>
							</h2>
							<div class="korean-text">
								<?php // echo wp_kses_post( wpautop( jkl_filter_content_with_span( $meta['wysiwyg_ko'] ) ) );. ?>
								<?php echo wp_kses_post( wpautop( $meta['wysiwyg_ko'] ) ); ?>
							</div>

							<?php if ( array_key_exists( 'wysiwyg_en', $meta ) ) { ?>
								<small id="show-english-reading" class="show-hide"><?php esc_html_e( 'Show English Translation', 'k2k' ); ?></small>
							<?php } ?>

							<hr>

						</div>

					<?php } ?>

					<?php if ( array_key_exists( 'wysiwyg_en', $meta ) ) { ?>

						<!-- English Text -->
						<div class="english-text-container">
							<h2 class="post-content-title"><?php esc_html_e( 'English Text', 'k2k' ); ?>
								<?php display_reading_needs_link( $meta ); ?>
							</h2>
							<div class="english-text">
								<?php echo wp_kses_post( wpautop( $meta['wysiwyg_en'] ) ); ?>
							</div>

							<hr>

						</div>

					</div><!-- .reading-passages -->

					<?php } ?>

				<?php
				if ( array_key_exists( 'questions', $meta ) ) :
					display_reading_questions( $meta );
				endif;

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

	<div id="dict-lookup-container">
		<div id="dict-lookup">
			<i id="dict-close" class="fas fa-times"></i>
			<h2>Dictionary Lookup</h2>
			<?php jkl_papago_dictionary_lookup(); ?>
		</div>
	</div>

<?php
get_footer();
