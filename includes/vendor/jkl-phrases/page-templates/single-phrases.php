<?php
/**
 * The template for displaying single Phrases posts
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
			$meta     = jkl_phrases_get_meta_data();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<!-- Phrases Post Type Navigation -->
				<header class="entry-header filter-nav-header">

					<?php require_once 'sidebar-phrases.php'; ?>
					<?php display_phrases_navigation(); ?>

				</header>

				<!-- Phrases Post Content Header -->
				<header class="entry-header content-header">

					<hgroup class="entry-titles">
						<?php
						the_title( '<h1 class="entry-title">', '</h1>' );
						display_phrase_subtitle( $meta );
						?>
					</hgroup>

					<?php gaya_post_thumbnail(); ?>

				</header><!-- .entry-header -->

				<?php
				/* Ad Above Post */
				if ( is_singular() && is_active_sidebar( 'widget-ad-pre-post' ) ) :
					/* Print styles for adsense widgets */
					wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
					dynamic_sidebar( 'widget-ad-pre-post' );
				endif;
				?>

				<!-- Phrases Taxonomy Meta -->
				<div class="entry-meta phrases-meta">
					<?php display_phrases_entry_meta( $meta ); ?>
				</div><!-- .entry-meta -->

				<!-- Phrases Post Content -->
				<div class="entry-content">

				<?php
				if ( array_key_exists( 'wysiwyg', $meta ) ) :
					?>

					<h2 class="post-content-title"><?php esc_html_e( 'Detailed Explanation', 'k2k' ); ?></h2>

					<!-- Detailed Explanation -->
					<div class="detailed-explanation <?php echo array_key_exists( 'usage', $meta ) ? '' : 'no-usage'; ?>">
						<?php echo k2k_get_wysiwyg_output( 'k2k_phrase_meta_wysiwyg' ); // phpcs:ignore ?>
					</div>

					<?php
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
