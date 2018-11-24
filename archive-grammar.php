<?php get_header(); ?>

<section id="primary">
  <div id="content" role="main">

    <?php if ( have_posts() ) : ?>

    <header class="page-header">
      <h1 class="page-title">Grammar Index</h1>
    </header>

    <!-- Start the Loop -->
    <?php while ( have_posts() ) : the_post(); ?>

      <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>

    <?php endwhile; ?>

    <!-- Display Post navigation -->
    <?php 
    global $wp_query;
    if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) {
    ?>
      <nav id="<?php echo $nav_id; ?>">
        <div class="nav-previous">
          <?php next_posts_link( '<span class="meta-nav">&larr;</span> Previous grammar' ); ?>
        </div>
        <div class="nav-next">
          <?php previous_posts_link( 'Next grammar <span class="meta-nav">&rarr;</span>' ); ?>
        </div>
      </nav>
    <?php 
    }

    endif; ?>

  </div>
</section>

<?php get_footer(); ?>