<?php get_header(); ?>

<div id="primary">
  <div id="content" role="main">
    <!-- Cycle through the posts -->
    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
          <!-- Display Featured Image -->
          <div style="float: right; margin: 10px;">
            <?php the_post_thumbnail( 'large' ); ?>
          </div>

          <!-- Display Title and Author name -->
          <strong>Title: </strong><?php the_title(); ?><br />
          <strong>Author: </strong>It's a me!
        </header>

        <div class="entry-content"><?php the_content(); ?></div>
      </article>

      <!-- Display the Comment form -->
      <?php comments_template( '', true ); ?>

    <?php endwhile; ?>
  </div>
</div>

<?php get_footer(); ?>