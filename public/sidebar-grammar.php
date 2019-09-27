<?php
/**
 * The sidebar containing the Grammar Filters
 * @link Inspiration: https://laracasts.com/search?refinement=type&name=series
 */
?>

<aside id="secondary" class="primary-sidebar widget-area">
	<aside id="grammar-filter-box" class="widget">
    <h3 class="widget-title">Grammar Filters | <a href="<?php echo esc_url( get_home_url() ) . '/grammar'; ?>">View All</a></h3>

    <!-- Search -->
    <?php get_search_form(); ?>

    <!-- Difficulty -->
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

      $icons = [ '⚡️', '📗', '⚙️', '🗣', '👐', '🏷' ];

      $output = '';
      if ( ! empty($taxonomies) ) :
        $output .= '<div>';
        $i = 0;
        foreach( $taxonomies as $taxonomy ) :
          $output .=  '<h4 style="margin-bottom: 0;">' . $icons[$i] . ' ' . ucwords( str_replace( array( '-', '_' ), ' ', esc_attr( $taxonomy[0]->taxonomy ) ) ) . '</h4>';
          if ( ! empty ($taxonomy ) ) :
            $output .= '<select onchange="if (this.value) window.location.href=this.value" style="max-width: 100%; width: 100%; display: block; height: 36px;">';
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
            $output.='</select>';
          endif;
          $i++;
        endforeach;
        $output .= '</div>';
      endif;
      echo $output;
      ?>

    <!-- Add ReactJS -->
    <!-- <div id="grammar_root"></div> -->
    <!-- End ReactJS -->

    <!-- <h4 class="grammar-filter-heading">😤 Difficulty</h4> -->

    <!-- Book -->
    <!-- <h4 class="grammar-filter-heading">😤 Book</h4> -->

    <!-- Usage -->
    <!-- <h4 class="grammar-filter-heading">😤 Usage</h4> -->

    <!-- Expression -->
    <!-- <h4 class="grammar-filter-heading">😤 Expression</h4> -->

  </aside>
</aside><!-- #secondary -->