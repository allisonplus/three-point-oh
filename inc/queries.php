<?php
/**
 * Custom queries.
 *
 * @package atarr
 */

/**
 * Testimonials Query.
 *
 * @return WP_Query The recent posts.
 */
function atarr_query_testimonials() {

	return new WP_Query( array(
		'post_type'              => 'testimonials',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	) );
}

/**
 * Portfolio Query.
 *
 * @return WP_Query Portfolio CPT.
 */
function atarr_query_portfolio() {

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	return new WP_Query( array(
		'post_type'      => 'portfolio',
		'posts_per_page' => 6,
		'paged'          => $paged,
	) );
}
