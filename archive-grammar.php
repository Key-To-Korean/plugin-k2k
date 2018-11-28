<?php 
/**
 * The template for displaying Grammar archive pages
 */
get_header(); ?>

<!-- .wrap for TwentySeventeen -->
<div class="wrap">
<!-- .wrap for TwentySeventeen -->

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : $this_tax = $wp_query->get_queried_object(); ?>

    <header class="page-header">
      <h1 class="page-title">
        <a href="<?php echo esc_url( get_home_url() ) . '/grammar'; ?>"><?php _e( 'Grammar Index', 'jkl-grammar' ); ?></a>
      </h1>
      <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>

      <!-- Sortable / Filterable Terms Lists -->
      <?php
      $taxonomies = [];
      $taxonomies[] = get_terms( array(
        'taxonomy' => 'level',
        'hide_empty' => false
      ) );
      $taxonomies[] = get_terms( array(
        'taxonomy' => 'book',
        'hide_empty' => false
      ) );
      $taxonomies[] = get_terms( array(
        'taxonomy' => 'part-of-speech',
        'hide_empty' => false
      ) );
      $taxonomies[] = get_terms( array(
        'taxonomy' => 'expression',
        'hide_empty' => false
      ) );
      $taxonomies[] = get_terms( array(
        'taxonomy' => 'usage',
        'hide_empty' => false
      ) );
      $taxonomies[] = get_terms( array(
        'taxonomy' => 'post_tag',
        'hide_empty' => false
      ) );

      $output = '';
      if ( ! empty($taxonomies) ) :
        $output .= '<div style="margin-top: 1rem;">';
        foreach( $taxonomies as $taxonomy ) :
          $output .= '<p style="margin-bottom: 0;"><strong>' . ucwords( str_replace( array( '-', '_' ), ' ', esc_attr( $taxonomy[0]->taxonomy ) ) ) . '</strong>: ';
          if ( ! empty ($taxonomy ) ) :
            $output .= '<select onchange="if (this.value) window.location.href=this.value">';
            $output.= '<optgroup label="'. ucwords( str_replace( array( '-', '_' ), ' ', esc_attr( $taxonomy[0]->taxonomy ) ) ) .'">';
            foreach ( $taxonomy as $key => $category ) :
              if ( $key == 0 ) {
                $output .= '<option value="' . esc_url( get_home_url() ) . '/grammar/">Select</option>'; 
              }
              $tax = $category->taxonomy;
              if ( $tax == 'post_tag' ) {
                $tax = 'tag';
              }
              $output.= '<option value="' . esc_url( get_home_url() ) . '/' . esc_attr( $tax ) . '/' . esc_attr( $category->slug ) .'/">
                '. esc_html( $category->name ) . ' (' . esc_attr( $category->count) . ')' .'</option>';
            endforeach;
            $output .= '</optgroup>';
            $output.='</select></p>';
          endif;
        endforeach;
        $output .= '</div>';
      endif;
      echo $output;
      ?>
    
    </header><!-- .page-header -->

    <!-- Add ReactJS -->
    <!-- <div id="grammar_root"></div> -->
    <!-- End ReactJS -->

    <?php if ( ! empty( $this_tax->taxonomy ) ) : ?>
      <h2 class="page-title"><?php echo ucwords( esc_attr( $this_tax->taxonomy ) ) . ': ' . ucwords( esc_attr( $this_tax->slug ) ); ?></h2>
    <?php else : ?>
      <h2 class="page-title"><?php _e( 'All Grammar', 'jkl-grammar' ); ?></h2>
    <?php endif; ?>

    <div class="entry-content">
    <ul class="grammar-list" style="margin: 1rem 0 3.5rem;">

    <!-- Start the Loop -->
    <?php while ( have_posts() ) : the_post(); ?>

      <li class="grammar-post">
        <?php the_title( sprintf( '<span class=""><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></span>' ); ?>
        <?php if ( function_exists( 'the_subtitle' ) ) : ?>
          <span class="entry-subtitle">
          <?php the_subtitle(); ?>
          </span>
        <?php endif; ?>
      </li>

    <?php endwhile; ?>

    </ul><!-- .grammar-list -->
    </div>

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

<!-- .wrap for TwentySeventeen -->
</div><!-- .wrap -->
<!-- .wrap for TwentySeventeen -->

<?php get_footer(); ?>