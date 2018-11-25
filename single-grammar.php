<?php 
/**
 * The template for displaying single Grammar posts
 *
 * This is the template that displays all Grammar posts.
 */
get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <!-- Cycle through the posts -->
    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
          <!-- Display Title and Subtitle -->
          <h2 class="entry-title"><?php the_title(); ?></h2>
          <h3 class="entry-title subtitle"><?php the_subtitle(); ?></h3>
        </header><!-- .entry-header -->

        <!-- Display Featured Image -->
        <div class="post-thumbnail">
          <?php the_post_thumbnail(); ?>
        </div>

        <div class="entry-content">
        <?php
          /* translators: %s: Name of current post */
          the_content( sprintf(
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'jkl-grammar' ),
            get_the_title()
          ) );
          wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'jkl-grammar' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'jkl-grammar' ) . ' </span>%',
            'separator'   => '<span class="screen-reader-text">, </span>',
          ) );
        ?>
        </div><!-- .entry-content --> 

        <footer class="entry-footer">
          <div class="entry-meta grammar-meta">
            <strong>Level</strong>
            <div class="grammar-level">
              <?php echo get_the_term_list( $post->ID, 'level', '<p>', ' ', '</p>' ); ?>
            </div>
            <strong>Book</strong>
            <div class="grammar-book">
              <?php echo get_the_term_list( $post->ID, 'book', '<p>', ' ', '</p>' ); ?>
            </div>
            <strong>Expressing</strong>
            <div class="grammar-expression tagcloud">
              <?php echo get_the_term_list( $post->ID, 'expression', '<p>', ' ', '</p>' ); ?>
            </div>
            <strong>Parts of Speech</strong>
            <div class="grammar-part tagcloud">
              <?php echo get_the_term_list( $post->ID, 'part-of-speech', '<p>', ' ', '</p>' ); ?>
            </div>
            <strong>Usage</strong>
            <div class="grammar-usage tagcloud">
              <?php echo get_the_term_list( $post->ID, 'usage', '<p>', ' ', '</p>' ); ?>
            </div>
          <div><!-- .entry-meta -->
          <?php
            edit_post_link(
              sprintf(
                /* translators: %s: Name of current post */
                __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'jkl-grammar' ),
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
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'jkl-grammar' ),
				) );
			} elseif ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'jkl-grammar' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'jkl-grammar' ) . '</span> ' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'jkl-grammar' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'jkl-grammar' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) );
			}

    endwhile; ?>
  </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>