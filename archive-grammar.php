<?php 
/**
 * The template for displaying Grammar archive pages
 */
get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

    <header class="page-header">
      <h1 class="page-title">Grammar Index</h1>
      <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
    </header><!-- .page-header -->

    <!-- Add ReactJS -->
    <div id="grammar_root"></div>
    <!-- End ReactJS -->

    <ul class="grammar-list">

    <!-- Start the Loop -->
    <?php while ( have_posts() ) : the_post(); ?>

      <li class="grammar-post">
        <?php the_title( sprintf( '<span class=""><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></span>' ); ?>
        <?php if ( the_subtitle() ) : ?>
          <span class="entry-subtitle">
          <?php the_subtitle(); ?>
          </span>
        <?php endif; ?>
      </li>

    <?php endwhile; ?>

    </ul><!-- .grammar-list -->

    <?php
    // Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'jkl-grammar' ),
				'next_text'          => __( 'Next page', 'jkl-grammar' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'jkl-grammar' ) . ' </span>',
			) );
		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
    ?>

  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>