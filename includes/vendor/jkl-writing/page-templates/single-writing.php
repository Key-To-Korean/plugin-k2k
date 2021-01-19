<?php
/**
 * The template for displaying single Writing posts
 *
 * This is the template that displays all Writing posts.
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
			$meta     = jkl_writing_get_meta_data();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<!-- Writing Post Type Navigation -->
				<header class="entry-header filter-nav-header">

					<?php require_once 'sidebar-writing.php'; ?>
					<?php display_writing_navigation(); var_dump( $meta ); ?>

				</header>

				<!-- Writing Post Content Header -->
				<header class="entry-header content-header">

					<div class="post-cats">
						<?php display_level_stars(); ?>
					</div>

					<hgroup class="entry-titles">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</hgroup>

					<?php
					if ( array_key_exists( 'featured_image', $meta ) ) {
						display_writing_thumbnail();
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

				<!-- Writing Taxonomy Meta -->
				<div class="entry-meta writing-meta">
					<?php
					if ( array_key_exists( 'featured_image', $meta ) ) {
						display_writing_thumbnail();
					}
					display_writing_entry_meta( $meta );
					?>
				</div><!-- .entry-meta -->

				<!-- Writing Post Content -->
				<div class="entry-content">

				<?php
				$count = 0;
				if ( array_key_exists( 'short_group', $meta ) ) {
					$count++;
				}
				if ( array_key_exists( 'medium_group', $meta ) ) {
					$count++;
				}
				if ( array_key_exists( 'long_group', $meta ) ) {
					$count++;
				}

				// If we have more than one group, then we should create tabs.
				if ( $count > 1 ) {
					?>
					<div class="writing-tabs">
					<?php
				}

				if ( array_key_exists( 'short_group', $meta ) ) {
					display_writing_tab( $meta, 'short' );
				}
				if ( array_key_exists( 'medium_group', $meta ) ) {
					display_writing_tab( $meta, 'medium' );
				}
				if ( array_key_exists( 'long_group', $meta ) ) {
					display_writing_tab( $meta, 'long' );
				}

				if ( $count > 1 ) {
					?>
					</div><!-- .writing-tabs -->
					<?php
				}

				/**
				 * If there's any "Post Content" like from Gutenberg - which there shouldn't be.
				 */
				the_content(
					sprintf( /* translators: %s: Name of current post */
						__( 'Continue writing<span class="screen-reader-text"> "%s"</span>', 'k2k' ),
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
			<i id="dict-close" class="fas fa-close">x</i>
			<h2>Dictionary Lookup</h2>
		</div>
	</div>

<?php
get_footer();
