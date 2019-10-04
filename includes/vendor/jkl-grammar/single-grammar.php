<?php
/**
 * The template for displaying single Grammar posts
 *
 * This is the template that displays all Grammar posts.
 *
 * @package K2K
 */

get_header(); ?>

<!-- .wrap for TwentySeventeen -->
<div class="wrap">
<!-- .wrap for TwentySeventeen -->

<div id="primary" class="content-area large-9 medium-12 columns">
	<main id="main" class="site-main" role="main">
		<!-- Cycle through the posts -->
		<?php
		while ( have_posts() ) :
			the_post();

			$this_tax = $wp_query->get_queried_object();
			get_all_the_post_meta( array( 'k2k-book', 'k2k-level', 'k2k-part-of-speech', 'k2k-expression', 'k2k-usage' ) );
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<!-- Display Title and Subtitle -->
					<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php if ( function_exists( 'the_subtitle' ) ) : ?>
						<h3 class="entry-title subtitle"><?php the_subtitle(); ?></h3>
					<?php endif; ?>
				</header><!-- .entry-header -->

				<!-- Display Featured Image -->
				<div class="post-thumbnail">
					<?php the_post_thumbnail(); ?>
				</div>

				<div class="entry-content">

					<div id="nav-above" class="navigation" style="display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 1rem;">
						<div class="nav-previous">
								<?php previous_post_link( '<span class="meta-nav"> %link </span>', esc_attr_x( '&#9668; Previous', 'Previous post link', 'category' ), true, '', esc_attr( $this_tax->taxonomy ) ); ?>
						</div>
						<div class="nav-index">
							<span class="meta-nav"><a href="<?php echo esc_url( get_home_url() ) . '/grammar'; ?>"><?php esc_attr_e( 'Grammar Index', 'k2k' ); ?></a></span>
						</div>
						<div class="nav-previous">
								<?php next_post_link( '<span class="meta-nav"> %link </span>', esc_attr_x( 'Next &#9658;', 'Next post link', 'category' ), true, '', esc_attr( $this_tax->taxonomy ) ); ?>
						</div>
					</div><!-- #nav-above -->

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
				?>
				</div><!-- .entry-content --> 

				<footer class="entry-footer">
					<div class="entry-meta grammar-meta">
						<strong><?php esc_html_e( 'Level', 'k2k' ); ?></strong>
						<div class="grammar-level">
							<?php echo get_the_term_list( $post->ID, 'k2k-level', '<p>', ' ', '</p>' ); ?>
						</div>
						<strong><?php esc_html_e( 'Book', 'k2k' ); ?></strong>
						<div class="grammar-book">
							<?php echo get_the_term_list( $post->ID, 'k2k-book', '<p>', ' ', '</p>' ); ?>
						</div>
						<strong><?php esc_html_e( 'Expressing', 'k2k' ); ?></strong>
						<div class="grammar-expression tagcloud">
							<?php echo get_the_term_list( $post->ID, 'k2k-expression', '<p>', ' ', '</p>' ); ?>
						</div>
						<strong><?php esc_html_e( 'Parts of Speech', 'k2k' ); ?></strong>
						<div class="grammar-part tagcloud">
							<?php echo get_the_term_list( $post->ID, 'k2k-part-of-speech', '<p>', ' ', '</p>' ); ?>
						</div>
						<strong><?php esc_html_e( 'Usage', 'k2k' ); ?></strong>
						<div class="grammar-usage tagcloud">
							<?php echo get_the_term_list( $post->ID, 'k2k-usage', '<p>', ' ', '</p>' ); ?>
						</div>
						<strong><?php esc_html_e( 'Tags', 'k2k' ); ?></strong>
						<div class="grammar-tags tagcloud">
							<?php // echo get_the_tag_list( '<p>', ' ', '</p>' );. ?>
						</div>
					<div><!-- .entry-meta -->
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

			</article>

			<?php
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
