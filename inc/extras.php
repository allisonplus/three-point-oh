<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package atarr
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function atarr_body_classes( $classes ) {

	global $is_IE;

	// If it's IE, add a class.
	if ( $is_IE ) {
		$classes[] = 'ie';
	}

	// Give all pages a unique class.
	if ( is_page() ) {
		$classes[] = 'page-' . basename( get_permalink() );
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds "no-js" class. If JS is enabled, this will be replaced (by javascript) to "js".
	$classes[] = 'no-js';

	return $classes;
}
add_filter( 'body_class', 'atarr_body_classes' );

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function atarr_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'atarr_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'atarr_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so atarr_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so atarr_categorized_blog should return false.
		return false;
	}
}

/**
 * Get an attachment ID from it's URL.
 *
 * @param  string $attachment_url  The URL of the attachment.
 * @return int                      The attachment ID.
 */
function atarr_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;

	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url ) {
		return false;
	}

	// Get the upload directory paths.
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL.
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL.
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}

/**
 * Trim the title lengtth.
 *
 * @param  array $args  Parameters include length and more.
 * @return string        The shortened excerpt.
 */
function atarr_get_the_title( $args = array() ) {

	// Set defaults.
	$defaults = array(
		'length'  => 12,
		'more'    => '...',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the title.
	return wp_trim_words( get_the_title( get_the_ID() ), $args['length'], $args['more'] );
}

/**
 * Limit the excerpt length.
 *
 * @param  array $args  Parameters include length and more.
 * @return string        The shortened excerpt.
 */
function atarr_get_the_excerpt( $args = array() ) {

	// Set defaults.
	$defaults = array(
		'length' => 20,
		'more'   => '...',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the excerpt.
	return wp_trim_words( get_the_excerpt(), absint( $args['length'] ), esc_html( $args['more'] ) );
}

/**
 * Returns a "Continue Reading" link for excerpts
 */
function atarr_continue_reading_link() {

	if ( is_post_type_archive() ) {
		return ' <a class="button" href="' . get_permalink() . '">' . esc_html( 'Learn More', 'starry' ) . '</a>';
	} else {
		return ' <a class="button" href="' . get_permalink() . '">' . esc_html( 'Read More', 'starry' ) . '</a>';
	}
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and atarr_continue_reading_link().
 */
function atarr_auto_excerpt_more() {
	return ' &hellip;' . atarr_continue_reading_link();
}
add_filter( 'excerpt_more', 'atarr_auto_excerpt_more' );

/**
 * Return an image URI, no matter what.
 *
 * @param  string $size  The image size you want to return.
 * @return string         The image URI.
 */
function atarr_get_post_image_uri( $size = 'thumbnail' ) {

	// If featured image is present, use that.
	if ( has_post_thumbnail() ) {

		$featured_image_id = get_post_thumbnail_id( get_the_ID() );
		$media = wp_get_attachment_image_src( $featured_image_id, $size );

		if ( is_array( $media ) ) {
			return current( $media );
		}
	}

	// Check for any attached image.
	$media = get_attached_media( 'image', get_the_ID() );
	$media = current( $media );

	// Set up default image path.
	$media_url = get_stylesheet_directory_uri() . '/assets/images/placeholder.png';

	// If an image is present, then use it.
	if ( is_array( $media ) && 0 < count( $media ) ) {
		$media_url = ( 'thumbnail' === $size ) ? wp_get_attachment_thumb_url( $media->ID ) : wp_get_attachment_url( $media->ID );
	}

	return $media_url;
}

/**
 * Check if it's the blog.
 */
function atarr_is_blog() {
	return ( (( is_archive() ) || ( is_404() ) || ( is_search() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) ) ) ? true : false ;
}

/**
 * Prints HTML with customized meta information single-post.
 *
 * @param  array $args  Link, date + category particulars..
 *
 * @author Allison Tarr
 */
function atarr_card_posted_on( $args = array() ) {

	// Set up category stuff.
	$category = get_the_category();
	$category_name = '';
	$category_link = '';

	// Setup defaults.
	$defaults = array(
		'link'          => get_the_permalink(),
		'date'          => get_the_date( 'F j, Y' ),
		'category'      => $category_name,
		'category_link' => $category_link,
	);

	// If there is an array of categories.
	if ( is_array( $category ) ) {
		$category_name = $category[0]->name;
		$category_link = get_category_link( $category[0]->cat_ID );
	}

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	ob_start();
	?>

	<p class="posted-on"><time class="entry-date"><?php echo esc_attr( $args['date'] ); ?></time></p>
	<p class="meta-content">
		<span class="category"><span class="posted-emphasis"><?php esc_html_e( 'in ', 'starry' ); ?></span><a class="category-link" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category_name ); ?></a></span>
	</p>

	<?php
	return ob_get_clean();
}

/**
 * Filter the archive title
 * Removes "Category:"/"Author", etc. from title.
 *
 * @param string $title Archive title.
 * @return string Filtered title.
 */
function atarr_archive_title( $title ) {

	if ( is_category() ) {
		$title = single_cat_title( '', false );
		$title = $title . esc_html( ' Archives', 'starry' );
	} elseif ( is_post_type_archive( 'portfolio' ) ) {
		$title = esc_html( 'Featured Work', 'starry' );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_date() ) {
		if ( is_year() ) {
			$title = sprintf( __( '%s Archives', 'starry' ), get_the_date( _x( 'Y', 'yearly archives date format', 'starry' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( __( '%s Archives', 'starry' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'starry' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( __( '%s Archives', 'starry' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'starry' ) ) );
		}
	} else {
		$title = __( 'Archives', 'starry' );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'atarr_archive_title' );

/**
 * Trim the title lengtth.
 *
 * @return string        The shortened excerpt.
 */
function atarr_get_styled_pagination() {

	$next_link = get_next_posts_link( __( 'Previous', 'starry' ) );
	$prev_link = get_previous_posts_link( __( 'Next', 'starry' ) );

	// Start markup.
	ob_start();

	if ( $prev_link || $next_link ) : ?>

	<div class="nav-links page-nav">

		<div class="nav-previous">
		<?php if ( $next_link ) : ?>
			<h4 class="pre-title"><?php echo $next_link; // WPCS: XSS OK.  ?> </h4>
		<?php endif; ?>
		</div>

		<div class="nav-next">
		<?php if ( $prev_link ) : ?>
			<h4 class="pre-title"><?php echo $prev_link; // WPCS: XSS OK.  ?></h4>
		<?php endif; ?>
		</div>

	<?php endif; ?>

	</div><!--.nav-links-->

	<?php
	return ob_get_clean();
}

/**
 * Goodreads API shortcode
 *
 * @param string $passed_values Values for Desired book data.
 * @return string Desired list of books from Goodreads API.
 */
function goodreads_api( $passed_values ) {

	// If API value doesn't exist within customizer, forget about it.
	if ( ! get_theme_mod( 'gr_api_key' ) ) {
		return false;
	}

	$key = get_theme_mod( 'gr_api_key' );

	$attributes = shortcode_atts( array(
		'user'         => '80235',
		'shelf'        => 'read',
		'num_of_books' => '4',
		'sort'         => 'date_read',
	), $passed_values );

	$books_path = 'http://www.goodreads.com/review/list/' . $attributes['user'] . '.xml?key=' . $key . '&v=2&shelf=' . $attributes['shelf'] . '&sort=' . $attributes['sort'] . '&order=d&page=1&per_page=' . $attributes['num_of_books'];
	$books_get_xml = wp_remote_fopen( $books_path );
	$books_get_json = new SimpleXMLElement( $books_get_xml );

	$value = '<ul class="bookshelf">';

	foreach ( $books_get_json->reviews->review as $book ) {
		$image_url_check = $book->book->image_url;

		if ( 0 === strpos( $image_url_check, 'http://s.gr-assets.com/assets/nophoto' ) ) {
			$imagecover = '<div class="temp-cover"><h4 class="title">' . $book->book->title . '</h4></div>';
		} else {
			$imagecover = '<img class="cover" src="' . $book->book->image_url . '"/ alt="' . $book->book->title . '">';
		}

		$value .= '<li class="bookshelf-book ';

		foreach ( $book->shelves->children() as $bookshelf ) {
			$value .= 'category-' . $bookshelf['name'] . ' ';
		}
			$value .= '"><a href="' . $book->book->link . '">' . $imagecover . '</a></li>';
	}
		$value .= '</ul>';

	return $value;

}
add_shortcode( 'gr-books', 'goodreads_api' );


/**
 * Caldera Forms - move field description (caption) above input, below label.
 *
 * @param string $field_structure.
 * @param string $form.
 * @return string new $field_structure.
 */
add_filter( 'caldera_forms_render_field_structure', function( $field_structure, $form ) {

	// Place description after label.
	$field_structure['label_after'] .= $field_structure['field_caption'];

	// Empty description so it doesn't show twice.
	$field_structure['field_caption'] = '';
	return $field_structure;
}, 10, 2 );
