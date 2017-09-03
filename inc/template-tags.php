<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package atarr
 */

if ( ! function_exists( 'atarr_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function atarr_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'atarr' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'atarr' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'atarr_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function atarr_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'atarr' ) );
			if ( $categories_list && atarr_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'atarr' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'atarr' ) );
			if ( $tags_list ) {
							printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'atarr' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'atarr' ), esc_html__( '1 Comment', 'atarr' ), esc_html__( '% Comments', 'atarr' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'atarr' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Flush out the transients used in atarr_categorized_blog.
 */
function atarr_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return false;
	}
	// Like, beat it. Dig?
	delete_transient( 'atarr_categories' );
}
add_action( 'delete_category', 'atarr_category_transient_flusher' );
add_action( 'save_post',     'atarr_category_transient_flusher' );

/**
 * Return SVG markup.
 *
 * @param  array $args {
 *     Parameters needed to display an SVG.
 *
 *     string $icon Required. Use the icon filename, e.g. "facebook-square".
 *     string $title Optional. SVG title, e.g. "Fac
 *     string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }.
 * @return string SVG markup.
 */
function atarr_get_svg( $args = array() ) {

	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'atarr' );
	}

	// YUNO define an icon?
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'atarr' );
	}

	// Set defaults.
	$defaults = array(
		'icon'  => '',
		'title' => '',
		'desc'  => '',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Figure out which title to use.
	$title = ( $args['title'] ) ? $args['title'] : $args['icon'];

	// Begin SVG markup.
	$svg = '<svg class="icon icon-' . esc_html( $args['icon'] ) . '" aria-hidden="true">';

	// Add title markup.
	$svg .= '<title>' . esc_html( $title ) . '</title>';

	// If there is a description, display it.
	if ( $args['desc'] ) {
		$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
	}

	$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	$svg .= '</svg>';

	return $svg;
}

/**
 * Display an SVG.
 *
 * @param array $args  Parameters needed to display an SVG.
 */
function atarr_do_svg( $args = array() ) {
	echo atarr_get_svg( $args ); // WPCS: XSS ok.
}

/**
 * Echo an image, no matter what.
 *
 * @param string $size  The image size you want to display.
 */
function atarr_do_post_image( $size = 'thumbnail' ) {

	// If featured image is present, use that.
	if ( has_post_thumbnail() ) {
		return the_post_thumbnail( $size );
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

	echo '<img src="' . esc_url( $media_url ) . '" class="attachment-thumbnail wp-post-image" alt="' . esc_html( get_the_title() ) . '" />';
}

/**
 * Echo the copyright text saved in the Customizer.
 */
function atarr_do_copyright_text() {

	// Grab our customizer settings.
	$copyright_text = get_theme_mod( 'atarr_copyright_text' );

	// Stop if there's nothing to display.
	if ( ! $copyright_text ) {
		return false;
	}
		// Echo the text.
	echo '<span class="copyright-text">&#169;' . date( 'Y' ) . '<span class="heart"> &#9825; </span>' . wp_kses_post( $copyright_text ) . '</span>'; // WPCS: XSS OK.

}

/**
 * Echo p5 orbs.
 */
function atarr_get_p5() {
	// Build the URLs.
	$orbs_url = get_stylesheet_directory_uri() . '/assets/js/concat/orbs.js';

	// Start markup.
	ob_start(); ?>

	<script src="<?php echo esc_url( $orbs_url ); ?>"></script>

	<div id="heroine">
		<div class="heroine-wrapper">
			<p class="fed"><?php esc_html_e( 'Front-end Developer &', 'atarr' ); ?>

			<div class="row">
				<span class="text-shifting"><?php esc_html_e( 'Creative', 'atarr' ); ?></span>
				<span class="text-shifting"><?php esc_html_e( 'Daydreamer', 'atarr' ); ?></span></p>
			</div><!--.row-->
		</div><!-- .heroine-wrapper -->
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Social links for the footer.
 */
function atarr_get_footer_social_links() {

	// Set an array of social networks.
	$social_networks = array( 'Codepen', 'Github', 'Twitter', 'Linkedin' );
	$email = get_theme_mod( 'atarr_email_link' );

	ob_start(); ?>

	<ul class="social-networks">

	<?php // If there's no email, don't make this <li> in the first place .?>
	<?php if ( ! empty( $email ) ) : ?>
		<li class="social-network email">
			<a href="mailto:<?php echo esc_html( $email ); ?>"></a>
			<span class="screen-reader-text"><?php esc_html_e( 'Email me', 'atarr' ); ?></span>
		</li>
	<?php endif; ?>

	<?php // Continue <li>'s with rest of social networks provided. ?>
	<?php foreach ( $social_networks as $network ) : ?>
		<li class="social-network <?php echo esc_attr( $network ); ?>">
			<a href="<?php echo esc_url( get_theme_mod( 'atarr_' . $network . '_link' ) ); ?>"></a>
			<span class="screen-reader-text"><?php esc_html_e( 'Visit my ', 'atarr' ); ?><?php echo esc_attr( $network ); ?></span>
		</li>
	<?php endforeach; ?>
	</ul><!-- .social-networks -->
	<?php
	return ob_get_clean();
}
