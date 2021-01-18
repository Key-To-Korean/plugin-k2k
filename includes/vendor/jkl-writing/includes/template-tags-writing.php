<?php
/**
 * JKL Writing Template Tags.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Search Form for Writing Post Type.
 */
function display_writing_search_form() {
	?>
	<form action="/" method="get" class="writing-search k2k-search">
		<label for="search" class="screen-reader-text"><?php esc_html_e( 'Search Writing', 'k2k' ); ?></label>
		<input type="text" name="s" id="search" placeholder="<?php esc_html_e( 'Search Writing', 'k2k' ); ?>" value="<?php the_search_query(); ?>" />
		<!-- <input type="submit" value="<?php esc_html_e( 'Search', 'k2k' ); ?>" /> -->
		<input type="hidden" value="k2k-writing" name="post_type" id="post_type" />
	</form>
	<?php
}

/**
 * Custom navigation for Writing Post Type.
 *
 * Default Taxonomy is 'Level' - but can pass in a different taxonomy if desired.
 * Possible taxonomies for Writing are 'Level', 'Book', 'Part of Speech', 'Expression', 'Usage', 'Phrase Type'.
 *
 * @param string $taxonomy The taxonomy to display post navigation for.
 */
function display_writing_navigation( $taxonomy = 'k2k-level' ) {
	?>
	<nav id="nav-above" class="navigation post-navigation writing-navigation" role="navigation">
		<p class="screen-reader-text"><?php esc_html_e( 'Writing Navigation', 'k2k' ); ?></p>
		<div class="nav-index">
			<span class="meta-nav"><a href="<?php echo esc_url( get_home_url() ) . '/writing/'; ?>"><?php esc_html_e( 'Writing Index', 'k2k' ); ?></a></span>
		</div>
		<div class="nav-links">
			<div class="nav-previous">
				<?php previous_post_link( '%link', '&#9668; %title', true, '', $taxonomy ); ?>
			</div>
			<div class="nav-next">
				<?php next_post_link( '%link', '%title &#9658;', true, '', $taxonomy ); ?>
			</div>
		</div>
	</nav><!-- #nav-above -->
	<?php
}

/**
 * Function to display a custom cropped thumbnail for Writing Posts.
 */
function display_writing_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail writing-thumbnail" style="background: url(<?php the_post_thumbnail_url(); ?>)">
		</div><!-- .post-thumbnail -->

		<?php
	endif;
}

/**
 * Function to embed and display the post video, if it exists.
 *
 * @param string $url The URL of the video link.
 */
function display_writing_video( $url ) {

	if ( '' === $url ) {
		return;
	}

	$embed_code = wp_oembed_get(
		$url,
		array(
			'width'  => 1000,
			'height' => 600,
		)
	);
	?>

	<div class="post-thumbnail post-video">
		<?php echo $embed_code; // phpcs:ignore ?>
	</div>

	<?php
}

/**
 * Function to display the entry meta for the Writing Post.
 *
 * @param array $meta The post meta.
 */
function display_writing_entry_meta( $meta ) {

	// Level.
	if ( array_key_exists( 'writing-level', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list writing-level-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Level: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-writing-level' );
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-stars">';
		display_level_stars( 'writing' );
		echo '</li>';
		echo '</ul>';
	}

	// Length.
	if ( array_key_exists( 'writing-length', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list writing-length-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Length: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-writing-length' );
		echo '</ul>';
	}

	// Topic.
	if ( array_key_exists( 'writing-topic', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list writing-topic-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Topic: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-writing-topic' );
		echo '</ul>';
	}

	// Type.
	if ( array_key_exists( 'writing-type', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list writing-type-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Type: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-writing-type' );
		echo '</ul>';
	}

	// Source.
	if ( array_key_exists( 'writing-source', $meta ) ) {
		echo '<ul class="k2k-taxonomy-list writing-source-taxonomy">';
		echo '<li class="k2k-taxonomy-item k2k-taxonomy-item-title">' . esc_html__( 'Source: ', 'k2k' ) . '</li>';
		display_meta_buttons( $meta, 'k2k-writing-source' );
		echo '</ul>';
	}

	// Post Edit Link.
	gaya_edit_post_link();

}

/**
 * Display a broken link icon if there is a related writing point that needs linked.
 *
 * @param array $meta The post meta.
 */
function display_writing_needs_link( $meta ) {
	if ( array_key_exists( 'related_writing', $meta ) && array_key_exists( 'k2k_writing_meta_related_needs_link', $meta['related_writing'][0] ) ) {
		echo ' <i class="fas fa-unlink" title="' . esc_attr( 'Related writing point needs link', 'k2k' ) . '"></i>';
	}
}

/**
 * Display a list of related writing points if there are any.
 *
 * @param array $meta The post meta.
 */
function display_writing_related_points( $meta ) {

	if ( array_key_exists( 'related_writing', $meta ) && array_key_exists( 'k2k_writing_meta_related_writing_points', $meta['related_writing'][0] ) ) {
		?>
		<div class="entry-meta">
			<ul class="related-writing">
				<li class="related-writing-title"><?php esc_html_e( 'Related Writing:', 'k2k' ); ?></li>
				<?php
				foreach ( $meta['related_writing'][0]['k2k_writing_meta_related_writing_points'] as $related ) {
					$related_post = get_post( $related );
					echo '<li class="related-term linked">';
					echo '<a class="tag-button" rel="tag" href="' . esc_url( get_the_permalink( $related_post->ID ) ) . '">' . esc_html( $related_post->post_title ) . '</a>';
					echo '</li>';
				}
				?>
			</ul>
		</div>
		<?php
	}

}

/**
 * Function to output the writing questions related to the post.
 *
 * @param array $meta The post meta data.
 */
function display_writing_questions( $meta ) {

	// Double-check that we actually have questions in this array.
	if ( ! array_key_exists( 'k2k_writing_meta_question_text', $meta['questions'][0] ) ) {
		return;
	}
	?>

	<!-- Writing Questions -->
	<div class="questions-header">
		<h3><?php esc_html_e( 'Writing Questions', 'k2k' ); ?></h3>
		<div class="sentence-buttons">
			<!-- <button class="expand-all" title="<?php // esc_html_e( 'Show all correct answers', 'k2k' );. ?>">
				<i class="fas fa-caret-down"></i>
			</button> -->
		</div>
	</div>

	<ol class="writing-questions">
		<?php

		/*
		 * _questions (array)
		 * _question_text (1)
		 * _answers (array)
		 * _correct_answer (1)
		 */
		foreach ( $meta['questions'] as $key => $question ) {
			?>

			<li class="writing-question-item"><?php echo esc_attr( $question['k2k_writing_meta_question_text'] ); ?>

			<?php
			if ( array_key_exists( 'k2k_writing_meta_answers', $question ) ) {
				$correct = array_key_exists( 'k2k_writing_meta_correct_answer', $question ) ? $question['k2k_writing_meta_correct_answer'] : '';
				?>

				<ol class="writing-question-answers">

				<?php
				foreach ( $question['k2k_writing_meta_answers'] as $key => $answer ) {
					?>
						<li class="writing-question-answer-item <?php echo ++$key === $correct ? 'correct' : ''; ?>">
							<?php echo esc_attr( $answer ); ?>
						</li>
					<?php
				}
				?>

				</ol>
				<?php
			}
		}
		?>
	</ol>

	<?php
}