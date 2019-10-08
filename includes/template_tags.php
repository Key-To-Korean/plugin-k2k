<?php
function get_custom_meta( $meta_key ) {

	$meta = get_post_meta( get_the_ID(), $meta_key )[0];

	return $meta;

}

function custom_meta_button( $type, $taxonomy ) {

	$meta       = get_all_the_post_meta( array( $taxonomy ) );
	$classnames = 'button' === $type ? 'btn button' : '';

	if ( array_key_exists( $taxonomy, $meta['post'] ) ) {

		$output  = '<a class="' . $classnames . '" title="' . $meta['post'][ $taxonomy ]['_name'];
		$output .= '" href="' . home_url() . '/' . substr( $taxonomy, 4 ) . '/' . $meta['post'][ $taxonomy ]['_slug'];
		$output .= '">';

		if ( array_key_exists( '_translation', $meta['post'][ $taxonomy ] ) ) {
			$output .= $meta['post'][ $taxonomy ]['_translation'];
		} else {
			$output .= $meta['post'][ $taxonomy ]['_name'];
		}

		$output .= '</a>';

		echo $output;

	}

}

function custom_footer_meta( $title, $array ) {

	$output  = '<ul class="related-terms">';
	$output .= '<li><h4>' . $title . '</h4></li>';

	foreach ( $array as $item ) {
		$post    = get_post( $item );
		$output .= '<li>';
		$output .= '<a class="btn button" rel="tag" href="' . get_the_permalink( $post->ID ) . '">' . $post->post_title . '</a>';
		$output .= '</li>';
	}

	$output .= '</ul>';

	echo $output;

}
