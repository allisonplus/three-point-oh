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
