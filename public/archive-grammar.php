<?php
/**
 * K2K - Archive Template
 *
 * The template for displaying Grammar archive pages
 *
 * @package K2K
 */

get_header(); ?>

<!-- .wrap for TwentySeventeen -->
<!-- <div class="wrap"> -->
<!-- .wrap for TwentySeventeen -->

<div id="primary" class="content-area large-9 medium-12 columns">
	<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :
			$this_tax = $wp_query->get_queried_object();
			?>

		<header class="page-header">
			<h1 class="page-title">
				<?php esc_html_e( 'Grammar Index', 'k2k' ); ?>
			</h1>
			<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>    
		</header><!-- .page-header -->

			<?php
			if ( ! empty( $this_tax->taxonomy ) ) :
				?>

			<h2 class="page-title"><?php echo esc_attr( ucwords( $this_tax->taxonomy ) ) . ': ' . esc_attr( ucwords( $this_tax->slug ) ); ?></h2>

		<?php else : ?>

			<h2 class="page-title"><?php esc_html_e( 'All Grammar', 'k2k' ); ?></h2>

		<?php endif; ?>

		<div class="entry-content">
		<ul class="grammar-list" style="margin: 1rem 0 3.5rem;">

		<!-- Start the Loop -->
			<?php
			while ( have_posts() ) :
				the_post();
				?>

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
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'k2k' ),
					'next_text'          => __( 'Next page', 'k2k' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'k2k' ) . ' </span>',
				)
			);

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php // get_sidebar( 'sidebar-grammar' ); ?>
<?php // load_template( dirname( __FILE__ ) . '/sidebar-grammar.php' ); ?> 

<!-- .wrap for TwentySeventeen -->
<!--</div><!-- .wrap -->
<!-- .wrap for TwentySeventeen -->

<?php get_footer(); ?>
