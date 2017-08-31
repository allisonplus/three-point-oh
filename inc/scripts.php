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
	$garamond = _x( 'on', 'EB Garamond font: on or off', 'atarr' );
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'atarr' );

	if ( 'off' !== $garamond || 'off' !== $libre_franklin ) {
		$font_families = array();

		if ( 'off' !== $garamond ) {
			$font_families[] = 'EB Garamond';
		}

		if ( 'off' !== $libre_franklin ) {
			$font_families[] = 'Libre Franklin:400,700';
		}
		// https://fonts.googleapis.com/css?family=EB+Garamond|Libre+Franklin:400,700.
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

	// Font Awesome.
	wp_enqueue_script( 'atarr-fa', 'https://use.fontawesome.com/bb54077af8.js' );

	// Enqueue p5.js.
	wp_enqueue_script( 'atarr-p5', get_template_directory_uri() . '/assets/js/p5' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_enqueue_script( 'atarr-p5-dom', get_template_directory_uri() . '/assets/js/p5.dom' . $suffix . '.js', array( 'jquery' ), $version, true );
	wp_enqueue_script( 'orbs', get_template_directory_uri() . '/assets/js/concat/orbs.js', array( 'jquery', 'atarr-p5' ), $version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue the mobile nav script.
	wp_enqueue_script( 'atarr-mobile-nav', get_template_directory_uri() . '/assets/js/mobile-nav-menu.js', array( 'jquery' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'atarr_scripts' );

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
