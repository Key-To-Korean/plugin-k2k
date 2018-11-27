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

    <?php if ( have_posts() ) : ?>

    <header class="page-header">
      <h1 class="page-title">Grammar Index</h1>
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

      $output = '';
      if ( ! empty($taxonomies) ) :
        foreach( $taxonomies as $taxonomy ) :
          $output .= '<p><strong><a href="' . $taxonomy[0]->taxonomy . '">' . ucwords( $taxonomy[0]->taxonomy ) . '</a></strong>: ';
          if ( ! empty ($taxonomy ) ) :
            $output .= '<select onchange="if (this.value) window.location.href=this.value">';
            $output.= '<optgroup label="'. esc_attr( ucwords( $taxonomy[0]->taxonomy) ) .'">';
            foreach ( $taxonomy as $key => $category ) :
              if ( $key == 0 ) {
                $output .= '<option value="/grammar">Every</option>'; 
              }
              $output.= '<option value="'. '/grammar/' . esc_attr( $category->taxonomy ) . '/' . esc_attr( $category->slug ) .'">
                '. esc_html( $category->name ) . ' (' . esc_attr( $category->count) . ')' .'</option>';
            endforeach;
            $output .= '</optgroup>';
            $output.='</select></p>';
          endif;
        endforeach;
      endif;
      echo $output;
      
      // if ( ! empty($taxonomies) ) :
      //   $output = '<select>';
      //   foreach ( $taxonomies as $category ) {
      //     if( $category->parent == 0 ) {
      //       $output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
      //       foreach( $taxonomies as $subcategory ) {
      //         if($subcategory->parent == $category->term_id) {
      //         $output.= '<option value="'. esc_attr( $subcategory->term_id ) .'">
      //           '. esc_html( $subcategory->name ) .'</option>';
      //         }
      //       }
      //       $output.='</optgroup>';
      //     }
      //   }
      //   $output.='</select>';
      //   echo $output;
      // endif;
      ?>
    
    </header><!-- .page-header -->

    <!-- Add ReactJS -->
    <div id="grammar_root"></div>
    <!-- End ReactJS -->

    <ul class="grammar-list">

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

<?php // get_sidebar(); ?>

<!-- .wrap for TwentySeventeen -->
</div><!-- .wrap -->
<!-- .wrap for TwentySeventeen -->

<?php get_footer(); ?>