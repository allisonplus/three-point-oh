<?php
/**
 * Custom scripts and styles.
 *
 * @package atarr
 */

/**
 * Register Google font.
 *
 * @link http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 */
function atarr_font_url() {

	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by the following, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$playfair_display = _x( 'on', 'Playfair Display font: on or off', 'atarr' );
	$roboto = _x( 'on', 'Roboto font: on or off', 'atarr' );

	if ( 'off' !== $playfair_display || 'off' !== $roboto ) {
		$font_families = array();

		if ( 'off' !== $playfair_display ) {
			$font_families[] = 'Playfair Display:400,700';
		}

		if ( 'off' !== $roboto ) {
			$font_families[] = 'Roboto:400,700';
		}
		// https://fonts.googleapis.com/css?family=Playfair+Display:400,700|Roboto:400,700.
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function atarr_scripts() {
	/**
	 * If WP is in script debug, or we pass ?script_debug in a URL - set debug to true.
	 */
	$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) || ( isset( $_GET['script_debug'] ) ) ? true : false;

	/**
	 * If we are debugging the site, use a unique version every page load so as to ensure no cache issues.
	 */
	$version = '1.0.0';

	/**
	 * Should we load minified files?
	 */
	$suffix = ( true === $debug ) ? '' : '.min';

	// Register styles.
	wp_register_style( 'atarr-google-font', atarr_font_url(), array(), null );

	// Enqueue styles.
	wp_enqueue_style( 'atarr-google-font' );
	wp_enqueue_style( 'atarr-style', get_stylesheet_directory_uri() . '/style' . $suffix . '.css', array(), $version );

	// Enqueue scripts.
	wp_enqueue_script( 'atarr-scripts', get_template_directory_uri() . '/assets/js/project' . $suffix . '.js', array( 'jquery' ), $version, true );

	// Secret Identity content switcher for front page content.
	if ( is_front_page() ) {
		wp_enqueue_script( 'atarr-super-heroine', get_template_directory_uri() . '/assets/js/super-heroine.js', array( 'jquery' ), $version, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'atarr_scripts' );

/**
 * Enqueue external scripts and styles re: particular content.
 */
function atarr_external_scripts() {
	/**
	 * If WP is in script debug, or we pass ?script_debug in a URL - set debug to true.
	 */
	$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) || ( isset( $_GET['script_debug'] ) ) ? true : false;

	/**
	 * If we are debugging the site, use a unique version every page load so as to ensure no cache issues.
	 */
	$version = '1.0.0';

	/**
	 * Should we load minified files?
	 */
	$suffix = ( true === $debug ) ? '' : '.min';

	// Font Awesome.
	wp_enqueue_script( 'atarr-fa', 'https://use.fontawesome.com/bb54077af8.js' );

	// Testimonial Slider.
	if ( is_front_page() ) {
		wp_enqueue_style( 'atarr-carousel-style', 'https://unpkg.com/flickity@2/dist/flickity.min.css' );
		wp_enqueue_script( 'atarr-carousel-js', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'atarr-mobile-nav', get_template_directory_uri() . '/assets/js/carousel-testimonials.js', array( 'jquery' ), $version, true );
	}

	// Enqueue p5.js.
	if ( ! atarr_is_blog() ) {
		wp_enqueue_script( 'atarr-p5', get_template_directory_uri() . '/assets/js/p5/p5' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'atarr-p5-dom', get_template_directory_uri() . '/assets/js/p5/p5.dom' . $suffix . '.js', array( 'jquery', 'atarr-p5' ), $version, true );
		wp_enqueue_script( 'orbs', get_template_directory_uri() . '/assets/js/p5/orbs.js', array( 'jquery', 'atarr-p5', 'atarr-p5-dom' ), $version, true );
	}
}
add_action( 'wp_enqueue_scripts', 'atarr_external_scripts' );

/**
 * Add SVG definitions to <head>.
 */
function atarr_include_svg_icons() {

	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/images/svg-icons.svg';

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
